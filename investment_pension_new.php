<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "investment_pension_new.php";
	$page_title = "Add/Update Investment Pension";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Investment Pension";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php
    include_once('lib/nusoap.php');
		 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
	
	include_once("classes/soap_client.php");
	$sOap_client = new soap_client();
	
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function get_types_of_units(index)
{
	//var solution_type  			= this.document.getElementById('solution_type');
	var FundCode = document.getElementsByTagName( "option" )[index].value;
	var text = document.getElementsByTagName( "option" )[index].text;
	var rnd = Math.random();
    var url="ajax_call.php?id="+rnd+"&param_1=FundCode"+"&param_2="+FundCode;
    postRequest(url);
}
function postRequest(strURL)
{
        var xmlHttp;
          if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                 var xmlHttp = new XMLHttpRequest();
            }else if (window.ActiveXObject) { // IE
                var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlHttp.open('POST', strURL, true);
            xmlHttp.setRequestHeader
              ('Content-Type', 'application/x-www-form-urlencoded');
                xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
               updatepage(xmlHttp.responseText);
                //alert(xmlHttp.responseText);
              }
           }
         xmlHttp.send(strURL);
}
function updatepage(str)
{
	document.getElementById("types_of_units_label").innerHTML = str ;
	//types_of_units_label
}

