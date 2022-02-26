<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "bulk_messages.php";
	$page_title = "Bulk Messages";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Bulk Messages";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>


<?php
		include_once('lib/nusoap.php');

	   	include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();

?>
<?php include($site_root."includes/header.php"); ?>

<div class="box">
	<h4 class="white"> <?php echo $page_title; ?> </h4>
	<div class="box-container">
		<iframe src="http://10.4.29.224:90/IFramePage.aspx" title="Bulk Messages" style="width:100%; height:260px;"></iframe>
	</div>
</div>

<?php include($site_admin_root."includes/footer.php"); ?>

