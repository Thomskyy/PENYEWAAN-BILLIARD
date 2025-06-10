<?php
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : 0;
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : 0;

$where = "";
if ($bulan && $tahun) {
    $where = "WHERE MONTH(waktu_mulai) = $bulan AND YEAR(waktu_mulai) = $tahun";
}

$sql = "SELECT t.*, p.nama, m.nomor_meja
        FROM transaksi t
        JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
        JOIN meja m ON t.id_meja = m.id_meja
        $where
        ORDER BY t.id_transaksi DESC";

$query = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Laporan Transaksi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #1e1e2f;
      color: white;
      font-family: 'Segoe UI', sans-serif;
    }
    .container-box {
      background-color: #2a2d3e;
      padding: 20px;
      border-radius: 10px;
      margin-top: 50px;
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
    <h2 class="mb-4">Laporan Transaksi</h2>

    <form method="GET" class="d-flex mb-4 flex-wrap gap-2 align-items-center">
      <select name="bulan" class="form-select w-auto" required>
        <option value="">-- Pilih Bulan --</option>
        <?php
          for ($b = 1; $b <= 12; $b++) {
              $selected = ($b === $bulan) ? 'selected' : '';
              echo "<option value='$b' $selected>" . date("F", mktime(0,0,0,$b,1)) . "</option>";
          }
        ?>
      </select>

      <select name="tahun" class="form-select w-auto" required>
        <option value="">-- Pilih Tahun --</option>
        <?php
          $tahun_sekarang = date('Y');
          for ($t = 2022; $t <= $tahun_sekarang; $t++) {
              $selected = ($t === $tahun) ? 'selected' : '';
              echo "<option value='$t' $selected>$t</option>";
          }
        ?>
      </select>

      <button type="submit" class="btn btn-primary">Filter</button>
      <a href="laporan.php" class="btn btn-secondary">Reset</a>
    </form>

    <?php if ($query->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-dark table-striped align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Nomor Meja</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Total Bayar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 1;
            while ($row = $query->fetch_assoc()) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['nama']}</td>
                        <td>{$row['nomor_meja']}</td>
                        <td>{$row['waktu_mulai']}</td>
                        <td>{$row['waktu_selesai']}</td>
                        <td>Rp " . number_format($row['total_bayar'], 0, ',', '.') . "</td>
                        <td>
            <a href='struk.php?id={$row['id_transaksi']}' class='btn btn-sm btn-primary'>
                Cetak Struk
            </a>
             </td>
                      </tr>";

                $no++;
            }
          ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
      <div class="alert alert-warning text-dark">Tidak ada data transaksi untuk filter yang dipilih.</div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
