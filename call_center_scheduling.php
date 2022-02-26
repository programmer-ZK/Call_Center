<?php include_once("includes/config.php"); ?>
<?php
$page_name = "call_center_scheduling";
$page_title = "Call Ceneter Login & logoff Time";
$page_level = "2";
$page_group_id = "1";
$page_menu_title = "Call Ceneter Login & logoff Time";
?>
<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/quick_links.php");
$quick_links = new quick_links();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();
include_once("classes/reports.php");
$reports = new reports();
?>
<?php include($site_root . "includes/header.php"); ?>
<style>
	input[type="search"],
	.dt-buttons,
	.dataTables_length {
		margin-top: 10px;
	}
</style>

<script type="text/javascript">
	function getHtml4Excel() {
		document.getElementById("gethtml1").value = document.getElementById("agent_pd_report2").innerHTML;
	}
</script>
<?php
$ttl_record = 0;


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

?>
<?php

$count_type = "link";

$field = empty($_REQUEST["field"]) ? "title" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "desc" : $_REQUEST["order"];

$total_records_count = $reports->count_call_center_timings($fdateTime, $tdateTime, $recStartFrom, $page_records_limit, $field, $order);
include_once("includes/paging.php");

$rs = $reports->get_call_center_timings($fdateTime, $tdateTime, $recStartFrom, $page_records_limit, $field, $order);

?>
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">IVR Time Records</div>


<form action="<?php echo ($page_name); ?>.php" method="post" name="xForm" id="xForm">
	<div class="box">

		<?php include($site_admin_root . "includes/date_hour_search_bar.php"); ?>
	</div>
	<br />

	<div id="agent_pd_report2">
		<div id="mid-col" class="mid-col">
			<div class="box">
				<h4 class="white" style="margin-bottom: 13px;"><?php echo ($page_title); ?></h4>
				<div class="box-container" style="overflow:hidden">
					<table class="table-short" id="keywords" style="margin-bottom: 13px;">
						<thead>
							<tr>
								<td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
							</tr>
							<tr>
								<td class="col-head">Status</td>
								<td class="col-first">Date Time</td>
							</tr>
						</thead>
						<tbody>
							<?php
							while (!$rs->EOF) { ?>
								<tr class="odd">
									<td height="50px" class="col-first">
										<?php $status = $rs->fields["status"];
										if ($status == '0') {
											echo "925000";
										} else {
											echo "925111";
										} ?>
									</td>

									<td height="50px" class="col-first">
										<?php echo $rs->fields["end_time"];
										?>
									</td>

								</tr>
							<?php
								$rs->MoveNext();
								$ttl_record++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</form>
</div>
<script>
	$(document).ready(function() {
		$('#keywords').DataTable({
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
<?php include($site_root . "includes/footer.php"); ?>