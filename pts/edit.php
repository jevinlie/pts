<?php
include 'koneksi.php';

// Ambil ID dari URL
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $result = mysqli_query($koneksi, "SELECT * FROM pengumuman_sekolah WHERE id_pengumuman = $id");
    $data = mysqli_fetch_assoc($result);

    if(!$data){
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

// Proses Update Data
if(isset($_POST['update'])){
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $tanggal_terbit = $_POST['tanggal_terbit'];

    $query = "UPDATE pengumuman_sekolah SET judul='$judul', isi='$isi', kategori='$kategori', tanggal_terbit='$tanggal_terbit' WHERE id_pengumuman=$id";
    
    if(mysqli_query($koneksi, $query)){
        header("Location: index.php");
        exit();
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pengumuman</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f9; }
        form { background: #fff; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 500px; }
        input[type="text"], input[type="date"], textarea { width: 100%; padding: 8px; margin: 5px 0 15px 0; display: inline-block; border: 1px solid #ccc; box-sizing: border-box; }
        button { background-color: #ffc107; color: black; padding: 10px 15px; border: none; cursor: pointer; border-radius: 3px; font-weight: bold; }
        button:hover { background-color: #e0a800; }
        a { text-decoration: none; color: #007bff; margin-left: 10px; }
    </style>
</head>
<body>

    <h2>Edit Pengumuman</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="">
        <label>Judul Pengumuman:</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($data['judul']); ?>" maxlength="100" required>

        <label>Isi Pengumuman:</label>
        <textarea name="isi" rows="4" required><?= htmlspecialchars($data['isi']); ?></textarea>

        <label>Kategori:</label>
        <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']); ?>" maxlength="30" required>

        <label>Tanggal Terbit:</label>
        <input type="date" name="tanggal_terbit" value="<?= $data['tanggal_terbit']; ?>" required>

        <button type="submit" name="update">Update Pengumuman</button>
        <a href="index.php">Kembali</a>
    </form>

</body>
</html>