<?php
include 'koneksi.php';
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}



?>
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

<?php include 'header.php'; ?>
                                                                                  

<div class="container my-5">
  <div class="container-box">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">Data Meja Billiard</h2>
      <div>
        <a href="tambah_meja.php" class="btn btn-outline-light me-2">Tambah Meja</a>
        <a href="tambah_pelanggan.php" class="btn btn-outline-light me-2">Tambah Pelanggan</a>
        <a href="transaksi.php" class="btn btn-success me-2">Pesan</a>
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
          echo "<tr>
                  <td>{$no}</td>
                  <td>{$row['nomor_meja']}</td>
                  <td>{$row['status']}</td>
   <td>
              <a class='btn btn-warning btn-sm me-1' href='edit_meja.php?id={$row['id_meja']}'>Edit</a>
              <a class='btn btn-danger btn-sm' href='hapus_meja.php?id={$row['id_meja']}'>Hapus</a>
            </td>
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
