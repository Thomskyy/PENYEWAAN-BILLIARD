<?php
include 'koneksi.php';
$id = $_GET['id'];
$conn->query("DELETE FROM meja WHERE id_meja = $id");
header('Location: index.php?msg=Meja berhasil dihapus');
?>