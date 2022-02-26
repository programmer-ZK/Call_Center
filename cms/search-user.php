<?php
/*********************************************************************
    profile.php

**********************************************************************/
require('staff.inc.php');
//require 'client.inc.php';
require_once INCLUDE_DIR . 'class.client-h.php';
$inc = 'h-search.inc.php';
$errors = array();
$success="";
if($_POST){
 
  if ($_POST['phone']==""){
      $errors['phone'] = __('Phone Number is required.');
  }/*elseif($_POST['phone'] && !$_POST['phone-ext']){
        $errors['phone'] = __('Extension required.');
  }*/else{
      $res=ClientInfo_h::getUserH($_POST);   
      if($res['exist']==true){
       //Http::redirect('h-users.php?id='.$res['id']); 
       Http::redirect('users.php?id='.$res['id']); 
      }else{
       Http::redirect('h-account.php?id='.$res['id']);
      }
    }  
        
  }

include(STAFFINC_DIR.'header.inc.php');
include('include/client/'.$inc);
include(STAFFINC_DIR.'footer.inc.php');

