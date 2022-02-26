<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "profile_search.php";
	$page_title = "Profile Search";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Profile Search";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
?>
<?php include($site_root."includes/header.php"); ?>

<script type="text/javascript">
function admin_validate(){

	var account_no 		= this.document.getElementById('account_no');
	var customer_id		= this.document.getElementById('customer_id');
	var name 			= this.document.getElementById('name');
	var email 			= this.document.getElementById('email');
	var zakat_status 	= this.document.getElementById('zakat_status');
	var cnic 			= this.document.getElementById('cnic');
	var passport_no		= this.document.getElementById('passport_no');
	var ntn 			= this.document.getElementById('ntn');
	
	var flag = true;
	var err_msg = '';
	var count = 0;
	
	if(account_no.value != ''){
		count++;
		//err_msg+= 'Missing Agent Exten\n';
		//this.document.getElementById('agent_exten_error').style.display="";
	}
	if(customer_id.value != ''){
		count++;
		//err_msg+= 'Missing Full Name\n';
		//this.document.getElementById('full_name_error').style.display="";
	}
	if(name.value != ''){
		count++;
		//err_msg+= 'Missing Email\n';
		//this.document.getElementById('email_error').style.display="";
	}
	if(email.value != ''){
		count++;
		//err_msg+= 'Missing Designation\n';
		//this.document.getElementById('designation_error').style.display="";
	}
	if(zakat_status.value != ''){
		count++;
		//err_msg+= 'Missing Department\n';
		//this.document.getElementById('department_error').style.display="";
	}
	if(cnic.value != ''){
		count++;
		//err_msg+= 'Missing Group\n';
		//this.document.getElementById('group_id_error').style.display="";
	}
	if(passport_no.value != ''){
		count++;
		//err_msg+= 'Missing Group\n';
		//this.document.getElementById('group_id_error').style.display="";
	}
	if(ntn.value != ''){
		count++;
		//err_msg+= 'Missing Group\n';
		//this.document.getElementById('group_id_error').style.display="";
	}

	if(count >=1){
		return true;
	}
	else{
		alert("Please Insert Atleast One Field");
		//$_SESSION[$db_prefix.'_RM'] = "Please insert Minimum search value";
		return false;
	}
}
</script>

      	<div class="box">      
      		<h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">
      		<form action="profile_listing.php" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
		
      			<h3>Search Profile</h3>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
<li >
                            <label class="field-title">Account No  :</label>
                            <label>
          <input name="account_no" id="account_no" class="txtbox-short"  value="<?php echo $account_no; ?>" />
         <!-- <span id="account_no_error" class="form-error-inline" style="<?php echo($account_no_error); ?>">Insert Agent Exten</span>--></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title">Customer ID  :</label>
                            <label>
          <input name="customer_id" id="customer_id" class="txtbox-short" value="<?php echo $customer_id; ?>" />
         <!-- <span id="customer_id_error" class="form-error-inline" style="<?php echo($customer_id_error); ?>">Insert Full Name</span>--></label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Email  :</label>
                            <label>
          <input name="email" id="email" class="txtbox-short" value="<?php echo $email; ?>" />
          <!--<span id="email_error" class="form-error-inline" style="<?php echo($email_error); ?>">Insert e-mail address</span>--></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title">Name  :</label>
                            <label>
          <input name="name" id="name" class="txtbox-short" value="<?php echo $name; ?>"  />
         <!-- <span id="name_error" class="form-error-inline" style="<?php echo($name_error); ?>">Please Insert Password</span>--></label>
                            <span  class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">CNIC  :</label>
                            <label>
          <input name="cnic" id="cnic" class="txtbox-short" value="<?php echo $cnic; ?>" />
         <!-- <span  id="cnic_error" class="form-error-inline" style="<?php echo($cnic_error); ?>">Enter your Designation </span>--></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even" style="display:none;">
                            <label class="field-title">Passport No :</label>
                            <label>
          <input name="passport_no" id="passport_no" class="txtbox-short" value="<?php echo $passport_no; ?>" />
          <!--<span id="passport_no_error" class="form-error-inline" style="<?php echo($passport_no_error); ?>">Enter Department Name </span>--></label>
                            <span class="clearFix">&nbsp;</span></li>
<li style="display:none;">
                            <label class="field-title">NTN  :</label>
                            <label>
          <input name="ntn" id="ntn" class="txtbox-short" value="<?php echo $ntn; ?>" />
         <!-- <span  id="ntn_error" class="form-error-inline" style="<?php echo($ntn_error); ?>">Enter your Designation </span>--></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title">Contact No :</label>
                            <label>
          <input name="caller_id" id="caller_id" class="txtbox-short" value="<?php echo $caller_id; ?>" />
         <!-- <span id="caller_id_error" class="form-error-inline" style="<?php //echo($caller_id_error); ?>">Insert Caller ID</span>--></label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Father/Guardian Name :</label>
                            <label>
          <input name="father_name" id="father_name" class="txtbox-short" value="<?php echo $father_name; ?>" />
         <!-- <span id="father_name_error" class="form-error-inline" style="<?php echo($father_name_error); ?>">Insert Father Name</span>--></label>
                            <span class="clearFix">&nbsp;</span></li>														
      					</ol>
      				</fieldset> 
      				<p class="align-right">
						<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Search</span></a><input type="hidden" value="search" id="search" name="search" />
					</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div>
      	</div>
<?php include($site_root."includes/footer.php"); ?> 
