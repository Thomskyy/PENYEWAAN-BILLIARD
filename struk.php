<?php
include 'koneksi.php';


if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("ID transaksi tidak ditemukan.");
}

$id = (int)$_GET['id'];

$sql = "SELECT t.*, p.nama AS nama_pelanggan, m.nomor_meja
        FROM transaksi t
        JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
        JOIN meja m ON t.id_meja = m.id_meja
        WHERE t.id_transaksi = $id";


$result = $conn->query($sql);

if (!$result || $result->num_rows == 0) {
    die("Data transaksi tidak ditemukan.");
}

$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
  
    <title>Struk Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      @media print {
    .btn-print {
      display: none;
    }
    body {
      background-color: white;
      color: black;
    }
  }
      
        body { background-color: #1e1e2f; color: white; font-family: 'Segoe UI'; }
        .container-box { background-color: #2a2d3e; padding: 30px; border-radius: 10px; text-align: center; }
    </style>
</head>
<body class="container py-5">
<div class="container-box">
    <h2 class="mb-4">Struk Transaksi</h2>
    <hr>
    <p><strong>Nama Pelanggan:</strong><br><?= $row['nama_pelanggan'] ?></p>
    <p><strong>Nomor Meja:</strong><br>Meja <?= $row['nomor_meja'] ?></p>
    <p><strong>Waktu Mulai:</strong><br><?= $row['waktu_mulai'] ?></p>
    <p><strong>Waktu Selesai:</strong><br><?= $row['waktu_selesai'] ?></p>
    <p><strong>Total Bayar:</strong><br>Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></p>
    <hr>
    <a href="laporan.php" class="btn btn-primary">Kembali ke Laporan</a>
</div>
</body>
<script>
  window.onload = function() {
    window.print();
  }
</script>

</html>
