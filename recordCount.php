<?php include_once("includes/config.php"); ?>



<?php
$page_name = "recordsCount.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Records Count";
$page_menu_title = "Records Count";
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
		$fdate 			= empty($_REQUEST["fdate"]) ? date('Y-m-d') : $_REQUEST["fdate"];
		$search_keyword = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
	}

	?>

	<?php
	$ttl_record = 0;
	$recStartFrom = 0;
	$field = empty($_REQUEST["field"]) ? "staff_updated_date" : $_REQUEST["field"];
	$order = empty($_REQUEST["order"]) ? "asc" : $_REQUEST["order"];
	$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, 1000, $field, $order);
	?>

	<?php
	/************************* Export to Excel ******************/
	//if(isset($_REQUEST['export'])){}
	if (isset($_REQUEST['export'])) {



		/*$stringData  = trim($_REQUEST['stringData']);*/

		$stringData     = trim($_REQUEST['gethtml1']);

		$stringData = preg_replace('/Â/', '', $stringData);

		$stringData = preg_replace('/<form name="xForm" (.*)>/isU', '', $stringData);

		$stringData = preg_replace('/<\/form>/isU', '', $stringData);

		$stringData = preg_replace('/<form name="xForm2" (.*)<\/form>/isU', '', $stringData);

		$stringData = preg_replace('/<form name="xForm3" (.*)<\/form>/isU', '', $stringData);

		$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);

		$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);

		$stringData = preg_replace('/EXPORT PDF/', '', $stringData);

		$stringData = str_replace('<tag1>', null, $stringData); //'<div style="border:2px solid #000000;background-color:#F2F2F2; margin-top:10px;margin-bottom:10px;">'

		$stringData = str_replace('</tag1>', null, $stringData); //'</div>'

		//$stringData = str_replace(' ','<br>',$stringData);

		$stringData = str_replace('<tag2>', null, $stringData);

		$stringData = str_replace('</tag2>', null, $stringData);

		$stringData = str_replace('<tag3>', null, $stringData);

		$stringData = str_replace('</tag3>', null, $stringData);

		//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);

		$db_export_fix = $site_root . "download/Productivity_Report.xls";

		//echo $stringData; exit;

		shell_exec("echo '<html><body>" . $stringData . "</html></body>' > " . $db_export_fix);



		ob_end_clean();

		header("Pragma: public");

		header("Expires: 0");

		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");

		header("Cache-Control: private", false);

		//header("Content-type: application/force-download");

		//header("Content-Type: text/csv");

		header("Content-Type: application/ms-excel");



		//echo $db_export; exit;

		header("Content-Disposition: attachment; filename=" . basename($db_export_fix) . ";");

		header("Content-Transfer-Encoding: binary");

		header("Content-Length: " . filesize($db_export_fix));

		readfile($db_export_fix);

		if (file_exists($db_export_fix) && !empty($file_name)) {

			unlink($db_export_fix);
		}


		exit();
	}
	if (isset($_REQUEST['export_pdf'])) {

		$stringData			= trim($_REQUEST['stringData']);
		//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
		$db_export_fix = $site_root . "download/Productivity_Report.csv";
		//echo $stringData; exit;

		shell_exec("echo '" . trim($stringData) . "' > " . $db_export_fix);

		///////////////////------HK------///////////////////
		//echo $db_export_fix; exit();
		ob_end_clean();
		//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
		$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'Productivity_Records.pdf', 'D', 160, 16, 1);
		exit();
	}
	///******************************************************************************/	
	$stringData	 = '';
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
								echo "Records Count <br> Agent Name - " . $rs_agent_name->fields["full_name"] . " <br> Department- " . $rs_agent_name->fields["department"] . " <br> Date: " . $fdate;
								$stringData .= "<tag1>Records Count</tag1>\r\n";
								$stringData .= "<tag3>Agent Name - " . $rs_agent_name->fields["full_name"] . "</tag3>\r\n<tag3>Date: " . $fdate . "</tag3>\r\n";
								?></h4>
							<br />
							<h4 class="white" style=" margin-bottom: 13px;">
								<?php

								echo "Working Times";
								$stringData .= "<tag1>Work Times</tag1>\r\n";
								?></h4>
							<?php $fdate = date('Y-m-d', strtotime($fdate));
							$agents = $reports->get_asum_agents_names_all();
							?>

							<div class="box-container">

								<table class="table-short" id="keywords" style=" margin-bottom: 13px;">
									<thead>
										<tr>
											<td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
										</tr>
										<tr>
											<td class="col-head2">Agent Name</td>
											<td class="col-head2">Inbound Calls</td>
											<td class="col-head2">Outbound Calls</td>
											<td class="col-head2">Total Calls</td>

										</tr>
									</thead>
									<?php $stringData .= "<tag2>Mobile</tag2>, <tag2>Landline</tag2>, <tag2>Extension</tag2>\r\n";  ?>
									<tbody>
										<?php
										$sum_worktime = 0;
										$agent = '';
										$inbound_calls = '';
										$outbound_calls = '';
										$Total = '';

										if ($rs_agent_name->fields["full_name"] == NULL) {
											while (!$agents->EOF) {
												$agent_inbound_calls    = $reports->record_inbound_count($agents->fields["FULL_NAME"], $fdate);
												$agent_outbound_calls  	= $reports->record_outbound_count($agents->fields["FULL_NAME"], $fdate);
										?>
												<tr class="odd">
													<td class="col-first"><?php echo strtoupper($agents->fields["FULL_NAME"]); ?> </td>
													<td class="col-first"><?php echo $agent_inbound_calls; ?> </td>
													<td class="col-first"><?php echo $agent_outbound_calls; ?> </td>
													<td class="col-first"><?php echo $agent_outbound_calls + $agent_inbound_calls; ?> </td>

												</tr>
											<?php $agents->MoveNext();
												$ttl_record++;
												$inbound_calls  += $agent_inbound_calls;
												$outbound_calls += $agent_outbound_calls;
												$Total += $agent_outbound_calls + $agent_inbound_calls;
											}
										} else {
											$agent_inbound_calls    = $reports->record_search_inbound_count($rs_agent_name->fields["full_name"], $fdate);
											$agent_outbound_calls  	= $reports->record_search_outbound_count($rs_agent_name->fields["full_name"], $fdate);
											?>
											<tr class="odd">
												<td class="col-first"><?php echo strtoupper($rs_agent_name->fields["full_name"]); ?> </td>
												<td class="col-first"><?php echo $agent_inbound_calls; ?> </td>
												<td class="col-first"><?php echo $agent_outbound_calls; ?> </td>
												<td class="col-first"><?php echo $agent_outbound_calls + $agent_inbound_calls; ?> </td>

											</tr>
										<?php } ?>
									</tbody>
									<tfoot>
										<tr>
											<td style="font-weight: bolder;">
												Total :
											</td>
											<td style="font-weight: bolder;">
												<?php
												echo $inbound_calls;
												?>
											</td>
											<td style="font-weight: bolder;">
												<?php
												echo $outbound_calls;
												?>
											</td>
											<td style="font-weight: bolder;">
												<?php
												echo $Total;
												?>
											</td>
										</tr>
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
			"paging": false,
			dom: 'frtiB',
			buttons: [{
					extend: 'copyHtml5',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true
				},
				{
					extend: 'csvHtml5',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true
				},
				{
					extend: 'excelHtml5',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true
				},
				{
					extend: 'pdfHtml5',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true
				},
				{
					extend: 'print',
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdate; ?>',
					footer: true
				}
			]
		});
	});
</script>

</html>