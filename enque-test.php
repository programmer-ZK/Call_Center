<?php include_once("includes/config.php"); ?>
<?php
        $pageName = 'summary_report.php';
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Summary Report";
        $page_menu_title = "Summary Report";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	//include_once("classes/reports.php");
	//$reports = new reports();
	
	//include_once("classes/all_agent.php");

   //$all_agent = new all_agent();
   //phpinfo();	
?>
<?php include($site_root."includes/header.php"); ?>
<!--<meta http-equiv="refresh" content="2">-->

<html>
<head>
</head>
<body>
<div>
<table>
  <thead>
    <tr>
      <td  class="col-head2">Enqueue CGGT</td>
    </tr>
  </thead>
  <tbody>
    <tr class="odd">
      <td><?php /* Enqueue */
		echo $inqueue_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) AND status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')' ); ?></td>
    </tr>
  </tbody>
</table>
</body>
</html>
