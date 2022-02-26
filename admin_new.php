<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "admin_new.php";
	$page_title = "Add/Update Admin Settings";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Admin Settings";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
	
	
	include_once("classes/ast_manager.php");
	$ast_manager = new ast_manager();
	//$ast_manager->reload_asterisk();
	//exit;
	
?>
<?php include($site_root."includes/header.php"); 
		


?>
<script type="text/javascript">
function admin_validate(){
/*	alert('Hi');
	return false;
*/
	var admin_id 	= this.document.getElementById('admin_id');
	var agent_exten	= this.document.getElementById('agent_exten');
	var full_name 	= this.document.getElementById('full_name');
	var email 		= this.document.getElementById('email');
	var password 	= this.document.getElementById('password');
	var re_password = this.document.getElementById('re_password');
	var designation	= this.document.getElementById('designation');
	var department 	= this.document.getElementById('department');
	var group_id 	= this.document.getElementById('group_id');
	var flag = true;
	var err_msg = '';
	
	if(agent_exten.value == ''){
		err_msg+= 'Missing Agent Exten\n';
		this.document.getElementById('agent_exten_error').style.display="";
	}
	if(full_name.value == ''){
		err_msg+= 'Missing Full Name\n';
		this.document.getElementById('full_name_error').style.display="";
	}
	if(email.value == ''){
		err_msg+= 'Missing Email\n';
		this.document.getElementById('email_error').style.display="";
	}
	
	
	if(admin_id.value == '' || admin_id.value == 0){
		if(password.value == ''){
			err_msg+= 'Missing Password\n';
			this.document.getElementById('password_error').style.display="";	
			flag =false;
		}
		if(re_password.value == ''){
			err_msg+= 'Missing Confirm Password\n';
			this.document.getElementById('re_password_error').style.display="";
			flag =false;
		}
		if((password.value != re_password.value) && (flag==true)){
			err_msg+= 'Both Password must be same\n';
			this.document.getElementById('re_password_error').style.display="";
		}
	}
	
	if(designation.value == ''){
		err_msg+= 'Missing Designation\n';
		this.document.getElementById('designation_error').style.display="";
	}
	
	if(department.value == ''){
		err_msg+= 'Missing Department\n';
		this.document.getElementById('department_error').style.display="";
	}
	
	if(group_id.value == 0){
		err_msg+= 'Missing Group\n';
		this.document.getElementById('group_id_error').style.display="";
	}

	if(err_msg == '' && IsEmpty(err_msg)){
		return true;
	}
	else{
		//alert(err_msg);
		return false;
	}
}
</script>
<script type="text/javascript">
$.validator.setDefaults({
	submitHandler: function() { alert("submitted!");  /*$("#xForm").submit(); */ }
});

$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	
	// validate signup form on keyup and submit
	$("#xForm").validate({
		rules: {
			agent_exten: "required",
			full_name: "required",
			password: "required",
			re_password: "required",
            designation: "required",
            department: "required",
		},
		messages: {
			agent_exten: "Please enter agent extension",
			full_name: "Please enter user name",
			password: "Please enter password",
			re_password: "Please enter confirm password",
            designation: "Please enter designation",
            department: "Please enter department",
		}
	});
});
</script>
<?php
	

	$admin_id 				= $tools_admin->decryptId($_REQUEST['admin_id']);
	$full_name 				= $_REQUEST['full_name'];
	$agent_exten			= trim($_REQUEST['agent_exten']);
	$email 					= $_REQUEST['email'];

	$password 				= $_REQUEST['password'];
	$cpassword 				= $_REQUEST['re_password'];

	$designation 	  		= $_REQUEST['designation']; 
	$department 	  		= $_REQUEST['department']; 
	$group_id 				= $_REQUEST['group_id'];

$full_name_error 	= "display:none;";
$agent_exten_error 	= "display:none;";
$email_error 		= "display:none;";
$password_error 	= "display:none;";
$re_password_error 	= "display:none;";
$designation_error 	= "display:none;";
$department_error 	= "display:none;";
$admin_groups_error = "display:none;";

