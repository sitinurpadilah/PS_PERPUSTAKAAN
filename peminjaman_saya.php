<?php 
include 'koneksi.php';
include 'header.php'; 

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    echo "<script>window.location='login.php';</script>";
    exit;
}

// Mengambil ID user dari session yang sudah disetel saat login
$user_id = $_SESSION['user_id'];
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-biru-gelap"><i class="bi bi-journal-check me-2"></i>Pinjaman Saya</h3>
        <span class="badge bg-primary text-white px-3 py-2 shadow-sm">
            Total Riwayat: <?php 
                // Menghitung total pinjaman milik user yang sedang login
                $count = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peminjaman WHERE user_id='$user_id'");
                $res = mysqli_fetch_assoc($count);
                echo $res['total'];
            ?>
        </span>
    </div>
    
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="navbar-biru text-white">
                    <tr>
                        <th class="py-3 ps-4">Judul Buku</th>
                        <th class="py-3">ISBN</th>
                        <th class="py-3">Tanggal Pinjam</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 pe-4 text-center">Info Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Join peminjaman dengan buku untuk mendapatkan judul
                    $sql = "SELECT p.*, b.judul FROM peminjaman p 
                            JOIN buku b ON p.isbn = b.isbn 
                            WHERE p.user_id = '$user_id' 
                            ORDER BY p.tanggal_pinjam DESC";
                    $result = mysqli_query($koneksi, $sql);

                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_array($result)) :
                    ?>
                    <tr>
                        <td class="ps-4 fw-bold text-biru-gelap"><?php echo $row['judul']; ?></td>
                        <td><code><?php echo $row['isbn']; ?></code></td>
                        <td><i class="bi bi-calendar-event me-2"></i><?php echo date('d M Y', strtotime($row['tanggal_pinjam'])); ?></td>
                        <td class="text-center">
                            <?php if($row['status'] == 'dipinjam') : ?>
                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">AKTIF</span>
                            <?php else : ?>
                                <span class="badge rounded-pill bg-success text-white px-3 py-2">SELESAI</span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-center">
                            <?php if($row['status'] == 'dipinjam') : ?>
                                <small class="text-muted italic"><i class="bi bi-info-circle me-1"></i>Kembalikan ke petugas</small>
                            <?php else : ?>
                                <small class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i>Sudah Diterima</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    } else {
                        echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Belum ada riwayat peminjaman.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>