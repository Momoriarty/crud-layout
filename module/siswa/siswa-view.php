<div class="card-body">
  <!-- Form pencarian -->
  <form action="" method="post">
    <div class="input-group mb-3">
      <input type="text" name="keyword" class="form-control" placeholder="Cari siswa...">
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
    <h3>Data Siswa</h3>
    <div>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#siswaModal">
        Tambah Data
      </button>
      <a href="?module=siswa" class="btn btn-secondary">
        Refresh
      </a>
    </div>
  </div>

  <div class="row">
    <?php
    include('config/koneksi.php');
    $no = 1;

    // Memeriksa apakah ada parameter pencarian
    if (isset($_POST['keyword'])) {
      $keyword = $_POST['keyword'];
      // Query dengan filter pencarian
      $query = "SELECT * FROM muda_siswa WHERE nisn LIKE '%$keyword%' OR nama_siswa LIKE '%$keyword%' OR jurusan LIKE '%$keyword%' OR no_hp LIKE '%$keyword%' OR alamat LIKE '%$keyword%'";
    } else {
      // Query tanpa filter pencarian
      $query = "SELECT * FROM muda_siswa";
    }

    $conn = mysqli_query($connection, $query);
    while ($data = mysqli_fetch_array($conn)) {
      ?>
      <!-- Data siswa -->
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">
              <?= $data['nama_siswa']; ?>
            </h5>
            <hr>
            <p class="card-text"><strong>NISN:</strong>
              <?= $data['nisn']; ?>
            </p>
            <p class="card-text"><strong>Jurusan:</strong>
              <?= $data['jurusan']; ?>
            </p>
            <p class="card-text"><strong>No Hp:</strong>
              <?= $data['no_hp']; ?>
            </p>
            <p class="card-text"><strong>Jenis Kelamin:</strong>
              <?= $data['jenis_kelamin']; ?>
            </p>
            <p class="card-text"><strong>Alamat:</strong>
              <?= $data['alamat']; ?>
            </p>
            <div class="text-end">
              <!-- Button trigger modal -->
              <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                data-bs-target="#editModal<?= $data['nisn']; ?>">
                Edit Data Siswa
              </button>
              <button data-bs-toggle="modal" data-bs-target="#deleteModal<?= $data['nisn']; ?>"
                class="btn btn-danger">Delete</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Delete -->
      <div class="modal fade" style="" id="deleteModal<?= $data['nisn']; ?>" tabindex="-1"
        aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Anda yakin ingin Menghapus Siswa
                <?= $data['nama_siswa']; ?>?
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <a href="module/siswa/aksi.php?module=siswa&act=delete&id=<?= $data['nisn']; ?>"
                class="btn btn-danger">Logout</a>
            </div>
          </div>
        </div>
      </div>


      <!-- Modal Edit Data Siswa-->
      <div class="modal fade" id="editModal<?= $data['nisn']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="module/siswa/aksi.php?module=siswa&act=update" method="POST">
                <!-- Form -->
                <div class="mb-3">
                  <label for="nisn" class="form-label">NISN</label>
                  <input type="text" name="nisn" class="form-control" id="" placeholder="NISN....."
                    value="<?= $data['nisn']; ?>" readonly>
                </div>
                <div class="mb-3">
                  <label for="nama_siswa" class="form-label">Nama Siswa</label>
                  <input type="text" name="nama" class="form-control" id="" placeholder="Nama....."
                    value="<?= $data['nama_siswa']; ?>">
                </div>
                <div class="mb-3">
                  <label for="jurusan" class="form-label">Jurusan</label>
                  <select name="jurusan" class="form-select" id="">
                    <option value="<?= $data['jurusan']; ?>" selected><?= $data['jurusan']; ?></option>
                    <option value="PPLG">PPLG</option>
                    <option value="TKJT">TKJT</option>
                    <option value="DKV">DKV</option>
                    <option value="AKL">AKL</option>
                    <option value="MPLB">MPLB</option>
                    <option value="Pemasaran">Pemasaran</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                  <select name="jenis_kelamin" class="form-select">
                    <?php if ($data['jenis_kelamin'] == 'L'): ?>
                      <option value="L" selected>Laki Laki</option>
                      <option value="P">Perempaun</option>
                    <?php else: ?>
                      <option value="L" selected>Laki Laki</option>
                      <option value="P">Perempaun</option>
                    <?php endif; ?>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="no_telp" class="form-label">No Hp</label>
                  <input type="text" name="no_hp" class="form-control" id="" placeholder="No Hp"
                    value="<?= $data['no_hp']; ?>">
                </div>
                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  <input type="text" name="alamat" class="form-control" id="" placeholder="Alamat....."
                    value="<?= $data['alamat']; ?>">
                </div>
                <div class="modal-footer">
                  <input type="hidden" name="nisn" value="<?= $data['nisn']; ?>">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" name="update">Update Data</button>
                </div>
            </div>

          </div>
        </div>
      </div>
      </form>

      <!-- Modal Edit End-->
    <?php } ?>
  </div>
</div>




<!-- Modal tambah Siswa -->
<div class="modal fade" id="siswaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fs-5" id="exampleModalLabel">Tambah Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="module/siswa/aksi.php?module=siswa&act=insert" method="post">
          <!-- Form -->
          <div class="mb-3">
            <label for="nisn" class="form-label">NISN</label>
            <input type="text" name="nisn" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="nama_siswa" class="form-label">Nama Siswa</label>
            <input type="text" name="nama_siswa" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <select name="jurusan" class="form-select" required>
              <option value="">--Pilih Jurusan--</option>
              <option value="PPLG">PPLG</option>
              <option value="TKJT">TKJT</option>
              <option value="DKV">DKV</option>
              <option value="AKL">AKL</option>
              <option value="MPLB">MPLB</option>
              <option value="Pemasaran">Pemasaran</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-select" required>
              <option value="L">Laki-Laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="no_telp" class="form-label">No Hp</label>
            <input type="text" name="no_hp" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" cols="10" rows="5" required></textarea>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Tambah Siswa</button>
      </div>
      </form>
    </div>
  </div>
</div>