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
  $fdate            = $_REQUEST['fdate'];
  $tdate            = $_REQUEST['tdate'];
} else {
  $fdate       = empty($_REQUEST["fdate"]) ? date('Y-m-d') : $_REQUEST["fdate"];
  $tdate       = empty($_REQUEST["tdate"]) ? date('Y-m-d') : $_REQUEST["tdate"];
  $search_keyword = empty($_REQUEST["search_keyword"]) ? "" : $_REQUEST["search_keyword"];
}


// Filter the excel data 
function filterData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "agent_pd_stats_report.xls";
$excelData = implode("\t", array('From :', $fdate)) . "\n";
$excelData .= implode("\t", array('To :', $tdate)) . "\n";
$excelData .= implode("\t", array('Agent :', $search_keyword)) . "\n\n";



// -------------- First Table -----------
if (true) {
  $excelData .= implode("\t", array('WORKING TIMES')) . "\n";

  // Column names 
  $fields = array('Agent Name', 'Online Time', 'Offline Time', 'Duration');

  // Display column names as first row 
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs_w_t = $reports->get_agent_work_times($search_keyword, $fdate, $tdate);

  // Output each row of the data 
  while (!$rs_w_t->EOF) {
    $uniqueid = $rs->fields["unique_id"];
    $new_rs = $admin->get_particular_hold($uniqueid);
    $name = $reports->get_agents_name($rs_w_t->fields["staff_id"]);
    $sum_worktime =  $tools_admin->sum_the_time($sum_worktime, $rs_w_t->fields["duration"]);
    $login_time =  ($rs_w_t->fields["max_logout_time"] == $rs_w_t->fields["login_time"]) ? 'Logged In' : date("Y-m-d H:i:s ", strtotime($rs_w_t->fields["logout_time"]));

    while (!$name->EOF) {
      $Agent_name = $name->fields['full_name'];
      $name->MoveNext();
    }

    $lineData = array(
      $Agent_name,
      $rs->fields["duration"],
      strtotime($rs_w_t->fields["login_time"]),
      $login_time,
      $rs_w_t->fields["duration"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $rs_w_t->MoveNext();
  }
  $excelData .= implode("\t", null) . "\n";
}

// -------------- Second Table -----------
if (true) {
  // Column names 
  $fields = array('CRM Status', 'Time Difference');

  $excelData .= implode("\n\t",  array("BREAK TIMES SUMMARY")) . "\n";

  // Display column names as first row 
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs_bs_t = $reports->get_agent_break_times_sum($search_keyword, $fdate, $tdate);
  while (!$rs_bs_t->EOF) {
    $B = "00:00:00";
    $_SESSION['bt'] = "00:00:00";
    $i = 0;
    $arr_names   = array("Namaz Break", "Lunch Break", "Tea Break", "Auxiliary Break", "Campaign");
    $arr_values = array('2', '3', '4', '5', '7');
    $duration  = array();
    // Output each row of the data 
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

    $lineData = array();
    for ($j = 0; $j < 4; $j++) {
      array_push($lineData, $arr_names[$j], $duration[$j]  );
      array_walk($lineData, 'filterData');
    };
    $excelData .= implode("\t", array_values($lineData)) . "\n";

    $excelData .= implode("\t", null) . "\n";
    $rs_bs_t->MoveNext();
  }
}

// -------------- Third Table -----------
if (true) {
  // Column names 
  $fields = array('Caller ID', 'Date', 'Time', 'Call ID');

  $excelData .= implode("\n\t",  array("ANSWERED CALLS")) . "\n";

  // Display column names as first row  
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs_c_b_t = $reports->get_agent_on_call_busy_times_new_live($search_keyword, $fdate, $tdate);


  // Output each row of the data 
  while (!$rs_c_b_t->EOF) {
    $name = $reports->get_agents_name($rs_c_b_t->fields["staff_id"]);
    $staff_id = $rs_c_b_t->fields["staff_id"];
    $abandoned_call = $reports->get_agent_drop_calls2($search_keyword, $fdate, $staff_id, $tdate);
    $agent_abandoned_calls = $rs_c_b_t->fields["call_type"] == "INBOUND" ? $abandoned_call : "";
    $E = $tools_admin->sum_the_time($E, $rs_c_b_t->fields["call_duration"]);
    $F = $tools_admin->sum_the_time($F, $rs_c_b_t->fields["busy_duration"]);

    while (!$name->EOF) {
      $Agent_name = $name->fields['full_name'];
      $name->MoveNext();
    }


    $lineData = array(
      $Agent_name,
      str_replace("OUTBOUND", "OUTGOING", $rs_c_b_t->fields["call_type"]),
      $rs_c_b_t->fields["cnt"],
      $rs_c_b_t->fields["call_duration"],
      $rs_c_b_t->fields["busy_duration"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $rs_c_b_t->MoveNext();
  }
}

// -------------- Fourth Table -----------
if (true) {
  // Column names 
  $fields = array('Agent Name', 'Call Type', 'No of Drop Calls');
  $excelData .= implode("\t", null) . "\n";

  $excelData .= implode("\n\t",  array("DROP CALLS")) . "\n";

  // Display column names as first row  
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs_c_b_t = $reports->get_agent_on_call_busy_times_new_live2($search_keyword, $fdate, $tdate);


  // Output each row of the data 
  while (!$rs_c_b_t->EOF) {
    $name = $reports->get_agents_name($rs_c_b_t->fields["staff_id"]);
    $staff_id = $rs_c_b_t->fields["staff_id"];
    $abandoned_call = $reports->get_agent_drop_calls2($search_keyword, $fdate, $staff_id, $tdate);
    $agent_abandoned_calls = $rs_c_b_t->fields["call_type"] == "INBOUND" ? $abandoned_call : "";
    $E = $tools_admin->sum_the_time($E, $rs_c_b_t->fields["call_duration"]);
    $F = $tools_admin->sum_the_time($F, $rs_c_b_t->fields["busy_duration"]);

    while (!$name->EOF) {
      $Agent_name = $name->fields['full_name'];
      $name->MoveNext();
    }


    $lineData = array(
      $Agent_name,
      str_replace("OUTBOUND", "OUTGOING", $rs_c_b_t->fields["call_type"]),
      $rs_c_b_t->fields["cnt"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $rs_c_b_t->MoveNext();
  }
}

// -------------- Fifth Table -----------
if (true) {
  // Column names 
  $fields = array('Agent', 'CRM Status', 'Start Time', 'End Time', 'Difference');
  $excelData .= implode("\t", null) . "\n";

  $excelData .= implode("\n\t",  array("BREAK TIMES")) . "\n";

  // Display column names as first row  
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs_b_t = $reports->get_agent_break_times_new_live($search_keyword, $fdate, $tdate);

  // Output each row of the data 
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

    $name = $reports->get_agents_name($rs_c_b_t->fields["staff_id"]);
    $staff_id = $rs_c_b_t->fields["staff_id"];
    $abandoned_call = $reports->get_agent_drop_calls2($search_keyword, $fdate, $staff_id, $tdate);
    $agent_abandoned_calls = $rs_c_b_t->fields["call_type"] == "INBOUND" ? $abandoned_call : "";
    $E = $tools_admin->sum_the_time($E, $rs_c_b_t->fields["call_duration"]);
    $F = $tools_admin->sum_the_time($F, $rs_c_b_t->fields["busy_duration"]);

    while (!$name->EOF) {
      $Agent_name = $name->fields['full_name'];
      $name->MoveNext();
    }


    $lineData = array(
      $Agent_name,
      $str,
      date("Y-m-d h:i:s", strtotime($rs_b_t->fields["start_time"])),
      date("Y-m-d h:i:s", strtotime($rs_b_t->fields["end_time"])),
      $rs_b_t->fields["duration"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $rs_b_t->MoveNext();
  }
}

// -------------- sixth Table -----------
if (true) {
  // Column names 
  $fields = array('Agent', 'ACW', 'Start Time', 'End Time', 'Duration');
  $excelData .= implode("\t", null) . "\n";

  $excelData .= implode("\n\t",  array("ACW TIMES")) . "\n";

  // Display column names as first row  
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs_a_t = $reports->get_agent_assignment_times_new_live($search_keyword, $fdate, $tdate);


  // Output each row of the data 
  while (!$rs_a_t->EOF) {

    $name = $reports->get_agents_name($rs_c_b_t->fields["staff_id"]);
    $staff_id = $rs_c_b_t->fields["staff_id"];
    $abandoned_call = $reports->get_agent_drop_calls2($search_keyword, $fdate, $staff_id, $tdate);
    $agent_abandoned_calls = $rs_c_b_t->fields["call_type"] == "INBOUND" ? $abandoned_call : "";
    $E = $tools_admin->sum_the_time($E, $rs_c_b_t->fields["call_duration"]);
    $F = $tools_admin->sum_the_time($F, $rs_c_b_t->fields["busy_duration"]);
    $D = $tools_admin->sum_the_time($D, $rs_a_t->fields["duration"]);

    while (!$name->EOF) {
      $Agent_name = $name->fields['full_name'];
      $name->MoveNext();
    }


    $lineData = array(
      $Agent_name,
      $rs_a_t->fields["assignment"],
      date("Y-m-d h:i:s", strtotime($rs_a_t->fields["start_time"])),
      date("Y-m-d h:i:s", strtotime($rs_a_t->fields["end_time"])),
      $rs_a_t->fields["duration"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $rs_a_t->MoveNext();
  }
}

// -------------- Seventh Table -----------
if (true) {
  // Column names 
  $fields = array('Agent', 'Caller ID', 'Hold Time');
  $excelData .= implode("\t", null) . "\n";

  $excelData .= implode("\n\t",  array("HOLD TIMES")) . "\n";

  // Display column names as first row  
  $excelData .= implode("\t", array_values($fields)) . "\n";

  // Fetch records from database 
  $rs_a_t_nh = $reports->get_agent_hold_times_new_live($search_keyword, $fdate, $tdate);



  // Output each row of the data 
  while (!$rs_a_t_nh->EOF) {
    $dunique = $rs_a_t_nh->fields["unique_id"];
    $rs_a_t_nh_time = $reports->get_agent_hold_times_new_live_times($dunique);
    $name = $reports->get_agents_name($rs_a_t_nh->fields["staff_id"]);

    while (!$name->EOF) {
      $Agent_name = $name->fields['full_name'];
      $name->MoveNext();
    }


    $lineData = array(
      $Agent_name,
      $rs_a_t_nh->fields["caller_id"],
      $rs_a_t_nh_time->fields["hold_time"],
      date("Y-m-d h:i:s", strtotime($rs_a_t->fields["end_time"])),
      $rs_a_t->fields["duration"]
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
    $rs_a_t_nh->MoveNext();
  }
}

// -------------- eighth Table -----------
if (true) {
  $C = $tools_admin->sub_the_time_new_live($sum_worktime, $B);
  //$C=$tools_admin->sum_the_time($C,$D);
  $G = $tools_admin->sum_the_time_new_live($D, $E);
  $H = $tools_admin->sub_the_time_new_live(str_replace('-', '', $C), $G);
  $I_new = $reports->get_agent_hold_times_new_live_agents($search_keyword, $fdate, $tdate);
  $I = $I_new->fields["hold_time"];


  // Column names 
  $excelData .= implode("\t", null) . "\n";

  $excelData .= implode("\n\t",  array("WORK TIMING DISTRIBUTION")) . "\n";

  $excelData .= implode("\t",  array("Work Time (A):", $sum_worktime)) . "\n";
  $excelData .= implode("\t",  array("Break Time(B):", $B)) . "\n";
  $excelData .= implode("\t",  array("Effective Work Time Available (C):", $C)) . "\n";
  $excelData .= implode("\t",  array("ACW Time (D):", $D)) . "\n";
  $excelData .= implode("\t",  array("On Call Time (E):", $E)) . "\n";
  $excelData .= implode("\t",  array("Busy Time (F):", $F)) . "\n";
  $excelData .= implode("\t",  array("Work Time Utilized (G):", $G)) . "\n";
  $excelData .= implode("\t",  array("Free Time (H):", $H)) . "\n";
  $excelData .= implode("\t",  array("Hold Time (I):", $I)) . "\n";
}


// Headers for download 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render excel data 
echo $excelData;

exit;
