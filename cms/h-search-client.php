<?php
/*********************************************************************
    profile.php
    
**********************************************************************/
require 'client.inc.php';
require_once INCLUDE_DIR . 'class.client-h.php';

$inc = 'h-search.inc.php';

$errors = array();
$success="";

if($_POST){
  if($res=ClientInfo_h::getUserH($_POST)){
      if(count($res)){
       Http::redirect('scp/h-users.php?id='.$res['id']); 
      }else{
        Http::redirect('h-account.php');
      }
     
    }
  }

//include(CLIENTINC_DIR.'header.inc.php');
include(CLIENTINC_DIR.$inc);
//include(CLIENTINC_DIR.'footer.inc.php');

