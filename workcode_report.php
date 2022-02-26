<?php include_once("includes/config.php"); ?>
<?php
$page_name = "workcode_report.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Work Code Report";
$page_menu_title = "Work Code Report";
?>

<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/reports.php");
$reports = new reports();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();

include_once("classes/admin.php");
$admin = new admin();

include_once("classes/user_tools.php");
$user_tools = new user_tools();
?>
<?php include($site_root . "includes/header.php"); ?>

<style>
	input[type="search"],
	.dt-buttons,
	.dataTables_length {
		margin-top: 10px;
	}
</style>
<script type="text/javascript" language="javascript1.2">
	function showWorkCode(wc) {
		if (wc || 0 !== wc.length) {
			alert(wc);

		} else {
			alert("No work code available!");

		}
		return false;
	}
</script>

<?php

$today = date("YmdHms");

if (isset($_REQUEST['search_date'])) {
	$keywords			= $_REQUEST['keywords'];
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];

	$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
} else {
	$fdate 			= empty($_REQUEST["fdate"]) ? date('Y-m-d') : $_REQUEST["fdate"];
	$tdate 			= empty($_REQUEST["tdate"]) ? date('Y-m-d') : $_REQUEST["tdate"];

	$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";

	$keywords 		= empty($_REQUEST["keywords"]) ? "" : $_REQUEST["keywords"];
	$search_keyword = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}
$fdate = date('Y-m-d', strtotime($fdate));
$tdate = date('Y-m-d', strtotime($tdate));

$fdateTime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
$tdateTime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;


// echo $fdateTime;
// echo "<br>";
// echo $tdateTime;
// echo "<br>";

?>
<?php

$field = empty($_REQUEST["field"]) ? "staff_updated_date" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "desc" : $_REQUEST["order"];

$rs = $reports->get_workcode_details($field, $order, $fdateTime, $tdateTime, $search_keyword, $keywords, false, $today);
?>


<div>

	<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Work Code Report</div>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
		<div class="box">

			<?php
			$form_type = "workcode_report";
			include($site_admin_root . "includes/search_form.php");
			include($site_admin_root . "includes/date_hour_search_bar.php");
			?>
	</form>
</div>
<br />
<div id="mid-col" class="mid-col" style="height:730px;">
	<div class="box">
		<h4 class="white"><?php echo ($page_title); ?></h4>


		<div class="box-container">
			<table class="table-short" id="tbl">
				<thead>
					<td> Tracking ID</td>
					<td> Caller ID</td>
					<td> Call Type</td>
					<td> WorkCode</td>
					<td> Agent Name</td>
					<td> Date Time</td>
				</thead>
				<tbody>
					<?php while (!$rs->EOF) { ?>
						<tr class="odd">
							<td class="col-first"><?php echo trim($rs->fields["unique_id"]); ?> </td>
							<td class="col-first"><?php echo trim(substr($rs->fields["caller_id"], 0, 11)); ?> </td>
							<td class="col-first" style="width:11%;"><?php echo trim($rs->fields["customer_id"]); ?> </td>
							<td class="col-first" style="width:7%;text-align:center;"><?php echo trim(substr($rs->fields["call_type"], 0, 1)); ?> </td>
							<td class="col-first"><?php echo trim($rs->fields['workcodes']); ?></td>

							<td class="col-first"><?php echo trim($rs->fields["agent_name"]); ?> </td>
							<td class="col-first"><?php echo trim(date('d-m-Y h:i:s A', strtotime($rs->fields["staff_updated_date"]))); ?> </td>
							<td class="col-first"><?php echo $rs->fields["detail"]; ?> </td>

						</tr>
					<?php $rs->MoveNext();
					} ?>
				</tbody>
			</table>
		</div>

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
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>