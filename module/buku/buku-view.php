<div class="card-body">

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
    <h3>Data Buku</h3>
    <div>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bukuModal">
        Tambah Data Buku
      </button>
      <a href="?module=buku" class="btn btn-secondary">
        Refresh
      </a>
    </div>
  </div>

  <div class="row">
    <?php
    include('config/koneksi.php');

    // Memeriksa apakah ada parameter pencarian
    if (isset($_POST['keyword'])) {
      $keyword = $_POST['keyword'];
      // Query dengan filter pencarian
      $query = "SELECT * FROM muda_buku WHERE judul_buku LIKE '%$keyword%' OR isbn LIKE '%$keyword%' OR pengarang LIKE '%$keyword%' OR penerbit LIKE '%$keyword%'";
    } else {
      // Query tanpa filter pencarian
      $query = "SELECT * FROM muda_buku";
    }


    $conn = mysqli_query($connection, $query);
    while ($data = mysqli_fetch_array($conn)) {
      ?>
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">
              <?= $data['judul_buku']; ?>
            </h5>
            <hr>
            <p class="card-text"><strong>ISBN:</strong>
              <?= $data['isbn']; ?>
            </p>
            <p class="card-text"><strong>Penulis:</strong>
              <?= $data['pengarang']; ?>
            </p>
            <p class="card-text"><strong>Penerbit:</strong>
              <?= $data['penerbit']; ?>
            </p>
            <p class="card-text"><strong>Jenis Buku:</strong>
              <?= $data['jenis_buku']; ?>
            </p>
            <p class="card-text"><strong>Tahun Terbit:</strong>
              <?= $data['tahun_terbit']; ?>
            </p>
            <p class="card-text"><strong>Stok:</strong>
              <?= $data['stok']; ?>
            </p>
            <div class="text-end">
              <button type="submit" class="btn btn-warning" data-bs-toggle="modal"
                data-bs-target="#editModal<?= $data['isbn']; ?>">Edit Data Buku</button>
              <button data-bs-toggle="modal" data-bs-target="#deleteModal<?= $data['isbn']; ?>"
                class="btn btn-danger">Delete</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Delete -->
      <div class="modal fade" style="" id="deleteModal<?= $data['isbn']; ?>" tabindex="-1"
        aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Anda yakin ingin Menghapus Buku
                <?= $data['judul_buku']; ?>?
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <a href="module/buku/aksi.php?module=buku&act=delete&id=<?= $data['isbn']; ?>"
                class="btn btn-danger">Logout</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Edit Data Siswa-->
      <div class="modal fade" id="editModal<?= $data['isbn']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Edit Data Peminjaman</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="module/buku/aksi.php?module=buku&act=update&id=<?= $data['isbn']; ?>" method="POST"
                enctype="multipart/form-data">
                <div class="mb3">
                  <label for="nisn" class="">ISBN</label>
                  <input type="text" name="isbn" class="form-control" id="" placeholder="NISN....."
                    value="<?= $data['isbn']; ?>" readonly>
                </div>
                <div class="mb-3">
                  <label for="judul_buku" class="form-label">Judul</label>
                  <input type="text" name="judul_buku" class="form-control" id="" value="<?= $data['judul_buku']; ?>"
                    required>
                </div>
                <div class="mb-3">
                  <label for="pengarang" class="form-label">Pengarang</label>
                  <input type="text" name="pengarang" class="form-control" id="" value="<?= $data['pengarang']; ?>"
                    required>
                </div>
                <div class="mb-3">
                  <label for="penerbtit" class="form-label">Penerbit</label>
                  <input type="text" name="penerbit" class="form-control" id="" value="<?= $data['penerbit']; ?>"
                    required>
                </div>
                <div class="mb-3">
                  <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                  <input type="text" name="tahun_terbit" class="form-control" id="" value="<?= $data['tahun_terbit']; ?>"
                    required>
                </div>
                <div class="mb-3">
                  <label for="jenis_buku" class="form-label">Jenis Buku</label>
                  <select name="jenis_buku" class="form-control" id="jenis_buku" required>
                    <option value="">
                      <?= ucwords($data['jenis_buku']); ?>
                    </option>
                    <option value="novel">Novel</option>
                    <option value="fiksi">Fiksi</option>
                    <option value="nonfiksi">Nonfiksi</option>
                    <option value="ensiklopedia">Ensiklopedia</option>
                    <option value="kamus">Kamus</option>
                    <option value="pelajaran">Buku Pelajaran</option>
                    <option value="panduan">Buku Panduan</option>
                    <option value="sejarah">Buku Sejarah</option>
                    <option value="biografi">Buku Biografi</option>
                    <option value="karya_sastra">Buku Karya Sastra</option>
                    <option value="puisi">Buku Puisi</option>
                    <option value="cerita_anak-anak">Buku Cerita Anak-anak</option>
                    <option value="komik">Buku Komik</option>
                    <option value="filsafat">Buku Filsafat</option>
                    <option value="agama">Buku Agama</option>
                    <option value="sains">Buku Sains</option>
                    <option value="matematika">Buku Matematika</option>
                    <option value="psikologi">Buku Psikologi</option>
                    <option value="hukum">Buku Hukum</option>
                    <option value="medis">Buku Medis</option>
                    <option value="teknik">Buku Teknik</option>
                    <option value="seni_dan_musik">Buku Seni dan Musik</option>
                    <option value="fotografi">Buku Fotografi</option>
                    <option value="travel_dan_petualangan">Buku Travel dan Petualangan</option>
                    <option value="kuliner_dan_resep">Buku Kuliner dan Resep</option>
                    <option value="bisnis_dan_manajemen">Buku Bisnis dan Manajemen</option>
                    <option value="motivasi_dan_pengembangan_diri">Buku Motivasi dan Pengembangan Diri</option>
                    <option value="komputer_dan_teknologi">Buku Komputer dan Teknologi</option>
                    <option value="keuangan_dan_investasi">Buku Keuangan dan Investasi</option>
                    <option value="politik_dan_hubungan_internasional">Buku Politik dan Hubungan Internasional
                    </option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="" class="form-label">Stok</label>
                  <input type="text" name="stok" class="form-control" id="" value="<?= $data['stok']; ?>" required>
                </div>
                <div class="mb-3">
                  <label for="gambar" class="form-label">Gambar</label>
                  <input type="file" name="gambar" class="form-control" id="gambar">
                  <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                </div>
                <div class="mb-3">
                  <a href="?module=buku" class="btn btn-primary">Batal</a>
                  <input type="submit" value="Update Data" class="btn btn-success">
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal Edit End-->

      <?php
    }
    ?>
  </div>
