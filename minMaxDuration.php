<?php include_once("includes/config.php"); ?>
<?php
$page_name = "minMaxDuration.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Min Max Call Duration";
$page_menu_title = "Min Max Call Duration";
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

if (isset($_REQUEST["fdate"]) && isset($_REQUEST["tdate"])) {
	$fdate            = $_REQUEST['fdate'];
	$tdate            = $_REQUEST['tdate'];

	$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
} else {
	$fdate             =  date('d-m-Y');
	$tdate             =   date('d-m-Y');
	$static_stime      =     "00:00:00";
	$static_etime      =     "23:59:59";
}


$fdatetime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
$tdatetime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;


/************************* Export to Excel ******************/
if (isset($_REQUEST['export'])) {

	$stringData	= trim($_REQUEST['stringData']);
	$stringData = str_replace('<tag1>', null, $stringData);
	$stringData = str_replace('</tag1>', null, $stringData);
	$stringData = str_replace('<tag2>', null, $stringData);
	$stringData = str_replace('</tag2>', null, $stringData);
	$db_export_fix = $site_root . "download/MIN_MAX_Call_REPORT.csv";
	shell_exec("echo '" . $stringData . "' > " . $db_export_fix);
	ob_end_clean();
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private", false);
	//header("Content-type: application/force-download");
	header("Content-Type: text/csv");

	//echo $db_export; exit;
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
	$db_export_fix = $site_root . "download/MIN_MAX_Call_REPORT.csv";
	shell_exec("echo '" . $stringData . "' > " . $db_export_fix);
	ob_end_clean();
	$tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 12, 'Recieved_dropped_Report.pdf', 'D', 40, 10, 1);
	exit();
}

/******************************************************************************/


?>
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Min Max Call Duration Report</div>

<div>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
		<div class="box">
			<?php include($site_admin_root . "includes/date_hour_search_bar.php");
			$stringData	 = '';
			?>
		</div>
		<br />
		<?php

		$fdate = date("Y-m-d", strtotime($fdate));
		$tdate = date("Y-m-d", strtotime($tdate));

		$stringData .= "<tag1>Min Call Duration</tag1>\r\n";

		include($site_admin_root . "minCallDuration.php");
		$stringData .= "<tag1>Max Call Duration</tag1>\r\n";
		?>
		<br />
		<?php include($site_admin_root . "maxCallDuration.php");
		?>
	</form>
	
</div>
</div>
</div>

</div>
<script>
	$(document).ready(function() {
		$('#tbl').DataTable({
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
					title: "MINIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "csv",
					title: "MINIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "excel",
					title: "MINIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "pdf",
					title: "MINIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "print",
					title: "MINIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c1; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				},

			]
		});
	});

	$(document).ready(function() {
		$('#tbl2').DataTable({
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
					title: "MAXMIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c2; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "csv",
					title: "MAXMIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c2; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "excel",
					title: "MAXMIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c2; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "pdf",
					title: "MAXMIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c2; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				}, {
					extend: "print",
					title: "MAXMIMUM CALL DURATION",
					messageBottom: '<?php echo  "Total numbe of records : " . $c2; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				},

			]
		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>