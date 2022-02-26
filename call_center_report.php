<?php include_once("includes/config.php"); ?>
<?php
$page_name = "call_center_report.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Call Center Report";
$page_menu_title = "Call Center Report";
?>

<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/admin.php");
$admin = new admin();

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


<?php


if (isset($_REQUEST['search_date'])) {
	$search_keyword         = $_REQUEST['search_keyword'];
	$fdate                          = $_REQUEST['fdate'];
	$tdate                          = $_REQUEST['tdate'];
	$static_stime = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
	$fdatetime                      = $_REQUEST["fdate"] . " " . $static_stime;
	$tdatetime                      = $_REQUEST["tdate"] . " " . $static_etime;
	echo "&nbsp;&nbsp;From: <b>" . $_REQUEST["fdate"] . " " . $static_stime . "</b> ";
	echo "To: <b>" . $_REQUEST["tdate"] . " " . $static_etime . "</b><br>";
} else {
	$fdate                  = empty($_REQUEST["fdate"]) ? date('Y-m-d') : $_REQUEST["fdate"];
	$tdate                  = empty($_REQUEST["tdate"]) ? date('Y-m-d') : $_REQUEST["tdate"];
	$search_keyword = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}

$fdate = date('Y-m-d H:i:s', strtotime($fdate));
$tdate = date('Y-m-d H:i:s', strtotime($tdate));

if (!empty($fdatetime) && !empty($tdatetime)) {
	$fdatetime = date('Y-m-d H:i:s', strtotime($fdatetime));
	$tdatetime = date('Y-m-d H:i:s', strtotime($tdatetime));
} else {
	$fdatetime = date('Y-m-d') . ' 00:00:00';
	$tdatetime = date('Y-m-d') . ' 23:59:59';
}


$nature_of_calls                = $reports->nature_of_calls($fdatetime, $tdatetime);
$drop_calls                     = $reports->drop_calls($fdatetime, $tdatetime);
$abandon_calls                 = $reports->abandon_new_calls($fdatetime, $tdatetime);
$total_talk_time                = $reports->total_talk_time($fdatetime, $tdatetime);
$busy_time                      = $reports->busy_time($fdatetime, $tdatetime);
$avg_busy_time                  = $reports->avg_busy_time($fdatetime, $tdatetime);
$average_queue_time     = $reports->average_queue_time($fdatetime, $tdatetime);
$avg_total_talk_time    = $reports->avg_total_talk_time($fdatetime, $tdatetime);
$pin_report                     = $reports->pin_report($fdatetime, $tdatetime);
$trans_report                   = $reports->trans_report($fdatetime, $tdatetime);
?>

<?php

$recStartFrom = 0;
$field = empty($_REQUEST["field"]) ? "staff_updated_date" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "asc" : $_REQUEST["order"];
$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, '', '');
$groups = $reports->get_evaluation_groups();

$evaluated_call_counts = $reports->get_evaluated_calls_count($search_keyword, $fdate, $tdate);

?>


<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Call Center Statistics</div>

