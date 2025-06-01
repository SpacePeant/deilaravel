<?php

session_start(); // Wajib ada sebelum akses $_SESSION

function getNextWeekdayDate(string $hari): string {
  $hariList = [
      'senin' => 1,
      'selasa' => 2,
      'rabu' => 3,
      'kamis' => 4,
      'jumat' => 5,
  ];

  $targetDay = $hariList[strtolower($hari)] ?? 1; // default ke Senin
  $now = new DateTime();
  $today = (int)$now->format('N'); // 1 = Senin

  // Langsung hitung hari target di minggu depan
  $diff = ($targetDay - $today + 7); // Selalu 7–13
  $now->modify("+$diff days");
  return $now->format('Y-m-d');
}

// Cek apakah session anak tersedia
if (!isset($_SESSION['selected_child_id']) || !isset($_SESSION['selected_child_name'])) {
    // Redirect kalau data anak belum dipilih
    header("Location: pilihanak.php");
    exit();
}

$id_anak = $_SESSION['selected_child_id'];
$nama_anak = $_SESSION['selected_child_name'];

$conn = new mysqli("localhost", "root", "MySQLISBUC2024Sean", "db_dei");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data menu beserta ID kategori
$sql = "
  SELECT m.id AS menu_id, m.nama AS menu_name, m.deskripsi AS menu_description, m.harga,
         m.gambar AS menu_image, m.category_id
  FROM menu m
  ORDER BY m.nama
";

$result = $conn->query($sql);

$menus = [];
while ($row = $result->fetch_assoc()) {
    $menus[] = [
        'id' => $row['menu_id'],
        'name' => $row['menu_name'],
        'description' => $row['menu_description'],
        'price' => $row['harga'],
        'image' => $row['menu_image'],
        'category_id' => $row['category_id']
    ];
}

// Ambil data kategori
$category_sql = "SELECT id, nama FROM category ORDER BY nama";
$category_result = $conn->query($category_sql);

$categories = [];
while ($row = $category_result->fetch_assoc()) {
    $categories[] = [
        'id_cat' => $row['id'],
        'name_cat' => $row['nama'],
    ];
}

// Fetch all menu items
$result = $conn->query("SELECT * FROM menu");
$men = [];

