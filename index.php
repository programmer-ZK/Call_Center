<?php include_once("includes/config.php"); ?>
<?php
$page_name = "index";
$page_level = "0";
$page_group_id = "0";
$page_title = "index";
$page_menu_title = "index";
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

<?php $rs_agent_name = $admin->get_agent_name($_SESSION[$db_prefix . '_UserId']); ?>

<?php if ($rs_agent_name->fields["department"] == "Super") { ?>
	<div class="box">
		<h4 class="white">
			<?php echo ($page_title); ?>
			<a href="#" class="heading-link">
				<?php if (empty($caller_id)) echo "No Calls";
				elseif (empty($client_detail->fields["id"])) echo "UnRegister No.";
				else echo "Users List"; ?>
			</a>
		</h4>
		<div class="box-container">
			<?php
			if (empty($caller_id)) { ?>
				<div class="box" id="mid-tab">
					<ul class="tab-menu">
						<li><a href="#faq-1">FAQ-1</a></li>
						<li><a href="#faq-2">FAQ-2</a></li>
						<li><a href="#faq-3">FAQ-3</a></li>
						<li><a href="#faq-4">FAQ-4</a></li>

					</ul>
					<div class="box-container" id="faq-1"><?php include($site_root . "includes/faqs1.php"); ?></div>
					<div class="box-container" id="faq-2"><?php include($site_root . "includes/faqs2.php"); ?></div>
					<div class="box-container" id="faq-3"><?php include($site_root . "includes/faqs3.php"); ?></div>
					<div class="box-container" id="faq-4"><?php include($site_root . "includes/faqs4.php"); ?></div>
				</div>

			<?php
			}
			if (!empty($caller_id)) {
				if (!empty($client_detail->fields['id'])) {
					$customer_id = $client_detail->fields['id'];
					header("Location: view_client.php?id=" . $customer_id . "");
					exit;
				} else {
					$_SESSION['contact'] = $caller_id;
					header('Location:create_client.php?msg=Client not found with this contact number create new one.');
					exit;
				}
			}
			?>
		</div>
	</div>
<?php } ?>


<?php if ($rs_agent_name->fields["department"] == "QA") { ?>

	<h1 style="text-align: center;">Hello Qa</h1>
	<script>
		window.location.href = "icdr-stats.php";
	</script>

<?php } ?>

<?php if ($rs_agent_name->fields["department"] == "ICT-Call Center") { ?>

	<body>



		<?php

		$recStartFrom = 0;
		$field = empty($_REQUEST["field"]) ? "staff_updated_date" : $_REQUEST["field"];
		$order = empty($_REQUEST["order"]) ? "asc" : $_REQUEST["order"];
		$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
		?>
		<?php

		?>

		<div>
			<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" onsubmit="">

				<div id="mid-col" class="mid-col">
					<div class="box">

						<br />

						<div id="agent_pd_report">

							<?php $rs_agent_name = $admin->get_agent_name($_SESSION[$db_prefix . '_UserId']); ?>

							<h4 class="white">
								<?php
								echo "Break Record  <br> Agent Name - " . $rs_agent_name->fields["full_name"] . " <br> Department- " . $rs_agent_name->fields["department"] . " <br> Date: " . date('Y-m-d');
								$stringData .= "<tag1>Break Records</tag1>\r\n";
								$stringData .= "<tag1>Agent Name - " . $rs_agent_name->fields["full_name"] . "</tag1>\r\n<tag1>Date: " . date('Y-m-d') . "</tag1>\r\n";
								?></h4>
							<br />

							<?php
							$rs_w_t = $reports->get_agent_work_times($_SESSION[$db_prefix . '_UserId'], date('Y-m-d'), date('Y-m-d'));
							$trec = $rs_w_t->fields["trec"]; ?>
							<br />
							<!-- ******************************  Agent Break Times SUM ************************** -->
							<?php
							$rs_bs_t = $reports->get_agent_break_times_sum($_SESSION[$db_prefix . '_UserId'], date('Y-m-d'), date('Y-m-d'));
							?>


							<div class="box-container">


								<table class="table-short" id="keywords" style=" margin-bottom: 13px;">
									<thead>
										<tr>
											<td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
										</tr>
										<tr>
											<td class="col-head2">CRM Status</td>
											<td class="col-head2">Time Difference</td>

										</tr>
									</thead>
									<?php $stringData .= "<tag2>CRM Status</tag2>, <tag2>Time Difference Summary</tag2>\r\n";  ?>
									<tbody>
										<?php
										$B = "00:00:00";
										$i = 0;
										$arr_names 	= array("Namaz Break", "Lunch Break", "Tea Break", "Auxiliary Break", "Campaign");
										$arr_values = array('2', '3', '4', '5', '7');
										$duration	= array();
										?>
										<?php
										while ($i < 5 /*!$rs_bs_t->EOF*/) {

											if ($arr_values[$i] == $rs_bs_t->fields["crm_status"]) {

												$B = $tools_admin->sum_the_time($B, $rs_bs_t->fields["duration"]);
												$duration[$i] = $rs_bs_t->fields["duration"];


												$rs_bs_t->MoveNext();
											} else {
												$duration[$i] = "-";
											}
										?>
										<?php
											$i++;
										}
										?>
										<?php for ($i = 0; $i < 5; $i++) { ?>
											<tr class="odd">
												<td class="col-first">
													<?php
													echo $arr_names[$i];
													$stringData .= $arr_names[$i];
													$stringData .= $crm_status[$i] . ", " . $duration[$i] . "\r\n";
													?>
												</td>
												<td class="col-first"><?php echo $duration[$i]; ?></td>
											</tr>
										<?php } ?>
									</tbody>
								</table>

							</div>


							<br />
			</form>
		</div>
		</div>
		</div>
		</div>
		<?php include($site_admin_root . "includes/footer.php"); ?>
	</body>
	<script type="text/javascript">
		setTimeout(function() {
			location = ''
		}, 45000) // 1 sec = 1000 ms, 45 sec = 45000 ms
	</script>
<?php } ?>



</html>