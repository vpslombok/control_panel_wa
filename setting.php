<?php
session_start();
include 'db.php';

// Ambil URL API dari database
$query = "SELECT web_url, url, url_api FROM webhook_urls ORDER BY updated_at DESC LIMIT 1";
$result = $conn->query($query);

$apiUrl = $url = $url_api = "";
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $apiUrl = $row['web_url'];
  $url = $row['url'];
  $url_api = $row['url_api'];
}

// Proses input form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $responseMessage = '';  // Inisialisasi variabel untuk menyimpan pesan respons
  $alertType = '';  // Variabel untuk menentukan jenis alert (success atau error)

  if (isset($_POST['web-url-input'])) {
    $webUrl = $_POST['web-url-input'];
    if (empty($webUrl)) {
      $responseMessage = 'URL harus diisi.';
      $alertType = 'error';
    } else {
      $query = "UPDATE webhook_urls SET web_url='$webUrl', updated_at=NOW() LIMIT 1";
      if ($conn->query($query) === TRUE) {
        $responseMessage = 'URL web berhasil diperbarui.';
        $alertType = 'success';
      } else {
        $responseMessage = 'Gagal memperbarui URL web: ' . $conn->error;
        $alertType = 'error';
      }
    }
  }

  if (isset($_POST['api-url-input'])) {
    $url_api = $_POST['api-url-input'];
    if (empty($url_api)) {
      $responseMessage = 'URL harus diisi.';
      $alertType = 'error';
    } else {
      $query = "UPDATE webhook_urls SET url_api='$url_api', updated_at=NOW() LIMIT 1";
      if ($conn->query($query) === TRUE) {
        $responseMessage = 'URL API berhasil diperbarui.';
        $alertType = 'success';
      } else {
        $responseMessage = 'Gagal memperbarui URL API: ' . $conn->error;
        $alertType = 'error';
      }
    }
  }

  if (isset($_POST['webhook-url-input'])) {
    $url = $_POST['webhook-url-input'];
    if (empty($url)) {
      $responseMessage = 'URL harus diisi.';
      $alertType = 'error';
    } else {
      $query = "UPDATE webhook_urls SET url='$url', updated_at=NOW() LIMIT 1";
      if ($conn->query($query) === TRUE) {
        $responseMessage = 'URL webhook berhasil diperbarui.';
        $alertType = 'success';
      } else {
        $responseMessage = 'Gagal memperbarui URL webhook: ' . $conn->error;
        $alertType = 'error';
      }
    }
  }

  // Mengembalikan pesan untuk ditampilkan pada form menggunakan SweetAlert
  echo "<script>
          Swal.fire({
              title: '" . ($alertType === 'success' ? 'Berhasil' : 'Gagal') . "',
              text: '$responseMessage',
              icon: '$alertType',
              confirmButtonText: 'OK',
              customClass: {
                  confirmButton: 'btn btn-danger'
              }
          });
        </script>";
  exit;
}
?>

<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<div class="form-index">
  <div class="form webhook">
    <h1>Update Webhook URL</h1>
    <form hx-post="setting.php" hx-target="#webhook-message" hx-swap="innerHTML">
      <input
        type="url"
        id="webhook-url-input"
        name="webhook-url-input"
        placeholder="Enter new webhook URL"
        value="<?php echo $url; ?>"
        class="form-control" style="margin-top: 10px;" />
      <button type="submit" class="btn btn-danger" style="margin-top: 10px;">Perbarui</button>
    </form>
    <div id="webhook-message"></div> <!-- Tempat untuk menampilkan pesan -->
  </div>
</div>

<div class="form-index">
  <div class="form webhook">
    <h1>Link Server Nodejs</h1>
    <form hx-post="setting.php" hx-target="#web-url-message" hx-swap="innerHTML">
      <input
        type="url"
        name="web-url-input"
        id="web-url-input"
        placeholder="Masukkan URL web baru"
        value="<?php echo $apiUrl; ?>"
        class="form-control" style="margin-top: 10px;" />
      <button type="submit" class="btn btn-danger" style="margin-top: 10px;">Perbarui</button>
    </form>
    <div id="web-url-message"></div> <!-- Tempat untuk menampilkan pesan -->
  </div>
</div>

<div class="form-index">
  <div class="form webhook">
    <h1>Link URL API</h1>
    <form hx-post="setting.php" hx-target="#api-url-message" hx-swap="innerHTML">
      <input
        type="url"
        name="api-url-input"
        id="api-url-input"
        placeholder="Masukkan api URL baru"
        value="<?php echo $url_api ?>"
        class="form-control" style="margin-top: 10px;" />
      <button type="submit" class="btn btn-danger" style="margin-top: 10px;">Perbarui</button>
    </form>
    <div id="api-url-message"></div> <!-- Tempat untuk menampilkan pesan -->
  </div>
</div>

<script>
  const apiUrl = "<?php echo $apiUrl; ?>"; // Gunakan URL API yang diambil dari database

  document.getElementById("hamburger").addEventListener("click", () => {
    const sidebar = document.getElementById("sidebar");
    const hamburger = document.getElementById("hamburger");

    sidebar.classList.toggle("active");

    if (sidebar.classList.contains("active")) {
      hamburger.style.display = "none";
    } else {
      hamburger.style.display = "block";
    }
  });

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
</script>

</body>

</html>