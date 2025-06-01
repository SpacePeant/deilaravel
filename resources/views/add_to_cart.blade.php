<?php
// add_to_cart.php

$day = $_POST['day'] ?? 'tidak diketahui';
$menu_name = $_POST['menu_name'] ?? '';
$menu_image = $_POST['menu_image'] ?? '';
$menu_price = (int)($_POST['menu_price'] ?? 0);
$quantity = (int)($_POST['quantity'] ?? 1);
$note = $_POST['note'] ?? '';
$options = [];
$minuman = null;

// Ambil semua inputan custom_*
foreach ($_POST as $key => $value) {
    if (strpos($key, 'custom_') === 0) {
        $label = substr($key, 7); // hapus 'custom_' prefix
        $options[$label] = $value;
    }
    if ($key === 'custom_Minuman' || strtolower($key) === 'custom_minuman') {
        $minuman = $value;
    }
}

$cart = file_exists('cart.json') ? json_decode(file_get_contents('cart.json'), true) : [];

$new_order = [
    "name" => $menu_name,
    "image" => $menu_image,
    "price" => $menu_price,
    "options" => $options,
    "quantity" => $quantity,
    "note" => $note
];

if ($minuman) {
    $new_order['minuman'] = $minuman;
}

if (!isset($cart[$day])) {
    $cart[$day] = [];
}

$cart[$day][] = $new_order;

// Simpan kembali ke file
file_put_contents('cart.json', json_encode($cart, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

echo json_encode(["success" => true]);
