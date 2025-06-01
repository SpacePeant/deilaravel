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

$conn = new mysqli("localhost", "root", "MySQLISBUC2024Sean", "db_dei");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$days_of_week = ['senin', 'selasa', 'rabu', 'kamis', 'jumat'];

// Query untuk mengambil data cart berdasarkan child_id yang dipilih
$query = "
    SELECT c.order_id,a.nama, c.day_of_week, c.quantity, c.note, m.nama AS menu_name, m.harga, m.gambar, c.options, c.alamat as alamat, DATE_FORMAT(c.jam, '%e %M %Y') AS tanggal_pengantaran,
  CONCAT(DATE_FORMAT(c.jam, '%H:%i'),' WIB') AS jam_pengantaran
    FROM orders c
    JOIN menu m ON c.menu_id = m.id
    JOIN anak a ON c.child_id = a.id
    ORDER BY FIELD(c.day_of_week, 'senin', 'selasa', 'rabu', 'kamis', 'jumat'), c.order_id";

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


// Misalnya, data anak baru sudah dimasukkan dan memiliki $id_anak
$query_anak = "SELECT * FROM anak WHERE id = ?";
$stmt_anak = $conn->prepare($query_anak);
$stmt_anak->bind_param("i", $id_anak);
$stmt_anak->execute();
$result_anak = $stmt_anak->get_result();
$child = $result_anak->fetch_assoc();
$stmt_anak->close();

// Pastikan anak baru sudah ada
if ($child) {
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

    // Outputkan kalori ideal
    echo "Kalori ideal untuk anak ini: " . round($kalori_ideal);
} else {
    echo "Anak dengan ID tersebut tidak ditemukan.";
}


$query = "SELECT * FROM cart WHERE child_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_anak);
$stmt->execute();
$result = $stmt->get_result();

