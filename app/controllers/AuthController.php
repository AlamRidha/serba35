<?php
session_start();
require_once '../config/Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Koneksi database
    $database = new Database();
    $conn = $database->getConnection();

    // Cek user berdasarkan username
    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();
    $user = $result->fetch_assoc();

    // Validasi user
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = [
            'id' => $user['id_user'],
            'username' => $user['username'],
            'role' => $user['Role']
        ];

        // Redirect sesuai role
        if ($user['Role'] === 'admin') {
            header("Location: ../index.php?page=dashboard");
        } else {
            header("Location: ../index.php?page=home");
        }
        exit;
    } else {
        // Redirect kembali ke login dengan error
        $error = "Username atau password salah!";
        header("Location: ../index.php?page=login&error=" . urlencode($error));
        exit;
    }
}
