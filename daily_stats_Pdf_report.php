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

if (isset($_REQUEST['export_pdf'])) {
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

  $keywords          = empty($_REQUEST["keywords"]) ? "0" : $_REQUEST["keywords"];
  $search_keyword    = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}


$pdf = new FPDF();

$pdf->AddPage();

// Heading
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 0, 'Daily Stats Report', 0, 0, "C");
$pdf->ln(10.0);

// From date
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 0, 'From : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(45, 0, $fdatetime, 0, 0, "L");
$pdf->ln(5.0);

// To Date
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 0, 'To : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(45, 0, $tdatetime, 0, 0, "L");
$pdf->ln(5.0);
// Generated Date
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 0, 'Generated At : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(25, 0, Date("d-m-Y H:i:s"), 0, 0, "L");
$pdf->ln(10.0);

if (true) {
  $rs = $admin->get_queue_wait_stats($search_keyword, addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime);

  $width_cell = array(35, 25, 35, 25, 25, 20, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'RECEIVED CALL STATS', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Caller ID', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'In Queue', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'Agent Name', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[3], 8, 'Date', 0, 0, "C", true); // Third header column 
  $pdf->Cell($width_cell[4], 8, 'Time', 0, 0, "C", true); // Fourth header column
  $pdf->Cell($width_cell[5], 8, 'Duration', 0, 0, "C", true); // fifth header column 
  $pdf->Cell($width_cell[6], 8, 'Hold Time', 0, 1, "C", true); // sixth header column 
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs->EOF) {

    $uniqueid = $rs->fields["unique_id"];
    $new_rs = $admin->get_particular_hold($uniqueid);

    $pdf->Cell($width_cell[0], 6, $rs->fields["caller_id"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[1], 6, $rs->fields["duration"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[2], 6, $rs->fields["agent_name"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[3], 6, date('d-m-Y', strtotime($rs->fields["DATE"])), 0, 0, "C", $fill);
    $pdf->Cell($width_cell[4], 6, date('h:i:s A', strtotime($rs->fields["TIME"])), 0, 0, "C", $fill);
    $pdf->Cell($width_cell[5], 6, $rs->fields["t_duration"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[6], 6, $new_rs->fields["new_t_time"], 0, 1, "C", $fill);
    $fill = !$fill; // to give alternate background fill  color to rows
    $rs->MoveNext();
    $a++;
  }
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $a, 0, 1, "L");
  $pdf->ln(20.0);
  /// end of records /// 

}


// --------------------Second Table ------------------

if (true) {
  $rs = $admin->get_drop_call_stats($search_keyword, addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime);

  // $pdf->AddPage();
  $width_cell = array(40, 40, 50, 30, 30, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'DROPPED CALL STATS', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Caller ID', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Wait In Queue', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'Agent Name', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[3], 8, 'Date', 0, 0, "C", true); // Third header column 
  $pdf->Cell($width_cell[4], 8, 'Time', 0, 1, "C", true); // Fourth header column
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);

  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs->EOF) {
    $pdf->Cell($width_cell[0], 6, $rs->fields["caller_id"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[1], 6, $rs->fields["duration"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[2], 6, $rs->fields["full_name"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[3], 6, $rs->fields["date"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[4], 6, $rs->fields["time"], 0, 1, "C", $fill);
    $fill = !$fill; // to give alternate background fill  color to rows
    $rs->MoveNext();
    $b++;
  }
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $b, 0, 1, "L");
  $pdf->ln(20.0);

  /// end of records /// 
}


// --------------------Third Table ------------------
if (true) {
  $rs = $reports->iget_aband_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdatetime, $tdatetime, $search_keyword, $keywords, 1, $today);

  // $pdf->AddPage();
  $width_cell = array(45, 55, 40, 50, 25, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'ABANDONED CALL STATS', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, ' Caller ID', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Date', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'Time', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[3], 8, 'Call ID', 0, 1, "C", true); // Third header column 
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs->EOF) {


    $pdf->Cell($width_cell[0], 6, $rs->fields["caller_id"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[1], 6, $rs->fields["update_date"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[2], 6, $rs->fields["update_time"], 0, 0, "C", $fill);

    $wrs = $reports->iget_fullname($rs->fields["staff_id"]);
    $rsw = $user_tools->get_call_workcodes($rs->fields['unique_id']);
    $i = 1;
    $workcodes = "";
    while (!$rsw->EOF) {
      $workcodes .= "\r\n" . $i . "- " . $rsw->fields['workcodes'];
      $i++;
      $rsw->MoveNext();
    }

    $pdf->Cell($width_cell[3], 6, $rs->fields["unique_id"], 0, 1, "C", $fill);

    $fill = !$fill; // to give alternate background fill  color to rows

    $rs->MoveNext();
    $c++;
  }
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $c, 0, 1, "L");

  /// end of records /// 

}



$pdf->Output("Daily_Stats_Report.pdf", 'D');
