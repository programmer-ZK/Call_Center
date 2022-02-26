<?php include_once("includes/config.php"); ?>

<?php 
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
?>
<?php
		$page   	= $_REQUEST['page'];
		$param_1   	= $_REQUEST['param_1'];
		$fundcode   	= $_REQUEST['param_2'];
		
		$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
		$account_no	= $tools_admin->decryptId($_REQUEST['account_no']);
		
		//$customer_id	= '16069';
		//$account_no		= '16069';

?>
<?php include($site_root."includes/iheader.php"); ?>
<?php include($site_root."includes/user_fund_balance_summary.php"); ?>
<?php include($site_root."includes/ifooter.php"); ?>
