<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "templates_delete";
	$page_title = "Delete Template";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Delete Template";
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
	$template_id 		= 	$_REQUEST['template_id'];
	$template	 		= 	$_REQUEST['template'];
	
	
	
	$rsTemplate  		= 	$templates->get_template_by_id($template_id, $template);
	
	if($rsTemplate->EOF){
		$_SESSION[$db_prefix.'_RM'] = " Template deletion rejected or not found.";
		header ("Location: templates.php?template=".$template);
		exit();
	}
	
	$title 		= 	$rsTemplate->fields['title'];
	
	if(isset($_REQUEST["yes"]) && !empty($_REQUEST["yes"])){
		$templates->delete_template($template_id, $template);
		$_SESSION[$db_prefix.'_GM'] = "[".$title."] Template inactive successfully.";
		header ("Location: templates.php?template=".$template);
		exit();
	}
	if(isset($_REQUEST["no"]) && !empty($_REQUEST["no"])){
		$_SESSION[$db_prefix.'_GM'] = "[".$title."] Template deletion cancelled.";
		header ("Location: templates.php?template=".$template);
		exit();
	}
?>
<form name="listings" id="listings" action="<?php echo($page_name);?>.php" method="post" >
	<input type="hidden" id="template_id" name="template_id" value="<?php echo $template_id; ?>" />
	<input type="hidden" id="template" name="template" value="<?php echo $template; ?>" />
<div id="mid-col" class="mid-col">
<div class="box">
                <h4 class="white">Are you sure you want to delete <?php echo $title;  ?>  record?</h4>
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
