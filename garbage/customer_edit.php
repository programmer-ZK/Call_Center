<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "customer_edit";
	$page_title = "Edit Customer";
?>
<?php
        include_once("classes/tools.php");
        $tools = new tools();
		global $tools;
?>
<?php
		include_once("classes/customers.php");
		$customers = new customers();
		global $customers;

		if($_REQUEST['rec_id'] <> ""){$rec_id = $_REQUEST['rec_id'];}
		global  $rec_id;
		$output = $customers->get_customer($rec_id);
		global  $output;
?>
<?php if($_SESSION['admin_login'] <> "true"){ header ("Location: login.php");}?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
//$.validator.setDefaults({
//	submitHandler: function() { alert("submitted!"); /* $("#frmcustomer").submit();*/  }
//});

$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	
	// validate signup form on keyup and submit
	/*$("#frmcustomer").validate({
		rules: {
			txtcaller_id: "required",
			txtfirst_name: "required",
			txtlast_name: "required",
                        txtgender: "required",
                        txtdesc: "required",
                	txtcell: "required",
		//       txtcnic: {
		//		required: true,
		//		minlength: 15
		//	},
                        txtemail: "required",
		//	txtpass: {
		//		required: true,
		//		minlength: 4
		//		},
                //        txcompany_name: "required",
                        txtcity: "required",
                //        txtcountry: "required",
                //        txttype: "required",						
			
		},
		messages: {
			txtcaller_id: "Please enter customer callerid",
			txtfirst_name: "Please enter customer firstname",
			txtlast_name: "Please enter customer lastname",
                        txtgender: "Please enter Gender",
                        txtdesc: "Please enter Query / Description",
			txtcell: "Please enter Cell no",
			//txtcnic: {
			//	required: "Please enter a cnic",
			//	minlength: "CNIC must consist of at least 15 characters"
			//},
                        txtemail: "Please enter a valid email address",			
		//	txtpass: {
		//		required: "Please provide a pincode",
	//			minlength: "Pincode must be at least 4 characters long"
	//		},
          //              txcompany_name: "Please enter customer companyname",
                        txtcity: "Please enter customer city",
            //            txtcountry: "Please enter customer country",
              //          txttype: "Please enter customer type",

		}
	});
	*/

});
</script>
<h1><?php echo($page_title); ?></h1>

<?php

 if(isset($_REQUEST['new_customer'])){
	//echo 'yahya'; exit;
	// echo "kokokokoko";
	 $flag = true;
	/* if($_REQUEST['txtcaller_id'] == ''){
		$txtcaller_id_error = $tools->isEmpty('Caller ID');
		$flag = false;
	 }
	 if($_REQUEST['txtfirst_name'] == ''){
		$txtfirst_name_error = $tools->isEmpty('First Name');
		$flag = false;
	 }
	 if($_REQUEST['txtlast_name'] == ''){
		$txtlast_name_error = $tools->isEmpty('Last Name');
		$flag = false;
	 }
	 if($_REQUEST['txtgender'] == ''){
		$txtgender_error = $tools->isEmpty('Gender');
		$flag = false;
	 }
	 if($_REQUEST['txtdesc'] == ''){
		$txtdesc_error = $tools->isEmpty('Query / Description');
		$flag = false;
	 }
//	 if($_REQUEST['txtcnic'] == ''){
//		$txtcnic_error = $tools->isEmpty('CNIC');
//		$flag = false;
//	 }
	 if($_REQUEST['txtemail'] == ''){
		$txtemail_error = $tools->isEmpty('Email');
		$flag = false;
	 }
//	 if($_REQUEST['txtpass'] == ''){
//		$txtpass_error = $tools->isEmpty('PIN');
//		$flag = false;
//	 }
//	 if($_REQUEST['txcompany_name'] == ''){
//		$txcompany_name_error = $tools->isEmpty('Company Name');
//		$flag = false;
//	 }
	 if($_REQUEST['txtcity'] == ''){
		$txtcity_error = $tools->isEmpty('City');
		$flag = false;
	 }
	 if($_REQUEST['txtcell'] == ''){
		$txtcell_error = $tools->isEmpty('Cell no');
		$flag = false;
	 }
//	 if($_REQUEST['txttype'] == ''){
//		$txttype_error = $tools->isEmpty('Type');
//		$flag = false;
//	 }
*/
	$flag = true;
	 if($flag == true){
//		echo "OKOKOKOK";
		$register_success = $customers->customer_update($_REQUEST['txtcaller_id'],$_REQUEST['txtfirst_name'],$_REQUEST['txtlast_name'],$_REQUEST['txtfather_name'],$_REQUEST['txtmother_name'],$_REQUEST['txtcnic'],$_REQUEST['txtemail'],$_REQUEST['txtpass'],$_REQUEST['txcompany_name'],$_REQUEST['txtcity'],$_REQUEST['txtcountry'] ,$_REQUEST['txttype'],$_REQUEST['txtgender'],$_REQUEST['txtdesc'],$_REQUEST['txtcell'],$_REQUEST['txtquery'],$_SESSION[$db_prefix.'_UserId'], $_REQUEST['txtid']);
	 	if($register_success)
		{
			echo "Successfully updated";		
			$_SESSION[$db_prefix.'_SM'] = "Successfully updated";
			header( 'Location: customers.php' ) ;
			
		}
		else
		{
			echo "Error!";
		}
	}
 }
