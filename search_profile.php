<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "search_profile.php";
	$page_title = "Search Profile";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Search Profile";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
	
	
	include_once("classes/ast_manager.php");
	$ast_manager = new ast_manager();
	
		include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$sOap_client = new soap_client();
	
	
?>
<?php include($site_root."includes/header.php"); 
		


?>
<script type="text/javascript">
function admin_validate(){
	//alert('Hi');
	//return false;

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
      		<h4 class="white">Admin Settings</h4>
        <div class="box-container">
      		<form action="profile_listing.php" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
		
      			<h3>Search Profile</h3>
      			<!--<p>Please complete the form below. Mandatory fields marked <em>*</em></p>-->
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
<li class="even">
                            <label class="field-title">Account No <em>*</em>:</label>
                            <label>
          <input name="account_no" id="account_no" class="txtbox-short"  value="<?php echo $account_no; ?> ">
          <span id="account_no_error" class="form-error-inline" style="<?php echo($account_no_error); ?>">Insert Agent Exten</span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title">Customer ID <em>*</em>:</label>
                            <label>
          <input name="customer_id" id="customer_id" class="txtbox-short" value="<?php echo $customer_id; ?>">
          <span id="customer_id_error" class="form-error-inline" style="<?php echo($customer_id_error); ?>">Insert Full Name</span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Email <em>*</em>:</label>
                            <label>
          <input name="email" id="email" class="txtbox-short" value="<?php echo $email; ?>">
          <span id="email_error" class="form-error-inline" style="<?php echo($email_error); ?>">Insert e-mail address</span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title">Name <em>*</em>:</label>
                            <label>
          <input   name="name" id="name" class="txtbox-short" value="<?php echo NULL; ?>" autocomplete = "off">
          <span id="name_error" class="form-error-inline" style="<?php echo($name_error); ?>">Please Insert Password</span></label>
                            <span  class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Zakat Ststus <em>*</em>:</label>
                            <label>
          <input name="zakat_status"  id="zakat_status" class="txtbox-short" value="<?php echo NULL; ?>" autocomplete = "off">
          <span id="zakat_status_error" class="form-error-inline" style="<?php echo($zakat_status_error); ?>">Re Enter Password</span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title">CNIC <em>*</em>:</label>
                            <label>
          <input name="cnic" id="cnic" class="txtbox-short" value="<?php echo $cnic; ?>">
          <span  id="cnic_error" class="form-error-inline" style="<?php echo($cnic_error); ?>">Enter your Designation </span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li>
                            <label class="field-title">Passport No<em>*</em>:</label>
                            <label>
          <input name="passport_no" id="passport_no" class="txtbox-short" value="<?php echo $passport_no; ?>">
          <span id="passport_no_error" class="form-error-inline" style="<?php echo($passport_no_error); ?>">Enter Department Name </span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title">NTN <em>*</em>:</label>
                            <label>
          <input name="ntn" id="ntn" class="txtbox-short" value="<?php echo $ntn; ?>">
          <span  id="ntn_error" class="form-error-inline" style="<?php echo($ntn_error); ?>">Enter your Designation </span></label>
                            <span class="clearFix">&nbsp;</span></li>


<!--<li class="even">
                            <label class="field-title">NTN <em>*</em>:</label>
                            <label> <?php echo $tools_admin->getcombo("admin_groups","group_id","id","group_name",$group_id,false,"form-select","","Group",""); ?><span id="group_id_error" class="form-error-inline" style="<?php echo($admin_groups_error); ?>">Please Select group</span></label>
                            <span class="clearFix">&nbsp;</span></li>-->
      					</ol>
      				</fieldset> 
      				<p class="align-right">
					<?php   if(isset($admin_id) && !empty($admin_id)){?>
						<a class="button" href="javascript:document.xForm.submit();"  ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Search</span></a>
						<input type="hidden" value="CREATE NEW ADMIN >>" id="search" name="search" />
               				<?php    }?>					
					<!--<input type="image" src="images/bt-send-form.gif" />-->
				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?> 
