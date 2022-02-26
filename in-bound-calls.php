<?php include_once("includes/config.php"); ?>
<?php
$page_name = "in-bound-calls.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Inbound Calls Report";
$page_menu_title = "Inbound Calls Report";
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
	#dateDiv tbody td {
		background-color: #B78554 !important;
	}

	#dateDiv tbody td a {
		display: none;
	}

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

		}
	</script>
</head>

<body>

	<?php

	if (isset($_REQUEST['fdate'])) {
		$search_keyword = $_REQUEST['search_keyword'];
		$fdate            = $_REQUEST['fdate'];
		$tdate            = $_REQUEST['tdate'];

		$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
		$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
	} else {
		$fdate             = empty($_REQUEST["fdate"]) ? date('d-m-Y') : $_REQUEST["fdate"];
		$tdate             = empty($_REQUEST["tdate"]) ? date('d-m-Y') : $_REQUEST["tdate"];
		$search_keyword = "";

		$static_stime     =  "00:00:00";
		$static_etime     =  "23:59:59";
	}

	$fdateTime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
	$tdateTime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;

	$ttl_record = 0;

	?>

	<div>
		<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" onsubmit="">

			<div id="mid-col" class="mid-col">
				<div class="box">
					<center>
						<h4>Inbound Calls Report</h4>
					</center>
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
		</style>

		<div id="agent_pd_report">
			<?php $rs_agent_name = $admin->in_bound_calls_report($search_keyword, $fdateTime, $tdateTime );
			$found_rows = $admin->found_rows();
			?>
			<h4 class="white" style="text-align:center;"><?php echo "From: " . date('d-m-Y', strtotime($fdateTime)) . ' To ' . date('d-m-Y', strtotime($tdateTime)); ?></h4>
			<br />

			<!-- ******************************  Agent On Call and Busy Times ************************** -->
			<div class="box-container">
				<?php //print_r($rs_agent_name->fields);
				?>
				<table class="table-short" id="keywords">
					<thead>
						<tr>
							<!--<th colspan="4"></th>
								<th colspan="4">
									<center>INBOUND CALL</center>
								</th>-->
						</tr>
						<tr>
							<th class="col-head2">S.NO</th>
							<th class="col-head2">AGENT NAME</th>
							<th class="col-head2">CALL DATE</th>
							<th class="col-head2">TIME</th>
							<th class="col-head2">DURATION</th>
							<th class="col-head2">CALLER ID</th>
							<th class="col-head2">HOLD TIME</th>
							<th class="col-head2">CALL TYPE</th>
							<th class="col-head2">DISCONNECTED BY</th>
						</tr>
					</thead>

					<tbody>
						<?php $i = $startpoint + 1;
						while (!$rs_agent_name->EOF) { ?>
							<tr class="odd">
								<td><?php echo $i++; ?></td>
								<td><?php echo $rs_agent_name->fields['full_name']; ?></td>
								<td><?php echo date('d-m-Y', strtotime($rs_agent_name->fields['call_date'])); ?></td>
								<td><?php echo date('h:i:s  ', strtotime($rs_agent_name->fields['TIME'])); ?></td>
								<td><?php echo $rs_agent_name->fields['duration']; ?></td>
								<td><?php echo $rs_agent_name->fields['caller_id']; ?></td>
								<td><?php $uniqid=$rs_agent_name->fields['unique_id'];
                                                                        $rs_uniq_hold = $admin->get_particular_hold($uniqid);                                          
                                                                        echo $rs_uniq_hold->fields['new_t_time'];          
                                                                        ?></td>
								<td><?php echo $rs_agent_name->fields['call_type']; ?></td>
								<td><?php echo $rs_agent_name->fields['disconnect_by']; ?></td>

							</tr>
						<?php
							$rs_agent_name->MoveNext();
							$ttl_record++;
						}

						?>
					</tbody>

				</table>

			</div>
			<br />




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
			[2, "desc"]
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
