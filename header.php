<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

// Cek apakah user sudah login
$is_logged_in = isset($_SESSION['user_id']);
$user_role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERPUSTAKAAN BIRU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { --biru-muda: #adcaf8; --biru-sedang: #709ee7; --biru-gelap: #2972bb; }
        .navbar-biru { background-color: var(--biru-gelap); }
        .btn-search { background-color: var(--biru-sedang); color: white; border: none; }
        .offcanvas-biru { background-color: #f0f5ff !important; color: var(--biru-gelap) !important; }
        .list-group-item-biru { background-color: #f0f5ff; color: var(--biru-gelap); border-color: var(--biru-muda) !important; }
        .list-group-item-biru:hover { background-color: var(--biru-muda); }
        .section-header { padding: 12px 20px 5px; font-size: 0.75rem; font-weight: bold; color: #6c757d; text-transform: uppercase; }
        .bg-admin-menu { background-color: #e2ebff; } /* Warna khusus pembeda menu admin */
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark shadow-sm navbar-biru">
    <div class="container">
        <button class="navbar-toggler d-block border-0 me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand fw-bold" href="index.php">PERPUSTAKAAN BIRU</a>

        <div class="flex-grow-1 mx-lg-4 mx-2">
            <form action="index.php" method="GET" class="d-flex border border-white rounded overflow-hidden bg-white">
                <input type="text" name="cari" class="form-control border-0 shadow-none" placeholder="Cari judul buku..." value="<?php echo isset($_GET['cari']) ? $_GET['cari'] : ''; ?>">
                <button class="btn btn-search px-3" type="submit"><i class="bi bi-search"></i></button>
            </form>
        </div>

        <div class="d-none d-lg-flex align-items-center">
            <?php if($is_logged_in): ?>
                <span class="text-white me-3 small">Halo, <strong><?php echo $_SESSION['nama']; ?></strong> (<?php echo strtoupper($user_role); ?>)</span>
                <a href="logout.php" class="btn btn-outline-light btn-sm px-3 fw-bold">KELUAR</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-light btn-sm px-4 fw-bold text-primary">LOGIN</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="offcanvas offcanvas-start offcanvas-biru" tabindex="-1" id="sidebarMenu" style="width: 280px;">
    <div class="offcanvas-header border-bottom border-primary">
        <h5 class="offcanvas-title fw-bold text-biru"><i class="bi bi-grid-fill me-2"></i>MENU UTAMA</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="list-group list-group-flush">
            <div class="section-header">Dashboard</div>
            <a href="index.php" class="list-group-item list-group-item-action list-group-item-biru py-3"><i class="bi bi-house-door me-2"></i> Katalog Buku</a>

            <?php if($is_logged_in): ?>
                
                <?php if($user_role == 'mahasiswa' || $user_role == 'dosen'): ?>
                    <div class="section-header">Peminjaman</div>
                    <a href="peminjaman_saya.php" class="list-group-item list-group-item-action list-group-item-biru py-3"><i class="bi bi-book me-2"></i> Pinjaman Saya</a>
                <?php endif; ?>

                <?php if($user_role == 'staff' || $user_role == 'admin'): ?>
                    <div class="section-header">Manajemen Data</div>
                    <a href="buku.php" class="list-group-item list-group-item-action list-group-item-biru py-3"><i class="bi bi-database-gear me-2"></i> Manajemen Buku</a>
                    <a href="daftar_peminjam.php" class="list-group-item list-group-item-action list-group-item-biru py-3"><i class="bi bi-journal-text me-2"></i> Semua Transaksi</a>
                    <a href="laporan.php" class="list-group-item list-group-item-action list-group-item-biru py-3"><i class="bi bi-bar-chart-line me-2"></i> Laporan</a>
                <?php endif; ?>

                <?php if($user_role == 'admin'): ?>
                    <div class="section-header">Otoritas Admin</div>
                    <a href="admin_tambah_user.php" class="list-group-item list-group-item-action list-group-item-biru py-3 bg-admin-menu">
                        <i class="bi bi-person-plus-fill me-2"></i> Tambah Petugas (Staff/Admin)
                    </a>
                    <a href="daftar_user.php" class="list-group-item list-group-item-action list-group-item-biru py-3 bg-admin-menu">
                        <i class="bi bi-people-fill me-2"></i> Daftar Semua User
                    </a>
                <?php endif; ?>
                
                <div class="p-3 mt-4">
                    <a href="logout.php" class="btn btn-danger w-100 shadow-sm fw-bold">KELUAR</a>
                </div>
            <?php else: ?>
                <div class="p-3 mt-4">
                    <a href="login.php" class="btn btn-primary w-100 shadow-sm fw-bold">LOGIN SEKARANG</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>