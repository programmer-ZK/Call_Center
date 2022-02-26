<?php include_once("includes/config.php"); ?>
<?php
$page_name = "daily-stats.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Daily Stats";
$page_menu_title = "Daily Stats";
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
$order = empty($_REQUEST["order"]) ? "desc" : $_REQUEST["order"];
$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>

<?php
if (isset($_REQUEST['search_date'])) {
	$keywords         = $_REQUEST['keywords'];
	$search_keyword   = $_REQUEST['search_keyword'];
	$fdate            = $_REQUEST['fdate'];
	$tdate            = $_REQUEST['tdate'];

	$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";

	$fdatetime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
	$tdatetime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;
} else {
	$fdate             =  date('d-m-Y');
	$tdate             =   date('d-m-Y');
	$static_stime      =     "00:00:00";
	$static_etime      =     "23:59:59";

	$fdatetime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
	$tdatetime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;

	$keywords          = empty($_REQUEST["keywords"]) ? "0" : $_REQUEST["keywords"];
	$search_keyword    = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}

?>
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Daily Report</div>

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

		include($site_admin_root . "queue_wait_stats.php");

		$stringData .= "<tag1>Drop Calls Stats</tag1>\r\n";
		?>

		<br />
		<?php include($site_admin_root . "drop_call_stats.php");
		$stringData .= "<tag1>Off Time Calls Stats</tag1>\r\n";
		?>
		<br />

		<br />
		<?php include($site_admin_root . "aband_call_stats.php");
		$stringData .= "<tag1>Abandon Calls Stats</tag1>\r\n";
		?>
		<br />


	</form>

</div>




<form action="daily_stats_xls_report.php" method="post" class="middle-forms cmxform" 
				name="xForm2" id="xForm2">
	<div style="float:right;">
		<a class="button" href="javascript:document.xForm2.submit();"><span>Export EXCEL</span></a>
		<input type="hidden" value="export_xl" id="export_xl" name="export_xl" />
		<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword" name="search_keyword" />
		<input type="hidden" value="<?php echo $keywords; ?>" id="keywords" name="keywords" />
		<input type="hidden" value="<?php echo $tdatetime; ?>" id="tdatetime" name="tdatetime" />
		<input type="hidden" value="<?php echo $fdatetime; ?>" id="fdatetime" name="fdatetime" />
	</div>
</form>
<form action="daily_stats_Pdf_report.php" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">
	<div style="float:right;">
		<a href="javascript:document.xForm3.submit();" class="button" ><span>Export PDF</span> </a>
		<input type="hidden" value="export_pdf" id="export_pdf" name="export_pdf" />
		<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword" name="search_keyword" />
		<input type="hidden" value="<?php echo $keywords; ?>" id="keywords" name="keywords" />
		<input type="hidden" value="<?php echo $tdatetime; ?>" id="tdatetime" name="tdatetime" />
		<input type="hidden" value="<?php echo $fdatetime; ?>" id="fdatetime" name="fdatetime" />
	</div>
</form>


<script>

	$(document).ready(function() {
		$('#tbl').DataTable({
			"order": [
				[3, "desc"]
			],
			"language": {
				"emptyTable": "No data available",
				"lengthMenu": "Show _MENU_ records",
				"info": "Showing _START_ to _END_ of _TOTAL_ records",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"infoEmpty": "No records available",
			},
			dom: 'lfrtp',
	 
		});
	});

	$(document).ready(function() {
		$('#tbl2').DataTable({
			"order": [
				[3, "desc"]
			],
			"language": {
				"emptyTable": "No data available",
				"lengthMenu": "Show _MENU_ records",
				"info": "Showing _START_ to _END_ of _TOTAL_ records",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"infoEmpty": "No records available",
			},
			dom: 'lfrtp',
		 
		});
	});

	$(document).ready(function() {
		$('#tbl3').DataTable({
			"order": [
				[1, "desc"]
			],
			"language": {
				"emptyTable": "No data available",
				"lengthMenu": "Show _MENU_ records",
				"info": "Showing _START_ to _END_ of _TOTAL_ records",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"infoEmpty": "No records available",
			},
			dom: 'lfrtp',
			
		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>