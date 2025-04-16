<?php
session_start();
require_once 'app/helpers/functions.php';
require_once 'app/config/Controller.php';
require_once 'app/config/Auth.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'login':
        include base_path('app/views/auth/login.php');
        break;
    case 'dashboard':
        include base_path('app/views/admin/dashboard.php');
        break;
    case 'home':
        include base_path('app/views/customer/home.php');
        break;
    case 'logout':
        include base_path('app/controllers/LogoutController.php');
        break;
    case 'proses_login':
        include 'app/controllers/AuthController.php';
        break;
    default:
        echo "404 Page Not Found";
        break;
}
