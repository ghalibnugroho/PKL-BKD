  
<!DOCTYPE html>
<html lang="en">
  <?php $this->load->view("templates/auth_header") ?>

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div class="col-8 col-lg-6 my-5">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">PKL Nih</h1>
                    <h1></h1>
                  </div>
                  <?=$this->session->flashdata('message');?>
                  <form class="user" method="post" action="<?=base_url();?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user" placeholder="Enter Username..." name="username" value="<?=set_value('username');?>">
                      <?=form_error('email', '<small class="text-danger pl-3">', '</small>');?>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password" value="<?=set_value('password');?>">
                      <?=form_error('password', '<small class="text-danger pl-3">', '</small>');?>
                    </div><br>
                    <button class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="auth/registration">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</html>
