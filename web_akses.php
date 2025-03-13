<?php
session_start();
include 'db.php';

// Cek apakah sudah login
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit;
}

// Jika logout, hapus session
if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit;
}

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
            echo "<td>" . $riwayat['location'] . "</td>";
            echo "<td>" . $riwayat['update_at'] . "</td>";
            echo "<td><button hx-get='web_akses.php?action=delete&id=" . $riwayat['id'] . "' hx-target='#row-" . $riwayat['id'] . "' hx-swap='outerHTML' class='btn btn-danger'>Hapus</button></td>";
            echo "<td><button type='button' class='btn btn-info' onclick='viewLocation(" . $riwayat['latitude'] . ", " . $riwayat['longitude'] . ", \"" . $riwayat['ip'] . "\")'>View</button></td>";
            echo "</tr>";
        }
    } else {
        echo "<td colspan='8'>Tidak ada data riwayat akses.</td>";
    }
    return;
}

// hapus data manual
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

<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.8);
        /* Background gelap untuk efek dramatis */
        animation: fadeIn 0.5s ease-out;
    }

    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border-radius: 10px;
        max-width: 60%;
        /* Modal ukuran default 60% */
        width: 90%;
        /* Ukuran lebar untuk ponsel kecil */
        position: relative;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
        transform: translateY(-50px);
        animation: slideDown 0.4s ease-out forwards;
        opacity: 0;
    }

    .modal-content h2 {
        margin-top: 0;
        color: #333;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
        transition: color 0.2s ease-in-out;
    }

    .close:hover,
    .close:focus {
        color: #ff5f5f;
        cursor: pointer;
    }

    button {
        background-color: #17a2b8;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #138496;
    }

    /* Animasi */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideDown {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Responsivitas */
    @media screen and (max-width: 768px) {
        .modal-content {
            max-width: 80%;
            /* Ukuran modal untuk tablet */
            width: 95%;
            /* Ukuran lebar untuk perangkat tablet */
        }
    }

    @media screen and (max-width: 480px) {
        .modal-content {
            max-width: 90%;
            /* Ukuran modal untuk ponsel */
            width: 100%;
            /* Lebar modal sesuai dengan layar kecil */
        }
    }
</style>

<div class="content">
    <div class="form-riwayat">
        <h2 style="font-weight: bold;">Laporan Akses Pengguna</h2>
        <div class="table-responsive">
            <div class="d-flex flex-column">
                <form method="post">
                    <button type="submit" name="hapus" class="btn btn-danger d-flex justify-content-end m-3"
                        hx-post="web_akses.php"
                        hx-target="#data-table"
                        hx-swap="outerHTML"
                        disabled
                        id="deleteButton">
                        <i class="fa fa-trash"></i> Hps
                    </button>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAll"></th>
                                <th>No</th>
                                <th>IP</th>
                                <th>Lokasi</th>
                                <th>Update</th>
                                <th>Aksi</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody id="data-table" hx-get="web_akses.php?action=fetch" hx-trigger="every 5s, load">
                            <!-- Data akan dimuat di sini -->
                        </tbody>
                    </table>
                </form>
            </div>
            <div id="mapModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Lokasi Pengguna</h2>
                    <div id="map" style="width: 100%; height: 400px;"></div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    let map; // Variabel map dideklarasikan di luar agar bisa diakses di seluruh fungsi

    function viewLocation(latitude, longitude, ip) {
        // Tampilkan modal
        const modal = document.getElementById("mapModal");
        modal.style.display = "block";

        // Hapus peta yang sudah ada (jika ada) sebelum membuat yang baru
        if (map != undefined) {
            map.remove();
        }

        // Reset kontainer map
        document.getElementById('map').innerHTML = "";

        // Inisialisasi peta baru
        map = L.map('map').setView([latitude, longitude], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Tambahkan marker pada peta dan tampilkan IP di popup
        L.marker([latitude, longitude]).addTo(map)
            .bindPopup(`IP: ${ip}`)
            .openPopup();
    }

    // Tutup modal dengan efek animasi
    document.querySelector(".close").onclick = function() {
        const modal = document.getElementById("mapModal");
        modal.style.animation = "fadeOut 0.5s ease-out forwards"; // Animasi fadeOut
        setTimeout(function() {
            modal.style.display = "none";
            modal.style.animation = ""; // Reset animasi untuk dibuka kembali
        }, 500); // Waktu sama dengan durasi animasi
    };

    // Tutup modal ketika diklik di luar konten modal
    window.onclick = function(event) {
        const modal = document.getElementById("mapModal");
        if (event.target == modal) {
            modal.style.animation = "fadeOut 0.5s ease-out forwards"; // Animasi fadeOut
            setTimeout(function() {
                modal.style.display = "none";
                modal.style.animation = ""; // Reset animasi untuk dibuka kembali
            }, 500); // Waktu sama dengan durasi animasi
        }
    }


    // Fungsi toggle sidebar
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

    // Fungsi untuk mengaktifkan/nonaktifkan tombol delete
    function toggleDeleteButton() {
        const checkboxes = document.querySelectorAll('input[name="checked[]"]');
        const deleteButton = document.getElementById('deleteButton');

        let anyChecked = false;
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                anyChecked = true;
            }
        });

        deleteButton.disabled = !anyChecked; // Aktifkan jika ada checkbox tercentang
    }

    // Tambahkan event listener untuk mengaktifkan tombol saat checkbox dipilih/dicentang
    document.querySelectorAll('input[name="checked[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', toggleDeleteButton);
    });

    // Tambahkan event listener untuk select all checkbox
    document.getElementById("selectAll").addEventListener("click", function() {
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        const isChecked = this.checked;

        checkboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
        });

        toggleDeleteButton(); // Cek ulang tombol delete setelah semua checkbox dipilih
    });

    // Memastikan event listener diaktifkan setelah data baru dimuat via HTMX
    document.body.addEventListener('htmx:afterSwap', (event) => {
        if (event.target.id === 'data-table') {
            // Tambahkan event listener ke checkbox baru yang dimuat
            document.querySelectorAll('input[name="checked[]"]').forEach(checkbox => {
                checkbox.addEventListener('change', toggleDeleteButton);
            });
        }
    });
</script>

</html>