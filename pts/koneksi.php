<?php
    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "pengumuman_sekolah_jevin";

    $koneksi = mysqli_connect($host, $username, $password, $db);

    if(!$koneksi){
        die("Koneksi gagal: " . mysqli_connect_error());
    }
    
    // Hapus atau comment baris echo di bawah ini agar redirect header() berfungsi normal:
    // if($koneksi){
    //     echo "Database berhasil";
    // }
?>