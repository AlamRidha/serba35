<?php
require_once base_path('app/config/Auth.php');

if (!isLoggedIn() || !isAdmin()) {
    header("Location: " . base_url('index.php?page=login'));
    exit;
}

include base_path('app/views/layouts/header.php');
?>

<h1>Selamat datang, Admin!</h1>
<p>admin</p>

<?php include '../layouts/footer.php'; ?>