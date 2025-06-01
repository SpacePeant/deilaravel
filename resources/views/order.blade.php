<?php
$day = isset($_GET['day']) ? $_GET['day'] : 'tidak diketahui';

// contoh tampilkan hari
echo "<h2>Hari yang dipilih: " . htmlspecialchars($day) . "</h2>";

// atau bisa digunakan dalam proses pemesanan selanjutnya
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Order</title>
    <link rel="stylesheet" href="menu.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tangerine&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <section class="food-cart">
        <h2>Paket Menu</h2>
        <div class="backbutt">
            <a href="hari.php">
                <button>Back</button>
            </a>
        </div>

        <div class="menu" id="menu-container">
            <!-- Paket list akan dimuat menggunakan JavaScript -->
        </div>
    </section>

    <script>
        const day = new URLSearchParams(window.location.search).get('day');
        // Fungsi untuk mengambil dan menampilkan paket dari JSON
        $(document).ready(function() {
            // Memuat file JSON dengan jQuery
            $.getJSON("paket_menu.json", function(paketData) {
                // Menghasilkan HTML untuk setiap paket
                var paketContainer = $("#menu-container");
                paketData.forEach(function(paket) {
                    var paketHTML = `
                        <a href="pesan.php?paket=${paket.id}&day=${day}" class="food-box">
                          <div class="menu-card">
                            <div class="circle-image">
                              <img src="${paket.gambar}" alt="${paket.nama}" />
                            </div>
                            <div class="menu-details">
                              <span class="label">Paket</span>
                              <h3>${paket.nama}</h3>
                              <p>${paket.deskripsi}</p>
                              <button>Lihat Detail</button>
                            </div>
                          </div>
                        </a>
                    `;
                    paketContainer.append(paketHTML);
                });
            });
        });
    </script>
</body>
</html>
