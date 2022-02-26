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


// Filter the excel data 
function filterData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "Daily_stats_report.xls";

$excelData = implode("\t", array('From :', $fdatetime)) . "\n";
$excelData .= implode("\t", array('To :', $tdatetime)) . "\n\n";


// -------------- First Table -----------
if (true) {

  // Column names 
  $excelData .= implode("\t", array('RECEIVED CALL STATS')) . "\n";

  $fields = array('Caller Id', 'Wait in queue', 'Agent Name', 'Date', 'Time', 'Duration', 'Hold Time');

  // Display column names as first row 
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs = $admin->get_queue_wait_stats($search_keyword, addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime);

  // Output each row of the data 
  while (!$rs->EOF) {
    $uniqueid = $rs->fields["unique_id"];
    $new_rs = $admin->get_particular_hold($uniqueid);

    $lineData = array(
      $rs->fields["caller_id"],
      $rs->fields["duration"],
      $rs->fields["agent_name"],
      date('d-m-Y', strtotime($rs->fields["DATE"])),
      date('h:i:s A', strtotime($rs->fields["TIME"])),
      $rs->fields["t_duration"],
      $new_rs->fields["new_t_time"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $rs->MoveNext();
    $a++;
  }
  $excelData .= implode("\t", array('Total Number of Records :', $a)) . "\n\n";
  $excelData .= implode("\t", null) . "\n";
}

// -------------- Second Table -----------
if (true) {
  // Column names 
  $fields = array('Caller Id', 'Wait in queue', 'Agent Name', 'Date', 'Time');

  $excelData .= implode("\n\t",  array("Drop call Stats")) . "\n";

  // Display column names as first row 
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs = $admin->get_drop_call_stats($search_keyword, addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime);

  // Output each row of the data 
  while (!$rs->EOF) {
    $uniqueid = $rs->fields["unique_id"];
    $new_rs = $admin->get_particular_hold($uniqueid);

    $lineData = array(
      $rs->fields["caller_id"],
      $rs->fields["duration"],
      $rs->fields["agent_name"],
      date('d-m-Y', strtotime($rs->fields["date"])),
      date('h:i:s A', strtotime($rs->fields["time"]))
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $rs->MoveNext();
    $b++;
  }
  $excelData .= implode("\t", array('Total Number of Records :', $b)) . "\n\n";
  $excelData .= implode("\t", null) . "\n";
}

// -------------- Third Table -----------
if (true) {
  // Column names 
  $fields = array('Caller ID', 'Date', 'Time', 'Call ID');

  $excelData .= implode("\n\t",  array("Abandoned call Stats")) . "\n";

  // Display column names as first row  
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs = $reports->iget_aband_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime, $search_keyword, $keywords, 1, $today);

  // Output each row of the data 
  while (!$rs->EOF) {
    $wrs = $reports->iget_fullname($rs->fields["staff_id"]);
    $rsw = $user_tools->get_call_workcodes($rs->fields['unique_id']);
    $i = 1;
    $workcodes = "";
    while (!$rsw->EOF) {
      $workcodes .= "\r\n" . $i . "- " . $rsw->fields['workcodes'];
      $i++;
      $rsw->MoveNext();
    }



    $lineData = array(
      $rs->fields["caller_id"],
      $rs->fields["update_date"],
      date("h:i:s a", strtotime($rs->fields["update_time"])),
      $rs->fields["unique_id"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $rs->MoveNext();
    $c++;
  }
  $excelData .= implode("\t", array('Total Number of Records :', $c)) . "\n\n";

}


// Headers for download 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render excel data 
echo $excelData;

exit;
