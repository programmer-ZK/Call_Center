<?php
/*********************************************************************
    profile.php
**********************************************************************/

require('staff.inc.php');
//require 'client.inc.php';
if(!$_REQUEST['id']){
     Http::redirect('index.php');
     exit;
}
require_once 'include/class.client-h.php';
$inc = 'h-register.inc.php';
$errors = array();
$success="";
if($_POST){

  if ($_POST['email']==""){
       $errors['email'] = __('Email is required.');
  
    }elseif(!$_POST['full_name']){
      $errors['full_name'] = __('Full name required.');
    }else{
    if($id=ClientInfo_h::addUserH($_POST)){
       Http::redirect('users.php?id='.$id);
    }

  }
}
//echo STAFFINC_DIR.'header.inc.php';
//echo CLIENTINC_DIR.$inc;
include(STAFFINC_DIR.'header.inc.php');
include('include/client/'.$inc);
include(STAFFINC_DIR.'footer.inc.php');

