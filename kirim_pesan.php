<?php
include 'db.php';

// ambil data web_url terbaru berdasarkan updated_at dari table webhook_urls dan di web_url tidak null
$query = "SELECT web_url FROM webhook_urls ORDER BY updated_at DESC LIMIT 1";
$result = $conn->query($query);

$apiUrl = "";
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $apiUrl = $row['web_url'];
}
?>

<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>
<style>
  /* Chrome, Safari, Edge, Opera */
  #nomor-input::-webkit-outer-spin-button,
  #nomor-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

  /* Firefox */
  #nomor-input[type=number] {
    -moz-appearance: textfield;
  }

  .input-icon {
    position: relative;
    margin-top: 15px;
  }

  .input-icon i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-10%);
    color: #000;
  }

  .input-icon input {
    padding-left: 30px; /* Adjust padding to make space for the icon */
  }
</style>

<div class="content">
  <div class="form">
    <h1>Kirim Pesan</h1>
    
    <!-- Input dengan ikon pesan -->
    <div class="input-icon">
      <i class="fas fa-envelope"></i>
      <input
        type="text"
        id="pesan-input"
        placeholder="Masukkan pesan"
        class="form-control" style="margin-top: 15px;" />
    </div>
    
    <!-- Input dengan ikon telepon -->
    <div class="input-icon">
      <i class="fab fa-whatsapp"></i>
      <input
        type="number"
        id="nomor-input"
        placeholder="Masukkan nomor tujuan"
        class="form-control" style="margin-top: 15px;" />
    </div>
    
    <!-- Input file -->
    <div class="input-icon">
      <input
        type="file"
        id="file-input"
        class="form-control" style="margin-top: 15px;" />
    </div>
    
    <button id="kirim-pesan-btn" class="btn btn-danger" style="margin-top: 15px;" disabled>
      Kirim Pesan
    </button>
  </div>
</div>


<script>
  const pesanInput = document.getElementById("pesan-input");
  const nomorInput = document.getElementById("nomor-input");
  const fileInput = document.getElementById("file-input");
  const kirimPesanBtn = document.getElementById("kirim-pesan-btn");

  const apiUrl = "<?php echo $apiUrl; ?>"; // Gunakan URL API yang diambil dari database

  nomorInput.addEventListener("input", function() {
    if (nomorInput.value) {
      kirimPesanBtn.disabled = false;
    } else {
      kirimPesanBtn.disabled = true;
    }
  });

  async function kirimPesan() {
    const pesan = pesanInput.value;
    const nomor = nomorInput.value;
    const file = fileInput.files[0];
    if (!pesan || !nomor) {
      Swal.fire({
        title: "Kirim Pesan",
        text: "Mohon isi pesan dan nomor tujuan.",
        icon: "error",
      });
      return;
    }
    try {
      const formData = new FormData();
      formData.append("message", pesan);
      formData.append("number", nomor);
      formData.append("file_dikirim", file); // Sesuaikan dengan contoh pada file_context_0
      const response = await fetch(apiUrl + "/send-message", {
        method: "POST",
        body: formData,
      });
      const result = await response.json();
      if (result.status) {
        Swal.fire({
          title: "Kirim Pesan",
          text: result.response,
          icon: "success",
        });
      } else {
        Swal.fire({
          title: "Kirim Pesan",
          text: result.response,
          icon: "error",
        });
      }
      // Tampilkan pesan respons API
      console.log(`${result.message ? result.message : result.response}`);
    } catch (error) {
      console.error("Error sending message:", error);
      Swal.fire({
        title: "Kirim Pesan",
        text: "Gagal mengirim pesan. Silakan coba lagi.",
        icon: "error",
      });
    }
  }

  kirimPesanBtn.addEventListener("click", kirimPesan);

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