<?php include_once("includes/config.php"); ?>
<?php
$page_name = "icdr-stats.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "CDR Stats";
$page_menu_title = "CDR Stats";
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

	.td {
		width: 18%;
		text-align: center;
		vertical-align: middle;
		padding-top: 50px;
	}

	.buttonload {
		background-color: #04AA6D;
		border: none;
		color: white;
		padding: 12px 16px;
		font-size: 16px
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
$today = date("YmdHms");
if (isset($_REQUEST['search_date'])) {
	$keywords         = $_REQUEST['keywords'];
	$search_keyword   = $_REQUEST['search_keyword'];
	$fdate            = $_REQUEST['fdate'];
	$tdate            = $_REQUEST['tdate'];

	$static_stime     = $_REQUEST['static_shours'] . ":" . $_REQUEST['static_sminutes'] . ":00";
	$static_etime     = $_REQUEST['static_ehours'] . ":" . $_REQUEST['static_eminutes'] . ":59";
} else {
	$fdate             = empty($_REQUEST["fdate"]) ? date('d-m-Y') : $_REQUEST["fdate"];
	$tdate             = empty($_REQUEST["tdate"]) ? date('d-m-Y') : $_REQUEST["tdate"];
	$static_stime   =     "00:00:00";
	$static_etime   =     "23:59:59";

	$keywords          = empty($_REQUEST["keywords"]) ? "" : $_REQUEST["keywords"];
	$search_keyword    = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}

$fdate        = date('Y-m-d', strtotime($fdate));
$tdate        = date('Y-m-d', strtotime($tdate));

$fdateTime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
$tdateTime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;

if (isset($_REQUEST['action']) && $_REQUEST['action'] == "add") {
	$rating            =    $_REQUEST["rating"];
	$unique_id         =    $_REQUEST["unique_id"];
	$call_date         =    $_REQUEST["call_date"];
	$call_duration     =    $_REQUEST["call_duration"];
	$user              =    $_REQUEST["user"];

	$url = "php /var/www/cgi-bin/pushrating.php";
	$params =  " " . $rating . " " . $unique_id  . " " . $call_date  . " " . $call_duration  . " " . $user;

	submit_rating($rating, $unique_id, $call_date, $call_duration, $user);
}

?>
<?php

$ttl_record = 0;

$field = empty($_REQUEST["field"]) ? "call_datetime" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "desc" : $_REQUEST["order"];

$rs = $reports->iget_records_pdf(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdateTime, $tdateTime, $search_keyword, $keywords, 1);

?>


<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Call Records</div>
<div>
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
		<div class="box">
			<?php
			$form_type = "icdr";
			include($site_admin_root . "includes/search_form.php");
			include($site_admin_root . "includes/date_hour_search_bar.php");
			?>
		</div>
		<br />
		<div id="mid-col" class="mid-col">
			<div class="box">
				<h4 class="white"><?php echo ($page_title); ?></h4>
				<table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">

				</table>
				<div class="box-container">
					<table class="table-short" id="tbl">
						<thead style="text-align: center;">
							<tr>
								<td>Caller Id</td>
								<td>Date</td>
								<!-- <td>Time</td> -->
								<!-- <td>Duration</td> -->
								<td>Agent Name</td>
								<td>Play/Download</td>

								<?php $rs_agent_name = $admin->get_agent_name($_SESSION[$db_prefix . '_UserId']); ?>

								<?php if ($rs_agent_name->fields["department"] == "QA") { ?>
									<td class="col-head2" style="width:12%; text-align: center;">
										Rating
									</td>
								<?php } ?>

							</tr>
						</thead>
						<tbody style="text-align: center;">
							<?php while (!$rs->EOF) { ?>
								<tr class="odd">
									<p style="display: none;" id="unique_id_<?= $rs->fields["id"] ?>"><?= $rs->fields["unique_id"] ?></p>
									<?php $split = explode('-', $rs->fields["call_date"]); ?>
									<td class="td" class="col-first">
										<a href="call_detail.php?unique_id=<?= $rs->fields["unique_id"]; ?>&id=<?= $rs->fields["id"]; ?>"><?= $rs->fields["caller_id"]; ?></a>
									</td>
									<td class="td" id="call_date_<?= $rs->fields["id"] ?>" class="col-first"><?= $rs->fields["call_datetime"] ?> </td>
									<!-- <td class="td" class="col-first"><?= $rs->fields["call_time"]; ?> </td> -->
									<!-- <td class="td" id="call_duration_<?= $rs->fields["id"] ?>" class="col-first"><?= $rs->fields["call_duration"]; ?> </td> -->
									<td class="td" class="col-first"><?= $rs->fields["full_name"]; ?> </td>

									<td class="col-first" style="padding-top: 35px; padding-bottom: 30px;">
										<audio controls style="width: 210px; margin: 10px 10px -20px 10px;">
											<source src="recording/<?= $rs->fields["unique_id"]; ?>.wav"><?= $rs->fields["caller_id"]; ?>
										</audio>
									</td>


									<?php if ($rs_agent_name->fields["department"] == "QA") {
										$get_rating = fetch_rating($rs->fields["unique_id"]);
									?>

										<td class="col-first d-flex flex-container" style="width: 20%;padding-top: 50px; flex-direction: row; border: none;">
											<div class="">
												<select name="rating" id="rating_<?= $rs->fields["id"] ?>" class="rating">
													<option selected disabled>Select</option>
													<option value="a" <?= ($get_rating->fields["rating"] == 'A') ? "Selected" : "" ?>>A</option>
													<option value="b" <?= ($get_rating->fields["rating"] == 'B') ? "Selected" : "" ?>>B</option>
													<option value="c" <?= ($get_rating->fields["rating"] == 'C') ? "Selected" : "" ?>>C</option>
												</select>
											</div>
											<div class="">
												<a type="button" id="save_btn_<?= $rs->fields["id"] ?>" class="button save_btn buttonload">
													<span>Submit</span>
												</a>
											</div>
										</td>
									<?php } ?>

								</tr>
							<?php
								$rs->MoveNext();
								$ttl_record++;
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {

		// Submit Rating
		$(".save_btn").click(function() {
			err = 0;
			id = $(this).attr("id");
			id = id.split("_");
			id = id.slice(-1);

			rating = $(`#rating_${id} :selected`).text();
			unique_id = $(`#unique_id_${id}`).text();
			call_date = $(`#call_date_${id}`).text();
			call_duration = $(`#call_duration_${id}`).text();
			user = "<?= $_SESSION[$db_prefix . '_UserName'] ?>";


			if (rating == 'Select') {
				swal.fire('Oops...', 'Please Select an Option First!', 'error');
				err = 1;
			}

			if (err == 0) {
				$(`#save_btn_${id}`).html('<i class="fa fa-refresh fa-spin"></i>');
				$.ajax({
						url: "<?php echo $_SERVER['PHP_SELF']; ?>",
						type: 'POST',
						data: {
							rating: rating,
							unique_id: unique_id,
							call_date: call_date,
							call_duration: call_duration,
							user: user,
							action: "add"
						},
					})
					.done(function(response) {
						// window.location = "icdr-stats.php";
						$(`#save_btn_${id}`).html('<span>Submit</span>');
						swal.fire('Done!', 'Rating Submited', 'success');
					})
					.fail(function() {
						swal.fire('Oops...', 'Something went wrong!', 'error');
					});
			}
		});


		$('#tbl').DataTable({
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
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				}, {
					extend: "csv",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				}, {
					extend: "excel",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				}, {
					extend: "pdf",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				}, {
					extend: "print",
					messageBottom: '<?php echo  "Total numbe of records : " . $ttl_record; ?>',
					messageTop: '<?php echo  $fdateTime . " - " . $tdateTime; ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					}
				},

			]
		});
	});
</script>
<?php include($site_admin_root . "includes/footer.php"); ?>