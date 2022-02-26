<?php include_once("includes/config.php"); ?>
<?php
$page_name = "abandon_calls.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Abandon Calls";
$page_menu_title = "Abandon Calls";
?>

<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/reports.php");
$reports = new reports();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();

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
	}
</script>

<?php
$ttl_record = 0;
$today = date("YmdHms");


if (isset($_REQUEST['search_date'])) {
	$keywords            = $_REQUEST['keywords'];
	$search_keyword                 = $_REQUEST['search_keyword'];
	$fdate                 = $_REQUEST['fdate'];
	$tdate                 = $_REQUEST['tdate'];

	$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
} else {
	$fdate             = empty($_REQUEST["fdate"]) ? date('Y-m-d') : $_REQUEST["fdate"];
	$tdate             = empty($_REQUEST["tdate"]) ? date('Y-m-d') : $_REQUEST["tdate"];
	$static_stime     =   "00:00:00";
	$static_etime     =   "23:59:59";

	$keywords         = empty($_REQUEST["keywords"]) ? "" : $_REQUEST["keywords"];
	$search_keyword         = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}
$fdate = date('Y-m-d', strtotime($fdate));
$tdate = date('Y-m-d', strtotime($tdate));

$fdateTime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
$tdateTime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;

?>
<?php

$field = empty($_REQUEST["field"]) ? "call_datetime" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "desc" : $_REQUEST["order"];


$rs = $reports->iget_aband_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdateTime, $tdateTime, $search_keyword, $keywords, 1, $today);
?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Abandoned Calls </div>
<div>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
		<div class="box">
			<?php
			$form_type = "iaband";
			include($site_admin_root . "includes/search_form.php");
			include($site_admin_root . "includes/date_hour_search_bar.php");
			?>
		</div>
		<br />
		<div id="mid-col" class="mid-col">
			<div class="box">
				<h4 class="white"><?php echo ($page_title); ?></h4>

				<div class="box-container">
					<table class=" table-short" id="tbl">
						<thead>
							<tr>
								<td> Caller ID</td>
								<td> Date</td>
								<td> Time</td>
								<td> Call ID</td>
							</tr>
						</thead>
						<tbody>
							<?php while (!$rs->EOF) { ?>
								<tr class="odd">

									<td><?php echo $rs->fields["caller_id"]; ?></td>

									<td class="col-first"><?php echo ($rs->fields["update_date"]); ?> </td>
									<td class="col-first"><?php echo date("h:i:s a", strtotime($rs->fields["update_time"])); ?> </td>
									<?php $wrs = $reports->iget_fullname($rs->fields["staff_id"]); ?>

									<!-- <td class="col-first"><?php echo $wrs->fields["full_name"]; ?> </td>-->

									<?php
									$rsw = $user_tools->get_call_workcodes($rs->fields['unique_id']);
									$i = 1;
									$workcodes = "";
									while (!$rsw->EOF) {
										$workcodes .= "\r\n" . $i . "- " . $rsw->fields['workcodes'];
										$i++;
										$rsw->MoveNext();
									}
									?>

									<td>
										<?php echo $rs->fields["unique_id"]; ?>
									</td>

								</tr>
							<?php
								$rs->MoveNext();
								$ttl_record++;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>


<script>
	$(document).ready(function() {
		$('#tbl').DataTable({
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
			dom: 'lfrtpiB',
			buttons: [{
					extend: "copy",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
				}, {
					extend: "csv",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
				}, {
					extend: "excel",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
				}, {
					extend: "pdf",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
				}, {
					extend: "print",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>'
				},

			]
		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>