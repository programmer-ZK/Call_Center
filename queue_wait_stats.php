 <?php
	$page_name = "queue_wait_stats.php";
	$page_level = "0";
	$page_group_id = "0";
	$page_title = "Received Call Stats";
	$page_menu_title = "Queue Wait Stats";
	?>

 <?php
	$rs = $admin->get_queue_wait_stats($search_keyword, addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime);
	?>


 <div id="mid-col" class="mid-col">
 	<div class="box">
 		<h4 class="white"><?php echo ($page_title); ?></h4>
 		<table class="table-short" id="tbl" style="background-color:#FFFFFF;">
 			<thead>
 				<tr>
 					<td class="col-head2">Caller ID</td>
 					<td class="col-head2">Wait In Queue</td>
 					<td class="col-head2">Agent Name</td>
 					<td class="col-head2">Date</td>
 					<td class="col-head2">Time</td>
 					<td class="col-head2">Duration</td>
 					<td class="col-head2">Hold Time</td>
 				</tr>
 			</thead>
 			<tbody>
 				<?php
					$c1 = 0;
					while (!$rs->EOF) { ?>
 					<?php

						?>
 					<tr class="odd">
 						<td class="col-first"><?php echo $rs->fields["caller_id"]; ?> </td>
 						<td class="col-first"><?php echo $rs->fields["duration"]; ?> </td>
 						<td class="col-first"><?php echo $rs->fields["agent_name"]; ?> </td>
 						<td class="col-first">&nbsp;<?php echo date('d-m-Y', strtotime($rs->fields["DATE"])); ?> </td>
 						<td class="col-first">&nbsp;<?php echo date('h:i:s A', strtotime($rs->fields["TIME"])); ?> </td>
 						<td class="col-first">&nbsp;<?php echo $rs->fields["t_duration"]; ?> </td>
 						<td class="col-first">&nbsp;<?php $uniqueid = $rs->fields["unique_id"];
																					$new_rs = $admin->get_particular_hold($uniqueid);
																					echo $new_rs->fields["new_t_time"];
																					?></td>
 					</tr>


 				<?php
						$stringData .= $rs->fields["caller_id"] . ", " . $rs->fields["customer_id"] . ", " . $rs->fields["duration"] . ", " . $rs->fields["agent_name"] . ", " . $rs->fields["DATE"] . ", " . $rs->fields["TIME"] . ", " . $rs->fields["t_duration"] . ", " . $new_rs->fields["new_t_time"] . "\r\n";

						$rs->MoveNext();
						$c1++;
					} ?>
 			</tbody>
 		</table>

 		</br>
 		</br>
 		<div style="float:right; font-size: 15px;">Total number of Received calls: <b><?php echo $c1; ?></b></div>
 		</br>
 		</br> </br>
 	</div>
 </div>