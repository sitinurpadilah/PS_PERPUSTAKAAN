<?php


?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data Buku</title>
</head>
<body>

    <h2>Formulir Tambah Buku</h2>
    <form action="proses_tambah_buku.php" method="POST">
        
        <label for="isbn">ISBN:</label><br>
        <input type="text" id="isbn" name="isbn" required><br><br>

        <label for="judul">Judul Buku:</label><br>
        <input type="text" id="judul" name="judul" required><br><br>

        <label for="pengarang">Pengarang:</label><br>
        <input type="text" id="pengarang" name="pengarang"><br><br>

        <label for="penerbit">Penerbit:</label><br>
        <input type="text" id="penerbit" name="penerbit"><br><br>
        
        <label for="status">Status Awal:</label><br>
        <select id="status" name="status">
            <option value="Tersedia">Tersedia</option>
            <option value="Dipinjam">Dipinjam</option>
        </select><br><br>

        <input type="submit" value="Simpan Buku">
    </form>
    
    <br>
    <a href="index.php">Kembali ke Daftar Buku</a>

</body>
</html>