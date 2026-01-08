<?php
session_start();
// Menghapus semua data session
session_destroy();

// Mengarahkan kembali ke halaman utama atau login
echo "<script>
        alert('Anda telah berhasil keluar.'); 
        window.location='index.php';
      </script>";
?>