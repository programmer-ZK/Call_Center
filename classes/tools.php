<?php
class tools
{
	function tools(){
	}
	function validateEmail($email) {
	  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)){
	    return true;
	  }
	  return false;
	}
	function validateAlphaString($val) {
	  if(preg_match('/^([a-zA-Z0-9._-\space\&,])+$/', $val)){
	    return true;
	  }
	  return false;
	}
	function validateString($val) {
	  if(preg_match('/^([a-zA-Z_-\space])+$/', $val)){
	    return true;
	  }
	  return false;
	}
	function validateNumber($val) {
	  if(preg_match('/^([0-9_-\space])+$/', $val) && is_numeric($val)){
	    return true;
	  }
	  return false;
	}
	function validateFloat($val) {
	  if(preg_match('/^[0-9]*\.?[0-9]+$/', $val) && (is_float($val) || is_numeric($val))){
	    return true;
	  }
	  return false;
	}
	function validateURL($val) {
if(preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $val)){
		 return true;
	 	}
	  return false;
	}
	function GetCurrentDateTime(){
		$curdate = date("Y-m-d H:i:s");
		return $curdate;
	}
	function GetCurrentDate(){
		$curdate = date("Y-m-d");
		return $curdate;
	}
	function GetCurrentTime(){
		$curdate = date("H:i:s");
		return $curdate;
	}
	function GetNextDate($howManydays='1'){
		$d = (date("d")+$howManydays);
		if($d<10)
			$d="0".$d;

		$curdate = date("Y-m-$d H:i:s");
		return $curdate;
	}
	function GetNextMonth(){
		$d = (date("m")+1);
		if($d<10)
			$d="0".$d;

		$curdate = date("Y-$d-d H:i:s");
		return $curdate;
	}
	function RemoveHtmlTags($document)
	{
	   $search = array (
	   				"'<script[^>]*?>.*?</script>'si",  	// Strip out javascript
                    "'<[/!]*?[^<>]*?>'si",          	// Strip out HTML tags
                    "'([rn])[s]+'",                		// Strip out white space
                    "'&(quot|#34);'i",               	// Replace HTML entities
                    "'&(amp|#38);'i",
                    "'&(lt|#60);'i",
                    "'&(gt|#62);'i",
                    "'&(nbsp|#160);'i",
                    "'&(iexcl|#161);'i",
                    "'&(cent|#162);'i",
                    "'&(pound|#163);'i",
                    "'&(copy|#169);'i",
                    "'&#(d+);'e");                    	// evaluate as php

	   $replace = array (
	   					"",
					   	"",
					   	"\1",
					   	"\"",
					   	"&",
					   	"<",
					   	">",
					   	" ",
					   	chr(161),
					   	chr(162),
					   	chr(163),
					   	chr(169),
					   	"chr(xxx1)"); 					// remove the "xxx" - this is just for showing the source

		$text = preg_replace($search, $replace, $document);
		return $text;
	}


        function sendEmail($fromemail, $toemail, $toname, $subject, $emaildata, $isHTML='1', $bcc='', $new_file_name='', $attachment_location=''){
		global $company_name;
		if(!empty($isHTML)){
			$isHTML=true;
		}else{
			$isHTML=false;
		}

		$this->PHPMailer($fromemail, $company_name, $toemail, $toname, $subject, $emaildata, $isHTML, $new_file_name, $attachment_location,$bcc);
		return true;

		$headers = "";
		if(!empty($isHTML)){
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		}
		$headers .= "From: ".$fromemail."\r\n";
		if(!empty($bcc)){
			$headers .= "Bcc: ".$bcc."\r\n";
		}
		$headers .= "Reply-To: ".$fromemail."\r\n";
		$headers .= "X-Mailer: PHP/".phpversion();

		if(!empty($toname)){
			$to		  = $toname." <".$toemail.">"; // note the comma
		} else {
			$to		  = $toemail; // note the comma
		}
		@mail($to, $subject, $emaildata, $headers);
		return true;
	}	// end of function SendEmail


function PHPMailer($from, $from_name, $to, $toName, $subject, $msgBody, $isHTML=true, $new_file_name='', $attachment_location='',$bcc='', $replyToName='', $replyToEmail='',$cc){
                global $site_root;
        include_once($site_root."classes/phpmailer.php");
                global $smtp_host_1; global $smtp_host_2; global $smtp_user; global $smtp_pass;
				
			//	echo $smtp_host_1.$smtp_user.$smtp_pass;exit;
error_reporting(E_ALL); 
ini_set("display_errors", 2);

                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->Host = $smtp_host_1.";".$smtp_host_2;
                 //$mail->Host = "10.1.107.202";
                
				
				$mail->SMTPAuth = false;
                $mail->Username = $smtp_user;
                $mail->Password = $smtp_pass;
              //  $mail->Username = "mkhurram@ublfunds.com";
               // $mail->Password = "ubl@006";
                
				
				
				//include_once("templates_email.php");
                $mail->AddAttachment("upload"."/".$_FILES['file']['name'] );
                $mail->From = $from;
                $mail->FromName = $from_name;
			//	$mail->Debug = true;
			//	$mail->$SMTPDebug ;
                if(empty($replyToEmail)){
                        $mail->AddReplyTo($from,$from_name);
                }else{
                        $mail->AddReplyTo($replyToEmail,$replyToName);
                }
                $mail->Subject = $_POST['subject'];
                if(!empty($bcc)){
                        $bcclist = explode(",",$_POST[bcc]);
                        foreach($bcclist as $bcc_add){
                                $mail->AddBCC($bcc_add, 'Member');
                        }
                }
                $mail->AddAddress($_POST['to']);
                if($attachment_location!=''){

              }$mail->AddCC($_POST['cc']);
                $mail->Body = $_POST['body'];
                if($mail->Send()){
          //    $sent = TRUE;echo "www";exit();
                }
		else{
	//	echo "wwwkkk";exit();
//	echo "Unable to send email due to server error";exit;
		}
                $mail->ClearAddresses();
                unset($mail);
                return true;
        }

