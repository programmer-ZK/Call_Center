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
include_once('includes/ticket_sys/config.php');
$inque_type = array('1' => 'CGT', '2' => 'NCSS', '3' => 'G. Inquiry', '4' => 'Lahore', '5' => 'Islamabad');
$rec_calls = selectMe('COUNT(*)', 'queue_stats', ' staff_id = \'' . $_REQUEST['user_id'] . '\' AND DATE(call_datetime) = DATE(NOW()) AND call_status = \'ANSWERED\' AND STATUS=0 AND call_type=\'INBOUND\'');

$dial_calls = selectMe('COUNT(*)', 'queue_stats', ' staff_id = \'' . $_REQUEST['user_id'] . '\' AND DATE(call_datetime) = DATE(NOW()) AND STATUS=0 AND TIMEDIFF(staff_end_datetime,staff_start_datetime) > \'00:00:00\' AND call_type=\'OUTBOUND\'');
//echo  'COUNT( DISTINCT unique_id)', 'abandon_calls', ' DATE(update_datetime) = DATE(NOW()) AND status = 1 and staff_id = \''.$_REQUEST['user_id'].'\' group by unique_id' ;
$abandoned_calls = selectMe('COUNT(*)', 'queue_stats', ' DATE(call_datetime) = DATE(NOW()) and call_status=\'DROP\' and staff_id = \'' . $_REQUEST['user_id'] . '\'');
$avg_talk_calls = selectMe('SEC_TO_TIME(ROUND(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))/COUNT(id)))', 'queue_stats', 'call_status = \'ANSWERED\' and staff_id = \'' . $_REQUEST['user_id'] . '\' AND DATE(call_datetime) = DATE(NOW()) AND STATUS=0 AND call_type=\'INBOUND\' ORDER BY id DESC');

$pin_generate = selectMe('COUNT(*)', 'user_pin', ' DATE(update_datetime)= DATE(NOW()) AND status = 1');
/* Enqueue 1 */
$inqueue_call = selectMe(
	'COUNT(*)',
	'queue_stats',
	'DATE(update_datetime)= DATE(NOW()) AND ivr_selection= \'' . $_REQUEST['group'] . '\' and cc_queue_stats.status = 1  AND (call_status <> \'IVR\' AND call_status <> \'OFFTIME\')'
);

?>

<div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
	<ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">

		<li class="ui-accordion-li-fix"> <a href="mystats_report.php?type=recieved" target="_blank" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Answered Calls: <?php echo $rec_calls; ?></a> </li>
		<li class="ui-accordion-li-fix"> <a href="mystats_report.php?type=dialed" target="_blank" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Dialed Calls: <?php echo $dial_calls; ?></a> </li>

		<li class="ui-accordion-li-fix"> <a href="mystats_report.php?type=abandoned" target="_blank" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Drop Calls: <?php echo $abandoned_calls; ?></a> </li>
		<!--<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Queue <?php echo $inque_type[$_REQUEST['group']]; ?>: <?php echo $inqueue_call; ?></a> </li>-->

		<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span>Avg. Talk Time: <?php echo $avg_talk_calls; ?></a> </li>


	</ul>
</div>
