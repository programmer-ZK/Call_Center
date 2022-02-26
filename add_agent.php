<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "add_agent.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Add Agent";
        $page_menu_title = "Add Agent";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
		
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();

?>	

<?php include($site_root."includes/iheader.php"); ?>	

<script type="text/javascript">
function agent_validate(){
/*	alert('Hi');
	return false;*/

	//var admin_id 	= this.document.getElementById('admin_id');
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
	
	
	//if(admin_id.value == '' || admin_id.value == 0){
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
	//}
	
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

<?php

$agent_id = $_REQUEST['agent_id'];

if(isset($agent_id) && !empty($agent_id))
{
	$rsAdmin  		= 	$admin->get_admin_by_id($agent_id);
//	if($rsAdmin->EOF){
//		$_SESSION[$db_prefix.'_EM'] = "Admin panel user updation rejected or not found.";
//		header ("Location: admin.php");
//		exit();
//	}
	$agent_exten	= 	$rsAdmin->fields['agent_exten'];
	$full_name 		= 	$rsAdmin->fields['full_name'];
	//$password 		= 	$rsAdmin->fields['password'];
	$email 			= 	$rsAdmin->fields['email'];
	$designation  	= 	$rsAdmin->fields['designation'];
	$department 	= 	$rsAdmin->fields['department'];
	$group_id  		=	$rsAdmin->fields['group_id'];
	$is_active  	=	$rsAdmin->fields['is_active'];
	
	unset($_REQUEST['agent_id']);
}	

$full_name_error 	= "display: none;";
$email_error	    = "display: none;";
$password_error	 	= "display: none;";
$re_password_error 	= "display: none;";
$department_error 	= "display: none;";

if(isset($_REQUEST['add_agent']))
 { 
 	$flag = true;
 
	$staff_id 			= $tools_admin->decryptId($_REQUEST['admin_id']);
	$new_agent_exten	= $_REQUEST['agent_exten'];
	$new_full_name 		= $_REQUEST['full_name'];
	$new_email			= $_REQUEST['email'];
	$password 			= $_REQUEST['password'];
	$cpassword 			= $_REQUEST['re_password'];
	$new_designation  	= $_REQUEST['designation'];
	$new_department 	= $_REQUEST['department'];
	$new_group_id 		= $_REQUEST['group_id'];
	
	$agent_exten		= $new_agent_exten;
	$full_name 			= $new_full_name ;
	$email 				= $new_email;
	$designation  		= $new_designation;
	$department 		= $new_department;
	$group_id  			= $new_group_id;
	
	if($new_full_name == ""){
	$flag = false;
	$full_name_error = "";
	}
	if($new_email == ""){
	$flag = false;
	$email_error ="";
	}
	if($password == ""){
	$flag = false;
	$password_error ="";
	}
	if($cpassword == ""){
	$flag = false;
	$re_password_error ="";
	}
	if($new_department == ""){
	$flag = false;
	$department_error ="";
	}
	if($flag == true){
		
		$admin->insert_agent($new_agent_exten, $new_full_name, $new_email, $password, $new_designation, $new_department, $new_group_id, $staff_id);
		
		//update previous agent status to 0 and update_datetime
		$admin->update_prev_agent($agent_id);
		
		$_SESSION[$db_prefix.'_GM'] = "Agent successfully added.";
		header('Location:agent-stats.php');
	}
 }
 
?>

<div class="box" style="width:100%;">
	<h4 class="white"><?php echo($page_title); ?></h4>
	<div class="box-container">	
      		<form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
            		<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $tools_admin->encryptId($_SESSION[$db_prefix.'_UserId']); ?>">
                    
				<fieldset>
					<h3><?php echo($page_title); ?></h3>
					<ol>
                    	<li class="">
							<label class="field-title">Agent Name <font color="red"><em>*</em></font>:</label>
							<input maxlength="50" id="full_name" name="full_name" value="<?php echo $full_name; ?>"/>    
							<span id="full_name_error" class="form-error-inline" style="<?php echo($full_name_error); ?>">Insert Full Name</span>
						</li>	
						
						<li class="even">
							<label class="field-title">Agent Extension :</label>
							<input maxlength="50" readonly="readonly" id="agent_exten" name="agent_exten" value="<?php echo $agent_exten; ?>"/> 
							<!--<span id="agent_exten_error" class="form-error-inline" style="<?php// echo($agent_exten_error); ?>">Insert Agent Exten</span>-->
						</li>	
						
						<li class="">
							<label class="field-title">Agent Email <font color="red"><em>*</em></font>:</label>
							<input maxlength="50" id="email" name="email" value="<?php echo $email; ?>"/> 
							<span id="email_error" class="form-error-inline" style="<?php echo($email_error); ?>">Insert e-mail address</span>
						</li>	
						
						<li class="even">
							<label class="field-title">Password <font color="red"><em>*</em></font>:</label>
							<input type="password" maxlength="50" id="password" name="password" value="<?php echo NULL; ?>"/> 
							<span id="password_error" class="form-error-inline" style="<?php echo($password_error); ?>">Please Insert Password</span>
						</li>
						
						<li class="">
							<label class="field-title">Retype Password <font color="red"><em>*</em></font>:</label>
							<input type="password" maxlength="50" id="re_password" name="re_password" value="<?php echo NULL; ?>"/> 
							<span id="re_password_error" class="form-error-inline" style="<?php echo($re_password_error); ?>">Re Enter Password</span>
						</li>
						
                        <li class="even">
							<label class="field-title">Designation :</label>
                            <input maxlength="20" readonly="readonly" id="designation" name="designation" value="<?php echo $designation; ?>"/>
							<!--<span id="re_password_error" class="form-error-inline" style="<?php// echo($re_password_error); ?>">Re Enter Password</span>-->
						</li>
						
						<li class="">
							<label class="field-title">Deparment <font color="red"><em>*</em></font>:</label>
                            <input maxlength="50" id="department" name="department" value="<?php echo $department; ?>"/>
							<span id="department_error" class="form-error-inline" style="<?php echo($department_error); ?>">Enter Department Name </span>
						</li>
						
						<li class="even">
							<label class="field-title">Group :</label>
							<?php echo $tools_admin->getcombo("admin_groups","kgroup_id","id","group_name",$group_id,true,"form-select","","Group",""); ?>
							<input type="hidden" id="group_id" name="group_id" value="<?php echo $group_id; ?>"/>
							<input type="hidden" id="agent_id" name="agent_id" value="<?php echo $agent_id; ?>"/>
							<!--<span id="group_id_error" class="form-error-inline" style="<?php// echo($admin_groups_error); ?>">Please Select group</span>-->
						</li>				
					</ol>
					
					<p class="align-right">
						<!--onclick="javascript: return agent_validate()"--><a  class="button" href="javascript:document.xForm.submit();"><span>Add</span></a>
						<input type="hidden" value="SUBMIT ADD_AGENT FORM >>"     name="add_agent" id="add_agent"/>	
						<input type="hidden" value="add" name="operation" id="operation"/>
					</p>
				</fieldset>      

    	</form>
	</div>
</div> 
<?php include($site_root."includes/ifooter.php"); ?> 
