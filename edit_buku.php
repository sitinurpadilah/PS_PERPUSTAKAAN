<?php 
include 'koneksi.php';
include 'header.php';

// Proteksi halaman: Hanya Staff atau Admin
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'staff' && $_SESSION['role'] != 'admin')) {
    echo "<script>alert('Akses ditolak!'); window.location='index.php';</script>";
    exit;
}

// Ambil ISBN dari URL
if (!isset($_GET['isbn'])) {
    header("Location: buku.php");
    exit;
}

$isbn = mysqli_real_escape_string($koneksi, $_GET['isbn']);
$query = mysqli_query($koneksi, "SELECT * FROM buku WHERE isbn = '$isbn'");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='buku.php';</script>";
    exit;
}
?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="navbar-biru text-white p-4">
                    <h4 class="fw-bold mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Data Buku</h4>
                </div>
                <div class="card-body p-4 bg-white">
                    <form action="proses_edit_buku.php" method="POST">
                        <input type="hidden" name="isbn_lama" value="<?php echo $data['isbn']; ?>">

                        <div class="mb-3">
                            <label class="form-label fw-bold">ISBN</label>
                            <input type="text" name="isbn" class="form-control" value="<?php echo $data['isbn']; ?>" required>
                            <small class="text-muted">*Jika ISBN diubah, data riwayat peminjaman mungkin terpengaruh.</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Buku</label>
                            <input type="text" name="judul" class="form-control" value="<?php echo $data['judul']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Pengarang</label>
                            <input type="text" name="pengarang" class="form-control" value="<?php echo $data['pengarang']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Penerbit</label>
                            <input type="text" name="penerbit" class="form-control" value="<?php echo $data['penerbit']; ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Buku</label>
                            <select name="status" class="form-select">
                                <option value="tersedia" <?php echo ($data['status'] == 'tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                                <option value="dipinjam" <?php echo ($data['status'] == 'dipinjam') ? 'selected' : ''; ?>>Sedang Dipinjam</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="buku.php" class="btn btn-secondary rounded-pill px-4">Batal</a>
                            <button type="submit" name="update" class="btn btn-biru rounded-pill px-4 shadow">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>