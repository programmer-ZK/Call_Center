<?php include_once("includes/config.php"); ?>
<?php
$page_name = "icdr-stats.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Call Center Main Report";
$page_menu_title = "Call Center Main Report";
?>
<?php include_once($site_root . "includes/check.auth.php"); ?>
<?php
include_once("classes/reports.php");
$reports = new reports();
include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();
include_once("classes/user_tools.php");
$user_tools = new user_tools();
?>
<?php include($site_root . "includes/header.php"); ?>
<style>
	.flex-container {
		display: flex;
		flex-direction: column;
		justify-items: center;
		align-items: center;
		vertical-align: center;
	}

	input[type="search"],
	.dt-buttons,
	.dataTables_length {
		margin-top: 10px;
	}

	#tbl td {
		text-align: center !important;
	}

	#tbl tfoot td {
		font-weight: bolder;
	}
</style>
<script type="text/javascript" language="javascript1.2">
	function showWorkCode(wc) {
		if (wc || 0 !== wc.length) {
			alert(wc);
		} else {
			alert("No work code available!");
		}
	}
</script>

<?php
if (isset($_REQUEST['fdate'])) {
	$fdate            = $_REQUEST['fdate'];
	$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
} else {
	$fdate             = empty($_REQUEST["fdate"]) ? date('d-m-Y') : $_REQUEST["fdate"];
	$static_stime   =     "00:00:00";
	$static_etime   =     "23:59:59";
}

$fdate        = date('Y-m-d', strtotime($fdate));

