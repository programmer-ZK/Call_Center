<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "inquiry.php";
	$page_title = "User Inquiry";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "User Inquiry";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
		 include_once('lib/nusoap.php');
        include_once("classes/tools.php");
        $tools = new tools();
		global $tools;
?>
<?php
		include_once("classes/customers.php");
		$customers = new customers();
		global $customers;

?>

<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
$.validator.setDefaults({
	submitHandler: function() { alert("submitted!"); /* $("#frmcustomer").submit();*/  }
});

$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	
	// validate signup form on keyup and submit
	$("#frmcustomer").validate({
		rules: {
			txtcaller_id: "required",
			txtfirst_name: "required",
			txtlast_name: "required",
			txtgender: "required",
			txtdesc: "required",
			txtcell: "required",			
			txtemail: "required",
			txtcity: "required",
		},
		messages: {
			txtcaller_id: "Please enter customer callerid",
			txtfirst_name: "Please enter customer firstname",
			txtlast_name: "Please enter customer lastname",
			txtgender: "Please enter Gender",
			txtdesc: "Please enter Query / Description",
			txtcell: "Please enter Cell no",
            txtemail: "Please enter a valid email address",			
            txtcity: "Please enter customer city",

		}
	});
	

});
</script>


<?php

 if(isset($_REQUEST['new_customer'])){

	 $flag = true;
	 
	 //,,,,$_REQUEST['txtmother_name'],,,$_REQUEST['txtpass'],$_REQUEST['txcompany_name'],$_REQUEST[''],$_REQUEST[''] ,$_REQUEST['txttype'],$_REQUEST['txtgender'],$_REQUEST['txtdesc'],$_REQUEST[''],$_REQUEST['txtquery'],$_SESSION[$db_prefix.'_UserId']
	 
	 if($flag == true){
	 	$caller_id 	=	$_REQUEST['txtcaller_id'];
		$first_name	=	$_REQUEST['txtfirst_name'];
		$last_name	=	$_REQUEST['txtlast_name'];
		$father_name=	$_REQUEST['txtfather_name'];
		$cnic		=	$_REQUEST['txtcnic'];
		$email		=	$_REQUEST['txtemail'];
		$address	=	$_REQUEST['txtadddress'];
		$city		=	$_REQUEST['txtcity'];
		$country	=	$_REQUEST['txtcountry'];
		$contact_no	=	$_REQUEST['txtcontact'];
		$cell_no	=	$_REQUEST['txtcell'];
		$product_info1	=	$_REQUEST['txtquery1'];
		$product_info2	=	$_REQUEST['txtquery2'];
		$product_info3	=	$_REQUEST['txtquery3'];
		$product_info4	=	$_REQUEST['txtquery4'];
		$description	=	$_REQUEST['txtdesc'];
		
		$product_info = $product_info1."|".$product_info2."|".$product_info3."|".$product_info4;
		
		$register_success = $customers->insert_customers($caller_id, $first_name, $last_name, $father_name, $cnic, $email, $address, $city, $country, $contact_no, $cell_no, $product_info, $description,'1', $_SESSION[$db_prefix.'_UserId']);
		
	 	if($register_success){
			echo "Successfully Registered";		
			$_SESSION[$db_prefix.'_GM'] = "Successfully Registered";
			header( 'Location: index.php' ) ;			
		}
		else{
			echo "User Already Exists";
		}
	}
 }
