<?php include_once("includes/config.php"); ?>



<?php
$page_name = "categoryRecordsCount.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Category Records Count";
$page_menu_title = "Category Records Count";
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
	#tbl td {
		text-align: center !important;
	}

	.dataTables_paginate {
		margin-bottom: 10px;
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
		$search_keyword  = $_REQUEST['search_keyword'];
		$daily 				   = $_REQUEST['day'];
		$startweek 		   = $_REQUEST['startweek'];
		$endweek 				 = $_REQUEST['endweek'];
		$month 				   = $_REQUEST['month'];
		$year 				   = $_REQUEST['year'];
		$filter		 		   = $_REQUEST['filter'];
	} else {
		$daily 			     = empty($_REQUEST["day"]) ? date('Y-m-d') : $_REQUEST["day"];
		$startweek 	     = empty($_REQUEST["startweek"]) ? date('Y-m-d') : $_REQUEST["startweek"];
		$endweek 		     = empty($_REQUEST["endweek"]) ? date('Y-m-d') : $_REQUEST["endweek"];
		$month 			     = empty($_REQUEST["month"]) ? date('Y-m-d') : $_REQUEST["month"];
		$year 			     = empty($_REQUEST["year"]) ? date('Y-m-d') : $_REQUEST["year"];
		$search_keyword  = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
	}

	if ($filter == 'yearly') {
		$exDate  =	date('Y', strtotime($_REQUEST["year"]));
	};

	if ($filter == 'monthly') {
		$exDate  = date('F Y', strtotime($_REQUEST["month"]));
	};

	if ($filter == 'daily') {
		$exDate  = date('d-m-Y', strtotime($_REQUEST["day"]));
	};

	if ($filter == NULL) {
		$exDate  = date('d-m-Y');
	};


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
							Filter :
							<label>
								<select id="filter" name="filter">
									<option value="daily">Daily</option>
									<option value="monthly">Monthly</option>
									<option value="yearly">Yearly</option>
								</select>
							</label>
							<label>

								<select id="year" name="year" style='display:none'></select>
								<select id="month" name="month" style='display:none'></select>
								<select id="day" name="day"></select>
								<input type="date" name="startweek" id="sweek" value="<?= date('Y-m-d') ?>" class="txtbox-short-date" style="display:none;">
								<input type="date" name="endweek" id="eweek" value="<?= date('Y-m-d') ?>" class="txtbox-short-date" style="display:none;">

							</label>
							<div style="float:right;">
								<label>


									<a class="button" href="javascript:document.xForm.submit();">
										<span>Search</span>
									</a>
									<input type="hidden" value="Search >>" id="search_date" name="search_date" />
									<div>
									</div>
					</h4>

					<br />

					<div id="agent_pd_report">
						<? if (isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])) {  ?>
							<h4 class="white">
								<?php
								$rs_agent_name = $admin->get_agent_name($search_keyword);

								echo "Call Distribution Report<br> <br> Date: " . $daily;

								?></h4>
							<br />
							<h4 class="white" style=" margin-bottom: 13px;">
								<?php

								echo "$filter Call Record";
								?></h4>
							<?php

							$months = date('m', strtotime($month));
							$years = date('Y', strtotime($year));
							$startweekLoop = date('d', strtotime($startweek));
							$endweekLoop = date('d', strtotime($endweek));
							$startweek = date('Y-m', strtotime($startweek));
							$endweek = date('Y-m', strtotime($endweek));

							?>
							<div class="box-container">

								<table class="table-short" id="tbl" style=" margin-bottom: 13px;">
									<thead>
										<tr>
											<td class="col-head2"><?= $filter == 'monthly' ? 'Date' : ($filter == 'yearly' ? 'Month' : ($filter == 'weekly' ? 'Days' : 'Hours')) ?></td>
											<td class="col-head2">Inbound Calls</td>
											<td class="col-head2">Outbound Calls</td>
											<td class="col-head2">Total Calls</td>
											<?php $column = $filter == 'monthly' ? 'Date' : ($filter == 'yearly' ? 'Month' : ($filter == 'weekly' ? 'Days' : 'Hours')) ?>
										</tr>
									</thead>

									<tbody>
										<?php

										if ($filter == NULL || $filter == 'daily') {
											for ($i = 0; $i < 24; $i++) {
												$agent_inbound_calls    = $reports->daily_inbound_report($daily, $i);
												$agent_outbound_calls    = $reports->daily_outbound_report($daily, $i);
										?>
												<tr class="odd">
													<td class="col-first"><?php echo $i . ":00:00" . " : " . $i . ":59:59"; ?> </td>
													<td class="col-first"><?php echo $agent_inbound_calls; ?> </td>
													<td class="col-first"><?php echo $agent_outbound_calls; ?> </td>
													<td class="col-first"><?php echo $agent_inbound_calls + $agent_outbound_calls; ?> </td>
												</tr>
											<?php
												$ttl_inbound += $agent_inbound_calls;
												$ttl_outbound += $agent_outbound_calls;
												$totalValue += $agent_inbound_calls + $agent_outbound_calls;
											} ?>
									<tfoot>
										<tr>
											<td style="font-weight:bold;">Total: </td>
											<td style="font-weight:bold;"><?= $ttl_inbound ?></td>
											<td style="font-weight:bold;"><?= $ttl_outbound ?></td>
											<td style="font-weight:bold;"><?= $totalValue ?></td>
											<td></td>
										</tr>
									</tfoot>
									<?php
										} else if ($filter == 'monthly') {
											for ($i = 1; $i <= date("t", strtotime($month)); $i++) {
												$agent_inbound_calls    = $reports->monthly_inbound_report($months, $i);
												$agent_outbound_calls    = $reports->monthly_outbound_report($months, $i);
												$year_new = date("Y");
									?>
										<tr class="odd">
											<td class="col-first"><?php echo date("d-m-Y", strtotime($year_new . '-' . $months . '-' . $i)); ?> </td>
											<td class="col-first"><?php echo $agent_inbound_calls; ?> </td>
											<td class="col-first"><?php echo $agent_outbound_calls; ?> </td>
											<td class="col-first"><?php echo $agent_inbound_calls + $agent_outbound_calls; ?> </td>

										<?php
												$ttl_inbound += $agent_inbound_calls;
												$ttl_outbound += $agent_outbound_calls;
												$totalValue += $agent_inbound_calls + $agent_outbound_calls;
											} ?>
										<tfoot>
											<tr>
												<td style="font-weight:bold;">Total: </td>
												<td style="font-weight:bold;"><?= $ttl_inbound ?></td>
												<td style="font-weight:bold;"><?= $ttl_outbound ?></td>
												<td style="font-weight:bold;"><?= $totalValue ?></td>
											</tr>
										</tfoot>
										<?php

										} else if ($filter == 'yearly') {
											for ($i = 1; $i <= 12; $i++) {
												$agent_inbound_calls    = $reports->yearly_inbound_report($years, $i);
												$agent_outbound_calls    = $reports->yearly_outbound_report($years, $i);
										?>
										<tr class="odd">
											<td class="col-first"><?php echo DateTime::createFromFormat('!m', $i)->format('F'); ?> </td>
											<td class="col-first"><?php echo $agent_inbound_calls; ?> </td>
											<td class="col-first"><?php echo $agent_outbound_calls; ?> </td>
											<td class="col-first"><?php echo $agent_inbound_calls + $agent_outbound_calls; ?> </td>
										<?php
												$ttl_inbound += $agent_inbound_calls;
												$ttl_outbound += $agent_outbound_calls;
												$totalValue += $agent_inbound_calls + $agent_outbound_calls;
											} ?>
										<tfoot>
											<tr>
												<td style="font-weight:bold;">Total: </td>
												<td style="font-weight:bold;"><?= $ttl_inbound ?></td>
												<td style="font-weight:bold;"><?= $ttl_outbound ?></td>
												<td style="font-weight:bold;"><?= $totalValue ?></td>
											</tr>
										</tfoot>
										<?php
										} else if ($filter == 'weekly') {
											for ($i = $startweekLoop; $i <= $endweekLoop; $i++) {
												$agent_inbound_calls = $reports->weekly_inbound_report($startweek, $endweek, $i);
												$agent_outbound_calls = $reports->weekly_outbound_report($startweek, $endweek, $i);
												$date = date('Ym' . $i . '000000');
												$dayName = date("l", strtotime($date));

										?>
										<tr class="odd">
											<td class="col-first"><?php echo  $dayName; ?> </td>
											<td class="col-first"><?php echo $agent_inbound_calls; ?> </td>
											<td class="col-first"><?php echo $agent_outbound_calls; ?> </td>
											<td class="col-first"><?php echo $agent_inbound_calls + $agent_outbound_calls; ?> </td>
										<?php
												$ttl_inbound += $agent_inbound_calls;
												$ttl_outbound += $agent_outbound_calls;
												$totalValue += $agent_inbound_calls + $agent_outbound_calls;
											} ?>
										<tfoot>
											<tr>
												<td style="font-weight:bold;">Total: </td>
												<td style="font-weight:bold;"><?= $ttl_inbound ?></td>
												<td style="font-weight:bold;"><?= $ttl_outbound ?></td>
												<td style="font-weight:bold;"><?= $totalValue ?></td>
											</tr>
										</tfoot>
									<?php
										}
									?>


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


	<script>
		document.getElementById('filter').addEventListener('change', function() {
			var data = this.value;
			if (data == 'daily') {
				$('#day').show();
				$('#sweek').hide();
				$('#eweek').hide();
				$('#month').hide();
				$('#year').hide();
			} else if (data == 'weekly') {
				$('#day').hide();
				$('#sweek').show();
				$('#eweek').show();
				$('#month').hide();
				$('#year').hide();
			} else if (data == 'monthly') {
				$('#day').hide();
				$('#sweek').hide();
				$('#eweek').hide();
				$('#month').show();
				$('#year').hide();
			} else if (data == 'yearly') {
				$('#day').hide();
				$('#sweek').hide();
				$('#eweek').hide();
				$('#month').hide();
				$('#year').show();
			} else {

			}
		});
		day();
		month();
		year();

		function year() {
			let year_satart = 1940;
			let year_end = (new Date).getFullYear(); // current year
			var month = ((new Date).getMonth() + 1); // current month
			let day = (new Date).getDate(); // current day


			let year_selected = 'Year';

			let option = '';
			option = '<option selected>Year</option>'; // first option

			for (let i = year_satart; i <= year_end; i++) {
				// let selected = (i === year_selected ? ' selected' : '');
				option += '<option value="' + i + '-01-01' + '">' + i + '</option>';
			}

			document.getElementById("year").innerHTML = option;
		};

		function month() {
			let months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
			var month_selected = ((new Date).getMonth() + 1); // current month
			let year = (new Date).getFullYear(); // current year
			let day = (new Date).getDate(); // current day
			var option = '';
			option = '<option>Month</option>'; // first option

			for (let i = 0; i < months.length; i++) {
				let month_number = (i + 1);


				let month = (month_number <= 9) ? '0' + month_number : month_number;



				let selected = (i === month_selected ? ' selected' : '');
				option += '<option value="' + year + '-' + month + '-' + '01' + '"' + selected + '>' + months[i] + '</option>';
			}
			document.getElementById("month").innerHTML = option;
		};

		function day() {
			let day_selected = (new Date).getDate(); // current day
			var month = ((new Date).getMonth() + 1); // current month
			let year = (new Date).getFullYear(); // current year
			let option = '';
			option = '<option>Day</option>'; // first option

			for (let i = 1; i < 32; i++) {

				let day = (i <= 9) ? '0' + i : i;


				let selected = (i === day_selected ? ' selected' : '');
				option += '<option value="' + year + '-' + month + '-' + day + '"' + selected + '>' + day + '</option>';
			}
			document.getElementById("day").innerHTML = option;
		};
	</script>
</body>

<script>
	$(document).ready(function() {
		$('#tbl').DataTable({
			paginate: false,
			info: false,
			"language": {
				"emptyTable": "No data available",
				"lengthMenu": "Show _MENU_ records",
				"info": "Showing _START_ to _END_ of _TOTAL_ records",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"infoEmpty": "No records available",
			},
			dom: 'rtpiB',
			buttons: [{
					extend: "copy",
					footer: true,
					messageTop: '<?php echo  $exDate; ?>',
					exportOptions: {
						rows: ':visible'
					}
				}, {
					extend: "csv",
					footer: true,
					messageTop: '<?php echo  $exDate; ?>',
					exportOptions: {
						rows: ':visible'
					}
				}, {
					extend: "excel",
					footer: true,
					messageTop: '<?php echo  $exDate; ?>',
					exportOptions: {
						rows: ':visible'
					}
				}, {
					extend: "pdf",
					messageTop: '<?php echo $exDate  ?>',
					footer: true,
					exportOptions: {
						rows: ':visible'
					}
				}, {
					extend: "print",
					footer: true,
					messageTop: '<?php echo  $exDate; ?>',
					exportOptions: {
						rows: ':visible'
					}
				},

			]
		});
	});
</script>

</html>