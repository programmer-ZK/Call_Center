<?php //include_once("includes/config.php"); 
?>
<?php
$page_name = "call_Ans_Time_stats.php";
$page_level = "0";
$page_group_id = "0";
$page_title = "Received Call Stats";
$page_menu_title = "Queue Wait Stats";
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
if (isset($_REQUEST["fdate"]) && isset($_REQUEST["tdate"])) {
	$fdatetime = date('Y-m-d H:i:s', strtotime($fdatetime));
	$tdatetime = date('Y-m-d H:i:s', strtotime($tdatetime));
} else {
	$fdatetime = date('Y-m-d') . ' 00:00:00';
	$tdatetime = date('Y-m-d') . ' 23:59:00';
}

$rs = $admin->get_queue_wait_stats($search_keyword, addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime);
?>

<!--<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">-->
<div id="mid-col" class="mid-col">
	<div class="box">
		<h4 class="white"><?php echo ($page_title); ?></h4>
		<table class="table-short" id="tbl" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
			<thead>
				<tr>
					<td colspan="12" class="paging"><?php echo ($paging_block); ?></td>
				</tr>
				<tr>
					<!-- <td class="col-head2">Call ID</td>-->
					<td class="col-head2">Caller ID</td>
					<!--  <td class="col-head2">Customer ID</td> -->
					<!-- <td class="col-head2">Account No</td>-->
					<td class="col-head2">Call Answering Time</td>
					<!--<td class="col-head2">Start Time</td>-->
					<td class="col-head2">Agent Name</td>
					<td class="col-head2">Date</td>
					<td class="col-head2">Time</td>
					<!-- <td class="col-head2">Duration</td> -->
				</tr>
			</thead>
			<tbody>
					<?php
					$c1 = 0;
					while (!$rs->EOF) { ?>
						<?php

						?>
						<tr class="odd">
							<!--  <td class="col-first"><?php //echo $rs->fields["unique_id"]; 
																					?> </td>-->
							<td class="col-first"><?php echo $rs->fields["caller_id"]; ?> </td>
							<!--	<td class="col-first"><?php // echo $rs->fields["customer_id"]; 
																					?> </td> -->
							<!--<td class="col-first"><?php //echo $rs->fields["account_no"]; 
																				?> </td>-->
							<td class="col-first"><?php echo $rs->fields["duration"]; ?> </td>
							<!--<td class="col-first"><?php //echo $rs->fields["staff_start_datetime"]; 
																				?> </td>-->
							<td class="col-first"><?php echo $rs->fields["agent_name"]; ?> </td>
							<td class="col-first">&nbsp;<?php echo date('d-m-Y', strtotime($rs->fields["DATE"])); ?> </td>
							<td class="col-first">&nbsp;<?php echo date('h:i:s A', strtotime($rs->fields["TIME"])); ?> </td>
							<!-- <td class="col-first">&nbsp;<?php echo $rs->fields["t_duration"]; ?> </td> -->
						</tr>


					<?php
						$stringData .= $rs->fields["caller_id"] . ", " . $rs->fields["customer_id"] . ", " . $rs->fields["duration"] . ", " . $rs->fields["agent_name"] . ", " . $rs->fields["DATE"] . ", " . $rs->fields["TIME"] . ", " . $rs->fields["t_duration"] . "\r\n";

						$rs->MoveNext();
						$c1++;
					} ?>
				</tbody>
		</table>

	 
		</br>
		<div style="float:right; font-size: 15px;">Total number of Received calls: <b><?php echo $c1; ?></b></div>
		</br> </br>
	</div>
</div>



<?php
/*if(isset($_REQUEST['export']))
{

            //$db_export_server = $site_root."download/Pin_Reset_Records_".$today.".csv";
                $db_export_fix = $site_root."download/Pin_Reset_Records.csv";

                //$heading = "Unique ID, Caller Id, Customer ID, Status, File ID, Date,  Time,  Agent Name\r\n";
                shell_exec("echo '".$str."' > ".$db_export_fix);
                //shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);

                 ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-type: application/force-download");
    //header("Content-Type: text/csv");

        //echo $db_export; exit;
    header("Content-Disposition: attachment; filename=".basename($db_export_fix).";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($db_export_fix));
    readfile($db_export_fix);
    if(file_exists($db_export_fix) && !empty($file_name)){
     unlink($db_export_fix);
     }
     exit();

}*/

?>
<!--</div> -->
<!--</form>-->
<?php //include($site_admin_root."includes/footer.php"); 
?>