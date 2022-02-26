<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "campaign_delete";
	$page_title = "Campaign Delete";
	$page_menu_title = "Campaign Delete";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php include($site_root."includes/header.php"); ?>
<?php
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();

	include_once("classes/templates.php");
	$templates = new templates();
?>
<?php 
	include_once("classes/campaign.php");
			  $campaign = new campaign();
			  
	
	 	?>	
<?php
	$campaign_id 				= $tools_admin->encryptId($_REQUEST['campaign_id']);

	
	
	$rsCampaign 		= 	$campaign->get_campaign_by_id($campaign_id);
	if($rsAdmin->EOF){
		$_SESSION[$db_prefix.'_RM'] = " Campaign deletion rejected or not found.";
		header ("Location: campaign.php");
		exit();
	}
	
	$cname 		= 	$rsCampaign->fields['cname'];
	
	if(isset($_REQUEST["yes"]) && !empty($_REQUEST["yes"])){
		$campaign->delete_campaign($campaign_id);
		$_SESSION[$db_prefix.'_GM'] = "[".$cname."] Campaign inactive successfully.";
		header ("Location: campaign.php");
		exit();
	}
	if(isset($_REQUEST["no"]) && !empty($_REQUEST["no"])){
		$_SESSION[$db_prefix.'_GM'] = "[".$cname."] Campaign deletion cancelled.";
		header ("Location: campaign.php");
		exit();
	}
?>
<form name="listings" id="listings" action="<?php echo($page_name);?>.php" method="post" >

	<input type="hidden" id="campaign_id" name="campaign_id" value="<?php echo $campaign_id; ?>" />
	<input type="hidden" id="campaign" name="campaign" value="<?php echo $campaign; ?>" />
<div id="mid-col" class="mid-col">
<div class="box">
                <h4 class="white">CAMPAIGN DELETE </h4>
        <div class="box-container" >
		
		
		<br />
		 <h>Are you sure you want to delete <?php echo $cname;  ?>  record?</h>
		<div style="float:right;">
		

	<a class="button" href="javascript:document.listings.submit();" ><span>Yes</span></a>
		<input type="hidden" value="Yes Delete >>" id="yes" name="yes"/>	
	
	<a class="button" href=" campaign2.php<?php $_SESSION[$db_prefix.'_GM'] = " Campaign deletion cancelled."; 
		?>" ><span>No</span></a>
		
	</div>
	<br />
	<br />
    </div>
	</div>
	</div>
	
</form>
<?php include($site_root."includes/footer.php"); ?>