?>



<form class="cmxform" id="frmcustomer" name="frmcustomer" method="post" action="<?php echo $page_name;?>.php">
	<fieldset>
		<!--  <legend>New Customer</legend> -->
		 <p style="display:none;">
                        <label for="txtid">ID</font></label>
                        <input id="txtid" name="txtid" value="<?php echo $_REQUEST['rec_id']; ?>"/>
                        <?php echo $txtid_error; ?>
                </p>
	
		<p>
			<label for="txtcaller_id">Caller ID<font color="red"> *</font></label>
			<input id="txtcaller_id" name="txtcaller_id" onclick="JavaScript:SayHello()" value="<?php echo $output->fields["caller_id"]; ?>" />
			<?php  echo $txtcaller_id_error;?>
		</p>		
		<p>
			<label for="txtfirst_name">First Name <font color="red">*</font></label>
			<input id="txtfirst_name" name="txtfirst_name" value="<?php echo $output->fields["first_name"]; ?>"/>
			<?php  echo $txtfirst_name_error; ?>			
		</p>
		<p>
			<label for="txtlast_name">Last Name <font color="red">*</font></label>
			<input id="txtlast_name" name="txtlast_name" value="<?php echo $output->fields["last_name"]; ?>" />
			<?php echo $txtlast_name_error; ?>			
		</p>
		<p>
                        <label for="txtgender">Gender <font color="red">*</font></label>
                        <select id="txtgender" name="txtgender" style="width:149px;" value="<?php echo $output->fields["gender"]; ?>" >
                         <option value="Male">Male</option>
                         <option value="Female">Female</option>
                        </select>
                        <?php echo $txtgender_error; ?>
                </p>
		<p style="display:none;">		
			<label for="txtfather_name">Father Name </font></label>
			<input id="txtfather_name" name="txtfather_name" value="<?php echo $output->fields["father_name"]; ?>"/>
			<?php echo $txtfather_name_error; ?>			
		</p>		
		<p style="display:none;">
			<label for="txtmother_name">Mother Name </label>
			<input id="txtmother_name" name="txtmother_name" />
			<?php echo $txtmother_name_error; ?>			
		</p>
                <p>
                        <label for="txtcity">City Name <font color="red">*</font></label>
                        <input id="txtcity" name="txtcity" value="<?php echo $output->fields["city"]; ?>"/>
                        <?php echo $txtcity_error; ?>
                </p>
		<p>
			<label for="txtemail">Email <font color="red">*</font></label>
			<input id="txtemail" name="txtemail" value="<?php echo $output->fields["email"]; ?>"/>
			<?php echo $txtemail_error; ?>
		</p>
                <p>
                        <label for="txtcell">Cell no<font color="red">*</font></label>
                        <input id="txtcell" name="txtcell" value="<?php echo $output->fields["cell_no"]; ?>"/>
                        <?php echo $txtcell_error; ?>
                </p>
                <p style="display:none;">
                        <label for="txtcnic">CNIC</label>
                        <input id="txtcnic" name="txtcnic" />
                        <?php echo $txtcnic_error; ?>
                </p>
		<p style="display:none;">
			<label for="txtpass">Pin Code</label>
			<input id="txtpass" name="txtpass" />
			<?php echo $txtpass_error; ?>			
		</p>		
		<p>
			<label for="txcompany_name">Company Name</label>
			<input id="txcompany_name" name="txcompany_name" value="<?php echo $output->fields["company_name"]; ?>" />
			<?php echo $txcompany_name_error; ?>			
		</p>
		<p style="display:none;">
			<label for="txtcountry">Country</label>
			<input id="txtcountry" name="txtcountry" value="1"/>
			<?php echo $txtcountry_error; ?>
		</p>
		<p style="display:none;">
			<label for="txttype">Type</label>
			<input id="txttype" name="txttype" />
			<?php echo $txttype_error; ?>
		</p>
		<p>
                        <label for="txtquery">Query</label>
                        <input id="txtquery" name="txtquery" value="<?php echo $output->fields["query"]; ?>"/>
                        <?php echo $txtquery_error; ?>
                </p>
	
		<p>
                        <label for="txtdesc">Description<font color="red">*</font></label>
                        <textarea id="txtdesc" name="txtdesc" rows="5" cols="40"> <?php echo $output->fields["description"]; ?></textarea>
                        <?php echo $txtdesc_error; ?>
                </p>
		
		<p>
			<input class="submit" type="submit" value="Submit" name="new_customer" id="new_customer"/>
		</p>
	</fieldset>
</form>
</td>
<td class="rightMenu">
<?php include($site_root."includes/faqs.php"); ?>
<?php include($site_root."includes/footer.php"); ?>


<?php
function verify($name,$value)
{
	if(isset($_REQUEST['new_customer']))
	{
		global $tools;
		echo $tools->isEmpty($name,$value);
		
	}
	//return true;
}
?>

