<?php include_once("includes/config.php"); ?>
<?php
$page_name = "callAnsTime.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Call Answer Time";
$page_menu_title = "Call Answer Time";
?>

<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/admin.php");
$admin = new admin();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();
?>
<?php include($site_root . "includes/header.php"); ?>
<style>
	input[type="search"],
	.dt-buttons,
	.dataTables_length {
		margin-top: 10px;
	}
</style>
<?php

$recStartFrom = 0;
$field = empty($_REQUEST["field"]) ? "staff_updated_date" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "asc" : $_REQUEST["order"];
$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>

<?php

if (isset($_REQUEST['search_date'])) {
	$static_stime = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";

	$fdatetime 			= $_REQUEST["fdate"] . " " . $static_stime;
	$tdatetime	 		= $_REQUEST["tdate"] . " " . $static_etime;
	$search_keyword	 	= $_REQUEST["search_keyword"];
} else {
	$fdate            =     date('Y-m-d');
	$tdate            =     date('Y-m-d');
	$static_stime     =     "00:00:00";
	$static_etime     =     "23:59:59";
	$search_keyword	 	=     "";
}


/************************* Export to Excel ******************/
if (isset($_REQUEST['export'])) {

	$stringData	= trim($_REQUEST['stringData']);
	$stringData = str_replace('<tag1>', null, $stringData);
	$stringData = str_replace('</tag1>', null, $stringData);
	$stringData = str_replace('<tag2>', null, $stringData);
	$stringData = str_replace('</tag2>', null, $stringData);
	$stringData = str_replace('<tag3>', null, $stringData);
	$stringData = str_replace('</tag3>', null, $stringData);

	$db_export_fix = $site_root . "download/Recieved_dropped_Report.csv";
	shell_exec("echo '" . $stringData . "' > " . $db_export_fix);
	ob_end_clean();
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
	header("Content-Type: text/csv");

	header("Content-Disposition: attachment; filename=" . basename($db_export_fix) . ";");
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: " . filesize($db_export_fix));
	readfile($db_export_fix);
	if (file_exists($db_export_fix) && !empty($file_name)) {
		unlink($db_export_fix);
	}
	exit();
}

if (isset($_REQUEST['export_pdf'])) {

	$stringData			= $_REQUEST['stringData'];
	$db_export_fix = $site_root . "download/Recieved_dropped_Report.csv";
	shell_exec("echo '" . $stringData . "' > " . $db_export_fix);
	ob_end_clean();
	$tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 12, 'Recieved_dropped_Report.pdf', 'D', 40, 10, 1);
	exit();
}

/******************************************************************************/


?>
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Call Answer Time Report</div>

<div>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
		<div class="box">
			<?php include($site_admin_root . "includes/date_hour_search_bar.php");
			$stringData	 = '';
			?>
		</div>
		<br />
		<?php
		$stringData .= "<tag1>Received Calls Stats</tag1>\r\n";

		include($site_admin_root . "call_Ans_Time_stats.php");

		$stringData .= "<tag1>Drop Calls Stats</tag1>\r\n";
		?>
		<br />
		<?php include($site_admin_root . "drop_call_stats.php");

		?>
		<br />



	</form>

</div>
<script>
	$(document).ready(function() {
		$('#tbl').DataTable({
			"order": [
				[3, "desc"],
				[4, "desc"]

			],
			"language": {
				"emptyTable": "No data available",
				"lengthMenu": "Show _MENU_ records",
				"info": "Showing _START_ to _END_ of _TOTAL_ records",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"infoEmpty": "No records available",
			},
			dom: 'lfrtpiB',
			buttons: [{
					extend: "copy",
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "csv",
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "excel",
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "pdf",
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "print",
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				},

			]
		});
	});

	$(document).ready(function() {
		$('#tbl2').DataTable({
			"order": [
				[3, "desc"],
				[4, "desc"]
			],
			"language": {
				"emptyTable": "No data available",
				"lengthMenu": "Show _MENU_ records",
				"info": "Showing _START_ to _END_ of _TOTAL_ records",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"infoEmpty": "No records available",
			},
			dom: 'lfrtpiB',
			buttons: [{
					extend: "copy",
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c3; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "csv",
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c3; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "excel",
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c3; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "pdf",
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c3; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "print",
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total numbe of records : " . $c3; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				},

			]
		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>