?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Call Center Main </div>
<div>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
		<div class="box">
			<h4 class="white">
				<div>
					Date :
					<label>
						<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo ($fdate) ? date('d-m-Y', strtotime($fdate)) : date('d-m-Y'); ?>" autocomplete="off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">
					</label>
					&nbsp;

					From :
					<label>
						<select name="static_shours">
							<?php for ($i = 0; $i <= 23; $i++) { ?>
								<?php if ($_REQUEST['static_shours'] == $i) { ?>
									<option id="sh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>" selected><?php echo $static_hours_array[$i]; ?></option>
								<?php continue;
								} ?>
								<option id="sh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>"><?php echo $static_hours_array[$i]; ?></option>
							<?php } ?>
						</select>

						<select name="static_sminutes">
							<?php for ($i = 0; $i <= 59; $i++) { ?>
								<?php if ($_REQUEST['static_sminutes'] == $i) { ?>
									<option id="sm<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>" selected><?php echo $static_minutes_array[$i]; ?></option>
								<?php continue;
								} ?>
								<option id="sm<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>"><?php echo $static_minutes_array[$i]; ?></option>
							<?php } ?>
						</select>
					</label>

					&nbsp;
					To :
					<label>
						<select name="static_ehours">
							<?php for ($i = 1; $i <= 23; $i++) { ?>
								<?php if (isset($_REQUEST['static_ehours']) && $_REQUEST['static_ehours'] == $i) { ?>
									<option id="eh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>" selected><?php echo $static_hours_array[$i]; ?></option>
								<?php
								} else { ?>
									<?php if (!isset($_REQUEST['static_ehours'])) { ?>
										<option id="em<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>" <?php echo ($static_hours_array[$i] == "23") ? "selected" : "" ?>><?php echo $static_hours_array[$i]; ?></option>
									<?php continue;
									} ?>
									<option id="eh<?php echo $i; ?>" value="<?php echo $static_hours_array[$i]; ?>"><?php echo $static_hours_array[$i]; ?></option>
								<?php }
								?>
							<?php } ?>
						</select>
						&nbsp;
						<select name="static_eminutes">
							<?php for ($i = 1; $i <= 59; $i++) { ?>
								<?php if (isset($_REQUEST['static_eminutes']) && $_REQUEST['static_eminutes'] == $i) { ?>
									<option id="em<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>" selected><?php echo $static_minutes_array[$i]; ?></option>
								<?php
								} else { ?>
									<?php if (!isset($_REQUEST['static_eminutes'])) { ?>
										<option id="em<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>" <?php echo ($static_minutes_array[$i] == "59") ? "selected" : "" ?>><?php echo $static_minutes_array[$i]; ?></option>
									<?php continue;
									} ?>
									<option id="em<?php echo $i; ?>" value="<?php echo $static_minutes_array[$i]; ?>"><?php echo $static_minutes_array[$i]; ?></option>
								<?php }
								?>
							<?php } ?>
						</select>
					</label>

					<a class="button" href="javascript:document.xForm.submit();">
						<span>Search</span>
					</a>
					<input type="hidden" value="Search >>" id="search_date" name="search_date" />

				</div>
			</h4>
		</div>
		<br />
		<div id="mid-col" class="mid-col">
			<div class="box">
				<h4 class="white"><?php echo ($page_title); ?></h4>
				<table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">

				</table>
				<div class="box-container">
					<br>
					<table class="table-short" id="tbl">
						<thead style="text-align: center;">
							<tr>
								<td>&nbsp;</td>
								<td>Time</td>
								<td>&nbsp;</td>
								<td>Answered Calls</td>
								<td>Abandonded Calls</td>
								<td>Drop Calls</td>
								<td>Total Call</td>
							</tr>
						</thead>
						<tbody>

							<?php

							date_default_timezone_set('GMT+5');

							$sdtime = $static_stime;
							$setime = date('H:i:s', strtotime('+29 minutes +59 seconds', strtotime($static_stime)));


							$ftime = date("H:i:s", strtotime($sdtime));
							$dtime = date("H:i:s", strtotime($setime));
							$count = 0;
							$ans_calls = 0;
							$abn_calls = 0;
							$drp_calls = 0;
							$ttl_calls = 0;
							
							while (true) {

								$rs1 = $reports->iget_call_center_main_answered($fdate, $ftime, $dtime);
								$rs2 = $reports->iget_call_center_main_abandoned($fdate, $ftime, $dtime);
								$rs3 = $reports->iget_call_center_main_drop($fdate, $ftime, $dtime);
								$rs4 = $reports->iget_call_center_main_total($fdate, $ftime, $dtime);


							?>

								<tr class="odd">
									<td><?php echo $ftime; ?></td>
									<td>:</td>
									<td><?php echo $dtime; ?></td>
									<td><?php echo $rs1->fields["answered_calls"]; ?></td>
									<td><?php echo $rs2->fields["abandoned_calls"]; ?></td>
									<td><?php echo $rs3->fields["drop_calls"]; ?></td>
									<td><?php echo $rs4->fields["total_calls"]; ?></td>
								</tr>
							<?php
								$count = $count + 1;

								$ans_calls += $rs1->fields["answered_calls"];
								$abn_calls += $rs2->fields["abandoned_calls"];
								$drp_calls += $rs3->fields["drop_calls"];
								$ttl_calls += $rs4->fields["total_calls"];

								if ($dtime >= $static_etime) {
									break;
								}


								$ftime = date('H:i:s', strtotime('+30 minutes', strtotime($ftime)));
								$dtime = date('H:i:s', strtotime('+30 minutes', strtotime($dtime)));
							} ?>
						</tbody>
						<tfoot>
							<tr>
								<td>&nbsp;</td>
								<td>GRAND TOTAL</td>
								<td>&nbsp;</td>
								<td><?php echo $ans_calls; ?></td>
								<td><?php echo $abn_calls; ?></td>
								<td><?php echo $drp_calls; ?></td>
								<td><?php echo $ttl_calls; ?></td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	$(document).ready(function() {
		$('#tbl').DataTable({
			"paginate": false,

			dom: 'tB',
			buttons: [{
					extend: 'copyHtml5',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true,
					exportOptions: {
						alignment: 'center',
					}
				},
				{
					extend: 'csvHtml5',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true,
					exportOptions: {
						alignment: 'center',
					}
				},
				{
					extend: 'excelHtml5',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true,
					exportOptions: {
						alignment: 'center',
					}
				},
				{
					extend: 'pdfHtml5',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true,
					customize: function(doc) {
						doc.styles.tableBodyEven.alignment = 'center';
						doc.styles.tableBodyOdd.alignment = 'center';
						doc.styles.tableFoot = 'center';
					}
				},
				{
					extend: 'print',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true,
					exportOptions: {
						alignment: 'center',
					}
				}

			],


		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>