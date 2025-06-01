<?php
// Koneksi ke database MySQL
$servername = "localhost";
$username = "root";  // Ganti dengan username MySQL Anda
$password = "MySQLISBUC2024Sean";      // Ganti dengan password MySQL Anda
$dbname = "db_dei";  // Nama database

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Query untuk mengambil data anak
$sql = "SELECT * FROM anak WHERE 1"; // Mengambil semua data anak
$result = $conn->query($sql);

// Cek apakah ada data anak
$children = [];
if ($result->num_rows > 0) {
    // Simpan data anak ke dalam array
    while($row = $result->fetch_assoc()) {
        $children[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();
?>
