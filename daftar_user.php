<?php 
include 'koneksi.php';
include 'header.php'; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-4 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-0">👥 Manajemen Pengguna</h3>
            <p class="text-muted small">Daftar akun di tabel <b>users</b>.</p>
        </div>
        <a href="admin_tambah_user.php" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-person-plus-fill me-2"></i>Tambah Petugas
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-dark">
                        <tr>
                            <th class="ps-4 py-3">ID</th>
                            <th>Nama & Email</th>
                            <th>Role</th>
                            <th>Info Spesifik</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query yang disederhanakan agar tidak menembak kolom yang tidak ada
                        // Kita hanya mengambil data dasar, lalu detailnya diambil lewat logika PHP
                        $sql = "SELECT 
                                    u.id, u.nama, u.email, u.role,
                                    m.nim, d.nidn
                                FROM users u
                                LEFT JOIN mahasiswa m ON u.id = m.user_id
                                LEFT JOIN dosen d ON u.id = d.user_id
                                ORDER BY u.role ASC, u.nama ASC";

                        $query = mysqli_query($koneksi, $sql);

                        if (!$query) {
                            echo "<tr><td colspan='5' class='p-5 text-center text-danger'>Eror: " . mysqli_error($koneksi) . "</td></tr>";
                        } elseif (mysqli_num_rows($query) > 0) {
                            while($data = mysqli_fetch_array($query)) {
                                $role = $data['role'];
                                
                                // Penentuan Badge
                                $badge = ($role == 'admin') ? 'bg-danger' : (($role == 'staff') ? 'bg-dark' : 'bg-primary');

                                // Logika Info Spesifik yang aman
                                $info = "-";
                                if ($role == 'mahasiswa') {
                                    $info = $data['nim'] ? "NIM: ".$data['nim'] : "NIM Kosong";
                                } elseif ($role == 'dosen') {
                                    $info = $data['nidn'] ? "NIDN: ".$data['nidn'] : "NIDN Kosong";
                                } elseif ($role == 'staff') {
                                    $info = "Petugas Internal";
                                } elseif ($role == 'admin') {
                                    $info = "Super Admin";
                                }
                        ?>
                        <tr>
                            <td class="ps-4 text-muted">#<?php echo $data['id']; ?></td>
                            <td>
                                <div class="fw-bold"><?php echo $data['nama']; ?></div>
                                <div class="text-muted small"><?php echo $data['email']; ?></div>
                            </td>
                            <td><span class="badge <?php echo $badge; ?> rounded-pill"><?php echo strtoupper($role); ?></span></td>
                            <td><small class="fw-semibold"><?php echo $info; ?></small></td>
                            <td class="text-center">
                                <a href="edit_user.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-outline-primary border-0"><i class="bi bi-pencil"></i></a>
                                <a href="hapus_user.php?id=<?php echo $data['id']; ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus user?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>