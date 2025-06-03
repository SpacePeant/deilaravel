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

if (isset($_GET['id'])) {
    $childId = $_GET['id'];
    // Proses ID anak di sini
    echo "Child ID: " . $childId;
}

$conn = new mysqli("localhost", "root", "Bernardo1777*", "db_dei");
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

$days_with_orders = array_keys($data_per_hari);

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $totalQuery = $conn->prepare("SELECT SUM(harga * quantity) AS total FROM cart c join menu m on m.id = c.menu_id WHERE child_id = ?");
$totalQuery->bind_param("i", $id_anak);
$totalQuery->execute();
$totalResult = $totalQuery->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalAmount = $totalRow['total'] ?? 0;

// 2. Insert ke tabel od
$insertOD = $conn->prepare("INSERT INTO od (total) VALUES (?)");
$insertOD->bind_param("i", $totalAmount);
$insertOD->execute();
$od_id = $insertOD->insert_id; // Ambil id dari od yang baru dimasukkan

// 3. Ambil semua cart untuk anak ini
$cartQuery = $conn->prepare("SELECT * FROM cart WHERE child_id = ?");
$cartQuery->bind_param("i", $id_anak);
$cartQuery->execute();
$cartResult = $cartQuery->get_result();

while ($row = $cartResult->fetch_assoc()) {
    // 4. Masukkan tiap item ke orders
    $insertOrder = $conn->prepare("INSERT INTO orders 
        (child_id, day_of_week, menu_id, options, quantity, note, alamat, kalori, jam, od_id)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $insertOrder->bind_param(
        "isisissisi",
        $row['child_id'],
        $row['day_of_week'],
        $row['menu_id'],
        $row['options'],
        $row['quantity'],
        $row['note'],
        $row['alamat'],
        $row['kalori'],
        $row['jam'],
        $od_id
    );

    $insertOrder->execute();
}

// 5. Hapus cart setelah berhasil
$deleteCart = $conn->prepare("DELETE FROM cart WHERE child_id = ?");
$deleteCart->bind_param("i", $id_anak);
$deleteCart->execute();

    // Tampilkan popup sukses nanti
    $_SESSION['payment_success'] = true;
    header("Location: payment.php");
    exit();
}

if (isset($_SESSION['payment_success']) && $_SESSION['payment_success']) {
    echo "<script>
        window.onload = function() {
            document.getElementById('successPopup').style.display = 'block';
        };
    </script>";
    unset($_SESSION['payment_success']);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Anak per Hari</title>
    
</head>
<body>
<?php include 'header.php'; ?>
<a href="javascript:history.back()" class="back-button">← Back</a>
<h2>Detail Pesanan</h2>

<?php
// Query untuk mendapatkan total kalori per hari
$query = "
    SELECT h.day_of_week,
           COALESCE(SUM(c.kalori), 0) AS total_kalori
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

<?php foreach ($days_with_orders as $day): ?>
    <div class="day-card">
        <div class="day-header">
            <!-- Menampilkan nama hari dan total kalori -->
            <h3>
                <?= ucfirst($day) ?>       
                <?php
                    // Ambil kalori per hari untuk hari ini
                    $total_kalori_hari_ini = isset($kalori_per_hari[$day]) ? $kalori_per_hari[$day] : 0;

                    // Tampilkan kalori yang sudah tercapai dibandingkan dengan kalori ideal
                    echo $total_kalori_hari_ini . " / " . round($kalori_ideal) . " Kalori";
                ?>
            </h3>
        </div>

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
                                <span class="qty"><?= $menu['quantity'] ?>x</span>
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

<!-- Ringkasan Pembayaran -->
<div class="container mt-4" id="pem">
  <div class="summary-card">
    <div class="summary-title">Ringkasan Pembayaran</div>
    <div class="summary-text">Total yang harus dibayar:</div>
    <div class="summary-total">
    <span id="totalAmount">Rp <?php echo $formattedTotal; ?></span>
    </div>
  </div>
</div>

<div class="checkout-bar">
    <div class="checkout-content">
        <span class="total-label">Total:</span>
        <span id="totalAmount">Rp <?php echo $formattedTotal; ?></span>
        <button class="checkout-button" onclick="document.getElementById('paymentForm').submit();">
    Bayar Sekarang
</button>
    </div>
</div>

<!-- Success Pop-up -->
<div id="successPopup" class="popup">
    <div class="popup-content">
        <span class="checkmark">&#10004;</span>
        <h2>Order Berhasil!</h2>
        <p>Terima kasih telah berbelanja!</p>
        <div class="popup-buttons">
            <button class="see-order-details" onclick="window.location.href='order_details.php'">Lihat Rincian Pesanan</button>
            <button class="back-home" onclick="window.location.href='home.php'">Kembali ke Beranda</button>
        </div>
    </div>
</div>

<div class="container">
  <h2>Pilih Metode Pembayaran</h2>
  <div class="grid">

  <label class="payment-option">
  <input type="radio" name="payment" checked>
  <img src="pay/BCA1.png" alt="BCA">
  <span>Bank BCA</span>
</label>

<label class="payment-option">
  <input type="radio" name="payment">
  <img src="pay/logo-mandiri.png" alt="Mandiri">
  <span>Bank Mandiri</span>
</label>

<label class="payment-option">
  <input type="radio" name="payment">
  <img src="pay/BRI1.png" alt="BRI">
  <span>Bank BRI</span>
</label>

<label class="payment-option">
  <input type="radio" name="payment">
  <img src="pay/BNI1.png" alt="BNI">
  <span>Bank BNI</span>
</label>

<label class="payment-option">
  <input type="radio" name="payment">
  <img src="pay/QRIS1.png" alt="QRIS">
  <span>QRIS</span>
</label>

<label class="payment-option">
  <input type="radio" name="payment">
  <img src="pay/Shopeepay1.png" alt="ShopeePay">
  <span>ShopeePay</span>
</label>

<label class="payment-option">
  <input type="radio" name="payment">
  <img src="pay/gopay.png" alt="GoPay">
  <span>GoPay</span>
</label>

<label class="payment-option">
  <input type="radio" name="payment">
  <img src="pay/OVO1.png" alt="OVO">
  <span>OVO</span>
</label>

<label class="payment-option">
  <input type="radio" name="payment">
  <img src="pay/dana1.png" alt="Dana">
  <span>Dana</span>
</label>
<div class="tes"></div>

<form id="paymentForm" method="POST" action="payment.php" style="display: none;"></form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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

function showSuccessPopup() {
    // Show the success popup
    document.getElementById("successPopup").style.display = "flex";
}

function closePopup() {
    // Close the popup
    document.getElementById("successPopup").style.display = "none";
}

</script>



</body>
</html>
