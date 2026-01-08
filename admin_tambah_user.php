<?php 
include 'koneksi.php';
include 'header.php'; 

// Proteksi: Hanya Admin yang boleh menambah Staff/Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak! Hanya Admin yang bisa menambah petugas.'); window.location='index.php';</script>";
    exit;
}
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="bg-primary p-4 text-white text-center">
                    <h3 class="fw-bold mb-0">🛡️ Registrasi Petugas</h3>
                    <p class="mb-0 opacity-75">Penambahan Akun Staff dan Administrator</p>
                </div>

                <div class="card-body p-4 p-lg-5">
                    <form action="proses_tambah_user.php" method="POST">
                        <input type="hidden" name="source" value="admin_panel">

                        <h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Data Akun Petugas</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control rounded-pill" placeholder="Nama lengkap petugas" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Email Kerja</label>
                                <input type="email" name="email" class="form-control rounded-pill" placeholder="nama@perpus.com" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Password</label>
                                <input type="password" name="password" class="form-control rounded-pill" placeholder="Password sementara" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Status / Role</label>
                                <select id="roleSelect" name="role" class="form-select rounded-pill" required onchange="toggleFields()">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="staff">Staff Perpustakaan</option>
                                    <option value="admin">Administrator</option>
                                </select>
                            </div>
                        </div>

                        <div id="spesifikFields" class="mt-4 pt-3 border-top" style="display:none;">
                            <div id="form-staff" class="role-form" style="display:none;">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-semibold">ID Staff / NIK</label>
                                        <input type="text" name="id_staff" class="form-control rounded-pill" placeholder="Masukkan Nomor Induk Karyawan">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary rounded-pill fw-bold py-2 shadow">DAFTARKAN PETUGAS</button>
                            <a href="daftar_user.php" class="btn btn-light rounded-pill fw-bold text-muted border">KEMBALI KE DAFTAR USER</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFields() {
    const role = document.getElementById("roleSelect").value;
    const container = document.getElementById("spesifikFields");
    const forms = document.querySelectorAll(".role-form");
    
    // Sembunyikan semua form tambahan dulu
    forms.forEach(f => f.style.display = "none");
    
    if (role === "staff") {
        container.style.display = "block";
        document.getElementById("form-staff").style.display = "block";
    } else {
        // Jika Admin, tidak ada field tambahan (disembunyikan)
        container.style.display = "none";
    }
}
</script>

<?php include 'footer.php'; ?>