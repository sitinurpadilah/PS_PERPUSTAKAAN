<?php 
include 'koneksi.php';
include 'header.php';

// Proteksi: Hanya Admin yang bisa kelola user
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses khusus Admin!'); window.location='index.php';</script>";
    exit;
}

// Proses Hapus User
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM user WHERE id_user = '$id'");
    echo "<script>window.location='user.php';</script>";
}
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-biru-gelap"><i class="bi bi-people-fill me-2"></i>Manajemen User</h3>
        <button class="btn btn-biru px-4 fw-bold rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#modalUser">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah User
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="navbar-biru text-white">
                    <tr>
                        <th class="py-3 ps-4">ID User</th>
                        <th class="py-3">Nama Lengkap</th>
                        <th class="py-3">Role</th>
                        <th class="py-3 pe-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($koneksi, "SELECT * FROM user ORDER BY role ASC");
                    while($u = mysqli_fetch_array($res)):
                    ?>
                    <tr>
                        <td class="ps-4"><code><?php echo $u['id_user']; ?></code></td>
                        <td class="fw-bold"><?php echo $u['nama']; ?></td>
                        <td>
                            <span class="badge <?php echo ($u['role'] == 'admin') ? 'bg-danger' : 'bg-info text-dark'; ?> px-3">
                                <?php echo strtoupper($u['role']); ?>
                            </span>
                        </td>
                        <td class="pe-4 text-center">
                            <a href="user.php?hapus=<?php echo $u['id_user']; ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('Hapus user ini?')">
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

<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header navbar-biru text-white">
                <h5 class="modal-title fw-bold">Tambah User Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="proses_tambah_user.php" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID User / NIM</label>
                        <input type="text" name="id_user" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Role</label>
                        <select name="role" class="form-select">
                            <option value="mahasiswa">Mahasiswa</option>
                            <option value="dosen">Dosen</option>
                            <option value="staff">Staff</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" name="simpan" class="btn btn-biru w-100 rounded-pill fw-bold shadow">SIMPAN USER</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>