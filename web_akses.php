<?php
include 'db.php';

if (isset($_GET['action']) && $_GET['action'] == 'fetch') {
    $query = "SELECT * FROM user_access ORDER BY id DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($riwayat = mysqli_fetch_array($result)) {
            echo "<tr id='row-" . $riwayat['id'] . "'>";
            echo "<td><input type='checkbox' name='checked[]' value='" . $riwayat['id'] . "'></td>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $riwayat['ip'] . "</td>";
            echo "<td>" . $riwayat['latitude'] . "</td>";
            echo "<td>" . $riwayat['longitude'] . "</td>";
            echo "<td>" . $riwayat['location'] . "</td>";
            echo "<td>" . $riwayat['update_at'] . "</td>";
            echo "<td><button hx-delete='web_akses.php?action=delete&id=" . $riwayat['id'] . "' hx-target='#row-" . $riwayat['id'] . "' hx-swap='outerHTML' class='btn btn-danger'>Hapus</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Tidak ada data riwayat akses.</td></tr>";
    }
    return;
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $query = "DELETE FROM user_access WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        echo "";  // Respon kosong untuk menghapus elemen dari DOM
    } else {
        echo "Gagal menghapus data";
    }
    return;
}

// hapus data secara cepat menggunakan checkbox
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus'])) {
    foreach ($_POST['checked'] as $id) {
        $query = "DELETE FROM user_access WHERE id = " . intval($id);
        mysqli_query($conn, $query);
    }
    echo ""; // Pengosongan response untuk mencegah kesalahan pada HTMX.
    return;
}
?>

<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<div class="content">
    <div class="form-riwayat">
        <h2 style="font-weight: bold;">Laporan Akses Pengguna</h2>
        <div class="table-responsive">
            <!-- Wrapper Flex -->
            <div class="d-flex flex-column">
                <!-- Baris Tombol Hapus -->
                <form method="post">
                    <button type="submit" name="hapus" class="btn btn-danger d-flex justify-content-end m-3" hx-post="web_akses.php" hx-target="#data-table" hx-swap="outerHTML">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>No</th>
                                <th>ip</th>
                                <th>latitude</th>
                                <th>longitude</th>
                                <th>lokasi</th>
                                <th>Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data-table" hx-get="web_akses.php?action=fetch" hx-trigger="load, every 10s">
                            <!-- Data akan dimuat di sini -->
                        </tbody>
                    </table>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // Tambahkan fungsi untuk mengaktifkan dan menonaktifkan sidebar
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const hamburger = document.getElementById("hamburger");

        sidebar.classList.toggle("active");

        // Periksa apakah sidebar sedang aktif
        if (sidebar.classList.contains("active")) {
            hamburger.style.display = "none"; // Sembunyikan hamburger
        } else {
            hamburger.style.display = "block"; // Tampilkan hamburger
        }
    }

    // Tambahkan event listener untuk hamburger
    document.getElementById("hamburger").addEventListener("click", toggleSidebar);

    // Tambahkan event listener untuk klik di luar sidebar
    document.addEventListener("click", (event) => {
        const sidebar = document.getElementById("sidebar");
        const hamburger = document.getElementById("hamburger");

        // Periksa apakah sidebar sedang aktif
        if (sidebar.classList.contains("active")) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickHamburger = hamburger.contains(event.target);

            // Jika klik di luar sidebar dan bukan di hamburger, tutup sidebar
            if (!isClickInsideSidebar && !isClickHamburger) {
                sidebar.classList.remove("active");
                hamburger.style.display = "block"; // Tampilkan kembali hamburger
            }
        }
    });

    // Tambahkan event listener untuk select all checkbox
    document.getElementById("selectAll").addEventListener("click", function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        if (this.checked) {
            checkboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
        } else {
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        }
    });
</script>

</html>