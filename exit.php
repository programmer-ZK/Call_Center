<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "call_hangup.php";
	$page_title = "Call Hangup.php";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Call Hangup.php";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/work_codes.php");
	$work_codes = new work_codes();
	
?>
<?php include($site_root."includes/iheader.php");

?>
<form name="form1" class="middle-forms cmxform">
<h3>Please Click Here To Go Home</h3>
<input onclick="closeAndRefresh();" type="button" name="SubmitButton" value="Home">
</form>
<script type="text/javascript">
function closeAndRefresh() {
if (window.opener &&!window.opener.closed) {
window.opener.document.location='index.php';
window.close();
}
}
</script> 
<?php include($site_root."includes/ifooter.php"); ?> 
