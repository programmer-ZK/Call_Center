<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "conversion_new.php";
	$page_title = "Add/Update Conversion";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Conversion";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
	$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
	
	include_once("classes/transactions.php");
	$transactions = new transactions();
	
	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
	
    include_once("classes/user_pin.php");
    $user_pin = new user_pin();	
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function get_preview()
{
//alert('waleed');exit;
	var tn = this.document.xForm.transaction_nature.selectedIndex;
	var ff = this.document.xForm.from_fund.selectedIndex;
	var fft = this.document.xForm.from_fund_types_of_units.selectedIndex;
	var tf = this.document.xForm.to_fund.selectedIndex;
	var tft = this.document.xForm.to_fund_types_of_units.selectedIndex;
	/*var selected_text = this.document.xForm.from_fund.options[ff].text;
	alert(selected_text);
*/
	var account_no 				= this.document.getElementById('account_no').value;
	var customer_id 			= this.document.getElementById('customer_id').value;
	var transaction_nature 		= this.document.xForm.transaction_nature.options[tn].text;
	var from_fund 				= this.document.xForm.from_fund.options[ff].text;
	var from_unit_type			= this.document.xForm.from_fund_types_of_units.options[fft].text;
	var to_fund			 		= this.document.xForm.to_fund.options[tf].text;
	var to_unit_type			= this.document.xForm.to_fund_types_of_units.options[tft].text;
	var units					= this.document.getElementById('unit_value').value;
	var unit_rdio				= this.document.getElementById('unit').name;
	
	
 var unit_types = document.forms['xForm'].elements['unit'];
  unit_rdio = getCheckedValue(unit_types);
	
		from_unit_type = from_unit_type.replace(/"/g, "'");
		to_unit_type = to_unit_type.replace(/"/g, "'");
	
	var url = "conversion_preview.php?customer_id="+customer_id +"&account_no="+account_no+"&transaction_nature="+transaction_nature+"&from_fund="+escape(from_fund)+"&from_fund_types_of_units="+from_unit_type+"&to_fund="+escape(to_fund)+"&to_fund_types_of_units="+to_unit_type+"&unit_value="+units+"&unit="+unit_rdio ;
	
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

function get_validate(value)
{ 
//alert("get_validate");
 var units = document.forms['xForm'].elements['unit'];
 var unit_type = getCheckedValue(units);
 
var  unit1 = this.document.getElementById('unit_lbl').innerHTML;
var  amount = this.document.getElementById('amount_lbl').innerHTML;
var  min_amount = '500';
var amount_zero = '0';
//value = value+'.0000';

value = value.replace(/^\s+|\s+$/g, '') ;
unit1 = unit1.replace(/^\s+|\s+$/g, '') ;
amount = amount.replace(/^\s+|\s+$/g, '') ;

value = parseFloat(value);
unit1 = parseFloat(unit1);
amount = parseFloat(amount); 
min_amount = parseFloat(min_amount); 
amount_zero = parseFloat(amount_zero);
// alert(unit_type);
		if(!unit_type){
			return "false";
		}else{
	//	alert("Unit Type => "+unit_type+" Value => "+value+" amount => "+amount+" unit => "+unit1);
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
				if(value <= amount_zero)
				{
					alert("Invalid Percentage");
					this.document.getElementById('unit_value').value = '';
					return false;
				}
				
			}
			else if(unit_type == "amount")
			{
				
				//alert ("Unit type is = "+unit_type+" and value is = "+value+" and unit1 = "+amount);
				if(value > amount)
				{
					alert("Amount limit exceded");
					this.document.getElementById('unit_value').value = '';
					return false;
				}
				if(value < min_amount)
				{
					alert("Minimum Amount limit is " + min_amount);
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
				if(value <= amount_zero)
				{
					alert("Invalid Unit");
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
 
	/*if(isNaN(value))
	{
		var selection = this.document.xForm.unit;
	
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
			if(value > 100){alert("limit exceded");
			return false;
			}
			
		}
		else if(unit_type == "amount")
		{
			amount = this.document.getElementById('amount_lbl').innerHTML;
			//alert ("Unit type is = "+unit_type+" and value is = "+value+" and unit1 = "+amount);
			if(value > amount){alert("limit exceded");
			return false;
			}
		}
		else if(unit_type == "unit")
		{
			unit1 = this.document.getElementById('unit_lbl').innerHTML;
			//alert ("Unit type is = "+unit_type+" and value is = "+value+" and unit1 = "+unit1.trim());
			if(value > unit1.trim()){alert("limit exceded");
			return false;
			}
		}
		else 
		{
			alert("Please Select Amount / Value Type");
			return false;
		}
	
	}
	else
	{
		//this.document.xForm.unit_value.focus()
		return false;
	}*/
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
			this.document.getElementById('unit_value').checked = true;
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
	}


function get_combo(index)
{
	//var combo_type  = this.document.getElementById('transaction_nature');
	var value = this.document.getElementById('transaction_nature').value;/*document.getElementsByTagName( "option" )[index].value;*/
/*	var text = this.document.getElementById('transaction_nature').text;*/
	var param1 = 'ISchemes';
	var param2 = '';
	var param3 = '';
	var param4 = '';
	//alert(value);
	if(value == 1)
	{
		param2 = 'Fund';
		param3 = 'Fund';
		get_from_combo(param2);
		get_to_combo(param3);
		//get_balance(param3);
		document.getElementById("amount_lbl").innerHTML = 0;
		document.getElementById("unit_lbl").innerHTML = 0;
		this.document.getElementById('from_fund_li').style.display="";
		this.document.getElementById('unit').style.display="";
		this.document.getElementById('to_fund_li').style.display="";
		
	}
	else if(value == 2)
	{
		param2 = 'Fund';
		param3 = 'Plan';
		get_from_combo(param2);
		get_to_combo(param3);
		//get_balance(param3);
			document.getElementById("amount_lbl").innerHTML = 0;
		document.getElementById("unit_lbl").innerHTML = 0;
		this.document.getElementById('from_fund_li').style.display="";
		this.document.getElementById('unit').style.display="none";
		this.document.getElementById('to_fund_li').style.display="none";
		
	}
	else if(value == 7)
	{	
		param2 = 'Fund';
		param3 = 'Pension Scheme';
		get_from_combo(param2);
		get_to_combo(param3);
		//get_balance(param3);
			document.getElementById("amount_lbl").innerHTML = 0;
		document.getElementById("unit_lbl").innerHTML = 0;
		this.document.getElementById('from_fund_li').style.display="";
		this.document.getElementById('unit').style.display="";
		this.document.getElementById('to_fund_li').style.display="";
	}
	else if(value == 3)
	{
		param2 = 'Plan';
		param3 = 'Plan';
		get_from_combo(param2);
		get_to_combo(param3);
		//get_balance(param3);
			document.getElementById("amount_lbl").innerHTML = 0;
		document.getElementById("unit_lbl").innerHTML = 0;
		this.document.getElementById('from_fund_li').style.display="none";
		this.document.getElementById('unit').style.display="none";
		this.document.getElementById('to_fund_li').style.display="none";
		//from_fund_li
	}
	else if(value == 5)
	{
		param2 = 'Plan';
		param3 = 'Fund';
		get_from_combo(param2);
		get_to_combo(param3);
		//get_balance(param3);
			document.getElementById("amount_lbl").innerHTML = 0;
		document.getElementById("unit_lbl").innerHTML = 0;
		this.document.getElementById('from_fund_li').style.display="none";
		this.document.getElementById('unit').style.display="";
		this.document.getElementById('to_fund_li').style.display="";
		//from_fund_li
	}			
	function get_from_combo(param2)
	{
			var account_no 			= this.document.getElementById('account_no').value;
			var customer_id 		= this.document.getElementById('customer_id').value;
		var rnd = Math.random();
	    var url="ajax_call.php?id="+rnd+"&param_1=GBDCONVERSION&param_2="+ param2 +"&param_3="+account_no+"&param_4="+customer_id+"&param_5="+param2+"&param_6=from_fund";
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
            xmlHttp.setRequestHeader
           ('Content-Type', 'application/x-www-form-urlencoded');
           xmlHttp.onreadystatechange = function() 
		   {
       			if (xmlHttp.readyState == 4) 
				{
					document.getElementById("from_fund_label").innerHTML = xmlHttp.responseText ;
        	       //updatepage(xmlHttp.responseText);
            	  //  alert(xmlHttp.responseText);
	            }
    		}
         xmlHttp.send(url);
	}
	function get_to_combo(param3)
	{
		var rnd = Math.random();
		var url="ajax_call.php?id="+rnd+"&param_1="+ param1 +"&param_2="+param3 +"&param_3=to_fund";
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
					document.getElementById("to_fund_label").innerHTML = xmlHttp.responseText ;
               		//updatepage(xmlHttp.responseText);
                	//alert(xmlHttp.responseText);
            }
         }
         xmlHttp.send(url);
	}
	
	
}
function get_types_of_units(param3,id,isType,index)
{
	//get_balance(param3);
	//alert(id);
	var from_fund 				= this.document.getElementById('from_fund');
	var to_fund			 		= this.document.getElementById('to_fund');
	if(from_fund.value  == to_fund.value)
	{
	 alert("Conversion in same account not allow"); 
	 this.document.getElementById('to_fund').value = 0;
	 //this.document.getElementById('from_fund_error').style.display="";
	 //return false;
	 }
	
//comment by waleed on 19 march	
	if(id == "from_fund" || id == "from_plan"){
		get_balance(index,isType);
	}


//comment end


	//var FundCode = document.getElementById(param3).value
	//var rnd = Math.random();
   // var url="ajax_call.php?id="+rnd+"&param_1=FundCode"+"&param_2="+FundCode;
	
	
	var FundCode  = param3.value; /*document.getElementsByTagName( "option" )[index].value;*/
	//alert(FundCode);
	var rnd = Math.random();
    var url="ajax_call.php?id="+rnd+"&param_1=FundCode"+"&param_2="+FundCode+"&param_4="+id;


    postRequest(url,id);
	
}
function postRequest(strURL,id)
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
               updatepage(xmlHttp.responseText,id);
                //alert(xmlHttp.responseText);
              }
           }
         xmlHttp.send(strURL);
}
function get_balance(index,param3)
	{
	
		var account_no 			= this.document.getElementById('account_no').value;
		var customer_id 		= this.document.getElementById('customer_id').value;
		var rnd = Math.random();
		var url="ajax_call.php?id="+rnd+"&param_1=GBAL&param_2="+param3 +"&param_3="+index+"&param_4="+account_no+"&param_5="+customer_id+"&param_6=CT";
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
					if(unit1 > 0){
					document.getElementById("unit_lbl").innerHTML = unit1;
					}
					else
					{
						document.getElementById("unit_lbl").innerHTML = 0;
					}
					if(amount > 0){
						document.getElementById("amount_lbl").innerHTML = amount;
					}else
					{
						document.getElementById("amount_lbl").innerHTML = 0;
					}
					
				//	alert(amount+" and "+unit1);
            }
         }
         xmlHttp.send(url);
	}
