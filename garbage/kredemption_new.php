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
	
	$customer_id = $_REQUEST['customer_id'];
	$account_no	 = $_REQUEST['account_no'];
	
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

function get_preview()
{
	var st = this.document.xForm.solution_type.selectedIndex;
	var tou = this.document.xForm._types_of_units.selectedIndex;
	var mop = this.document.xForm.modeofpayment.selectedIndex;

	var account_no 			= this.document.getElementById('account_no').value;
	var customer_id 		= this.document.getElementById('customer_id').value;
	var solution_type 		= this.document.xForm.solution_type.options[st].text;
	var types_of_units 		= this.document.xForm._types_of_units.options[tou].text;
	var Unit			 	= this.document.getElementById('unit_value').value;
	var modeofpayment		= this.document.xForm.modeofpayment.options[mop].text;
	var bank_account_no 	= this.document.getElementById('bank_account_no').value;
	var bank_account_title	= this.document.getElementById('bank_account_title').value;
	var bank_branch_name 	= this.document.getElementById('bank_branch_name').value;
	var bank_branch_code 	= this.document.getElementById('bank_branch_code').value;
	var bank_name 			= this.document.getElementById('bank_name').value;
	var unit_rdio			= this.document.getElementById('unit').name;
	var city_name			= this.document.getElementById('city_name').value;
	var type1				= this.document.getElementById('type1').value;

var unit_types = document.forms['xForm'].elements['unit'];
  unit_rdio = getCheckedValue(unit_types);
	
		solution_type = solution_type.replace(/"/g, "'");
		types_of_units = types_of_units.replace(/"/g, "'");
	
	var url = "redemption_preview.php?customer_id="+customer_id +"&account_no="+account_no+"&solution_type="+solution_type+"&types_of_units="+types_of_units+"&Unit="+Unit+"&modeofpayment="+modeofpayment+"&bank_account_no="+bank_account_no+"&bank_account_title="+bank_account_title+"&bank_branch_name="+bank_branch_name+"&bank_branch_code="+bank_branch_code+"&bank_name="+bank_name+"&unit_rdio="+unit_rdio+"&city_name="+city_name+"&type1="+type1 ;
	//alert(url);
	
	//url = escape("conversion_preview.php?customer_id="+customer_id +"&account_no="+account_no+"&transaction_nature="+transaction_nature+"&from_fund="+from_fund+"&from_fund_types_of_units="+from_unit_type+"&to_fund="+to_fund+"&to_fund_types_of_units="+to_unit_type+"&unit_value="+units+"&unit="+unit_rdio);
	
	//alert(url);
	popitup(url);
	return false;


}

function popitup(url) {
	newwindow=window.open(url,'name','scrollbars=1,height=900,width=550');
	if (window.focus) {newwindow.focus()}
	return false;
}

function getCheckedValue(radioObj) {
	if(!radioObj)
		return "";
	var radioLength = radioObj.length;
	if(radioLength == undefined)
		if(radioObj.checked)
			return radioObj.value;
		else
			return "";
	for(var i = 0; i < radioLength; i++) {
		if(radioObj[i].checked) {
			return radioObj[i].value;
		}
	}
	return "";
}

	function get_validate(value)
{ 

	//alert("get_validate");
 var units = document.forms['xForm'].elements['unit'];
 var unit_type = getCheckedValue(units);
 
var  unit1 = this.document.getElementById('unit_lbl').innerHTML;
var  amount = this.document.getElementById('amount_lbl').innerHTML;
//value = value+'.0000';

value = value.replace(/^\s+|\s+$/g, '') ;
unit1 = unit1.replace(/^\s+|\s+$/g, '') ;
amount = amount.replace(/^\s+|\s+$/g, '') ;

value = parseFloat(value);
unit1 = parseFloat(unit1);
amount = parseFloat(amount); 
// alert(unit_type);
		if(!unit_type){
			return "false";
		}else{
		//alert("Unit Type => "+unit_type+" Value => "+value+" amount => "+amount+" unit => "+unit1);
		//floatvar = parseFloat(value);
		//alert(floatvar);

		 	if(unit_type == "percentage")
			{
		//		percentage = this.document.getElementById('percentage_lbl').value;
				if(value > 100)
				{
					alert("Percentage limit exceded");
					this.document.getElementById('unit_value').value = '';
					return false;
				}
				
			}
			else if(unit_type == "amount")
			{
				
				//alert ("Unit type is = "+unit_type+" and value is = "+value+" and unit1 = "+amount);
				if(value > amount && value <= 500)
//				if(value > amount)
				{
					alert("Amount limit exceded");
					this.document.getElementById('unit_value').value = '';
					return false;
				}
			}
			else if(unit_type == "unit")
			{
				
				//alert ("Unit type is = "+unit_type+" and value is = "+value+" and unit1 = "+unit1.trim());

				if(value > unit1)
				{
					alert("Unit limit exceded");
					this.document.getElementById('unit_value').value = '';
					return false;
				}
			}
			else 
			{
				alert("Please Select Amount / Value Type");
				return false;
			}
			
			
		}

	/*var selection = this.document.xForm.unit;
	
	for (i=0; i<selection.length; i++)
	{
  	if (selection[i].checked == true)
  	//alert(selection[i].value);
		unit_type = selection[i].value;
	}


	//unit_type = this.document.getElementById('unit').value;
	//alert ("Unit type is = "+unit_type+" and value is = "+value);
	if(unit_type == "percentage")
	{
//		percentage = this.document.getElementById('percentage_lbl').value;
		if(value > 100){alert("limit exceded");}
	}
	else if(unit_type == "amount")
	{
		amount = this.document.getElementById('amount_lbl').innerHTML;
		//alert ("Unit type is = "+unit_type+" and value is = "+value+" and unit1 = "+amount);
		if(value > amount){alert("limit exceded");}
	}
	else if(unit_type == "unit")
	{
		unit1 = this.document.getElementById('unit_lbl').innerHTML;
		//alert ("Unit type is = "+unit_type+" and value is = "+value+" and unit1 = "+unit1.trim());
		if(value > unit1.trim()){alert("limit exceded");}
	}
	else 
	{
		alert("Please Select Amount / Value Type");
	}*/
}


	function get_mode_of_payment(value)
	{
	//	alert(value);
		if(value == 3)
		{
		//city_name_div
			this.document.getElementById('bank_detail_div').style.display="";
			this.document.getElementById('city_name_div').style.display="none";
		}
		else
		{
			this.document.getElementById('bank_detail_div').style.display="none";
			this.document.getElementById('city_name_div').style.display="";
		}
	}
	function bank_info(value)
	{
		//alert(value);
		//var bank_id = document.getElementById("bank").value;
		//alert(bank_id);
		//alert(document.getElementById("BranchName_"+value).innerHTML) ;
		document.getElementById("bank_branch_name").value = document.getElementById("BranchName_"+value).innerHTML;
		document.getElementById("bank_name").value = document.getElementById("BankName_"+value).innerHTML;
		document.getElementById("bank_account_no").value = document.getElementById("BankAccountNo_"+value).innerHTML;
		document.getElementById("bank_account_title").value = document.getElementById("BankAccountTitle_"+value).innerHTML; 
		document.getElementById("bank_branch_code").value = document.getElementById("BranchCode_"+value).innerHTML;
		
		//alert(document.getElementById("bank_branch_name").value);
	}
	
	function get_type (value)
	{
		if(value == "percentage")
		{
		//city_name_div
			this.document.getElementById('unit_lbl').style.display="none";
			this.document.getElementById('amount_lbl').style.display="none";
			this.document.getElementById('percentage_lbl').style.display="";
			this.document.getElementById('percentage_lbl').innerHTML="%";
			this.document.getElementById('unit_value').value = "";
//			this.document.getElementById('unit_value').value = "%";
			
		}
		else if(value == "amount")
		{
			this.document.getElementById('amount_lbl').style.display="";
			this.document.getElementById('unit_lbl').style.display="none";
			this.document.getElementById('percentage_lbl').style.display="none";
			this.document.getElementById('unit_value').value = "";
		}
		else if(value == "unit")
		{
			this.document.getElementById('unit_value').value = "";
			this.document.getElementById('unit_lbl').style.display="";
			this.document.getElementById('amount_lbl').style.display="none";
			this.document.getElementById('percentage_lbl').style.display="none";
		}
		
		/*if(value == "percentage")
		{
		//city_name_div
			this.document.getElementById('unit_value').value = "%";
			
		}
		else if(value == "amount")
		{
			this.document.getElementById('unit_value').value = "";
		}
		else if(value == "unit")
		{
			this.document.getElementById('unit_value').value = "";
		}*/
	}

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
		var url="ajax_call.php?id="+rnd+"&param_1=GBAL&param_2="+param3 +"&param_3="+index+"&param_4="+account_no+"&param_5="+customer_id;
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
/*	alert('Hi');
	return false;
*/

	
	var account_no 			= this.document.getElementById('account_no');
	var customer_id 		= this.document.getElementById('customer_id');
	var solution_type 		= this.document.getElementById('solution_type');//
	var Unit			 	= this.document.getElementById('unit_value');
	var modeofpayment		= this.document.getElementById('modeofpayment');
	//var bank_account_no 	= this.document.getElementById('bank_account_no');
/*	var bank_account_title	= this.document.getElementById('bank_account_title');
	var bank_branch_name 	= this.document.getElementById('bank_branch_name');
	var bank_branch_code 	= this.document.getElementById('bank_branch_code');
	var bank_name 			= this.document.getElementById('$bank_name');*/
	var flag = true;
	var err_msg = '';
	
	
	
	if(solution_type  == null){ 
	this.document.getElementById('solution_type_error').style.display=""; 
	return false;
	}
	 if(modeofpayment  == null){ 
	this.document.getElementById('bank_error').style.display=""; 
	return false;
	}
	
	this.document.getElementById('solution_type_error').style.display="none";
	this.document.getElementById('bank_error').style.display="none";  
	this.document.getElementById('unit_error').style.display="none"; 
	this.document.getElementById('unit_error').style.display="none"; 
	
	if(solution_type.value  == 0)
	{
	 //alert("HII"); 
	 this.document.getElementById('solution_type_error').style.display="";
	 return false;
	 }
	 
	
	//unit_error
	var units = document.forms['xForm'].elements['unit'];
		var unit_type = getCheckedValue(units);
		
		if(!unit_type){
			this.document.getElementById('unit_error').style.display=""; 
			return false;
		}
	
	if(modeofpayment.value  == 3)
	{
		var units = document.forms['xForm'].elements['bank'];
		var unit_type = getCheckedValue(units);
		
		if(!unit_type){
			this.document.getElementById('bank_error').style.display=""; 
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
		

	$admin_id 					= $tools_admin->decryptId($_REQUEST['admin_id']);
	$account_no 				= $_REQUEST['account_no'];
	$customer_id 				= $_REQUEST['customer_id'];
	$solution_type 				= $_REQUEST['solution_type'];
	$types_of_units 			= $_REQUEST['_types_of_units'];
	$unit2 				  		= $_REQUEST['unit_value']; 
	$unit_rdio			  		= $_REQUEST['unit'];
	$modeofpayment 	  			= $_REQUEST['modeofpayment']; 
	$account_type 				= $_REQUEST['account_type'];
	$bank_account_no 			= $_REQUEST['bank_account_no'];
	$bank_account_title 		= $_REQUEST['bank_account_title']; 
	$bank_branch_name 	  		= $_REQUEST['bank_branch_name']; 
	$bank_branch_code 			= $_REQUEST['bank_branch_code'];
	$bank_name 	  				= $_REQUEST['bank_name'];
	$city_name					= $_REQUEST['city_name'];
	$type1						= $_REQUEST['type1'];
	$unit_error					= $_REQUEST['unit_error'];
	 

	$bank_name_error 			= "display:none;";
	$admin_id_error 			= "display:none;";
	$account_no_error 			= "display:none;";
	$customer_id_error 			= "display:none;";
	$solution_type_error 		= "display:none;";
	$types_of_units_error 		= "display:none;";
	$unit_value_error 			= "display:none;";
	$modeofpayment_error 		= "display:none;";
	$account_type_error 		= "display:none;";
	$bank_account_no_error 		= "display:none;";
	$bank_account_title_error 	= "display:none;";
	$bank_branch_name_error 	= "display:none;";
	$bank_branch_code_error 	= "display:none;";
	$unit_error				 	= "display:none;";
		
		$unique_id2		= $_SESSION['unique_id'];
		$caller_id2		= $_SESSION['caller_id'];
		//echo $unique_id; echo $caller_id; exit;
if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{

	$flag = true;
	 if($_REQUEST['account_no'] == ''){
			$account_no_error = "display:inline;";
			$flag = false;
	 }
	if($_REQUEST['customer_id'] == ''){
        	        $customer_id_error = "display:inline;";
	                $flag = false;
        	 }
	if($_REQUEST['solution_type'] == ''){
        	        $solution_type_error = "display:inline;";
	                $flag = false;
        	 }
	if($_REQUEST['_types_of_units'] == ''){
	                $types_of_units_error = "display:inline;";
                	$flag = false;
        	 }
	if($_REQUEST['unit_value'] == ''){
	                $unit_value_error = "display:inline;";
                	$flag = false;
        	 }
	if($_REQUEST['modeofpayment'] == ''){
                	$modeofpayment_error = "display:inline;";
        	        $flag = false;
	         }
	/*if($_REQUEST['account_type'] == ''){
					$account_type_error = "display:inline;";
					$flag = false;
             }*/
	/*if($_REQUEST['bank_account_no'] == ''){
        	        $bank_account_no_error = "display:inline;";
	                $flag = false;
        	 }
	if($_REQUEST['bank_account_title'] == ''){
	                $bank_account_title_error = "display:inline;";
                	$flag = false;
        	 }
	if($_REQUEST['bank_branch_name'] == ''){
	                $bank_branch_name_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['bank_name'] == ''){
	                $bank_name_error = "display:inline;";//$tools->isEmpty('Caller ID');
                	$flag = false;
        	 }
	if($_REQUEST['bank_branch_code'] == ''){
                	$bank_branch_code_error = "display:inline;";//$tools->isEmpty('Caller ID');
        	        $flag = false;
	         }*/

	if($flag == true) {

		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))	{		
		
		$amount = $unit2;
		
	/*	if($unit_rdio == "unit")
		{$unit = $unit2;}
		else if ($unit_rdio == "amount")
		{$amount = $unit2;}
		else if($unit_rdio == "percentage")
		{$percentage = $unit2;}
		else{}*/
		if($unit_rdio == "unit")
		{$percentage = 1;}
		else if ($unit_rdio == "amount")
		{$percentage = 2;}
		else if($unit_rdio == "percentage")
		{$percentage = 3;}
		else{}

			
			if($unit 		== ''){ $unit = 0;}
			if($amount 		== ''){$amount = 0;}
			if($percentage 	== ''){ $percentage = 0;}
			
			if($modeofpayment == '1')
			{
				$modeofpayment = 'Cheque';
			}
			if($modeofpayment == '2')
			{
				$modeofpayment = 'Pay order';
			}
			if($modeofpayment == '3')
			{
				$modeofpayment = 'Online';
			}
			

			$method = 'SetRedemptionTransaction';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'FundCode' => $solution_type, 'TransType'=>'RT', 'InvSolution'=>$solution_type,'UnitType'=>$types_of_units,'Unit'=>$unit,'Amount'=>$amount,'Percentage'=>$percentage,'ModeofPay'=>$modeofpayment,'CityName'=> $city_name, 'Type1' => $type1,'BankAccNo'=>$bank_account_no,'AccTitle'=>$bank_account_title,'BranchName'=>$bank_branch_name,'BranchCode'=>$bank_branch_code,'AccountNo'=>$account_no,'CustomerId'=>$customer_id,'BankName'=>$bank_name);
			

			$trans_id = $sOap_client->call_soap_method_2($method,$params);
			
			if($trans_id < 0)
			{
				$_SESSION[$db_prefix.'_RM'] = "Set Redemption Fail. Error: ['".$trans_id."']";
			}
			else{
					$rsAdmUser = $transactions->set_redemption($account_no, $customer_id, $solution_type, $types_of_units, $unit, $amount, $percentage, $modeofpayment, $city_name, $account_type, $bank_account_no, $bank_account_title, $bank_name, $bank_branch_name, $bank_branch_code, $trans_id, $type1, $unique_id2, $caller_id2);		
						
					$_SESSION[$db_prefix.'_GM'] = "Set Redemption successfully. Having Transaction ID ['".$trans_id."']";
			}
//					header ("Location: customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no);
					header ("Location: customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile");
					exit();
		}	
	}	
}

?>

      	<div class="box">      
      		<h4 class="white"><?php echo $page_menu_title ;?></h4>
        <div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return redemption_validate(this);">

		<input type="hidden" id="account_no" name="account_no" value="<?php echo $account_no; ?>">
		<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
<li class="even">
                            <label class="field-title">Account No <em>*</em>:</label>
                            <label>
          <input name="account_no" id="account_no" class="txtbox-short" value="<?php echo $account_no; ?>" disabled="disabled"></label>
          <span id="account_no_error" class="form-error-inline" title = "Please Insert Account No" style="<?php echo($account_no_error); ?>"></span>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Customer ID <em>*</em>:</label>
                            <label>
          <input name="customer_id" id="customer_id" class="txtbox-short" value="<?php echo $customer_id; ?>" disabled="disabled"></label>
          <span id="customer_id_error" class="form-error-inline" title = "Pleaes Insert Customer ID"style="<?php echo($customer_id_error); ?>"></span>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title">Solution Type <em>*</em>:</label>
                            <label></label>
							<table  class="table-short2" >
										  <thead>											
										</thead>	
									<tbody>			
										<tr><tr></tr>
											<td class="col-first"><input type="radio" name="type1" id="type1" value="Fund" onchange="javascript:get_investment_solution(this.value)"  />Fund</td>
											<td class="col-first"><input type="radio" name="type1" id="type1" value="Plan" onchange="javascript:get_investment_solution(this.value)"  />Plan</td>
											<td class="col-first"></td>
										</tr>
										</tbody>
									</table><div id="solution_type_div">
							<?php 
								/*		$method = 'GetInvestmentSolution';
										$params = array('AccessKey' => $access_key,'Channel' => $channel);
										echo $sOap_client->get_combo($method, $params, $combo_id="solution_type", $value_feild="Code", $text_feild="Name", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="javascript:get_types_of_units(this.selectedIndex)", $title="")
										//echo $sOap_client->getcombo("admin_groups","group_id","id","group_name",$group_id,false,"form-select","","Group",""); 
								*/
							?>
							</div>
       
          <span id="solution_type_error" class="form-error-inline" title = "Please Select Solution Type" style="<?php echo($solution_type_error); ?>"></span>
                            <span  class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Types of Units <em>*</em>:</label>
                            <label id="types_of_units_label">
          					</label>
          <span id="types_of_units_error" class="form-error-inline" title = "Please Select Type of Units" style="<?php echo($types_of_units_error); ?>"></span>
                            <span  class="clearFix">&nbsp;</span></li>

<li class="even">
								<table  class="table-short2" >
										  <thead>
											
										</thead>	
									<tbody>			
										<tr>
											<td class="col-first"><input type="radio" name="unit" id="unit" value="unit" onchange="javascript:get_type(this.value)"  />Unit</td>
											<td class="col-first"><input type="radio" name="unit" id="unit" value="amount" onchange="javascript:get_type(this.value)"  />Amount</td>
											<td class="col-first"><input type="radio" name="unit" id="unit" value="percentage" onchange="javascript:get_type(this.value)"  />Percentage</td>
										</tr>
										</tbody>
									</table>
									<span id="unit_error" class="form-error-inline" title = "Please Insert Unit" style="<?php echo($unit_error); ?>"></span>
								<span class="clearFix">&nbsp;</span>
							</li>
							
<li class="even">
								<label class="field-title">Amount / Value <em>*</em>:</label>
								<label >
								 <input name="unit_value" id="unit_value" class="txtbox-short" value="" onkeydown="return ( event.ctrlKey || event.altKey 
                    || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                    || (95<event.keyCode && event.keyCode<106)
                    || (event.keyCode==8) || (event.keyCode==9) 
                    || (event.keyCode>34 && event.keyCode<40) 
                    || (event.keyCode==46)
					|| (event.keyCode==110)
					|| (event.keyCode==190) )" onchange="javascript:get_validate(this.value)"/></label>&nbsp;&nbsp;<label class="field-title" id="unit_lbl" style="display:none; color:#FF0000"></label><label class="field-title" id="amount_lbl" style="display:none; color:#FF0000"></label><label class="field-title" id="percentage_lbl" style="display:none"></label>
								<span id="unit_value_error" class="form-error-inline" title = "Please Insert Unit" style="<?php echo($unit_value_error); ?>"></span>
								<span class="clearFix">&nbsp;</span></li>


							
