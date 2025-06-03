<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    



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
    display: none;
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

.popup {
        display: none; /* Hidden by default */
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
    }
    
    /* Popup Content */
    .popup-content {
        position: relative;
        background-color: white;
        width: 300px;
        margin: 15% auto;
        padding: 20px;
        text-align: center;
        border-radius: 10px;
    }
    
    /* Close Button */
    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        color: #000;
        cursor: pointer;
    }
    
    /* Popup Icon */
    .popup-icon {
        width: 40px;
        height: 40px;
        margin-bottom: 20px;
    }
    
    /* Popup Message */
    .popup-message {
        font-size: 18px;
        color: #333;
    }

    .container{
        margin-bottom: 80px;
    }
    .empty-message {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 300px; /* Atur tinggi sesuai kebutuhan */
        font-size: 1.5rem;
        color: #555;
        font-weight: 600;
    }
    .checkout-button.disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
    </style>
</head>
<body>
    @include('includes.header')
    <div class="container">
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
                            <span id="total-kalori-hari-ini-{{$anak}}-{{ strtolower($hari) }}">
    {{ $groupedCart[$anak][$hari]['kalori_total'] ?? 0 }} / {{ $groupedCart[$anak][$hari]['kalori_ideal'] ?? 0 }} Kalori
</span>
                        </h3>
                        <button class="lihat-detail" data-day="{{ $anak }}-{{ $hari }}">Lihat Detail</button>
                    </div>

                    <div class="menu-container" id="detail-{{ $anak }}-{{ $hari }}" style="display:none;">
                        @if (!empty($menus))
                            @foreach ($groupedCart[$anak][$hari]['menus'] as $menu)
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
                                            <button class="qty-btn minus" data-cart-id="{{ $menu['cart_id'] }}">−</button>
                                            <span class="qty" id="qty-{{ $menu['cart_id'] }}">{{ $menu['quantity'] }}</span>
                                            <button class="qty-btn plus" data-cart-id="{{ $menu['cart_id'] }}">+</button>
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

    <div class="checkout-bar">
        <div class="checkout-content">
            <span class="total-label">Total:</span>
            <span id="totalAmount">Rp {{ $totalHarga }}</span>
            <button class="checkout-button" onclick="checkout()">Checkout Payment</button>
        </div>
    </div>
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

        let paymentUrl = '{{ route("checkout") }}' + '?id=' + childId + '&name=' + encodeURIComponent(childName);
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
           const kaloriSpan = document.getElementById(`total-kalori-hari-ini-${data.anakId}-${data.hari.toLowerCase()}`);
if (kaloriSpan) {
    kaloriSpan.textContent = `${data.kaloriTotal} / ${data.kalori_ideal} Kalori`;
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