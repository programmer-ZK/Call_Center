<?php include_once("includes/config.php"); ?>
<?php
$page_name = "agent-stats-summary.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Agent Statistics Summary";
$page_menu_title = "Agent Statistics Summary";
?>

<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/admin.php");
$admin = new admin();

include_once("classes/reports.php");
$reports = new reports();
?>
<?php include($site_root . "includes/header.php"); ?>
<meta http-equiv="refresh" content="45">
<style>	input[type="search"],
	.dt-buttons,
	.dataTables_length {
		margin-top: 10px;
	}</style>
<?php

$agents = $reports->get_asum_agents_names();

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
$ttl_record=0;
?>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
	<div id="mid-col" class="mid-col">
		<div style="font-size:18px; font-weight:bold; line-height:20px; display:block; text-align:right; margin-bottom:10px;">Auto Switching<input type="radio" name="radio" id="radio" <?php echo $chek; ?> style="width:20px; height:20px; float:right; margin-top:2px;"></div>
		<div class="box">
			<h4 id="np" class="white new_wht">
				<a class="heading-link clr_heading active" href="javascript:;"><?php echo ($page_title); ?></a>

				<a class="heading-link clr_heading" href="agent-stats.php"><span>Agent Stats</span></a>

				<a class="heading-link clr_heading" href="call_center_wallboard.php"><span>Call Center Wallboard</span></a>
			</h4>
			<div class="box-container">
				<table class="table-short" id="tbl" style="display:inline-block; width:100%;">
					<thead>

						<tr>
							<td class="col-head2">Agent<br />Name</td>
							<td class="col-head2">Inbound<br />Calls</td>
							<td class="col-head2">Outbound<br />Calls</td>
							<td class="col-head2">Break<br />Time</td>
							<td class="col-head2">After Call Work<br /> (ACW)</td>
							<td class="col-head2">Login<br />Time</td>
							<td class="col-head2">Time Duration<br />(Last Status)</td>
							<td class="col-head2">Last 30<br />Minutes Call</td>
						</tr>
					</thead>
					<tbody>


						<?php
						while (!$agents->EOF) {
							$agent_inbound_calls    = $reports->get_asum_inbound_calls($agents->fields["ADMIN_ID"]);
							$agent_outbound_calls  	= $reports->get_asum_outbound_calls($agents->fields["ADMIN_ID"]);
							$agent_break_time  		= $reports->get_asum_break_time($agents->fields["ADMIN_ID"]);
							$agent_assignment_time  = $reports->get_asum_assignment_time($agents->fields["ADMIN_ID"]);
							$agent_login_time 		= $reports->get_asum_agent_login_time($agents->fields["ADMIN_ID"]);
							$agent_busy_time 		= $reports->get_asum_busy_time($agents->fields["ADMIN_ID"]);
							$crm_status_time 		= $admin->crm_status_time($agents->fields["ADMIN_ID"]);
							$crm_30_last_time 		= $admin->crm_30_last_time($agents->fields["FULL_NAME"]);
						?>
							<tr class="odd">
								<td class="col-first"><?php echo strtoupper($agents->fields["FULL_NAME"]); ?> </td>
								<td class="col-first"><?php echo $agent_inbound_calls; ?> </td>
								<td class="col-first"><?php echo $agent_outbound_calls; ?> </td>
								<td class="col-first"><?php echo $agent_break_time == "" ? '-' : $agent_break_time; ?> </td>
								<td class="col-first"><?php echo $agent_assignment_time == "" ? '-' : $agent_assignment_time; ?> </td>
								<td class="col-first"><?php echo $agent_login_time == "" ? '-' : $agent_login_time;  ?> </td>
								<td class="col-first"><?php echo $crm_status_time == "" ? '-' : $crm_status_time; ?> </td>
								<td class="col-first"><?php echo $crm_30_last_time == "" ? '-' : $crm_30_last_time; ?> </td>


							</tr>
						<?php $agents->MoveNext();
						$ttl_record++;
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
			paginate:false,
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
					messageTop: '<?php echo date("d-m-Y") ?>'
				}, {
					extend: "csv",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo date("d-m-Y") ?>'
				}, {
					extend: "excel",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo date("d-m-Y") ?>'
				}, {
					extend: "pdf",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo date("d-m-Y") ?>'
				}, {
					extend: "print",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo date("d-m-Y") ?>'
				},

			]
		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>