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

$evaluated_call_counts = $reports->get_evaluated_calls_count($search_keyword, $fdate, $tdate);

// Starting of PDF

$pdf = new FPDF();

$pdf->AddPage();

// Heading
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 0, 'Call Center Stats Report', 0, 0, "C");
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

// --------------------First Table ------------------
if (true) {
  $width_cell = array(63, 63, 63, 25, 25, 20, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'NATURE OF CALLS', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Call Type', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Number of Calls', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'Percent', 0, 1, "C", true); // Second header column
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$nature_of_calls->EOF) {
    $t_calls =  $nature_of_calls->fields["total"];

    $pdf->Cell($width_cell[0], 6, $nature_of_calls->fields["call_type"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[1], 6, $nature_of_calls->fields["total_calls"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[2], 6, round($nature_of_calls->fields["percent"], 2) . "%", 0, 1, "C", $fill);
    $fill = !$fill; // to give alternate background fill  color to rows
    $nature_of_calls->MoveNext();
    $a++;
  }
  $pdf->Cell($width_cell[0], 6, "Total :", 0, 0, "C", $fill);
  $pdf->Cell($width_cell[1], 6, $t_calls, 0, 0, "C", $fill);
  $pdf->Cell($width_cell[2], 6, "", 0, 1, "C", $fill);

  $pdf->ln(10.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $a, 0, 1, "L");
  $pdf->ln(20.0);



  /// end of records /// 

}

// IN between the tables

// DROP CALLS
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 0, 'DROP CALLS : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 0, $drop_calls->fields["drop_calls"], 0, 0, "L");
$pdf->ln(10.0);

// ABANDONED CALLS
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 0, 'ABANDONED CALLS : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 0, $abandon_calls->fields["abandon_calls"], 0, 0, "L");
$pdf->ln(20.0);

// --------------------Second Table ------------------

if (true) {


  // $pdf->AddPage();
  $width_cell = array(95, 95, 50, 30, 30, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'TOTAL TALK TIME', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Call Type', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Talk Time', 0, 1, "C", true); // Second header column
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);

  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$total_talk_time->EOF) {
    $no_calls =  $total_talk_time->fields["total_time"];

    $pdf->Cell($width_cell[0], 6, $total_talk_time->fields["call_type"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[1], 6, $total_talk_time->fields["talk_time"], 0, 1, "C", $fill);
    $fill = !$fill; // to give alternate background fill  color to rows
    $total_talk_time->MoveNext();
    $b++;
  }
  $pdf->Cell($width_cell[0], 6, "Total :", 0, 0, "C", $fill);
  $pdf->Cell($width_cell[1], 6, $no_calls, 0, 0, "C", $fill);

  $pdf->ln(10.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $b, 0, 1, "L");
  $pdf->ln(20.0);

  /// end of records /// 
}


// --------------------Third Table ------------------

if (true) {

  // $pdf->AddPage();
  $width_cell = array(95, 95, 40, 50, 25, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'AVG TOTAL TALK TIME', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Call Type', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Talk Time', 0, 1, "C", true); // Second header column  
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$avg_total_talk_time->EOF) {
    $no_calls =  $avg_total_talk_time->fields["total_time"];

    $pdf->Cell($width_cell[0], 6, $avg_total_talk_time->fields["call_type"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[1], 6, $avg_total_talk_time->fields["talk_time"], 0, 1, "C", $fill);

    $fill = !$fill; // to give alternate background fill  color to rows
    $avg_total_talk_time->MoveNext();
    $c++;
  }
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $c, 0, 1, "L");
  $pdf->ln(20.0);

  /// end of records /// 
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

// AVG HOLD TIME
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(70, 0, 'AVG HOLD TIME : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 0, $avg, 0, 0, "L");
$pdf->ln(10.0);

$pdf->Output("call_center_report.pdf", 'D');
