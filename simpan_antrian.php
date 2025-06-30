<?php
include 'koneksi.php';

$nama = $_POST['nama'];
$no_wa = $_POST['no_wa'];

$conn->query("INSERT INTO waiting_list (nama, no_wa) VALUES ('$nama', '$no_wa')");
header('Location: antrian.php?msg=sukses');
