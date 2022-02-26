<?php
/*********************************************************************
    profile.php

    Manage client profile. This will allow a logged-in user to manage
    his/her own public (non-internal) information

    Peter Rotich <peter@osticket.com>
    Jared Hancock <jared@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
    $Id: $
**********************************************************************/
require 'client.inc.php';
require_once INCLUDE_DIR . 'class.client-h.php';
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
       Http::redirect('scp/h-users.php?id='.$id);
    }

  }
}
//include(CLIENTINC_DIR.'header.inc.php');
include(CLIENTINC_DIR.$inc);
//include(CLIENTINC_DIR.'footer.inc.php');

