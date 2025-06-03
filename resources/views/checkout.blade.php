<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
      body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    padding: 20px;
}

h2 {
    margin-bottom: 24px;
}

.day-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 16px 24px;
    margin-bottom: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    margin-left: 200px;
    margin-right: 200px;
    justify-content: center;
}

a{
  color: black;
  text-decoration: none;
}

.day-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.lihat-detail {
    padding: 8px 14px;
    background-color: #2196f3;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.menu-container {
    margin-top: 16px;
}

.menu-card {
    display: flex;
    margin-bottom: 16px;
    background-color: #ffffff;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 8px;
    position: relative;
}

.menu-image-container {
    width: 100px;
    height: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-right: 30px;  /* Tambahkan margin kanan */
}

.menu-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 6px;
}

.menu-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}

.menu-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.menu-price {
    font-weight: bold;
    color: #333;
    font-size: 16px;
    position: absolute;
    top: 16px;
    right: 16px;
}

.menu-options ul {
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

.menu-card{
  align-items: center;
}

.menu-image-container img{
  width: 150%;
  height: 150%;
}
.menu-image-container{
  margin: 0px 100px 0px 100px;
}

.note-textarea {
    width: 50%;
    height: 100px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f5f5f5;
    font-family: Arial, sans-serif;
    font-size: 14px;
    color: #333;
    resize: none; /* Menonaktifkan perubahan ukuran textarea */
    box-sizing: border-box; /* Agar padding tidak menambah ukuran */
    margin-top: 15px;
}

h2{
  text-align: center;
  padding: 20px 0px 20px 0px;
}

.checkout-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #fff;
    border-top: 1px solid #ddd;
    padding: 12px 24px;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.05);
    display: flex;
    justify-content: center;
    z-index: 999;
}

