<link href="css/style.css" rel="stylesheet" type="text/css" />
<style type="text/css">
	#panel8,
	#flip8 {
		border-bottom: 1px dotted #d6d8d9;
	}

	#panel8 {
		display: none;
	}

	div.box-container {
		padding: 0px;
	}

	ul.list-links,
	div#to-do-list ul {
		padding: 0px;
	}

	body,
	html {
		background: none;
		height: auto;
	}
</style>
<?php
/*error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);*/
include_once('includes/ticket_sys/config.php');
$agent_online = selectMe('COUNT(*)', 'admin', ' is_phone_login=1 and is_crm_login = 1 and group_id=1');
// $agent_online = selectMe('COUNT(*)', 'admin', ' is_phone_login=1 and is_crm_login = 1');
$agent_on_calls = selectMe('COUNT(*)', 'admin', 'is_busy = 1');

/* Total Calls */
/*13- 3 -16*/
//$total_calls = selectMe('COUNT(DISTINCT(unique_id))', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) and STATUS = 0'); 
$total_calls = selectMe('COUNT(unique_id)', 'queue_stats', 'DATE(call_datetime)= DATE(NOW()) and STATUS = 0 AND call_type <>"" ');

/* Rec Calls */
$rec_calls = selectMe('COUNT(DISTINCT(unique_id))', 'queue_stats', 'call_status= \'ANSWERED\' AND DATE(call_datetime) = DATE(NOW()) and call_type=\'INBOUND\' ');

/* Dialed Calls */
$dial_calls = selectMe('COUNT(DISTINCT(unique_id))', 'queue_stats', ' DATE(call_datetime) = DATE(NOW()) and call_type=\'OUTBOUND\' and TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> \'00:00:00\''); //and TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> \'00:00:00\'

/* Dialed Calls */
$dial_calls_unanswer = selectMe('COUNT(DISTINCT(unique_id))', 'queue_stats', ' DATE(call_datetime) = DATE(NOW()) and call_type=\'OUTBOUND\' and TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) = \'00:00:00\''); //and TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> \'00:00:00\'

/* Drop Calls */
//$drop_calls = selectMe('COUNT(DISTINCT(unique_id))', 'queue_stats', '(TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) = \'00:00:00\' OR staff_id IS NULL) AND DATE(update_datetime) = DATE(NOW())  AND STATUS = 0 AND call_type = \'INBOUND\' AND call_status = \'DROP\'');
$drop_calls = selectMe('COUNT(DISTINCT(unique_id))', 'queue_stats', ' DATE(call_datetime) = DATE(NOW())  AND STATUS = 0 AND call_type = \'INBOUND\' AND call_status = \'DROP\'');

