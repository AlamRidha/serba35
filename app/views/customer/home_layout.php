<?php
require_once base_path('app/config/Auth.php');

if (!isLoggedIn()) {
    header("Location: " . base_url('index.php?page=login'));
    exit;
}

include base_path('app/views/layouts/header.php');
?>

<style>
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('index.php?page=home'); ?>">Toko Serba 35</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <a href="index.php?page=cart" class="btn btn-outline-light position-relative">
                    🛒 Keranjang
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cart-count">
                        <?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>
                    </span>
                </a>
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET['page'] ?? '') === 'home' ? 'active' : '' ?>" href="<?= base_url('index.php?page=home'); ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET['page'] ?? '') === 'data_product_c' ? 'active' : '' ?>" href="<?= base_url('index.php?page=data_product_c'); ?>">Data Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET['page'] ?? '') === 'order_c' ? 'active' : '' ?>" href="<?= base_url('index.php?page=order_c'); ?>">Order</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($_GET['page'] ?? '') === 'riwayat_c' ? 'active' : '' ?>" href="<?= base_url('index.php?page=riwayat_c'); ?>">Riwayat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('index.php?page=logout'); ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="container my-4 ">
    <?php
    if (file_exists($content_view)) {
        include $content_view;
    } else {
        echo "<p>Halaman tidak ditemukan: <code>$content_view</code></p>";
    }
    ?>
</main>


<?php include base_path('app/views/layouts/footer.php'); ?>