.checkout-content {
    width: 100%;
    max-width: 900px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-label {
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

#totalAmount {
    font-size: 18px;
    font-weight: bold;
    color: #4caf50;
    margin-left: 10px;
    flex-grow: 1;
    text-align: right;
    margin-right: 20px;
}

.checkout-button {
    padding: 10px 18px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
}

.container {
      max-width: 800px;
      margin: 0 auto;
      background: #fff;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    h2 {
      margin-bottom: 20px;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 16px;
    }

    .payment-option {
      display: flex;
      align-items: center;
      gap: 12px;
      border: 2px solid #e0e0e0;
      padding: 12px;
      border-radius: 10px;
      background-color: #fff;
      transition: all 0.2s ease;
      cursor: pointer;
    }

    .payment-option:hover {
      border-color: #007bff;
      box-shadow: 0 2px 8px rgba(0, 123, 255, 0.1);
    }

    .payment-option input[type="radio"] {
      accent-color: #007bff;
      width: 18px;
      height: 18px;
    }

    .payment-option img {
      width: 40px;
      height: 40px;
      background-color: #eaeaea;
      border-radius: 6px;
      object-fit: contain;
    }

    .payment-option span {
      font-size: 16px;
      font-weight: 500;
    }

    .summary-card {
    background: linear-gradient(135deg, #ffffff, #f1f3f5);
    border-radius: 16px;
    padding: 25px 30px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .summary-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
  }

  .summary-title {
    font-size: 1.6rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
  }

  .summary-text {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 10px;
  }

  .summary-total {
    font-size: 2rem;
    font-weight: bold;
    color: #28a745;
  }

  #pem{
    margin-bottom: 50px;
    margin-top: 80px;
    background-color: #ffffff;
    padding: 12px;
    border-radius: 8px;
  }

.checkout-button:hover {
    background-color: #218838;
}

/* Pop-up Styling */
.popup {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.popup-content {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    text-align: center;
    width: 300px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.checkmark {
    font-size: 50px;
    color: green;
    margin-bottom: 20px;
}

h2 {
    color: green;
    font-size: 24px;
    margin: 10px 0;
}

p {
    font-size: 16px;
    margin-bottom: 20px;
}

.popup-buttons {
    margin: 30px 0;
    display: flex;
}

.see-order-details, .back-home {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin: 0 10px;
}

.see-order-details:hover, .back-home:hover {
    background-color: #0056b3;
}

.close-popup {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.close-popup:hover {
    background-color: #c82333;
}

.tes{
    margin-bottom: 100px;
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
    #successPopup{
        align-items: center;
        justify-content: center;
    }
    .popup {
    display: none; /* Hide by default */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    background-color: rgba(0, 0, 0, 0.5); /* Dark background to dim the screen */
    width: 100%;
    height: 100%;
}

.popup-content {
    position: relative;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    max-width: 500px;
    margin: 0 auto;
    text-align: center;
}
    </style>
</head>
<body>
    @include('includes.header')
    <div class="containerr">
    @if (empty($groupedCart) || count($groupedCart) === 0)
        <div class="empty-message">
            Belum ada pesanan.
        </div>
    @else
        @foreach ($groupedCart as $anak => $hariMenus)
            <h2 class="anak-header">Anak: {{ $anak }}</h2>

            @foreach ($hariMenus as $hari => $menus)
                <div class="day-card">
                    <div class="day-header">
                        <h3>
                            {{ ucfirst($hari) }}
                            <span id="total-kalori-hari-ini-{{ $anak }}-{{ $hari }}">
                                {{ $kalori_per_hari[$anak][$hari] ?? 0 }} / {{ round($kalori_ideal[$anak] ?? 0) }} Kalori
                            </span>
                        </h3>
                    </div>

                    <div class="menu-container" id="detail-{{ $anak }}-{{ $hari }}">
                        @if (!empty($menus))
                            @foreach ($menus as $menu)
                                @php
                                    $options = is_array($menu['options']) ? $menu['options'] : json_decode($menu['options'], true) ?? [];
                                @endphp
                                <div class="menu-card" data-cart-id="{{ $menu['cart_id'] }}">
                                    <div class="menu-image-container">
                                        <img src="{{ asset('images/' . ($menu['gambar'] ?? 'default.png')) }}" alt="{{ $menu['menu_nama'] }}">
                                    </div>
                                    <div class="menu-info">
                                        <div class="menu-header">
                                            <h4>{{ $menu['menu_nama'] }}</h4>
                                            <div class="menu-price">Rp{{ number_format($menu['harga'] ?? 0, 0, ',', '.') }}</div>
                                        </div>

                                        <div class="menu-options">
                                            <ul>
                                                @foreach ($options as $key => $value)
                                                    <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <p><strong>Alamat:</strong> {{ $menu['alamat'] ?? '-' }}</p>
                                        <p><strong>Jam Pengiriman:</strong> {{ $menu['jam'] ?? '-' }}</p>

                                        @if (!empty($menu['note']))
                                            <div class="tulis"><strong>Catatan:</strong></div>
                                            <div class="note-container">
                                                <textarea class="note-textarea" readonly>{{ $menu['note'] }}</textarea>
                                            </div>
                                        @endif

                                        <div class="quantity-control">
                                                                                        <span class="qty" id="qty-{{ $menu['cart_id'] }}">{{ $menu['quantity'] }}x</span>
                                        </div>

                                    </div>
                                </div>
                            @endforeach

                        @else
                            <p>Tidak ada menu yang dipesan</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @endforeach
    @endif

    <div class="container mt-4" id="pem">
    <div class="summary-card">
        <div class="summary-title">Ringkasan Pembayaran</div>
        <div class="summary-text">Total yang harus dibayar:</div>
        <div class="summary-total">
            <span id="totalAmount">Rp {{ number_format($totalHarga ?? 0, 0, ',', '.') }}</span>
        </div>
    </div>
</div>
</div>
<div class="checkout-bar">
    <div class="checkout-content">
        <span class="total-label">Total:</span>
        <span id="totalAmount">Rp {{ number_format($totalHarga ?? 0, 0, ',', '.') }}</span>
        <button class="checkout-button" form="paymentForm" type="submit">
            Bayar Sekarang
        </button>
    </div>
</div>

<!-- Success Pop-up -->
<div id="successPopup" class="popup" style="display:none;">
    <div class="popup-content">
        <span class="checkmark">&#10004;</span>
        <h2>Order Berhasil!</h2>
        <p>Terima kasih telah berbelanja!</p>
        <div class="popup-buttons">
            {{-- <a href="{{ route('order.details') }}" class="see-order-details btn btn-primary">Lihat Rincian Pesanan</a>
            <a href="{{ route('home') }}" class="back-home btn btn-secondary">Kembali ke Beranda</a> --}}
        </div>
    </div>
</div>

<div class="container">
    <h2>Pilih Metode Pembayaran</h2>
        <form id="paymentForm" action="{{ route('checkout.all') }}" method="POST">
        @csrf
        <div class="grid">

            @php
                $payments = [
                    ['value' => 'bca', 'img' => 'pay/BCA1.png', 'name' => 'Bank BCA'],
                    ['value' => 'mandiri', 'img' => 'pay/logo-mandiri.png', 'name' => 'Bank Mandiri'],
                    ['value' => 'bri', 'img' => 'pay/BRI1.png', 'name' => 'Bank BRI'],
                    ['value' => 'bni', 'img' => 'pay/BNI1.png', 'name' => 'Bank BNI'],
                    ['value' => 'qris', 'img' => 'pay/QRIS1.png', 'name' => 'QRIS'],
                    ['value' => 'shopeepay', 'img' => 'pay/Shopeepay1.png', 'name' => 'ShopeePay'],
                    ['value' => 'gopay', 'img' => 'pay/gopay.png', 'name' => 'GoPay'],
                    ['value' => 'ovo', 'img' => 'pay/OVO1.png', 'name' => 'OVO'],
                    ['value' => 'dana', 'img' => 'pay/dana1.png', 'name' => 'Dana'],
                ];
            @endphp

            @foreach ($payments as $index => $payment)
                <label class="payment-option">
                    <input 
                        type="radio" 
                        name="payment_method" 
                        value="{{ $payment['value'] }}" 
                        {{ $index === 0 ? 'checked' : '' }}>
                    <img src="{{ asset($payment['img']) }}" alt="{{ $payment['name'] }}">
                    <span>{{ $payment['name'] }}</span>
                </label>
            @endforeach

        </div>
    </form>
</div>

{{-- Jangan lupa script JS, bisa kamu pindahkan ke file .js --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function updateCheckoutButton() {
    const totalAmountSpan = document.getElementById('totalAmount');
    const checkoutButton = document.querySelector('.checkout-button');

    // Ambil nilai total, hilangkan 'Rp' dan titik ribuan, lalu parse ke number
    let totalText = totalAmountSpan.textContent || '';
    totalText = totalText.replace(/[^0-9]/g, ''); // hapus selain angka
    const total = parseInt(totalText, 10) || 0;

    if (total > 0) {
        checkoutButton.disabled = false;
        checkoutButton.classList.remove('disabled'); // buat gaya khusus kalau mau
    } else {
        checkoutButton.disabled = true;
        checkoutButton.classList.add('disabled'); // buat gaya khusus kalau mau
    }
}

// Panggil fungsi ini setelah update total harga
updateCheckoutButton();
    $('.lihat-detail').on('click', function () {
        const day = $(this).data('day');
        $('#detail-' + day).slideToggle();
    });

    // JS quantity update dan checkout bisa diimplementasikan sesuai kebutuhan Laravel API endpoint

    function checkout() {
        let totalAmount = {{ $totalHarga }};
        let childId = {{ session('selected_child_id', 'null') }};
        let childName = {!! json_encode(session('selected_child_name', '')) !!};

        if (totalAmount === 0) {
            alert('Belum ada makanan yang di pesan');
            return false;
        }

        let paymentUrl = '{{ url('payment') }}' + '?id=' + childId + '&name=' + encodeURIComponent(childName);
        window.location.href = paymentUrl;
    }
</script>


<script>
    function hapusAnakJikaHariKosong() {
    const container = document.querySelector('.container');
    if (!container) return;

    const anakHeaders = container.querySelectorAll('h2');
    anakHeaders.forEach((h2, index) => {
        let nextElem = h2.nextElementSibling;
        let adaDayCard = false;

        while (nextElem && nextElem.tagName.toLowerCase() !== 'h2') {
            if (nextElem.classList.contains('day-card')) {
                adaDayCard = true;
                break;
            }
            nextElem = nextElem.nextElementSibling;
        }

        if (!adaDayCard) {
            h2.remove();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Ambil token csrf dari meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function updateQuantity(cartId, delta) {
        fetch('/cart/update-quantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ cart_id: cartId, delta: delta })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.quantity > 0) {
                    // Update tampilan quantity
                    const qtySpan = document.getElementById('qty-' + cartId);
                    if (qtySpan) {
                        qtySpan.textContent = data.quantity;
                    }
                } else {
                    // Quantity 0: hapus menu dari DOM
                    const menuCard = document.querySelector(`.menu-card[data-cart-id="${cartId}"]`);
                    if (menuCard) {
                        // Simpan referensi elemen yang akan dicek setelah hapus
                        const dayContainer = menuCard.closest('.menu-container');
                        const dayCard = menuCard.closest('.day-card');
                        const anak = dayCard ? dayCard.previousElementSibling ? dayCard.previousElementSibling.textContent : null : null;

                        menuCard.remove();

                        

                        // Jika menu-container sudah kosong, hapus day-card juga
                        if (dayContainer && dayContainer.children.length === 0) {
                            // Hapus day-card
                            if (dayCard) {
                                const anakHeader = dayCard.previousElementSibling; // <h2>Anak: ...</h2> mungkin ada di atas day-card
                                dayCard.remove();
hapusAnakJikaHariKosong();
                                // Cek apakah masih ada day-card untuk anak tersebut
                                
                            }
                        }
                    }
                }
                const totalAmountSpan = document.getElementById('totalAmount');
        if (totalAmountSpan) {
            // Format harga pakai toLocaleString Indonesia
            totalAmountSpan.textContent = 'Rp ' + Number(data.totalHarga).toLocaleString('id-ID');
        }
            } else {
                alert('Gagal update quantity: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(err => {
            alert('Error saat update quantity');
            console.error(err);
        });
    }

    // Pasang event listener tombol plus
    document.querySelectorAll('.qty-btn.plus').forEach(button => {
        button.addEventListener('click', function () {
            const cartId = this.dataset.cartId;
            updateQuantity(cartId, 1);
        });
    });

    // Pasang event listener tombol minus
    document.querySelectorAll('.qty-btn.minus').forEach(button => {
        button.addEventListener('click', function () {
            const cartId = this.dataset.cartId;
            updateQuantity(cartId, -1);
        });
    });
});

</script>

</body>
</html>