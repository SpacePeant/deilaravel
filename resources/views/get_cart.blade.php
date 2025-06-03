<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
  /* (Gaya CSS tetap seperti yang Anda buat sebelumnya, tidak diubah) */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  
  body {
    font-family: 'Poppins', sans-serif;
    background-color: #f9f9f9;
    color: #333;
    padding: 20px;
  }
  
  /* Section title */
  .menu-section h2 {
    font-family: 'Tangerine', cursive;
    font-size: 48px;
    color: #738e2a;
    text-align: center;
    margin-bottom: 30px;
  }
  
  /* Filter buttons */
  .filters {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 30px;
  }
  
  .filters button {
    padding: 10px 20px;
    border: 2px solid #738e2a;
    background-color: white;
    color: #738e2a;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
  }
  
  .filters button:hover,
  .filters button.active {
    background-color: #738e2a;
    color: white;
  }
  
  /* Menu grid */
  .menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  /* Menu card */
  .menu-card {
    background-color: white;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    padding: 15px;
    text-align: center;
    transition: 0.3s ease;
    text-decoration: none;
    color: inherit;
  }
  
  .menu-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  }
  
  .menu-card img {
    width: 100%;
    height: auto;
    max-height: 180px;
    object-fit: contain;
    margin-bottom: 10px;
  }
  
  .menu-card h3 {
    font-size: 18px;
    margin: 10px 0 5px;
    color: #333;
  }
  
  .menu-card p {
    font-size: 14px;
    color: #777;
    margin-bottom: 10px;
  }
  
  /* Detail button */
  .detail-btn {
    padding: 8px 16px;
    background-color: #738e2a;
    border: none;
    color: white;
    border-radius: 25px;
    cursor: pointer;
    font-weight: 600;
    transition: 0.3s ease;
  }
  
  .detail-btn:hover {
    background-color: #738e2a;
  }
  
  /* Cart Icon */
  .cart-icon {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #4caf50;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 1000;
  }
  
  .cart-icon i {
    width: 24px;
    height: 24px;
  }
  
  .cart-icon span {
    position: absolute;
    top: 8px;
    right: 8px;
    background: red;
    color: white;
    font-size: 12px;
    font-weight: bold;
    border-radius: 50%;
    padding: 2px 6px;
  }
  
  /* Cart sidebar (optional styling) */
  .cart-sidebar {
    position: fixed;
    top: 0;
    right: 0;
    width: 300px;
    height: 100%;
    background-color: white;
    box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    overflow-y: auto;
    z-index: 1001;
  }
  
  .cart-sidebar.hidden {
    display: none;
  }
  
  .cart-sidebar h2 {
    margin-bottom: 15px;
    font-size: 24px;
  }
  
  .cart-sidebar ul {
    list-style: none;
    margin-bottom: 20px;
  }
  
  .cart-sidebar button {
    width: 100%;
    padding: 10px;
    background-color: #f57c00;
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s ease;
  }
  
  .cart-sidebar button:hover {
    background-color: #d96200;
  }

  .jum{
    border-radius: 25px;
    padding: 3px 15px 3px 15px;
    font-size: 13px;
  }
  .menu-container {
    display: none;
    margin-top: 16px;
}

.menu-kotak {
    display: flex;
    margin-bottom: 16px;
    background-color: #ffffff;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    position: relative;
}

.menu-image-cont {
    width: 100px;
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 30px;  /* Tambahkan margin kanan */
}

.menu-image-cont img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
}

.menu-inf {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}

.menu-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.menu-pri {
    font-weight: bold;
    color: #333;
    font-size: 16px;
    position: absolute;
    top: 16px;
    right: 16px;
}

.menu-opt ul {
    margin: 0;
    padding-left: 20px;
    list-style-type: none;
}

