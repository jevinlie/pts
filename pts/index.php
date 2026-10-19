<?php
include 'koneksi.php';

// Proses Tambah Data
if(isset($_POST['tambah'])){
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi = mysqli_real_escape_string($koneksi, $_POST['isi']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $tanggal_terbit = $_POST['tanggal_terbit'];

    $query = "INSERT INTO pengumuman_sekolah (judul, isi, kategori, tanggal_terbit) VALUES ('$judul', '$isi', '$kategori', '$tanggal_terbit')";
    if(mysqli_query($koneksi, $query)){
        header("Location: index.php");
        exit();
    } else {
        $error = "Gagal menambah data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengumuman Sekolah</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">
                <i class="bi bi-megaphone-fill me-2"></i>Pengumuman Sekolah
            </a>
        </div>
    </nav>

    <div class="container pb-5">
        <div class="row g-4">
            
            <!-- Form Tambah Data -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="bi bi-plus-circle me-1"></i> Tambah Pengumuman
                    </div>
                    <div class="card-body">
                        <?php if(isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Judul Pengumuman</label>
                                <input type="text" name="judul" class="form-control" maxlength="100" placeholder="Masukkan judul" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Isi Pengumuman</label>
                                <textarea name="isi" class="form-control" rows="4" placeholder="Tulis isi pengumuman..." required></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Kategori</label>
                                <input type="text" name="kategori" class="form-control" maxlength="30" placeholder="Contoh: Akademik, Kegiatan" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Tanggal Terbit</label>
                                <input type="date" name="tanggal_terbit" class="form-control" required>
                            </div>

                            <button type="submit" name="tambah" class="btn btn-success w-100">
                                <i class="bi bi-save me-1"></i> Simpan Pengumuman
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabel Daftar Data -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-primary">
                            <i class="bi bi-list-task me-2"></i>Daftar Pengumuman
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>Judul</th>
                                        <th>Isi</th>
                                        <th>Kategori</th>
                                        <th>Tanggal Terbit</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM pengumuman_sekolah ORDER BY tanggal_terbit DESC";
                                    $result = mysqli_query($koneksi, $query);

                                    if (!$result) {
                                        echo "<tr><td colspan='6' class='text-center text-danger py-3'>Error Query: " . mysqli_error($koneksi) . "</td></tr>";
                                    } else {
                                        if(mysqli_num_rows($result) > 0){
                                            while($row = mysqli_fetch_assoc($result)){
                                                echo "<tr>";
                                                echo "<td class='ps-3 fw-bold text-muted'>" . $row['id_pengumuman'] . "</td>";
                                                echo "<td class='fw-semibold'>" . htmlspecialchars($row['judul']) . "</td>";
                                                echo "<td>" . nl2br(htmlspecialchars($row['isi'])) . "</td>";
                                                echo "<td><span class='badge bg-info text-dark'>" . htmlspecialchars($row['kategori']) . "</span></td>";
                                                echo "<td><small class='text-muted'>" . date('d M Y', strtotime($row['tanggal_terbit'])) . "</small></td>";
                                                echo "<td class='text-center'>
                                                        <div class='btn-group btn-group-sm' role='group'>
                                                            <a href='edit.php?id=" . $row['id_pengumuman'] . "' class='btn btn-warning text-white' title='Edit'><i class='bi bi-pencil-square'></i></a> 
                                                            <a href='delete.php?id=" . $row['id_pengumuman'] . "' class='btn btn-danger' onclick='return confirm(\"Yakin ingin menghapus pengumuman ini?\")' title='Hapus'><i class='bi bi-trash'></i></a>
                                                        </div>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center text-muted py-4'>Belum ada pengumuman yang ditambahkan.</td></tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>