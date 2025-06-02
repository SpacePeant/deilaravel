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
            <form action="{{ route('anak.store') }}" method="POST">
  @csrf
  <div class="mb-3">
    <label for="nama" class="form-label">Nama</label>
    <input type="text" name="nama" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
    <input type="date" name="tanggal_lahir" class="form-control" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Gender</label><br>
    <input type="radio" name="gender" value="L" required> Laki-laki
    <input type="radio" name="gender" value="P" required> Perempuan
  </div>
  <div class="mb-3">
    <label for="tinggi" class="form-label">Tinggi (cm)</label>
    <input type="number" name="tinggi" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="berat" class="form-label">Berat (kg)</label>
    <input type="number" name="berat" class="form-control" required>
  </div>
  <div class="mb-3">
    <label for="alergi" class="form-label">Alergi (jika ada)</label>
    <input type="text" name="alergi" class="form-control">
  </div>
  <button type="submit" class="btn btn-success">Simpan</button>
</form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
    