<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tokoserba35';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// echo "Koneksi database berhasil!";
