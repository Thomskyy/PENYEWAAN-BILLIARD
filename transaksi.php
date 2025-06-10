<?php
include 'koneksi.php';


if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $id_meja = $_POST['id_meja'];
    $waktu_mulai = $_POST['waktu_mulai'];
    $waktu_selesai = $_POST['waktu_selesai'];

    // Hitung durasi
    $start = new DateTime($waktu_mulai);
    $end = new DateTime($waktu_selesai);
    $interval = $start->diff($end);
    $jam = $interval->h + ($interval->i / 60);

    $tarif_per_jam = 20000;
    $total_bayar = ceil($jam * $tarif_per_jam);

    // Simpan ke transaksi
    $query = $conn->prepare("INSERT INTO transaksi (id_pelanggan, id_meja, waktu_mulai, waktu_selesai, total_bayar) VALUES (?, ?, ?, ?, ?)");
    $query->bind_param("iissd", $id_pelanggan, $id_meja, $waktu_mulai, $waktu_selesai, $total_bayar);
    $query->execute();

    if ($query->affected_rows > 0) {
        $id_transaksi = $conn->insert_id;

        // Update status meja
        $conn->query("UPDATE meja SET status='terisi' WHERE id_meja = $id_meja");

        header("Location: struk.php?id=$id_transaksi");
        exit;
    } else {
        echo "Gagal menyimpan transaksi.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include 'header.php'; ?>
    <title>Penyewaan Meja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
        }
        label {
            font-weight: 500;
        }
    </style>
</head>
<body class="container py-5">
<div class="container-box">
    <h2 class="mb-4">Form Penyewaan</h2>
    <form method="POST" class="w-50">
        <div class="mb-3">
            <label class="form-label">Pelanggan</label>
            <select name="id_pelanggan" class="form-select" required>
                <option value="">-- Pilih Pelanggan --</option>
                <?php
                $res = $conn->query("SELECT * FROM pelanggan");
                while ($p = $res->fetch_assoc()) {
                    echo "<option value='{$p['id_pelanggan']}'>{$p['nama']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Meja</label>
            <select name="id_meja" class="form-select" required>
                <option value="">-- Pilih Meja --</option>
                <?php
                $res = $conn->query("SELECT * FROM meja WHERE status='kosong'");
                while ($m = $res->fetch_assoc()) {
                    echo "<option value='{$m['id_meja']}'>Meja {$m['nomor_meja']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Waktu Mulai</label>
            <input type="datetime-local" name="waktu_mulai" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Waktu Selesai</label>
            <input type="datetime-local" name="waktu_selesai" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan Transaksi</button>
    </form>
</div>
</body>
</html>
