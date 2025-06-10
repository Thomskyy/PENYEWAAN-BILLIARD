<?php
include 'koneksi.php';
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nomor = $_POST['nomor_meja'];
    $status = $_POST['status'];

    $cek = $conn->query("SELECT * FROM meja WHERE nomor_meja = '$nomor'");
    if ($cek->num_rows > 0) {
        header('Location: index.php?msg=Nomor meja sudah ada!');
        exit;
    }

    $conn->query("INSERT INTO meja (nomor_meja, status) VALUES ('$nomor', '$status')");
    header('Location: index.php?msg=Meja berhasil ditambahkan');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Meja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e1e2f; color: white; font-family: 'Segoe UI', sans-serif; }
        .container-box { background-color: #2a2d3e; padding: 20px; border-radius: 10px; }
    </style>
</head>
<body class="container py-5">
<div class="container-box">
<h2 class="mb-4">Tambah Meja Billiard</h2>
<form method="POST" class="w-50">
    <div class="mb-3">
        <label class="form-label">Nomor Meja</label>
        <input type="text" name="nomor_meja" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
            <option value="kosong">Kosong</option>
            <option value="terisi">Terisi</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
</div>
</body>
</html>
echo "<script>
Swal.fire({
  icon: 'success',
  title: 'Berhasil!',
  text: 'Meja berhasil ditambahkan',
  showConfirmButton: false,
  timer: 2000
});
setTimeout(() => window.location='index.php', 2000);
</script>";


<!-- index.php (perbaikan status badge & validasi alert) -->
<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Billiard Herta's Pocket Dimension</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #1e1e2f;
      color: white;
    }
    .navbar {
      background-color: #2c2f48;
    }
    .navbar-brand {
      font-weight: bold;
    }
    .container-box {
      background-color: #2a2d3e;
      border-radius: 10px;
      padding: 20px;
    }
    table {
      color: white;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Billiard Herta</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
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
    </div>
  </div>
</nav>

<div class="container my-5">
  <div class="container-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">Data Meja Billiard</h2>
      <div>
        <a href="tambah_meja.php" class="btn btn-outline-light me-2">Tambah Meja</a>
        <a href="tambah_pelanggan.php" class="btn btn-outline-light me-2">Tambah Pelanggan</a>
        <a href="transaksi.php" class="btn btn-success me-2">Penyewaan</a>
        <a href="laporan.php" class="btn btn-warning">Laporan</a>
      </div>
    </div>

    <?php if (isset($_GET['msg'])): ?>
      <div class="alert alert-success"> <?= htmlspecialchars($_GET['msg']) ?> </div>
    <?php endif; ?>

    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nomor Meja</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $result = $conn->query("SELECT * FROM meja");
      $no = 1;
      while ($row = $result->fetch_assoc()) {
          $badge = $row['status'] === 'terisi' ? 'danger' : 'success';
          echo "<tr>
                  <td>{$no}</td>
                  <td>{$row['nomor_meja']}</td>
                  <td><span class='badge bg-$badge'>{$row['status']}</span></td>
                  <td><a class='btn btn-danger btn-sm' href='hapus_meja.php?id={$row['id_meja']}'>Hapus</a></td>
                </tr>";
          $no++;
      }
      ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>
