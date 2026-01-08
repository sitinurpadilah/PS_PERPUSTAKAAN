<?php
include 'koneksi.php';
session_start();

// Proteksi: Hanya Staff/Admin yang bisa memproses
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'staff' && $_SESSION['role'] != 'admin')) {
    echo "<script>alert('Akses Ditolak!'); window.location='index.php';</script>";
    exit;
}

if (isset($_GET['isbn']) && isset($_GET['id_pinjam'])) {
    $isbn = mysqli_real_escape_string($koneksi, $_GET['isbn']);
    $id_pinjam = mysqli_real_escape_string($koneksi, $_GET['id_pinjam']);

    // 1. Update status peminjaman
    $sql_pinjam = "UPDATE peminjaman SET status='dikembalikan' WHERE id='$id_pinjam'";
    $query_pinjam = mysqli_query($koneksi, $sql_pinjam);

    // 2. Update status buku agar bisa dipinjam lagi
    $sql_buku = "UPDATE buku SET status='tersedia' WHERE isbn='$isbn'";
    $query_buku = mysqli_query($koneksi, $sql_buku);

    if ($query_pinjam && $query_buku) {
        echo "<script>
                alert('Buku Berhasil Diterima Kembali!');
                window.location='daftar_peminjam.php';
              </script>";
    } else {
        echo "Gagal Update: " . mysqli_error($koneksi);
    }
} else {
    header("Location: daftar_peminjam.php");
}
?>