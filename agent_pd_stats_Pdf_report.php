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
  $fdate            = $_REQUEST['fdate'];
  $tdate            = $_REQUEST['tdate'];
} else {
  $fdate       = empty($_REQUEST["fdate"]) ? date('Y-m-d') : $_REQUEST["fdate"];
  $tdate       = empty($_REQUEST["tdate"]) ? date('Y-m-d') : $_REQUEST["tdate"];
  $search_keyword = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}

// Start of PDF...
$rs_agent_name = $admin->get_agent_name($search_keyword);

$pdf = new FPDF();

$pdf->AddPage();

// Heading
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 0, 'Agent Productivity Report', 0, 0, "C");
$pdf->ln(10.0);

// From date
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 0, 'From : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(45, 0, $fdate, 0, 0, "L");
$pdf->ln(5.0);

// To Date
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 0, 'To : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(45, 0, $tdate, 0, 0, "L");
$pdf->ln(5.0);

// Agent Name
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(20, 0, 'Name : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(65, 0, $rs_agent_name->fields["full_name"], 0, 0, "L");
$pdf->ln(5.0);

// Agent Department
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(25, 0, 'Dept : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(55, 0, $rs_agent_name->fields["department"], 0, 0, "L");
$pdf->ln(5.0);

// Generated Date
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 0, 'Generated At : ', 0, 0, "L");
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(25, 0, Date("d-m-Y H:i:s"), 0, 0, "L");
$pdf->ln(10.0);


// --------------------First Table ------------------
if (true) {
  $rs_w_t = $reports->get_agent_work_times($search_keyword, $fdate, $tdate);

  $width_cell = array(45, 60, 60, 25, 35, 20, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'WORKING TIMES', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Agent Name', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Online Time', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'Offline Time', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[3], 8, 'Duration', 0, 1, "C", true); // Third header column 
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs_w_t->EOF) {
    $name = $reports->get_agents_name($rs_w_t->fields["staff_id"]);
    while (!$name->EOF) {
      $pdf->Cell($width_cell[0], 6, $name->fields['full_name'], 0, 0, "C", $fill);
      $name->MoveNext();
    }
    $login_time =  ($rs_w_t->fields["max_logout_time"] == $rs_w_t->fields["login_time"]) ? 'Logged In' : date("Y-m-d H:i:s ", strtotime($rs_w_t->fields["logout_time"]));

    $pdf->Cell($width_cell[1], 6, date("Y-m-d H:i:s", strtotime($rs_w_t->fields["login_time"])), 0, 0, "C", $fill);
    if ($login_time == "Logged In") {
      $pdf->SetTextColor(220, 0, 0);
    }

    $pdf->Cell($width_cell[2], 6, $login_time, 0, 0, "C", $fill);

    $pdf->SetTextColor(0, 0, 0);

    $sum_worktime =  $tools_admin->sum_the_time($sum_worktime, $rs_w_t->fields["duration"]);
    $pdf->Cell($width_cell[3], 6, $rs_w_t->fields["duration"], 0, 1, "C", $fill);
    $fill = !$fill; // to give alternate background fill  color to rows
    $rs_w_t->MoveNext();
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
  $rs_bs_t = $reports->get_agent_break_times_sum($search_keyword, $fdate, $tdate);

  // $pdf->AddPage();
  $width_cell = array(95, 95, 50, 30, 30, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'BREAK TIMES SUMMARY', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFont('Arial', 'B', 10);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'CRM Status', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Time Difference', 0, 1, "C", true); // Second header column
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);

  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs_bs_t->EOF) {

    $B = "00:00:00";
    $_SESSION['bt'] = "00:00:00";
    $i = 0;
    $arr_names   = array("Namaz Break", "Lunch Break", "Tea Break", "Auxiliary Break", "Campaign");
    $arr_values = array('2', '3', '4', '5', '7');
    $duration  = array();

    while ($i < 4) {
      if ($arr_values[$i] == $rs_bs_t->fields["crm_status"]) {
        $B = $tools_admin->sum_the_time($B, $rs_bs_t->fields["duration"]);
        $_SESSION['bt'] = $tools_admin->sum_the_time($_SESSION['bt'], $rs_bs_t->fields["duration"]);
        $duration[$i] = $rs_bs_t->fields["duration"];
        $rs_bs_t->MoveNext();
        $c2++;
      } else {
        $duration[$i] = "-";
      };
      $i++;
    }

    for ($i = 0; $i < 4; $i++) {
      $pdf->Cell($width_cell[0], 6, $arr_names[$i], 0, 0, "C", $fill);
      $pdf->Cell($width_cell[1], 6, $duration[$i], 0, 1, "C", $fill);
    };

    $pdf->Cell($width_cell[0], 6, $rs->fields["caller_id"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[1], 6, $rs->fields["duration"], 0, 1, "C", $fill);

    $fill = !$fill; // to give alternate background fill  color to rows
    $rs_bs_t->MoveNext();
    $b++;
  }
  $pdf->ln(20.0);

  /// end of records /// 
}


// --------------------Third Table ------------------
if (true) {
  $rs_c_b_t = $reports->get_agent_on_call_busy_times_new_live($search_keyword, $fdate, $tdate);

  // $pdf->AddPage();
  $width_cell = array(50, 40, 35, 35, 30, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'ANSWERED CALLS', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Agent Name', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Call Type', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'No of Calls', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[3], 8, 'Call ID', 0, 0, "C", true); // Third header column 
  $pdf->Cell($width_cell[4], 8, 'Busy Time', 0, 1, "C", true); // Third header column 
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs_c_b_t->EOF) {
    $name = $reports->get_agents_name($rs_c_b_t->fields["staff_id"]);
    $staff_id = $rs_c_b_t->fields["staff_id"];
    $abandoned_call = $reports->get_agent_drop_calls2($search_keyword, $fdate, $staff_id, $tdate);
    $agent_abandoned_calls = $rs_c_b_t->fields["call_type"] == "INBOUND" ? $abandoned_call : "";
    $E = $tools_admin->sum_the_time($E, $rs_c_b_t->fields["call_duration"]);
    $F = $tools_admin->sum_the_time($F, $rs_c_b_t->fields["busy_duration"]);

    while (!$name->EOF) {
      $pdf->Cell($width_cell[0], 6, $name->fields['full_name'], 0, 0, "C", $fill);
      $name->MoveNext();
    }

    $pdf->Cell($width_cell[1], 6, str_replace("OUTBOUND", "OUTGOING", $rs_c_b_t->fields["call_type"]), 0, 0, "C", $fill);
    $pdf->Cell($width_cell[2], 6, $rs_c_b_t->fields["cnt"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[3], 6, $rs_c_b_t->fields["call_duration"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[4], 6, $rs_c_b_t->fields["busy_duration"], 0, 1, "C", $fill);

    $fill = !$fill; // to give alternate background fill  color to rows

    $rs_c_b_t->MoveNext();
    $c++;
  }
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $c, 0, 1, "L");
  $pdf->ln(20.0);
  /// end of records /// 
}


// --------------------Fourth Table ------------------
if (true) {
  $rs_c_b_t = $reports->get_agent_on_call_busy_times_new_live2($search_keyword, $fdate, $tdate);

  // $pdf->AddPage();
  $width_cell = array(67, 62, 62, 50, 25, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'DROP CALLS', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Agent Name', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Call Type', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'No of Drop Calls', 0, 1, "C", true); // Second header column
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs_c_b_t->EOF) {
    $name = $reports->get_agents_name($rs_c_b_t->fields["staff_id"]);
    while (!$name->EOF) {
      $pdf->Cell($width_cell[0], 6, $name->fields['full_name'], 0, 0, "C", $fill);
      $name->MoveNext();
    }

    $pdf->Cell($width_cell[1], 6, str_replace("OUTBOUND", "OUTGOING", $rs_c_b_t->fields["call_type"]), 0, 0, "C", $fill);
    $pdf->Cell($width_cell[2], 6,  $rs_c_b_t->fields["cnt"], 0, 1, "C", $fill);

    $fill = !$fill; // to give alternate background fill  color to rows
    $rs_c_b_t->MoveNext();
    $d++;
  }
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $d, 0, 1, "L");
  $pdf->ln(20.0);

  /// end of records /// 
}


