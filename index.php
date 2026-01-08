<?php 
include 'koneksi.php';
include 'header.php'; 
?>

<div class="bg-biru text-white py-5 mb-5 shadow">
    <div class="container text-center">
        <h1 class="fw-bold display-5">koleksi perpustakaan</h1>
        <p class="lead mb-4">Perpustakaan: tempat pura-pura rajin</p>
        
        <?php if(!isset($_SESSION['user_id'])): ?>
            <div class="d-flex justify-content-center gap-3">
                <a href="login.php" class="btn btn-outline-light px-4 py-2 rounded-pill fw-bold">
                    <i class="bi bi-box-arrow-in-right me-1"></i> MASUK
                </a>
                <a href="tambah_user.php" class="btn btn-warning text-dark px-4 py-2 rounded-pill fw-bold shadow">
                    <i class="bi bi-person-plus-fill me-1"></i> DAFTAR ANGGOTA BARU
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        <?php
        $query = mysqli_query($koneksi, "SELECT * FROM buku ORDER BY judul ASC");
        
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_array($query)) :
                $foto = (!empty($row['foto'])) ? $row['foto'] : 'default.jpg';
        ?>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden card-hover">
                <div class="position-relative">
                    <img src="assets/img/buku/<?php echo $foto; ?>" 
                         class="card-img-top" 
                         alt="<?php echo $row['judul']; ?>"
                         style="height: 300px; object-fit: cover;">
                    
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge rounded-pill <?php echo ($row['status'] == 'tersedia') ? 'bg-success' : 'bg-danger'; ?> px-3 shadow">
                            <?php echo strtoupper($row['status']); ?>
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <small class="text-muted d-block mb-1"><?php echo $row['penerbit']; ?></small>
                    <h6 class="card-title fw-bold text-biru-gelap mb-2 text-truncate-2" style="height: 45px;">
                        <?php echo $row['judul']; ?>
                    </h6>
                    <p class="card-text small text-muted mb-3">
                        <i class="bi bi-person me-1"></i> <?php echo $row['pengarang']; ?>
                    </p>
                    
                    <div class="d-grid">
                        <a href="detail_buku.php?isbn=<?php echo $row['isbn']; ?>" 
                           class="btn <?php echo ($row['status'] == 'tersedia') ? 'btn-biru' : 'btn-outline-secondary disabled'; ?> rounded-pill fw-bold btn-sm">
                           <?php echo ($row['status'] == 'tersedia') ? 'Lihat Detail' : 'Tidak Tersedia'; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            endwhile; 
        } else {
            echo "<div class='col-12 text-center py-5'><h4 class='text-muted'>Belum ada koleksi buku.</h4></div>";
        }
        ?>
    </div>
</div>

<style>
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .btn-biru {
        background-color: #0d6efd;
        color: white;
    }
    .btn-biru:hover {
        background-color: #0b5ed7;
        color: white;
    }
    .bg-biru {
        background-color: #0d6efd;
    }
</style>

<?php include 'footer.php'; ?>