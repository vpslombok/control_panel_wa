<?php
include 'db.php';

// Ambil data dari database termasuk id
$query = "SELECT id, ip, latitude, longitude, location FROM user_access";
$result = $conn->query($query);

// hapus data yang dipilih
if (isset($_POST['hapus'])) {
    $id = $_POST['checked'];
    foreach ($id as $id) {
        $query = "DELETE FROM user_access WHERE id = '$id'";
        $conn->query($query);
    }
}

// hapus 
?>

<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<div class="content">
    <div class="form-akses">
        <h2>Data Akses Pengguna</h2>
        <div class="table-responsive">
            <form action="web_akses.php" method="post">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>No</th>
                            <th>IP</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($akses = mysqli_fetch_array($result)) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' name='checked[]' value='" . $akses['id'] . "'></td>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . $akses['ip'] . "</td>";
                                echo "<td>" . $akses['latitude'] . "</td>";
                                echo "<td>" . $akses['longitude'] . "</td>";
                                echo "<td>" . $akses['location'] . "</td>";
                                echo "<td><a href='web_akses.php?id=" . $akses['id'] . "' class='btn btn-danger'>Hapus</a></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data akses pengguna.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <button type="submit" name="hapus" class="btn btn-primary">Hapus yang Dipilih</button>
            </form>
        </div>
    </div>
</div>

</body>
<script>
    $(document).ready(function() {
        $('#selectAll').click(function() {
            $('input[name="checked[]"]').prop('checked', this.checked);
        });
    });


    document.getElementById("hamburger").addEventListener("click", () => {
        const sidebar = document.getElementById("sidebar");
        const hamburger = document.getElementById("hamburger");

        sidebar.classList.toggle("active");

        // Periksa apakah sidebar sedang aktif
        if (sidebar.classList.contains("active")) {
            hamburger.style.display = "none"; // Sembunyikan hamburger
        } else {
            hamburger.style.display = "block"; // Tampilkan hamburger
        }
    });

    // Event listener untuk klik di luar sidebar
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
</script>

</html>