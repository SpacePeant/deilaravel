<?php
// Menghubungkan dengan database
session_start();
// Koneksi ke database MySQL
$servername = "localhost";
$username = "root";  // Ganti dengan username MySQL Anda
$password = "MySQLISBUC2024Sean";      // Ganti dengan password MySQL Anda
$dbname = "db_dei";  // Nama database

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data anak
$sql = "SELECT * FROM anak"; // Mengambil semua data anak
$result = $conn->query($sql);

// Cek apakah ada data anak
$children = [];
if ($result->num_rows > 0) {
    // Simpan data anak ke dalam array
    while($row = $result->fetch_assoc()) {
        $children[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Data Anak</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
      .child-card {
        cursor: pointer;
        border-radius: 1rem;
        transition: transform 0.2s;
      }
      .child-card:hover {
        transform: scale(1.02);
      }
      .child-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
      }
    </style>
  </head>
  <body class="bg-light">
    <?php include 'header.php'; ?>

    <div class="container py-5">
      <h2 class="mb-4">Pilih Anak</h2>
      <div class="row row-cols-1 row-cols-md-2 g-4" id="childList">
        <?php
        // Render data anak menggunakan PHP
        foreach ($children as $child) {
            $imgSrc = ($child['gender'] == 'L') ? 'imganak/cowok.png' : 'imganak/cewek.png';
            echo '
              <div class="col">
                <div onclick="selectChild(' . $child['id'] . ', \'' . $child['nama'] . '\')" class="text-decoration-none text-dark">
                  <div class="card p-3 shadow-sm child-card">
                    <div class="d-flex align-items-center">
                      <img src="' . $imgSrc . '" alt="Foto Anak" class="child-img me-3" />
                      <div>
                        <h5 class="mb-1">' . $child['nama'] . '</h5>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            ';
        }
        ?>
      </div>
    </div>

    <script>
      function selectChild(id, name) {
        // Simpan ke sessionStorage
        sessionStorage.setItem("selectedChild", JSON.stringify({ id, name }));
        // Pindah ke hari.php
        window.location.href = "hari.php?id=" + id + "&name=" + encodeURIComponent(name);
      }
    </script>

    <script>
      feather.replace();
    </script>
  </body>
</html>
