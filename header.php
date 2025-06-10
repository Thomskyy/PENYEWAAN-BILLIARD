<?php
// koneksi.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'billiard_herta';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}


// 🔁 AUTO CLEAR: Update status meja dan hapus transaksi yang selesai
$expired = $conn->query("SELECT * FROM transaksi WHERE waktu_selesai < NOW()");
while ($row = $expired->fetch_assoc()) {
    $id_meja = $row['id_meja'];
    $id_transaksi = $row['id_transaksi'];
    $conn->query("UPDATE meja SET status='kosong' WHERE id_meja=$id_meja");
    $conn->query("DELETE FROM transaksi WHERE id_transaksi=$id_transaksi");
}
?>

<!-- header.php -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #2c2f48;">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">Billiard Herta's Pocket Dimension</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Data Meja</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tambah_pelanggan.php">Data Pelanggan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="transaksi.php">Transaksi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="laporan.php">Laporan</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <span class="navbar-text me-3 text-light">
            <i class="fa fa-user"></i> <?= isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>
          </span>
        </li>
        <li class="nav-item">
          <a class="nav-link text-danger" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
