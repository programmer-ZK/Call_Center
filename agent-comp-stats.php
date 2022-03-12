<?php include_once("includes/config.php"); ?>
<?php
$page_name = "agent-comp-stats.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Agent Complete Stats";
$page_menu_title = "Agent Complete Stats";
?>
<?php include_once($site_root . "includes/check.auth.php"); ?>
<?php
include_once("classes/admin.php");
$admin = new admin();
include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();
?>
<?php include($site_root . "includes/header.php"); ?>
<style>
	input[type="search"],
	.dt-buttons,
	.dataTables_length {
		margin-top: 10px;
	}
</style>
<meta http-equiv="refresh" content="45">
<?php
$recStartFrom = 0;
$field = empty($_REQUEST["field"]) ? "staff_updated_date" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "asc" : $_REQUEST["order"];
$rs = $admin->get_agent_comp_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>
<?php
session_start(); // this MUST be at the very top of the page, the only thing before it is <?php 

if (!isset($_SESSION['number'])) {
	$_SESSION['number'] = 0;
} elseif ($_SESSION['number'] == 1) {
	$_SESSION['number'] = 0;
} else {
	$_SESSION['number'] = $_SESSION['number'] + 1;
}

$id = isset($_GET['id']) ? $_GET['id'] : "";
if ($id == 'start') {
	$chek = "checked";
	if ($_SESSION['number'] == 1) {
		unset($_SESSION['number']);
		header("Location: agent-stats.php?id=" . $_GET['id']);
	}
} else {
	$chek = "";
}
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
	<div id="mid-col" class="mid-col">
		<div style="font-size:18px; font-weight:bold; line-height:20px; display:block; text-align:right; margin-bottom:10px;">Auto Switching<input type="radio" name="radio" id="radio" <?php echo $chek; ?> style="width:20px; height:20px; float:right; margin-top:2px;"></div>
		<div class="box">
			<h4 id="np" class="white new_wht">
				<a class="heading-link clr_heading active" href="javascript:;">
					<?php echo ($page_title); ?></a>

				<a class="heading-link clr_heading" href="agent-stats.php"><span>Agent Stats</span></a>
				&nbsp;&nbsp;
				<a class="heading-link clr_heading" href="call_center_wallboard.php"><span>Call Center Wallboard</span></a>
				 &nbsp;&nbsp;
                                <a class="heading-link clr_heading" href="agent-stats-summary.php"><span>Agent Stats Summary</span></a>

			</h4>
			<div class="box-container">
				<table class="table-short" id="tbl4" style="display:inline-block; width:100%;">
					<thead>
						<tr>
							<td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
						</tr>
						<tr>
							<td class="col-head2">Full<br />Name</td>
							<td class="col-head2">CRM Login</td>
							<td class="col-head2">Phone Login</td>
							<td class="col-head2">Call<br />Status</td>
							<td class="col-head2">Status</td>
							<td class="col-head2">Caller No</td>
							<td class="col-head2">Time Duration <br />(Call Status)</td>
							<td class="col-head2">Time Duration <br />(CRM Status)</td>
							<td class="col-head2">Busy Time <br />(Last Call)</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$c4;
						while (!$rs->EOF) { ?>
							<tr class="odd">
								<td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>
								<td class="col-first"><?php echo (empty($rs->fields["is_crm_login"]) ? "<font color=\"red\">No</font>" : "Yes"); ?> </td>
								<td class="col-first"><?php echo (empty($rs->fields["is_phone_login"]) ? "<font color=\"red\">No</font>" : "Yes"); ?> </td>
								<?php
								$position = strpos($rs->fields["t_duration"], "-");

								if ($rs->fields["is_busy"] == 2) {
									$bstr = "<font color=\"green\">Ringing</font>";
									$rsx = $admin->ringing_id($rs->fields["admin_id"]);
									$str_callerid = $rsx->fields["caller_id"];
									$str_t_duration = '';
								} else if ($rs->fields["is_busy"] == 1) {
									if ($rs->fields["call_type"] == "OUTBOUND") {
										$c_type = "OUTBOUND";
										$bstr = "<font color=\"green\">On Call (O.B)</font>";
									} else {
										$c_type = "INBOUND";
										$bstr = "<font color=\"green\">On Call (I.B)</font>";
									}
									$str_callerid = $rs->fields["caller_id"];
									if ($position === false)
										$str_t_duration = $rs->fields["t_duration"];
									else
										$str_t_duration = '';
								} else if ($rs->fields["is_busy"] == 0) {
									$bstr = "Free";
									$str_callerid = '';
									if ($position === false)
										$str_t_duration = $rs->fields["t_duration"];
									else
										$str_t_duration = '';
								} else if ($rs->fields["is_busy"] == 3) {
									$bstr = "<font color=\"red\">Busy</font>";
									$str_callerid = $rs->fields["caller_id"];
									if ($position === false)
										$str_t_duration = $rs->fields["t_duration"];
									else
										$str_t_duration = '';
								} else if ($rs->fields["is_busy"] == 5) {
									$bstr = "<font color=\"red\">On Hold</font>";
									$str_callerid = $rs->fields["caller_id"];
									if ($position === false) {
										$new_rs = $admin->get_agent_list_hold($rs->fields["full_name"], $str_callerid);
										$str_t_duration = $new_rs->fields["new_t_time"];
									} else {
										$str_t_duration = '';
										//$str_t_duration = $rs->fields["t_duration"];
									}
								}

								?>

								<td class="col-first"><?php echo $bstr; ?> </td>

								<?php
								if ($rs->fields["is_crm_login"] == 1) {
									$str = "Online";
								} else if ($rs->fields["is_crm_login"] == 2) {
									$str = "<font color=\"red\">Namaz Break</font>";
								} else if ($rs->fields["is_crm_login"] == 3) {
									$str = "<font color=\"red\">Lunch Break</font>";
								} else if ($rs->fields["is_crm_login"] == 4) {
									$str = "<font color=\"red\">Tea Break</font>";
								} else if ($rs->fields["is_crm_login"] == 5) {
									$str = "<font color=\"red\">Auxiliary Break</font>";
								} else if ($rs->fields["is_crm_login"] == 6) {
									$str = "<font color=\"red\">After Call Work</font>";
								} else if ($rs->fields["is_crm_login"] == 7) {
									$str = "<font color=\"red\">Campaign</font>";
								} else if ($rs->fields["is_crm_login"] == 0) {
									$str = "<font color=\"red\">Offline</font>";
									$str_t_duration = '';
								} else {
									$str = "Unkown";
								}
								?>
								<td class="col-first"><?php echo $str; ?> </td>
								<td class="col-first"><?php echo $str_callerid;
																			?> </td>
								<td class="col-first"><?php echo $str_t_duration; ?> </td>

								<?php $crm_status_time = $admin->crm_status_time($rs->fields["admin_id"]); ?>
								<td class="col-first"><?php echo $crm_status_time; ?> </td>


								<?php $last_busy_time = $admin->last_busy_time($rs->fields["admin_id"]); ?>
								<td class="col-first"><?php echo $last_busy_time; ?> </td>


							</tr>
						<?php $rs->MoveNext();
							$c4++;
						} ?>
					</tbody>
				</table>
			</div>

		</div>

	</div>
	</div>
