<?php
// Pastikan base URL disesuaikan dengan struktur proyek
define("BASE_URL", "/"); // Sesuaikan jika ada subfolder, misal: "/control_panel_wa/"

// Ambil nama halaman saat ini tanpa folder
$current_page = basename($_SERVER['SCRIPT_NAME']);
?>

<div class="sidebar" id="sidebar">
        <h2>LOMBOK SERVER</h2>
        <ul>
                <li><a href="<?= BASE_URL; ?>index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
                                <i class="fas fa-home"></i> Beranda</a></li>
                <li><a href="<?= BASE_URL; ?>page/kirim_pesan.php" class="<?= $current_page == 'kirim_pesan.php' ? 'active' : '' ?>">
                                <i class="fas fa-envelope"></i> Kirim Pesan</a></li>
                <li><a href="<?= BASE_URL; ?>page/riwayat.php" class="<?= $current_page == 'riwayat.php' ? 'active' : '' ?>">
                                <i class="fas fa-history"></i> Riwayat Kirim</a></li>
                <li><a href="<?= BASE_URL; ?>page/reply.php" class="<?= $current_page == 'reply.php' ? 'active' : '' ?>">
                                <i class="fas fa-reply"></i> Pesan Auto Reply</a></li>
                <li><a href="<?= BASE_URL; ?>page/setting.php" class="<?= $current_page == 'setting.php' ? 'active' : '' ?>">
                                <i class="fas fa-cog"></i> Pengaturan Server</a></li>
                <li><a href="<?= BASE_URL; ?>page/web_akses.php" class="<?= $current_page == 'web_akses.php' ? 'active' : '' ?>">
                                <i class="fas fa-users"></i> Akses Web</a></li>
                <li><a href="<?= BASE_URL; ?>page/folder.php" class="<?= $current_page == 'folder.php' ? 'active' : '' ?>">
                                <i class="fas fa-folder"></i> Folder</a></li>
        </ul>

        <p style="font-size: 14px; color: #fff; margin-top: 20px;">Version 13.03.25 <i class="fas fa-info-circle"></i></p>
        <a href="<?= BASE_URL; ?>logout.php" id="logout-session" class="btn btn-danger w-100">Keluar</a>
</div>