while ($row = $result->fetch_assoc()) {
    $menu_id = $row['id']; // Assuming 'id' is the correct column name

    // Fetch customizations for each menu item
    $stmt2 = $conn->prepare("SELECT opsi_kategori, opsi_nama FROM customizations WHERE menu_id = ?");
    $stmt2->bind_param("i", $menu_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $rows = $result2->fetch_all(MYSQLI_ASSOC);

    $customizations = [];
    foreach ($rows as $custom_row) {
        $kategori = $custom_row['opsi_kategori'];
        $opsi = $custom_row['opsi_nama'];

        if (!isset($customizations[$kategori])) {
            $customizations[$kategori] = [];
        }
        $customizations[$kategori][] = $opsi;
    }

    $men[] = [
        'id' => $row['id'],
        'name' => $row['nama'],
        'description' => $row['deskripsi'],
        'price' => $row['harga'],
        'image' => $row['gambar'],
        'category_id' => $row['category_id'],
        'customizations' => $customizations
    ];
}

$hari = $_GET['day'] ?? '';
$jamStr = $_POST['delivery_time'] ?? '07:00';
if (strlen($jamStr) === 5) $jamStr .= ':00'; // jadi "HH:MM:SS"

// Hitung tanggal minggu depan
$tanggal = getNextWeekdayDate($hari);

// Gabungkan ke format TIMESTAMP
$jam_timestamp = "$tanggal $jamStr";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu_id'])) {

  $day = $_GET['day'] ?? 'tidak diketahui';
  $menu_id = (int)$_POST['menu_id'];
  $quantity = (int)$_POST['quantity'];
  $note = $_POST['note'] ?? '';
  $alamat = $_POST['delivery_address'] ?? '';

  $customOptions = [];

  // Ambil semua input yang dimulai dengan 'custom_'
  foreach ($_POST as $key => $value) {
      if (strpos($key, 'custom_') === 0) {
          $kategori = substr($key, 7); // hilangkan 'custom_'
          $customOptions[$kategori] = $value;
      }
  }

  // Urutkan agar JSON konsisten
  ksort($customOptions);
  $options_json = json_encode($customOptions, JSON_UNESCAPED_UNICODE);

  // Pastikan variabel $id_anak sudah tersedia
  // (Jika belum, ambil dari session atau hidden input)
  // $id_anak = $_POST['child_id'] ?? $_SESSION['child_id'] ?? null;

  $check_stmt = $conn->prepare("SELECT * FROM cart WHERE child_id = ? AND day_of_week = ? AND menu_id = ? AND note = ? AND alamat = ? AND jam = ?");
  $check_stmt->bind_param("isisss", $id_anak, $day, $menu_id, $note, $alamat, $jam_timestamp);
  $check_stmt->execute();
  $result = $check_stmt->get_result();

  $cart_id = null;
$new_quantity = $quantity;

// Decode options dari user
$customOptions = json_decode($options_json, true);
ksort($customOptions);

// Hitung total kalori dari menu
$stmt_menu_kalori = $conn->prepare("SELECT kalori FROM menu WHERE id = ?");
$stmt_menu_kalori->bind_param("i", $menu_id);
$stmt_menu_kalori->execute();
$result_menu_kalori = $stmt_menu_kalori->get_result();
$row_menu_kalori = $result_menu_kalori->fetch_assoc();
$menu_kalori = (int)$row_menu_kalori['kalori'];  // Kalori yang ada di menu

$stmt_menu_kalori->close();

// Hitung total kalori dari opsi yang dipilih
$total_kalori = $menu_kalori;  // Mulai dengan kalori menu
foreach ($customOptions as $kategori => $opsi_nama) {
    $stmt_kalori = $conn->prepare("SELECT kalori FROM customizations WHERE menu_id = ? AND opsi_kategori = ? AND opsi_nama = ?");
    $stmt_kalori->bind_param("iss", $menu_id, $kategori, $opsi_nama);
    $stmt_kalori->execute();
    $result_kalori = $stmt_kalori->get_result();
    if ($row_kalori = $result_kalori->fetch_assoc()) {
        $total_kalori += (int)$row_kalori['kalori'];  // Tambahkan kalori kustomisasi
    }
    $stmt_kalori->close();
}

// Cek apakah sudah ada item serupa
$result = $conn->query("SELECT * FROM cart WHERE child_id = $id_anak AND day_of_week = '$day' AND menu_id = $menu_id");
while ($row = $result->fetch_assoc()) {
    $existing_options = json_decode($row['options'], true);
    ksort($existing_options);
    if ($existing_options === $customOptions) {
        $cart_id = $row['cart_id'];
        $new_quantity += $row['quantity'];
        break;
    }
}

if ($cart_id !== null) {
    // Update quantity dan total kalori (dikalikan jumlah)
    $kalori_total_update = $total_kalori * $new_quantity;
    $update_stmt = $conn->prepare("UPDATE cart SET quantity = ?, kalori = ? WHERE cart_id = ?");
    $update_stmt->bind_param("iii", $new_quantity, $kalori_total_update, $cart_id);
    $update_stmt->execute();
    $update_stmt->close();
} else {
    // Insert baru dengan total kalori
    $kalori_total_insert = $total_kalori * $quantity;
    $insert_stmt = $conn->prepare("INSERT INTO cart (child_id, day_of_week, menu_id, options, quantity, note, alamat, jam, kalori) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $insert_stmt->bind_param("isisisssi", $id_anak, $day, $menu_id, $options_json, $quantity, $note, $alamat, $jam_timestamp, $kalori_total_insert);
    $insert_stmt->execute();
    $insert_stmt->close();
}

  $check_stmt->close();
  $conn->close();

  // Redirect atau tampilkan notifikasi
  header("Location: hari.php?success=1");
  exit;
}

$ha = $_GET['day'] ?? '';
$day = strtolower(trim($ha));
$menu_id = $_GET['menu_id'] ?? null;

$query = "
    SELECT c.menu_id as aidi, c.cart_id, c.day_of_week, c.quantity, c.note, m.nama AS menu_name, m.harga, m.gambar, c.options, c.alamat as alamat, DATE_FORMAT(c.jam, '%e %M %Y') AS tanggal_pengantaran,
    CONCAT(DATE_FORMAT(c.jam, '%H:%i'),' WIB') AS jam_pengantaran
    FROM cart c
    JOIN menu m ON c.menu_id = m.id
    WHERE c.child_id = $id_anak
    AND c.day_of_week = '$day' 
    ORDER BY c.cart_id";  

$result = mysqli_query($conn, $query);
$data_per_hari = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data_per_hari[$row['day_of_week']][] = $row;
}




