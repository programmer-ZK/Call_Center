<?php include_once("classes/login_admin.php"); $login_admin = new login_admin();?>
<?php 
$user_name = $_REQUEST['txtLogin'];
$password  = $_REQUEST['txtPassword'];
echo $total_records_count = $login_admin->usr_auth($user_name, $password);


if(isset($_REQUEST['login'])){
        if($_REQUEST['txtLogin'] == 'admin' && $_REQUEST['txtPassword'] == 'admin786!'){
                $_SESSION['admin_login'] = "true";
                header ("Location: index.php");
        }
        else {
                $_SESSION[$db_prefix.'_SM'] = "Invalid Email or Password.";
        }
}


?>

