<?php include_once("includes/config.php"); ?>
<?php
$page_name = "icdr-stats.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "CDR Stats";
$page_menu_title = "CDR Stats";
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
	.flex-container {
		display: flex;
		flex-direction: column;
		justify-items: center;
		align-items: center;
		vertical-align: center;
	}

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
$today = date("YmdHms");
if (isset($_REQUEST['search_date'])) {
	$keywords         = $_REQUEST['keywords'];
	$search_keyword   = $_REQUEST['search_keyword'];
	$fdate            = $_REQUEST['fdate'];
	$tdate            = $_REQUEST['tdate'];

	$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
} else {
	$fdate             = empty($_REQUEST["fdate"]) ? date('d-m-Y') : $_REQUEST["fdate"];
	$tdate             = empty($_REQUEST["tdate"]) ? date('d-m-Y') : $_REQUEST["tdate"];
	$static_stime   =     "00:00:00";
	$static_etime   =     "23:59:59";

	$keywords          = empty($_REQUEST["keywords"]) ? "" : $_REQUEST["keywords"];
	$search_keyword    = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}

$fdate        = date('Y-m-d', strtotime($fdate));
$tdate        = date('Y-m-d', strtotime($tdate));

$fdateTime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
$tdateTime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;

echo "<b>"
?>
<?php

$ttl_record = 0;


$field = empty($_REQUEST["field"]) ? "call_datetime" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "desc" : $_REQUEST["order"];


$rs = $reports->iget_records_pdf(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdateTime, $tdateTime, $search_keyword, $keywords, 1);

?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Call Records</div>
<div>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
		<div class="box">
			<?php
			$form_type = "icdr";
			include($site_admin_root . "includes/search_form.php");
			include($site_admin_root . "includes/date_hour_search_bar.php");
			?>
		</div>
		<br />
		<div id="mid-col" class="mid-col">
			<div class="box">
				<h4 class="white"><?php echo ($page_title); ?></h4>
				<table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">

				</table>
				<div class="box-container">
					<table class="table-short" id="tbl">
						<thead style="text-align: center;">
							<tr>
								<td>Caller Id</td>
								<td>Date</td>
								<td>Time</td>
								<td>Duration</td>
								<td>Agent Name</td>
								<td>Play/Download</td>

								<?php $rs_agent_name = $admin->get_agent_name($_SESSION[$db_prefix . '_UserId']); ?>

								<?php if ($rs_agent_name->fields["department"] == "QA") { ?>
									<td class="col-head2" style="width:12%; text-align: center;">
										Rating
									</td>
								<?php } ?>

							</tr>
						</thead>
						<tbody style="text-align: center;">
							<?php while (!$rs->EOF) {  //date('Ymd',strtotime($rs->fields["call_date"])); 
							?>
								<tr class="odd">
									<?php $split = explode('-', $rs->fields["call_date"]); ?>
									<td style="width:15%; text-align: center; vertical-align: middle;
                                    padding-top: 50px;" class="col-first"><a href="call_detail.php?unique_id=<?php echo $rs->fields["unique_id"]; ?>&id=<?php echo $rs->fields["id"]; ?>"><?php echo $rs->fields["caller_id"]; ?></a></td>
									<td style="width:18%; text-align: center; vertical-align: middle;
                                    padding-top: 50px;" class="col-first"><?php echo $rs->fields["call_datetime"] // date('d-m-Y', strtotime($rs->fields["call_date"])) //$rs->fields["call_date"]; //;
																																					?> </td>
									<td style="width:15%; text-align: center; vertical-align: middle;
                                    padding-top: 50px;" class="col-first"><?php echo $rs->fields["call_time"]; //date("g:i s", strtotime($rs->fields["call_time"])); 
																																					?> </td>
									<td style="width:15%; text-align: center; vertical-align: middle;
                                    padding-top: 50px;" class="col-first"><?php echo $rs->fields["call_duration"]; ?> </td>
									<td style="width:15%; text-align: center; vertical-align: middle;
                                    padding-top: 50px;" class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>



									<td class="col-first" style="padding-top: 35px; padding-bottom: 30px;">
										<audio controls style="width: 145px; margin: 10px 10px -20px 10px;">
											<source src="recording/<?php echo $rs->fields["unique_id"]; ?>.wav"><?php echo $rs->fields["caller_id"]; ?>
										</audio>
									</td>


									<?php if ($rs_agent_name->fields["department"] == "QA") { ?>

										<td class="col-first d-flex flex-container" style="width: 20%;padding-top: 50px; flex-direction: row; border: none;">
											<div class="">
												<select name="rating" id="rating" class="rating">
													<option value="a">A</option>
													<option value="b">B</option>
													<option value="c">C</option>
												</select>
											</div>
											<div class="">
												<a class="button" href="#">
													<span>Submit</span>
												</a>
											</div>
										</td>
									<?php } ?>

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
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				}, {
					extend: "csv",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				}, {
					extend: "excel",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				}, {
					extend: "pdf",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				}, {
					extend: "print",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				},

			]
		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>