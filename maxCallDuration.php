<?php //include_once("includes/config.php"); 
?>
<?php
$page_name = "maxCallDuration.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Maxmimum Call Duration";
$page_menu_title = "Maximum Call Duration";
?>

<?php //include_once($site_root."includes/check.auth.php"); 
?>

<?php
/*include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();*/
?>
<?php //include($site_root."includes/header.php"); 
?>
<?php
//$total_records_count = $admin->get_records_count($txtSearch);
//include_once("includes/paging.php");
$recStartFrom = 0;
$field = empty($_REQUEST["field"]) ? "update_datetime" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "desc" : $_REQUEST["order"];
//	$rs = $admin->get_queue_wait_stats(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate);
//echo $search_keywords;
//die;
// if (isset($_REQUEST["fdate"]) && isset($_REQUEST["tdate"])) {
// 	$fdate           = $_REQUEST['fdate'];
// 	$tdate           = $_REQUEST['tdate'];
// } else {
// 	$fdate = date('Y-m-d');
// 	$tdate = date('Y-m-d');
// }

$rs = $admin->max_call_duration($search_keyword, addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime);
?>

<!--<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">-->
<div id="mid-col" class="mid-col">
	<div class="box">
		<h4 class="white"><?php echo ($page_title); ?></h4>
		<table class="table-short"id="tbl2" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
			<thead>
				<tr>
					<td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
				</tr>
				<tr>
					<!-- <td class="col-head2">Call ID</td>-->
					<td class="col-head2">Caller ID</td>
					<!--  <td class="col-head2">Customer ID</td> -->
					<!-- <td class="col-head2">Account No</td>-->
					<td class="col-head2">Wait In Queue</td>
					<!--<td class="col-head2">Start Time</td>-->
					<td class="col-head2">Agent Name</td>
					<td class="col-head2">Date</td>
					<td class="col-head2">Time</td>
					<td class="col-head2">Duration</td>
				</tr>
			</thead>
			<tbody>
					<?php
					$c2 = 0;
					while (!$rs->EOF) { ?>
						<?php
						//$data = $db_conn->Execute("SELECT caller_id,enqueue_duration AS duration,DATE(call_datetime) AS DATE,  TIME(call_datetime) AS TIME,  full_name AS agent_name,talk_time AS t_duration FROM cc_vu_queue_stats WHERE full_name = '" . $rs->fields["agent_name"] . "' AND talk_time = '" . $rs->fields["t_duration"] . "'  AND DATE(call_datetime) = '" . $rs->fields["DATE"] . "' ");
						// print_r($data);				
						//while (!$data->EOF) {
						?>
							<tr class="odd">
								<td class="col-first"><?php echo $rs->fields["caller_id"]; ?> </td>
								<td class="col-first"><?php echo $rs->fields["duration"]; ?> </td>
								<td class="col-first"><?php echo $rs->fields["agent_name"]; ?> </td>
								<td class="col-first">&nbsp;<?php echo $rs->fields["DATE"]; ?> </td>
								<td class="col-first">&nbsp;<?php echo $rs->fields["TIME"]; ?> </td>
								<td class="col-first">&nbsp;<?php echo $rs->fields["t_duration"]; ?> </td>
							</tr>


					<?php
							$stringData .= $rs->fields["caller_id"] . ", " . $rs->fields["duration"] . ", " . $rs->fields["agent_name"] . ", " . $rs->fields["DATE"] . ", " . $rs->fields["TIME"] . ", " . $rs->fields["t_duration"] . "\r\n";
							//$data->MoveNext();
						//}


						$rs->MoveNext();
						$c2++;
					} ?>
				</tbody>
		</table>

		
		</br>
		<div style="float:right;">Total number MAXMIMUM CALL DURATION : <b><?php echo " " . $c1; ?></b> </div>
		</br> </br>
	</div>
