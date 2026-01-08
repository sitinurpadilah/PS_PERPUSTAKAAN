<?php
// 1. Panggil koneksi database
include 'koneksi.php';

// Cek apakah data sudah dikirim melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 2. Tangkap data dari formulir & Sanitasi Data
    $isbn      = mysqli_real_escape_string($koneksi, $_POST['isbn']);
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($koneksi, $_POST['pengarang']);
    $penerbit  = mysqli_real_escape_string($koneksi, $_POST['penerbit']);
    $status    = mysqli_real_escape_string($koneksi, $_POST['status']); 
    
    // --- LOGIKA UPLOAD FOTO ---
    $foto_name = $_FILES['foto']['name'];
    $foto_tmp  = $_FILES['foto']['tmp_name'];
    $foto_size = $_FILES['foto']['size'];
    $foto_error = $_FILES['foto']['error'];

    // Jika user mengunggah foto
    if ($foto_error === 0) {
        $ekstensi_valid = ['jpg', 'jpeg', 'png'];
        $ekstensi_foto  = explode('.', $foto_name);
        $ekstensi_foto  = strtolower(end($ekstensi_foto));

        // Cek format file
        if (!in_array($ekstensi_foto, $ekstensi_valid)) {
            echo "<script>alert('Format gambar harus JPG atau PNG!'); window.history.back();</script>";
            exit;
        }

        // Cek ukuran file (Maks 2MB)
        if ($foto_size > 2000000) {
            echo "<script>alert('Ukuran gambar terlalu besar! Maks 2MB.'); window.history.back();</script>";
            exit;
        }

        // Generate nama unik untuk foto (Contoh: 978123_20240101.jpg)
        $nama_foto_baru = $isbn . '_' . time() . '.' . $ekstensi_foto;
        $tujuan_upload = 'assets/img/buku/' . $nama_foto_baru;

        // Pindahkan file dari folder sementara ke folder assets
        move_uploaded_file($foto_tmp, $tujuan_upload);
    } else {
        // Jika tidak upload foto, gunakan foto default
        $nama_foto_baru = 'default.jpg';
    }

    // 3. Susun perintah SQL (Sekarang 6 kolom termasuk foto)
    $sql = "INSERT INTO buku (isbn, judul, pengarang, penerbit, status, foto) 
            VALUES ('$isbn', '$judul', '$pengarang', '$penerbit', '$status', '$nama_foto_baru')";
            
    // 4. Jalankan perintah SQL
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data buku berhasil ditambahkan!'); window.location='buku.php';</script>";
    } else {
        echo "<script>alert('Gagal! " . mysqli_error($koneksi) . "'); window.history.back();</script>";
    }
} else {
    header("location: buku.php");
}

// 5. Tutup koneksi
mysqli_close($koneksi);
?>