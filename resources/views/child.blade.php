<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Detail Anak</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
        <img src="{{ $imgSrc }}" alt="Foto Anak" class="child-img me-4" />
        <div>
          <h4>{{ $child->nama }}</h4>
          <p class="mb-1">Umur: {{ $umur }} tahun</p>
          <p class="mb-1">Tinggi: {{ $child->tinggi_cm }} cm</p>
          <p class="mb-1">Berat: {{ $child->berat_kg }} kg</p>
          <p class="mb-1">Alergi: {{ $child->alergi ?? '-' }}</p>
          <p class="mb-1">Kebutuhan Kalori Ideal: {{ number_format($kalori, 2) }} kkal/hari</p>
          <p class="mb-1">Kebutuhan Protein Ideal: {{ number_format($protein, 2) }} gram/hari</p>
        </div>
      </div>

      <form action="{{ route('anak.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data anak ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Hapus Anak</button>
        <a href="{{ route('anak') }}" class="btn btn-secondary ms-2">Kembali</a>
      </form>
    </div>
  </div>
</body>
</html>