$result = $conn->query("SELECT * FROM customizations");
$customizations_by_menu = [];

while ($row = $result->fetch_assoc()) {
    $menu_id = $row['menu_id'];
    $kategori = $row['opsi_kategori'];
    $opsi = $row['opsi_nama'];
    $kalori = $row['kalori'];

    if (!isset($customizations_by_menu[$menu_id])) {
        $customizations_by_menu[$menu_id] = [];
    }

    if (!isset($customizations_by_menu[$menu_id][$kategori])) {
        $customizations_by_menu[$menu_id][$kategori] = [];
    }

    $customizations_by_menu[$menu_id][$kategori][] = [
        'opsi_nama' => $opsi,
        'kalori' => $kalori
    ];
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Menu</title>
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
<body class="container mt-4">
<a href="javascript:history.back()" class="back-button">← Back</a>
<section class="menu-section">
    <h2>Paket Menu</h2>

  <!-- Filter Buttons -->
  <div class="filters">
    <button class="filter-btn active" data-filter="all">Semua</button>
    <?php foreach ($categories as $category): ?>
      <button class="filter-btn" data-filter="<?php echo htmlspecialchars($category['id_cat']); ?>">
        <?php echo htmlspecialchars($category['name_cat']); ?>
      </button>
    <?php endforeach; ?>
  </div>

  <!-- Menu Cards -->
    <div class="menu-grid">
    <?php foreach ($men as $index => $menu): ?>
    <?php
    // Hitung jumlah item menu ini dalam cart
    $stmt = $conn->prepare("
        SELECT COUNT(*) AS jumlah 
        FROM cart c
        WHERE c.child_id = ? AND c.day_of_week = ? AND c.menu_id = ?
    ");
    $ha = $_GET['day'] ?? '';
    $day = strtolower(trim($ha));
    $stmt->bind_param("isi", $id_anak, $day, $menu['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $jumlah = ($row = $result->fetch_assoc()) ? $row['jumlah'] : 0;
    ?>
    
    <!-- Tombol Menu / Card -->
    <div class="menu-card" data-category="<?= htmlspecialchars($menu['category_id']) ?>">
        <div class="plate-image">
            <img src="images/<?= htmlspecialchars($menu['image']) ?>" alt="<?= htmlspecialchars($menu['name']) ?>" />
            
            <?php if ($jumlah > 0): ?>
              <button class="jum" data-id="<?= $menu['id'] ?>"
              data-bs-toggle="modal" data-bs-target="#modalCart"><?= $jumlah ?> item</button>
            <?php endif; ?>
        </div>
        <div>
            <h3><?= htmlspecialchars($menu['name']) ?></h3>
            <p><?= htmlspecialchars($menu['description']) ?></p>
            <p><strong>Rp <?= htmlspecialchars(number_format($menu['price'], 0, ',', '.')) ?></strong></p>
            <button class="detail-btn" data-bs-toggle="modal" data-bs-target="#modal<?= $index ?>">Tambah</button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal<?= $index ?>" tabindex="-1" aria-labelledby="modalLabel<?= $index ?>" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel<?= $index ?>">Kustomisasi - <?= htmlspecialchars($menu['name']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach ($menu['customizations'] as $kategori => $opsiList): ?>
                        <div class="mb-3">
                            <label class="form-label"><?= htmlspecialchars($kategori) ?></label>
                            <select name="custom_<?= htmlspecialchars($kategori) ?>" class="form-select" required>
                                <option value="">Pilih opsi</option>
                                <?php foreach ($opsiList as $opsi): ?>
                                    <option value="<?= htmlspecialchars($opsi) ?>"><?= htmlspecialchars($opsi) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endforeach; ?>

                    <div class="mb-3">
                        <label class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control" name="note" rows="2" placeholder="Contoh: tanpa timun, pedas banget, lombok dipisah"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Pengantaran</label>
                        <textarea class="form-control" name="delivery_address" rows="2" required placeholder="Masukkan alamat lengkap..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jam Pengantaran</label>
                        <select class="form-select" name="delivery_time" required>
                            <option value="">Pilih Jam</option>
                            <option value="07:00">07:00 WIB</option>
                            <option value="12:00">12:00 WIB</option>
                            <option value="18:00">18:00 WIB</option>
                        </select>
                    </div>

                    <input type="hidden" name="name" value="<?= htmlspecialchars($menu['name']) ?>">
                    <input type="hidden" name="image" value="<?= htmlspecialchars($menu['image']) ?>">
                    <input type="hidden" name="price" value="<?= (int)$menu['price'] ?>">
                    <input type="hidden" name="day" value="<?= htmlspecialchars($day) ?>">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                    <input type="hidden" name="child_id" value="<?= $id_anak ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-success">Tambah ke Pesanan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Cart Details -->
<?php if (isset($data_per_hari[$day]) && !empty($data_per_hari[$day])): ?>
<div class="modal fade" id="modalCart" tabindex="-1" aria-labelledby="modalCartLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCartLabel">Detail Menu Hari <?= ucfirst($day) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <!-- Input Hidden untuk Menu ID -->
                <input type="hidden" id="modalMenuId" value="">

                <?php foreach ($data_per_hari[$day] as $cartItem): 
                    // Pastikan $cartItem['aidi'] dibandingkan dengan nilai menu_id yang dipassing
                    ?>
                    <div class="menu-kotak" data-cart-id="<?= $cartItem['aidi'] ?>">
                        <div class="menu-image-cont">
                            <img src="images/<?= htmlspecialchars($cartItem['gambar']) ?>" alt="<?= htmlspecialchars($cartItem['menu_name']) ?>">
                        </div>
                        <div class="menu-inf">
                            <div class="menu-head">
                                <h4><?= htmlspecialchars($cartItem['menu_name']) ?></h4>
                                <div class="menu-pri">Rp <?= number_format($cartItem['harga'], 0, ',', '.') ?></div>
                            </div>

                            <div class="menu-opt">
                                <ul>
                                    <?php 
                                    // Mengambil dan menampilkan opsi kustomisasi
                                    $options = json_decode($cartItem['options'], true);
                                    foreach ($options as $key => $value): ?>
                                        <li><strong><?= htmlspecialchars($key) ?>:</strong> <?= htmlspecialchars($value) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                            <p><strong>Alamat:</strong> <?= htmlspecialchars($cartItem['alamat']) ?></p>
                            <p><strong>Jam Pengiriman:</strong> <?= htmlspecialchars($cartItem['jam_pengantaran']) ?></p>

                            <?php if (!empty($cartItem['note'])): ?>
                                <div class="tulis"><strong>Catatan:</strong></div>
                                <div class="note-container">
                                    <textarea class="note-textarea" readonly><?= htmlspecialchars($cartItem['note']) ?></textarea>
                                </div>
                            <?php endif; ?>

                            <div class="menu-ki" data-cart-id="<?= $cartItem['cart_id'] ?>">
                              <div class="quantity-control">
                                  <button class="qty-btn minus">−</button>
                                  <span class="qty"><?= $cartItem['quantity'] ?></span>
                                  <button class="qty-btn plus">+</button>
                              </div>
                          </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php endforeach; ?>

    </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".menu-ki").forEach(function (menuBox) {
    const cartId = menuBox.getAttribute("data-cart-id");

    // Debugging log untuk memastikan cartId didapatkan
    console.log(cartId);  // Periksa apakah cartId benar-benar ada

    const qtySpan = menuBox.querySelector(".qty");

    menuBox.querySelector(".qty-btn.plus").addEventListener("click", function () {
        updateQuantity(cartId, 1, qtySpan);
    });

    menuBox.querySelector(".qty-btn.minus").addEventListener("click", function () {
        updateQuantity(cartId, -1, qtySpan);
    });
});
    function updateQuantity(cartId, change, qtySpan) {
        fetch("update_quantity.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `cart_id=${cartId}&change=${change}`
        })
        .then(res => res.json())
.then(data => {
    console.log(data);  // Debugging response
    if (data.success) {
        qtySpan.textContent = data.new_quantity;
    } else {
        alert("Gagal mengupdate jumlah.");
    }
});
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const jumButtons = document.querySelectorAll(".jum");

    jumButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const menuId = this.getAttribute("data-id");

            // Set ke input hidden (jika dibutuhkan)
            const modalMenuIdInput = document.getElementById("modalMenuId");
            if (modalMenuIdInput) {
                modalMenuIdInput.value = menuId;
            }

            // Seleksi semua elemen menu-kotak
            const allMenus = document.querySelectorAll(".menu-kotak");
            allMenus.forEach(function (menu) {
                const cartMenuId = menu.getAttribute("data-cart-id");

                // Tampilkan hanya yang cocok
                if (cartMenuId === menuId) {
                    menu.style.display = "flex"; // atau "block" tergantung layout kamu
                } else {
                    menu.style.display = "none";
                }
            });
        });
    });
});

