<?php

session_start(); // Selalu wajib untuk akses $_SESSION

// Cek apakah ada data dari URL (GET)
if (isset($_GET['id']) && isset($_GET['name'])) {
    $_SESSION['selected_child_id'] = $_GET['id'];
    $_SESSION['selected_child_name'] = $_GET['name'];
}

// Jika tidak ada session anak, redirect balik ke pilihanak.php
if (!isset($_SESSION['selected_child_id']) || !isset($_SESSION['selected_child_name'])) {
    header("Location: pilihanak.php");
    exit();
}

// Ambil data dari session
$id_anak = $_SESSION['selected_child_id'];
$nama_anak = $_SESSION['selected_child_name'];

$conn = new mysqli("localhost", "root", "MySQLISBUC2024Sean", "db_dei");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (isset($_GET['get_total']) && $_GET['get_total'] == '1') {
    $query = "SELECT SUM(c.quantity * m.harga) AS total
              FROM cart c
              JOIN menu m ON m.id = c.menu_id
              WHERE c.child_id = $id_anak"; // GANTI sesuai kebutuhan

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'] ?? 0;

    echo $total;
    exit; // ini penting agar tidak menampilkan halaman penuh saat request AJAX
}

$days_of_week = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];

// Query untuk mengambil data cart berdasarkan child_id yang dipilih
$query = "
    SELECT c.cart_id, c.day_of_week, c.quantity, c.note, m.nama AS menu_name, m.harga, m.gambar, c.options, c.alamat as alamat, DATE_FORMAT(c.jam, '%e %M %Y') AS tanggal_pengantaran,
  CONCAT(DATE_FORMAT(c.jam, '%H:%i'),' WIB') AS jam_pengantaran
    FROM cart c
    JOIN menu m ON c.menu_id = m.id
    WHERE c.child_id = $id_anak
    ORDER BY FIELD(c.day_of_week, 'senin', 'selasa', 'rabu', 'kamis', 'jumat'), c.cart_id";

$result = mysqli_query($conn, $query);
$data_per_hari = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data_per_hari[$row['day_of_week']][] = $row;
}

// Misalnya ini dilakukan sebelum HTML
$query = "SELECT SUM(c.quantity * m.harga) AS total
          FROM cart c
          JOIN menu m ON m.id = c.menu_id
                    WHERE child_id = '$id_anak'";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total = $row['total'] ?? 0;
    $formattedTotal = number_format($total, 0, ',', '.');
} else {
    $formattedTotal = '0'; // fallback agar tidak error
}


$query_anak = "SELECT * FROM anak WHERE id = ?";
$stmt_anak = $conn->prepare($query_anak);
$stmt_anak->bind_param("i", $id_anak);
$stmt_anak->execute();
$result_anak = $stmt_anak->get_result();
$child = $result_anak->fetch_assoc();
$stmt_anak->close();

// Menghitung umur anak
$umur = date_diff(date_create($child['tanggal_lahir']), date_create('today'))->y;

// Mendapatkan data tinggi, berat, dan gender
$tinggi = $child['tinggi_cm'];
$berat = $child['berat_kg'];
$gender = $child['gender'];

// Hitung kalori ideal berdasarkan umur dan gender
if ($gender == 'P') { // CEWEK
    $kalori_ideal = ($tinggi * 3.10) + (($berat * 9.25) + 447.6) - ($umur * 4.33);
} else { // COWOK
    $kalori_ideal = ($tinggi * 4.8) + (($berat * 13.4) + 88.4) - ($umur * 5.68);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Anak per Hari</title>
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
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<h2>Pesanan Anak per Hari</h2>

<?php
// Query untuk mendapatkan total kalori per hari
$query = "
    SELECT h.day_of_week,
           COALESCE(SUM(c.kalori * c.quantity), 0) AS total_kalori
    FROM (
        SELECT 'senin' AS day_of_week
        UNION SELECT 'selasa'
        UNION SELECT 'rabu'
        UNION SELECT 'kamis'
        UNION SELECT 'jumat'
    ) AS h
    LEFT JOIN cart c ON c.day_of_week = h.day_of_week AND c.child_id = ?
    GROUP BY h.day_of_week
    ORDER BY FIELD(h.day_of_week, 'senin', 'selasa', 'rabu', 'kamis', 'jumat');
";

// Menyiapkan statement untuk mendapatkan kalori per hari
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_anak);  // Bind parameter dengan child_id
$stmt->execute();
$result = $stmt->get_result();

// Menyimpan total kalori untuk setiap hari
$kalori_per_hari = [];
while ($row = $result->fetch_assoc()) {
    $kalori_per_hari[$row['day_of_week']] = $row['total_kalori'];
}

$stmt->close();
?>