// --------------------Fifth Table ------------------
if (true) {
  $rs_b_t = $reports->get_agent_break_times_new_live($search_keyword, $fdate, $tdate);

  // $pdf->AddPage();
  $width_cell = array(40, 25, 50, 50, 25, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'BREAK TIMES', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Agent', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'CRM Status', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'Start Time', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[3], 8, 'End Time', 0, 0, "C", true); // Third header column 
  $pdf->Cell($width_cell[4], 8, 'Difference', 0, 1, "C", true); // Third header column 
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs_b_t->EOF) {
    if ($rs_b_t->fields["crm_status"] == 1) {
      $str = "Online";
    } else if ($rs_b_t->fields["crm_status"] == 2) {
      $str = "Namaz Break";
    } else if ($rs_b_t->fields["crm_status"] == 3) {
      $str = "Lunch Break";
    } else if ($rs_b_t->fields["crm_status"] == 4) {
      $str = "Tea Break";
    } else if ($rs_b_t->fields["crm_status"] == 5) {
      $str = "Auxiliary Break";
    } else if ($rs_b_t->fields["crm_status"] == 0) {
      $str = "Offline";
    } else if ($rs_b_t->fields["crm_status"] == 7) {
      $str = "Campaign";
    } else {
      $str = "Unkown";
    }

    $name = $reports->get_agents_name($rs_b_t->fields["staff_id"]);
    while (!$name->EOF) {
      $pdf->Cell($width_cell[0], 6, $name->fields['full_name'], 0, 0, "C", $fill);
      $name->MoveNext();
    }

    $pdf->Cell($width_cell[1], 6, $str, 0, 0, "C", $fill);
    $pdf->Cell($width_cell[2], 6, date("Y-m-d h:i:s", strtotime($rs_b_t->fields["start_time"])), 0, 0, "C", $fill);

    $pdf->Cell($width_cell[3], 6, date("Y-m-d h:i:s", strtotime($rs_b_t->fields["end_time"])), 0, 0, "C", $fill);
    $pdf->Cell($width_cell[4], 6, $rs_b_t->fields["duration"], 0, 1, "C", $fill);

    $fill = !$fill; // to give alternate background fill  color to rows

    $rs_b_t->MoveNext();
    $e++;
  }
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $e, 0, 1, "L");
  $pdf->ln(20.0);

  /// end of records /// 
}


