<?php
include('config/koneksi.php');
?>

<head>
    <link rel="stylesheet" href="assest/home.css">
</head>

<body>
    <div class="container">
        <div class="header-box">
            <h5>Peminjaman Hari ini Tanggal : <span>
                    <?= date('D d-m-Y H:i:s') ?>
                </span></h5>
            <div class="scroll-container">
                <div class="card-container">
                    <?php
                    $query = "SELECT * FROM muda_peminjaman WHERE tanggal_pinjam >= CURDATE() AND tanggal_kembali >= CURDATE()";
                    $conn = mysqli_query($connection, $query);

                    if (mysqli_num_rows($conn) > 0) {
                        while ($data = mysqli_fetch_array($conn)) {
                            $tanggalPeminjaman = strtotime($data['tanggal_pinjam']) + (1 * 60 * 60 * 24); // Waktu Delete
                    
                            // Check if the booking date has passed 1 hour or the return date has passed
                            if ($tanggalPeminjaman < time() || $data['tanggal_kembali'] < date('Y-m-d')) {
                                continue;
                            }
                            ?>

                            <div class="card">
                                <div class="row g-0">
                                    <div class="col-md-6">
                                        <div class="">
                                            <img src="module/pustaka/uploads/<?= $data['lokasi_file']; ?>" class="gambar-buku"
                                                alt="Images">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card-body">
                                            <label for="" class="form-label mb-0 mt-3 card-text" style="font-size:15px;">Id
                                                Peminjaman</label>
                                            <h6 class="card-text mb-0 mt-0">
                                                <?= $data['id_peminjaman'] ?>
                                            </h6>
                                            <hr class="mb-0 mt-0">
                                            <label for="" class="form-label mb-0 card-text" style="font-size:15px;">Nisn</label>
                                            <p class="card-text mb-0">
                                                <?= $data['nisn'] ?>
                                            </p>
                                            <hr class="mb-0 mt-0">
                                            <label for="" class="form-label mb-0 card-text" style="font-size:15px;">Tgl
                                                Kembali</label>
                                            <p class="card-text">
                                                <?= $data['tanggal_kembali'] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7">Belum Ada Peminjaman Hari Ini</td>
                        </tr>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>



        <div class="container mt-3">
            <form action="" method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="keyword" class="form-control" placeholder="Cari buku...">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
            <div class="d-flex justify-content-between mb-3 mx-3">
                <div>
                    <a href="?module=home" class="btn btn-secondary">
                        Refresh
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            include('config/koneksi.php');

            // Memeriksa apakah ada parameter pencarian
            if (isset($_POST['keyword'])) {
                $keyword = $_POST['keyword'];
                // Query dengan filter pencarian
                $query_buku = "SELECT `isbn`, `judul_buku`, `pengarang`, `penerbit`, `tahun_terbit`, `jenis_buku`, `stok`, `lokasi_file` FROM muda_buku WHERE judul_buku LIKE '%$keyword%' OR isbn LIKE '%$keyword%' OR pengarang LIKE '%$keyword%' OR penerbit LIKE '%$keyword%' OR tahun_terbit LIKE '%$keyword%'OR jenis_buku LIKE '%$keyword%'";
            } else {
                // Query tanpa filter pencarian
                $query_buku = "SELECT `isbn`, `judul_buku`, `pengarang`, `penerbit`, `tahun_terbit`, `jenis_buku`, `stok`, `lokasi_file` FROM `muda_buku` WHERE stok > 0";
            }



            $conn_buku = mysqli_query($connection, $query_buku);
            while ($data_buku = mysqli_fetch_array($conn_buku)) {
                ?>

                <style>
                    .card::before {
                        content: "";
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background-image: url('module/buku/uploads/<?= $data_buku['lokasi_file']; ?>');
                        background-size: cover;
                        background-repeat: no-repeat;
                        filter: blur(2px);
                        border-radius: 8px;

                    }
                </style>
                <div class="card" id="card">
                    <img src="module/buku/uploads/<?= $data_buku['lokasi_file']; ?>" class="gambar-buku" alt="">
                    <div class="card-body">
                        <h5 class="card-title" id="">
                            <?= $data_buku['judul_buku']; ?>
                        </h5>
                        <p class="card-author" id="card2">
                            <?= $data_buku['pengarang']; ?>
                        </p>
                        <p class="card-description" id="card3">ISBN:
                            <?= $data_buku['isbn']; ?>
                        </p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#pinjamModal<?= $data_buku['isbn']; ?>">
                            Pinjam Buku
                        </button>
                    </div>
                </div>

                <!-- Pinjam Buku Modal -->
                <div class="modal fade" id="pinjamModal<?= $data_buku['isbn']; ?>" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Pinjam Buku</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="module/pustaka/aksi.php?module=pustaka&act=insert" method="post"
                                    enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <label class="form-label">ISBN</label>
                                        <input type="text" class="form-control" name="isbn"
                                            value="<?= $data_buku['isbn']; ?>" required readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <select class="form-control" name="nisn" required>
                                            <option value="" selected>Pilih Nama</option>
                                            <?php
                                            include("config/koneksi.php");
                                            $query_siswa = "SELECT * FROM muda_siswa";
                                            $conn_siswa = mysqli_query($connection, $query_siswa);
                                            while ($data = mysqli_fetch_array($conn_siswa)) {
                                                ?>
                                                <option value="<?= $data['nisn']; ?>"><?= $data['nama_siswa']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Kembali</label>
                                        <input type="date" class="form-control" name="tanggal_kembali" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="pinjam" selected>Pinjam</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <!-- Input file untuk menyimpan nilai gambar yang belum ada -->
                                        <!-- <input type="file" name="lokasi_gambar" id=""> -->
                                        <!-- Input hidden untuk menyimpan nilai gambar yang sudah ada -->
                                        <input type="hidden" name="lokasi_gambar_existing"
                                            value="<?= $data_buku['lokasi_file']; ?>">

                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary">Pinjam</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

            }
            mysqli_close($connection);
            ?>
        </div>

</body>