if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{
//echo "yahya"; exit;
        $flag = true;
         if($_REQUEST['full_name'] == ''){
                $full_name_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
		 if($_REQUEST['agent_exten'] == ''){
                $agent_exten_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['email'] == ''){
        	        $email_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['password'] == ''){
        	        $password_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['re_password'] == ''){
	                $re_password_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['designation'] == ''){
	                $designation_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['department'] == ''){
                	$department_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['admin_groups'] == 'Please Select'){
                        $admin_groups_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }

        if($flag == true)
        {

		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))
		{
		
		/*$sip = "[".$agent_exten."]
				username = ".$agent_exten."
				type = friend
				host = dynamic
				secret = ".$password."
				context = call_center
				callerid = ".$agent_exten."
				mailbox = ".$agent_exten."@call_center";
		$add_to_sip = "echo '".trim($sip)."' >> ".$asterisk_path."custom_sip.conf";
		$output_sip 	 = trim(shell_exec($add_to_sip));
		
		$extension 		= "exten => ".$agent_exten.",1,Dial(SIP/".$agent_exten.",15,tmgfM(Transfer),\${UNIQUEID},\${EXTEN})";
		$add_to_exten 	= "echo '".trim($extension)."' >> ".$asterisk_path."custom_exten.conf";
		$output_exten	 = shell_exec(trim($add_to_exten));
		
		$extension 		= "exten => ".$agent_exten.",n,Goto(transfer-\${DIALSTATUS},1)";
		$add_to_exten 	= "echo '".trim($extension)."' >> ".$asterisk_path."custom_exten.conf";
		$output_exten	 = shell_exec(trim($add_to_exten));
		

		$ast_manager->reload_asterisk();*/
		//exit;
		//echo $agent_exten; exit;
		
			$rsAdmUser = $admin->admin_user_name_exists($agent_exten);
			if($rsAdmUser->EOF)	{
				$admin->insert_admin_user($agent_exten,$full_name, md5($password), $email, $designation, $department, $group_id, '1');
				$_SESSION[$db_prefix.'_GM'] = "[".$full_name."] for admin panel create successfully.";
				
				header ("Location: admin_list.php");
				exit();
			}
			else{
			
				$_SESSION[$db_prefix.'_RM'] = "[".$full_name."] for admin panel already exists.";
			}	
		}	
	
		if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"]))
		{
			//echo $admin_id."  and  ".$_REQUEST['admin_id']; exit;	
			$rsAdmUser = $admin->admin_user_name_exists($agent_exten,$admin_id);
			if($rsAdmUser->EOF)	{
				
				if(isset($password) && !empty($password) && isset($cpassword) && !empty($cpassword) && ($password==$cpassword)){
					//echo "Condition 1.1";
					$admin->update_admin_user_password($admin_id,md5($password));
					$admin->update_admin_user($admin_id,$agent_exten,$full_name, $email, $designation, $department, $group_id, '1');
					$_SESSION[$db_prefix.'_GM'] = "[".$full_name."] for admin panel updated successfully.";
					header ("Location: admin_list.php");
					exit();
				}
				else if(empty($password) && empty($cpassword)){
					//echo "Condition 1.2";
					$admin->update_admin_user($admin_id,$agent_exten,$full_name, $email, $designation, $department, $group_id, '1');
					$_SESSION[$db_prefix.'_GM'] = "[".$full_name."] for admin panel updated successfully.";
					header ("Location: admin_list.php");
					exit();
				}
				else if((isset($password) && !empty($password)) || (isset($cpassword) && !empty($cpassword))){
					//echo "Condition 1.3";
					if($password != $cpassword){
						$_SESSION[$db_prefix.'_RM'] = "Both [passwords] not matched.";
					}
				}	

			}
			else{
			//echo  $full_name." ,".$password." ,".$email." ,".$designation." ,".$department." ,".$group_id.", ".$is_active.", ";
			//	echo "Condition 5"; exit;			
				$_SESSION[$db_prefix.'_EM'] = "[".$full_name."] for admin panel already exists.";
			}	
		}
	}	
}
		if(isset($admin_id) && !empty($admin_id))
		{
			$rsAdmin  		= 	$admin->get_admin_by_id($admin_id);
			if($rsAdmin->EOF){
				$_SESSION[$db_prefix.'_EM'] = "Admin panel user updation rejected or not found.";
				header ("Location: admin.php");
				exit();
			}
			$full_name 		= 	$rsAdmin->fields['agent_exten'];
			$agent_exten	= 	$rsAdmin->fields['agent_exten'];
			$full_name 		= 	$rsAdmin->fields['full_name'];
			$password 		= 	$rsAdmin->fields['password'];
			$email 			= 	$rsAdmin->fields['email'];
			$designation  	= 	$rsAdmin->fields['designation'];
			$department 	= 	$rsAdmin->fields['department'];
			$group_id  		=	$rsAdmin->fields['group_id'];
			$is_active  	=	$rsAdmin->fields['is_active'];
		}		

