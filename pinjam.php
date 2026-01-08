<?php 
include 'koneksi.php';
include 'header.php'; // Pastikan session_start() ada di sini

// Proteksi: Jika belum login, tendang ke halaman login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Menangkap ISBN dari URL
$isbn_buku = isset($_GET['isbn']) ? mysqli_real_escape_string($koneksi, $_GET['isbn']) : '';

// Ambil judul buku dari database untuk tampilan informasi
$query_buku = mysqli_query($koneksi, "SELECT judul FROM buku WHERE isbn = '$isbn_buku'");
$data_buku = mysqli_fetch_array($query_buku);
?>

<div class="container mt-5">
    <div class="card shadow-sm border-0 mx-auto" style="max-width: 500px;">
        <div class="card-body p-4">
            <h4 class="fw-bold mb-4 text-center">Konfirmasi Peminjaman</h4>
            <form action="proses_pinjam.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Peminjam</label>
                    <input type="text" class="form-control bg-light" value="<?php echo $_SESSION['nama']; ?>" readonly>
                </div>

                <div class="mb-3">
    <label class="form-label small fw-bold">ISBN Buku</label>
    <input type="text" name="isbn" class="form-control" value="<?php echo isset($_GET['isbn']) ? $_GET['isbn'] : ''; ?>" required>
    <div class="form-text text-danger">Pastikan ISBN sama persis dengan yang ada di database.</div>
</div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Judul Buku</label>
                    <input type="text" class="form-control bg-light" value="<?php echo $data_buku['judul'] ?? 'Buku tidak ditemukan'; ?>" readonly>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-bold">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                </div>

                <button type="submit" name="submit" class="btn btn-primary w-100 fw-bold py-2">KONFIRMASI PINJAM</button>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>