?>

		<div class="box">
		<h4 class="white"><?php echo($page_title); ?> </h4>
        <div class="box-container">
			<form class="middle-forms cmxform" name="xForm" id="xForm" method="post" action="<? echo $_SERVER['PHP_SELF'] ?>">
				<fieldset>
					<h3><?php echo($page_title); ?></h3>
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION[$db_prefix.'_UserId'];?>"/>
					<ol>
                    	<li class="even">
							<label class="field-title">Caller ID<font color="red"> <em>*</em></font>:</label>
							<input id="txtcaller_id" name="txtcaller_id" value="<?php echo $caller_id;?>" />
							<?php  echo $txtcaller_id_error;?>
						</li>		
						<li >
							<label class="field-title">First Name <font color="red"><em>*</em></font>:</label>
							<input id="txtfirst_name" name="txtfirst_name" />
							<?php  echo $txtfirst_name_error; ?>			
						</li>
						<li class="even">
							<label class="field-title">Last Name <font color="red"><em>*</em></font>:</label>
							<input id="txtlast_name" name="txtlast_name" />
							<?php echo $txtlast_name_error; ?>			
						</li>
						<li  >
							<label class="field-title">Email <font color="red"><em>*</em></font>:</label>
							<input id="txtemail" name="txtemail" />
							<?php echo $txtemail_error; ?>
						</li>						
						<li  class="even">
								<label class="field-title">Mailing Address :</label>
								<input id="txtaddress" name="txtaddress" />
								<?php echo $txtaddress_error; ?>
						</li>
						<li>
							<label class="field-title">City Name <font color="red"><em>*</em></font>:</label>
							<input id="txtcity" name="txtcity" />
							<?php echo $txtcity_error; ?>
						</li>
						<li  class="even">
							<label class="field-title">Country <font color="red"><em>*</em></font>:</label>
							<input id="txtcountry" name="txtcountry" value="<?php echo $_REQUEST['txtcountry'];?>" />
							<?php echo $txtcity_error; ?>
						</li>												
						<li >
								<label class="field-title">Contact No:</label>
								<input id="txtcontact" name="txtcontact" />
								<?php echo $txtcontact_error; ?>
						</li>
						<li  class="even">
							<label class="field-title">Cell no<font color="red"><em>*</em></font>:</label>
							<input id="txtcell" name="txtcell" />
							<?php echo $txtcell_error; ?>
					   </li>
					   	<li >
							<label class="field-title">Product Info :</label>
            		    </li>					
						<li class="even">
							<label class="field-title">FAQ 1 :</label>
							<input id="txtquery1" name="txtquery1" />
							<?php echo $txtquery_error; ?>
            		    </li>	
						<li >
							<label class="field-title">FAQ 2 :</label>
							<input id="txtquery2" name="txtquery2" />
							<?php echo $txtquery_error; ?>
            		    </li>	
						<li class="even">
							<label class="field-title">FAQ 3 :</label>
							<input id="txtquery3" name="txtquery3" />
							<?php echo $txtquery_error; ?>
            		    </li>	
						<li >
							<label class="field-title">FAQ 4 :</label>
							<input id="txtquery4" name="txtquery4" />
							<?php echo $txtquery_error; ?>
            		    </li>						
						<li  class="even">
								<label class="field-title">Description<font color="red"><em>*</em></font>:</label>
								<textarea id="txtdesc" name="txtdesc" rows="5" cols="40"></textarea>
								<?php echo $txtdesc_error; ?>
						</li>
						<li style="display:none;" >
							<label class="field-title">Company Name :</label>
							<input id="txcompany_name" name="txcompany_name" />
							<?php echo $txcompany_name_error; ?>			
						</li>
						<li style="display: none;">
							 <label class="field-title">Gender <font color="red"><em>*</em></font>:</label>
								<select id="txtgender" name="txtgender" style="width:149px;">
								 <option value="Male">Male</option>
								 <option value="Female">Female</option>
								</select>
								<?php echo $txtgender_error; ?>
						</li>
					</ol>
					<p class="align-right">
						<a id="btn_submit" class="button" href="javascript:document.xForm.submit();" onclick="javascript:document.xForm.submit();"><span>Submit</span></a>
						<input type="hidden" value="Submit" name="new_customer" id="new_customer" />	
					</p>
				</fieldset>
				
			</form>
 		</div>
    </div>
 <div class="box" id="mid-tab">
        <ul class="tab-menu">
                  <li><a href="#faq-1">FAQ-1</a></li>
                  <li><a href="#faq-2">FAQ-2</a></li>
                  <li><a href="#faq-3">FAQ-3</a></li>
                  <li><a href="#faq-4">FAQ-4</a></li>

		</ul>
			<div class="box-container" id="faq-1"><?php  include($site_root."includes/faqs1.php"); ?></div>
			<div class="box-container" id="faq-2"><?php  include($site_root."includes/faqs2.php"); ?></div>			
			<div class="box-container" id="faq-3"><?php  include($site_root."includes/faqs3.php"); ?></div>
			<div class="box-container" id="faq-4"><?php  include($site_root."includes/faqs4.php"); ?></div>
</div>


<?php
function verify($name,$value){
	if(isset($_REQUEST['new_customer'])){
		global $tools;
		echo $tools->isEmpty($name,$value);
		
	}
}
?>
<?php include($site_root."includes/footer.php"); ?>    

