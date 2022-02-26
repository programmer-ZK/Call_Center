<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "registeration_detail.php";
	$page_title = "Registration Detail";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Registration Detail";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/transactions.php");
	$transactions = new transactions();
	
	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$soap_client = new soap_client();
	
    include_once("classes/user_pin.php");
    $user_pin = new user_pin();
	
	include_once("classes/user_tools.php");		
	$user_tools = new user_tools(); 
?>

<?php include($site_root."includes/header.php"); //http://www.codingforums.com/showthread.php?t=201276?>


<?php
		
	$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
	$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
	$tid			= $_REQUEST['tid'];
	
	$method 	= 'GetContactRegisteredInfo';
	$params 	= array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel); 
	$rs1 		= $soap_client->call_soap_method($method,$params); 

	$count = 0;
	while($count != count($rs1)){ 
		if($rs1[$count]["Id"] != $tid)
		{
			$count++;		
		}
		break; 
	}
	//print_r($rs1[$count]); exit;
		$rscdr = $user_tools->get_cdr_details($unique_id);		
		$userfield = $rscdr->fields["userfield"];

/*	$is_residence 	= empty($rs1[$count]['IsResidenceRegister'])?'no':'yes';
	$is_office		= empty($_REQUEST['office'])?'no':'yes';
	$is_mobile		= empty($_REQUEST['mobile'])?'no':'yes';
*/

	//print_r($rs1[$count]);
?>
      	<div class="box">      
      		<h4 class="white"><?php echo $page_menu_title ;?></h4>
        	<div class="box-container">
      			<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" >

				<input type="hidden" id="account_no" name="account_no" value="<?php echo $account_no; ?>">
				<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">
<!--      		<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>-->
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
							<li class="even">
								<label class="field-title">Request ID <em>*</em>:</label>
								<label><?php echo $rs1[$count]["Id"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li >
								<label class="field-title">Channel <em>*</em>:</label>
								<label><?php echo $rs1[$count]["Channel"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li class="even">
								<label class="field-title">Mobile <em>*</em>:</label>
								<label><?php echo $rs1[$count]["Mobile"]; ?>&nbsp&nbsp; | &nbsp&nbsp;</label>
								<label>For IVR:<b><font color="green"><?php echo $rs1[$count]["IsMobileTransRegister"]."  "; ?>&nbsp&nbsp; | &nbsp&nbsp;</font></b></label>
								<label>For SMS:<b><font color="green"><?php echo $rs1[$count]["IsMobileSmsRegister"]; ?></font></b></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li >
								<label class="field-title">Residence <em>*</em>:</label>
								<label><?php echo $rs1[$count]["Residence"]." -- "; ?></label>
								<label><b><font color="green"><?php echo $rs1[$count]["IsResidenceRegister"]; ?></font></b></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li class="even">
								<label class="field-title">Office <em>*</em>:</label>
								<label><?php echo $rs1[$count]["Office"]." -- "; ?></label>
								<label><b><font color="green"><?php echo $rs1[$count]["IsOfficeRegister"]; ?></font></b></label>
								<span class="clearFix">&nbsp;</span>
							</li>																					
							<li >
								<label class="field-title">CreatedOn <em>*</em>:</label>
								<label><?php echo $rs1[$count]["CreatedOn"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li class="even">
								<label class="field-title">ModifiedOn <em>*</em>:</label>
								<label><?php echo $rs1[$count]["ModifiedOn"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li >
								<label class="field-title">Status <em>*</em>:</label>
								<label><?php echo $rs1[$count]["Status"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li class="even">
								<label class="field-title">Reason <em>*</em>:</label>
								<label><?php echo $rs1[$count]["Comments"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li >
								<label class="field-title">CallerId <em>*</em>:</label>
								<label><?php echo $rs1[$count]["CallerId"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li class="even">
								<label class="field-title">OperatingType <em>*</em>:</label>
								<label><?php echo $rs1[$count]["OperatingType"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li >
								<label class="field-title">SigningDetail <em>*</em>:</label>
								<label><?php echo $rs1[$count]["SigningDetail"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>							
							<li class="even">
								<label class="field-title">CategoryType <em>*</em>:</label>
								<label><?php echo $rs1[$count]["CategoryType"]; ?></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li >
								<label class="field-title">CallLogId <em>*</em>:</label>
								<label><a href="call_detail.php?unique_id=<?php echo $rs1[$count]["CallLogId"]; ?>"><?php echo $rs1[$count]["CallLogId"]; ?></a></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							
							<?php 
									$rscdr = $user_tools->get_cdr_details($rs1[$count]["CallLogId"]);		
									$userfield = $rscdr->fields["userfield"];
									$staff_name  = $tools_admin->returnFieldVal('full_name', 'admin', 'admin_id='.$rscdr->fields["staff_id"]);
									
							?>
							<li class="even">
								<label class="field-title">Audio :</label>
								<label><a title="click here to download" target="_blank" href="recording/<?php echo $userfield; ?>.wav" ><?php echo 'click here'; ?> </a></label>
								<span class="clearFix">&nbsp;</span>
							</li>
							<li>
								<label class="field-title">Agent Name :</label>
								<label><?php echo $staff_name;?></label>
								<span class="clearFix">&nbsp;</span>
							</li>																																																																				
						</ol>
					</fieldset>
				</form>
			</div>
		</div>
		<?php include($site_root."includes/footer.php"); ?> 