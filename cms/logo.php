<?php
/*********************************************************************
    logo.php
    
    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/

// Don't update the session for inline image fetches
if (!function_exists('noop')) { function noop() {} }
session_set_save_handler('noop','noop','noop','noop','noop','noop');
define('DISABLE_SESSION', true);

require_once('main.inc.php');

if (($logo = $ost->getConfig()->getStaffLogo())) {
    $logo->display();
} else {
    header('Location: ../images/i_logo.png');
}

?>