// --------------------Sixth Table ------------------
if (true) {
  $rs_a_t = $reports->get_agent_assignment_times_new_live($search_keyword, $fdate, $tdate);

  // $pdf->AddPage();
  $width_cell = array(40, 25, 50, 50, 25, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'ACW TIMES', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Agent', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'ACW', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'Start Time', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[3], 8, 'End Time', 0, 0, "C", true); // Third header column 
  $pdf->Cell($width_cell[4], 8, 'Duration', 0, 1, "C", true); // Third header column 
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs_a_t->EOF) {
    $name = $reports->get_agents_name($rs_a_t->fields["staff_id"]);
    while (!$name->EOF) {
      $pdf->Cell($width_cell[0], 6, $name->fields['full_name'], 0, 0, "C", $fill);
      $name->MoveNext();
    }

    $pdf->Cell($width_cell[1], 6, $rs_a_t->fields["assignment"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[2], 6, date("Y-m-d h:i:s", strtotime($rs_a_t->fields["start_time"])), 0, 0, "C", $fill);

    $D = $tools_admin->sum_the_time($D, $rs_a_t->fields["duration"]);
    $pdf->Cell($width_cell[3], 6, date("Y-m-d h:i:s", strtotime($rs_a_t->fields["end_time"])), 0, 0, "C", $fill);
    $pdf->Cell($width_cell[4], 6, $rs_a_t->fields["duration"], 0, 1, "C", $fill);

    $fill = !$fill; // to give alternate background fill  color to rows

    $rs_a_t->MoveNext();
    $f++;
  }
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $f, 0, 1, "L");
  $pdf->ln(20.0);

  /// end of records /// 
}


