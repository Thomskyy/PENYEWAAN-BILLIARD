<?php
include 'koneksi.php';
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $conn->query("UPDATE meja SET status='$status' WHERE id_meja=$id");
    header('Location: index.php?msg=Status meja berhasil diperbarui');
    exit;
}
$result = $conn->query("SELECT * FROM meja WHERE id_meja=$id");
$meja = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Meja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #1e1e2f; color: white; font-family: 'Segoe UI', sans-serif; }
        .container-box { background-color: #2a2d3e; padding: 20px; border-radius: 10px; margin-top: 50px; }
    </style>
</head>
<body class="container py-5">
<div class="container-box">
    <h2 class="mb-4">Edit Status Meja</h2>
    <form method="POST" class="w-50">
        <div class="mb-3">
            <label class="form-label">Nomor Meja</label>
            <input type="text" class="form-control" value="<?= $meja['nomor_meja']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="kosong" <?= $meja['status'] == 'kosong' ? 'selected' : ''; ?>>Kosong</option>
                <option value="terisi" <?= $meja['status'] == 'terisi' ? 'selected' : ''; ?>>Terisi</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Update</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>