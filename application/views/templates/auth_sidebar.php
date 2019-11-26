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
    <a class="nav-link" href="<?= base_url('home'); ?>">
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
      <a class="nav-link" href="<?php echo site_url('daftar-kegiatan') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>Daftar Kegiatan</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
      Keuangan
    </div>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('rekap-keuangan') ?>">
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
      <a class="nav-link" href="<?php echo site_url('list-sppd') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>List SPPD</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo site_url('list-rincian') ?>">
        <i class="fas fa-fw fa-table"></i>
        <span>List Rincian</span></a>
    </li>


    <hr class="sidebar-divider">
  <?php }
  ?>
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>