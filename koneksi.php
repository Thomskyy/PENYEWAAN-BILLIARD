<?php
// koneksi.php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'billiard_herta';

$conn = new mysqli($host, $user, $pass, $db);

// Set karakter set ke UTF-8
$conn->set_charset('utf8mb4');

if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}
?>
