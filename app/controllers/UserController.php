<?php
require_once base_path('app/config/Database.php');

class UserController
{
    public static function settingPage()
    {
        include base_path('app/views/pages/setting.php');
    }

    public static function updateSetting()
    {
        session_start();
        global $conn;

        if (!isset($_SESSION['user'])) {
            header("Location: " . base_url('index.php?page=login'));
            exit;
        }

        $id_user = $_SESSION['user']['id_user'];
        $new_username = mysqli_real_escape_string($conn, $_POST['username']);
        $new_password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

        $query = "UPDATE users SET username = '$new_username'";
        if ($new_password) {
            $query .= ", password = '$new_password'";
        }
        $query .= " WHERE id_user = $id_user";

        if (mysqli_query($conn, $query)) {
            $_SESSION['user']['username'] = $new_username;
            header("Location: " . base_url('index.php?page=setting&success=1'));
        } else {
            header("Location: " . base_url('index.php?page=setting&error=1'));
        }
        exit;
    }
}