function updatepage(str,id)
{
//alert(id);
	document.getElementById(id+"_label2").innerHTML = str ;
	//types_of_units_label
}

</script>

<script type="text/javascript">
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

function conversion_validate(){
	//alert('waleed');exit;
	//alert('khan');
	 
	var account_no 			= this.document.getElementById('account_no');
	var customer_id 		= this.document.getElementById('customer_id');
	
	//var transaction_type 		= this.document.getElementById('transaction_type').value;
	var transaction_nature 		= this.document.getElementById('transaction_nature');
	
	var from_fund 				= this.document.getElementById('from_fund');
	//alert(from_fund); return false;
//	var types_of_units 			= this.document.getElementById('types_of_units');
	var from_unit_type			= this.document.getElementById('from_fund_types_of_units');
	var to_fund			 		= this.document.getElementById('to_fund');
	var to_unit_type			= this.document.getElementById('to_fund_types_of_units');/**/
	var units					= this.document.getElementById('unit_value');

	if(transaction_nature == null){ 
	this.document.getElementById('transaction_nature_error').style.display=""; 
	return false;
	}
	
	
	if(from_fund  == null){ 
	this.document.getElementById('from_fund_error').style.display=""; 
	return false;
	}
	if(from_unit_type  == null){
	 this.document.getElementById('from_fund_types_of_units_error').style.display=""; 
	 return false;
	 }
	if(to_fund  == null){  
	this.document.getElementById('to_fund_error').style.display=""; 
	return false;
	}
	if(to_unit_type  == null){ 
	this.document.getElementById('to_fund_types_of_units_error').style.display=""; 
	return false;
	}
	 if(units  == null)
	{
	 this.document.getElementById('unit_error').style.display=""; 
			return false;
	 }
	 
	this.document.getElementById('transaction_nature_error').style.display="none"; 
	this.document.getElementById('from_fund_error').style.display="none"; 
	this.document.getElementById('from_fund_types_of_units_error').style.display="none";
	this.document.getElementById('to_fund_error').style.display="none";  
	this.document.getElementById('to_fund_types_of_units_error').style.display="none"; 
	this.document.getElementById('unit_error').style.display="none"; 
	
	
	
	if(from_fund.value  == 0)
	{
	 //alert("HII"); 
	 this.document.getElementById('from_fund_error').style.display="";
	 return false;
	 }


 if(from_unit_type.value  == '' || from_unit_type.value  == "Please Select"){ 
	this.document.getElementById('from_fund_types_of_units_error').style.display=""; 
	return false;
	} 

	if(to_fund.value  == 0){ 
	 this.document.getElementById('to_fund_error').style.display=""; 
	return false;
	}
	
 if(to_unit_type.value  == '' || to_unit_type.value  == "Please Select"){ 
	this.document.getElementById('to_fund_types_of_units_error').style.display=""; 
	return false;
	} 

	if(from_fund.value  == to_fund.value)
	{
	 alert("Conversion in same account not allow"); 
	 //this.document.getElementById('from_fund_error').style.display="";
	 return false;
	 }
	  if(units.value  == 0)
	{
	 this.document.getElementById('unit_error').style.display=""; 
			return false;
	 }


//unit_error
	var units = document.forms['xForm'].elements['unit'];
		var unit_type = getCheckedValue(units);
		
		if(!unit_type){
			this.document.getElementById('unit_error').style.display=""; 
			return false;
		}
	var flag 					= true;
	var err_msg 				= '';
	
	if(account_no.value == ''){
		err_msg+= 'Missing Account No\n';
		this.document.getElementById('account_no_error').style.display="";
	}
	if(customer_id.value == ''){
		err_msg+= 'Missing Customer ID\n';
		this.document.getElementById('customer_id_error').style.display="";
	}

	
	
	
	if(units.value == '' || units.value == '0'){
		err_msg+= 'Missing Units\n';
		this.document.getElementById('unit_value_error').style.display="";
	}
	
	
	if(err_msg == ''){
		//alert("true"); 

		return get_preview();
		//return false;
	}
	else{ 
		//alert(err_msg);
		//alert("false"); 
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
	
	
	$id 							= $tools_admin->decryptId($_REQUEST['id']);

	//$transaction_type 			= $_REQUEST['transaction_type']; //= $tools_admin->decryptId($_REQUEST['transaction_type']);
	$transaction_nature 			= $_REQUEST['transaction_nature'];
	$from_fund 						= $_REQUEST['from_fund'];
	$from_unit_type 				= $_REQUEST['from_fund_types_of_units'];
	$to_fund 						= $_REQUEST['to_fund'];
	$to_unit_type 				  	= $_REQUEST['to_fund_types_of_units']; 
	$units 			  				= $_REQUEST['unit_value']; 
	$unit_rdio			  			= $_REQUEST['unit'];
	$unit_error						= $_REQUEST['unit_error'];

	
	
	$account_no_error 				= "display:none;";
	$customer_id_error 				= "display:none;";
//	$transaction_type_error 		= "display:none;";
	$transaction_nature_error 		= "display:none;";
	$from_fund_error 				= "display:none;";
	$from_fund_types_of_units_error	= "display:none;";
	$to_fund_error 					= "display:none;";
	$to_fund_types_of_units_error	= "display:none;";
	$unit_value_error 				= "display:none;";
	$unit_error				 		= "display:none;";

if(isset($_REQUEST['preview']) || isset($_REQUEST['preview'])){
	//header ("Location: conversion_preview.php?customer_id=".$customer_id ."&account_no=".$account_no."&transaction_nature=".transaction_nature."&from_fund=".from_fund."&from_fund_types_of_units=".from_unit_type."&to_fund=".to_fund."&to_fund_types_of_units=".to_unit_type."&unit_value=".units."&unit=".unit_rdio );
	//echo "Location: conversion_preview.php?customer_id=".$customer_id ."&account_no=".$account_no."&transaction_nature=".$transaction_nature."&from_fund=".$from_fund."&from_fund_types_of_units=".$from_unit_type."&to_fund=".$to_fund."&to_fund_types_of_units=".$to_unit_type."&unit_value=".$units."&unit=".$unit_rdio ; exit;
}	

if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{
		$unique_id		= $_SESSION['unique_id'];
		$caller_id		= $_SESSION['caller_id'];
	$flag = true;
	if($_REQUEST['account_no'] == ''){
		$account_no_error = "display:inline;";
		$flag = false;
	}
	if($_REQUEST['customer_id'] == ''){
		$customer_id_error = "display:inline;";
		$flag = false;
   	 }
   /*      if($_REQUEST['transaction_type'] == ''){
                $transaction_type_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
    		}
	*/
	if($_REQUEST['transaction_nature'] == '-1'){
		$transaction_nature_error = "display:inline;";//$tools->isEmpty('Caller ID');
		$flag = false;
  	}
	if($_REQUEST['from_fund'] == '0'){
		$from_fund_error = "display:inline;";//$tools->isEmpty('Caller ID');
		$flag = false;
   	}
	if($_REQUEST['from_fund_types_of_units'] == ''){
		$from_fund_types_of_units_error = "display:inline;";//$tools->isEmpty('Caller ID');
		$flag = false;
    }
	if($_REQUEST['to_fund'] == '0'){
		$to_fund_error = "display:inline;";//$tools->isEmpty('Caller ID');
		$flag = false;
   	}
	if($_REQUEST['to_fund_types_of_units'] == ''){
		$to_fund_types_of_units_error = "display:inline;";//$tools->isEmpty('Caller ID');
		$flag = false;
  	}
	if($_REQUEST['unit_value'] == ''){
		$unit_value_error = "display:inline;";//$tools->isEmpty('Caller ID');
		$flag = false;
    }	
	if($flag == true){
		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"])){
			$amount = $units;
			
			/*
			if($unit_rdio == "unit"){
				$unit2 = $units;
			}
			else if ($unit_rdio == "amount"){
				$amount = $units;
			}
			else if($unit_rdio == "percentage"){
				$percentage = $units;
			}
			else{
			}
			*/			
			if($unit_rdio == "unit"){
				$percentage = 1;
			}else if ($unit_rdio == "amount"){
				$percentage = 2;
			}
			else if($unit_rdio == "percentage"){
				$percentage = 3;
			}
			else{
			}
			
		
			if($unit2 == ''){
				$unit2 = 0;
			}
			if($amount 		== ''){
				$amount = 0;
			}
			if($percentage 	== ''){
				$percentage = 0;
			}
			
			if($from_fund != 0 && $to_fund != 0){
				$method = 'SetConversionTransaction';
				$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no, 'CustomerId'=>$customer_id, 'TransType'=>'CT','TransactionNature'=>$transaction_nature,'FromFund'=>$from_fund,'FromUnitType'=>$from_unit_type,'ToFund'=>$to_fund,'ToUnitType'=>$to_unit_type,'Units'=>$unit2,'Amount'=>$amount,'Percentage'=>$percentage);
				//print_r($params); exit;
				$trans_id = $soap_client->call_soap_method_2($method,$params);			
			
				if($trans_id < 0){
					$_SESSION[$db_prefix.'_RM'] = "Set Conversion Fail. Error: ['".$trans_id."']";
				}
				else{
					$rsAdmUser = $transactions->set_conversion($account_no, $customer_id, $transaction_type, $transaction_nature, $from_fund, $from_unit_type, $to_fund, $to_unit_type, $unit2, $amount, $percentage, $trans_id, $channel='IVR',$unique_id, $caller_id);
				
					$_SESSION[$db_prefix.'_GM'] = "Set Conversion successfully. Having Transaction ID ['".$trans_id."']";
				}
				header ("Location: customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile");
			}
			else{
				$_SESSION[$db_prefix.'_RM'] = "Please check Fund Types.";
			}
			exit();
		}	
	}	
}
?>

      	<div class="box">      
      		<h4 class="white"><?php echo $page_menu_title ;?></h4>
        <div class="box-container">
      	<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return conversion_validate(this);">
		<input type="hidden" id="id" name="id" value="<?php echo $tools_admin->encryptId($id); ?>">
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
          <input name="account_no" id="account_no" class="txtbox-short" value="<?php echo $account_no; ?>" disabled="disabled">
          <span id="account_no_error" class="form-error-inline" title = "Please Insert Account No" style="<?php echo($account_no_error); ?>"></span></label>
                            <span class="clearFix">&nbsp;</span></li>
