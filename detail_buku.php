<?php 
include 'koneksi.php';
include 'header.php'; 

$isbn = mysqli_real_escape_string($koneksi, $_GET['isbn']);

// ==========================================================
// BAGIAN PROSES PINJAM (Ditaruh di dalam file utama)
// ==========================================================
if (isset($_GET['action']) && $_GET['action'] == 'pinjam' && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; //
    $tgl_pinjam = date('Y-m-d');
    $status_baru = 'DIPINJAM'; // Sesuai kapitalisasi database

    mysqli_begin_transaction($koneksi);
    try {
        // 1. Simpan ke tabel peminjaman
        $sql_pinjam = "INSERT INTO peminjaman (user_id, isbn, tanggal_pinjam, status) 
                       VALUES ('$user_id', '$isbn', '$tgl_pinjam', '$status_baru')";
        if (!mysqli_query($koneksi, $sql_pinjam)) {
            throw new Exception("Gagal simpan transaksi: " . mysqli_error($koneksi)); //
        }

        // 2. Update status di tabel buku
        $sql_update = "UPDATE buku SET status='$status_baru' WHERE isbn='$isbn'";
        if (!mysqli_query($koneksi, $sql_update)) {
            throw new Exception("Gagal update buku.");
        }

        mysqli_commit($koneksi);
        echo "<script>alert('Peminjaman berhasil! Selamat membaca dan overthinking!!'); window.location='detail_buku.php?isbn=$isbn';</script>"; //
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "');</script>";
    }
}

// Ambil data buku terbaru setelah kemungkinan ada proses update di atas
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE isbn = '$isbn'");
$data = mysqli_fetch_array($query);

// Cek apakah user sedang meminjam buku ini
$sedang_dipinjam = false;
if (isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $cek = mysqli_query($koneksi, "SELECT * FROM peminjaman WHERE isbn='$isbn' AND user_id='$uid' AND status='DIPINJAM'");
    $sedang_dipinjam = mysqli_fetch_array($cek);
}

$foto = (!empty($data['foto'])) ? $data['foto'] : 'default.jpg';
?>

<div class="container mt-4 mb-5">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="row g-0">
            <div class="col-md-4 text-center p-5 bg-light d-flex align-items-center justify-content-center">
                <img src="assets/img/buku/<?php echo $foto; ?>" class="img-fluid rounded shadow-lg" style="max-height: 400px;">
            </div>
            
            <div class="col-md-8 p-4 p-lg-5">
                <div class="mb-3">
                    <span class="badge rounded-pill <?php echo (strtoupper($data['status']) == 'TERSEDIA') ? 'bg-success' : 'bg-danger'; ?> px-4 py-2">
                        STATUS: <?php echo strtoupper($data['status']); ?> </span>
                </div>
                
                <h1 class="fw-bold mb-2"><?php echo $data['judul']; ?></h1>
                <p class="text-muted">ISBN: <strong><?php echo $data['isbn']; ?></strong></p>
                <hr>
                
                <div class="d-flex flex-wrap gap-3 mt-4">
                    <a href="index.php" class="btn btn-outline-secondary px-4 rounded-pill">KEMBALI</a>
                    
                    <?php if(!isset($_SESSION['user_id'])): ?>
                        <a href="login.php?isbn=<?php echo $isbn; ?>" class="btn btn-primary px-4 rounded-pill">LOGIN UNTUK PINJAM</a>
                    
                    <?php else: ?>
                        <?php if($sedang_dipinjam): ?>
                            <button class="btn btn-info text-white px-4 rounded-pill shadow" disabled>ANDA SEDANG MEMINJAM BUKU INI</button>
                        
                        <?php elseif(strtoupper($data['status']) == 'TERSEDIA'): ?>
                            <a href="detail_buku.php?isbn=<?php echo $isbn; ?>&action=pinjam" 
                               class="btn btn-success px-5 fw-bold rounded-pill shadow"
                               onclick="return confirm('Apakah Anda yakin ingin meminjam buku ini?')">
                               PINJAM SEKARANG </a>
                        
                        <?php else: ?>
                            <button class="btn btn-secondary px-4 rounded-pill" disabled>SEDANG DIPINJAM</button>
                        <?php endif; ?>

                        <?php if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'staff'): ?>
                            <a href="buku.php" class="btn btn-warning px-4 rounded-pill shadow">KELOLA DATA</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>