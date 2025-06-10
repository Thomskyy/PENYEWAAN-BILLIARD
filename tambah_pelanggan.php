<?php
include 'koneksi.php';
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $conn->query("INSERT INTO pelanggan (nama, no_hp) VALUES ('$nama', '$no_hp')");
    header('Location: index.php?msg=Pelanggan berhasil ditambahkan');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e1e2f; color: white; font-family: 'Segoe UI', sans-serif; }
        .container-box { background-color: #2a2d3e; padding: 20px; border-radius: 10px; }
    </style>
</head>
<body class="container py-5">
<div class="container-box">
<h2 class="mb-4">Tambah Pelanggan</h2>
<form method="POST" class="w-50">
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" name="nama" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">No HP</label>
        <input type="text" name="no_hp" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
</div>
</body>
</html>