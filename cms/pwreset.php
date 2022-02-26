<?php
/*********************************************************************
    pwreset.php

    Handles step 2, 3 and 5 of password resetting
        1. Fail to login (2+ fail login attempts)
        2. Visit password reset form and enter username or email
        3. Receive an email with a link and follow it
        4. Visit password reset form again, with the link
        5. Enter the username or email address again and login
        6. Password change is now required, user changes password and
           continues on with the session

**********************************************************************/
require_once('main.inc.php');
if(!defined('INCLUDE_DIR')) die('Fatal Error. Kwaheri!');
//Http::redirect('../pwreset.php'); exit();
// Bootstrap gettext translations. Since no one is yet logged in, use the
// system or browser default
TextDomain::configureForUser();

require_once(INCLUDE_DIR.'class.staff.php');
require_once(INCLUDE_DIR.'class.csrf.php');

$tpl = 'pwreset.php';
if($_POST) {
   /* print_r($_POST);
    die;*/

    /*if (!$ost->checkCSRFToken()) {
        Http::response(400, __('Valid CSRF Token Required'));
        exit;
    }*/
    switch ($_POST['do']) {
        case 'sendmail':
            if (($staff=Staff::lookup($_POST['userid']))) {
                if (!$staff->hasPassword()) {
                    $msg = __('Unable to reset password. Contact your administrator');
                }
                elseif (!$staff->sendResetEmail()) {
                    $tpl = 'pwreset.sent.php';
                }
            }
            else
                $msg = sprintf(__('Unable to verify username %s'),
                    Format::htmlchars($_POST['userid']));
            break;
        case 'newpasswd':
            // TODO: Compare passwords
            $tpl = 'pwreset.login.php';
            $errors = array();
            if ($staff = StaffAuthenticationBackend::processSignOn($errors)) {
                $info = array('page' => 'index.php');
                Http::redirect($info['page']);
            }
            elseif (isset($errors['msg'])) {
                $msg = $errors['msg'];
               
                
            }
             //Http::redirect('../pwreset.php?msg=Invalid email.');
            break;
    }
}
elseif ($_GET['token']) {
    $msg = __('Please enter your email');
    $_config = new Config('pwreset');
    if (($id = $_config->get($_GET['token']))
            && ($staff = Staff::lookup($id)))
        // TODO: Detect staff confirmation (for welcome email)
        $tpl = 'pwreset.login.php';
    else
        header('Location: index.php');
}
elseif ($cfg->allowPasswordReset()) {
    $msg = __('Enter your email address below');
}
else {
    $_SESSION['_staff']['auth']['msg']=__('Password resets are disabled');
    return header('Location: index.php');
}
define("OSTSCPINC",TRUE); //Make includes happy!
include_once(INCLUDE_DIR.'staff/'. $tpl);
