<h1 style="text-align:center;">Halaman Peminjaman Buku Pustaka</h1>


<!-- Form pencarian -->
<form action="" method="POST">
  <div class="input-group mb-3">
    <input type="text" name="keyword" class="form-control" placeholder="Cari buku...">
    <button class="btn btn-primary" type="submit">Cari</button>
  </div>
</form>
<?php
if (!empty($_SESSION['alert'])):
  echo $_SESSION['alert'];
endif;
unset($_SESSION['alert']);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Data Peminjaman</h3>
  <div>
    <a href="?module=pustaka" class="btn btn-secondary">
      Refresh
    </a>
  </div>
</div>
<div class="container">
  <div class="row">
    <?php

    include('config/koneksi.php');
    if (isset($_POST['keyword'])) {
      $keyword = $_POST['keyword'];
      // Query dengan filter pencarian
      $query = "SELECT * FROM muda_peminjaman WHERE id_peminjaman LIKE '%$keyword%' OR nisn LIKE '%$keyword%' OR isbn LIKE '%$keyword%' OR tanggal_pinjam LIKE '%$keyword%'";
    } else {
      // Query tanpa filter pencarian
      $query = "SELECT * FROM muda_peminjaman as p
                JOIN muda_siswa as s
                ON p.nisn = s.nisn 
                JOIN muda_buku as b
                ON p.isbn = b.isbn;";
    }

    $conn = mysqli_query($connection, $query);
    while ($data = mysqli_fetch_array($conn)) {
      ?>
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">ID Peminjaman:
              <?= $data["id_peminjaman"]; ?>
            </h5>
            <hr>
            <p class="card-text">NISN:
              <?= $data["nisn"]; ?>
            </p>
            <p class="card-text">Nama:
              <?= $data["nama_siswa"]; ?>
            </p>
            <p class="card-text">Judul Buku:
              <?= $data["judul_buku"]; ?>
            </p>
            <p class="card-text">Tanggal Pinjam:
              <?= date('d-m-Y', strtotime($data["tanggal_pinjam"])); ?>
            </p>
            <p class="card-text">Tanggal Kembali:
              <?= date('d-m-Y', strtotime($data["tanggal_kembali"])); ?>
            </p>
            <p class="card-text">Status:
              <?= $data["status"]; ?>
            </p>

            <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
              data-bs-target="#editModal<?= $data['id_peminjaman']; ?>">Edit Data Peminjaman</button>
            <button type="submit" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $data['id_peminjaman']; ?>"
              class="btn btn-danger">Delete</button>
          </div>
        </div>
      </div>

      <!-- Modal Delete -->
      <div class="modal fade" style="" id="deleteModal<?= $data['id_peminjaman']; ?>" tabindex="-1"
        aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Anda yakin ingin Menghapus Data
                <?= $data['nisn']; ?> ?
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <a href="module/pustaka/aksi.php?module=pustaka&act=delete&id=<?= $data['id_peminjaman']; ?>&isbn=<?= $data['isbn']; ?>"
                class="btn btn-danger">Hapus</a>
            </div>
          </div>
        </div>
      </div>


      <!-- Modal Edit Data Siswa-->
      <div class="modal fade" id="editModal<?= $data['id_peminjaman']; ?>" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data Peminjaman</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="module/pustaka/aksi.php?module=pustaka&act=update" method="POST">
                <!-- Form -->
                <div class="modal-body">
                  <div class="form-group">
                    <label for="id_peminjaman">Id Peminjaman:</label>
                    <input type="text" class="form-control" id="id_peminjaman" name="id_peminjaman"
                      value="<?php echo $data['id_peminjaman']; ?>" readonly>
                  </div>

                  <div class="form-group">
                    <label for="nisn">NISN:</label>
                    <input type="text" class="form-control" id="nisn" name="nisn" value="<?php echo $data['nisn']; ?>"
                      readonly>
                  </div>

                  <div class="form-group">
                    <label for="isbn">Judul Buku:</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo $data['isbn']; ?>"
                      readonly>
                  </div>

                  <div class="form-group">
                    <label for="tanggal_pinjam">Tanggal Pinjam:</label>
                    <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam"
                      value="<?php echo $data['tanggal_pinjam']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="tanggal_kembali">Tanggal Kembali:</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                      value="<?php echo $data['tanggal_kembali']; ?>">
                  </div>

                  <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status">
                      <option value="pinjam" <?php if ($data['status'] == 'pinjam')
                        echo 'selected'; ?>>
                        Dipinjam</option>
                      <option value="selesai" <?php if ($data['status'] == 'selesai')
                        echo 'selected'; ?>>
                        Dikembalikan</option>
                    </select>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Edit End -->
      <?php
    }
    mysqli_close($connection);
    ?>
  </div>
</div>