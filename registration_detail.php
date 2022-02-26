<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "registration_detail";
	$page_title = "Registration Detail";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Registration Detail";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();
		
		include_once("classes/user_tools.php");		
		$user_tools = new user_tools(); 

?>
<?php include($site_root."includes/header.php"); ?>
<?php
		$regtype	= $_REQUEST['regtype'];	
		$isregistered	= $_REQUEST['isregistered'];
		$status	= $_REQUEST['status'];	
		$date	= $_REQUEST['date'];	
	$customer_id = $_REQUEST['customer_id'];
	$account_no	 = $_REQUEST['account_no'];
?>

        <div class="box">
        	<h4 class="white" >Registration Detail</h4>
        	<div class="box-container">
                <form action="" method="post" class="middle-forms">
					<fieldset>
						<legend>Fieldset Title</legend>
							<ol>
								<li class="even">
									<label class="field-title"><?php echo $regtype; ?>&nbsp;:</label>
									<label></label>
									<span class="clearFix">&nbsp;</span>
								</li>
								<li >
									<label class="field-title">Is Registered :</label> 
									<label><?php echo $isregistered; ?></label>
									<span class="clearFix">&nbsp;</span>
								</li>
								<li class="even">
									<label class="field-title">Status :</label>
									<label><?php echo $status; ?></label>
									<span class="clearFix">&nbsp;</span>
								</li>
								<li >
									<label class="field-title">Date :</label>
									<label><?php echo $date; ?></label>
									<span class="clearFix">&nbsp;</span>
								</li>
								<!--<li class="even">
									<label class="field-title">WorkCodes :</label>
									<label><?php //echo $wcodes; ?></label>
									<span class="clearFix">&nbsp;</span>
								</li>
								<li class="even">
									<label class="field-title">Audio :</label>
									<label><a title="click here to download" target="_blank" href="recording/<?php //echo $userfield; ?>.wav" ><?php //echo $unique_id; ?> </a></label>
									<span class="clearFix">&nbsp;</span>
								</li>									-->							
							</ol>
					</fieldset>
					  <p class="align-right">
				<a class="button" href="<?php echo "customer_detail.php?customer_id=".$customer_id ."&account_no=".$account_no."&tab=profile"; ?>" onclick=""><span>Back</span></a>
				</p>
					<span class="clearFix">&nbsp;</span>
					
                </form>
        	</div>
        </div>
<?php include($site_root."includes/footer.php"); ?>		