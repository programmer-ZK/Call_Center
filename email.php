	
	<?php include_once("includes/config.php"); ?>
	<?php
		$page_name = "email.php";
		$page_title = "Email";
	$page_level = "0";
		$page_group_id = "0";
		$page_menu_title = "Email";
	?>
	<?php include_once($site_root."includes/check.auth.php"); ?>
	
	<?php 	
	
	include_once("classes/tools.php");
	$tools = new tools();
	
		include_once("classes/tools_admin.php");
		$tools_admin = new tools_admin();
		
		include_once("classes/email.php");
		$email = new email();
		
	?>
	<?php include($site_root."includes/header.php"); ?>
	<script type="text/javascript">
	
function validateForm()
{
var x=document.forms["xForm"]["to"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
 // alert("Email Address is not valid");
  return false;
  }
}
function validateForm1()
{
var x=document.forms["xForm"]["cc"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  //alert("Email Address is not valid");
  return false;
  }
}
function validateForm2()
{
var x=document.forms["xForm"]["bcc"].value;
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
 // alert("Email Address is not valid");
  return false;
  }
}
	function msg_validate(){
	
		
			var body    = this.document.getElementById('wysiwyg');
		
			var title    = this.document.getElementById('title');
			var subject    = this.document.getElementById('subject');
			var to = this.document.getElementById('to');
			var cc = this.document.getElementById('cc');
			var bcc = this.document.getElementById('bcc');
	
		var flag = true;
			var err_msg = '';
	
	if(to.value == ''){
					err_msg+= 'Enter Email Address\n';
					this.document.getElementById('to_error').style.display="";
			}
		else{	this.document.getElementById('to_error').style.display="none";
     // Put extra check for data format
     var ret = validateForm();
     if( ret == false )
     {this.document.getElementById('to_email_error').style.display="";
          return false;
     }	
	 
	 else {this.document.getElementById('to_email_error').style.display= "none";}
	 
	 
	 }	
	 
	 if(cc.value != ''){ var ret = validateForm1();
     if( ret == false )
     {this.document.getElementById('to_cc_error').style.display="";
          return false;
     }	
	 else
	 {this.document.getElementById('to_cc_error').style.display="none";}
					
			}
	if(bcc.value != ''){ var ret = validateForm2();
     if( ret == false )
     {this.document.getElementById('to_bcc_error').style.display="";
          return false;
     }	else{this.document.getElementById('to_bcc_error').style.display="none";}
					
			}
	 
	 
	if(subject.value == ''){
					err_msg+= 'Enter Subject\n';
					this.document.getElementById('subject_error').style.display="";
			}
			else {this.document.getElementById('subject_error').style.display="none";}
		 if(body.value == ''){
					err_msg+= 'Enter Body\n';
					this.document.getElementById('body_error').style.display="";
			}
	else {this.document.getElementById('body_error').style.display="none";}
	
			if(err_msg == '' && IsEmpty(err_msg)){
					 return true; 
			}
			else{
					return false;
			}
	}
	
	</script>
	
	<?php
	
	
		$title	 				= $_REQUEST['title'];
		$subject 				= $_REQUEST['subject'];
	
		$body	 				= $_REQUEST['body'];
		$to              	 	= $_POST['to'];
		$cc              	 	= $_POST['cc'];
		$bcc 					= $_REQUEST['bcc'];
		$attachment 			= $_POST['file'];
	
		$title_error 		    = "display:none;";
		$subject_error 			= "display:none;";
		$body_error	 			= "display:none;";
		$to_error	    		= "display:none;";
		$bcc_error	    		= "display:none;";
		$cc_error	    		= "display:none;";
	$to_email_error	    		= "display:none;";
	$to_cc_error	    		= "display:none;";
	$to_bcc_error	    		= "display:none;";
	if(isset($_POST['send']) ){
	  //echo 'waleed';exit;
		$flag = true;
		 if($to == ''){
				$to_error = "display:inline;";
				$flag = false;
		 }
		
		
		
	     if($flag == true){
		$folder = ($site_root."/upload");  
			if (file_exists($folder)) {  
			
			} else {  
				mkdir("$folder", 777);  
			}
			
			$ext = strtolower(substr(strrchr($_FILES["file"]["name"], "."), 1));
			$file_name = date("YmdHis").'.'.$ext;
			$fname = $_FILES["file"]["name"];
			//echo $fname;exit;
	if($_FILES["file"]["size"] >= 0 ){
			
	move_uploaded_file($_FILES["file"]["tmp_name"],"$folder"."/".$_FILES["file"]["name"]);}
	include_once("classes/phpmailer.php");
	include_once("includes/mailserver_info.php");
	$tools->PHPMailer($from, $fromName, $to, $toName, $subject, $msgBody, $isHTML=true, $new_file_name, $attachment_location,$bcc, $replyToName, $replyToEmail,$cc);
	$email->email_functionality($to,$cc,$bcc, $subject, $body,$datetime,$staff_id,$fname);
	$_SESSION[$db_prefix.'_GM'] = "Emailed successfully.";
	header ("Location: index.php");
	}	
	}
	
				
	?>
	
	
	<div class="box">      
	<h4 class="white">Email</h4>
	<div class="box-container">
			
	<form action="email.php" method="post" class="middle-forms cmxform" name="xForm" id="xForm" enctype="multipart/form-data">
	
	
	<h3>Email</h3>
				
	<fieldset>
	<legend>Fieldset Title</legend>
	<ol>						
	
	<li class="even"><label class="field-title">To <em>*</em>:</label> <label><input name="to" id="to" class="txtbox-short"><span class="form-error-inline" id="to_error" title="Please Insert Email Address"  style="<?php echo($to_error); ?>"></span></label><span class="clearFix">&nbsp;</span>
	<span class="form-error-inline" id="to_email_error" title="Please Insert Valid Email"  style="<?php echo($to_email_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	
	
	
	
				<li class="odd"><label class="field-title">Cc:</label> <label><input name="cc" id="cc" class="txtbox-short"><span class="form-error-inline" id="to_cc_error" title="Please Insert Valid Email Address"  style="<?php echo($to_cc_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>			
			
					<li class="odd"><label class="field-title">Bcc:</label> <label><input name="bcc" id="bcc" class="txtbox-short"><span class="form-error-inline" id="to_bcc_error" title="Please Insert Valid Email Address"  style="<?php echo($to_bcc_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>		
	<li class="even"><label class="field-title">Subject <em>*</em>:</label> <label><input name="subject" id="subject" class="txtbox-short" value="<?php echo $subject; ?>"><span class="form-error-inline" id="subject_error" title="Please Insert Subject"  style="<?php echo($subject_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
													
	 <li class="odd"><label class="field-title">Body  <em>*</em>:</label><label> 
													
	
<textarea id="<?php echo"wysiwyg"; ?>" name ="body" rows="7" cols="25" ></textarea>
																					
																							
<span class="form-error-inline" id="body_error" title="Please Insert Body"   style="<?php echo($body_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>


<li class="even" ><label class="field-title">Attach<em>*</em>:</label> <label><input type="file" name="file" id="file"></label><span class="clearFix">&nbsp;</span></li>


	 </ol><!-- end of form elements -->
	 </fieldset>
	 <p class="align-right">
			<a class="button" href="index.php" ><span>Back</span></a>
	
<a class="button" href="javascript:document.xForm.submit();"  onClick="javascript:return msg_validate('xForm');" ><span>Send</span></a>
				<input type="hidden" name="send" id="send" >
								
	
	  </p>
	  <span class="clearFix">&nbsp;</span>
	  </form>
	  </div>
	  </div>
	  <?php
	  ?>
	  <?php include($site_root."includes/footer.php"); ?> 