$ordersInserted = 0;
while ($row = $result->fetch_assoc()) {
    $menuId = $row['menu_id'];
    $options = $row['options']; // diasumsikan sudah dalam bentuk JSON
    $quantity = $row['quantity'];
    $note = $row['note'];
    $alamat = $row['alamat'];
    $kalori = $row['kalori'];
    $day = $row['day_of_week']; // senin/jumat dst
    $jam = date('Y-m-d H:i:s'); // timestamp saat ini

    $insert = $conn->prepare("
        INSERT INTO orders (child_id, day_of_week, menu_id, options, quantity, note, alamat, kalori, jam)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $insert->bind_param("isisissis", $id_anak, $day, $menuId, $options, $quantity, $note, $alamat, $kalori, $jam);
    $insert->execute();

    if ($insert->affected_rows > 0) {
        $ordersInserted++;
    }
}

// Hapus isi cart jika semua sudah dipindahkan
if ($ordersInserted > 0) {
    $delete = $conn->prepare("DELETE FROM cart WHERE child_id = ?");
    $delete->bind_param("i", $id_anak);
    $delete->execute();
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
.child-wrapper{
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
.day-card {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 16px 24px;
    margin-bottom: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    margin-left: 50px;
    margin-right: 50px;
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

.child-header img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        margin-bottom: 20px;
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
    </style>
</head>
<body>
<?php include 'header.php'; ?>
<h2>Detail Pesanan</h2>

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
$query = $conn->prepare("
    SELECT o.*, 
           m.nama AS menu_name, m.harga, m.gambar, 
           a.nama AS child_name, a.gender, a.tanggal_lahir, a.tinggi_cm, a.berat_kg
    FROM orders o
    JOIN menu m ON o.menu_id = m.id
    JOIN anak a ON o.child_id = a.id
    ORDER BY o.od_id, o.child_id, FIELD(o.day_of_week, 'senin', 'selasa', 'rabu', 'kamis', 'jumat')
");
$query->execute();
$result = $query->get_result();

$data = [];
$kalori = [];
$kalori_ideal = [];

while ($row = $result->fetch_assoc()) {
    $od = $row['od_id'];
    $child = $row['child_id'];
    $day = $row['day_of_week'];

    // Hitung umur dari tanggal lahir
    $tanggal_lahir = $row['tanggal_lahir'];
    $umur = date_diff(date_create($tanggal_lahir), date_create('today'))->y;

    // Hitung kalori ideal jika belum dihitung
    if (!isset($kalori_ideal[$child])) {
        $tinggi = $row['tinggi_cm'];
        $berat = $row['berat_kg'];
        $gender = strtolower($row['gender']);

        if ($gender === 'p') {
            $ideal = ($tinggi * 3.10) + (($berat * 9.25) + 447.6) - ($umur * 4.33);
        } else {
            $ideal = ($tinggi * 4.8) + (($berat * 13.4) + 88.4) - ($umur * 5.68);
        }

        $kalori_ideal[$child] = round($ideal);
    }

    $data[$od][$child][$day][] = $row;
    $kalori[$od][$child][$day] = ($kalori[$od][$child][$day] ?? 0) + $row['kalori'];
}

?>

<?php foreach ($data as $od_id => $children): ?>
    <?php
        // Ambil tanggal pertama dan terakhir dari data
        $firstDate = null;
        $lastDate = null;

        foreach ($children as $days) {
            foreach ($days as $menus) {
                foreach ($menus as $menu) {
                    $jam = $menu['jam'];
                    if (!$firstDate || $jam < $firstDate) $firstDate = $jam;
                    if (!$lastDate || $jam > $lastDate) $lastDate = $jam;
                }
            }
        }

        // Format tanggal
        $tanggal_awal = date('d M', strtotime($firstDate));
        $tanggal_akhir = date('d M', strtotime($lastDate));
        
    ?>
    <div class="order-wrapper">
        <h2>Pesanan <?= $tanggal_awal ?> - <?= $tanggal_akhir ?></h2>

        <?php foreach ($children as $child_id => $days): ?>
            <?php
    $child_data = $days[array_key_first($days)][0];
    $child_name = $child_data['child_name'];
    $gender = strtoupper($child_data['gender']); // pastikan huruf besar
    $foto = $child_data['gender'] === 'L' ? 'imganak/cowok.png' : 'imganak/cewek.png';
?>
            <div class="child-wrapper">
                <div class="child-header" style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="<?= $foto ?>" alt="Foto Anak" width="50" height="50" style="border-radius: 50%;">
                        <h3><?= htmlspecialchars($child_name) ?></h3>
                    </div>

                    <!-- Tombol untuk buka modal -->
                    <button onclick="openModal('modal-<?= $od_id ?>-<?= $child_id ?>')" class="btn-detail">Cek Detail Pesanan</button>
                </div>
                <?php foreach ($days as $day => $menus): ?>
                    <div class="day-card">
                        <div class="day-header" style="display: flex; justify-content: space-between; align-items: center;">
                            <h4>
                                <?= ucfirst($day) ?> - 
                                <?= $kalori[$od_id][$child_id][$day] ?? 0 ?> / 
                                <?= $kalori_ideal[$child_id] ?? '?' ?> Kalori
                            </h4>
                            <span><?= date('d M Y', strtotime($menus[0]['jam'])) ?></span>
                        </div>

                        <div class="menu-container" id="detail-<?= $day ?>">
                            <?php foreach ($menus as $menu): ?>
                                <?php $options = json_decode($menu['options'], true); ?>
                                <div class="menu-card" data-cart-id="<?= $menu['order_id'] ?>">
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

                                        <p><strong>Alamat:</strong> <?= htmlspecialchars($menu['alamat']) ?></p>
                                        <p><strong>Jam Pengiriman:</strong> <?= date('H:i', strtotime($menu['jam'])) ?></p>

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
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <!-- Modal tersembunyi -->
    <div class="modal" id="modal-<?= $od_id ?>-<?= $child_id ?>" style="display: none; position: fixed; top: 0; left:0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
                    <div class="modal-content" style="background: white; padding: 20px; margin: 10% auto; width: 90%; max-width: 400px; border-radius: 10px; position: relative;">
                        <span class="close" onclick="closeModal('modal-<?= $od_id ?>-<?= $child_id ?>')" style="position: absolute; top: 10px; right: 15px; cursor: pointer;">&times;</span>
                        
                        <h4>Detail Pesanan</h4>
                        <p><strong>Status Pembayaran:</strong> <?= $child_data['payment_status'] ?? 'Pending' ?></p>
                        <p><strong>Tanggal Sampai:</strong> <?= isset($child_data['tanggal_sampai']) ? date('d M Y', strtotime($child_data['tanggal_sampai'])) : 'Belum sampai' ?></p>

                        <?php if (!empty($child_data['bukti_foto'])): ?>
                            <p><strong>Bukti Kurir:</strong></p>
                            <img src="bukti_kurir/<?= $child_data['bukti_foto'] ?>" alt="Bukti Kurir" style="max-width: 100%; border-radius: 8px;">
                        <?php else: ?>
                            <p><em>Belum ada bukti kurir</em></p>
                        <?php endif; ?>
                    </div>
                </div>
<?php endforeach; ?>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'block';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
</script>


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