</script>
<script type="text/javascript">
function admin_validate(){
/*	alert('Hi');
	return false;
*/
		
	var investment_solution  		= this.document.getElementById('investment_solution');
	var transaction_type 			= this.document.getElementById('transaction_type');
	var transaction_channel			= this.document.getElementById('transaction_channel');
	var unit_type 					= this.document.getElementById('unit_type');
	var amount						= this.document.getElementById('amount');
	var reference_no				= this.document.getElementById('reference_no');
	var bank_account_no 			= this.document.getElementById('bank_account_no');
	var branch_name 				= this.document.getElementById('branch_name');
	var account_no 					= this.document.getElementById('account_no');
	var customer_id  				= this.document.getElementById('customer_id');
	var bank_name 					= this.document.getElementById('bank_name');
	var coverage					= this.document.getElementById('coverage');
	var sum_insured 				= this.document.getElementById('sum_insured');
	var is_income_benefit			= this.document.getElementById('is_income_benefit');
	var client_dob					= this.document.getElementById('client_dob');
	var client_age 					= this.document.getElementById('client_age');
	var retirement_age 				= this.document.getElementById('retirement_age');
	var volatility 					= this.document.getElementById('volatility');
	
	var flag = true;
	var err_msg = '';
	
	if(investment_solution.value == ''){
		err_msg+= 'Missing Investment Solution\n';
		this.document.getElementById('investment_solution_error').style.display="";
	}
	if(transaction_type.value == ''){
		err_msg+= 'Missing Transaction Type\n';
		this.document.getElementById('transaction_type_error').style.display="";
	}
	if(transaction_channel.value == ''){
		err_msg+= 'Missing Transaction Channel\n';
		this.document.getElementById('transaction_channel_error').style.display="";
	}
	if(unit_type.value == ''){
		err_msg+= 'Missing Unit Type\n';
		this.document.getElementById('unit_type_error').style.display="";
	}
	if(amount.value == ''){
		err_msg+= 'Missing Amount\n';
		this.document.getElementById('amount_error').style.display="";
	}
	if(reference_no.value == ''){
		err_msg+= 'Missing Reference No\n';
		this.document.getElementById('reference_no_error').style.display="";
	}
	if(bank_account_no.value == ''){
		err_msg+= 'Missing Bank Account No\n';
		this.document.getElementById('bank_account_no_error').style.display="";
	}
	
	if(branch_name.value == ''){
		err_msg+= 'Missing Branch Name\n';
		this.document.getElementById('branch_name_error').style.display="";
	}
	
	if(account_no.value == ''){
		err_msg+= 'Missing Account No\n';
		this.document.getElementById('account_no_error').style.display="";
	}

	if(customer_id.value == ''){
		err_msg+= 'Missing Customer ID\n';
		this.document.getElementById('customer_id_error').style.display="";
	}
	if(bank_name.value == ''){
		err_msg+= 'Missing Bank Name\n';
		this.document.getElementById('bank_name_error').style.display="";
	}
	if(coverage.value == ''){
		err_msg+= 'Missing Coverage\n';
		this.document.getElementById('coverage_error').style.display="";
	}
	
	if(sum_insured.value == ''){
		err_msg+= 'Missing Sum Insured\n';
		this.document.getElementById('sum_insured_error').style.display="";
	}
	
	if(is_income_benefit.value == ''){
		err_msg+= 'Missing Is Income Benefit\n';
		this.document.getElementById('is_income_benefit_error').style.display="";
	}

	if(client_dob.value == ''){
		err_msg+= 'Missing Coverage\n';
		this.document.getElementById('coverage_error').style.display="";
	}
	
	if(sum_insured.value == ''){
		err_msg+= 'Missing Client DOB\n';
		this.document.getElementById('client_dob_error').style.display="";
	}
	
	if(client_age.value == ''){
		err_msg+= 'Missing Is Client Age\n';
		this.document.getElementById('client_age_error').style.display="";
	}

	if(retirement_age.value == ''){
		err_msg+= 'Missing Retirement Age\n';
		this.document.getElementById('retirement_age_error').style.display="";
	}
	
	if(volatility.value == ''){
		err_msg+= 'Missing Volatility\n';
		this.document.getElementById('volatility_error').style.display="";
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
	
	$investment_solution 					= ($_REQUEST['investment_solution']);
	$transaction_type 				= $_REQUEST['transaction_type'];
	$transaction_channel 				= $_REQUEST['transaction_channel'];

	$unit_type 				= $_REQUEST['unit_type'];
	$amount 			= $_REQUEST['amount'];

	$reference_no 	  			= $_REQUEST['reference_no']; 
	$bank_account_no 	  				= $_REQUEST['bank_account_no']; 
	$branch_name 		= $_REQUEST['branch_name'];
	$account_no 			= $_REQUEST['account_no'];
	$customer_id 				= $_REQUEST['customer_id'];

	$bank_name 	  			= $_REQUEST['bank_name']; 
	$coverage 	  				= $_REQUEST['coverage']; 
	$sum_insured 		= $_REQUEST['sum_insured'];
	$is_income_benefit 			= $_REQUEST['is_income_benefit'];
	$client_dob 				= $_REQUEST['client_dob'];

	$client_age 		= $_REQUEST['client_age'];
	$retirement_age 			= $_REQUEST['retirement_age'];
	$volatility 				= $_REQUEST['volatility'];

	$investment_solution_error 			= "display:none;";
	$transaction_type_error 			= "display:none;";
	$transaction_channel_error 		= "display:none;";
	$unit_type_error 		= "display:none;";
	$amount_error 		= "display:none;";
	$reference_no_error 			= "display:none;";
	$bank_account_no_error= "display:none;";
	$branch_name_error 		= "display:none;";
	$account_no_error 			= "display:none;";

	$customer_id_error 			= "display:none;";
	$bank_name_error 			= "display:none;";
	$coverage_error 		= "display:none;";
	$sum_insured_error 		= "display:none;";
	$is_income_benefit_error 		= "display:none;";
	$client_dob_error 			= "display:none;";
	$client_age_error= "display:none;";
	$retirement_age_error 		= "display:none;";
	$volatility_error 			= "display:none;";


if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{
//echo "yahya"; exit;
        $flag = true;
         if($_REQUEST['investment_solution'] == ''){
                $investment_solution_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['transaction_type'] == ''){
        	        $transaction_type_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['transaction_channel'] == ''){
        	        $transaction_channel_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['unit_type'] == ''){
	                $unit_type_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['amount'] == ''){
	                $amount_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['reference_no'] == ''){
                	$reference_no_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['bank_account_no'] == ''){
                        $bank_account_no_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }
	if($_REQUEST['branch_name'] == ''){
        	        $branch_name_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['account_no'] == ''){
        	        $account_no_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }

	if($_REQUEST['customer_id'] == ''){
                	$customer_id_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['bank_name'] == ''){
                        $bank_name_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }
	if($_REQUEST['coverage'] == ''){
        	        $coverage_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['sum_insured'] == ''){
        	        $sum_insured_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }

	if($_REQUEST['is_income_benefit'] == ''){
        	        $is_income_benefit_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }

	if($_REQUEST['client_dob'] == ''){
                	$client_dob_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['client_age'] == ''){
                        $client_age_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
                 }
	if($_REQUEST['retirement_age'] == ''){
        	        $retirement_age_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['volatility'] == ''){
        	        $volatility_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }

        if($flag == true)
        {

		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))
		{
			$rsAdmUser = $admin->admin_user_name_exists($full_name);
			if($rsAdmUser->EOF)	{
				$admin->insert_admin_user($account_no,$customer_id, $solution_type, $types_of_units, $product_type, $coverage, $requested_sum_insured, '1');
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
					$admin->update_admin_user($account_no,$customer_id, $solution_type, $types_of_units, $product_type, $coverage, $requested_sum_insured, '1');
					$_SESSION[$db_prefix.'_GM'] = "[".$full_name."] for admin panel updated successfully.";
					header ("Location: admin_list.php");
					exit();
				}
				else if(empty($password) && empty($cpassword)){
					//echo "Condition 1.2";
					$admin->update_admin_user( $account_no,$customer_id, $solution_type, $types_of_units, $product_type, $coverage, $requested_sum_insured,'1');
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
				$_SESSION[$db_prefix.'_RM'] = "[".$full_name."] for admin panel already exists.";
			}	
		}
	}	
}
	/*	if(isset($admin_id) && !empty($admin_id))
		{
			$rsAdmin  		= 	$admin->get_admin_by_id($admin_id);
			if($rsAdmin->EOF){
				$_SESSION[$db_prefix.'_RM'] = "Admin panel user updation rejected or not found.";
				header ("Location: admin.php");
				exit();
			}
			$account_no 			= 	$rsAdmin->fields['account_no'];
			$customer_id 			= 	$rsAdmin->fields['customer_id'];
			$solution_type 			= 	$rsAdmin->fields['solution_type'];
			$types_of_units  		= 	$rsAdmin->fields['types_of_units'];
			$product_type 			= 	$rsAdmin->fields['product_type'];
			$coverage  				=	$rsAdmin->fields['coverage'];
			$requested_sum_insured  =	$rsAdmin->fields['requested_sum_insured'];
			retirement_age			=	$rsAdmin->fields['retirement_age'];		
			volatality				=	$rsAdmin->fields['volatality'];
		}		
	*/
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
						
						
						
				<li class="even">
				<label class="field-title">Account No <em>*</em>:</label><label><input name="account_no" id="account_no" class="txtbox-short" value="<?php echo $account_no; ?>"><span id="account_no_error" class="form-error-inline" title = "Please Enter Account No" style="<?php echo($account_no_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li ><label class="field-title">Customer ID <em>*</em>:</label><label><input name="customer_id" id="customer_id" class="txtbox-short" value="<?php echo $customer_id; ?>"><span id="customer_id_error" class="form-error-inline" title = "Please Enter Customer ID" style="<?php echo($customer_id_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li class="even">
				<label class="field-title">Investment Solution  <em>*</em>:</label><label
				<?php $method = 'investment_solution ';$params = array('AccessKey' => $investment_solution ,'Channel' => $channel); echo $investment_solution ->get_combo($method, $params, $combo_id="investment_solution ", $value_feild="investment_solution ", $text_feild="ShortName", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="javascript:get_types_of_units(this.selectedIndex)", $title="")?>
				
				<span id="investment_solution_error" class="form-error-inline" style="<?php echo($investment_solution_error); ?>">Please Select Investment Solution </span>
				</label>
				<span  class="clearFix">&nbsp;</span>
				</li>
				
				<li >
				<label class="field-title">Transaction Type <em>*</em>:</label>
				<label id="transaction_type_label">
				<span id="transaction_type_error" class="form-error-inline" style="<?php echo($types_of_units_error); ?>">Please Select Transaction Type</span></label>
				<span  class="clearFix">&nbsp;</span>
				</li>

				<li class="even">
				<label class="field-title">Transaction Channel  <em>*</em>:</label><label
				<?php $method = 'transaction_channel ';$params = array('AccessKey' => $transaction_channel ,'Channel' => $channel); echo $transaction_channel ->get_combo($method, $params, $combo_id="transaction_channel ", $value_feild="transaction_channel ", $text_feild="ShortName", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="javascript:get_types_of_units(this.selectedIndex)", $title="")?>
				
				<span id="transaction_channel_error" class="form-error-inline" style="<?php echo($transaction_channel_error); ?>">Please Select Transaction Channel </span>
				</label>
				<span  class="clearFix">&nbsp;</span>
				</li>
				
				<li >
				<label class="field-title">Unit Type <em>*</em>:</label>
				<label id="unit_type_label">
				<span id="unit_type_error" class="form-error-inline" style="<?php echo($types_of_units_error); ?>">Please Select Unit Type</span></label>
				<span  class="clearFix">&nbsp;</span>
				</li>
				
				<li class="even">
				<label class="field-title">Amount <em>*</em>:</label><label><input name="amount" id="amount" class="txtbox-short" value="<?php echo $amount; ?>"><span id="amount_error" class="form-error-inline" title = "Please Enter Amount" style="<?php echo($amount_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li ><label class="field-title">Reference No <em>*</em>:</label><label><input name="reference_no" id="reference_no" class="txtbox-short" value="<?php echo $reference_no; ?>"><span id="reference_no_error" class="form-error-inline" title = "Please Enter Reference No" style="<?php echo($customer_id_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li class="even">
				<label class="field-title">Bank Account No <em>*</em>:</label><label><input name="bank_account_no" id="bank_account_no" class="txtbox-short" value="<?php echo $bank_account_no; ?>"><span id="bank_account_no_error" class="form-error-inline" title = "Please Enter Bank Account No" style="<?php echo($bank_account_no_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li ><label class="field-title">Branch Name <em>*</em>:</label><label><input name="branch_name" id="branch_name" class="txtbox-short" value="<?php echo $branch_name; ?>"><span id="branch_name_error" class="form-error-inline" title = "Please Enter Branch Name" style="<?php echo($branch_name_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>	
				
				<li class="even">
				<label class="field-title">Bank Name <em>*</em>:</label><label><input name="bank_name" id="bank_name" class="txtbox-short" value="<?php echo $bank_name; ?>"><span id="bank_name_error" class="form-error-inline" title = "Please Enter Bank Name" style="<?php echo($bank_name_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li ><label class="field-title">Coverage <em>*</em>:</label><label><input name="coverage" id="coverage" class="txtbox-short" value="<?php echo $coverage; ?>"><span id="coverage_error" class="form-error-inline" title = "Please Enter Coverage" style="<?php echo($coverage_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li class="even">
				<label class="field-title">Sum Insured <em>*</em>:</label><label><input name="sum_insured" id="sum_insured" class="txtbox-short" value="<?php echo $sum_insured; ?>"><span id="sum_insured_error" class="form-error-inline" title = "Please Enter Sum Insured" style="<?php echo($sum_insured_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li ><label class="field-title">Is Income Benefit <em>*</em>:</label><label><input name="is_income_benefit" id="is_income_benefit" class="txtbox-short" value="<?php echo $is_income_benefit; ?>"><span id="is_income_benefit_error" class="form-error-inline" title = "Please Enter Is Income Benefit" style="<?php echo($is_income_benefit_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>	
				
				<li class="even">
				<label class="field-title">Client DOB <em>*</em>:</label><label><input name="client_dob" id="client_dob" class="txtbox-short" value="<?php echo $client_dob; ?>"><span id="client_dob_error" class="form-error-inline" title = "Please Enter Client DOB" style="<?php echo($client_dob_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li ><label class="field-title">Client Age <em>*</em>:</label><label><input name="client_age" id="client_age" class="txtbox-short" value="<?php echo $client_age; ?>"><span id="client_age_error" class="form-error-inline" title = "Please Enter Client Age" style="<?php echo($client_age_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li class="even">
				<label class="field-title">Retirement Age <em>*</em>:</label><label><input name="retirement_age" id="retirement_age" class="txtbox-short" value="<?php echo $retirement_age; ?>"><span id="retirement_age_error" class="form-error-inline" title = "Please Enter Retirement Age" style="<?php echo($retirement_age_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
				
				<li ><label class="field-title">Volatility <em>*</em>:</label><label><input name="volatility" id="volatility" class="txtbox-short" value="<?php echo $volatility; ?>"><span id="volatility_error" class="form-error-inline" title = "Please Enter Volatility" style="<?php echo($volatility_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>	
				
				<li class="even">
				<label class="field-title">Product Type <em>*</em>:</label> 
				<label>
				<select name="product_type" id="product_type" class="txtbox-short" >
				<option value="1">Islamic</option>
				<option value="2">Commercial</option>
				</select>
				<span id="product_type_error" class="form-error-inline" style="<?php echo($product_type_error); ?>">Please Select Product Type</span>
				</label>
				<span  class="clearFix">&nbsp;</span>
				</li>									
				<li >
				<label class="field-title">Takaful Coverage <em>*</em>:</label> 
				<label>
				<select name="coverage" id="coverage" class="txtbox-short" >
				<option value="1">Accidental death & total permenant disability</option>
				<option value="2">Life Insurance</option>
				<option value="3">Critical illness</option>
				<option value="4">Accidental Medical Expense Re-imbursement</option>
				</select>
				<span id="coverage_error" class="form-error-inline" style="<?php echo($coverage_error); ?>">Please Select Takaful Coverage</span>
				</label>
				<span  class="clearFix">&nbsp;</span>
				</li>
				
				<li class="even">
				<label class="field-title"> Requested Sum Insured<em>*</em>:</label> 
				<label>
				<input name="requested_sum_insured" id="requested_sum_insured" class="txtbox-short" value="<?php echo $requested_sum_insured; ?>">
				<span id="requested_sum_insured_error" class="form-error-inline" style="<?php echo($requested_sum_insured_error); ?>">Requested Sum Insured </span>
				</label>
				<span class="clearFix">&nbsp;</span>
				</li>
				
				<li>
				<label class="field-title"> Retirement Age<em>*</em>:</label>
				<label>
				<input name="retirement_age" id="retirement_age" class="txtbox-short" value="<?php echo $requested_sum_insured; ?>">
				<span id="retirement_age_error" class="form-error-inline" style="<?php echo($retirement_age_error); ?>">Enter Retirement Age </span>
				</label>
				<span class="clearFix">&nbsp;</span>
				</li>
				
				<li class="even">
				<label class="field-title">Volatality <em>*</em>:</label>
				<label>
				<select name="volatality" id="volatality" class="txtbox-short" >
				<option value="1">Lower</option>
				<option value="2">Low</option>
				<option value="3">Medium</option>
				<option value="4">High</option>
				<option value="5">Life cycle</option>
				</select>
				<span id="volatality_error" class="form-error-inline" style="<?php echo($volatality_error); ?>">Please Select Volatality</span>
				</label>
				<span  class="clearFix">&nbsp;</span>
				</li>
						
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
