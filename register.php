<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Form Register</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="assest/register.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <div class="card">
      <h2 class="text-center mb-4">Register</h2>
      <?php 
                    if (!empty($_SESSION['alert'])) :
                        echo $_SESSION['alert'];
                        endif;
                        unset($_SESSION['alert']);
                     ?>
      <form action="aksi-register.php" method="POST">
        <div class="form-group">
          <label for="nama_user">Nama User</label>
          <input type="text" name="nama_user" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="konfirmasi_password">Konfirmasi Password</label>
          <input type="password" name="konfirmasi_password" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="level">Level</label>
          <select name="level" class="form-control" required>
            <option value="">--Pilih Level--</option>
            <option value="admin">Administrator</option>
            <option value="user">User</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        <a href="index.php" class="btn-back"><i class="fas fa-arrow-left"></i> Kembali</a>
      </form>
    </div>
  </div>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
