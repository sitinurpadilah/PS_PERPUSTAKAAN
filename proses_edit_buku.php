<?php
include 'koneksi.php';

if (isset($_POST['update'])) {
    // Tangkap data dari form
    $isbn_lama = mysqli_real_escape_string($koneksi, $_POST['isbn_lama']);
    $isbn_baru = mysqli_real_escape_string($koneksi, $_POST['isbn']);
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit  = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $status    = mysqli_real_escape_string($koneksi, $_POST['status']);

    // Query Update
    $sql = "UPDATE buku SET 
            isbn = '$isbn_baru', 
            judul = '$judul', 
            pengarang = '$pengarang', 
            penerbit = '$penerbit', 
            status = '$status' 
            WHERE isbn = '$isbn_lama'";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data buku berhasil diperbarui!'); window.location='buku.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data: " . mysqli_error($koneksi) . "'); window.history.back();</script>";
    }
} else {
    header("Location: buku.php");
}

mysqli_close($koneksi);
?>