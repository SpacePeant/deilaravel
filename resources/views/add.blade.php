<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $tanggal_lahir = $_POST['tanggal_lahir'];
  $gender = $_POST['gender'];
  $tinggi = $_POST['tinggi'];
  $berat = $_POST['berat'];
  $alergi = $_POST['alergi'];

  // Validasi sederhana (bisa dikembangkan)
  if (!$nama || !$tanggal_lahir || !$gender || !$tinggi || !$berat) {
    echo "<script>alert('Harap isi semua field wajib.'); history.back();</script>";
    exit;
  }

  // Simpan ke database
  $stmt = $conn->prepare("INSERT INTO anak (nama, tanggal_lahir, gender, tinggi_cm, berat_kg, alergi) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("sssdds", $nama, $tanggal_lahir, $gender, $tinggi, $berat, $alergi);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo "<script>alert('Data anak berhasil ditambahkan.'); window.location.href = 'anak.php';</script>";
  } else {
    echo "<script>alert('Gagal menambahkan data.'); history.back();</script>";
  }

  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <title>Tambah Anak</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        background-color: #f8f9fa;
        font-family: "Open Sans", sans-serif;
      }
      .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        padding: 30px;
      }
      h2 {
        font-weight: 600;
        font-size: 1.8rem;
        color: #343a40;
      }
      label.form-label {
        font-weight: 600;
        margin-bottom: 6px;
      }
      .form-control {
        border-radius: 8px;
      }
      .btn-success {
        background-color: #198754;
        border-color: #198754;
        padding: 8px 20px;
        font-weight: 600;
      }
      .btn-success:hover {
        background-color: #157347;
      }
      .btn-secondary {
        padding: 8px 20px;
        font-weight: 600;
      }
    </style>
  </head>
  <body>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
          <div class="card">
            <h2 class="mb-4 text-center">Tambah Data Anak</h2>
            <form method="POST">
              <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap Anak</label>
                <input type="text" class="form-control" id="nama" name="nama" required />
              </div>
              <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required />
              </div>
              <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select class="form-control" id="gender" name="gender" required>
                  <option value="">Pilih</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="tinggi" class="form-label">Tinggi Badan (cm)</label>
                <input type="number" class="form-control" id="tinggi" name="tinggi" step="0.1" required />
              </div>
              <div class="mb-3">
                <label for="berat" class="form-label">Berat Badan (kg)</label>
                <input type="number" class="form-control" id="berat" name="berat" step="0.1" required />
              </div>
              <div class="mb-3">
                <label for="alergi" class="form-label">Alergi Anak</label>
                <input type="text" class="form-control" id="alergi" name="alergi" />
              </div>
              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="anak.php" class="btn btn-secondary ms-2">Kembali</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
