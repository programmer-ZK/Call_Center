<?php include_once("includes/config.php"); ?>
<?php
$page_name = "breakRecord.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Break Records";
$page_menu_title = "Break Records’ ";
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
	#dateDiv tbody td a {
		display: none;
	}

	#tbl td {
		text-align: center !important;
	}

	.dataTables_paginate {
		margin-bottom: 10px;
	}

	#tbl tfoot td {
		font-weight: bolder !important;
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
	if (isset($_REQUEST['fdate'])) {
		$search_keyword		=  $_REQUEST["search_keyword"];
		$fdate 				= date('Y-m-d', strtotime($_REQUEST['fdate']));
		$tdate 				= date('Y-m-d', strtotime($_REQUEST['tdate']));
		$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
		$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
	} else {
		$fdate 			=  date('Y-m-d');
		$tdate 			=  date('Y-m-d');

		$static_stime     =  "00:00:00";
		$static_etime     =  "23:59:59";
		$search_keyword		=  0;
	}


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
					</h4>

					<br />

					<div id="agent_pd_report">
						<? if (isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])) { ?>
							<h4 class="white">
								<?php
								$rs_agent_name = $admin->get_agent_name($search_keyword);
								echo "Break Record  <br> Agent Name - " . $rs_agent_name->fields["full_name"] . " <br> Department- " . $rs_agent_name->fields["department"] . " <br> Date: " . $fdate  . " - " . $tdate . " <br> Time: " . $static_stime  . " - " . $static_etime;
								?>
							</h4>
							<br />

							<br />
							<!-- ******************************  Agent Break Times SUM ************************** -->
							<?php ?>

							<h4 class="white" style=" margin-bottom: 13px;"><?php echo "Break Times Summary"; ?></h4>

							<div class="box-container">


								<table class="table-short" id="tbl" style=" margin-bottom: 13px;">
									<thead>
										<tr>

											<td>&nbsp;</td>
											<td>Time</td>
											<td>&nbsp;</td>
											<td class="col-head2">Namaz Break</td>
											<td class="col-head2">Lunch Break</td>
											<td class="col-head2">Tea Break</td>
											<td class="col-head2">Auxiliary Break</td>
											<td class="col-head2">After Call Work (ACW)</td>
											<td class="col-head2">TOTAL TIME</td>

										</tr>
									</thead>

									<?php
									$arr_names 	= array("Namaz Break", "Lunch Break", "Tea Break", "Auxiliary Break", "After Call Work (ACW)", "Campaign");
									$arr_values = array('2', '3', '4', '5', '6', '7');


									date_default_timezone_set('GMT+5');
									$sdtime = $static_stime;
									$setime = date('H:i:s', strtotime('+29 minutes +59 seconds', strtotime($static_stime)));
									$stime = date("H:i:s", strtotime($sdtime));
									$etime = date("H:i:s", strtotime($setime));
									$count = 0;
									?>

									<tbody>

										<?php while (true) {

											$rs1 = $reports->iget_all_breaks($search_keyword, $fdate, $tdate, $stime, $etime, 2);
											$rs2 = $reports->iget_all_breaks($search_keyword, $fdate, $tdate, $stime, $etime, 3);
											$rs3 = $reports->iget_all_breaks($search_keyword, $fdate, $tdate, $stime, $etime, 4);
											$rs4 = $reports->iget_all_breaks($search_keyword, $fdate, $tdate, $stime, $etime, 5);
											$rs5 = $reports->iget_all_breaks($search_keyword, $fdate, $tdate, $stime, $etime, 6);
											$rs6 = $reports->iget_all_breaks_sum($search_keyword, $fdate, $tdate, $stime, $etime);

											$namaz_break =   !empty($rs1->fields["duration"]) ? $rs1->fields["duration"] : "-";
											$lunch_break =   !empty($rs2->fields["duration"]) ? $rs2->fields["duration"] : "-";
											$tea_break 	 =   !empty($rs3->fields["duration"]) ? $rs3->fields["duration"] : "-";
											$aux_break 	 =   !empty($rs4->fields["duration"]) ? $rs4->fields["duration"] : "-";
											$acw_break 	 =   !empty($rs5->fields["duration"]) ? $rs5->fields["duration"] : "-";
											$ttl_break 	 =   !empty($rs6->fields["duration"]) ? $rs6->fields["duration"] : "-";
										?>
											<tr>

												<td><?php echo $stime; ?></td>
												<td>:</td>
												<td><?php echo $etime; ?></td>
												<td><?php echo $namaz_break ?></td>
												<td><?php echo $lunch_break ?></td>
												<td><?php echo $tea_break ?></td>
												<td><?php echo $aux_break ?></td>
												<td><?php echo $acw_break ?></td>
												<td><?php echo $ttl_break ?></td>

											</tr>

										<?php

											if ($etime >= $static_etime) {
												break;
											}

											$stime = date('H:i:s', strtotime('+30 minutes', strtotime($stime)));
											$etime = date('H:i:s', strtotime('+30 minutes', strtotime($etime)));
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
<?php
$mgsTop = "Report generate Time - " . date("d-m-Y H:i:s") . "                                 " . "Agent Name - " . $rs_agent_name->fields["full_name"] . "                                        " . "Department- " . $rs_agent_name->fields["department"] . "                                                             " . "Date- " . $fdate . " - " . $tdate  . "                                                               " . "Time- " . $static_stime . " - " . $static_etime;
?>
<script>
	$(document).ready(function() {
		$('#tbl').DataTable({
			aLengthMenu: [
				[25, 50, 100, 200, -1],
				[25, 50, 100, 200, "All"]
			],
			iDisplayLength: -1,
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
					messageTop: '<?= $mgsTop ?>',
					exportOptions: {
						rows: ':visible',
						alignment: 'center'
					}
				}, {
					extend: "csv",
					messageTop: '<?= $mgsTop ?>',
					exportOptions: {
						rows: ':visible',
						alignment: 'center'
					}
				}, {
					extend: "excel",
					messageTop: '<?= $mgsTop ?>',
					exportOptions: {
						rows: ':visible',
						alignment: 'center'
					}
				}, {
					extend: "pdf",
					messageTop: '<?= $mgsTop ?>',
					exportOptions: {
						rows: ':visible'
					},
					customize: function(doc) {
						doc.styles.tableBodyEven.alignment = 'center';
						doc.styles.tableBodyOdd.alignment = 'center';
						doc.styles.tableFoot = 'center';
					}
				}, {
					extend: "print",
					messageTop: '<?= $mgsTop ?>',
					exportOptions: {
						rows: ':visible',
						alignment: 'center'
					}
				},

			]
		});
	});
</script>

</html>