<?php include_once("includes/config.php"); ?>
<?php
$page_name = "dropped-calls.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Dropped Calls Report";
$page_menu_title = "Dropped Calls Report";
?>

<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/admin.php");
$admin = new admin();
//echo 'ddd';die;		
include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();

include_once("classes/reports.php");
$reports = new reports();

include_once("classes/all_agent.php");

$all_agent = new all_agent();
?>
<?php include($site_root . "includes/header.php"); ?>
<!--<meta http-equiv="refresh" content="2">-->
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
		$fdate            = $_REQUEST['fdate'];
		$tdate            = $_REQUEST['tdate'];

		$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
		$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
	} else {
		$fdate             =  date('d-m-Y');
		$tdate             =  date('d-m-Y');

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
						<h4>Dropped Calls Report</h4>
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
							</div>
						</div>
					</h4>
		</form>
		<br />
		<style>
			table {
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
			<?php $rs_agent_name = $admin->dropped_call_report($search_keyword, $fdateTime, $tdateTime, $startpoint, $per_page);
			//echo 'ddd';die;       
			$found_rows = $admin->found_rows();
			?>
			<h4 class="white" style="text-align:center;">
				<?php echo "From: " . date('d-m-Y', strtotime($fdate)) . ' To ' . date('d-m-Y', strtotime($tdate)); ?></h4>
			<br />

			<!-- ******************************  Agent On Call and Busy Times ************************** -->
			<div class="box-container">
				<?php //print_r($rs_agent_name->fields);
				?>
				<table class="table-short" id="keywords" style=" margin-bottom: 13px;">
					<thead>

						<tr>
							<th class="col-head2">AGENT NAME</th>
							<th class="col-head2">CALL DATE</th>
							<th class="col-head2">TIME</th>
							<th class="col-head2">DURATION</th>
							<th class="col-head2">CALLER ID</th>
							<th class="col-head2">CALL ID</th>
							<th class="col-head2">DISCONNECTED BY</th>
						</tr>
					</thead>

					<tbody>
						<?php
						while (!$rs_agent_name->EOF) { ?>
							<tr class="odd">
								<td><?php echo $rs_agent_name->fields['full_name']; ?></td>
								<td><?php echo date('d-m-Y', strtotime($rs_agent_name->fields['call_date'])); ?></td>
								<td><?php echo date('H:i:s', strtotime($rs_agent_name->fields['TIME'])); ?></td>
								<td><?php echo $rs_agent_name->fields['duration']; ?></td>
								<td><?php echo $rs_agent_name->fields['caller_id']; ?></td>
								<td><?php echo $rs_agent_name->fields['call_id']; ?></td>
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
				[2, "desc"],
				[3, "desc"]
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