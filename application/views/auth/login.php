<?php 
  if(!null == $this->session->userdata('username')){
    redirect('home');
  }
?>
  <!DOCTYPE html>
  <html lang="en">
  <?php $this->load->view("templates/auth_header") ?>

  <div class="container col-12 py-10">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-8 col-lg-8 d-flex align-items-stretch justify-content-center">
        <div class="card o-hidden border-0 shadow-lg">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6">
                <img src="assets/img/malang.jpg" alt="malang" height="100%" width="100%">
              </div>
              <div class="col-lg-6 py-9">
                <div class="card-login">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-3 font">BKD ft. PKL</h1>
                    <h1></h1>
                  </div>
                  <?= $this->session->flashdata('message'); ?>
                  <form class="user" method="post" action="<?= base_url(); ?>">
                    <div class="form-group padding-input-top">
                      <input type="text" class="form-control form-control-user" placeholder="Masukkan Username..." name="username" value="<?= set_value('username'); ?>">
                      <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" value="<?= set_value('password'); ?>">
                      <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                    </div><br>
                    <button class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  </html>