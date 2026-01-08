<?php
$host = "localhost"; // Lokasi server database
$user = "root";      // Username default XAMPP
$pass = "";          // Password default XAMPP (kosong)
$db   = "perpustakaan"; // Nama database yang kita buat

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
// echo "Koneksi berhasil!"; // Opsional: Hapus setelah testing
?>