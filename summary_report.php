<?php include_once("includes/config.php"); ?>
<?php
$pageName = 'summary_report.php';
$page_level = "0";
$page_group_id = "0";
$page_title = "Summary Report";
$page_menu_title = "Summary Report";
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
</style>
<html>

<head>


	<script type="text/javascript">
		function getHtml4Excel() {
			document.getElementById("f_date").value = document.getElementById("fdate").value;
			document.getElementById("t_date").value = document.getElementById("tdate").value;
			var e = document.getElementById("search_keyword");
			var strSearch = e.options[e.selectedIndex].value;
			document.getElementById("_search").value = strSearch;

			document.getElementById("gethtml1").value = document.getElementById("agent_pd_report").innerHTML;
		}
	</script>
</head>

<body>

	<?php
	$ttl_record = 0;
	$rs_agent_name = "";
	if (isset($_REQUEST['search_date'])) {
		$search_keyword		= $_REQUEST["search_keyword"];
		$fdate 				= $_REQUEST['fdate'];
		$tdate 				= $_REQUEST['tdate'];
	}

	?>
	<?php
	/************************* Export to Excel ******************/
	///******************************************************************************/


	$stringDatab	 = '';
	?>

	<div>

		<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" onsubmit="">

			<div id="mid-col" class="mid-col">
				<div class="box">
					<center>
						<h4>Summary Report</h4>
					</center>
					<h4 class="white">

						<div>
							From Date :
							<label>
								<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['fdate']) ? date('d-m-Y', strtotime($_REQUEST['fdate'])) : $fdate = date('d-m-Y'); ?>" autocomplete="off" readonly onClick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">
							</label>
							To Date:
							<label>
								<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['tdate']) ? date('d-m-Y', strtotime($_REQUEST['tdate'])) : $tdate = date('d-m-Y'); ?>" autocomplete="off" readonly onClick="javascript:NewCssCal ('tdate','ddMMyyyy', 'dropdown')">
							</label>
							<div style="">
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
		</form>
		<br />
		<style>
			#keywords {
				border-collapse: collapse;
				margin: 1em auto;
			}

			th,
			td {
				padding: 5px 10px;
				border: 1px solid #999;
				font-size: 12px;
			}

			th {
				background-color: #eee;
			}

			th[data-sort] {
				cursor: pointer;
			}

			/* just some random additional styles for a more real-world situation */
			#msg {
				color: #0a0;
				text-align: center;
			}

			td.name {
				font-weight: bold;
			}

			td.email {
				color: #666;
				text-decoration: underline;
			}

			/* zebra-striping seems to really slow down Opera sometimes */
			tr:nth-child(even)>td {
				background-color: #f9f9f7;
			}

			tr:nth-child(odd)>td {
				background-color: #ffffff;
			}

			.disabled {
				opacity: 0.5;
			}

			.pagination {
				display: inline-block;
				text-align: center;
				width: 100%;
				margin-bottom: 20px;
			}

			.pagination ul {
				display: inline-block;
				list-style: none;
			}

			.pagination ul li {
				display: inline-block;
				font-size: 14px;
				font-weight: bold;
				margin: 0 2px;
			}

			.pagination ul li a {
				color: #000;
				float: left;
				padding: 5px 10px;
				text-decoration: none;
				background: #fff;
				-webkit-transition: all 0.5s ease;
				-moz-transition: all 0.5s ease;
				-o-transition: all 0.5s ease;
				transition: all 0.5s ease;
			}

			.pagination ul li:hover a,
			.pagination ul li:focus a,
			.pagination ul li.active a {
				color: #a72c62;
			}

			#mid-col table>tbody>tr.red>td {
				background-color: red;
				color: white;
			}
		</style>
		<?php

		if (!empty($_REQUEST['fdate'])) {
			$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
			if ($page <= 0) $page = 1;
			$per_page = 50; // Set how many records do you want to display per page.
			$startpoint = ($page * $per_page) - $per_page;
			$search_keyword		= $_REQUEST["search_keyword"];
			$fdate 				= $_REQUEST['fdate'];
			$tdate 				= $_REQUEST['tdate'];

			$fdate = date('Y-m-d', strtotime($fdate));
			$tdate = date('Y-m-d', strtotime($tdate));
			$rs_agent_name = $admin->get_agent_summary($search_keyword, $fdate, $tdate, $startpoint, $per_page);
			$found_rows = $admin->found_rows();
		?>

			<div id="agent_pd_report">

				<br />

				<!-- ******************************  Agent On Call and Busy Times ************************** -->
				<h4 class="white" style="text-align:center; margin-bottom: 13px;"><?php echo "From: " . date('d-m-Y', strtotime($fdate)) . ' To ' . date('d-m-Y', strtotime($tdate)); ?></h4>

				<?php $stringData .= "<tag1>From</tag1>" . date('d-m-Y', strtotime($fdate)) . "<tag1> To </tag1>" . date('d-m-Y', strtotime($tdate)) . "\r\n"; ?>
				<div class="box-container tbl_resp">
					<?php //print_r($rs_agent_name->fields);
					?>

					<?php $stringData .= "<tag1></tag2>,<tag1></tag2>,<tag1></tag2><tag1>INBOUND CALL</tag1>,<tag1></tag2>, <tag1>OUTBOUND CALL</tag1>" . "\r\n"; ?>
					<?php $stringData .= "<tag2>DATE</tag2>,  <tag2>AGENT</tag2> , <tag2>NO</tag2>, <tag2>DURATION</tag2>, <tag2>NO</tag2>, <tag2>DURATION</tag2>, <tag2>DROP</tag2>, <tag2>BREAK</tag2>, <tag2>ACW</tag2>, <tag2>LOGIN TIME</tag2>, <tag2>BUSY TIME</tag2>, <tag2>TIME DURATION</tag2>, <tag2>LOGOUT TIME</tag2>, <tag2>DEPART</tag2>" . "\r\n"; ?>



					<table id="keywords" style="width: 100%;">
						<thead>
							<tr>
								<th colspan="2"><span></span></th>
								<th colspan="2"><span>INBOUND CALL</span></th>
								<th colspan="2"><span>OUTBOUND CALL</span></th>
								<th colspan="9"><span></span></th>
							</tr>
							<tr>
								<th><span>DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
								<th><span>AGENT</span></th>
								<th><span>NO</span></th>
								<th>DURATION</th>
								<th><span>NO</span></th>
								<th>DURATION</th>
								<th><span>DROP </span></th>
								<th><span>BREAK </span></th>
								<th><span>ACW</span></th>
								<th><span>HOLD TIME</th>
								<th><span>LOGIN TIME</span></th>
								<th><span>LOGOUT TIME</span></th>
								<th><span>DEPART</span> </th>
							</tr>
						</thead>

						<?php

						$total = array(
							'inbound_call_no' => '', 'inbound_call_duration' => '', 'outbound_call_no' => '', 'outbound_call_duration' => '',
							'abandon_calls' => '', 'droped_calls' => '', 'break_time' => '', 'assignment_time' => '', 'busy_duration' => '', 'login_duration' => ''
						);
						?>
						<tbody>
							<?php while (!$rs_agent_name->EOF) {
								$query_string = "?fdate=" . $fdate . "&tdate=" . $tdate . "&search_keyword=" . $rs_agent_name->fields['staff_id'];
								$rs_in_bound = $admin->get_agent_in_summary($rs_agent_name->fields['staff_id'], $rs_agent_name->fields['update_datetime']);
								$rs_out_bound = $admin->get_agent_ob_summary($rs_agent_name->fields['staff_id'], $rs_agent_name->fields['update_datetime']);
								$rs_login = $admin->get_agent_login_summary($rs_agent_name->fields['staff_id'], $rs_agent_name->fields['update_datetime']);
								$rs_break_assign = $admin->get_agent_break_assign_summary($rs_agent_name->fields['staff_id'], $rs_agent_name->fields['update_datetime']);
								$rs_drop_name = $admin->get_agent_drop_summary($rs_agent_name->fields['staff_id'], $rs_agent_name->fields['update_datetime']);
								$rs_abandoned = $admin->get_agent_abandoned_summary($rs_agent_name->fields['staff_id'], $rs_agent_name->fields['update_datetime']);
								$total['outbound_call_no'] += $rs_out_bound->fields['outbound_call_no'];
								$bd = $tools_admin->sum_the_time($rs_in_bound->fields['inbound_busy_duration'], $rs_out_bound->fields['outbound_busy_duration']);

								$rs_hold_time = $admin->get_agent_hold_new_time($rs_agent_name->fields['staff_id'], $rs_agent_name->fields['update_datetime']);

								$total['busy_duration'] += $tools_admin->sum_the_time($bd, '00:00:00');
								// }
								if (!empty($rs_out_bound->fields['outbound_call_duration'])) {
									$str_time2 = $rs_out_bound->fields['outbound_call_duration'];
									sscanf($str_time2, "%d:%d:%d", $hours, $minutes, $seconds);
									$time_seconds2 = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
									$total['outbound_call_duration'] += $time_seconds2;
								}

								$total['inbound_call_no'] += $rs_in_bound->fields['inbound_call_no'];

								if (!empty($rs_in_bound->fields['inbound_call_duration'])) {
									$str_time = $rs_in_bound->fields['inbound_call_duration'];
									sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
									$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
									$total['inbound_call_duration'] += $time_seconds;
								}

								$total['hold_time'] += $rs_hold_time->fields['hold_time'];

								if (!empty($rs_hold_time->fields['hold_time'])) {
									$str_time = $rs_hold_time->fields['hold_time'];
									sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
									$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
									$total['hold_time'] += $time_seconds;
								}

								$total['abandon_calls'] += $rs_abandoned->fields['abandon_calls'];
								$total['droped_calls'] += $rs_drop_name->fields['droped_calls'];

								if (!empty($rs_break_assign->fields['break_time'])) {
									$str_time = ($rs_break_assign->fields['break_time']) ? $rs_break_assign->fields['break_time'] : '00:00:00';
									sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
									$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
									$total['break_time'] += $time_seconds;
								}
								if (!empty($rs_break_assign->fields['assignment_time'])) {
									$str_time = $rs_break_assign->fields['assignment_time'];
									sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
									$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
									$total['assignment_time'] += $time_seconds;
								}

								$bd = $tools_admin->sum_the_time($rs_in_bound->fields['inbound_busy_duration'], $rs_out_bound->fields['outbound_busy_duration']);
								$str_time = $bd;
								sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
								$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
								$total['busy_duration'] += $time_seconds;
								$bd = $time_seconds;  // mad change time format 12-03-2016



							?>
								<tr class="odd">
									<td><?php echo date('d-m-Y', strtotime($rs_agent_name->fields['update_datetime']));  ?></td>
									<td><?php echo $rs_drop_name->fields['full_name'];  ?></td>
									<td><a style="color:blue;" href="javascript:;" onClick="window.open('inbound-calls.php<?php echo $query_string; ?>','_blank','width=1000, height=1000,scrollbars=yes');"><?php echo $rs_in_bound->fields['inbound_call_no'];  ?></a></td>
									<td><?php echo $rs_in_bound->fields['inbound_call_duration'];  ?></td>
									<td><a style="color:blue;" target="_blank" href="out-bound-calls.php<?php echo $query_string; ?>"><?php echo $rs_out_bound->fields['outbound_call_no']; ?></a></td>
									<td><?php echo $rs_out_bound->fields['outbound_call_duration']; ?></td>
									<td><a style="color:blue;" target="_blank" href="dropped-calls.php<?php echo $query_string; ?>"><?php echo $rs_drop_name->fields['droped_calls'];  ?></a></td>
									<td><?php echo $rs_break_assign->fields['break_time'];  ?></td>
									<td><?php echo $rs_break_assign->fields['assignment_time']; ?></td>
									<td><?php echo $rs_hold_time->fields['hold_time']; ?></td>
									<td><?php echo $rs_login->fields['login_time'];  ?></td>

									<td><?php if ($rs_agent_name->fields['update_datetime'] == date('Y-m-d') && $rs_drop_name->fields['is_crm_login'] != 0) {
												echo '<span style="color:red">Logged In</span>';
											} else {
												echo $rs_login->fields['logout_time'];
											}  ?></td>

									<td><?php echo $rs_drop_name->fields['department']; ?></td>


								</tr>
								<?php $stringData .= date('d-m-Y', strtotime($rs_agent_name->fields['update_datetime'])) . "," . $rs_drop_name->fields['full_name'] . "," . $rs_in_bound->fields['inbound_call_no'] . "," . $rs_in_bound->fields['inbound_call_duration'] . "," . $rs_out_bound->fields['outbound_call_no'] . "," . $rs_out_bound->fields['outbound_call_duration'] . "," . $rs_drop_name->fields['droped_calls'] . "," . $rs_break_assign->fields['break_time'] . "," . $rs_break_assign->fields['assignment_time'] . "," . $rs_hold_time->fields['hold_time'] . "," . $rs_login->fields['login_time'] . "," . $bd . "," . $rs_login->fields['login_duration'] . "," . $rs_login->fields['logout_time'] . "," . $rs_drop_name->fields['department'] . "\r\n"; ?>

							<?php
								$rs_agent_name->MoveNext();
								$ttl_record++;
							}
							?>
						</tbody>

						<tfoot>
							<tr>

								<th colspan="2">Grand Total</b></th>
								<th><?php echo $total['inbound_call_no']; ?></th>
								<th><?php echo ($total['inbound_call_duration']) ? date("H:i:s", strtotime("00:0:00 +" . $total['inbound_call_duration'] . " seconds")) : '00:00:00'; ?></th>
								<th><?php echo $total['outbound_call_no']; ?></th>
								<th><?php echo ($total['outbound_call_duration']) ? date("H:i:s", strtotime("00:0:00 +" . $total['outbound_call_duration'] . " seconds")) : '00:00:00'; ?></th>
								<th><?php echo $total['droped_calls']; ?></th>
								<th><?php echo ($total['break_time']) ? date("H:i:s", strtotime("00:0:00 +" . $total['break_time'] . " seconds")) : '00:00:00'; ?></th>
								<th><?php echo ($total['assignment_time']) ? date("H:i:s", strtotime("00:0:00 +" . $total['assignment_time'] . " seconds")) : '00:00:00'; ?></th>
								<th><?php echo ($total['hold_time']) ? date("H:i:s", strtotime("00:0:00 +" . $total['hold_time'] . " seconds")) : '00:00:00'; ?></th>
								<th>--</th>
								<th>--</th>
								<th>--</th>

							</tr>
							<tr>
								<td colspan="15">
									<center>
										<div class="pagination">
											<ul>
												<?php echo $admin->pagination($found_rows->fields, $per_page = 50, $page, 'summary_report.php?fdate=' . $fdate . '&tdate=' . $tdate . '&search_keyword=' . $search_keyword . '&');

												?>
											</ul>
										</div>
									</center>
								</td>
							</tr>
						</tfoot>
					</table>
				</div>

				<br />
			</div>
		<?php } ?>

	</div>

	</div>
	</div>

	<?php include($site_admin_root . "includes/footer.php"); ?>
</body>
<script>
	$(document).ready(function() {
	
		$('#keywords').DataTable({
			"order": [
			[10, "desc"]
		],
			"paginate": false,
			"language": {
				"emptyTable": "No data available",
				"lengthMenu": "Show _MENU_ records",
				"info": "Total :  _TOTAL_ records",
				"infoFiltered": "(filtered from _MAX_ total records)",
				"infoEmpty": "No records available",
			},
			dom: 'lfrtpiB',
			buttons: [{
					extend: 'copyHtml5',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate . " - " . $tdate; ?>',
					footer: true
				},
				{
					extend: 'csvHtml5',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate . " - " . $tdate; ?>',
					footer: true
				},
				{
					extend: 'excelHtml5',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate . " - " . $tdate; ?>',
					footer: true
				},
				{
					extend: 'pdfHtml5',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate . " - " . $tdate; ?>',
					pageSize: 'A4',
					orientation: 'landscape',
					footer: true
				},
				{
					extend: 'print',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate . " - " . $tdate; ?>',
					footer: true
				}
			]
		});
	});
</script>

</html>
