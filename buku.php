<?php 
include 'koneksi.php';
include 'header.php';

// Proteksi halaman: Hanya Staff atau Admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'staff' && $_SESSION['role'] != 'admin')) {
    echo "<script>alert('Akses ditolak!'); window.location='index.php';</script>";
    exit;
}

// Proses Hapus Buku (Sekaligus menghapus file gambar di folder)
if (isset($_GET['hapus'])) {
    $isbn_hapus = mysqli_real_escape_string($koneksi, $_GET['hapus']);
    
    // Ambil nama file foto sebelum dihapus dari database
    $cek_foto = mysqli_query($koneksi, "SELECT foto FROM buku WHERE isbn = '$isbn_hapus'");
    $data_foto = mysqli_fetch_array($cek_foto);
    
    if ($data_foto['foto'] != '' && $data_foto['foto'] != 'default.jpg') {
        unlink("assets/img/buku/" . $data_foto['foto']); // Hapus file dari folder
    }

    mysqli_query($koneksi, "DELETE FROM buku WHERE isbn = '$isbn_hapus'");
    echo "<script>alert('Buku berhasil dihapus!'); window.location='buku.php';</script>";
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-biru-gelap"><i class="bi bi-database-gear me-2"></i>Manajemen Data Buku</h3>
        <button class="btn btn-biru px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah Buku Baru
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="navbar-biru text-white">
                    <tr>
                        <th class="py-3 ps-4">Cover</th>
                        <th class="py-3">ISBN & Judul</th>
                        <th class="py-3">Pengarang / Penerbit</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 pe-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY judul ASC");
                    while ($row = mysqli_fetch_array($query)) :
                        $foto = (!empty($row['foto'])) ? $row['foto'] : 'default.jpg';
                    ?>
                    <tr>
                        <td class="ps-4">
                            <img src="assets/img/buku/<?php echo $foto; ?>" class="rounded-3 shadow-sm" style="width: 50px; height: 70px; object-fit: cover;">
                        </td>
                        <td>
                            <code class="small"><?php echo $row['isbn']; ?></code><br>
                            <span class="fw-bold text-biru-gelap"><?php echo $row['judul']; ?></span>
                        </td>
                        <td>
                            <small class="text-muted">By:</small> <?php echo $row['pengarang']; ?><br>
                            <small class="text-muted">Pub:</small> <?php echo $row['penerbit']; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill <?php echo ($row['status'] == 'tersedia') ? 'bg-success' : 'bg-danger'; ?> px-3 py-2">
                                <?php echo strtoupper($row['status']); ?>
                            </span>
                        </td>
                        <td class="pe-4 text-center">
                            <a href="edit_buku.php?isbn=<?php echo $row['isbn']; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 mb-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="buku.php?hapus=<?php echo $row['isbn']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 mb-1" onclick="return confirm('Hapus buku ini?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header navbar-biru text-white">
                <h5 class="modal-title fw-bold">Tambah Buku Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses_tambah_buku.php" method="POST" enctype="multipart/form-data">
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">ISBN</label>
                            <input type="text" name="isbn" class="form-control" placeholder="Contoh: 978..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small">Status Awal</label>
                            <select name="status" class="form-select">
                                <option value="tersedia">Tersedia</option>
                                <option value="dipinjam">Dipinjam</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Pengarang</label>
                        <input type="text" name="pengarang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Penerbit</label>
                        <input type="text" name="penerbit" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Cover Buku (Foto)</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <div class="form-text">Format: JPG/PNG, Max: 2MB</div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-biru rounded-pill px-4 shadow">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>