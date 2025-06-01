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
