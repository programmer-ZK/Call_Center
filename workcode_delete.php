<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "workcode_delete";
	$page_title = "Delete Workcode ";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Delete Workcode";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php include($site_root."includes/header.php"); ?>
<?php
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();

	include_once("classes/work_codes.php");
	$work_codes = new work_codes();
?>

<?php
	$agent_id 			= $_SESSION[$db_prefix.'_UserId'];
	$parent_id       	= $tools_admin->decryptId($_REQUEST['parent_id']);
	$workcode_id       	= $tools_admin->decryptId($_REQUEST['workcode_id']);
	$parent_name     	= $_REQUEST['parent_name'];
	$workcode_title		= $_REQUEST['detail'];
	
	if($rsAdmin->EOF){
		$_SESSION[$db_prefix.'_RM'] = "Workcode deletion rejected or not found.";
		header ("Location: workcodes_list.php");
		exit();
	}
	

	if(isset($_REQUEST["yes"]) && !empty($_REQUEST["yes"])){
		$workcode_title		= $_REQUEST['workcode_title'];
		$work_codes->delete_workcodes($workcode_title, $workcode_id, $agent_id);
		$_SESSION[$db_prefix.'_GM'] = "[".$workcode_title."]  inactive successfully.";
		header ("Location: workcodes_list.php");
		exit();
	}
	if(isset($_REQUEST["no"]) && !empty($_REQUEST["no"])){
	$workcode_title		= $_REQUEST['workcode_title'];
		$_SESSION[$db_prefix.'_GM'] = "[".$workcode_title."]  deletion cancelled.";
		header ("Location: workcodes_list.php");
		exit();
	}
?>
<form name="listings" id="listings" action="<?php echo($page_name);?>.php" method="post" >
			<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $tools_admin->encryptId($parent_id); ?>"> 
			<input type="hidden" name="workcode_id" id="workcode_id" value="<?php echo $tools_admin->encryptId($workcode_id); ?>"> 
			<input type="hidden" name="workcode_title" id="workcode_title" value="<?php echo $workcode_title; ?>">
<div id="mid-col" class="mid-col">
<div class="box">
                <h4 class="white">Are you sure you want to delete <?php echo $workcode_title;  ?>  record?</h4>
        <div class="box-container" >
		<br />
		<div style="float:right;">
		<input type="submit" id="yes" name="yes" value="Yes"  class="buttonstyle"/>
        <input type="submit" id="no" name="no" value="No"  class="buttonstyle"/> </div>
		<br />
		<br />
    </div>
	</div>
	</div>
	
</form>
<?php include($site_root."includes/footer.php"); ?>
