<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "investment_merakal_new.php";
	$page_title = "Add/Update Investment MeraKal";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Investment Mera Kal";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function admin_validate(){
/*	alert('Hi');
	return false;
*/
	var account_no  			= this.document.getElementById('account_no');
	var customer_id  			= this.document.getElementById('customer_id');
	var solution_type  			= this.document.getElementById('solution_type');
	var types_of_units  		= this.document.getElementById('types_of_units');
	var product_type  			= this.document.getElementById('product_type');
	var coverage  				= this.document.getElementById('coverage');
	var requested_sum_insured 	= this.document.getElementById('requested_sum_insured');
	var income_benefit 			= this.document.getElementById('income_benefit');
	var dob_child  				= this.document.getElementById('dob_child');
	var maturity_age 			= this.document.getElementById('maturity_age');
	var total_age_of_plan 		= this.document.getElementById('total_age_of_plan');
	var flag 					= true;
	var err_msg 				= '';
	
	if(account_no.value == ''){
		err_msg+= 'Missing Full Name\n';
		this.document.getElementById('account_no_error').style.display="";
	}
	if(customer_id.value == ''){
		err_msg+= 'Missing Email\n';
		this.document.getElementById('customer_id_error').style.display="";
	}
	/*
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
	}*/
	
	if(solution_type.value == ''){
		err_msg+= 'Missing Designation\n';
		this.document.getElementById('solution_type_error').style.display="";
	}
	
	if(types_of_units.value == ''){
		err_msg+= 'Missing Department\n';
		this.document.getElementById('types_of_units_error').style.display="";
	}
	
	if(product_type.value == ''){
		err_msg+= 'Missing Group\n';
		this.document.getElementById('product_type_error').style.display="";
	}
	
	if(coverage.value == ''){
		err_msg+= 'Missing Designation\n';
		this.document.getElementById('coverage_error').style.display="";
	}
	
	if(requested_sum_insured.value == ''){
		err_msg+= 'Missing Department\n';
		this.document.getElementById('requested_sum_insured_error').style.display="";
	}
	
	if(income_benefit.value == ''){
		err_msg+= 'Missing Group\n';
		this.document.getElementById('income_benefit_error').style.display="";
	}
	
	if(dob_child.value == ''){
		err_msg+= 'Missing Designation\n';
		this.document.getElementById('dob_child_error').style.display="";
	}
	
	if(maturity_age.value == ''){
		err_msg+= 'Missing Department\n';
		this.document.getElementById('maturity_age_error').style.display="";
	}
	
	if(total_age_of_plan.value == ''){
		err_msg+= 'Missing Group\n';
		this.document.getElementById('total_age_of_plan_error').style.display="";
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
			full_name: "required",
			password: "required",
			re_password: "required",
            designation: "required",
            department: "required",
		},
		messages: {
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
	$account_no 			= $_REQUEST['account_no'];
	$customer_id 			= $_REQUEST['customer_id'];
	$solution_type 			= $_REQUEST['solution_type'];
	$types_of_units 		= $_REQUEST['types_of_units'];
	$product_type 	  		= $_REQUEST['product_type']; 
	$coverage 	  			= $_REQUEST['coverage']; 
	$requested_sum_insured 	= $_REQUEST['requested_sum_insured'];
	$income_benefit 		= $_REQUEST['income_benefit'];
	$dob_child 	  			= $_REQUEST['dob_child']; 
	$maturity_age 	  		= $_REQUEST['maturity_age']; 
	$total_age_of_plan 		= $_REQUEST['total_age_of_plan'];


	$account_no_error 				= "display:none;";
	$customer_id_error 				= "display:none;";
	$solution_type_error 			= "display:none;";
	$types_of_units_error 			= "display:none;";
	$product_type_error 			= "display:none;";
	$coverage_error 				= "display:none;";
	$requested_sum_insured_error 	= "display:none;";
	$income_benefit_error 			= "display:none;";
	$dob_child_error 				= "display:none;";
	$maturity_age_error 			= "display:none;";
	$total_age_of_plan_error 		= "display:none;";


if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{
//echo "yahya"; exit;
        $flag = true;
         if($_REQUEST['account_no'] == ''){
                $account_no_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['customer_id'] == ''){
        	        $customer_id_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['solution_type'] == ''){
        	        $solution_type_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['types_of_units'] == ''){
	                $types_of_units_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['product_type'] == ''){
	                $product_type_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['coverage'] == ''){
                	$coverage_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['requested_sum_insured'] == ''){
                        $requested_sum_insured_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }
	if($_REQUEST['income_benefit'] == ''){
	                $income_benefit_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['dob_child'] == ''){
	                $dob_child_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['maturity_age'] == ''){
                	$maturity_age_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['total_age_of_plan'] == ''){
                        $total_age_of_plan_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }
        if($flag == true)
        {

		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))
		{
			$rsAdmUser = $admin->admin_user_name_exists($full_name);
			if($rsAdmUser->EOF)	{
				$admin->insert_investment_mk($account_no, $customer_id, $solution_type, $types_of_units, $product_type, $coverage, $requested_sum_insured, $income_benefit, $dob_child, $maturity_age, $total_age_of_plan, '1');
				$_SESSION[$db_prefix.'_GM'] = "[".$full_name."] for admin panel create successfully.";
				header ("Location: admin_new.php");
				exit();
			}
			else{
				$_SESSION[$db_prefix.'_RM'] = "[".$full_name."] for admin panel already exists.";
			}	
		}	
	
		if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"]))
		{
			//echo $admin_id."  and  ".$_REQUEST['admin_id']; exit;	
			$rsAdmUser = $admin->admin_user_name_exists($full_name,$admin_id);
			if($rsAdmUser->EOF)	{
				
				if(isset($password) && !empty($password) && isset($cpassword) && !empty($cpassword) && ($password==$cpassword)){
					//echo "Condition 1.1";
					$admin->update_admin_user_password($admin_id,md5($password));
					$admin->update_admin_user($admin_id,$full_name, $email, $designation, $department, $group_id, '1');
					$_SESSION[$db_prefix.'_GM'] = "[".$full_name."] for admin panel updated successfully.";
					header ("Location: admin_list.php");
					exit();
				}
				else if(empty($password) && empty($cpassword)){
					//echo "Condition 1.2";
					$admin->update_admin_user($admin_id,$full_name, $email, $designation, $department, $group_id, '1');
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
			$account_no 			= 	$rsAdmin->fields['account_no'];
			$customer_id 			= 	$rsAdmin->fields['customer_id'];
			$solution_type 			= 	$rsAdmin->fields['solution_type'];
			$types_of_units 	 	= 	$rsAdmin->fields['types_of_units'];
			$product_type 			= 	$rsAdmin->fields['product_type'];
			$coverage  				=	$rsAdmin->fields['coverage'];
			$requested_sum_insured  =	$rsAdmin->fields['requested_sum_insured'];
			$income_benefit 		= 	$rsAdmin->fields['income_benefit'];
			$dob_child  			=	$rsAdmin->fields['dob_child'];
			$maturity_age  			=	$rsAdmin->fields['maturity_age'];
			$total_age_of_plan  	=	$rsAdmin->fields['total_age_of_plan'];
			}		

?>

      	<div class="box">      
      		<h4 class="white"><?php echo $page_menu_title ;?></h4>
        <div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
		<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $tools_admin->encryptId($admin_id); ?>">
      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
						
						<li class="even"><label class="field-title">Account No <em>*</em>:</label> <label><input name="account_no" id="account_no" class="txtbox-short" value="<?php echo $account_no; ?>"><span id="account_no_error" class="form-error-inline" title = "Please Insert Account No" style="<?php echo($account_no_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
                                                <li ><label class="field-title">Customer ID <em>*</em>:</label> <label><input name="customer_id" id="customer_id" class="txtbox-short" value="<?php echo $customer_id; ?>"><span id="account_no_error" class="form-error-inline" title = "Please Insert Customer ID" style="<?php echo($account_no_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                                                <li class="even"><label class="field-title">Solution Type <em>*</em>:</label> <label><select name="solution_type" id="solution_type" class="txtbox-short" ><option value="1">Fund</option><option value="2">Plan</option><option value="3">Pension Scheme</option></select><span id="solution_type_error" class="form-error-inline" title = "Please Select Solution Type" style="<?php echo($solution_type_error); ?>"></span></label><span  class="clearFix">&nbsp;</span></li>
                                                
                                                <li ><label class="field-title">Types of Units <em>*</em>:</label> <label><select name="types_of_units" id="types_of_units" class="txtbox-short" ><option value="1">B</option><option value="2">C</option></select><span id="types_of_units_error" class="form-error-inline" title = "Please Select Types of Units" style="<?php echo($types_of_units_error); ?>"></span></label><span  class="clearFix">&nbsp;</span></li>

                                                <li class="even"><label class="field-title">Product Type <em>*</em>:</label> <label><select name="product_type" id="product_type" class="txtbox-short" ><option value="1">Islamic</option><option value="2">Commercial</option></select><span id="product_type_error" class="form-error-inline" title = "Please Select Product Type" style="<?php echo($product_type_error); ?>"></span></label><span  class="clearFix">&nbsp;</span></li>									
                                                
												<li ><label class="field-title">Coverage <em>*</em>:</label> <label><select name="coverage" id="coverage" class="txtbox-short" ><option value="1">Accidental death & total permenant disability</option><option value="2">Natural Death & total permenant disability</option></select><span id="coverage_error" class="form-error-inline" title = "Please Select Coverage" style="<?php echo($coverage_error); ?>"></span></label><span  class="clearFix">&nbsp;</span></li>
												
					<li class="even"><label class="field-title"> Requested Sum Insured<em>*</em>:</label> <label><input name="requested_sum_insured" id="requested_sum_insured" class="txtbox-short" value="<?php echo $requested_sum_insured; ?>"><span id="requested_sum_insured_error" class="form-error-inline" title = "Please Insert Requested Sum Insured" style="<?php echo($requested_sum_insured_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					
					<li><label class="field-title"> Income Benefit<em>*</em>:</label> <label><input name="income_benefit" id="income_benefit" class="txtbox-short" value="<?php echo $income_benefit; ?>"><span id="income_benefit_error" class="form-error-inline" title = "Please Insert Income Benefit" style="<?php echo($income_benefit_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					
					<li class="even"><label class="field-title"> DOB Child<em>*</em>:</label> <label><input name="dob_child" id="dob_child" class="txtbox-short" value="<?php echo $dob_child; ?>"><span id="dob_child_error" class="form-error-inline" title = "Please Insert DOB Child" style="<?php echo($dob_child_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					
					<li ><label class="field-title"> Maturity Age<em>*</em>:</label> <label><input name="maturity_age" id="maturity_age" class="txtbox-short" value="<?php echo $maturity_age; ?>"><span id="maturity_age_error" class="form-error-inline" title = "Please Insert Maturity Age" style="<?php echo($maturity_age_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>					
					
					<li class="even"><label class="field-title"> Total Age of Plan<em>*</em>:</label> <label><input name="total_age_of_plan" id="total_age_of_plan" class="txtbox-short" value="<?php echo $total_age_of_plan; ?>"><span id="total_age_of_plan_error" class="form-error-inline" title = "Please Insert Total Age Of Plan" style="<?php echo($total_age_of_plan_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>	
					
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
