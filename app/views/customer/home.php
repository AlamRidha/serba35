<?php
require_once base_path('app/config/Auth.php');

if (!isLoggedIn()) {
    header("Location: " . base_url('index.php?page=login'));
    exit;
}

include base_path('app/views/layouts/header.php');
?>

<div class="container mt-5">
    <h3>Selamat Datang di Toko Serba 35 Kampar!</h3>
    <p>Customer</p>
    <!-- Tombol Logout -->
    <a href="<?= base_url('index.php?page=logout'); ?>" class="btn btn-danger">Logout</a>
</div>

<?php include base_path('app/views/layouts/footer.php'); ?>