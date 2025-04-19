<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once base_path('app/config/Database.php');

$db = new Database();
$conn = $db->getConnection();

// Ambil semua user
function getAllUsers($keyword = null)
{
    global $conn;
    $query = "SELECT * FROM users";

    if ($keyword) {
        $escapedKeyword = mysqli_real_escape_string($conn, $keyword);
        $query .= " WHERE username LIKE '%$escapedKeyword%'";
    }

    $result = mysqli_query($conn, $query);
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    return $data;
}

// Tambah user
function createUser($data)
{
    global $conn;
    $username = mysqli_real_escape_string($conn, $data['username']);
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $role = mysqli_real_escape_string($conn, $data['Role']);

    $query = "INSERT INTO users (username, password, Role) 
              VALUES ('$username', '$password', '$role')";

    return mysqli_query($conn, $query);
}

// Update user
function updateUser($id, $data)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $username = mysqli_real_escape_string($conn, $data['username']);
    $role = mysqli_real_escape_string($conn, $data['Role']);

    $query = "UPDATE users SET username='$username', Role='$role'";

    if (!empty($data['password'])) {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $query .= ", password='$password'";
    }

    $query .= " WHERE id_user=$id";

    return mysqli_query($conn, $query);
}

// Hapus user
function deleteUser($id)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $query = "DELETE FROM users WHERE id_user=$id";
    return mysqli_query($conn, $query);
}

// Ambil user berdasarkan ID
function getUserById($id)
{
    global $conn;
    $id = mysqli_real_escape_string($conn, $id);
    $query = "SELECT * FROM users WHERE id_user=$id LIMIT 1";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}