<div>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">

		<div id="mid-col" class="mid-col">
			<div class="box">

				<h4 class="white">
					<table>
						<tr>
							<td style="padding-right:5px">
								From Date :
							</td>
							<td>
								<label>
									<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo  date('d-m-Y', strtotime($fdate)); ?>" autocomplete="off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">
								</label>
							</td>
							<td style="padding-left:20px">

								<select name="static_shours">
									<?php for ($i = 0; $i <= 23; $i++) { ?>
										<option id="sh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>"><?php echo $static_hours_array[$i]; ?></option>
									<?php } ?>
								</select>
								&nbsp;
								<select name="static_sminutes">
									<?php for ($i = 0; $i <= 59; $i++) { ?>
										<option id="sm<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>"><?php echo $static_minutes_array[$i]; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<td style="padding-top:10px">
								To Date :
							</td>
							<td>
								<label>
									<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo  date('d-m-Y', strtotime($tdate)); ?>" autocomplete="off" readonly="readonly" onclick="javascript:NewCssCal ('tdate','ddMMyyyy', 'dropdown')">
								</label>
							</td>
							<td style="padding-left:20px">

								<select name="static_ehours">
									<?php for ($i = 0; $i <= 23; $i++) { ?>
										<option id="eh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>" <?php echo ($static_hours_array[$i] == "23") ? "selected" : "" ?>><?php echo $static_hours_array[$i]; ?></option>
									<?php } ?>
								</select>
								&nbsp;
								<select name="static_eminutes">
									<?php for ($i = 0; $i <= 59; $i++) { ?>
										<option id="em<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>" <?php echo ($static_minutes_array[$i] == "59") ? "selected" : "" ?>><?php echo $static_minutes_array[$i]; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<a class="button" href="javascript:document.xForm.submit();">
									<span>Search</span>
								</a>
								<input type="hidden" value="Search >>" id="search_date" name="search_date" />
							</td>
						</tr>
					</table>

				</h4>


				<?php $break = 0; ?>
				<br />

				<br />

				<h4 class="white">
					<?php
					echo "Nature of Calls";
					$stringData .= "<tag1>Nature of Calls</tag1>\r\n";
					$stringData .= "<tag2>Call Type</tag2>,<tag2>Number of Calls</tag2>,<tag2>Percent</tag2>\r\n";
					?>
				</h4>
				<div class="box-container">
					<table id="tbl1" class="table-short">
						<thead>
							<tr>
								<td colspan="12" class="paging"><?php //echo($paging_block);
																								?></td>
							</tr>
							<tr>
								<td class="col-head2">Call Type</td>
								<td class="col-head2" style="padding-left:10px">Number of Calls </td>
								<td class="col-head2" style="padding-left:10px">Percent </td>

							</tr>
						</thead>

						<tbody>
							<?php
							$c1;
							$t_calls = 0;
							while (!$nature_of_calls->EOF) {
							?>
								<tr class="odd">

									<td class="col-first">
										<?php
										$t_calls =  $nature_of_calls->fields["total"];
										echo ($nature_of_calls->fields["call_type"]); ?> </td>
									<td class="col-first" style="padding-left:10px"><?php echo ($nature_of_calls->fields["total_calls"]); ?> </td>
									<td class="col-first" style="padding-left:10px"><?php echo (round($nature_of_calls->fields["percent"], 2) . "%"); ?> </td>
								</tr>
							<?php $nature_of_calls->MoveNext();
								$c1++;
							} ?>
							<tr class="odd">
								<td class="col-first">Total :</td>
								<td class="col-first" style="padding-left:10px">
									<?php $stringData .= "Total: ," . $t_calls . ",\r\n";
									echo ($t_calls); ?>
								</td>
								<td class="col-first" style="padding-left:10px">
									&nbsp
								</td>

							</tr>
						</tbody>
					</table>
				</div>

				<br />

				<h4 class="white">
					<?php
					echo "Drop Calls: ";
					$stringData .= "<tag1a>Drop Calls: " . $drop_calls->fields['drop_calls'] . "</tag1a>\r\n";
					?>

					<?php echo ($drop_calls->fields["drop_calls"]); ?>
				</h4>

				<br />

				<h4 class="white">
					<?php
					echo "Abandoned Calls: ";
					$stringData .= "<tag1a>Abandoned Calls: " . $abandon_calls->fields['abandon_calls'] . "</tag1a>\r\n";
					?>

					<?php echo ($abandon_calls->fields["abandon_calls"]); ?>
				</h4>


				<br />

				<h4 class="white">
					<?php
					echo "Total Talk Time";
					$stringData .= "<tag1>Total Talk Time</tag1>\r\n";
					$stringData .= "<tag2>Call Type</tag2>,<tag2>Talk Time</tag2>\r\n";
					?>
				</h4>
				<div class="box-container">
					<table class="table-short" id="tbl2">
						<thead>
							<tr>
								<td colspan="12" class="paging"><?php //echo($paging_block);
																								?></td>
							</tr>
							<tr>
								<td class="col-head2">Call Type</td>
								<!--<td class="col-head2" style="padding-left:10px">Number of Calls </td>-->
								<td class="col-head2" style="padding-left:10px">Talk Time </td>
								<!--<td class="col-head2" style="padding-left:10px">Busy Time </td>-->


							</tr>
						</thead>

						<tbody>
							<?php
							$c2;

							$no_calls = 0;
							while (!$total_talk_time->EOF) {
								$stringData .= $total_talk_time->fields['call_type'] . "," . $total_talk_time->fields['talk_time'] . "," . $busy_time->fields['busy_time'] . "\r\n";
							?>
								<tr class="odd">

									<td class="col-first">
										<?php
										$no_calls =  $total_talk_time->fields["total_time"];
										echo ($total_talk_time->fields["call_type"]); ?> </td>

									<td class="col-first" style="padding-left:10px"><?php echo ($total_talk_time->fields["talk_time"]); ?> </td>

								</tr>
							<?php $total_talk_time->MoveNext();
								$busy_time->MoveNext();
								$c2++;
							} ?>
							<tr class="odd">
								<td class="col-first">Total :</td>
								<td class="col-first" style="padding-left:10px">
									<?php $stringData .= "Total: ," . $no_calls . ",\r\n";
									echo ($no_calls); ?>
								</td>
								<!--<td class="col-first" style="padding-left:10px">-->
								&nbsp
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<br />

				<h4 class="white">
					<?php
					echo "AVG Total Talk Time";
					$stringData .= "<tag1>AVG Total Talk Time</tag1>\r\n";
					$stringData .= "<tag2>Call Type</tag2>,<tag2>Talk Time</tag2>\r\n";
					?>
				</h4>
				<div class="box-container">
					<table class="table-short" id="tbl3">
						<thead>
							<tr>
								<td colspan="12" class="paging"><?php //echo($paging_block);
																								?></td>
							</tr>
							<tr>
								<td class="col-head2">Call Type</td>
								<!--<td class="col-head2" style="padding-left:10px">Number of Calls </td>-->
								<td class="col-head2" style="padding-left:10px">Talk Time </td>
								<!--<td class="col-head2" style="padding-left:10px">Busy Time </td>-->


							</tr>
						</thead>

						<tbody>
							<?php
							$c3;

							$no_calls = 0;
							while (!$avg_total_talk_time->EOF) {
								$stringData .= $avg_total_talk_time->fields["call_type"] . "," . $avg_total_talk_time->fields["talk_time"] . "," . $avg_busy_time->fields["AvgBusyTime"] . "\r\n";
							?>
								<tr class="odd">

									<td class="col-first">
										<?php
										$no_calls =  $avg_total_talk_time->fields["total_time"];
										echo ($avg_total_talk_time->fields["call_type"]); ?> </td>
									<!--<td class="col-first" style="padding-left:10px"><?php //echo($avg_total_talk_time->fields["no_of_calls"]); 
																																			?> </td>-->
									<td class="col-first" style="padding-left:10px"><?php echo ($avg_total_talk_time->fields["talk_time"]); ?> </td>
									<!--<td class="col-first" style="padding-left:10px"><?php echo ($avg_busy_time->fields["AvgBusyTime"]); ?> </td>-->
								</tr>
							<?php $avg_total_talk_time->MoveNext();
								$avg_busy_time->MoveNext();
								$c3++;
							} ?>
							<tr class="odd">
								<td class="col-first"></td>
								<td class="col-first" style="padding-left:10px">
									<?php //$stringData .= "Total: ,".$no_calls.",\r\n"; echo($no_calls); 
									?>
								</td>
								<!--<td class="col-first" style="padding-left:10px">-->
								&nbsp
								</td>
							</tr>
						</tbody>
					</table>
				</div>

				<br />
				<h4 class="white">
					<?php
					echo "AVG HOLD TIME: ";
					$I_new = $reports->get_agent_hold_times_new_live_agents('', $fdatetime, $tdatetime);
					$I = $I_new->fields["hold_time"];
					$J_new = $reports->get_agent_hold_calls('', $fdatetime, $tdatetime);
					$J = $J_new->fields["hold_calls"];

					$fpos1 = strpos($I, ':', 0);
					$fpos2 = strpos($I, ':', $fpos1 + 1);
					$hour = substr($I, 0, $fpos1);
					$min = substr($I, $fpos1 + 1, $fpos2 - $fpos1 - 1);
					$sec = substr($I, $fpos2 + 1);

					$firsttime = ($hour * 3600) + ($min * 60) + $sec;
					$avgholdsec = $firsttime / $J;

					$hours = floor($avgholdsec / 3600);
					$avgholdsec -= $hours * 3600;
					$minutes  = floor($avgholdsec / 60);
					$avgholdsec -= $minutes * 60;
					$seconds = $avgholdsec;

					$avg = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

					$stringData .= "<tag1a>AVG HOLD TIME: " . $avg . "</tag1a>\r\n";
					?>

					<?php echo $avg; ?>
				</h4>


				<br />

				<!--JD inline 22 dec 2014-->
				<h4 style="display:none;" class="white">
					<?php
					echo "Average Queue Time: ";
					$stringData .= "<tag1a>Average Queue Time: " . $average_queue_time->fields['avg_queu_time'] . "</tag1a>\r\n";
					?>

					<?php echo ($average_queue_time->fields["avg_queu_time"]); ?>
				</h4>

				<br />
				<!--JD inline 22 dec 2014-->
				<h4 style="display:none;" class="white">
					<?php
					echo "Pins Generated";
					$stringData .= "<tag1>Pins Generated</tag1>\r\n";
					$stringData .= "<tag2>Pin Type</tag2>,<tag2>No of Pins</tag2>,<tag2>Percent</tag2>\r\n";
					?>
				</h4>
				<div style="display:none;" class="box-container">
					<table class="table-short">
						<thead>
							<tr>
								<td colspan="12" class="paging"><?php //echo($paging_block);
																								?></td>
							</tr>
							<tr>
								<td class="col-head2">Pin Type</td>
								<!--<td class="col-head2" style="padding-left:10px">Number of Calls </td>-->
								<td class="col-head2" style="padding-left:10px">No of Pins</td>
								<td class="col-head2" style="padding-left:10px">Percent</td>


							</tr>
						</thead>

						<tbody>
							<?php
							$total = 0;
							while (!$pin_report->EOF) {
								$stringData .= $pin_report->fields['pin_type'] . "," . $pin_report->fields['no_pins'] . "," . $pin_report->fields['percent'] . "\r\n";
							?>
								<tr class="odd">

									<td class="col-first"><?php
																				$total =  $pin_report->fields["total"];
																				echo ($pin_report->fields["pin_type"]); ?> </td>
									<td class="col-first" style="padding-left:10px"><?php echo ($pin_report->fields["no_pins"]); ?> </td>
									<td class="col-first" style="padding-left:10px"><?php echo ($pin_report->fields["percent"]); ?> </td>

								</tr>
							<?php $pin_report->MoveNext();
							} ?>
							<tr class="odd">
								<td class="col-first">Total :</td>
								<td class="col-first" style="padding-left:10px">
									<?php $stringData .= "Total: ," . $total . ",\r\n";
									echo ($total); ?>
								</td>
								<td class="col-first" style="padding-left:10px">
									&nbsp
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<br />

				<h4 style="display:none;" class="white">
					<?php
					echo "Transactions Executed";
					$stringData .= "<tag1>Transactions Executed</tag1>\r\n";
					$stringData .= "<tag2>Transaction Type</tag2>,<tag2>No of Transactions</tag2>,<tag2>Percent</tag2>\r\n";
					?>
				</h4>
				<div style="display:none;" class="box-container">
					<table class="table-short">
						<thead>
							<tr>
								<td colspan="12" class="paging"><?php //echo($paging_block);
																								?></td>
							</tr>
							<tr>
								<td class="col-head2">Transaction Type</td>
								<!--<td class="col-head2" style="padding-left:10px">Number of Calls </td>-->
								<td class="col-head2" style="padding-left:10px">No of Transactions</td>
								<td class="col-head2" style="padding-left:10px">Percent</td>


							</tr>
						</thead>

						<tbody>
							<?php
							$total = 0;
							while (!$trans_report->EOF) {
								$stringData .= $trans_report->fields['trans_type'] . "," . $trans_report->fields['no_trans'] . "," . $trans_report->fields['percent'] . "\r\n";
							?>
								<tr class="odd">

									<td class="col-first"><?php
																				$total =  $trans_report->fields["total"];
																				echo ($trans_report->fields["trans_type"]); ?> </td>
									<td class="col-first" style="padding-left:10px"><?php echo ($trans_report->fields["no_trans"]); ?> </td>
									<td class="col-first" style="padding-left:10px"><?php echo ($trans_report->fields["percent"]); ?> </td>

								</tr>
							<?php $trans_report->MoveNext();
							} ?>
							<tr class="odd">
								<td class="col-first">Total :</td>
								<td class="col-first" style="padding-left:10px">
									<?php $stringData .= "Total: ," . $total . ",\r\n";
									echo ($total); ?>
								</td>
								<td class="col-first" style="padding-left:10px">
									&nbsp
								</td>
							</tr>
						</tbody>
					</table>
				</div>


			</div>


		</div>

	</form>

	<form action="call_center_xl_report.php" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2">
		<div style="float:right;">
			<a class="button" href="javascript:document.xForm2.submit();"><span>Export EXCEL</span></a>
			<input type="hidden" value="export_xl" id="export_xl" name="export_xl" />
			<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword" name="search_keyword" />
			<input type="hidden" value="<?php echo $tdatetime; ?>" id="tdatetime" name="tdatetime" />
			<input type="hidden" value="<?php echo $fdatetime; ?>" id="fdatetime" name="fdatetime" />
		</div>
	</form>
	<form action="call_center_Pdf_report.php" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">
		<div style="float:right;">
			<a href="javascript:document.xForm3.submit();" class="button"><span>Export PDF</span> </a>
			<input type="hidden" value="export_pdf" id="export_pdf" name="export_pdf" />
			<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword" name="search_keyword" />
			<input type="hidden" value="<?php echo $tdatetime; ?>" id="tdatetime" name="tdatetime" />
			<input type="hidden" value="<?php echo $fdatetime; ?>" id="fdatetime" name="fdatetime" />
		</div>
	</form>
</div>
</div>
<script>
	$(document).ready(function() {
		$('#tbl1').DataTable({
			"language": {
				"emptyTable": "No data available",
				"lengthMenu": "Show _MENU_ records",
				"info": "Showing _START_ to _END_ of _TOTAL_ records",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"infoEmpty": "No records available",
			},
			dom: 'lfrtpi',

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
			dom: 'lfrtpi',

		});
	});

	$(document).ready(function() {
		$('#tbl3').DataTable({
			"language": {
				"emptyTable": "No data available",
				"lengthMenu": "Show _MENU_ records",
				"info": "Showing _START_ to _END_ of _TOTAL_ records",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"infoEmpty": "No records available",
			},
			dom: 'lfrtpi',

		});
	});
</script>

<?php include($site_admin_root . "includes/footer.php"); ?>
