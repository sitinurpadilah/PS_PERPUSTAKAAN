<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

// Cek session untuk menentukan arah redirect jika gagal
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Tangkap Data Umum
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']); 
    $role     = $_POST['role'];
    
    // Tangkap sumber halaman (untuk redirect balik)
    $source   = isset($_POST['source']) ? $_POST['source'] : 'public';

    // 2. Tangkap Data Spesifik (Gunakan null coalescing agar tidak error jika tidak ada)
    $nim      = isset($_POST['nim']) ? $_POST['nim'] : '';
    $jurusan  = isset($_POST['jurusan']) ? $_POST['jurusan'] : '';
    $nidn     = isset($_POST['nidn']) ? $_POST['nidn'] : '';
    $fakultas = isset($_POST['fakultas']) ? $_POST['fakultas'] : '';
    $id_staff = isset($_POST['id_staff']) ? $_POST['id_staff'] : ''; // Ini data identitas staff
    
    // Tentukan kemana harus kembali jika gagal/berhasil
    $redirect_url = ($source == 'admin_panel') ? 'admin_tambah_user.php' : 'tambah_user.php';
    if($source == 'admin_panel' && isset($_POST['role']) && $_POST['role'] != 'admin') {
        $success_url = 'daftar_user.php'; // Admin lebih baik kembali ke daftar setelah input
    } else {
        $success_url = $redirect_url;
    }

    // 3. MULAI TRANSAKSI DATABASE
    mysqli_begin_transaction($koneksi);

    try {
        // QUERY 1: Simpan ke tabel users
        $sql_user = "INSERT INTO users (nama, email, password, role) 
                     VALUES ('$nama', '$email', '$password', '$role')";
        
        if (!mysqli_query($koneksi, $sql_user)) {
            throw new Exception("Email sudah terdaftar atau kesalahan data utama.");
        }
        
        $user_id = mysqli_insert_id($koneksi);

        // QUERY 2: Simpan ke tabel spesifik sesuai Role
        $sql_spesifik = "";
        
        switch ($role) {
            case 'mahasiswa':
                $sql_spesifik = "INSERT INTO mahasiswa (user_id, nim, jurusan) 
                                 VALUES ('$user_id', '$nim', '$jurusan')";
                break;
            case 'dosen':
                $sql_spesifik = "INSERT INTO dosen (user_id, nidn, fakultas) 
                                 VALUES ('$user_id', '$nidn', '$fakultas')";
                break;
            case 'staff':
                // Karena Anda bilang tidak ada kolom id_staff, 
                // kita asumsikan kolom identitas di tabel staff bernama 'nama'
                // atau sesuaikan dengan kolom yang tersedia di tabel staff Anda
                $sql_spesifik = "INSERT INTO staff (user_id, nama) 
                                 VALUES ('$user_id', '$id_staff')";
                break;
            case 'admin':
                // Admin biasanya tidak punya tabel spesifik, jadi tidak perlu insert tambahan
                $sql_spesifik = "";
                break;
        }
        
        if (!empty($sql_spesifik)) {
            if (!mysqli_query($koneksi, $sql_spesifik)) {
                throw new Exception("Gagal menyimpan detail profil $role.");
            }
        }

        mysqli_commit($koneksi);
        echo "<script>alert('Berhasil! User $nama sebagai $role telah didaftarkan.'); window.location='$success_url';</script>";

    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo "<script>alert('Gagal: " . $e->getMessage() . "'); window.location='$redirect_url';</script>";
    }

    mysqli_close($koneksi);

} else {
    header("location: index.php");
}
?>