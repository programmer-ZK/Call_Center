<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "quick_links_delete";
	$page_title = "Delete Quick Links";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Delete Quick Links";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php include($site_root."includes/header.php"); ?>
<?php
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();

	include_once("classes/quick_links.php");
	$quick_links = new quick_links();
?>

<?php
	$link_id 		= 	$_REQUEST['link_id'];
	$rsLink  		= 	$quick_links->get_links_by_id($link_id);
	if($rsAdmin->EOF){
		$_SESSION[$db_prefix.'_RM'] = "Links deletion rejected or not found.";
		header ("Location: quick_links_list.php");
		exit();
	}
	$link_title 		= 	$rsLink->fields['title'];

	if(isset($_REQUEST["yes"]) && !empty($_REQUEST["yes"])){
		$quick_links->delete_link($link_id);
		$_SESSION[$db_prefix.'_GM'] = "[".$link_title."] Link inactive successfully.";
		header ("Location: quick_links_list.php");
		exit();
	}
	if(isset($_REQUEST["no"]) && !empty($_REQUEST["no"])){
		$_SESSION[$db_prefix.'_GM'] = "[".$link_title."] Link deletion cancelled.";
		header ("Location: quick_links_list.php");
		exit();
	}
?>
<form name="listings" id="listings" action="<?php echo($page_name);?>.php" method="post" >
	<input type="hidden" id="link_id" name="link_id" value="<?php echo $link_id; ?>" />
<div id="mid-col" class="mid-col">
<div class="box">
                <h4 class="white">Are you sure you want to delete <?php echo $link_title;  ?>  link?</h4>
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
