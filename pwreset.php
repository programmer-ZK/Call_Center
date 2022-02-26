
<?php
include_once("login.header.php");
if(isset($_REQUEST['send_mail'])){
 $user_email = $_POST['txtEmail'];
 if ($user_email==""){
      $errors['email'] = 'Email is required.';
  }else if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
	    $errors['email'] = 'Email is not valid.';
  }else{
	  	
  	 $result2=$admin->desig_of_login_users($user_email);		
  	 if ((($result2->fields['designation'] == 'Agents')) || ($result2->fields['designation'] == 'Supervisor')) {
  	 	$result = $admin->get_user_by_email($user_email);
		 // hbm
		       $key = md5(mt_rand(100000, 999999));
		       //$encrypt = $result->fields['admin_id'];
                 //Create a new PHPMailer instance
				$mail = new PHPMailer;
				$mail->SMTPDebug = 0;                               // Enable verbose debug output
				$mail->isSMTP();                                      // Set mailer to use SMTP
				$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
				$mail->SMTPAuth = true;                               // Enable SMTP authentication
				$mail->Username = 'alert.callcenter@gmail.com';                 // SMTP username
				$mail->Password = 'convex123789';                           // SMTP password
				$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 587;                                    // TCP port to connect
				
				//Set who the message is to be sent from
				$mail->setFrom('alert.callcenter@gmail.com', 'Call Center Alerts');
				//Set an alternative reply-to address
				$mail->addReplyTo('alert.callcenter@gmail.com', 'Call Center Alerts');
				//Set who the message is to be sent to
				$mail->addAddress($result->fields['email'],$result->fields['full_name']);
				//$mail->addAddress('hafeez@convexinteractive.com',$result->fields['full_name']);
				//Set the subject line
				$mail->Subject = 'Staff Password Reset';
               // $mail->Body    ='Your Membership ID is';
			     $mail->IsHTML(true); 
                $mail->Body    = 'Hi, '.$result->fields['full_name'].' <br/><br/>
				A password reset request has been submitted on your behalf for the helpdesk at'.$host.'/convex_crm/<br/><br/>Follow the link below to login to the help desk and change your password. <br/><br/>Click here to reset your password '.$host.'/convex_crm/reset.php?token='.$key.'&action=reset<br/><br/>--<br>'.$host.'/convex_crm/<br>Solve your problems.<br/><br/>Your Customer Support System.';
				
				if(!$mail->send()){
				$errors['email']= 'Something went wrong try again.';
			    }else{
				$admin->insert_admin_config('pwreset',$key,$result->fields['admin_id']);	
				$errors['email']="A password reset email was sent to the email on file for your account.  Follow the link in the email to reset your password.";
				}
		    
			
		 
		     /*$encrypt = $result->fields['admin_id'];
            //$message = "Your password reset link send to your e-mail address.";
            $to='hafeez@convexinteractive.com';//$email;
            $subject="Forget Password";
            $from = 'hafeez@convexinteractive.com';
            $body='Hi, <br/><br/>Your Membership ID is '.$admin_id.
            '<br><br>Click here to reset your password http://10.100.50.56/convex_crm/reset.php?token='.$encrypt.'&action=reset<br/><br/>--<br>http://10.100.50.51/convex_crm/<br>Solve your problems.';
            if($rest = $tools->sendEmail($from, $to,'hafeez', $subject,$body)){
				$errors['email']= $rest."A password reset email was sent to the email on file for your account.  Follow the link in the email to reset your password.";
			}else{
				$errors['email']="Something went wrong try again.";
				}*/
		 // hbm
		
		/*if($admin->sendmail($user_email,$result->fields['admin_id'])){
		   $errors['email']="A password reset email was sent to the email on file for your account.  Follow the link in the email to reset your password.";
		}else{
			$errors['email']="Something went wrong try again.";
		} */
	     //die('here we go.');   
  	 }else{
		 echo "<form action=\"cms/pwreset-h.php\" method=\"post\" id=\"pwreset\">
		        <input type=\"hidden\" name=\"do\" value=\"sendmail\">
	            <input name=\"userid\" type=\"hidden\" value=\"$user_email\"></form>
          <script type=\"text/javascript\">
           document.getElementById('pwreset').submit();
          </script>";
      
	 }
  	// print_r($result2);
	// die('here we go.');
  }

}?>
<?php if($_REQUEST['msg']!=""){
	    $errors['email'] = $_REQUEST['msg'];
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
  <div id="form-container">
    <form name="login-form" action="<?php echo (!empty($_REQUEST['token']))? "crm_merged/pwreset-h.php" :"";?>" method="post">
      <fieldset>
        <h2>Password Reset!</h2>
        <ol>
          <li> 
          <?php if(!empty($_REQUEST['token'])){?>
           <input type="hidden" name="do" value="newpasswd"/>
           <input type="hidden" name="token" value="<?php echo $_REQUEST['token']; ?>"/>
           <?php } ?>
            <!-- <label class="field-title">Username:</label>-->
            <label class="txt-field">
              <input type="text"  name="txtEmail" maxlength="255" placeholder="Enter Email"/>
            </label>
          </li>
            <?php //if(isset($_REQUEST['msg'])){?>
             <label class="remember" style="width: 250px;"><font color="red" style="font-weight:normal"><?php echo @$errors['email'];?></font></label>
		   <?php  //}  ?>
        </ol>
         <input type="submit" name="send_mail" id="login"  value="Send Email" />
      </fieldset>
      <span class="clearFix">&nbsp;</span>
    </form>
  </div>
</div>
<?php
include_once("login.footer.php");
?>