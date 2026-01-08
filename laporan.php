<?php 
include 'koneksi.php';
include 'header.php';

// Proteksi: Benar-benar hanya ADMIN yang boleh melihat halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Halaman ini khusus Administrator.'); window.location='index.php';</script>";
    exit;
}

// 1. Ambil Statistik Real-time (Untuk Card Atas)
$total_buku = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM buku"))['total'];
$total_tersedia = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM buku WHERE UPPER(status)='TERSEDIA'"))['total'];
$total_dipinjam = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM buku WHERE UPPER(status)='DIPINJAM'"))['total'];
$total_transaksi_all = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peminjaman"))['total'];

// 2. Query mengambil data ringkasan bulanan dari tabel LAPORAN
$query_laporan_hasil = mysqli_query($koneksi, "SELECT * FROM laporan ORDER BY id DESC");
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0"><i class="bi bi-journal-check me-2"></i>Laporan Tahunan & Bulanan</h3>
            <p class="text-muted small">Kelola dan pantau arsip statistik perpustakaan.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="rekap_laporan.php" class="btn btn-success rounded-pill px-4 shadow-sm">
                <i class="bi bi-arrow-clockwise me-1"></i> Update Data Bulan Ini
            </a>
            <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-4">
                <i class="bi bi-printer me-2"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <div class="row g-4 mb-5">
        </div>

    <div class="card border-0 shadow rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 p-4">
            <h5 class="fw-bold mb-0">Riwayat Laporan Bulanan</h5>
            <small class="text-muted">Klik "Update Data" untuk menyimpan statistik transaksi saat ini ke database.</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th class="py-3">Periode (Bulan)</th>
                            <th class="py-3 text-center">Total Transaksi</th>
                            <th class="py-3 text-center">Buku Masih Dipinjam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($query_laporan_hasil)): 
                        ?>
                        <tr>
                            <td class="ps-4"><?php echo $no++; ?></td>
                            <td class="fw-bold text-dark"><?php echo $row['periode']; ?></td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    <?php echo $row['total_transaksi']; ?> Transaksi
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                    <?php echo $row['total_buku_dipinjam']; ?> Buku
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <?php if(mysqli_num_rows($query_laporan_hasil) == 0): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-3"></i>
                                    Belum ada rekapan data di tabel laporan. Klik "Update Data".
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .navbar, footer { display: none !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    body { background-color: #fff !important; }
}
</style>

<?php include 'footer.php'; ?>