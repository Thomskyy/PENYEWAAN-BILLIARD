<?php
// File: antrian.php
include 'koneksi.php';
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Tunggu Meja</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #1e1e2f;
      color: white;
    }
    .container-box {
      background-color: #2a2d3e;
      padding: 20px;
      border-radius: 10px;
      margin-top: 50px;
    }
  </style>
</head>
<body>
<?php include 'header.php'; ?>
<div class="container my-5">
  <div class="container-box">
    <h2 class="mb-4">Daftar Tunggu Meja</h2>

    <form method="POST" action="simpan_antrian.php" class="mb-4">
      <div class="row g-2">
        <div class="col-md-5">
          <input type="text" name="nama" class="form-control" placeholder="Nama Pelanggan" required>
        </div>
        <div class="col-md-5">
          <input type="text" name="no_wa" class="form-control" placeholder="Nomor WhatsApp (628xxx)" required>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-warning w-100">Tambahkan</button>
        </div>
      </div>
    </form>

    <h5>Daftar Antrian Saat Ini</h5>
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] === 'sukses') {
      echo '<div class="alert alert-success text-dark">Pelanggan berhasil ditambahkan ke daftar tunggu.</div>';
    }

    $data = $conn->query("SELECT * FROM waiting_list WHERE status='menunggu' ORDER BY waktu_request ASC");
    if ($data->num_rows > 0):
    ?>
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>No. WhatsApp</th>
          <th>Waktu</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($d = $data->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($d['nama']) ?></td>
          <td><?= htmlspecialchars($d['no_wa']) ?></td>
          <td><?= $d['waktu_request'] ?></td>
          <td>
            <?php
              $pesan = urlencode("Halo {$d['nama']}, saat ini tersedia meja kosong. Silakan datang ke Herta's Pocket Dimension. Terima kasih!");
              $wa = $d['no_wa'];
            ?>
            <a href="https://wa.me/<?= $wa ?>?text=<?= $pesan ?>" target="_blank" class="btn btn-success btn-sm">Kirim WA</a>
            <a href="ubah_status.php?id=<?= $d['id_antrian'] ?>" class="btn btn-secondary btn-sm">Selesai</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="alert alert-info text-dark">Belum ada pelanggan dalam antrian.</div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
