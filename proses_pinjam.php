<?php
session_start(); 
include 'koneksi.php';

// 1. Proteksi Login
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Silakan login terlebih dahulu!'); window.location='login.php';</script>";
    exit;
}

// Menangkap ISBN dari URL (GET) sesuai dengan link di detail_buku.php
if (isset($_GET['isbn'])) {
    
    $user_id     = $_SESSION['user_id']; // Mengambil ID dari session login
    $isbn        = mysqli_real_escape_string($koneksi, $_GET['isbn']);
    $tgl_pinjam  = date('Y-m-d'); // Tanggal otomatis hari ini
    $status_awal = 'dipinjam'; 

    // 2. Cek apakah buku benar-benar masih tersedia (Proteksi Tambahan)
    $cek_buku = mysqli_query($koneksi, "SELECT status FROM buku WHERE isbn = '$isbn'");
    $data_buku = mysqli_fetch_array($cek_buku);

    // Menggunakan strtolower untuk memastikan kecocokan teks
    if (strtolower($data_buku['status']) !== 'tersedia') {
        echo "<script>alert('Maaf, buku ini sedang tidak tersedia atau sudah dipinjam orang lain!'); window.location='index.php';</script>";
        exit;
    }

    // 3. Mulai Transaksi Database
    mysqli_begin_transaction($koneksi);

    try {
        // QUERY 1: Simpan ke tabel peminjaman
        $sql_pinjam = "INSERT INTO peminjaman (user_id, isbn, tanggal_pinjam, status) 
                       VALUES ('$user_id', '$isbn', '$tgl_pinjam', '$status_awal')";
                       
        if (!mysqli_query($koneksi, $sql_pinjam)) {
            throw new Exception("Gagal simpan transaksi peminjaman. Periksa relasi Foreign Key.");
        }

        // QUERY 2: Update status di tabel buku menjadi 'dipinjam'
        $sql_update_buku = "UPDATE buku SET status='dipinjam' WHERE isbn='$isbn'";
        
        if (!mysqli_query($koneksi, $sql_update_buku)) {
            throw new Exception("Gagal memperbarui status buku.");
        }

        // Jika semua oke, simpan permanen
        mysqli_commit($koneksi);
        
        // 4. Redirect ke halaman riwayat pinjam
        echo "<script>
                alert('Peminjaman berhasil! Selamat membaca.'); 
                window.location='peminjaman_saya.php';
              </script>";

    } catch (Exception $e) {
        // Membatalkan semua perubahan jika terjadi error (misal: error #1451)
        mysqli_rollback($koneksi);
        echo "<script>
                alert('Terjadi kesalahan: " . $e->getMessage() . "'); 
                window.location='index.php';
              </script>";
    }

} else {
    header("location: index.php");
}
?>