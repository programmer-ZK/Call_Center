<?php include_once("includes/config.php"); ?>
<?php
$page_name = "offtime_call_summary.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Off Time Call Summary";
$page_menu_title = "Off Time Call Summary";
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

			document.getElementById("_fdate").value = document.getElementById("fdate").value;
			document.getElementById("_tdate").value = document.getElementById("tdate").value;

		}
	</script>
</head>

<body>

	<?php
	$rs = "";
	if (isset($_REQUEST['fdate'])) {
		$fdate            = $_REQUEST['fdate'];
		$tdate            = $_REQUEST['tdate'];

		$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
		$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
	} else {
		$fdate             = empty($_REQUEST["fdate"]) ? date('d-m-Y') : $_REQUEST["fdate"];
		$tdate             = empty($_REQUEST["tdate"]) ? date('d-m-Y') : $_REQUEST["tdate"];

		$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
		$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
	}

	$fdateTime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
	$tdateTime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;

	$ttl_record = 0;
	?>

	<div>
		<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" onsubmit="">

			<div id="mid-col" class="mid-col">
				<div class="box">
					<h4 class="white">
						<div id="dateDiv">
							<?php include($site_admin_root . "includes/date_hour_search_bar.php"); ?>
							<div>
								<br>
								<br>
								<div>
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
		</style>
		<?php if (!empty($fdate) && !empty($tdate)) {
			$stringData = '';
		?>
			<div id="agent_pd_report">
				<?php $rs = $admin->getofftimecalls($fdateTime, $tdateTime); //print_r($rs);
				?>

				<br />

				<!-- ******************************  Agent On Call and Busy Times ************************** -->
				<h4 class="white" style="margin-bottom: 13px;"><?php echo "OFF TIME CALL SUMMARY " . date('M-d-Y', strtotime($fdate)) . ' To ' . date('M-d-Y', strtotime($tdate));
																												$stringData .= "<tag1>OFF TIME CALL SUMMARY</tag1>\r\n";
																												?></h4>
				<div class="box-container">
					<table class="table-short" id="keywords" style="margin-bottom: 13px;">
						<thead>
							<tr>
								<th class="col-head2">CALLER ID</th>
								<th class="col-head2">CALL TYPE</th>
								<th class="col-head2">CALL DATETIME</th>
								<?php $stringData .= "<tag2>CALLER ID</tag2>, <tag2>CALL TYPE</tag2>, <tag2>CALL DATETIME</tag2>\r\n";  ?>
							</tr>
						</thead>
						<tbody>
							<?php while (!$rs->EOF) { ?>
								<tr class="odd">
									<td><?php echo $rs->fields['caller_id']; ?></td>
									<td><?php echo $rs->fields['call_status']; ?></td>
									<td><?php echo $rs->fields['call_date']; ?></td>
								</tr>
							<?php
								$stringData .= $rs->fields['caller_id'] . ", " . $rs->fields['call_status'] . ", " . $rs->fields['call_date'] . "\r\n";
								$rs->MoveNext();
								$ttl_record++;
							} ?>
						</tbody>
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