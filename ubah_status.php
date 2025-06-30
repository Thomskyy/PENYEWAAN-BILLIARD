<?php
include 'koneksi.php';
$id = $_GET['id'];
$conn->query("UPDATE waiting_list SET status='diberitahu' WHERE id_antrian=$id");
header('Location: antrian.php');
