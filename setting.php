<?php
session_start();
include 'db.php';

// Ambil URL API dari database
$query = "SELECT web_url FROM webhook_urls ORDER BY updated_at DESC LIMIT 1";
$result = $conn->query($query);

$apiUrl = "";
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $apiUrl = $row['web_url'];
}

// Ambil URL API dari database
$query = "SELECT url FROM webhook_urls ORDER BY updated_at DESC LIMIT 1";
$result = $conn->query($query);

$url = "";
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $url = $row['url'];
}

// Ambil URL API dari database
$query = "SELECT url_api FROM webhook_urls ORDER BY updated_at DESC LIMIT 1";
$result = $conn->query($query);

$url_api = "";
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $url_api = $row['url_api'];
}


if (isset($_POST['web-url-input']) && !isset($_POST['reload'])) {
  $webUrl = $_POST['web-url-input'];
  if (empty($webUrl)) {
    $_SESSION['message'] = 'URL harus diisi.';
  } else {
    $query = "UPDATE webhook_urls SET web_url='$webUrl', updated_at=NOW() ORDER BY updated_at DESC LIMIT 1";
    if ($conn->query($query) === TRUE) {
      // Mengatur session flash message untuk memberi tahu pengguna bahwa operasi berhasil
      $_SESSION['message'] = 'URL web berhasil diperbarui.';
    } else {
      // Mengatur session flash message untuk memberi tahu pengguna bahwa operasi gagal
      $_SESSION['message'] = 'Gagal memperbarui URL web: ' . $conn->error;
    }
  }

  // Redirect untuk mencegah resubmission data saat reload halaman
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}

// Menampilkan pesan setelah redirect
if (isset($_SESSION['message'])) {
  echo "<script>alert('" . $_SESSION['message'] . "');</script>";
  unset($_SESSION['message']);
}


if (isset($_POST['api-url-input']) && !isset($_POST['reload'])) {
  $url_api = $_POST['api-url-input'];
  if (empty($url_api)) {
    $_SESSION['message'] = 'URL harus diisi.';
  } else {
    $query = "UPDATE webhook_urls SET url_api='$url_api', updated_at=NOW() ORDER BY updated_at DESC LIMIT 1";
    if ($conn->query($query) === TRUE) {
      // Mengatur session flash message untuk memberi tahu pengguna bahwa operasi berhasil
      $_SESSION['message'] = 'URL berhasil diperbarui.';
    } else {
      // Mengatur session flash message untuk memberi tahu pengguna bahwa operasi gagal
      $_SESSION['message'] = 'Gagal memperbarui URL web: ' . $conn->error;
    }
  }

  // Redirect untuk mencegah resubmission data saat reload halaman
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}

// Menampilkan pesan setelah redirect
if (isset($_SESSION['message'])) {
  echo "<script>alert('" . $_SESSION['message'] . "');</script>";
  unset($_SESSION['message']);
}

?>


<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<div class="content">
  <div class="form webhook">
    <h1>Update Webhook URL</h1>
    <input
      type="url"
      id="webhook-url-input"
      placeholder="Enter new webhook URL"
      value="<?php echo $url; ?>"
      class="form-control" style="margin-top: 10px;" />
    <button id="update-webhook-url-btn" class="btn btn-primary" style="margin-top: 10px;">
      Update URL
    </button>
  </div>
</div>

<div class="content">
  <div class="form web">
    <h1>Link Server Nodejs</h1>
    <form method="POST" action="setting.php">
      <input
        type="url"
        name="web-url-input"
        id="web-url-input"
        placeholder="Masukkan URL web baru"
        value="<?php echo $apiUrl; ?>"
        class="form-control" style="margin-top: 10px;" />
      <button type="submit" id="update-web-url-btn" class="btn btn-danger" style="margin-top: 10px;">Perbarui</button>
    </form>
  </div>
</div>

<div class="content">
  <div class="form web">
    <h1>Link URL API</h1>
    <form method="POST" action="setting.php">
      <input
        type="url"
        name="api-url-input"
        id="api-url-input"
        placeholder="Masukkan api URL baru"
        value="<?php echo $url_api ?>"
        class="form-control" style="margin-top: 10px;" />
      <button type="submit" id="update-api-url-btn" class="btn btn-danger" style="margin-top: 10px;">Perbarui</button>
    </form>
  </div>
</div>


<script>
  const apiUrl = "<?php echo $apiUrl; ?>"; // Gunakan URL API yang diambil dari database

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
</body>

</html>