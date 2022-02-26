<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "redemption_new.php";
	$page_title = "Add/Update Redemption";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Redemption";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
	
	$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
	$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
	
	include_once("classes/transactions.php");
	$transactions = new transactions();
	
	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$sOap_client = new soap_client();
	
    include_once("classes/user_pin.php");
    $user_pin = new user_pin();
?>

<?php include($site_root."includes/header.php"); //http://www.codingforums.com/showthread.php?t=201276?>


<script type="text/javascript">
function admin_validate(){

	var payment 			= this.document.getElementById('payment');
	
	var MailingAddress 		= this.document.getElementById('MailingAddress');
	
	var CityName 			= this.document.getElementById('CityName');
	
	var email 				= this.document.getElementById('email');
	
	var mobile 				= this.document.getElementById('mobile');
	
	var residence 			= this.document.getElementById('residence');
	
	var office 				= this.document.getElementById('office');
	
	var humail 				= this.document.getElementById('humail');
	
	var husms 				= this.document.getElementById('husms');
	
	var huemail 			= this.document.getElementById('huemail');
	
	var MaritalStatus 		= this.document.getElementById('MaritalStatus');
	
	

	var flag 			= true;
	var err_msg = '';
	
	if(payment.value == ''){
		err_msg+= 'Missing Payment/Frequency\n';
		this.document.getElementById('payment_error').style.display="";
	}
	
	
	if(MailingAddress.value == ''){
		err_msg+= 'Missing MailingAddress\n';
		this.document.getElementById('MailingAddress_error').style.display="";
	}
	
	
	if(CityName.value == ''){
		err_msg+= 'Missing CityName\n';
		this.document.getElementById('CityName_error').style.display="";
	}
	
	
	if(email.value == ''){
		err_msg+= 'Missing Email\n';
		this.document.getElementById('email_error').style.display="";
	}
	
	
	if(mobile.value == ''){
		err_msg+= 'Missing Mobile Number\n';
		this.document.getElementById('mobile_error').style.display="";
	}
	
	
	if(residence.value == ''){
		err_msg+= 'Missing Residence Number\n';
		this.document.getElementById('residence_error').style.display="";
	}
	
	
	if(office.value == ''){
		err_msg+= 'Missing Office Number\n';
		this.document.getElementById('office_error').style.display="";
	}
	
	
	if(humail.value == ''){
		err_msg+= 'Missing Hold/Un-hold Mail Instructions\n';
		this.document.getElementById('humail_error').style.display="";
	}
	
	
	if(husms.value == ''){
		err_msg+= 'Missing Hold/Un-hold SMSInstructions\n';
		this.document.getElementById('husms_error').style.display="";
	}
	
	
	if(huemail.value == ''){
		err_msg+= 'Missing Hold/Un-hold Email Instructions\n';
		this.document.getElementById('huemail_error').style.display="";
	}
	
	
	if(MaritalStatus.value == ''){
		err_msg+= 'Missing Marital Status\n';
		this.document.getElementById('MaritalStatus_error').style.display="";
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

<script type="text/javascript">

function get_investment_solution(value)
{
	var param1 = 'GBD';
	if(value == "Plan")
	{
		get_combo(value);
		
	 	this.document.getElementById('unit').style.display="none";
		//this.document.getElementById('unit').innerHTML = "";
		
	}
	else if(value == "Fund")
	{
		
		get_combo(value);
		//get_balance(value);
		this.document.getElementById('unit').style.display="";
		//this.document.getElementById('unit').innerHTML = "Unit";
	}

function get_combo(param2)
	{
		var account_no 			= this.document.getElementById('account_no').value;
		var customer_id 		= this.document.getElementById('customer_id').value;
	
		var rnd = Math.random();
	    var url="ajax_call.php?id="+rnd+"&param_1="+ param1 +"&param_2="+ param2+"&param_3="+account_no+"&param_4="+customer_id+"&param_5="+value+"&param_6=RT";
		//alert(url);
        	var xmlHttp;
          	if (window.XMLHttpRequest) 
			{ // Mozilla, Safari, ...
            	      xmlHttp = new XMLHttpRequest();
	       }
		   else 
		   if (window.ActiveXObject) 
		   { // IE
                 xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
           }
            xmlHttp.open('POST', url, true);
			//alert(url);
            xmlHttp.setRequestHeader
           ('Content-Type', 'application/x-www-form-urlencoded');
           xmlHttp.onreadystatechange = function() 
		   {
       			if (xmlHttp.readyState == 4) 
				{
					document.getElementById("solution_type_div").innerHTML = xmlHttp.responseText ;
        	       //updatepage(xmlHttp.responseText);
            	 //   alert(xmlHttp.responseText);
	            }
    		}
         xmlHttp.send(url);
	}



}

function get_types_of_units(index,id,isType){
	get_balance(isType,index);
	//var FundCode = document.getElementsByTagName( "option" )[index].value;
	//var text = document.getElementsByTagName( "option" )[index].text;
	
	var FundCode = document.getElementById(id).value;
	
	var rnd = Math.random();
    var url="ajax_call.php?id="+rnd+"&param_1=FundCode"+"&param_2="+FundCode;
	
    postRequest(url);
}
function get_balance(param3,index)
	{
	
			var account_no 			= this.document.getElementById('account_no').value;
			var customer_id 		= this.document.getElementById('customer_id').value;
		var rnd = Math.random();
		var url="ajax_call.php?id="+rnd+"&param_1=GBAL&param_2="+param3 +"&param_3="+index+"&param_4="+account_no+"&param_5="+customer_id+"&param_6=RT";
		//alert(url);
		var xmlHttp;
		if (window.XMLHttpRequest) 
		{ // Mozilla, Safari, ...
                  xmlHttp = new XMLHttpRequest();
        }
		else if 
		(window.ActiveXObject) { // IE
                 xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlHttp.open('POST', url, true);
        xmlHttp.setRequestHeader
        ('Content-Type', 'application/x-www-form-urlencoded');
        xmlHttp.onreadystatechange = function() 
		{
        	if (xmlHttp.readyState == 4) 
			{
				//	document.getElementById("to_fund_label").innerHTML = xmlHttp.responseText ;
               		//updatepage(xmlHttp.responseText);
                	unit_amount  = xmlHttp.responseText.split("|");
					unit1 = unit_amount[0];
					amount = unit_amount[1];
					//unit_amount_lbl
					document.getElementById("unit_lbl").innerHTML = unit1;
					document.getElementById("amount_lbl").innerHTML = amount;
				//	alert(amount+" and "+unit1);
            }
         }
         xmlHttp.send(url);
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
function iget_types_of_units(index){
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
function redemption_validate(){
//	alert('Hi');
//	return false;


	
	var account_no 			= this.document.getElementById('account_no');
	var customer_id 		= this.document.getElementById('customer_id');
	var solution_type 		= this.document.getElementById('solution_type');//
	var Unit			 	= this.document.getElementById('unit_value');
	var modeofpayment		= this.document.getElementById('modeofpayment');
	var i_types_of_units	= this.document.getElementById('_types_of_units');
	//alert(this.document.getElementById('_types_of_units').value);
	//var bank_account_no 	= this.document.getElementById('bank_account_no');
/*	var bank_account_title	= this.document.getElementById('bank_account_title');
	var bank_branch_name 	= this.document.getElementById('bank_branch_name');
	var bank_branch_code 	= this.document.getElementById('bank_branch_code');
	var bank_name 			= this.document.getElementById('$bank_name');*/
	var flag = true;
	var err_msg = '';
	
	
	
	if(solution_type  == null){ 
	this.document.getElementById('solution_type_error').style.display=""; 
	//alert("sol type");
	return false;
	}
	 if(modeofpayment  == null){ 
	this.document.getElementById('bank_error').style.display=""; 
	//alert("bank error 1");
	return false;
	}
	
	this.document.getElementById('solution_type_error').style.display="none";
	this.document.getElementById('bank_error').style.display="none";  
	this.document.getElementById('unit_error').style.display="none"; 
	this.document.getElementById('unit_error').style.display="none"; 
	this.document.getElementById('unit_error').style.display="none"; 
	this.document.getElementById('types_of_units_error').style.display="none";
	
	if(solution_type.value  == 0)
	{
		 this.document.getElementById('solution_type_error').style.display="";
		//alert("solution type");
		 return false;
	}
	 if(i_types_of_units.value == 0){
		 this.document.getElementById('types_of_units_error').style.display="";
		//alert("type of unit");
		 return false;
	 }
	
	//unit_error
	var units = document.forms['xForm'].elements['unit'];
		var unit_type = getCheckedValue(units);
		
		if(!unit_type){
			this.document.getElementById('unit_error').style.display=""; 
			//alert("unit_error");
			return false;
		}
	
	if(modeofpayment.value  == 3)
	{
		var units = document.forms['xForm'].elements['bank'];
		var unit_type = getCheckedValue(units);
		
		if(!unit_type){
			this.document.getElementById('bank_error').style.display=""; 
			//alert("bank error");
			return false;
		}
		
		
	 //alert("HII"); 
	 //this.document.getElementById('solution_type_error').style.display="";
	 //return false;
	 }
	
	if(account_no.value == ''){
		err_msg+= 'Missing Account No\n';
		this.document.getElementById('account_no_error').style.display="";
	}
	if(customer_id.value == ''){
		err_msg+= 'Missing Customer ID\n';
		this.document.getElementById('customer_id_error').style.display="";
	}
	/*if(bank_name.value == ''){
		err_msg+= 'Missing bank_name\n';
		this.document.getElementById('bank_name_error').style.display="";
	}*/
	
	/*if(solution_type.value == ''){
		err_msg+= 'Missing Solution Type\n';
		this.document.getElementById('solution_type_error').style.display="";
		flag =false;
	}*/
	if(Unit.value == '' || Unit.value == '0'){
		err_msg+= 'Missing Unit Type\n';
		this.document.getElementById('unit_value_error').style.display="";
	}
	/*if(modeofpayment.value == ''){
		err_msg+= 'Missing Mode of Payment\n';
		this.document.getElementById('modeofpayment_error').style.display="";
	}*/
	/*if(bank_account_no.value == ''){
		err_msg+= 'Missing Bank Account No\n';
		this.document.getElementById('bank_account_no_error').style.display="";
	}
	if(bank_account_title.value == ''){
		err_msg+= 'Missing Bank Account Title\n';
		this.document.getElementById('bank_account_title_error').style.display="";
	}
	if(bank_branch_name.value == 0){
		err_msg+= 'Missing Bank Branch Name\n';
		this.document.getElementById('bank_branch_name_error').style.display="";
	}
	if(bank_branch_code.value == 0){
		err_msg+= 'Missing Bank Branch Code\n';
		this.document.getElementById('bank_branch_code_error').style.display="";
	}*/
	//alert('Hi');
	if(err_msg == ''){
		//return true;
		return get_preview();
	}
	else{
		return false;
	}
}
</script>
<?php
 
if($_SESSION[$db_prefix.'_UserPinVerification']<> true){
		$_SESSION[$db_prefix.'_BM'] = "Please first verify the Pin";
		$_SESSION[$db_prefix.'_Page'] = $page_name."?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no);
		header ("Location: pin_generation.php?customer_id=".$tools_admin->encryptId($customer_id)."&account_no=".$tools_admin->encryptId($account_no)."&action=pver");
		exit();
}
else{
		$user_pin->update_user_status($unique_id,$caller_id,300,3,$_SESSION[$db_prefix.'_UserId']);  // Pin verfication to Talking Again
}

?>
<?php

$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
		$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
		
		$method = 'GetProfile';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		$rs = $soap_client->call_soap_method($method,$params); //print_r($params); exit;
		
		$ID = $rs[0]["CustomerId"]; 
		$Name = $rs[0]["Name"]; $_SESSION[$db_prefix.'_CustomerName'] = $rs[0]["Name"];
		$Gender = $rs[0]["Gender"];
		$CNIC = $rs[0]["NICNo"];
		$CNICExpiryDate = date( 'y-m-d', strtotime($rs[0]["CNICExpiry"]));
		$FatherName = $rs[0]["FHName"];
		$MaritalStatuss = $rs[0]["MaritalName"];
		$DOB = date( 'y-m-d', strtotime($rs[0]["DateOfBirth"])); 
		$Occupation =  $rs[0]["OccupationName"]; 
		$AccountNumber =  $rs[0]["AccountNumber"];
		$TitleCode =  $rs[0]["TitleCode"];			  
		$Email = $rs[0]["Email"];
		$CityNamee = $rs[0]["CityName"];
		$CountryName = $rs[0]["CountryName"];
		$Address = $rs[0]["Address"];			  
		$RegistrationDate = date( 'y-m-d', strtotime($rs[0]["RegistrationDate"]));
		$StatementName = $rs[0]["StatementName"];
		$StatementDays = $rs[0]["StatementDays"];
		$IsZakatDeducted = $rs[0]["IsZakatDeducted"];
		$IsJumboCertificate = $rs[0]["IsJumboCertificate"];
		$IsCertificate = $rs[0]["IsCertificate"];
		$IsResident = $rs[0]["IsResident"];
		$IsBonus = $rs[0]["IsBonus"];
		$IsDividend = $rs[0]["IsDividend"];
		$IsMuslim = $rs[0]["IsMuslim"];
		$SigningDetail = $rs[0]["SigningDetail"]; $_SESSION[$db_prefix.'_SigningDetail'] = $rs[0]["SigningDetail"];
		$IsFlexibleReturn = $rs[0]["IsFlexibleReturn"];
		$IsAllowSMS = $rs[0]["IsAllowSMS"];
		$IsHoldMail = $rs[0]["IsHoldMail"];
		$isDuplicateNIC = $rs[0]["isDuplicateNIC"];
		$isDeath = $rs[0]["isDeath"];
		$CategoryType = $rs[0]["CategoryType"];  $_SESSION[$db_prefix.'_CategoryType'] = $rs[0]["CategoryType"];
		$EducationName = $rs[0]["EducationName"];
		$NationalityName = $rs[0]["NationalityName"];
		$SubCat = $rs[0]["SubCat"];
		$CurrencyName = $rs[0]["CurrencyName"];
		$IssuePlace = $rs[0]["IssuePlace"];
		$Validity= $rs[0]["Validity"];
		$GCNICExpiry= date( 'y-m-d', strtotime($rs[0]["GCNICExpiry"]));
		$isHoldEmail= $rs[0]["isHoldEmail"];
		$isCGTExempted= $rs[0]["isCGTExempted"];
		$SubAgentName= $rs[0]["SubAgentName"];
		$SubAgentEmail= $rs[0]["SubAgentEmail"];
		$CompanyExecutive= $rs[0]["CompanyExecutive"];
		$AccountType= $rs[0]["AccountType"];
		$IsZakatDeducted= $rs[0]["IsZakatDeducted"];
		$Gcnic= $rs[0]["Gcnic"];
		$GCNICExpiry= date( 'y-m-d', strtotime($rs[0]["GCNICExpiry"]));
		$OperatingTypeCode1= $rs[0]["OperatingTypeCode1"]; $_SESSION[$db_prefix.'_OperatingTypeCode'] = $rs[0]["OperatingTypeCode1"];
			
			
		$method = 'GetContactDetail';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $AccountNumber,'CustomerId' => $ID, 'CallerId'=> $caller_id );
		$rs2 = $soap_client->call_soap_method($method,$params);	
		
		//echo "Caller ID --> ".$caller_id;
		//print_r($rs2); 
		
		$tcustomer_id			= $rs2[0]["CustomerId"]; //AccountNo
		$taccount_no			= $rs2[0]["AccountNo"];
		$isregistered_restel  	= $rs2[0]["isregisteredResTel"];
		$isregistered_offtel	= $rs2[0]["isregisteredOffTel"];	
		$isregistered_mobiletrans = $rs2[0]["isregisteredMobileTrans"];
		$residencee				= str_replace("-", "", $rs2[0]["Residence"]);
		$officee				= str_replace("-","",$rs2[0]["Office"]);		
		$mobilee					= str_replace("-","",$rs2[0]["Mobile"]);
		
















	$payment 								= $_REQUEST['payment'];
	$MailingAddress 						= $_REQUEST['MailingAddress'];
	$CityName 								= $_REQUEST['CityName'];
	$email 									= $_REQUEST['email'];
	$mobile 								= $_REQUEST['mobile'];
	$residence 								= $_REQUEST['residence'];
	$office 								= $_REQUEST['office'];
	$humail 								= $_REQUEST['humail'];
	$husms 									= $_REQUEST['husms'];
	$huemail 								= $_REQUEST['huemail'];
	$MaritalStatus 							= $_REQUEST['MaritalStatus'];
	

	$payment_error 						= "display:none;";
	$MailingAddress_error 				= "display:none;";
	$CityName_error 					= "display:none;";
	$email_error 						= "display:none;";
	$mobile_error 						= "display:none;";
	$residence_error 					= "display:none;";
	$office_error 						= "display:none;";
	$humail_error 						= "display:none;";
	$husms_error 						= "display:none;";
	$huemail_error 						= "display:none;";
	$MaritalStatus_error 				= "display:none;";



	$account_no 				= $_REQUEST['account_no'];
	$customer_id 				= $_REQUEST['customer_id'];

	$unique_id2		= $_SESSION['unique_id'];
	$caller_id2		= $_SESSION['caller_id'];
	//	echo $unique_id; echo $caller_id;echo $account_no.$customer_id; exit;

if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{
//echo "yahya"; exit;
        $flag = true;
         if($_REQUEST['payment'] == ''){
                $payment_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	
	if($_REQUEST['MailingAddress'] == ''){
                $MailingAddress_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	if($_REQUEST['CityName'] == ''){
                $CityName_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	if($_REQUEST['email'] == ''){
                $email_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	if($_REQUEST['mobile'] == ''){
                $mobile_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	if($_REQUEST['residence'] == ''){
                $residence_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	if($_REQUEST['office'] == ''){
                $office_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	if($_REQUEST['humail'] == ''){
                $humail_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	if($_REQUEST['husms'] == ''){
                $husms_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	if($_REQUEST['huemail'] == ''){
                $huemail_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	
	if($_REQUEST['MaritalStatus'] == ''){
                $MaritalStatus_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	
	

   if($flag == true)
        {
	if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"]))
		{
		
	echo $payment 	.							
	$MailingAddress .						
	$CityName 	.						
	$email 	.								
	$mobile .							
	$residence .							
	$office .								
	$humail .								
	$husms 	.								
	$huemail .								
	$MaritalStatus 	;exit;		

$admin->update_profile_customeer($unique_id,$caller_id,
$customer_id,$account_no,$payment,$MailingAddress,$CityName,$email,$mobile,$residence,$office,$humail,$husms,$huemail,$MaritalStatus,$_SESSION[$db_prefix.'_UserId']);
               	
				header ("Location: index.php");
				exit();
			
		}	
	
	

	}	
}
		
?>

      <div class="box">      
      		<h4 class="white">Profile Update Settings</h4>
        <div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
		<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $tools_admin->encryptId($admin_id); ?>">
      			<h3>Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
						
						 <li  class="even"><label class="field-title">Payment/ Profit Frequency <em>*</em>:</label> <label><input name="payment" id="payment" class="txtbox-short" value="<?php echo $payment; ?>"><span id="payment_error" class="form-error-inline" title = "Please Enter Payment/ Profit Frequency" style="<?php echo($payment_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
						 <li ><label class="field-title">Mailing Address <em>*</em>:</label> <label><input name="MailingAddress" id="MailingAddress" class="txtbox-short" value="<?php echo $Address; ?>"><span id="MailingAddress_error" class="form-error-inline" title = "Please Enter Mailing Address" style="<?php echo($MailingAddress_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						
						 <li class="even"><label class="field-title">City Name <em>*</em>:</label> <label><input name="CityName" id="CityName" class="txtbox-short" value="<?php echo $CityNamee; ?>"><span id="CityName_error" class="form-error-inline" title = "Please Enter City Name" style="<?php echo($CityName_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
						 
				
	

						<li ><label class="field-title">Email <em>*</em>:</label> <label><input name="email" id="email" class="txtbox-short" value="<?php echo $Email; ?>"><span id="email_error" class="form-error-inline" title = "Please Enter Email" style="<?php echo($email_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	 
	 
	 <li class="even" ><label class="field-title">Contact details (Mobile) <em>*</em>:</label> <label><input name="mobile" id="mobile" class="txtbox-short" value="<?php echo $mobilee; ?>"><span id="mobile_error" class="form-error-inline" title = "Please Enter Mobile Number" style="<?php echo($mobile_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	 
	  <li ><label class="field-title">Contact details (Residence) <em>*</em>:</label> <label><input name="residence" id="residence" class="txtbox-short" value="<?php echo $residencee; ?>"><span id="residence_error" class="form-error-inline" title = "Please Enter Residence Number" style="<?php echo($residence_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	  
	  
	   <li  class="even"><label class="field-title">Contact details (Office) <em>*</em>:</label> <label><input name="office" id="office" class="txtbox-short" value="<?php echo $officee; ?>"><span id="office_error" class="form-error-inline" title = "Please Enter Office Number" style="<?php echo($office_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	 
	 
	 
	 
	 
	 					<li ><label class="field-title">Hold/Un-hold Mail Instructions <em>*</em>:</label> <label><input name="humail" id="humail" class="txtbox-short" value="<?php if($IsHoldMail == "false")
														{
															echo "NO";
														}
														else{
															echo "YES";
														} ?>"><span id="humail_error" class="form-error-inline" title = "Please Enter Hold/Un-hold Mail Instructions" style="<?php echo($humail_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	 
	 <li class="even" ><label class="field-title">Hold/Un-hold SMSInstructions <em>*</em>:</label> <label><input name="husms" id="husms" class="txtbox-short" value="<?php if($IsAllowSMS == "false")
														{
															echo "NO";
														}
														else{
															echo "YES";
														}; ?>"><span id="husms_error" class="form-error-inline" title = "Please Enter Hold/Un-hold SMSInstructions" style="<?php echo($husms_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	 
	 <li ><label class="field-title">Hold/Un-hold Email Instructions <em>*</em>:</label> <label><input name="huemail" id="huemail" class="txtbox-short" value="<?php if($isHoldEmail == "false")
														{
															echo "NO";
														}
														else{
															echo "YES";
														} ?>"><span id="huemail_error" class="form-error-inline" title = "Please Enter Hold/Un-hold Email Instructions" style="<?php echo($huemail_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	 
	 
	 					
	 
	 
						<li  class="even"><label class="field-title">Marital Status <em>*</em>:</label> <label><input name="MaritalStatus" id="MaritalStatus" class="txtbox-short" value="<?php echo $MaritalStatuss; ?>"><span id="MaritalStatus_error" class="form-error-inline" title = "Please Enter Marital Status" style="<?php echo($MaritalStatus_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
												
                      
						
					  
					
                       
						
						
					
					     
					
						
                       
					     


					     
      					</ol>
      				</fieldset> 
      				<p class="align-right">
					<?php   //if(isset($admin_id) && !empty($admin_id)){?>
						<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');" ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php   // }
                			//else{
                			?>
                    			<!--	<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Add</span></a>
						<input type="hidden" value="CREATE NEW ADMIN >>" id="add" name="add" />-->
               				<?php   // }?>						
					<!--<input type="image" src="images/bt-send-form.gif" />-->
				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?> 


