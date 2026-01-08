<?php
include 'koneksi.php';
session_start();

// Proteksi: Pastikan hanya Admin yang bisa menjalankan proses rekap
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location='index.php';</script>";
    exit;
}

// 1. Ambil Nama Bulan dan Tahun saat ini (Contoh: December 2025)
$periode = date('F Y'); 

// 2. Hitung jumlah transaksi dari daftar peminjam
$sql_transaksi = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peminjaman");
$data_transaksi = mysqli_fetch_assoc($sql_transaksi);
$total_transaksi = $data_transaksi['total'] ?? 0;

// 3. Hitung jumlah buku yang statusnya masih 'DIPINJAM'
// Menggunakan UPPER untuk mengantisipasi perbedaan penulisan di database
$sql_pinjam = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM buku WHERE UPPER(status)='DIPINJAM'");
$data_pinjam = mysqli_fetch_assoc($sql_pinjam);
$total_buku_dipinjam = $data_pinjam['total'] ?? 0;

// 4. Cek apakah laporan periode ini sudah ada?
$cek = mysqli_query($koneksi, "SELECT id FROM laporan WHERE periode = '$periode'");

if (mysqli_num_rows($cek) > 0) {
    // Jika sudah ada, perbarui datanya (UPDATE)
    $query = "UPDATE laporan SET 
              total_transaksi = '$total_transaksi', 
              total_buku_dipinjam = '$total_buku_dipinjam' 
              WHERE periode = '$periode'";
} else {
    // Jika belum ada, masukkan data baru (INSERT)
    $query = "INSERT INTO laporan (periode, total_transaksi, total_buku_dipinjam) 
              VALUES ('$periode', '$total_transaksi', '$total_buku_dipinjam')";
}

// Eksekusi Query
if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Berhasil! Data laporan periode $periode telah diperbarui.'); window.location='laporan.php';</script>";
} else {
    echo "Gagal memperbarui database: " . mysqli_error($koneksi);
}
?>