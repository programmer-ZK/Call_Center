

<script src="jquery.js"></script>
<script> 
$(document).ready(function(){
  $("#flip9").click(function(){
    $("#panel9").slideToggle("slow");
	$("#flip9 h4 div + div").toggleClass('arrow_down');
  });
});
</script>
 
<style type="text/css"> 
#panel9,#flip9
{
border-bottom:1px dotted #d6d8d9;
}
#panel9
{
	display:none;

}
</style>


	<?php 
		include_once("classes/tools_admin.php");		
		$tools_admin = new tools_admin(); 
		
		/*$total_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) and status = 0 and staff_id = \''.$_SESSION[$db_prefix.'_UserId'].'\'');*/ //($_SESSION[$db_prefix.'_UserId']);
		//$rec_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) AND status = 0' );
		$rec_calls = $tools_admin->select('COUNT(*)', 'queue_stats', ' staff_id = \''.$_SESSION[$db_prefix.'_UserId'].'\' AND DATE(update_datetime) = DATE(NOW()) AND TIMEDIFF(staff_end_datetime,staff_start_datetime) > \'00:00:00\' AND STATUS=0 AND call_type=\'INBOUND\'' );
		//$dial_calls = $tools_admin->select('COUNT(*)', 'queue_stats', ' staff_id = \''.$_SESSION[$db_prefix.'_UserId'].'\' AND DATE(update_datetime) = DATE(NOW()) AND TIMEDIFF(staff_end_datetime,staff_start_datetime) > \'00:00:00\' AND STATUS=0 AND call_type=\'OUTBOUND\'' );
		$dial_calls = $tools_admin->select('COUNT(*)', 'queue_stats', ' staff_id = \''.$_SESSION[$db_prefix.'_UserId'].'\' AND DATE(update_datetime) = DATE(NOW()) AND STATUS=0 AND call_type=\'OUTBOUND\'' );
		//$dial_calls = $tools_admin->select('COUNT(*)', 'cdr', '  DATE(calldate) = DATE(NOW()) and lastdata like \'%,'.$_SESSION[$db_prefix.'_UserId'].',%\' and call_type=\'OUTBOUND\'' );
		
		$abandoned_calls = $tools_admin->select('COUNT(*)', 'abandon_calls', ' DATE(update_datetime) = DATE(NOW()) AND status = 1 and staff_id = \''.$_SESSION[$db_prefix.'_UserId'].'\' ' );
		$avg_talk_calls = $tools_admin->select('SEC_TO_TIME(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))/COUNT(id))', 'queue_stats', 'TIMEDIFF(staff_end_datetime,staff_start_datetime) > \'00:00:00\' and staff_id = \''.$_SESSION[$db_prefix.'_UserId'].'\' AND DATE(update_datetime) = DATE(NOW()) AND STATUS=0 ORDER BY id DESC' );
		//$total_inqueue_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'TIMEDIFF(dequeue_datetime,enqueue_datetime) <> \'00:00:00\' AND TIMEDIFF(dequeue_datetime,enqueue_datetime) > \'00:00:10\' AND DATE(update_datetime) = DATE(NOW()) ORDER BY id DESC' );
		//$inqueue_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) and staff_id = \''.$_SESSION[$db_prefix.'_UserId'].'\' AND status = 1' );
		//$abandoned_calls = $tools_admin->select('COUNT(*)', 'queue_stats_logs', 'DATE(update_datetime)= DATE(NOW()) and staff_id = \''.$_SESSION[$db_prefix.'_UserId'].'\' AND status = 2' );
		/*$avg_inqueued_calls = $tools_admin->select('sum(update_datetime)/COUNT(*)', 'queue_stats', 'TIMEDIFF(dequeue_datetime,enqueue_datetime) <> \'00:00:00\' AND TIMEDIFF(dequeue_datetime,enqueue_datetime) > \'00:00:10\'
AND DATE(update_datetime) = DATE(NOW()) ORDER BY id DESC' );*/
		/*$last_hour = $tools_admin->select('COUNT(*)', 'queue_stats', ' HOUR(update_datetime) = HOUR(NOW()) - 1 AND DATE(update_datetime)= DATE(NOW()) AND status = 0' );
		$last_three_hour = $tools_admin->select('COUNT(*)', 'queue_stats', ' HOUR(update_datetime) = HOUR(NOW()) - 3 AND DATE(update_datetime)= DATE(NOW()) and  status = 0' );
		
		$nine_three = $tools_admin->select('COUNT(*)', 'queue_stats', ' TIME(update_datetime) BETWEEN \'09:00:00\' AND \'14:59:59\' AND DATE(update_datetime)= DATE(NOW()) AND status = 0' );
		
		$three_nine = $tools_admin->select('COUNT(*)', 'queue_stats', ' TIME(update_datetime) BETWEEN \'15:00:00\' AND \'21:59:59\' AND DATE(update_datetime)= DATE(NOW()) AND status = 0' );*/
		$pin_generate = $tools_admin->select('COUNT(*)', 'user_pin', ' DATE(update_datetime)= DATE(NOW()) AND status = 1' );
		
	?>
	<div class="box">
		<div id="flip9"><h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">My Stats</h4></div>
				<div id="panel9">
		<!--<h4 class="light-grey">My Stats</h4>-->
			  <div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
				<ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
						  <!--<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Total In Calls: <?php //echo $total_calls;?></a> </li>-->
						  <li class="ui-accordion-li-fix"> <a href="mystats_report.php?type=recieved" target="_blank" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Received Calls: <?php echo $rec_calls;?></a> </li>
						    <li class="ui-accordion-li-fix"> <a href="mystats_report.php?type=dialed" target="_blank" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Dialed Calls: <?php echo $dial_calls;?></a> </li>
					<!-- <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Drop Calls: <?php //echo $drop_calls;?></a> </li>  -->
					  <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Abandoned Calls: <?php echo $abandoned_calls;?></a> </li>
					    <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Avg. Talk Time: <?php echo $avg_talk_calls;?></a> </li> 
						 <!-- <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Total InQueued: <?php //echo $total_inqueue_calls;?></a> </li> -->
						 <!-- <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>InQueue: <?php //echo $inqueue_calls;?></a> </li> -->
						 <!-- <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Last Hour Rec. Calls: <?php //echo $last_hour;?></a> </li> 
						   <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Last 3 Hour Rec. Calls: <?php //echo $last_three_hour;?></a> </li> 
						   <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Rec. Calls (9:00 to 3:00): <?php //echo $nine_three;?></a> </li>
						   <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Rec. Calls (3:00 to 9:00): <?php //echo $three_nine;?></a> </li>-->
						   <!--<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Avg InQueued Calls: <?php //echo $avg_inqueued_calls;?></a> </li>--> 
						  <!-- JD
                          <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>PIN's Generated: <?php /*?><?php echo $pin_generate?><?php */?></a> </li>
						<li class="ui-accordion-li-fix"><a href="agent_performance_report_agentwise.php">My Performance Weekly</a> </li>-->
						   
						  
				 </ul></div>
			</div>
	</div>
