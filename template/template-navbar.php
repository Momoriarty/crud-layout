<div class="dashboard-nav">
  <header>
    <a href="#!" class="menu-toggle">
      <i class="fas fa-bars"></i>
    </a>
    <a href="#" class="brand-logo">
      <div class="darkmode">
        <div class="light fa fa-sun fa-spin" style="color:yellow;"></div>
        <div class="dark fa fa-moon fa-spin" style="color:grey;"></div>
      </div>
      <span>MZ</span>
    </a>
  </header>


  <?php
  $module = !empty($_GET['module']) ? $_GET['module'] : '';
  ?>

  <nav class="dashboard-nav-list">
    <a href="?module=home" class="dashboard-nav-item <?= $module === 'home' ? 'active' : ''; ?>">
      <i class="fas fa-home"></i>
      Beranda
    </a>


    <?php
    if ($_SESSION['level_user'] == "admin") { ?>
      <a href="?module=siswa" class="dashboard-nav-item <?= $module === 'siswa' ? 'active' : ''; ?>">
        <i class="fas fas fa-users"></i>
        Data Siswa
      </a>
      <a href="?module=buku" class="dashboard-nav-item <?= $module === 'buku' ? 'active' : ''; ?>">
        <i class="fas fa-book"></i>
        Data Buku
      </a>
      <div class='dashboard-nav-dropdown'>
        <a href="#!"
          class="dashboard-nav-item dashboard-nav-dropdown-toggle <?= $module === 'pustaka' ? 'active' : ''; ?>">
          <i class="fas fa-book-reader"></i>
          Pustaka
        </a>
        <div class='dashboard-nav-dropdown-menu'>
          <a href="?module=pustaka" class="dashboard-nav-dropdown-item">
            Peminjaman
          </a>
          <a href="?module=pengembalian" class="dashboard-nav-dropdown-item">
            Pengembalian
          </a>
        </div>
      </div>
      <a href="?module=user" class="dashboard-nav-item <?= $module === 'user' ? 'active' : ''; ?>">
        <i class="fas fa-user"></i>
        Data User
      </a>

      <?php
    }
    ?>

    <div class='dashboard-nav-dropdown'>
      <a href="#!" class="dashboard-nav-item dashboard-nav-dropdown-toggle ">
        <i class="fas fa-gamepad"></i>
        Game
      </a>
      <div class='dashboard-nav-dropdown-menu'>
        <a href="?module=game" class="dashboard-nav-dropdown-item ">
          Tic Tac Toe
        </a>
      </div>
    </div>

    <div class="nav-item-divider"></div>
    <a href="" class="dashboard-nav-item" data-bs-toggle="modal" data-bs-target="#logoutModal">
      <i class="fas fa-sign-out-alt"></i>
      Logout
    </a>


  </nav>
</div>


<!-- Modal Logout -->
<div class="modal fade" style="" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Anda yakin ingin logout?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>