<li >
                            <label class="field-title">Customer ID <em>*</em>:</label>
                            <label>
          <input name="customer_id" id="customer_id" class="txtbox-short" value="<?php echo $customer_id; ?>" disabled="disabled">
          <span id="customer_id_error" class="form-error-inline" title="Pleaes Insert Customer ID" style="<?php echo($customer_id_error); ?>"></span></label>
                            <span class="clearFix">&nbsp;</span></li>
                     <!-- <li class="even">
                            <label class="field-title">Transaction Type<em>*</em>:</label>
                            <label>
                        <?php // $transaction_type, $transaction_nature, $from_fund, $from_unit_type, $to_fund, $to_unit_type, $units, $amount, $percentage,
										/*					$method = 'GetTransactionType';
															$params = array('AccessKey' => $access_key,'Channel' => $channel);
															echo $soap_client->get_combo($method, $params, $combo_id="transaction_type", $value_feild="TransactionCode", $text_feild="TransactionDescription", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="", $title="")
															//echo $sOap_client->getcombo("admin_groups","group_id","id","group_name",$group_id,false,"form-select","","Group",""); 
															*/
							?>
                        <span id="transaction_type_error" class="form-error-inline" title = "Please Select Transaction Type" style="<?php echo($transaction_type_error); ?>"></span></label>
                            <span  class="clearFix">&nbsp;</span></li>-->
                      <li >
                            <label class="field-title">Conversion Type <em>*</em>:</label>
                            <label >
                        <select name="transaction_nature" id="transaction_nature" class="txtbox-short"  onchange="javascript:get_combo(this.selectedIndex)">
                              <option value="-1">Please Select</option>
                              <option value="1">Fund to Fund</option>
                             <!-- <option value="2">Fund to Plan</option>-->
                              <!--<option value="3">Fund to Pension Scheme</option>-->
                              <option value="3">Plan to Plan</option>
                             <!-- <option value="4">Plan to Fund</option>-->
                            </select>
                        <span id="transaction_nature_error" class="form-error-inline" title = "Please Select Transaction Nature" style="<?php echo($transaction_nature_error); ?>"></span></label>
                            <span  class="clearFix">&nbsp;</span></li>
                      <li class="even">
                            <label class="field-title">From Fund <em>*</em>:</label>
                            <label id="from_fund_label">
                        </label>
                        <span id="from_fund_error" class="form-error-inline" title = "Please Insert From Fund" style="<?php echo($from_fund_error); ?>"></span>
                            <span class="clearFix">&nbsp;</span></li>
                      <li id = "from_fund_li">
                            <label class="field-title">From Unit Type <em>*</em>:</label>
                            <label id="from_fund_label2">
                        </label>
                        <span id="from_fund_types_of_units_error" class="form-error-inline" title = "Please Insert From Unite Type" style="<?php echo($from_fund_types_of_units_error); ?>"></span>
                            <span class="clearFix">&nbsp;</span></li>
                      <li class="even">
                            <label class="field-title">To Fund <em>*</em>:</label>
                            <label id="to_fund_label">
                        </label>
                        <span id="to_fund_error" class="form-error-inline" title = "Please Insert To Fund" style="<?php echo($to_fund_error); ?>"></span>
                            <span class="clearFix">&nbsp;</span></li>
                      <li id = "to_fund_li" >
                            <label class="field-title">To Unit Type <em>*</em>:</label>
                            <label id="to_fund_label2">
                        </label>
                        <span id="to_fund_types_of_units_error" class="form-error-inline" title = "Please Select To Unite Type" style="<?php echo($to_fund_types_of_units_error); ?>"></span>
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
								</li>
								<li >
									<label class="field-title">Amount / Value <em>*</em>:</label>
									<label >
									<input maxlength="10" name="unit_value" id="unit_value" class="txtbox-short" value="" onkeypress='' onchange="javascript:return get_validate(this.value)" onkeyup="" onkeydown="return ( event.ctrlKey || event.altKey 
                    || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                    || (95<event.keyCode && event.keyCode<106)
                    || (event.keyCode==8) || (event.keyCode==9) 
                    || (event.keyCode>34 && event.keyCode<40) 
                    || (event.keyCode==46)
					|| (event.keyCode==110)
					 )" /></label>&nbsp;&nbsp; <!--javascript:return get_validate(this.value)-->
									<label class="field-title" id="unit_lbl" style="display:none; color:#FF0000"></label>
									<label class="field-title" id="amount_lbl" style="display:none; color:#FF0000"></label>
									<label class="field-title" id="percentage_lbl" style="display:none"></label>
									<span id="unit_value_error" class="form-error-inline" title = "Please Insert Unit" style="<?php echo($unit_value_error); ?>"></span>
									<span class="clearFix">&nbsp;</span>
								</li>
								<script type="text/javascript">
									function validate(evt) {
									//validate(event)
									var theEvent = evt || window.event;
									var key = theEvent.keyCode || theEvent.which;
									key = String.fromCharCode( key );
									var regex = /[0-9]|\.|\37|3\8/;
									if( !regex.test(key) ) {
									theEvent.returnValue = false;
									if(theEvent.preventDefault) theEvent.preventDefault();
									}
									}
								</script>
								
								
				      
                    </ol>
      				</fieldset> 
      				<p class="align-right">
					<?php   if(isset($admin_id) && !empty($admin_id)){?>
						<a class="button" href="javascript:document.xForm.submit();"  ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<!--<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Add</span></a>
									<input type="hidden" value="CREATE NEW ADMIN >>" id="add" name="add" />-->
										<a class="button" href="" onclick="javascript:return conversion_validate('xForm');"><span>Preview</span></a>
									<input type="hidden" value="CREATE NEW ADMIN >>" id="add" name="add" />
               				<?php    }?>					
					<!--<input type="image" src="images/bt-send-form.gif" />-->
				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div>
      	</div>
<?php include($site_root."includes/footer.php"); ?> 
