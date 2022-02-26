<?php
/*********************************************************************
    login.php
**********************************************************************/
require_once('main.inc.php');
if(!defined('INCLUDE_DIR')) die('Fatal Error.contact Admin!');
Http::redirect('../login.php');
// Bootstrap gettext translations. Since no one is yet logged in, use the
// system or browser default
TextDomain::configureForUser();
 
require_once(INCLUDE_DIR.'class.staff.php');
require_once(INCLUDE_DIR.'class.csrf.php');

$content = Page::lookup(Page::getIdByType('banner-staff'));

$dest = $_SESSION['_staff']['auth']['dest'];
$msg = $_SESSION['_staff']['auth']['msg'];
$msg = $msg ?: ($content ? $content->getName() : __('Authentication Required'));
$dest=($dest && (!strstr($dest,'login.php') && !strstr($dest,'ajax.php')))?$dest:'index.php';
$show_reset = false;
if($_POST) {
	 
    // Check the CSRF token, and ensure that future requests will have to
    // use a different CSRF token. This will help ward off both parallel and
    // serial brute force attacks, because new tokens will have to be
    // requested for each attempt.
    /*if (!$ost->checkCSRFToken())
        Http::response(400, __('Valid CSRF Token Required'));*/

    // Rotate the CSRF token (original cannot be reused)
    /*$ost->getCSRF()->rotate();*/
     //print_r($_POST);
      /// die;
    // Lookup support backends for this staff
    $username = trim($_POST['userid']);
    if ($user = StaffAuthenticationBackend::process($username,
            $_POST['passwd'], $errors)) {
      
        session_write_close();
        Http::redirect($dest);
        require_once('index.php'); //Just incase header is messed up.
        exit;
    }
    $msg = $errors['err']?$errors['err']:__('Invalid login');
    $show_reset = true;
}
elseif ($_GET['do']) {
    switch ($_GET['do']) {
    case 'ext':
        // Lookup external backend
        if ($bk = StaffAuthenticationBackend::getBackend($_GET['bk']))
            $bk->triggerAuth();
    }
    Http::redirect('login.php');
}
// Consider single sign-on authentication backends
elseif (!$thisstaff || !($thisstaff->getId() || $thisstaff->isValid())) {
	
    if (($user = StaffAuthenticationBackend::processSignOn($errors, false))
            && ($user instanceof StaffSession))
       @header("Location: $dest");
}
define("OSTSCPINC",TRUE); 
//Make includes happy!
//include_once('../login.php');
//include_once(INCLUDE_DIR.'staff/login.tpl.php');
?>
<!-- <form action="http://localhost/crm-merged/login.php" method="post">
        <input type="hidden" name="do" value="scplogin">
        <fieldset>
        <input type="text" name="userid" id="name" value="" placeholder="Email or Username" autocorrect="off" autocapitalize="off">
        <input type="password" name="passwd" id="pass" placeholder="Password" autocorrect="off" autocapitalize="off">
            <input class="submit" type="submit" name="submit" value="Log In">
        </fieldset>
    </form> -->