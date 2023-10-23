
    <h3 style="text-align:center;">Data User</h3>

    <?php
    if (!empty($_SESSION['alert'])):
      echo $_SESSION['alert'];
    endif;
    unset($_SESSION['alert']);
    ?>

<button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#userModal">
  Tambah Data User
</button>

<div class="row">
  <?php
  include('config/koneksi.php');

  // Memeriksa apakah ada parameter pencarian
  if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    // Query dengan filter pencarian
    $query = "SELECT * FROM muda_user WHERE nama_user LIKE '%$keyword%' OR isbn LIKE '%$keyword%' OR pengarang LIKE '%$keyword%' OR penerbit LIKE '%$keyword%'";
  } else {
    // Query tanpa filter pencarian
    $query = "SELECT * FROM muda_user";
  }


  $conn = mysqli_query($connection, $query);
  while ($data = mysqli_fetch_array($conn)) {
    ?>
    <div class="col-md-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">
            <?= $data['nama_user']; ?>
          </h5>
          <hr>
          <p class="card-text"><strong>Username:</strong>
            <?= $data['username']; ?>
          </p>
          <p class="card-text"><strong>Level:</strong>
            <?= $data['level']; ?>
          </p>
          <div class="text-end">     
              <button data-bs-toggle="modal" data-bs-target="#deleteModal<?= $data['id']; ?>"
                class="btn btn-danger">Delete</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Delete -->
      <div class="modal fade" style="" id="deleteModal<?= $data['id']; ?>" tabindex="-1"
        aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Delete</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Anda yakin ingin Menghapus Data
                <?= $data['nama_user']; ?>?
              </p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <a href="module/user/aksi.php?module=user&act=delete&id=<?= $data['id']; ?>"
                class="btn btn-danger">Logout</a>
            </div>
          </div>
        </div>
      </div>



    
    <?php
  }
  ?>

  <!-- Modal user -->
  <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="module/user/aksi.php?module=user&act=insert" method="post">
            <!-- Form -->
            <div class="mb-3">
              <label for="nama_user" class="form-label">Nama User</label>
              <input type="text" name="nama_user" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="konfirmasi_password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="level" class="form-label">Level</label>
              <select name="level" class="form-select" required>
                <option value="">--Pilih Level--</option>
                <option value="admin">Administrator</option>
                <option value="user">User</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>