</div>


<!-- Modal Tambah -->
<div class="modal fade" id="bukuModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog-centered modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Buku</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="module/buku/aksi.php?module=buku&act=insert" method="post" enctype="multipart/form-data">
          <!-- Form -->
          <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control" id="" required>
          </div>
          <div class="mb-3">
            <label for="judul_buku" class="form-label">Judul</label>
            <input type="text" name="judul_buku" class="form-control" id="" required>
          </div>
          <div class="mb-3">
            <label for="pengarang" class="form-label">Pengarang</label>
            <input type="text" name="pengarang" class="form-control" id="" required>
          </div>
          <div class="mb-3">
            <label for="penerbtit" class="form-label">Penerbit</label>
            <input type="text" name="penerbit" class="form-control" id="" required>
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Tahun Terbit</label>
            <input type="text" name="tahun_terbit" class="form-control" id="" required>
          </div>
          <div class="mb-3">
            <label for="jenis_buku" class="form-label">Jenis Buku</label>
            <select name="jenis_buku" class="form-control" id="jenis_buku" required>
              <option value="">Pilih jenis buku</option>
              <option value="novel">Novel</option>
              <option value="fiksi">Fiksi</option>
              <option value="nonfiksi">Nonfiksi</option>
              <option value="ensiklopedia">Ensiklopedia</option>
              <option value="kamus">Kamus</option>
              <option value="pelajaran">Buku Pelajaran</option>
              <option value="panduan">Buku Panduan</option>
              <option value="sejarah">Buku Sejarah</option>
              <option value="biografi">Buku Biografi</option>
              <option value="karya_sastra">Buku Karya Sastra</option>
              <option value="puisi">Buku Puisi</option>
              <option value="cerita_anak-anak">Buku Cerita Anak-anak</option>
              <option value="komik">Buku Komik</option>
              <option value="filsafat">Buku Filsafat</option>
              <option value="agama">Buku Agama</option>
              <option value="sains">Buku Sains</option>
              <option value="matematika">Buku Matematika</option>
              <option value="psikologi">Buku Psikologi</option>
              <option value="hukum">Buku Hukum</option>
              <option value="medis">Buku Medis</option>
              <option value="teknik">Buku Teknik</option>
              <option value="seni_dan_musik">Buku Seni dan Musik</option>
              <option value="fotografi">Buku Fotografi</option>
              <option value="travel_dan_petualangan">Buku Travel dan Petualangan</option>
              <option value="kuliner_dan_resep">Buku Kuliner dan Resep</option>
              <option value="bisnis_dan_manajemen">Buku Bisnis dan Manajemen</option>
              <option value="motivasi_dan_pengembangan_diri">Buku Motivasi dan Pengembangan Diri</option>
              <option value="komputer_dan_teknologi">Buku Komputer dan Teknologi</option>
              <option value="keuangan_dan_investasi">Buku Keuangan dan Investasi</option>
              <option value="politik_dan_hubungan_internasional">Buku Politik dan Hubungan Internasional
              </option>
            </select>
          </div>
          <div class="mb-3">
            <label for="" class="form-label">Stok</label>
            <input type="text" name="stok" class="form-control" id="" required>
          </div>
          <div class="mb-3">
            <input type="file" name="gambar">
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>
</div>