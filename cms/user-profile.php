<?php
/*********************************************************************
    profile.php

**********************************************************************/
require 'secure.inc.php';

require_once 'class.user.php';
$user = User::lookup($thisclient->getId());

if ($user && $_POST) {
    $errors = array();
    if ($acct = $thisclient->getAccount()) {
       $acct->update($_POST, $errors);
    }
    if (!$errors && $user->updateInfo($_POST, $errors))
        Http::redirect('tickets.php');
}

$inc = 'profile.inc.php';

include(CLIENTINC_DIR.'header.inc.php');
include(CLIENTINC_DIR.$inc);
include(CLIENTINC_DIR.'footer.inc.php');

