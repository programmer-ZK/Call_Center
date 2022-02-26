<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "call_hangup.php";
	$page_title = "Call Hangup | Step 1";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Call Hangup";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/work_codes.php");
	$work_codes = new work_codes();
	
?>
<?php include($site_root."includes/iheader.php");?>
<?php
  $cb = $_POST['cb'];

if(isset($_REQUEST['submitwc'])){
  if(empty($cb)){
    echo("You didn't select any workcodes.");
  }
  else{
	$unique_id = $_REQUEST["unique_id"];
	$caller_id = $_REQUEST["caller_id"];
	$agent_id = $_SESSION[$db_prefix.'_UserId'];
    $N = count($cb);
    	//echo("You selected $N workcodes(s): ");
    for($i=0; $i < $N; $i++){
      	//echo($cb[$i] . " ");
	  $workcodes =$cb[$i];
	  $work_codes->insert_work_codes($unique_id, $caller_id, $workcodes, $agent_id);
	  $que_str =  "unique_id=".$unique_id."&caller_id=".$caller_id; 
	  
    }
	header ("Location: call_hangup2.php?".$que_str);
	$tools_admin->update_cdr($unique_id, $agent_id);
  }
}
?>
<div class="box">      

	<h4 class="white"><?php echo "Set Work Codes" ;?></h4>
		<div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
				<input type="hidden" id="caller_id" name="caller_id" value="<?php echo $_REQUEST["caller_id"];?>"/>
				<input type="hidden" id="unique_id" name="unique_id" value="<?php echo $_REQUEST["unique_id"];?>"/>
				<div style="padding:10px; overflow-y: auto; height:450px; ">
					<ul>
					<li>Complaint
						<div id="navcontainer">
							<ul id="navlist">
								<li><input type="checkbox" id="cb[]" name="cb[]" value="Lodge" />Lodge</li><br />
								<li><input type="checkbox" id="cb[]" name="cb[]" value="Follow up" />Follow up</li><br />
								<li><input type="checkbox" id="cb[]" name="cb[]" value="Resolution" />Resolution</li><br />
								<li><input type="checkbox" id="cb[]" name="cb[]" value="Closed" />Closed</li><br />
							</ul>
						</div>
					</li>
					<li>Service Request
						<ul>
							<li>Statement
								<div id="navcontainer">
									<ul id="navlist">
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Physical" />Physical</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="E-statement" />E-statement</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="SMS statement" />SMS statement</li><br />
									</ul>
								</div>		
							</li>
							<li>UBL Fund Services
								<div id="navcontainer">
									<ul id="navlist">
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Password Reset" />Password Reset</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Pin Generation" />Pin Generation</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Pin Reset" />Pin Reset</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Pin Change" />Pin Change</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Tele Tranaction Registration" />Tele Trans Registration</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="SMS Tranaction Registration" />SMS Trans Registration</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="E-subscription" />E-subscription</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="E-unsubscription" />E-unsubscription</li>	<br />					
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Additional Purchase" />Additional Purchase</li>	<br />																																		
									</ul>
								</div>		
							</li>
							<li>Transaction
								<div id="navcontainer">
									<ul id="navlist">
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Conversion Submission" />Conversion Submission</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Conversion Cancellation" />Conversion Cancellation</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Redemtion Submission" />Redemtion Submission</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Redemtion Cancellation" />Redemtion Cancellation</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Profile Submission" />Profile Submission</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Profile Cancellation" />Profile Cancellation</li><br />																																						
									</ul>
								</div>		
							</li>
							<li>Material Request
								<div id="navcontainer">
									<ul id="navlist">
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Forms via Email" />Forms via Email</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Forms via Physical" />Forms via Physical</li>	<br />						
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Marketing Collateral/Reports via Email" />Marketing Collateral/Reports via Email</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Marketing Collateral/Reports via Physical" />Marketing Collateral/Reports via Physical</li>	<br />						
										
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Others" />Others</li><br />
																																													
									</ul>
								</div>		
							</li>
							<li>Payment Instrument
								<div id="navcontainer">
									<ul id="navlist">
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Re-Validate of Instrument" />Re-Validate of Instrument</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Duplicate Issuance" />Duplicate Issuance</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Stop/Cancel" />Stop/Cancel</li><br />
																																													
									</ul>
								</div>		
							</li>
							<li>Certificate/Challans
								<div id="navcontainer">
									<ul id="navlist">
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Holdings" />Holdings</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="cgt" />cgt</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Zakat" />Zakat</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="With Holding Tax" />With Holding Tax</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Others Certificate/Challans" />Others Certificate/Challans</li><br />
										
									</ul>
								</div>		
							</li>
							<li><input type="checkbox" id="cb[]" name="cb[]" value="Verification" />Verification</li>	<br />										
						</ul>
					</li>
					<li>Inquiry
						<div id="navcontainer">
							<ul id="navlist">
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Balance" />Balance</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Products" />Products</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="NAV" />NAV</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Services" />Services</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Transaction Inquiry" />Transaction Inquiry</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="UBL" />UBL</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="UCPF-1" />UCPF-1</li><br />										
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Others Inquiry" />Others Inquiry</li><br />
										
							</ul>
						</div>		
					</li>
					<li>Campaigns
						<div id="navcontainer">
							<ul id="navlist">
										<li><input type="checkbox" id="cb[]" name="cb[]" value="UPPF-1" />UPPF-1</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Smart Savings Magezine English" />Smart Savings Magezine English</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="Smart Savings Magezine Urdu" />Smart Savings Magezine Urdu</li><br />
										<li><input type="checkbox" id="cb[]" name="cb[]" value="TV Ads" />TV Ads</li><br />
							</ul>
						</div>		
					</li>		
					<li>Outgoing
						<div id="navcontainer">
							<ul id="navlist">
								<li><input type="checkbox" id="cb[]" name="cb[]" value="No Answer" />No Ans</li><br />
								<li><input type="checkbox" id="cb[]" name="cb[]" value="Busy" />Busy</li>	<br />						
								<li><input type="checkbox" id="cb[]" name="cb[]" value="Not Connected" />Not Connected</li><br />
								<li><input type="checkbox" id="cb[]" name="cb[]" value="Powered Off" />Powered Off</li><br />																	
							</ul>
						</div>		
					</li>
				</ul>
			</div>	
			<div style="padding:10px;">
				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Submit</span></a>
				<input type="hidden" value="submitwc" id="submitwc" name="submitwc" />
			</div>	
			</form>
    	</div>
</div>
<?php include($site_root."includes/ifooter.php"); ?> 