<li >
                            <label class="field-title">Mode of Payment <em>*</em>:</label>
                            <label>
          					<select name="modeofpayment" id="modeofpayment" class="txtbox-short"  onchange="javascript:get_mode_of_payment(this.value)">
                              <option value="1">Cheque</option>
                              <option value="2">Pay order</option>
                              <option value="3">Online</option>
                            </select></label>
          <span id="modeofpayment_error" class="form-error-inline" title = "Please Select Mode of Payment"   style="<?php  echo($modeofpayment_error); ?>"></span>
                            <span  class="clearFix">&nbsp;</span></li>
							
							
							<?php
									$method = 'GetBankDetail';
									$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
									
									$rs2 = $sOap_client->call_soap_method($method,$params);	$count = 0; 
							?>
							<div id="city_name_div">
								<li class="even">
                            <label class="field-title"> City Name<em>*</em>:</label>
                            <label>
         					 <input name="city_name" id="city_name" class="txtbox-short" value="<?php echo $city_name_title; ?>">
          						<!--<span id="bank_account_title_error" class="form-error-inline" title = "Please Insert Bank Account Title" style="<?php //echo($bank_account_title_error); ?>"></span>-->
								</label>
                            <span class="clearFix">&nbsp;</span></li>
							</div>
							
						<div id="bank_detail_div" style="display:none" >
							<li class="even">
								<label class="field-title">Bank Details <em>*</em>:</label>
								<label>		<span id="account_type_error" class="form-error-inline" title="Please Select Account Type" style="<?php echo($account_type_error); ?>"></span>
								</label>
								<span  class="clearFix">&nbsp;</span>
								</li>
						
								<li>
								<table  class="table-short2" >
										  <thead>
											<td ></td>
											<td class="col-head" >Branch</td>
											<td class="col-head" >Bank</td>
											<td class="col-head" >Account No</td>
											<td class="col-head" >Title</td>
											<td class="col-head" >Code</td>
										</thead>
								<?php $count = 0; 
									while($count != count($rs2)){ ?>	
									<tbody>			
										<tr>
											<td class="col-first" ><input type="radio" name="bank" id="bank" value="<?php echo $count;?>" onchange="javascript:bank_info(this.value)"  /></td>
											<td class="col-first"  id="BranchName_<?php echo $count;?>" name="BranchName_<?php echo $count;?>"><?php  echo $rs2[$count]["BranchName"]; ?></td>
											<td class="col-first" id="BankName_<?php echo $count;?>" name="BankName_<?php echo $count;?>"><?php  echo $rs2[$count]["BankName"]; ?></td>
											<td class="col-first" id="BankAccountNo_<?php echo $count;?>" name="BankAccountNo_<?php echo $count;?>"><?php  echo $rs2[$count]["BankAccountNo"]; ?></td>
											<td class="col-first" id="BankAccountTitle_<?php echo $count;?>" name="BankAccountTitle_<?php echo $count;?>"><?php  echo $rs2[$count]["AccountTitle"]; ?></td>
											<td class="col-first" id="BranchCode_<?php echo $count;?>" name="BranchCode_<?php echo $count;?>"><?php  echo $rs2[$count]["BranchCode"]; ?></td>
										</tr>
										</tbody>
                         		<?php $count++; } ?>
									</table>
									
							<span id="bank_error" class="form-error-inline" title = "Please Select BANK"   style="<?php  echo($bank_error); ?>"></span>
                            <span  class="clearFix">&nbsp;</span>
							</li>
							
													
							<li >
                            <label class="field-title"> Bank Account No<em>*</em>:</label>
                            <label>
          <input name="bank_account_no" id="bank_account_no" class="txtbox-short" value="<?php echo $bank_account_no; ?>" readonly="readonly">
          <span id="bank_account_no_error" class="form-error-inline" title = "Please Insert Bank Account No" style="<?php echo($bank_account_no_error); ?>"></span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title"> Bank Account Title<em>*</em>:</label>
                            <label>
          <input name="bank_account_title" id="bank_account_title" class="txtbox-short" value="<?php echo $bank_account_title; ?>" readonly="readonly" />
          <span id="bank_account_title_error" class="form-error-inline" title = "Please Insert Bank Account Title" style="<?php echo($bank_account_title_error); ?>"></span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title"> Bank Branch Name<em>*</em>:</label>
                            <label>
          <input name="bank_branch_name" id="bank_branch_name" class="txtbox-short" value="<?php echo $bank_branch_name; ?>" readonly="readonly" />
          <span id="bank_branch_name_error" class="form-error-inline" title = "Please Insert Bank Branch Name" style="<?php echo($bank_branch_name_error); ?>"></span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li class="even">
                            <label class="field-title"> Bank Name<em>*</em>:</label>
                            <label>
          <input name="bank_name" id="bank_name" class="txtbox-short" value="<?php echo $bank_branch_name; ?>" readonly="readonly" />
          <span id="bank_name_error" class="form-error-inline" title = "Please Insert Bank Name" style="<?php echo($bank_name_error); ?>"></span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title"> Bank Branch Code<em>*</em>:</label>
                            <label>
          <input name="bank_branch_code" id="bank_branch_code" class="txtbox-short" value="<?php echo $bank_branch_code; ?>" readonly="readonly">
          <span id="bank_branch_code_error" class="form-error-inline" title = "Please Insert Bank Branch Code" style="<?php echo($bank_branch_code_error); ?>"></span></label>
                            <span class="clearFix">&nbsp;</span></li>
      					
					</div>
						</ol>
      				</fieldset> 
      				<p class="align-right">
					<?php   if(isset($admin_id) && !empty($admin_id)){?>
						<a class="button" href="javascript:document.xForm.submit();"  ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<a class="button" href="" onclick="javascript:return redemption_validate();"><span>Preview</span></a>
									<input type="hidden" value="add" id="add" name="add" />
               				<?php    }?>					
					<!--<input type="image" src="images/bt-send-form.gif" />-->
				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div>
      	</div>
<?php include($site_root."includes/footer.php"); ?> 
