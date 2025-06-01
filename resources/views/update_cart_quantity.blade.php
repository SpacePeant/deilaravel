<?php
$conn = new mysqli("localhost", "root", "Bernardo1777*", "db_dei");

if ($conn->connect_error) {
    http_response_code(500);
    exit("Koneksi gagal");
}

$cart_id = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

if ($cart_id === 0) {
    http_response_code(400);
    exit("Data tidak valid");
}

if ($quantity > 0) {
    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
    $stmt->bind_param("ii", $quantity, $cart_id);
} else {
    $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = ?");
    $stmt->bind_param("i", $cart_id);
}

if ($stmt->execute()) {
    echo "OK";
} else {
    http_response_code(500);
    echo "Gagal";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartId = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    // Update data quantity di database
    // (Contoh query, sesuaikan dengan struktur database Anda)
    $query = "UPDATE cart SET quantity = ? WHERE cart_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ii', $quantity, $cartId);
    $stmt->execute();
    
    // Dapatkan kalori per item (misalnya $kalori_per_item diambil dari database atau variabel PHP)
    $kalori_per_item = 100; // Ganti dengan nilai kalori yang sesuai

    // Hitung kalori total
    $totalKalori = $kalori_per_item * $quantity;

    // Kembalikan kalori baru jika diperlukan
    echo json_encode(['kalori' => $totalKalori]);
}

