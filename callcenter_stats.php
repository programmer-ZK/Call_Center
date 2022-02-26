<script src="jquery.js"></script>
<script> 
$(document).ready(function(){
  $("#flip8").click(function(){
    $("#panel8").slideToggle("slow");
	$("#flip8 h4 div + div").toggleClass('arrow_down');
  });
  
});
</script>
<style type="text/css"> 
#panel8,#flip8{border-bottom:1px dotted #d6d8d9;}
#panel8{display:none;}
</style>
	
    <?php 
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		include_once("classes/tools_admin.php");		
		$tools_admin = new tools_admin(); 
		
		$agent_online = $tools_admin->select('COUNT(*)', 'admin', ' is_phone_login=1 and is_crm_login = 1');
		$agent_on_calls = $tools_admin->select('COUNT(*)', 'admin', 'DATE(staff_updated_date)= DATE(NOW()) and is_busy = 1');
		
		/* Total Calls */
		$total_calls = $tools_admin->select('COUNT(DISTINCT(unique_id))', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) and STATUS = 0'); 
		
		/* Rec Calls */
		$rec_calls = $tools_admin->select('COUNT(DISTINCT(unique_id))', 'queue_stats', 'TIMEDIFF(staff_end_datetime,staff_start_datetime) > \'00:00:00\' AND DATE(update_datetime) = DATE(NOW()) and call_type=\'INBOUND\' ' );
		
		/* Dialed Calls */
		$dial_calls = $tools_admin->select('COUNT(DISTINCT(unique_id))', 'queue_stats', ' DATE(update_datetime) = DATE(NOW()) and call_type=\'OUTBOUND\' and TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> \'00:00:00\'' ); //and TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> \'00:00:00\'
		
		/* Dialed Calls */
		$dial_calls_unanswer = $tools_admin->select('COUNT(DISTINCT(unique_id))', 'queue_stats', ' DATE(update_datetime) = DATE(NOW()) and call_type=\'OUTBOUND\' and TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) = \'00:00:00\'' ); //and TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> \'00:00:00\'
		
		/* Drop Calls */
		$drop_calls = $tools_admin->select('COUNT(DISTINCT(unique_id))', 'queue_stats', '(TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) = \'00:00:00\' OR staff_id IS NULL) AND DATE(update_datetime) = DATE(NOW())  AND STATUS = 0 AND call_type = \'INBOUND\' AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\') ');
		
		/* OFF TIME Calls */
		$offTime_calls = $tools_admin->select('COUNT(DISTINCT(unique_id))', 'queue_stats',
        'STATUS = 0
                AND call_type = \'INBOUND\'
                AND DATE(update_datetime) = DATE(NOW()) AND  (call_status = \'OFFTIME\' )');
		
		/* IVR Calls */
		$ivr_calls = $tools_admin->select('COUNT(DISTINCT(unique_id))', 'queue_stats',
        'STATUS = 0
                AND call_type = \'INBOUND\'
                AND DATE(update_datetime) = DATE(NOW()) AND  (call_status = \'IVR\' ) ');
		
		/* Enqueue */
		$inqueue_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) AND status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')' );
/* Enqueue 1 */
		$inqueue_call_cgt = $tools_admin->select('COUNT(*)', 
		          'queue_stats', 
				  'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=1 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')' );
/* Enqueue 2 */
		$inqueue_call_ncss = $tools_admin->select('COUNT(*)', 
		          'queue_stats', 
				  'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=2 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')' );
/* Enqueue 3 */
		$inqueue_call_gi = $tools_admin->select('COUNT(*)', 
		          'queue_stats', 
				  'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=3 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')' );
/* Enqueue 4 */
		$inqueue_call_lahore = $tools_admin->select('COUNT(*)', 
		          'queue_stats', 
				  'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=4 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')' );
/* Enqueue 5 */
		$inqueue_call_islamabad = $tools_admin->select('COUNT(*)', 
		          'queue_stats', 
				  'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=5 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')' );

		/* Average Enqueue */		
		$avg_inqueued_calls = $tools_admin->select('SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(time(dequeue_datetime),time(enqueue_datetime)))))', 'queue_stats', 'TIMEDIFF(dequeue_datetime,enqueue_datetime) <> \'00:00:00\' AND TIMEDIFF(dequeue_datetime,enqueue_datetime) > \'00:00:10\' AND DATE(update_datetime) = DATE(NOW())' );
		
		/* Average talk Time */		
		$avg_talk_calls = $tools_admin->select('SEC_TO_TIME(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))/COUNT(id))', 'queue_stats', 'TIMEDIFF(staff_end_datetime,staff_start_datetime) <> \'00:00:00\' AND DATE(update_datetime) = DATE(NOW()) ORDER BY id DESC' );

 /* Pin Genrate */		
$pin_generate = $tools_admin->select('COUNT(*)', 'user_pin', ' DATE(update_datetime)= DATE(NOW()) AND status = 1' );
		?>
<div id="panel8"> 
  <!--<h4 class="light-grey">Call Center Stats</h4>-->
  <div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
    <ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Agents Online: <?php echo $agent_online;?></a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Agents on Calls: <?php echo $agent_on_calls;?></a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Total Calls: <?php echo $total_calls;?></a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Received Calls: <?php echo $rec_calls;?></a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Dialed Calls (Successfull): <?php echo $dial_calls;?></a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Dialed Calls (Unsuccessfull): <?php echo $dial_calls_unanswer;?></a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Drop Calls: <?php echo $drop_calls;?></a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>IVR Calls: <?php echo $ivr_calls;?></a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>OFF TIME Calls: <?php echo $offTime_calls;?></a> </li>
      <!-- <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Total InQueued: <?php //echo $total_inqueue_calls;?></a> </li> -->
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>InQueue: <?php echo $inqueue_calls;?></a> </li>
      <?php //if(admin_login){ print_r($_SESSION['cc_UserGroupId']?>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span> IQueue CGT:
        <?php  echo  $inqueue_call_cgt ;?>
        </a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span> IQueue A/C Opening & NCSS:
        <?php  echo  $inqueue_call_ncss  ;?>
        </a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span> IQueue General Inquiry:
        <?php  echo  $inqueue_call_gi  ;?>
        </a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span> IQueue Lahore:
        <?php  echo  $inqueue_call_lahore  ;?>
        </a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span> IQueue Islamabad :
        <?php  echo  $inqueue_call_islamabad;?>
        </a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Avg. Queue Time: <?php echo $avg_inqueued_calls;?></a> </li>
      <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Avg. Talk Time: <?php echo $avg_talk_calls;?></a> </li>
      <!-- <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Last 3 Hour Rec. Calls: <?php //echo $last_three_hour;?></a> </li> 
						   <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Rec. Calls (9:00 to 3:00): <?php //echo $nine_three;?></a> </li>
						   <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Rec. Calls (3:00 to 9:00): <?php //echo $three_nine;?></a> </li>--> 
      <!--<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Avg InQueued Calls: <?php //echo $avg_inqueued_calls;?></a> </li>--> 
      <!-- JD
                            <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>PIN's Generated: <?php /*?><?php echo $pin_generate?><?php */?></a> </li>-->
      
    </ul>
  </div>
</div>

	
