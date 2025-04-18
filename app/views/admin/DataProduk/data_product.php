<?php
require_once base_path('app/config/Auth.php');
require_once base_path('app/controllers/ProductController.php');

if (!isLoggedIn() || !isAdmin()) {
    header("Location: " . base_url('index.php?page=login'));
    exit;
}

// Proses tambah produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'store') {
    if (createProduk($_POST, $_FILES)) {

        echo "<script>alert('Produk berhasil ditambahkan!'); window.location.href='index.php?page=data_product';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan produk.');</script>";
    }
}

// Proses hapus produk
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    if (deleteProduk($_GET['id_product'])) {
        echo "<script>alert('Produk berhasil dihapus!'); window.location.href='index.php?page=data_product';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal menghapus produk.');</script>";
    }
}

// Proses edit produk
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'update') {
    if (updateProduk($_POST['id_product'], $_POST, $_FILES)) {
        echo "<script>alert('Produk berhasil diperbarui!'); window.location.href='index.php?page=data_product';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal memperbarui produk.');</script>";
    }
}


// Ambil data dari controller
$keyword = $_GET['search'] ?? null;
$products = getAllProducts($keyword);
// $products = getAllProducts();
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>📦 Data Produk</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">➕ Tambah Produk</button>
    </div>

    <form method="GET" action="" class="mb-4">
        <input type="hidden" name="page" value="data_produk">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="<?= $_GET['search'] ?? '' ?>">
            <button class="btn btn-secondary" type="submit">🔍 Cari</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-nowrap">
            <thead class="table-dark text-center">
                <tr>
                    <th>ID</th>
                    <th>Nama Produk</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)) : ?>
                    <?php $no = 1; ?>
                    <?php foreach ($products as $product) : ?>
                        <tr>

                            <!-- <td class="text-center"><?= $product['id_product'] ?></td> -->
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= htmlspecialchars($product['nama_produk']) ?></td>
                            <td><?= htmlspecialchars($product['deskripsi']) ?></td>
                            <td class="text-end">Rp<?= number_format($product['harga'], 0, ',', '.') ?></td>
                            <td class="text-center"><?= $product['stok'] ?></td>
                            <td class="text-center">

                                <?php if (!empty($product['gambar'])) : ?>
                                    <img src="<?= base_url($product['gambar']) ?>" alt="Gambar Produk" width="60">
                                <?php else : ?>
                                    <span class="text-muted">Tidak ada</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <!-- <a href="<?= base_url('index.php?page=edit_product&id_product=' . $product['id_product']) ?>" class="btn btn-sm btn-warning">✏️ Edit</a> -->
                                <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditProduk<?= $product['id_product'] ?>">✏️ Edit</a>
                                <a href="<?= base_url('index.php?page=data_product&id_product=' . $product['id_product'] . '&action=delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">🗑️ Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada data produk.</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>

        <!-- Modal Tambah Produk -->
        <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('index.php?page=data_product&action=store') ?>" method="POST" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">➕ Tambah Produk Baru</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_produk" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="nama_produk" required>
                            </div>
                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="harga" class="form-label">Harga</label>
                                    <input type="number" class="form-control" name="harga" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" name="stok" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" name="gambar" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-success">💾 Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit Produk -->
        <?php foreach ($products as $product) : ?>
            <div class="modal fade" id="modalEditProduk<?= $product['id_product'] ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $product['id_product'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <form action="<?= base_url('index.php?page=data_product&action=update') ?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id_product" value="<?= $product['id_product'] ?>">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalEditLabel<?= $product['id_product'] ?>">✏️ Edit Produk</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_produk" class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" value="<?= htmlspecialchars($product['nama_produk']) ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" rows="3" required><?= htmlspecialchars($product['deskripsi']) ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="number" class="form-control" name="harga" value="<?= $product['harga'] ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="stok" class="form-label">Stok</label>
                                        <input type="number" class="form-control" name="stok" value="<?= $product['stok'] ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Gambar Produk</label>
                                    <?php if (!empty($product['gambar'])) : ?>
                                        <div class="mb-2">
                                            <img src="<?= base_url($product['gambar']) ?>" alt="Gambar Saat Ini" width="100" class="img-thumbnail">
                                            <small class="d-block text-muted">Gambar saat ini</small>
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" name="gambar" accept="image/*">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">❌ Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>