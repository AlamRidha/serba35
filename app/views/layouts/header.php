<?php if (isLoggedIn()) : ?>
    <a href="<?= base_url('index.php?page=logout') ?>" class="btn btn-danger">Logout</a>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Toko Serba 35 Kampar</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>