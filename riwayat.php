<?php
include 'db.php';

if (isset($_GET['action']) && $_GET['action'] == 'fetch') {
    $query = "SELECT * FROM sent_messages ORDER BY id DESC";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $no = 1;
        while ($riwayat = mysqli_fetch_array($result)) {
            echo "<tr id='row-" . $riwayat['id'] . "'>";
            echo "<td><input type='checkbox' name='checked[]' value='" . $riwayat['id'] . "'></td>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . $riwayat['number'] . "</td>";
            echo "<td>" . $riwayat['message_in'] . "</td>";
            echo "<td>" . $riwayat['message'] . "</td>";
            echo "<td>" . $riwayat['tanggal'] . "</td>";
            echo "<td><button hx-get='riwayat.php?action=delete&id=" . $riwayat['id'] . "' hx-target='#row-" . $riwayat['id'] . "' hx-swap='outerHTML' class='btn btn-danger'>Hapus</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Tidak ada data riwayat pesan.</td></tr>";
    }
    exit;
}

if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = intval($_GET['id']);
    $query = "DELETE FROM sent_messages WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: riwayat.php?action=fetch');
        exit;
    } else {
        echo "Gagal menghapus data";
    }
}

// hapus data secara cepat menggunakan checkbox
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hapus'])) {
    foreach ($_POST['checked'] as $id) {
        $query = "DELETE FROM sent_messages WHERE id = " . intval($id);
        mysqli_query($conn, $query);
    }
    header('Location: riwayat.php?action=fetch');
    exit;
}
?>

<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<div class="content">
    <div class="form-riwayat">
        <h2>Riwayat Pesan Terkirim</h2>
        <div class="table-responsive">
            <div class="d-flex flex-column">
                <form method="post">
                    <button type="submit" name="hapus" id="deleteButton" class="btn btn-danger d-flex justify-content-end m-3" hx-post="riwayat.php" hx-target="#data-table" hx-swap="outerHTML" disabled>
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>No</th>
                                <th>Nomor Telpon</th>
                                <th>Pesan Masuk</th>
                                <th>Pesan Terkirim</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="data-table" hx-get="riwayat.php?action=fetch" hx-trigger="load, every 5s">
                            <!-- Data akan dimuat di sini -->
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const hamburger = document.getElementById("hamburger");

        sidebar.classList.toggle("active");

        if (sidebar.classList.contains("active")) {
            hamburger.style.display = "none";
        } else {
            hamburger.style.display = "block";
        }
    }

    document.getElementById("hamburger").addEventListener("click", toggleSidebar);

    document.addEventListener("click", (event) => {
        const sidebar = document.getElementById("sidebar");
        const hamburger = document.getElementById("hamburger");

        if (sidebar.classList.contains("active")) {
            const isClickInsideSidebar = sidebar.contains(event.target);
            const isClickHamburger = hamburger.contains(event.target);

            if (!isClickInsideSidebar && !isClickHamburger) {
                sidebar.classList.remove("active");
                hamburger.style.display = "block";
            }
        }
    });

    function updateDeleteButtonState() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#selectAll)');
        const deleteButton = document.getElementById("deleteButton");
        const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

        deleteButton.disabled = !anyChecked;
    }

    document.getElementById("selectAll").addEventListener("click", function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:not(#selectAll)');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButtonState();
    });

    function attachCheckboxListeners() {
        document.querySelectorAll('input[type="checkbox"]:not(#selectAll)').forEach(checkbox => {
            checkbox.addEventListener("change", updateDeleteButtonState);
        });
    }

    // Attach listeners when data is loaded or updated
    document.getElementById("data-table").addEventListener("htmx:afterSettle", function() {
        attachCheckboxListeners();
        updateDeleteButtonState();
    });

    // Initialize listeners on page load
    attachCheckboxListeners();
</script>

</html>