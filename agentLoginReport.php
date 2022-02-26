<?php include_once("includes/config.php"); ?>
<?php
$page_name = "agentLoginReport.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Agent Login Report";
$page_menu_title = "Agent Login Report";
?>

<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/admin.php");
$admin = new admin();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();

include_once("classes/reports.php");
$reports = new reports();

include_once("classes/all_agent.php");

$all_agent = new all_agent();
?>
<?php include($site_root . "includes/header.php"); ?>

<style>
	input[type="search"],
	.dt-buttons,
	.dataTables_length {
		margin-top: 10px;
	}

	#dateDiv tbody td a {
		display: none;
	}
</style>
<html>

<head>
	<script type="text/javascript">
		function getHtml4Excel() {
			document.getElementById("gethtml1").value = document.getElementById("agent_pd_report").innerHTML;
		}
	</script>
</head>

<body>

	<?php
	if (isset($_REQUEST['search_date'])) {
		$search_keyword		= $_REQUEST['search_keyword'];
		$fdate 				= $_REQUEST['fdate'];
		$tdate 				= $_REQUEST['tdate'];
		$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
		$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
	} else {
		$fdate 			=     empty($_REQUEST["fdate"]) ? date('Y-m-d') : $_REQUEST["fdate"];
		$tdate 			=     empty($_REQUEST["tdate"]) ? date('Y-m-d') : $_REQUEST["tdate"];
		$static_stime   =     "00:00:00";
		$static_etime   =     "23:59:59";
		$search_keyword = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
	}

	$fdateTime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
	$tdateTime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;

	$ttl_record = 0;
	?>

	<?php

	$recStartFrom = 0;
	$field = empty($_REQUEST["field"]) ? "staff_updated_date" : $_REQUEST["field"];
	$order = empty($_REQUEST["order"]) ? "asc" : $_REQUEST["order"];
	$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
	?>



	<div>
		<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" onsubmit="">

			<div id="mid-col" class="mid-col">
				<div class="box">

					<h4 class="white">
						<div>
							<div id="dateDiv">
								<?php include($site_admin_root . "includes/date_hour_search_bar.php"); ?>
							</div>


							<div>
								<br>
								<br>
								<label>

									<?php echo $tools_admin->getcombo("admin", "search_keyword", "admin_id", "full_name", $search_keyword, false, "form-select", "", "Agent", " designation = 'Agents' "); ?>
								</label>
								<a class="button" href="javascript:document.xForm.submit();">
									<span>Search</span>
								</a>
								<input type="hidden" value="Search >>" id="search_date" name="search_date" />
								<div>
								</div>
							</div>
						</div>
					</h4>

					<br />

					<div id="agent_pd_report">
						<? if (isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])) {  ?>
							<h4 class="white">
								<?php
								$rs_agent_name = $admin->get_agent_name($search_keyword);
								echo "Agent Login Report  <br> Agent Name - " . $rs_agent_name->fields["full_name"] . " <br> Department- " . $rs_agent_name->fields["department"] . " <br> Date: " . $fdate . " - " . $tdate;
								?></h4>
							<br />
							<h4 class="white" style="margin-bottom: 13px;">
								<?php

								echo "Working Times";
								?></h4>
							<?php
							$fdate = date('Y-m-d', strtotime($fdate));
							$tdate = date('Y-m-d', strtotime($tdate));
							$rs_w_t = $reports->get_agent_work_times_new_live($search_keyword, $fdateTime, $tdateTime);
							$trec = $rs_w_t->fields["trec"]; ?>

							<div class="box-container">

								<table class="table-short" id="keywords" style="margin-bottom: 13px;">
									<thead>
										<tr>
											<td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
										</tr>
										<tr>
											<td class="col-head2">Agent Name</td>
											<td class="col-head2">Online Time</td>
											<td class="col-head2">Offline Time</td>
											<td class="col-head2">Time Duration</td>

										</tr>
									</thead>
						
									<tbody>
										<?php
										$sum_worktime = "00:00:00";
										while (!$rs_w_t->EOF) { ?>
											<tr class="odd">
												<td class="col-first">
													<?php
													$name = $reports->get_agents_name($rs_w_t->fields["staff_id"]);
													while (!$name->EOF) {
														echo $name->fields['full_name'];
														$name->MoveNext();
													}
													$login_time =  ($rs_w_t->fields["max_logout_time"] == $rs_w_t->fields["login_time"]) ? '<span style="color:red">Logged In</span>' : date("Y-m-d H:i:s", strtotime($rs_w_t->fields["logout_time"]))
													?>
												</td>
												<td class="col-first">
													<?php echo date("Y-m-d H:i:s", strtotime($rs_w_t->fields["login_time"])); ?>
												</td>
												<td class="col-first">
													<?php echo $login_time; ?>
												</td>
												<td class="col-first">
													<?php $A = $rs_w_t->fields["duration"];
													$sum_worktime =	$tools_admin->sum_the_time($sum_worktime, $rs_w_t->fields["duration"]);
													echo ($rs_w_t->fields["duration"]); ?>
												</td>

											</tr>
										<?php
											$rs_w_t->MoveNext();
											$ttl_record++;
										} ?>
									</tbody>
								</table>

							</div>
							<br />

		</form>
	<? } ?>
	</div>
	</div>

	</div>
	</div>
	<?php include($site_admin_root . "includes/footer.php"); ?>
</body>
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

</html>