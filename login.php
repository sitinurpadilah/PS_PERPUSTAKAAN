<?php 
include 'koneksi.php';
session_start(); 

// Jika sudah login, langsung lempar ke index
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Masuk - koleksi buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; }
        .login-card { max-width: 400px; margin-top: 100px; border-radius: 15px; border: none; }
    </style>
</head>
<body>

<div class="container">
    <div class="card login-card shadow mx-auto">
        <div class="card-body p-5">
            <h3 class="text-center fw-bold mb-4 text-primary">MASUK</h3>
            <p class="text-center text-muted small mb-4">Silakan masuk untuk melanjutkan peminjaman.</p>

            <form action="proses_login.php" method="POST">
                <input type="hidden" name="isbn_tujuan" value="<?php echo isset($_GET['isbn']) ? $_GET['isbn'] : ''; ?>">
                
                <div class="mb-3">
                    <label class="form-label small fw-bold">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
                <div class="mb-4">
                    <label class="form-label small fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="<3<3<3<3" required>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3">MASUK SEKARANG</button>
                
                <div class="text-center">
                    <a href="index.php" class="text-decoration-none small text-secondary">&larr; Kembali ke Katalog</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>