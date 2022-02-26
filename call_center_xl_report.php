<?php include_once("includes/config.php"); ?>
<?php include_once($site_root . "includes/check.auth.php");

include_once("classes/admin.php");
$admin = new admin();

include_once("classes/reports.php");
$reports = new reports();

include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();

include_once("classes/user_tools.php");
$user_tools = new user_tools();

?>


<?php
if (isset($_REQUEST['export_xl'])) {
  $search_keyword   = $_REQUEST['search_keyword'];

  $fdatetime        =  $_REQUEST['fdatetime'];
  $tdatetime        =  $_REQUEST['tdatetime'];
} else {
  $fdate             =  date('d-m-Y');
  $tdate             =   date('d-m-Y');
  $static_stime      =     "00:00:00";
  $static_etime      =     "23:59:59";

  $fdatetime        = date('Y-m-d', strtotime($fdate)) . " " . $static_stime;
  $tdatetime        = date('Y-m-d', strtotime($tdate)) . " " . $static_etime;

  $search_keyword    = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}

$nature_of_calls                = $reports->nature_of_calls($fdatetime, $tdatetime);
$drop_calls                     = $reports->drop_calls($fdatetime, $tdatetime);
$abandon_calls                 = $reports->abandon_new_calls($fdatetime, $tdatetime);
$total_talk_time                = $reports->total_talk_time($fdatetime, $tdatetime);
$busy_time                      = $reports->busy_time($fdatetime, $tdatetime);
$avg_busy_time                  = $reports->avg_busy_time($fdatetime, $tdatetime);
$average_queue_time     = $reports->average_queue_time($fdatetime, $tdatetime);
$avg_total_talk_time    = $reports->avg_total_talk_time($fdatetime, $tdatetime);
$pin_report                     = $reports->pin_report($fdatetime, $tdatetime);
$trans_report                   = $reports->trans_report($fdatetime, $tdatetime);

$recStartFrom = 0;
$field = empty($_REQUEST["field"]) ? "staff_updated_date" : $_REQUEST["field"];
$order = empty($_REQUEST["order"]) ? "asc" : $_REQUEST["order"];
$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, '', '');
$groups = $reports->get_evaluation_groups();



// Filter the excel data 
function filterData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "Call_center_stats_report.xls";


// -------------- First Table -----------
if (true) {

  $excelData = implode("\t", array('Nature Of Calls')) . "\n";

  // Column names 
  $fields = array('Call Type', 'Number of Calls', 'Percent');
  // Display column names as first row 
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Output each row of the data 
  while (!$nature_of_calls->EOF) {
    $t_calls =  $nature_of_calls->fields["total"];

    $lineData = array(
      $nature_of_calls->fields["call_type"],
      $nature_of_calls->fields["total_calls"],
      round($nature_of_calls->fields["percent"], 2) . "%"
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $nature_of_calls->MoveNext();
  }
  // Total
  $fields = array('Total', $t_calls);
  $excelData .= implode("\t", array_values($fields)) . "\n";
}

// 'DROP CALLS
$fields = array("\n" . 'DROP CALLS', $drop_calls->fields["drop_calls"]);
$excelData .= implode("\t", array_values($fields));

// ABANDONED CALLS
$fields = array("\n" . 'ABANDONED CALLS', $abandon_calls->fields["abandon_calls"]);
$excelData .= implode("\t", array_values($fields)) . "\n\n";


// -------------- Second Table -----------
if (true) {
  // Column names 
  $fields = array('Caller Id', 'Talk Time');

  $excelData .= implode("\t",  array("TOTAL TALK TIME")) . "\n";

  // Display column names as first row 
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Output each row of the data 
  while (!$total_talk_time->EOF) {
    $no_calls =  $total_talk_time->fields["total_time"];

    $lineData = array(
      $total_talk_time->fields["call_type"],
      $total_talk_time->fields["talk_time"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $total_talk_time->MoveNext();
  }
  // Total
  $fields = array('Total', $no_calls);
  $excelData .= implode("\t", array_values($fields)) . "\n\n";
}


// -------------- Third Table -----------
if (true) {
  // Column names 
  $fields = array('Caller Id', 'Talk Time');

  $excelData .= implode("\t",  array("AVG TOTAL TALK TIME")) . "\n";

  // Display column names as first row 
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Output each row of the data 
  while (!$avg_total_talk_time->EOF) {
    $lineData = array(
      $avg_total_talk_time->fields["call_type"],
      $avg_total_talk_time->fields["talk_time"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $avg_total_talk_time->MoveNext();
  }
}

$I_new = $reports->get_agent_hold_times_new_live_agents('', $fdatetime, $tdatetime);
$I = $I_new->fields["hold_time"];
$J_new = $reports->get_agent_hold_calls('', $fdatetime, $tdatetime);
$J = $J_new->fields["hold_calls"];

$fpos1 = strpos($I, ':', 0);
$fpos2 = strpos($I, ':', $fpos1 + 1);
$hour = substr($I, 0, $fpos1);
$min = substr($I, $fpos1 + 1, $fpos2 - $fpos1 - 1);
$sec = substr($I, $fpos2 + 1);

$firsttime = ($hour * 3600) + ($min * 60) + $sec;
$avgholdsec = $firsttime / $J;

$hours = floor($avgholdsec / 3600);
$avgholdsec -= $hours * 3600;
$minutes  = floor($avgholdsec / 60);
$avgholdsec -= $minutes * 60;
$seconds = $avgholdsec;

$avg = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);


// AAVG HOLD TIME
$fields = array("\n" . 'AAVG HOLD TIME', $avg);
$excelData .= implode("\t", array_values($fields)) . "\n\n";


// Headers for download 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render excel data 
echo $excelData;

exit;
