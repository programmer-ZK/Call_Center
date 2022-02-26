<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "inquiry_stats.php";
	$page_title = "Inquiry Report";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Inquiry Report";
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
		<iframe src="http://10.4.29.224:90/IFrameDailyCallsReport.aspx" title="Inquiry report" style="width:100%; height:260px;"></iframe>
	</div>
</div>

<?php include($site_admin_root."includes/footer.php"); ?>

