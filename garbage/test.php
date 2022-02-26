<?php include_once("includes/config.php"); ?>
<?php
        include_once("classes/tools.php");
        $tools = new tools();
		
		$tools->PHPMailer('yzaki16@gmail.com', $fromName, 'yzaki16@gmail.com', $toName, 'sdfsdfs', 'rest', $isHTML=true, $new_file_name='', $attachment_location='',$bcc='', $replyToName='', $replyToEmail='');
		exit;
?>
<?php
require_once('classes/phpmailer.php');

$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

$mail->IsSMTP(); // telling the class to use SMTP

try {
  $mail->Host       = "smtp.gmail.com"; // SMTP server
  $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
  $mail->SMTPAuth   = true;                  // enable SMTP authentication
  $mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
  $mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
  $mail->Port       = 465;                   // set the SMTP port for the GMAIL server
  $mail->Username   = "yzaki16@gmail.com";  // GMAIL username
  $mail->Password   = "";            // GMAIL password
  $mail->AddReplyTo('yzaki16@gmail.com', 'Yahya Zaki');
  $mail->AddAddress('yzaki16@gmail.com', 'Farhan');
  //$mail->SetFrom('yzaki16@gmail.com', 'Sender Name');
  //$mail->AddReplyTo('MYFROMADDRESSHERE', 'Sender Name');
  $mail->Subject = 'PHPMailer Test Subject via mail(), advanced';
  $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML('dfdsf');
  //$mail->AddAttachment('images/phpmailer.gif');      // attachment
  //$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
exit;
?>

</body>
</html>


<?php

$fp   =   fsockopen("www.google.com",   80,   &$errno,   &$errstr,   10);  // work fine
  if(!   $fp) 
      echo   "www.google.com -  $errstr   ($errno)<br>\n"; 
  else 
      echo   "www.google.com -  ok<br>\n";

 
      $fp   =   fsockopen("smtp.gmail.com",   465,   &$errno,   &$errstr,   10);   // NOT work
  if(!   $fp) 
      echo   "smtp.gmail.com 465  -  $errstr   ($errno)<br>\n"; 
  else 
      echo   "smtp.gmail.com 465 -  ok<br>\n"; 
     
     
      $fp   =   fsockopen("smtp.gmail.com",   587,   &$errno,   &$errstr,   10);   // NOT work
  if(!   $fp) 
      echo   "smtp.gmail.com 587  -  $errstr   ($errno)<br>\n"; 
  else 
      echo   "smtp.gmail.com 587 -  ok<br>\n";       

echo "<br />".phpinfo();
exit;
      ?>
	  

<?php

$string 				= '<12345>';
$url					= 'http://crm:8080/index.php?action=DetailView&module=HelpDesk&parenttab=Support&record=[TicketNumber]';
$url_replace_pattern	= '[TicketNumber]';
$patterns 				= "/^<\d+>$/";

if(preg_match($patterns, $string)){
	//echo 'Match found';
	$string = str_replace('<', '', $string);
	$string = str_replace('>', '', $string);
	echo $url = str_replace($url_replace_pattern,$string,$url);
}
else{
	echo 'No match found';
}

?> 