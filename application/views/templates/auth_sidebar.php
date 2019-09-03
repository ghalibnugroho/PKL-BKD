<!-- Page Wrapper -->


<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('home'); ?>">
    <img src="<?= base_url('assets/'); ?>img/logo-bkd-malang.png" width="50">
    <div class="sidebar-brand-text mx-auto my-1">BKD MALANG</div>
  </a>


  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="index.html">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <?php
  if ($this->session->userdata('priority') == 1) {
    ?>
    <div class="sidebar-heading">
      Pegawai
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('daftar-pegawai') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Daftar Pegawai</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Kegiatan
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('list-st') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Daftar Kegiatan</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Surat Tugas
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('list-st') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>List Surat Tugas</span></a>
    </li>
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Surat Perintah Perjalanan Dinas
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('list-sppd') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>List SPPD</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Keuangan
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('rincian') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Rekap Keuangan</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Akun
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('ubah-password') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Ubah Password</span></a>
    </li>
  <?php
  } else { ?>

    <!-- Heading -->
    <div class="sidebar-heading">
      Surat Tugas
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('surat-tugas') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Buat Surat Tugas</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('list-st') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>List Surat Tugas</span></a>
    </li>

    <!-- Nav Item - Tables -->

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Surat Perintah Perjalanan Dinas
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('list-rincian') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>List Rincian</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('list-sppd') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>List SPPD</span></a>
    </li>

    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Keuangan
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('rincian') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Rincian Biaya</span></a>

    <?php }
    ?>

  </li>
  <!-- Divider -->
  <!-- Divider -->

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>

<!-- End of Sidebar -->

<!-- Nav Item - Utilities Collapse Menu -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Utilities</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Custom Utilities:</h6>
        <a class="collapse-item" href="utilities-color.html">Colors</a>
        <a class="collapse-item" href="utilities-border.html">Borders</a>
        <a class="collapse-item" href="utilities-animation.html">Animations</a>
        <a class="collapse-item" href="utilities-other.html">Other</a>
      </div>
    </div>
  </li> -->

<!-- Nav Item - Pages Collapse Menu -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-folder"></i>
      <span>Pages</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Login Screens:</h6>
        <a class="collapse-item" href="login.html">Login</a>
        <a class="collapse-item" href="register.html">Register</a>
        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
        <div class="collapse-divider"></div>
        <h6 class="collapse-header">Other Pages:</h6>
        <a class="collapse-item" href="404.html">404 Page</a>
        <a class="collapse-item" href="blank.html">Blank Page</a>
      </div>
    </div>
  </li> -->