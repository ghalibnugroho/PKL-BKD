<?php 
  if(null == $this->session->userdata('email')){
    redirect(base_url());
  }
?>