<?php foreach ($days_of_week as $day): ?>
    <div class="day-card">
        <a href="get_cart.php?day=<?= urlencode($day) ?>&id=<?= urlencode($id_anak) ?>" class="day-link">

            <div class="day-header">
                <!-- Menampilkan nama hari dan total kalori -->
                <h3>
                    <?= ucfirst($day) ?>       
                    <?php
                        // Ambil kalori per hari untuk hari ini
                        $total_kalori_hari_ini = isset($kalori_per_hari[$day]) ? $kalori_per_hari[$day] : 0;

                        // Tampilkan kalori yang sudah tercapai dibandingkan dengan kalori ideal
                        echo '<span id="total-kalori-hari-ini">' . $total_kalori_hari_ini . ' / ' . round($kalori_ideal) . ' Kalori</span>';
                    ?>
                </h3>
                <button class="lihat-detail" data-day="<?= $day ?>">Lihat Detail</button>
            </div>
        </a>

        <div class="menu-container" id="detail-<?= $day ?>">
            <?php if (isset($data_per_hari[$day]) && !empty($data_per_hari[$day])): ?>
                <!-- Jika ada menu untuk hari ini -->
                <?php foreach ($data_per_hari[$day] as $menu):
                    $options = json_decode($menu['options'], true); ?>
                    <div class="menu-card" data-cart-id="<?= $menu['cart_id'] ?>">
                        <div class="menu-image-container">
                            <img src="images/<?= htmlspecialchars($menu['gambar']) ?>" alt="<?= htmlspecialchars($menu['menu_name']) ?>">
                        </div>
                        <div class="menu-info">
                            <div class="menu-header">
                                <h4><?= htmlspecialchars($menu['menu_name']) ?></h4>
                                <div class="menu-price">Rp<?= number_format($menu['harga'], 0, ',', '.') ?></div>
                            </div>

                            <div class="menu-options">
                                <ul>
                                    <?php foreach ($options as $key => $value): ?>
                                        <li><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <p><strong>Alamat:</strong> <?php echo $menu['alamat']; ?></p>
                            <p><strong>Jam Pengiriman:</strong> <?php echo $menu['jam_pengantaran']; ?></p>

                            <?php if (!empty($menu['note'])): ?>
                                <div class="tulis"><strong>Catatan:</strong></div>
                                <div class="note-container">
                                    <textarea class="note-textarea" readonly><?= htmlspecialchars($menu['note']) ?></textarea>
                                </div>
                            <?php endif; ?>

                            <div class="quantity-control">
                                <button class="qty-btn minus">−</button>
                                <span class="qty"><?= $menu['quantity'] ?></span>
                                <button class="qty-btn plus">+</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Jika tidak ada menu untuk hari ini -->
                <p>Tidak ada menu yang dipesan</p>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<div class="checkout-bar">
    <div class="checkout-content">
        <span class="total-label">Total:</span>
        <span id="totalAmount">Rp <?php echo $formattedTotal; ?></span>
        <button class="checkout-button" onclick="checkout()">Checkout Payment</button>
    </div>
</div>
<script>
    function checkout() {

        var totalAmount = <?php echo $formattedTotal; ?>;
        var childId = <?php echo $_SESSION['selected_child_id']; ?>; // Mengambil child_id dari session PHP
        var childName = <?php echo json_encode($_SESSION['selected_child_name']); ?>; // Mengambil child_name dari session PHP
        if (totalAmount == 0) {
            // Tampilkan popup jika totalAmount adalah 0
            openPopup();
            return false; // Jangan lanjutkan proses checkout
        } else {
            // Redirect ke payment.php dengan child_id dan child_name
            var paymentUrl = 'payment.php?id=' + childId + '&name=' + encodeURIComponent(childName);
            window.location.href = paymentUrl;
        }
    }

    // Function to open the popup
    function openPopup() {
        document.getElementById('popup').style.display = 'block';
    }

    // Function to close the popup
    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }
</script>
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <img src="https://img.icons8.com/ios/452/cancel.png" alt="cancel-icon" class="popup-icon">
        <p class="popup-message">Belum ada makanan yang di pesan</p>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('.lihat-detail').on('click', function () {
        const day = $(this).data('day');
        $('#detail-' + day).slideToggle();
    });

    $('.qty-btn').on('click', function () {
        const isPlus = $(this).hasClass('plus');
        const $menuCard = $(this).closest('.menu-card');
        const cartId = $menuCard.data('cart-id');
        const $qtySpan = $menuCard.find('.qty');
        const $caloriesSpan = $menuCard.find('#total-kalori-hari-ini');
        let qty = parseInt($qtySpan.text());

        qty = isPlus ? qty + 1 : qty - 1;
        if (qty < 0) return;

        $.ajax({
            url: 'update_cart_quantity.php',
            method: 'POST',
            data: { cart_id: cartId, quantity: qty },
            success: function (response) {
                if (qty === 0) {
                    $menuCard.slideUp(function () {
                        $(this).remove();
                    });
                } else {
                    
                    $qtySpan.text(qty);
                }
                // Format dan update kalori
            const kaloriPerItem = data.kaloriPerItem; // Ambil kalori per item dari respons server
            const totalKaloriHariIni = data.totalKaloriHariIni; // Ambil total kalori hari ini dari server

            // Update tampilan kalori untuk item ini
            $menuCard.find('#total-kalori-hari-ini').text(kaloriPerItem * qty); // Misalnya, update tampilan kalori per item

            // Update total kalori hari ini di elemen dengan id total-kalori-hari-ini
            $('#total-kalori-hari-ini').text(totalKaloriHariIni + ' / ' + data.kaloriIdeal + ' Kalori');
            },
            error: function () {
                alert('Gagal memperbarui quantity.');
            }
        });
    });
</script>
<script>
document.querySelectorAll(".lihat-detail").forEach(btn => {
    btn.addEventListener("click", function(e) {
        e.stopPropagation(); // Cegah klik tombol memicu klik link
        e.preventDefault();  // Opsional: cegah default behavior

    });
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateTotalAmount() {
    $.ajax({
        url: 'hari.php?get_total=1',
        method: 'GET',
        success: function(data) {
            const formatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(data);

            $('#totalAmount').text(formatted);
        },
        error: function() {
            $('#totalAmount').text('Rp 0');
        }
    });
}

$(document).ready(function () {
    updateTotalAmount();
});

$('.qty-btn').on('click', function () {
    setTimeout(updateTotalAmount, 300); // tunggu DOM update
});
</script>



</body>
</html>
