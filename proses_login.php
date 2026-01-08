<?php
session_start();
include 'koneksi.php';

// Tangkap data dari form login
$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = $_POST['password']; // Teks asli

// Query cari user berdasarkan username (gunakan kolom email jika username di tabel Anda adalah email)
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$username' OR nama='$username'");
$user  = mysqli_fetch_array($query);

if ($user) {
    // Cek apakah password di database sama dengan password yang diinput
    if ($password == $user['password']) {
        
        // Simpan data ke Session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama']    = $user['nama'];
        $_SESSION['role']    = $user['role'];

        // Cek jika ada tujuan ISBN (untuk fitur pinjam langsung setelah login)
        $isbn_tujuan = $_POST['isbn_tujuan'];
        
        if (!empty($isbn_tujuan)) {
            header("Location: detail_buku.php?isbn=$isbn_tujuan");
        } else {
            header("Location: index.php");
        }
    } else {
        // Jika password salah
        echo "<script>alert('Password yang anda masukkan salah'); window.location='login.php';</script>";
    }
} else {
    // Jika username tidak ditemukan
    echo "<script>alert('Username/Email tidak terdaftar'); window.location='login.php';</script>";
}
?>