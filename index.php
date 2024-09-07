<?php
include 'db.php';
// Ambil URL API dari database
$query = "SELECT web_url FROM webhook_urls ORDER BY updated_at DESC LIMIT 1";
$result = $conn->query($query);

$apiUrl = "";
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $apiUrl = $row['web_url'];
}

$query = "SELECT url_api FROM webhook_urls ORDER BY updated_at DESC LIMIT 1";
$result = $conn->query($query);

$urlapi = "";
if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $urlapi = $row['url_api'];
}


?>
<?php include 'layout/header.php'; ?>
<?php include 'layout/sidebar.php'; ?>

<div class="content">
  <div class="form">
    <h1>WhatsApp API QR</h1>
    <div id="connection-status" style="font-size: 18px; color: #000; margin-top: 10px;">Checking connection...</div>
    <div id="signal-bar" style="display: flex; gap: 2px; margin-top: 10px;">
      <div class="signal-bar" id="bar1" style="width: 8px; height: 20px; background-color: gray;"></div>
      <div class="signal-bar" id="bar2" style="width: 8px; height: 20px; background-color: gray;"></div>
      <div class="signal-bar" id="bar3" style="width: 8px; height: 20px; background-color: gray;"></div>
      <div class="signal-bar" id="bar4" style="width: 8px; height: 20px; background-color: gray;"></div>
      <div class="signal-bar" id="bar5" style="width: 8px; height: 20px; background-color: gray;"></div>
    </div>
    <div id="loading" style="display: none"></div>
    <img id="profile-pic" style="display: none" alt="Profile Picture" src="./assets/loader.gif" style="display: block;" />
    <img id="qrcode" alt="QR Code" src="./assets/loader.gif" style="display: block;" />
    <div class="user-info-container">
      <div id="user-info"></div>
      <p id="user-number" style="font-size: 18px; color: rgb(0, 0, 0); margin-top: 10px"></p>
    </div>
    <button id="logout-btn" class="btn btn-danger">Logout</button>
  </div>
</div>

<script>
  const apiUrl = "<?php echo $apiUrl; ?>";
  const urlapi = "<?php echo $urlapi; ?>";

  function updateSignalBar(status) {
    const bars = Array.from(document.getElementsByClassName("signal-bar"));
    bars.forEach((bar, index) => {
      if (index < status) {
        bar.style.backgroundColor = "green";
      } else {
        bar.style.backgroundColor = "gray";
      }
    });
  }

  function sendLocationToServer(latitude, longitude, locationName, update_at) {
    fetch(urlapi + "/api/update-location.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          latitude: latitude,
          longitude: longitude,
          locationName: locationName,
          update_at: update_at
        }),
      })
      .then(response => response.json())
      .then(data => {
        console.log('Location data sent successfully:', data);
      })
      .catch(error => {
        console.error('Error sending location data:', error);
      });
  }

  setInterval(() => {
    fetch(apiUrl + "/api/qr-code")
      .then((response) => {
        if (response.ok) {
          document.getElementById("connection-status").textContent = "Status: Online";
          document.getElementById("connection-status").style.color = "green";
          updateSignalBar(5); // Set bar sinyal ke 5 jika koneksi berhasil
        } else {
          throw new Error("API not reachable");
        }
        return response.json();
      })
      .then((data) => {
        const profilePic = document.getElementById("profile-pic");
        const loading = document.getElementById("loading");
        const userInfo = document.getElementById("user-info");
        const userNumber = document.getElementById("user-number");
        const qrCodeImg = document.getElementById("qrcode");

        if (data.qrCodeUrl) {
          qrCodeImg.src = data.qrCodeUrl;
          qrCodeImg.style.display = "block";
        } else {
          qrCodeImg.style.display = "none";
        }

        if (data.user) {
          loading.style.display = "none";
          profilePic.src = data.profilePicUrl;
          profilePic.style.display = "block";
          userInfo.textContent = `Name: ${data.nama}`;
          userNumber.textContent = `Number: ${data.user}`;
        } else {
          profilePic.style.display = "none";
          userInfo.textContent = "";
          userNumber.textContent = "";
        }
      })
      .catch((error) => {
        console.error("Error fetching data:", error);
        document.getElementById("connection-status").textContent = "Status: Offline";
        document.getElementById("connection-status").style.color = "red";
        updateSignalBar(0); // Set bar sinyal ke 0 jika tidak ada koneksi
      });

    // Ambil lokasi pengguna dan nama lokasi berdasarkan kordinat
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        const update_at = new Date().toISOString();
        // Menggunakan API Geocoding dari OpenStreetMap untuk mendapatkan nama lokasi berdasarkan kordinat
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
          .then(response => response.json())
          .then(data => {
            const locationName = data.display_name; // Mendapatkan nama lokasi dari API
            sendLocationToServer(latitude, longitude, locationName);
          })
          .catch(error => {
            console.error("Error getting location name:", error);
          });
      }, (error) => {
        console.error("Error getting location:", error);
        // Jika GPS tidak diaktifkan, maka jangan beri akses
        if (error.code === 1) {
          alert("GPS tidak diaktifkan. Silakan aktifkan GPS untuk menggunakan fitur ini.");
        }
      });
    } else {
      console.error("Geolocation is not supported by this browser.");
    }
  }, 10000); // Memanggil API setiap 10 detik
</script>

<!-- Event listener untuk tombol logout -->
<script>
  document.getElementById("logout-btn").addEventListener("click", () => {
    fetch(apiUrl + "/logout", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
      })
      .then((response) => response.json())
      .then((data) => {
        if (data.status) {
          console.log(data.message);
          // Tambahkan kode untuk mengarahkan ke halaman login atau tindakan lain setelah logout
        } else {
          console.error(data.message);
        }
      })
      .catch((error) => {
        console.error("Error logging out:", error);
      });
  });

  // Event listener untuk hamburger
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