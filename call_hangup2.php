<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "call_hangup2.php";
	$page_title = "Call Hangup | Step 2";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Call Hangup";
	
	/*
	SELECT wc_title FROM cc_workcodes WHERE wc_title IN (SELECT workcodes FROM cc_call_workcodes where unique_id= '1324050866.161' AND staff_id = '9030' AND status = 1)AND wc_value='1' AND status='1'
	*/
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/work_codes.php");
	$work_codes = new work_codes();
	
	$unique_id = $_REQUEST["unique_id"];
	$caller_id = $_REQUEST["caller_id"];
	$staff_id = $_SESSION[$db_prefix.'_UserId'];
	$rs = $work_codes->get_workcodes_for_values($unique_id,$caller_id,$account_no,$customer_id,$staff_id);
	
?>
<?php
if(isset($_REQUEST['update'])){

	$count  = $_REQUEST["count"]; 

	$tools_admin->exec_query("update cc_admin set is_busy='0' where admin_id='".$_SESSION[$db_prefix.'_UserId']."'and status='1'");
	$n=0;
	while($n < $count){

		$workcodes = $_REQUEST["feild_".$n];
		$detail = $_REQUEST["value_".$n];
		//echo $detail; exit;
		$work_codes->update_work_codes($unique_id, $caller_id, $workcodes, $detail, $_SESSION[$db_prefix.'_UserId']);
		$n++;
	}
	$_SESSION[$db_prefix.'_GM'] = "Call Ended Successfully.";
	
	
	include_once("classes/user_pin.php");
	$user_pin = new user_pin();
	$user_pin->update_user_status($unique_id,$caller_id,'-1',0,$_SESSION[$db_prefix.'_UserId']);
	
	header ("Location: exit.php");
}
?>
<?php include($site_root."includes/iheader.php");?>
      	<div class="box">      
      		<h4 class="white"><?php echo $page_title ;?></h4>
        	<div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
				<input type="hidden" id="count" name="count" value="<?php echo $rs->RecordCount(); ?>">
				<input type="hidden" id="caller_id" name="caller_id" value="<?php echo $_REQUEST["caller_id"];?>"/>
				<input type="hidden" id="unique_id" name="unique_id" value="<?php echo $_REQUEST["unique_id"];?>"/>
      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
						<?php $i=0; while(!$rs->EOF){ ?>
                      <li class="even">
                            <label class="field-title"><?php echo $rs->fields["wc_title"]; ?> <em>*</em>:</label>
                            <label>
								<input type="hidden" name="feild_<?php echo $i;?>" id="feild_<?php echo $i;?>" class="txtbox-short" value="<?php echo $rs->fields["wc_title"]; ?>"  />
          						<input name="value_<?php echo $i;?>" id="value_<?php echo $i;?>" class="txtbox-short" value="" /></label>
          						<span id="error_<?php echo $i;?>" class="form-error-inline" title="Please Insert <?php echo $rs->fields["wc_title"];?> Detail" style=" <?php echo($account_no_error); ?> "></span>
                            	<span class="clearFix">&nbsp;</span>
						</li>
				 		<?php $i++; $rs->MoveNext();	} ?>
                    </ol>
      				</fieldset> 
      				<p class="align-right">
						<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:document.xForm.submit();"><span>Update</span></a>
						<input type="hidden" value="update" id="update" name="update" />
					</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div>
      	</div>
<?php include($site_root."includes/ifooter.php"); ?> 
