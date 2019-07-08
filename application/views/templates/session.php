<?php 
  if(null == $this->session->userdata('username')){
    redirect(base_url());
  }
?>