/* OFF TIME Calls */
$offTime_calls = selectMe(
	'COUNT(DISTINCT(unique_id))',
	'queue_stats',
	'STATUS = 0
                AND call_type = \'INBOUND\' 
                AND DATE(call_datetime) = DATE(NOW()) AND  (call_status = \'OFFTIME\' )'
);
/*Transfered*/
/*$transf_calls = selectMe('COUNT(DISTINCT(unique_id))', 'queue_stats',
        'STATUS = 0
                AND call_type = \'INBOUND\'
               AND DATE(update_datetime) = DATE(NOW()) AND  (call_status = \'TRANSFER\' ) ');	*/
$transf_calls = selectMe(
	'COUNT(unique_id)',
	'queue_stats',
	'STATUS = 0
                AND call_type = \'INBOUND\'
               AND DATE(call_datetime) = DATE(NOW()) AND  (call_status = \'ABANDONED\' ) '
);
/*Transfered*/
/*$shift_calls = selectMe('COUNT(DISTINCT(unique_id))', 'queue_stats',
        'STATUS = 0
                AND call_type = \'INBOUND\'
               AND DATE(update_datetime) = DATE(NOW()) AND  (call_status = \'SHIFT\' ) ');*/
$shift_calls = selectMe(
	'COUNT(unique_id)',
	'queue_stats',
	'STATUS = 0
                AND call_type = \'INBOUND\'
               AND DATE(update_datetime) = DATE(NOW()) AND  (call_status = \'SHIFT\' ) '
);

/* IVR Calls */
//$ivr_calls = selectMe('COUNT(DISTINCT(unique_id))', 'queue_stats',
//'STATUS = 0
//        AND call_type = \'INBOUND\'
//        AND DATE(update_datetime) = DATE(NOW()) AND  (call_status = \'IVR\' ) ');

/* Enqueue */
$inqueue_calls = selectMe('COUNT(*)', 'queue_stats', 'DATE(call_datetime)= DATE(NOW()) AND status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')');
/* Enqueue 1 */
$inqueue_call_cgt = selectMe(
	'COUNT(*)',
	'queue_stats',
	'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=1 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')'
);
/* Enqueue 2 */
$inqueue_call_ncss = selectMe(
	'COUNT(*)',
	'queue_stats',
	'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=2 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')'
);
/* Enqueue 3 */
$inqueue_call_gi = selectMe(
	'COUNT(*)',
	'queue_stats',
	'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=3 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')'
);
/* Enqueue 4 */
$inqueue_call_lahore = selectMe(
	'COUNT(*)',
	'queue_stats',
	'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=4 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')'
);
/* Enqueue 5 */
$inqueue_call_islamabad = selectMe(
	'COUNT(*)',
	'queue_stats',
	'DATE(update_datetime)= DATE(NOW()) AND ivr_selection=5 and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')'
);

/* Average Enqueue */
$avg_inqueued_calls = selectMe('SEC_TO_TIME(ROUND(AVG(TIME_TO_SEC(TIMEDIFF(time(dequeue_datetime),time(enqueue_datetime))))))', 'queue_stats', 'TIMEDIFF(dequeue_datetime,enqueue_datetime) <> \'00:00:00\' AND TIMEDIFF(dequeue_datetime,enqueue_datetime) > \'00:00:10\' AND DATE(call_datetime) = DATE(NOW())');

/* Average talk Time */
$avg_talk_calls = selectMe('SEC_TO_TIME(ROUND(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))/COUNT(id)))', 'queue_stats', 'TIMEDIFF(staff_end_datetime,staff_start_datetime) <> \'00:00:00\' AND DATE(call_datetime) = DATE(NOW()) ORDER BY id DESC');

/* Pin Genrate */
$pin_generate = selectMe('COUNT(*)', 'user_pin', ' DATE(update_datetime)= DATE(NOW()) AND status = 1');
?>

<!--<h4 class="light-grey">Call Center Stats</h4>-->
<div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 0px;">
	<ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Agents Online: <?php echo $agent_online ?></a> </li>
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Agents on Calls: <?php echo $agent_on_calls; ?></a> </li>
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Total Calls: <?php echo $total_calls; ?></a> </li>
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Answered Calls: <?php echo $rec_calls; ?></a> </li>
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Abandoned Calls: <?php echo $transf_calls; ?></a> </li>
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Dialed Calls (Success): <?php echo $dial_calls; ?></a> </li>
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Dialed Calls (Failed): <?php echo $dial_calls_unanswer; ?></a> </li>
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Drop Calls: <?php echo $drop_calls; ?></a> </li>
		<!--<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>IVR Calls: <?php //echo $ivr_calls;
																																																																																																																																	?></a> </li>-->
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Off Time Calls: <?php echo $offTime_calls; ?></a> </li>
		<!-- <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Total InQueued: <?php //echo $total_inqueue_calls;
																																																																																																																																				?></a> </li> -->
		<!--<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span> Queue Lahore:
      <?php echo  $inqueue_call_lahore; ?>
      </a> </li>
    <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span> Queue Islamabad :
      <?php echo  $inqueue_call_islamabad; ?>
      </a> </li>-->
		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Avg. Talk Time: <?php echo $avg_talk_calls; ?></a> </li>
	</ul>
</div>