// --------------------Seventh Table ------------------
if (true) {
  $rs_a_t_nh = $reports->get_agent_hold_times_new_live($search_keyword, $fdate, $tdate);

  // $pdf->AddPage();
  $width_cell = array(64, 64, 62, 50, 25, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'HOLD TIMES', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', 'B', 12);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(45, 65, 84); // Background color of header 

  // Header starts /// 
  $pdf->Cell($width_cell[0], 8, 'Agent', 0, 0, "C", true); // First header column 
  $pdf->Cell($width_cell[1], 8, 'Caller ID', 0, 0, "C", true); // Second header column
  $pdf->Cell($width_cell[2], 8, 'Hold Time', 0, 1, "C", true); // Third header column 
  //// header ends ///////

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 
  $fill = false; // to give alternate background fill color to rows 

  /// each record is one row  ///
  while (!$rs_a_t_nh->EOF) {

    $dunique = $rs_a_t_nh->fields["unique_id"];
    $rs_a_t_nh_time = $reports->get_agent_hold_times_new_live_times($dunique);
    $name = $reports->get_agents_name($rs_a_t_nh->fields["staff_id"]);
    while (!$name->EOF) {
      $pdf->Cell($width_cell[0], 6, $name->fields['full_name'], 0, 0, "C", $fill);
      $name->MoveNext();
    }

    $pdf->Cell($width_cell[1], 6, $rs_a_t_nh->fields["caller_id"], 0, 0, "C", $fill);
    $pdf->Cell($width_cell[2], 6, $rs_a_t_nh_time->fields["hold_time"], 0, 1, "C", $fill);


    $fill = !$fill; // to give alternate background fill  color to rows

    $rs_a_t_nh->MoveNext();
    $g++;
  }
  $pdf->ln(5.0);
  $pdf->SetFont('Arial', '', 10);
  $pdf->Cell(0, 0, 'Total Number of Records: ' . $g, 0, 1, "L");
  $pdf->ln(20.0);


  /// end of records /// 

}


// --------------------eighth Table ------------------
if (true) {

  $C = $tools_admin->sub_the_time_new_live($sum_worktime, $B);
  //$C=$tools_admin->sum_the_time($C,$D);
  $G = $tools_admin->sum_the_time_new_live($D, $E);
  $H = $tools_admin->sub_the_time_new_live(str_replace('-', '', $C), $G);
  $I_new = $reports->get_agent_hold_times_new_live_agents($search_keyword, $fdate, $tdate);
  $I = $I_new->fields["hold_time"];

  // $pdf->AddPage();
  $width_cell = array(100, 100, 40, 50, 25, 25, 25);
  $pdf->SetFont('Arial', 'B', 16);
  $pdf->Cell(0, 0, 'WORK TIMING DISTRIBUTION', 0, 0, "C"); // First header column 
  $pdf->ln(5.0);

  $pdf->SetFont('Arial', '', 10);
  $pdf->SetTextColor(0, 0, 0);
  $pdf->SetFillColor(243, 243, 243); // Background color of header 

  /// each record is one row  ///

  $pdf->Cell($width_cell[0], 6, "Work Time (A):", 0, 0, "C", 0);
  $pdf->Cell($width_cell[1], 6, $sum_worktime, 0, 1, "C", 0);

  $pdf->Cell($width_cell[0], 6, "Break Time(B):", 0, 0, "C", 1);
  $pdf->Cell($width_cell[1], 6, $B, 0, 1, "C", 1);

  $pdf->Cell($width_cell[0], 6, "Effective Work Time Available (C):", 0, 0, "C", 0);
  $pdf->Cell($width_cell[1], 6, $C, 0, 1, "C", 0);

  $pdf->Cell($width_cell[0], 6, "ACW Time (D):", 0, 0, "C", 1);
  $pdf->Cell($width_cell[1], 6, $D, 0, 1, "C", 1);

  $pdf->Cell($width_cell[0], 6, "On Call Time (E):", 0, 0, "C", 0);
  $pdf->Cell($width_cell[1], 6, $E, 0, 1, "C", 0);

  $pdf->Cell($width_cell[0], 6, "Busy Time (F):", 0, 0, "C", 1);
  $pdf->Cell($width_cell[1], 6, $F, 0, 1, "C", 1);

  $pdf->Cell($width_cell[0], 6, "Work Time Utilized (G):", 0, 0, "C", 0);
  $pdf->Cell($width_cell[1], 6, $G, 0, 1, "C", 0);

  $pdf->Cell($width_cell[0], 6, "Free Time (H):", 0, 0, "C", 1);
  $pdf->Cell($width_cell[1], 6, str_replace('-', '', $H), 0, 1, "C", 1);

  $pdf->Cell($width_cell[0], 6, "Hold Time (I):", 0, 0, "C", 0);
  $pdf->Cell($width_cell[1], 6, str_replace('-', '', $I), 0, 1, "C", 0);


  $pdf->ln(5.0);
  /// end of records /// 

}


$pdf->Output("Agent_pd_stats_Report.pdf", 'D');