</script>

  <!-- Filter Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const filterButtons = document.querySelectorAll('.filter-btn');

      filterButtons.forEach(button => {
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
    });
  </script>

<script>
document.addEventListener("DOMContentLoaded", function() {
  const buttons = document.querySelectorAll(".btn-view-cart-item");

  buttons.forEach(button => {
    button.addEventListener("click", function() {
      document.getElementById("modalMenuName").textContent = this.dataset.menu;
      document.getElementById("modalQty").textContent = this.dataset.qty;

      // Options
      const optionsList = document.getElementById("modalOptions");
      optionsList.innerHTML = "";
      try {
        const options = JSON.parse(this.dataset.options);
        for (const key in options) {
          const li = document.createElement("li");
          li.textContent = `${key}: ${options[key]}`;
          optionsList.appendChild(li);
        }
      } catch (e) {
        optionsList.innerHTML = "<li>(tidak ada opsi)</li>";
      }

      // Alamat, jam, dan note
      document.getElementById("modalAlamat").textContent = this.dataset.alamat;
      document.getElementById("modalJam").textContent = this.dataset.jam;
      document.getElementById("modalNote").value = this.dataset.note || "(Tidak ada catatan)";
    });
  });
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  document.querySelectorAll(".menu-kotak").forEach(menuBox => {
    const cartId = menuBox.dataset.cartId;
    const minusBtn = menuBox.querySelector(".qty-btn.minus");
    const plusBtn = menuBox.querySelector(".qty-btn.plus");
    const qtySpan = menuBox.querySelector(".qty");

    minusBtn.addEventListener("click", () => {
      let qty = parseInt(qtySpan.textContent);
      if (qty > 1) {
        qty--;
        qtySpan.textContent = qty;
      }
    });

    plusBtn.addEventListener("click", () => {
      let qty = parseInt(qtySpan.textContent);
      qty++;
      qtySpan.textContent = qty;
    });
  });
});
</script>
</body>
</html>

