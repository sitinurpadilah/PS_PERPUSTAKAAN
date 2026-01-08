<?php

include 'koneksi.php';

include 'header.php';

?>



<div class="container mt-5 mb-5">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card border-0 shadow-lg rounded-4 overflow-hidden">

<div class="bg-primary p-4 text-white text-center">

<h3 class="fw-bold mb-0">👤 Registrasi Anggota</h3>

<p class="mb-0 opacity-75">Khusus Mahasiswa dan Dosen</p>

</div>



<div class="card-body p-4 p-lg-5">

<form action="proses_tambah_user.php" method="POST">

<h5 class="fw-bold mb-3 text-primary border-bottom pb-2">Data Akun</h5>

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">Nama Lengkap</label>

<input type="text" name="nama" class="form-control rounded-pill" required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">Email</label>

<input type="email" name="email" class="form-control rounded-pill" required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">Password</label>

<input type="password" name="password" class="form-control rounded-pill" required>

</div>

<div class="col-md-6 mb-3">

<label class="form-label fw-semibold">Status / Role</label>

<select id="roleSelect" name="role" class="form-select rounded-pill" required onchange="toggleFields()">

<option value="">-- Pilih Status --</option>

<option value="mahasiswa">Mahasiswa</option>

<option value="dosen">Dosen</option>

</select>

</div>

</div>



<div id="spesifikFields" class="mt-4 pt-3 border-top" style="display:none;">

<div id="form-mahasiswa" class="role-form" style="display:none;">

<div class="row">

<div class="col-md-6 mb-3"><label class="form-label fw-semibold">NIM</label><input type="text" name="nim" class="form-control rounded-pill"></div>

<div class="col-md-6 mb-3"><label class="form-label fw-semibold">Jurusan</label><input type="text" name="jurusan" class="form-control rounded-pill"></div>

</div>

</div>

<div id="form-dosen" class="role-form" style="display:none;">

<div class="row">

<div class="col-md-6 mb-3"><label class="form-label fw-semibold">NIDN</label><input type="text" name="nidn" class="form-control rounded-pill"></div>

<div class="col-md-6 mb-3"><label class="form-label fw-semibold">Fakultas</label><input type="text" name="fakultas" class="form-control rounded-pill"></div>

</div>

</div>

</div>



<div class="d-grid gap-2 mt-4">

<button type="submit" class="btn btn-primary rounded-pill fw-bold py-2 shadow">DAFTAR SEKARANG</button>

<a href="login.php" class="btn btn-light rounded-pill fw-bold text-muted">SUDAH PUNYA AKUN? LOGIN</a>

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

forms.forEach(f => f.style.display = "none");

if (role !== "") {

container.style.display = "block";

document.getElementById("form-" + role).style.display = "block";

} else {

container.style.display = "none";

}

}

</script>

<?php include 'footer.php'; ?>