.quantity-control {
    position: absolute;
    bottom: 12px;
    right: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.qty-btn {
    width: 28px;
    height: 28px;
    border: none;
    border-radius: 4px;
    background-color: #ddd;
    cursor: pointer;
    font-size: 18px;
    font-weight: bold;
}

.menu-right-bottom {
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.menu-kotak{
  align-items: center;
}

.menu-image-cont img{
  width: 150%;
  height: 150%;
}
.menu-image-cont{
  margin: 0px 60px 0px 60px;
}
  .back-button {
      display: inline-block;
      background-color: #28a745;
      color: white;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 6px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      margin: 20px;
      transition: background-color 0.3s ease;
    }

    .back-button:hover {
      background-color: #218838;
    }

  </style>
</head>
<body>
  
  <body>
  @include('includes.header')
  <a href="javascript:history.back()" class="back-button">← Back</a>

<h2>Paket Menu</h2>

<!-- Filter Buttons -->
<!-- Filter Buttons -->
<div class="filters mb-4">
    <button class="filter-btn active" data-filter="all">Semua</button>
    @foreach ($categories as $category)
        <button class="filter-btn" data-filter="{{ $category->id }}">
            {{ $category->nama }}
        </button>
    @endforeach
</div>

<!-- Menu Cards -->
<div class="menu-grid">
@foreach ($menus as $index => $menu)
    <div class="menu-card" data-category="{{ $menu->category_id }}">
        <div class="plate-image">
            <img src="{{ asset('images/' . $menu->gambar) }}" alt="{{ $menu->nama }}" />
        </div>
        <div>
            <h3>{{ $menu->nama }}</h3>
            <p>{{ $menu->deskripsi }}</p>
            <p><strong>Rp {{ number_format($menu->harga, 0, ',', '.') }}</strong></p>
            <button class="detail-btn" data-bs-toggle="modal" data-bs-target="#modal{{ $index }}">Tambah</button>
        </div>
    </div>

      <!-- Modal -->
      <div class="modal fade" id="modal{{ $index }}" tabindex="-1" aria-labelledby="modalLabel{{ $index }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" class="modal-content" action="{{ route('order.add') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel{{ $index }}">Kustomisasi - {{ $menu->nama }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Kustomisasi Menu --}}
                @foreach ($menu->customizations_grouped as $kategori => $opsiList)
                    <div class="mb-3">
                        <label class="form-label">{{ $kategori }}</label>
                        <select name="custom_{{ \Str::slug($kategori) }}" class="form-select" required>
                            <option value="">Pilih opsi</option>
                            @foreach ($opsiList as $opsi)
                                <option value="{{ $opsi }}">{{ $opsi }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach

                {{-- Catatan --}}
                <div class="mb-3">
                    <label class="form-label">Catatan Tambahan</label>
                    <textarea class="form-control" name="note" rows="2" placeholder="Contoh: tanpa timun, pedas banget, lombok dipisah"></textarea>
                </div>

                {{-- Alamat --}}
                <div class="mb-3">
                    <label class="form-label">Alamat Pengantaran</label>
                    <textarea class="form-control" name="delivery_address" rows="2" required placeholder="Masukkan alamat lengkap..."></textarea>
                </div>

                {{-- Hari --}}
                <div class="mb-3">
                    <label class="form-label">Hari Pengantaran (boleh pilih lebih dari satu)</label>
                    <div class="row">
                        @foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $day)
                            <div class="form-check form-check-inline col-6">
                                <input class="form-check-input" type="checkbox" name="delivery_days[]" id="day_{{ $day }}_{{ $index }}" value="{{ $day }}">
                                <label class="form-check-label" for="day_{{ $day }}_{{ $index }}">{{ ucfirst($day) }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Jam --}}
                <div class="mb-3">
                    <label class="form-label">Jam Pengantaran</label>
                    <select class="form-select" name="delivery_time" required>
                        <option value="">Pilih Jam</option>
                        <option value="07:00">07:00 WIB</option>
                        <option value="12:00">12:00 WIB</option>
                        <option value="18:00">18:00 WIB</option>
                    </select>
                </div>

                {{-- Anak --}}
                <div class="mb-3">
                    <label class="form-label">Pilih Anak</label>
                    @foreach ($anak as $a)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="anak_ids[]" value="{{ $a->id }}" id="anak{{ $index }}_{{ $a->id }}">
                            <label class="form-check-label" for="anak{{ $index }}_{{ $a->id }}">
                                {{ $a->nama }}
                            </label>
                        </div>
                    @endforeach
                </div>

                {{-- Hidden --}}
                <input type="hidden" name="name" value="{{ $menu->nama }}">
                <input type="hidden" name="image" value="{{ $menu->gambar }}">
                <input type="hidden" name="price" value="{{ $menu->harga }}">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Tambah ke Pesanan</button>
            </div>
        </form>
    </div>
</div>

  @endforeach
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Filter Script -->
<script>
  document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');

        const filter = button.getAttribute('data-filter');
        const menuCards = document.querySelectorAll('.menu-card');

        menuCards.forEach(card => {
            const category = card.getAttribute('data-category');
            if (filter === 'all' || category === filter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

</script>
</body>
</html>