/*
        function PHPMailer($from, $fromName, $to, $toName, $subject, $msgBody, $isHTML=true, $new_file_name='', $attachment_location='',$bcc='', $replyToName='', $replyToEmail=''){
		global $site_root; 
		include_once($site_root."classes/phpmailer.php");
		global $smtp_host_1; global $smtp_host_2; global $smtp_user; global $smtp_pass;
		$mail = new PHPMailer();
		// SMTP settings
		$mail->IsSMTP();
		$mail->Host = $smtp_host_1.";".$smtp_host_2;
		$mail->SMTPAuth = true;
		$mail->Username = $smtp_user;
		$mail->Password = $smtp_pass;
		
		// message headers
		$mail->From = $from;
		$mail->FromName = $fromName;
		if(empty($replyToEmail)){
			$mail->AddReplyTo($from,$fromName);
		}else{
			$mail->AddReplyTo($replyToEmail,$replyToName);
		}
		$mail->Subject = $subject;
		if(!empty($bcc)){
			$bcclist = explode(",",$bcc);
			foreach($bcclist as $bcc_add){
				$mail->AddBCC($bcc_add, 'Member');
			}
		}
		// additional parameters
		$mail->IsHTML($isHTML);
		// set recipient address(es)
		$mail->AddAddress($to,$toName);
                if($attachment_location!=''){
                    $mail->AddAttachment($attachment_location, $new_file_name);
                }

		// build message
		$mail->Body = $msgBody;
		// send message
		if($mail->Send()){
			echo 'asdas';
			$sent = TRUE;
		}
		// clear mail addresses for next send
		$mail->ClearAddresses();
		// unset mail object
		unset($mail);
		return true;
	}*/
	// Get The Client IP Address
	function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	function encrypt_string($su_email){
		return md5($su_email);
	}

	function getYears($company_reg_year_value){
		for($i=1901;$i<=$year=date("Y");$i++){
			if($i==$company_reg_year_value){
					$rs.='<option value="'.$i.'" selected="selected" title="'.$i.'">'.$i.'</option>';
			}else{
					$rs.='<option value="'.$i.'" title="'.$i.'">'.$i.'</option>';
			}
		}
		return $rs;
	}
	function findexts ($filename){
		$filename = strtolower($filename) ;
		$exts = split("[/\\.]", $filename) ;
		$n = count($exts)-1;
		$exts = $exts[$n];
		return $exts;
	}
	function getsplitNumber ($number_value){
		$rs=explode("|",$number_value);
		return $rs;
	}
	function getJoinNumber ($country_code,$city_code,$number){
		$rs=$country_code."|".$city_code."|".$number;
		return $rs;
	}
	function viewSplitNumber ($number_value){
		$rs=preg_replace('/\|/','-',$number_value);
		return $rs;
	}
	function checkPasswordValidation($password,$confirm_password){
		if( empty($password) || empty($confirm_password)){
			$error_code ="Required fields Can't be empty";
		}else if($password != $confirm_password){
			$error_code ="Confirm password not match";
		}else if(strlen($password)<6){
			$error_code ="Password must be of at least 6 characters";
		}
		else{
			$error_code="TRUE";
		}
		return $error_code;
	}
	function encryptProductId($pid){
		return round($pid*240880);
	}
	function decryptProductId($pid){
		return round($pid/240880);
	}
	function checkImage($image_name,$path="0")
	{
		$images=explode("/",$image_name);
		$image_name=$images[sizeof($images)-1];
		if(!empty($path)){
 			$filename=$path."".$image_name;
		}
		if (file_exists($filename) && !empty($image_name)){
			return $image_name;
		}else{
			return "blank.gif";
		}
	}
	function break_long_string($stringToBreak,$length=100){
		if(strlen($stringToBreak) > $length ){
				if(strpos($stringToBreak," ")){
					$strarr=explode(" ",$stringToBreak);
					for($i=0;$i<sizeof($strarr);$i++){
						if(strlen($strarr[$i]) > $length ){
								$loopsize=round(strlen($strarr[$i])/$length);
								$j=0;
								for($k=0;$k<=$loopsize;$k++){
								$strreturn.= substr($strarr[$i],$j,$length)." ";
								$j=$j+$length;
								}
						}else{
							$strreturn.=$strarr[$i]." ";
						}
					}#end FOR
				}else{
					$loopsize=strlen($stringToBreak)/$length;
					$j=0;
					for($i=0;$i<$loopsize;$i++){
					$strreturn.= substr($stringToBreak,$j,$length)." ";
					$j=$j+$length;
					}
				}
			}else{
				$strreturn= $stringToBreak;
			}
			return $strreturn;
	}
	function checkEmailorURL_IN_String($str){
		$str = preg_replace("/([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+/","*****" ,$str);
		$str = preg_replace('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', '******', $str);
	  	return $str;
	}
	
	function isEmpty($value)//$name,$value)
	{	
		//if($_REQUEST[$name] != '')
		//{
		//	$output = "false";
		//}
		//else
		//{ 
			$output = "<tr class=\"msg\">";
			$output.= "<td class=\"title\" style=\"padding-top:5px; width:100px;\"></td>";
			$output.= "<td colspan=\"2\">Please insert ".$value."</td>";
			$output.= "</tr>";
			
			//$output= "<p><label>Please insert ".$value."</label></p>";
			
			$output = "<label class=\"error\">Please enter customer ".$value."</label>";
			
		//}
		return $output;
	}
}
?>
