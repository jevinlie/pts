<?php
include 'koneksi.php';

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    
    $query = "DELETE FROM pengumuman_sekolah WHERE id_pengumuman = $id";
    if(mysqli_query($koneksi, $query)){
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: index.php");
    exit();
}
?>