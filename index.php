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
    case 'data_product':
        include base_path('app/views/admin/data_product.php');
        break;
    case 'data_category':
        include base_path('app/views/admin/data_category.php');
        break;
    case 'laporan_penjualan':
        include base_path('app/views/admin/report.php');
        break;
    case 'data_user':
        include base_path('app/views/admin/data_user.php');
        break;
    case 'home':
        include base_path('app/views/customer/home.php');
        break;
    case 'data_order':
        include base_path('app/views/admin/data_order.php');
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
