<?php
require_once base_path('app/config/Auth.php');

if (!isLoggedIn() || !isAdmin()) {
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

    .sidebar {
        width: 250px;
        height: 100vh;
        background-color: #343a40;
        position: fixed;
        top: 0;
        left: 0;
        padding-top: 60px;
        transform: translateX(0);
        transition: transform 0.3s ease;
        z-index: 1020;
    }

    .sidebar.collapsed {
        transform: translateX(-100%);
    }

    .sidebar a {
        color: #fff;
        padding: 15px;
        display: block;
        text-decoration: none;
    }

    .sidebar a:hover {
        background-color: #495057;
    }

    .content {
        margin-left: 250px;
        padding: 20px;
        margin-top: 60px;
        transition: margin-left 0.3s ease;
    }

    .content.expanded {
        margin-left: 0;
    }

    .navbar-custom {
        z-index: 1031;
    }

    @media (max-width: 768px) {
        .content {
            margin-left: 0;
        }
    }
</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top navbar-custom">
    <div class="container-fluid">
        <button class="btn btn-dark me-2" id="toggleSidebar">
            ☰
        </button>
        <a class="navbar-brand" href="<?= base_url('index.php?page=dashboard'); ?>">Dashboard</a>
        <div class="d-flex ms-auto">
            <a href="<?= base_url('index.php?page=logout'); ?>" class="btn btn-outline-light me-2">Logout</a>

            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#settingModal">⚙️ Setting</button>

        </div>
    </div>
</nav>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <a href="<?= base_url('index.php?page=dashboard'); ?>">🏠 Dashboard</a>
    <a href="<?= base_url('index.php?page=data_category'); ?>">📁 Data Kategori</a>
    <a href="<?= base_url('index.php?page=data_product'); ?>">📦 Data Produk</a>
    <a href="<?= base_url('index.php?page=data_order'); ?>">💵 Manajemen Pesanan</a>
    <a href="<?= base_url('index.php?page=laporan_penjualan'); ?>">📓 Laporan Penjualan</a>
    <a href="<?= base_url('index.php?page=data_user'); ?>">🧑Manajemen User</a>
    <a href="<?= base_url('index.php?page=logout'); ?>">🚪 Keluar</a>
</div>

<!-- Content -->
<div class="content" id="mainContent">
    <?php
    if (file_exists($content_view)) {
        include $content_view;
    } else {
        echo "<p>Halaman tidak ditemukan: <code>$content_view</code></p>";
    }
    ?>
</div>

<!-- Modal Pengaturan Akun -->
<div class="modal fade" id="settingModal" tabindex="-1" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="<?= base_url('index.php?page=setting') ?>" class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="settingModalLabel">⚙️ Pengaturan Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success">Pengaturan berhasil diperbarui!</div>
                <?php elseif (isset($_GET['error'])): ?>
                    <div class="alert alert-danger">Gagal menyimpan perubahan.</div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Username Baru</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['username']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengganti">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Batal</button>
                <button type="submit" class="btn btn-success">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>


<script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('mainContent');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
        content.classList.toggle('expanded');
    });
</script>

<?php include base_path('app/views/layouts/footer.php') ?>