<?php
/*********************************************************************
    Check user.php
**********************************************************************/
require_once('main.inc.php');
require_once(INCLUDE_DIR.'class.staff.php');
require_once(INCLUDE_DIR.'class.csrf.php');
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

        /*$user_name = $_POST['userid'];
        $password  = $_POST['passwd'];
        $remember  = $_POST['remember'];
        
        if($remember=="1"){
            $year = time() + 31536000;
            setcookie('remember_un',$user_name, $year);
            setcookie('remember_pwd',$password, $year);
        }elseif($remember!='1') {
            if(isset($_COOKIE['remember_un'])) {
                $past = time() - 100;
                setcookie(remember_un, gone, $past);
                setcookie(remember_pwd, gone, $past);
                    }
            }*/

        Http::redirect('index.php');
        //require_once('index.php'); //Just incase header is messed up.
        exit;
    }else{
		  $msg = $errors['err']?$errors['err']:__('Invalid login');
		 Http::redirect('../login.php?msg='.$msg);
        $show_reset = true;
		}
}