<?php
$conn = new mysqli("localhost", "root", "Bernardo1777*", "db_dei");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'] ?? '';
    $change = (int)($_POST['change'] ?? 0);

    if ($cart_id && $change !== 0) {
        $stmt = $conn->prepare("SELECT quantity FROM cart WHERE cart_id = ?");
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$result = $stmt->get_result();
$current = $result->fetch_assoc();

if (!$current) {
    error_log("Cart ID tidak ditemukan: $cart_id");  // Tambahkan log error jika cart_id tidak ditemukan
}

        if ($current) {
            $newQty = max(1, $current['quantity'] + $change); // tidak boleh kurang dari 1

            $update = $conn->prepare("UPDATE cart SET quantity = ? WHERE cart_id = ?");
            $update->bind_param("ii", $newQty, $cart_id);
            $update->execute();

            echo json_encode(['success' => true, 'new_quantity' => $newQty]);
            exit;
        }
    }
}

echo json_encode(['success' => false]);
