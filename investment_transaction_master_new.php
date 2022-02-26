<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "nvestment_transaction_master_new.php";
	$page_title = "Add/Update Investment Transaction Master";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Investment Transaction Master";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
	$account_no	= $tools_admin->decryptId($_REQUEST['account_no']);
	
	include_once("classes/transactions.php");
	$transactions = new transactions();
	
	 include_once('lib/nusoap.php');
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function get_types_of_units(index){
	var FundCode = document.getElementsByTagName( "option" )[index].value;
	var text = document.getElementsByTagName( "option" )[index].text;
	var rnd = Math.random();
    var url="ajax_call.php?id="+rnd+"&param_1=FundCode"+"&param_2="+FundCode;
    postRequest(url);
}
function postRequest(strURL){
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
function updatepage(str){
	document.getElementById("types_of_units_label").innerHTML = str ;
}

</script>

<script type="text/javascript">
function admin_validate(){
/*	alert('Hi');
	return false;

account_no
caller_id
transaction_type
investment_type
types_of_date
transaction_channel
refrence_no
amount
date
bank_account_no
bank_branch_name
bank_name

*/
	var transaction_type	 		= this.document.getElementById('transaction_type').value;
	var investment_type		 		= this.document.getElementById('investment_type').value;
	var types_of_unit 				= this.document.getElementById('types_of_unit').value;
//	var types_of_date 				= this.document.getElementById('types_of_date');
	var transaction_channel			= this.document.getElementById('transaction_channel').value;
	var refrence_no			 		= this.document.getElementById('refrence_no').value;
	var amount						= this.document.getElementById('amount').value;
	var date						= this.document.getElementById('date');
	var bank_account_no 			= this.document.getElementById('bank_account_no');
	var bank_branch_name 			= this.document.getElementById('bank_branch_name');
	var bank_name 					= this.document.getElementById('bank_name');
	
	var flag 					= true;
	var err_msg 				= '';
	
	if(transaction_type.value == ''){
		err_msg+= 'Missing Transaction Type\n';
		this.document.getElementById('transaction_type_error').style.display="";
	}
	if(investment_type.value == ''){
		err_msg+= 'Missing Transaction Nature\n';
		this.document.getElementById('investment_type_error').style.display="";
	}
	
	if(types_of_unit.value == ''){
		err_msg+= 'Missing From Fund Type\n';
		this.document.getElementById('types_of_unit_error').style.display="";
		flag =false;
	}
/*		alert('Hi');
	return false;
	if(types_of_date.value = ''){
		err_msg+= 'Missing Type of Units\n';
		this.document.getElementById('types_of_date_error').style.display="";
	}*/
	
	if(transaction_channel.value == ''){
		err_msg+= 'Missing Transaction Channel\n';
		this.document.getElementById('transaction_channel_error').style.display="";
	}
	if(refrence_no.value == ''){
		err_msg+= 'Missing Refrence No\n';
		this.document.getElementById('refrence_no_error').style.display="";
	}
	if(amount.value == ''){
		err_msg+= 'Missing Amount\n';
		this.document.getElementById('amount_error').style.display="";
	}
	if(date.value == ''){
		err_msg+= 'Missing Unites\n';
		this.document.getElementById('date_error').style.display="";
	}
	if(bank_account_no.value == ''){
		err_msg+= 'Missing Bank Account No\n';
		this.document.getElementById('bank_account_no_error').style.display="";
	}
	if(bank_branch_name.value == ''){
		err_msg+= 'Missing Branch Name\n';
		this.document.getElementById('bank_branch_name_error').style.display="";
	}
	if(bank_name.value == ''){
		err_msg+= 'Missing  Bank Name\n';
		this.document.getElementById('bank_name_error').style.display="";
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
	$id 						= $tools_admin->decryptId($_REQUEST['id']);
	$transaction_type 			= $_REQUEST['transaction_type']; //= $tools_admin->decryptId($_REQUEST['transaction_type']);
	$investment_type 			= $_REQUEST['investment_type'];
	$types_of_unit 				= $_REQUEST['types_of_unit'];
	$transaction_channel 		= $_REQUEST['transaction_channel'];
	$refrence_no 				= $_REQUEST['refrence_no'];
	$amount 				  	= $_REQUEST['amount']; 
	$date 			  			= $_REQUEST['date']; 
	$bank_account_no			= $_REQUEST['bank_account_no']; 
	$bank_branch_name 			= $_REQUEST['bank_branch_name'];
	$bank_name		 			= $_REQUEST['bank_name'];
	
	$transaction_type_error 	= "display:none;";
	$investment_type_error 		= "display:none;";
	$types_of_unit_error 		= "display:none;";
	$transaction_channel_error	= "display:none;";
	$refrence_no_error 			= "display:none;";
	$amount_error 				= "display:none;";
	$date_error 				= "display:none;";
	$bank_account_no_error 		= "display:none;";
	$bank_branch_name_error 	= "display:none;";
	$bank_name_error 	= "display:none;";
	

if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{

        $flag = true;
         if($_REQUEST['transaction_type'] == ''){
                $transaction_type_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['investment_type'] == ''){
        	        $investment_type_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['types_of_unit'] == ''){
        	        $types_of_unit_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($_REQUEST['transaction_channel'] == ''){
	                $transaction_channel_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['refrence_no'] == ''){
	                $refrence_no_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['amount'] == ''){
	                $amount_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['date'] == ''){
	                $date_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
    		}
	if($_REQUEST['bank_account_no'] == ''){
                	$bank_account_no_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }
	if($_REQUEST['bank_branch_name'] == ''){
                        $bank_branch_name_error = "display:inline;";//$tools->isEmpty('Caller ID');
                        $flag = false;
             }
	if($flag == true)
  {

		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))
		{
		
			$rsAdmUser = $transactions->set_conversion($account_no, $customer_id, $transaction_type, $investment_type, $types_of_date, $from_unit_type, $refrence_no, $to_unit_type, $date, $amount, $bank_branch_name, $channel='IVR');
			
			$method = 'SetConversionTransaction';//$access_key  $channel
           // $params = array('AccessKey'=>$access_key,'Channel'=>$channel,'AccountNo'=>$account_no,'CustomerId'=>$customer_id,'TransType'=>$transaction_type,'TransactionNature'=>$investment_type,'FromFund'=>$types_of_date,'FromUnitType'=>$from_unit_type,'ToFund'=>$refrence_no,'ToUnitType'=>$to_unit_type,'Units'=>$date,'Amount'=>$amount,'Percentage'=>$bank_branch_name);
			
			 $params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no, 'CustomerId'=>$customer_id, 'TransType'=>$transaction_type,'TransactionNature'=>$investment_type,'FromFund'=>$types_of_date,'FromUnitType'=>$from_unit_type,'ToFund'=>$refrence_no,'ToUnitType'=>$to_unit_type,'Units'=>$date,'Amount'=>$amount,'Percentage'=>$bank_branch_name);
			
				$res = $soap_client->call_soap_method($method,$params);
				echo $res; exit;
			if($rsAdmUser->EOF)	
			{
				//$admin->insert_admin_user($admin_id, md5($password), $email, $designation, $department, $group_id, '1');
				
				$_SESSION[$db_prefix.'_GM'] = "Set Conversion successfully.";
				
				
				header ("Location: conversion_new.php");
				exit();
			}
			else{
				$_SESSION[$db_prefix.'_RM'] = "Set Conversion successfully.";
			}	
		}	
	
	/*	if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"]))
		{
			//echo $admin_id."  and  ".$_REQUEST['admin_id']; exit;	
			$rsAdmUser = $admin->admin_user_name_exists($admin_id,$admin_id);
			if($rsAdmUser->EOF)	
			{
				
				if(isset($password) && !empty($password) && isset($cpassword) && !empty($cpassword) && ($password==$cpassword))
				{
					//echo "Condition 1.1";
					$admin->update_admin_user_password($admin_id,md5($password));
					$admin->update_admin_user($admin_id,$admin_id, $email, $designation, $department, $group_id, '1');
					$_SESSION[$db_prefix.'_GM'] = "[".$admin_id."] for admin panel updated successfully.";
					header ("Location: admin_list.php");
					exit();
				}
				else if(empty($password) && empty($cpassword))
				{
					//echo "Condition 1.2";
					$admin->update_admin_user($admin_id,$admin_id, $email, $designation, $department, $group_id, '1');
					$_SESSION[$db_prefix.'_GM'] = "[".$admin_id."] for admin panel updated successfully.";
					header ("Location: admin_list.php");
					exit();
				}
				else if((isset($password) && !empty($password)) || (isset($cpassword) && !empty($cpassword)))
				{
					//echo "Condition 1.3";
					if($password != $cpassword)
					{
						$_SESSION[$db_prefix.'_RM'] = "Both [passwords] not matched.";
					}
				}	

			}
			else
			{
			//echo  $admin_id." ,".$password." ,".$email." ,".$designation." ,".$department." ,".$group_id.", ".$is_active.", ";
			//	echo "Condition 5"; exit;			
				$_SESSION[$db_prefix.'_EM'] = "[".$full_name."] for admin panel already exists.";
			}	
		}*/
	}	
}
/*		if(isset($admin_id) && !empty($admin_id))
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
			$types_of_date  		= 	$rsAdmin->fields['redemption_type'];
			$redemption_type 		= 	$rsAdmin->fields['department'];
			$modeofpayment  		=	$rsAdmin->fields['modeofpayment'];
			$account_type  			=	$rsAdmin->fields['account_type'];
			$bank_account_no  		= 	$rsAdmin->fields['bank_account_no'];
			$bank_account_titlee 	= 	$rsAdmin->fields['bank_account_title'];
			$bank_branch_name  		=	$rsAdmin->fields['bank_branch_name'];
			$bank_branch_code  		=	$rsAdmin->fields['bank_branch_code'];
		}		*/
?>

<div class="box">
  <h4 class="white"><?php echo $page_menu_title ;?></h4>
  <div class="box-container">
    <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
      <input type="hidden" id="id" name="id" value="<?php echo $tools_admin->encryptId($id); ?>">
      <h3>Add / Update</h3>
      <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      <fieldset>
      <legend>Fieldset Title</legend>
      <ol>
        <li class="even">
          <label class="field-title"> Account No <em>*</em>:</label>
          <label>
          <input name="account_no" id="account_no" class="txtbox-short" value="<?php echo $account_no; ?>">
          <span id="date_error" class="form-error-inline" title = "Please Insert Account No" style="<?php $account_no_error = "display:none;"; echo($account_no_error); ?>"></span></label>
          <span  class="clearFix">&nbsp;</span></li>
        <li class="even">
          <label class="field-title">Caller ID <em>*</em>:</label>
          <label>
          <input name="caller_id" id="caller_id" class="txtbox-short" value="<?php echo $caller_id; ?>">
          <span id="caller_id_error" class="form-error-inline" title = "Please Insert Caller ID" style="<?php $caller_id_error = "display:none;"; echo($caller_id_error); ?>"></span></label>
          <span  class="clearFix">&nbsp;</span></li>
        <li class="even">
          <label class="field-title">Transaction Type<em>*</em>:</label>
          <label>
          <?php // $transaction_type, $investment_type, $types_of_date, $from_unit_type, $refrence_no, $to_unit_type, $date, $amount, $bank_branch_name,
															$method = 'GetTransactionType';
															$params = array('AccessKey' => $access_key,'Channel' => $channel);
															echo $soap_client->get_combo($method, $params, $combo_id="transaction_type", $value_feild="TransactionCode", $text_feild="TransactionDescription", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="", $title="")
															//echo $sOap_client->getcombo("admin_groups","group_id","id","group_name",$group_id,false,"form-select","","Group",""); 
															
							?>
          <span id="transaction_type_error" class="form-error-inline" title = "Please Select Transaction Type" style="<?php echo($transaction_type_error); ?>"></span></label>
          <span  class="clearFix">&nbsp;</span></li>
<li >
          <label class="field-title">Investmennt Type<em>*</em>:</label>
          <label>
          <?php // $transaction_type, $investment_type, $types_of_date, $from_unit_type, $refrence_no, $to_unit_type, $date, $amount, $bank_branch_name,
															
															$method = 'GetInvestmentSolution';
															$params = array('AccessKey' => $access_key,'Channel' => $channel);
															echo $sOap_client->get_combo($method, $params, $combo_id="investment_type", $value_feild="Code", $text_feild="Name", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="javascript:get_types_of_units(this.selectedIndex)", $title="")
															
															//echo $sOap_client->getcombo("admin_groups","group_id","id","group_name",$group_id,false,"form-select","","Group",""); 
															
							?>
          <span id="investment_type_error" class="form-error-inline" title = "Please Select Investment Solution Type" style="<?php echo($investment_type_error); ?>"></span></label>
          <span  class="clearFix">&nbsp;</span></li>
        <li class="even">
          <label class="field-title">Types of Units <em>*</em>:</label>
          <label id="types_of_unit_label"> <span id="types_of_unit_error" class="form-error-inline" title = "Please Select Type of Units" style="<?php echo($types_of_unit_error); ?>"></span></label>
          <span  class="clearFix">&nbsp;</span></li>
        <li >
          <label class="field-title">Trans Channel <em>*</em>:</label>
          <label >
          <select name="transaction_channel" id="transaction_channel" class="txtbox-short"  onchange="javascript:get_combo(this.selectedIndex)">
            <option value="-1">Please Select</option>
            <option value="1">Debit Card</option>
            <option value="2">Credit Card</option>
            <option value="3">Other Bank</option>
          </select>
          <span id="investment_type_error" class="form-error-inline" title = "Please Select Investment Type" style="<?php echo($investment_type_error); ?>"></span></label>
          <span  class="clearFix">&nbsp;</span></li>
        <li class="even">
          <label class="field-title">Refrence No <em>*</em>:</label>
          <label > 
		  <input name="refrence_no" id="refrence_no" class="txtbox-short" value="<?php echo $refrence_no; ?>">
		  <span id="refrence_no_error" class="form-error-inline" title = "Please Insert Refrence No" style="<?php echo($refrence_no_error); ?>"></span></label>
          <span class="clearFix">&nbsp;</span></li>
        
        <li >
          <label class="field-title">Amount <em>*</em>:</label>
          <label>
          <input name="amount" id="amount" class="txtbox-short" value="<?php echo $amount; ?>">
          <span id="amount_error" class="form-error-inline" title = "Please Insert Amount" style="<?php echo($amount_error); ?>"></span></label>
          <span class="clearFix">&nbsp;</span></li>
        <li class="even">
          <label class="field-title">Date <em>*</em>:</label>
          <label>
          <input name="date" id="date" class="txtbox-short" value="<?php echo $date; ?>">
          <span id="date_error" class="form-error-inline" title = "Please Insert Date" style="<?php echo($date_error); ?>"></span></label>
          <span class="clearFix">&nbsp;</span></li>
        <li >
          <label class="field-title"> Bank Account No<em>*</em>:</label>
          <label>
          <input name="bank_account_no" id="bank_account_no" class="txtbox-short" value="<?php echo $bank_account_no; ?>">
          <span id="bank_account_no_error" class="form-error-inline" title = "Please Insert Bank Account No" style="<?php echo($bank_account_no_error); ?>"></span></label>
          <span class="clearFix">&nbsp;</span></li>
        <li >
          <label class="field-title"> Bank Branch Name<em>*</em>:</label>
          <label>
          <input name="bank_branch_name" id="bank_branch_name" class="txtbox-short" value="<?php echo $bank_branch_name; ?>">
          <span id="bank_branch_name_error" class="form-error-inline" title = "Please Insert Bank Branch Name" style="<?php echo($bank_branch_name_error); ?>"></span></label>
          <span class="clearFix">&nbsp;</span></li>
        <li class="even">
          <label class="field-title"> Bank Name<em>*</em>:</label>
          <label>
          <input name="bank_name" id="bank_name" class="txtbox-short" value="<?php echo $bank_branch_name; ?>">
          <span id="bank_name_error" class="form-error-inline" title = "Please Insert Bank Name" style="<?php echo($bank_name_error); ?>"></span></label>
          <span class="clearFix">&nbsp;</span></li>
      
      </ol>
      </fieldset>
      <p class="align-right">
        <?php   if(isset($id) && !empty($id)){?>
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
  </div>
  <!-- end of div.box-container -->
</div>
<!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?>