?>

      	<div class="box">      
      		<h4 class="white">Admin Settings</h4>
        <div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
		<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $tools_admin->encryptId($admin_id); ?>">
      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
						<li class="even"><label class="field-title">Agent Extension <em>*</em>:</label> <label>
						<input name="agent_exten" id="agent_exten" class="txtbox-short" maxlength="6" value="<?php echo trim($agent_exten); ?>"><span id="agent_exten_error" class="form-error-inline" style="<?php echo($agent_exten_error); ?>">Insert Agent Exten</span></label><span class="clearFix">&nbsp;</span></li>
						<li class="even"><label class="field-title">Admin Name <em>*</em>:</label> <label><input name="full_name" id="full_name" class="txtbox-short" value="<?php echo $full_name; ?>"><span id="full_name_error" class="form-error-inline" style="<?php echo($full_name_error); ?>">Insert Full Name</span></label><span class="clearFix">&nbsp;</span></li>
                                                <li ><label class="field-title">Admin Email <em>*</em>:</label> <label><input name="email" id="email" class="txtbox-short" value="<?php echo $email; ?>"><span id="email_error" class="form-error-inline" style="<?php echo($email_error); ?>">Insert e-mail address</span></label><span class="clearFix">&nbsp;</span></li>
                                                <li class="even"><label class="field-title">Password <em>*</em>:</label> <label><input  type="password" name="password" id="password" class="txtbox-short" value="<?php echo NULL; ?>" autocomplete = "off"><span id="password_error" class="form-error-inline" style="<?php echo($password_error); ?>">Please Insert Password</span></label><span  class="clearFix">&nbsp;</span></li>
                                                
						<li ><label class="field-title">Re-Password <em>*</em>:</label> <label><input name="re_password" type="password" id="re_password" class="txtbox-short" value="<?php echo NULL; ?>" autocomplete = "off"><span id="re_password_error" class="form-error-inline" style="<?php echo($re_password_error); ?>">Re Enter Password</span></label><span class="clearFix">&nbsp;</span></li>

                                                <li class="even"><label class="field-title">Designation <em>*</em>:</label> <label><input name="designation" id="designation" class="txtbox-short" value="<?php echo $designation; ?>"><span  id="designation_error" class="form-error-inline" style="<?php echo($designation_error); ?>">Enter your Designation </span></label><span class="clearFix">&nbsp;</span></li>
					<li><label class="field-title"> Department<em>*</em>:</label> <label><input name="department" id="department" class="txtbox-short" value="<?php echo $department; ?>"><span id="department_error" class="form-error-inline" style="<?php echo($department_error); ?>">Enter Department Name </span></label><span class="clearFix">&nbsp;</span></li>
                                                <li class="even"><label class="field-title">Group <em>*</em>:</label> <label> <?php echo $tools_admin->getcombo("admin_groups","group_id","id","group_name",$group_id,false,"form-select","","Group",""); ?><span id="group_id_error" class="form-error-inline" style="<?php echo($admin_groups_error); ?>">Please Select group</span></label><span class="clearFix">&nbsp;</span></li>		
      					</ol>
      				</fieldset> 
      				<p class="align-right">
					<?php   if(isset($admin_id) && !empty($admin_id)){?>
						<a class="button" href="javascript:document.xForm.submit();"  ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Add</span></a>
						<input type="hidden" value="CREATE NEW ADMIN >>" id="add" name="add" />
               				<?php    }?>					
					<!--<input type="image" src="images/bt-send-form.gif" />-->
				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?> 
