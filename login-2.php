<?php
include_once("login.header.php");
if(isset($_REQUEST['login'])){

$result1=$admin->no_of_login_users();
$no = $result1->fields['Users'];

        $user_name = $_REQUEST['txtLogin'];
        $password  = $_REQUEST['txtPassword'];
		$remember  = $_REQUEST['remember'];
$result2=$admin->desig_of_login_users($user_name );
//$desig = $result2->fields['designation'];
//print_r($result2);
//echo $result2->fields['designation']. $no . $limit_of_login_users;
//exit;
//echo $no;

//echo $result1->fields['designation'] ;


//echo "farhan";
if ((($no < $limit_of_login_users)  && ($result2->fields['designation'] == 'Agents')) ||($result2->fields['designation'] == 'Supervisor')) {
	// echo "farhan";
    // print_r($result2->fields);
    // die;
	if($admin->usr_auth($user_name, $password) & $user_name!= '' & $password != ''){
//echo "farhan";
//echo $no ."_". $limit_of_login_users;exit();
//if ((($no < $limit_of_login_users) && ($result->fields['designation'] = 'Agents'))||($result->fields['designation'] = 'Supervisor')) {
//	if ($no < $limit_of_login_users) { echo "farhan";         
                     
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
					}
        	        $_SESSION['admin_login'] = "true";
			        $_SESSION[$db_prefix.'_GM'] = "Login Successful.";
        	        header ("Location: index.php");
			       exit;
	}else{
	   //$userr_login = "1";
	}
	
}else{
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
					}
	echo "<form action=\"cms_2/scp/checkusers.php\" method=\"post\" id=\"loginForm\">
	            <input name=\"userid\" type=\"hidden\" value=\"$user_name\">
				<input name=\"passwd\" type=\"hidden\" value=\"$password\">
				<input name=\"remember\" type=\"hidden\" value=\"$remember\">
          </form>
          <script type=\"text/javascript\">
           document.getElementById('loginForm').submit();
          </script>";     
	 
	// die('here go.');
}
//}	
//else {
             //   $_SESSION[$db_prefix.'_RM'] = "Invalid Email or Password.";
//	$userr_login = "1";
//}


?>
<tr class="msg">
  <td colspan="2"><?php echo $_SESSION[$db_prefix.'_GM']; unset($_SESSION[$db_prefix.'_GM']); ?></td>
</tr>
<?php
}
else {
             
}?>

<div class="main_header">
  <div id="container">
    <div id="header">
      <div id="top">
        <h1><a href="index.php"><img src="<?php echo IMG_PATH; ?>i_logo.png" alt="RNI" style="width: 250px;" /></a></h1>
        <span class="clearFix">&nbsp;</span> </div>
        
      <!-- end of #header --> 
    </div>
  </div>
</div>
<div id="container">
 <?php //print_r($_COOKIE['remember_un']);?>
  <div id="form-container">
    <form name="login-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <fieldset>
        <h2>Sign Me In!</h2>
        <ol>
          <li> 
           <?php if(isset($_SESSION[$db_prefix.'_GM'])){?>
      <div class="box"> 
      <div id="message-green">
          <table border="0" width="100%" cellpadding="0" cellspacing="0">
          <tr>
          <td class="green-left"><?php echo $_SESSION[$db_prefix.'_GM']; unset($_SESSION[$db_prefix.'_GM']); ?></td>
          <td class="green-right"><a class="close-green"><img src="images/icon_close_green.gif" alt="" /></a></td>
          </tr>
          </table>
      </div>
      </div>
      <?php } ?>
            <!-- <label class="field-title">Username:</label>-->
            <label class="txt-field">
              <input type="text"  name="txtLogin" maxlength="255" placeholder="User Name" value="<?php echo (@$_REQUEST['msg']=="")?@$_COOKIE['remember_un']:""; ?>"/>
            </label>
          </li>
          <li> 
            <!-- <label class="field-title">Password:</label>-->
            <label class="txt-field">
              <input type="password" name="txtPassword" maxlength="255" placeholder="Password" value="<?php echo (@$_REQUEST['msg']=="")?@$_COOKIE['remember_pwd']:""; ?>" />
            </label>
          </li>
          <li>
            <label class="remember">
              <input type="checkbox" name="remember" value="1" <?php if(!isset($_REQUEST['msg']) && isset($_COOKIE['remember_un'])) {
		                              echo 'checked="checked"';
	                                  }
									   else {
										 echo '';
										}
										?>/>
              Remember Me</label>
            <a href="pwreset.php" class="forgot"> Forgot Password </a>
            <?php if ($userr_login == '1'){ ?>
            <label class="remember"><font color="red" style="font-weight:normal">No. of Login Users Exceeds</font></label>
            <?php }elseif(isset($_REQUEST['msg'])){?>
             <label class="remember"><font color="red" style="font-weight:normal"> <?php echo $_REQUEST['msg']; ?></font></label>
		   <?php  }  ?>
           </li>
          
        </ol>
         <input type="submit" name="login" id="login"  value="Login" />
      </fieldset>
      <span class="clearFix">&nbsp;</span>
    </form>
  </div>
</div>
<?php
include_once("login.footer.php");
?>

