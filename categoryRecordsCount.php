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
	#keywords td {
		text-align: center !important;
	}

	#keywords tfoot td {
		font-weight: bolder !important;
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
		$search_keyword		= $_REQUEST['search_keyword'];
		$fdate 				= $_REQUEST['fdate'];
	} else {
		$fdate 			=  date('Y-m-d');
		$search_keyword =   "";
	}

	$ttl_record = 0;
	?>

	<?php

	$recStartFrom = 0;
	$field = empty($_REQUEST["field"]) ? "staff_updated_date" : $_REQUEST["field"];
	$order = empty($_REQUEST["order"]) ? "asc" : $_REQUEST["order"];
	$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, 1000, $field, $order);
	?>

	<div>
		<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" onsubmit="">

			<div id="mid-col" class="mid-col">
				<div class="box">

					<h4 class="white">

						<div>
							Date :
							<label>
								<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo  date('d-m-Y', strtotime($fdate)); ?>" autocomplete="off" readonly onClick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">
							</label>
							<div style="float:right;">
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
						<? if (isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])) {  ?>
							<h4 class="white">
								<?php
								$rs_agent_name = $admin->get_agent_name($search_keyword);
								echo "Category Records Count <br> Agent Name - " . $rs_agent_name->fields["full_name"] . " <br> Department- " . $rs_agent_name->fields["department"] . " <br> Date: " . $fdate;
								$stringData .= "<tag1>Category Records Count</tag1>\r\n";
								$stringData .= "<tag3>Agent Name - " . $rs_agent_name->fields["full_name"] . "</tag3>\r\n<tag3>Date: " . $fdate . "</tag3>\r\n";
								?></h4>
							<br />
							<h4 class="white" style=" margin-bottom: 13px;"><?php

																															echo "Working Times";
																															$stringData .= "<tag1>Work Times</tag1>\r\n";
																															?></h4>
							<?php $fdate = date('Y-m-d', strtotime($fdate));
							$rs_w_t = $reports->get_category_count($rs_agent_name->fields["full_name"], $fdate);
							?>

							<div class="box-container">

								<table class="table-short" id="keywords" style=" margin-bottom: 13px;">
									<thead>
										<tr>
											<td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
										</tr>
										<tr>
											<td class="col-head2">Agent Name</td>
											<td class="col-head2">Mobile</td>
											<td class="col-head2">Landline</td>
											<td class="col-head2">Extension</td>

										</tr>
									</thead>
									<?php $stringData .= "<tag2>Mobile</tag2>, <tag2>Landline</tag2>, <tag2>Extension</tag2>\r\n";  ?>
									<tbody>
										<?php
										$sum_worktime = "00:00:00";
										$agent = '';
										$ext = '';
										$mob = '';
										$land = '';

										foreach ($rs_w_t as $key => $value) {
										?>
											<tr class="odd">
												<td class="col-first">
													<?php echo $rs_w_t[$key]['agentID']; ?>
												</td>
												<td class="col-first">
													<?php echo $rs_w_t[$key]['countMob']; ?>
												</td>
												<td class="col-first">
													<?php echo $rs_w_t[$key]['countLand']; ?>
												</td>
												<td class="col-first">
													<?php echo $rs_w_t[$key]['countExt']; ?>
												</td>
											</tr>
										<?php
											$ext += $rs_w_t[$key]['countExt'];
											$mob += $rs_w_t[$key]['countMob'];
											$land += $rs_w_t[$key]['countLand'];
											$ttl_record++;
										} ?>
									</tbody>
									<tfoot>
										<td>Total</td>
										<td><?php echo $ext ?></td>
										<td><?php echo $mob ?></td>
										<td><?php echo $land ?></td>
									</tfoot>
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
<script>
	$(document).ready(function() {
		$('#keywords').DataTable({
			paginate: false,
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
					footer: true,
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo $fdate; ?>'
				}, {
					extend: "csv",
					footer: true,
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo $fdate; ?>'
				}, {
					extend: "excel",
					footer: true,
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate; ?>'
				}, {
					extend: "pdf",
					footer: true,
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo $fdate; ?>'
				}, {
					extend: "print",
					footer: true,
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo $fdate; ?>'
				},

			]
		});
	});
</script>

</html>