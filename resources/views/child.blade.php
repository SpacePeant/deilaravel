<?php
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

if (!isset($_GET['id'])) {
  echo "<p>ID anak tidak ditemukan.</p>";
  exit;
}

$id = $_GET['id'];

// Ambil data anak berdasarkan ID
$stmt = $conn->prepare("SELECT * FROM anak WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$child = $result->fetch_assoc();

if (!$child) {
  echo "<p>Data anak tidak ditemukan.</p>";
  exit;
}

// Hitung umur dari tanggal_lahir
$umur = date_diff(date_create($child['tanggal_lahir']), date_create('today'))->y;

// Hitung kalori ideal berdasarkan umur
if ( $child['gender'] === 'P') {
  $kalori = ($child['tinggi_cm'] * 3.10) + (($child['berat_kg'] * 9.25) + 447.6) - ($umur * 4.33);
} else {
  $kalori = ($child['tinggi_cm'] * 4.8) + (($child['berat_kg'] * 13.4) + 88.4) - ($umur * 5.68);
}

// Hitung protein ideal: 1 gram per kg berat
$protein = $child['berat_kg'] * 1;

// Tentukan gambar berdasarkan gender
$imgSrc = $child['gender'] === 'L' ? 'imganak/cowok.png' : 'imganak/cewek.png';
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Detail Anak</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      .child-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
      }
    </style>
  </head>
  <body class="bg-light">
    <div class="container py-5">
      <h2 class="mb-4">Detail Anak</h2>
      <div class="card p-4 shadow-sm">
        <div class="d-flex align-items-center mb-4">
          <img src="<?= $imgSrc ?>" alt="Foto Anak" class="child-img me-4" />
          <div>
            <h4><?= htmlspecialchars($child['nama']) ?></h4>
            <p class="mb-1">Umur: <?= $umur ?> tahun</p>
            <p class="mb-1">Tinggi: <?= htmlspecialchars($child['tinggi_cm']) ?> cm</p>
            <p class="mb-1">Berat: <?= htmlspecialchars($child['berat_kg']) ?> kg</p>
            <p class="mb-1">Alergi: <?= $child['alergi'] ? htmlspecialchars($child['alergi']) : '-' ?></p>
            <p class="mb-1">Kebutuhan Kalori Ideal: <?= $kalori ?> kkal/hari</p>
            <p class="mb-1">Kebutuhan Protein Ideal: <?= $protein ?> gram/hari</p>
          </div>
        </div>

        <form method="post" onsubmit="return confirm('Yakin ingin menghapus data anak ini?');">
          <button type="submit" name="delete" class="btn btn-danger">Hapus Anak</button>
          <a href="anak.php" class="btn btn-secondary ms-2">Kembali</a>
        </form>
      </div>
    </div>

    <?php
    // Proses hapus jika tombol ditekan
    if (isset($_POST['delete'])) {
      $stmt = $conn->prepare("DELETE FROM anak WHERE id = ?");
      $stmt->bind_param("i", $id);
      $stmt->execute();
      echo "<script>alert('Data anak berhasil dihapus'); window.location.href='anak.php';</script>";
      exit;
    }
    ?>
  </body>
</html>
