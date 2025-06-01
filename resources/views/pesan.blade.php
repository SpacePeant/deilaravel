<?php
// pesan.php
$paket_id = $_GET['paket'] ?? '';
$day = $_GET['day'] ?? 'tidak diketahui';

$menu_data = json_decode(file_get_contents('paket_menu.json'), true);
$selected_paket = null;

foreach ($menu_data as $paket) {
    if ($paket['id'] === $paket_id) {
        $selected_paket = $paket;
        break;
    }
}

if (!$selected_paket) {
    echo "<h2>Paket tidak ditemukan.</h2>";
    exit;
}

// Proses form jika ada POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['name'];
    $image = $_POST['image'];
    $price = (int) $_POST['price'];
    $quantity = (int) $_POST['quantity'] ?? 1;
    $note = $_POST['note'] ?? '';
    $minuman = $_POST['minuman'] ?? 'Air Putih';
    $day_post = $_POST['day'] ?? 'tidak diketahui';

    // Ambil opsi kustomisasi
    $options = [];
    foreach ($_POST as $key => $value) {
        if (!in_array($key, ['name', 'image', 'price', 'note', 'quantity', 'minuman', 'day'])) {
            $options[$key] = $value;
        }
    }

    // Bangun struktur item
    $new_item = [
        "name" => $item_name,
        "image" => $image,
        "price" => $price,
        "options" => $options,
        "quantity" => $quantity,
        "minuman" => $minuman,
        "note" => $note
    ];

    // Baca cart.json
    $cart_file = 'cart.json';
    $cart = file_exists($cart_file) ? json_decode(file_get_contents($cart_file), true) : [];

    // Tambahkan item ke hari yang sesuai
    if (!isset($cart[$day_post])) {
        $cart[$day_post] = [];
    }

    $cart[$day_post][] = $new_item;

    // Simpan kembali
    file_put_contents($cart_file, json_encode($cart, JSON_PRETTY_PRINT));

    // Redirect atau notifikasi
    echo "<script>alert('Pesanan ditambahkan ke $day_post!'); window.location.href='pesan.php?paket=$paket_id&day=$day_post';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesan - <?= htmlspecialchars($selected_paket['nama']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container py-4">
    <h2><?= htmlspecialchars($selected_paket['nama']) ?></h2>
    <p><?= htmlspecialchars($selected_paket['deskripsi']) ?></p>
    <h4>Hari yang dipilih: <?= htmlspecialchars($day) ?></h4>
    <div class="row">
        <?php foreach ($selected_paket['menu'] as $index => $menu): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="<?= htmlspecialchars($menu['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($menu['nama']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($menu['nama']) ?></h5>
                        <p class="card-text">Rp<?= number_format($menu['harga'], 0, ',', '.') ?></p>
                        <p><?= htmlspecialchars($menu['deskripsi']) ?></p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal<?= $index ?>">Pilih</button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modal<?= $index ?>" tabindex="-1" aria-labelledby="modalLabel<?= $index ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel<?= $index ?>">Kustomisasi - <?= htmlspecialchars($menu['nama']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <?php foreach ($menu['customizations'] as $label => $options): ?>
                                <div class="mb-3">
                                    <label class="form-label"><?= htmlspecialchars($label) ?></label>
                                    <select class="form-select" name="<?= htmlspecialchars($label) ?>" required>
                                        <?php foreach ($options as $option): ?>
                                            <option value="<?= htmlspecialchars($option) ?>"><?= htmlspecialchars($option) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php endforeach; ?>

                            <div class="mb-3">
                                <label class="form-label">Catatan Tambahan</label>
                                <textarea class="form-control" name="note" rows="2" placeholder="Contoh: tanpa timun, pedas banget, lombok dipisah"></textarea>
                            </div>

                            <!-- Hidden fields -->
                            <input type="hidden" name="name" value="<?= htmlspecialchars($menu['nama']) ?>">
                            <input type="hidden" name="image" value="<?= htmlspecialchars($menu['gambar']) ?>">
                            <input type="hidden" name="price" value="<?= (int)$menu['harga'] ?>">
                            <input type="hidden" name="day" value="<?= htmlspecialchars($day) ?>">
                            <input type="hidden" name="quantity" value="1">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Tambah ke Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
