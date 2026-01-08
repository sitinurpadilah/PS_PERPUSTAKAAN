<?php
include 'koneksi.php';

if(isset($_GET['isbn'])) {
    $isbn = mysqli_real_escape_string($koneksi, $_GET['isbn']);
    
    // Pastikan buku tidak sedang dipinjam sebelum dihapus (opsional tapi disarankan)
    $hapus = mysqli_query($koneksi, "DELETE FROM buku WHERE isbn='$isbn'");
    
    if($hapus) {
        echo "<script>alert('Buku berhasil dihapus!'); window.location='buku.php';</script>";
    } else {
        echo "<script>alert('Buku tidak bisa dihapus karena masih terkait data peminjaman!'); window.location='buku.php';</script>";
    }
} else {
    header("Location: buku.php");
}
?>