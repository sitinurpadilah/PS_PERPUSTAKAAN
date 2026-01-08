<?php 
include 'koneksi.php';
include 'header.php';

// Proteksi: Hanya Staff/Admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'staff' && $_SESSION['role'] != 'admin')) {
    echo "<script>alert('Akses ditolak!'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-biru-gelap"><i class="bi bi-journal-text me-2"></i>Semua Transaksi Peminjaman</h3>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="navbar-biru text-white">
                    <tr>
                        <th class="py-3 ps-4">Peminjam</th>
                        <th class="py-3">Judul Buku</th>
                        <th class="py-3">Tgl Pinjam</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 pe-4 text-center">Aksi</th> </tr>
                </thead>
                <tbody>
                    <?php
                    // Mengambil semua kolom dari tabel peminjaman (p.*) 
                    // Termasuk 'id' sebagai primary key tabel peminjaman
                    $sql = "SELECT p.*, b.judul, u.nama 
                            FROM peminjaman p 
                            JOIN buku b ON p.isbn = b.isbn 
                            JOIN users u ON p.user_id = u.id 
                            ORDER BY p.tanggal_pinjam DESC";
                    
                    $result = mysqli_query($koneksi, $sql);

                    if (!$result) {
                        echo "<tr><td colspan='5' class='text-center text-danger'>Error: " . mysqli_error($koneksi) . "</td></tr>";
                    } else {
                        while($row = mysqli_fetch_array($result)) :
                    ?>
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold"><?php echo $row['nama']; ?></span>
                        </td>
                        <td><?php echo $row['judul']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tanggal_pinjam'])); ?></td>
                        <td class="text-center">
                            <?php if($row['status'] == 'dipinjam') : ?>
                                <span class="badge rounded-pill bg-warning text-dark px-3">DIPINJAM</span>
                            <?php else : ?>
                                <span class="badge rounded-pill bg-success px-3 text-white">DIKEMBALIKAN</span>
                            <?php endif; ?>
                        </td>
                        <td class="pe-4 text-center">
                            <?php if($row['status'] == 'dipinjam') : ?>
                                <a href="proses_kembali.php?isbn=<?php echo $row['isbn']; ?>&id_pinjam=<?php echo $row['id']; ?>" 
                                   class="btn btn-danger btn-sm px-3 fw-bold rounded-pill shadow-sm"
                                   onclick="return confirm('Konfirmasi pengembalian buku?')">
                                   TERIMA BUKU
                                </a>
                            <?php else : ?>
                                <span class="text-muted small"><i class="bi bi-check-circle-fill text-success"></i> Selesai</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>