</form>
<?php if (!isset($_GET['id'])) { ?>
	<script>
		$(document).ready(function() {

			$('#radio').click(function() {
				var url = window.location.href + '?id=start';
				window.location = url;

			});
		});
	</script>
<?php } else { ?>
	<script>
		$(document).ready(function() {

			$('#radio').click(function() {
				window.location.href = window.location.href.split('?')[0];;

			});
		});
	</script>
<?php } ?>

<script>
	$(document).ready(function() {
		$('#tbl').DataTable({
			"order": [
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
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c1; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "csv",
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c1; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "excel",
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c1; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "pdf",
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c1; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "print",
					title: "Received Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c1; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				},

			]
		});
	});

	$(document).ready(function() {
		$('#tbl2').DataTable({
			"order": [
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
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c3; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "csv",
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c3; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "excel",
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c3; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "pdf",
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c3; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "print",
					title: "Dropped Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c3; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				},

			]
		});
	});

	$(document).ready(function() {
		$('#tbl3').DataTable({
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
					title: "Abandoned Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "csv",
					title: "Abandoned Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "excel",
					title: "Abandoned Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "pdf",
					title: "Abandoned Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "print",
					title: "Abandoned Call Stats",
					messageBottom: '<?php echo  "Total number of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdatetime . " - " . $tdatetime; ?>'
				},

			]
		});
	});

	$(document).ready(function() {
		$('#tbl4').DataTable({
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
					title: "Agent Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c4; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "csv",
					title: "Agent Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c4; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "excel",
					title: "Agent Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c4; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "pdf",
					title: "Agent Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c4; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "print",
					title: "Agent Stats",
					messageBottom: '<?php echo  "Total number of records : " . $c4; ?>',
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				},

			]
		});
	});

	$(document).ready(function() {
		$('#tbl5').DataTable({
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
					title: "QUEUE STATS",
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "csv",
					title: "QUEUE STATS",
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "excel",
					title: "QUEUE STATS",
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "pdf",
					title: "QUEUE STATS",
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				}, {
					extend: "print",
					title: "QUEUE STATS",
					messageTop: '<?php echo  Date("d-m-Y H:i:s"); ?>'
				},

			]
		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>
