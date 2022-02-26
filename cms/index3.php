<?php
/*********************************************************************
    profile.php

**********************************************************************/
require 'client.inc.php';
require_once INCLUDE_DIR . 'class.client-h.php';
//$inc = 'h-search.inc.php';
$errors = array();
$success="";
if($_POST){
  //print_r($_POST);
  //die;
  if ($_POST['phone']==""){
      $errors['phone'] = __('Phone Number is required.');
  }elseif($_POST['phone'] && !$_POST['phone-ext']){
        $errors['phone'] = __('Extension required.');
  }else{
      $res=ClientInfo_h::getUserH($_POST);   
      if($res['exist']==true){
       Http::redirect('h-users-view.php?id='.$res['id']); 
      }else{
       Http::redirect('h-account.php?id='.$res['id']);
      }
    }  
        
  }
//die('here');
//include(CLIENTINC_DIR.'header.inc.php');
//include(CLIENTINC_DIR.$inc);
//include(CLIENTINC_DIR.'footer.inc.php');

