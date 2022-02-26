<?php
class tools_admin
{
	function tools_admin()
	{
	}

	function is_call_center_on()
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT scl.status FROM  cc_schadule_config AS scl WHERE scl.status = '1' ";
		$rs = $db_conn->Execute($sql);
		//print_r($rs);
		if ($rs->fields['status'] == 1) {
			return true;
		} else {
			return false;
		}
	}
	function generateGraph($title, $datay1)
	{

		//$datay1 = array(20,15,23,15);
		//$datay2 = array(12,9,42,8);
		//$datay3 = array(5,17,32,24);

		// Setup the graph
		$graph = new Graph(250, 200);
		$graph->SetScale("textlin");

		$theme_class = new UniversalTheme;

		$graph->SetTheme($theme_class);
		$graph->img->SetAntiAliasing(false);
		$graph->title->Set($title);
		$graph->SetBox(false);

		$graph->img->SetAntiAliasing();

		$graph->yaxis->HideZeroLabel();
		$graph->yaxis->HideLine(false);
		$graph->yaxis->HideTicks(false, false);

		$graph->xgrid->Show();
		$graph->xgrid->SetLineStyle("solid");
		$graph->xaxis->SetTickLabels(array('Week 1', 'Week 2', 'Week 3', 'Week 4'));
		$graph->xgrid->SetColor('#E3E3E3');

		// Create the first line
		$p1 = new LinePlot($datay1);
		$graph->Add($p1);
		$p1->mark->SetType(MARK_CIRCLE, '', 0.8);
		$p1->value->SetFormat('%d');
		$p1->value->Show();
		$p1->value->SetColor('#000000');
		$p1->SetColor("#6495ED");
		$p1->SetLegend('');


		$graph->legend->SetFrameWeight(1);

		// Output line

		// The image must be stroked to find out the image maps
		$graph->Stroke("graphs/" . $title . ".png");

		// Then read the image map
		//$imagemap = $graph->GetHTMLImageMap('MainMap');

		//echo $imagemap;
		//echo "<img src='graphs/$title.png'>"; 
	}


	function generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	{

		//$dest: I or D or F or S
		$pdf = new PDF($pageOrient, $unit, $pageSize);
		//$thead = array('Called ID', 'Caller ID', 'Call Status', 'Call Type', 'Tracking ID', 'Date', 'Time', 'Duration', 'Agent Name');
		$data = $pdf->LoadData($inputFile);
		//print_r($data); exit();
		$pdf->SetFont($font, '', $fontSize);
		$pdf->AddPage();
		$pdf->SetData($thead, $data,  $cellWidth, $cellHeight, $cellBorder);
		$pdf->Output($outputFileName, $dest);
	}

	function exec_query($sql)
	{
		global $db_conn;
		global $db_prefix;
		$rs = $db_conn->Execute($sql);
		//echo $sql;// exit;
		return $rs;
	}
	function sum_the_time($time1, $time2)
	{
		$times = array($time1, $time2);
		$seconds = 0;
		foreach ($times as $time) {
			list($hour, $minute, $second) = explode(':', $time);
			$seconds += $hour * 3600;
			$seconds += $minute * 60;
			$seconds += $second;
		}
		$hours = floor($seconds / 3600);
		$seconds -= $hours * 3600;
		$minutes  = floor($seconds / 60);
		$seconds -= $minutes * 60;
		return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
	}

	function sum_the_time_new_live($time1, $time2)
        {

		$fpos1 = strpos($time1,':',0);
                $fpos2 = strpos($time1,':',$fpos1+1);
                $firsthour = substr($time1,0,$fpos1);
                $firstmin = substr($time1,$fpos1+1,$fpos2-$fpos1-1);
                $firstsec = substr($time1,$fpos2+1);

                $spos1 = strpos($time2,':',0);
                $spos2 = strpos($time2,':',$spos1+1);
                $secondhour = substr($time2,0,$spos1);
                $secondmin = substr($time2,$spos1+1,$spos2-$spos1-1);
                $secondsec = substr($time2,$spos2+1);

                $firsttime = ($firsthour*3600) + ($firstmin*60) + $firstsec;
                $secondtime = ($secondhour*3600) + ($secondmin*60) + $secondsec;

                $seconds = $firsttime + $secondtime;

                $hours = floor($seconds / 3600);
                $seconds -= $hours * 3600;
                $minutes  = floor($seconds / 60);
                $seconds -= $minutes * 60;
                return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
                //return "{$hours}:{$minutes}:{$seconds}";
        }


	function sub_the_time($end, $start)
        {

                //echo 'h '.$end;
		$end = strtotime($end);
		$start = strtotime($start);
		$seconds = $end - $start;
                $hours = floor($seconds / 3600);
                $seconds -= $hours * 3600;
                $minutes = floor($seconds / 60);
                $seconds -= $minutes * 60;
                $newret = $hours.":".$minutes.":".$seconds;

                return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }


	function sub_the_time_new_live($end, $start)
	{

		//echo 'h '.$end; 
		$fpos1 = strpos($end,':',0);
		$fpos2 = strpos($end,':',$fpos1+1);
		$firsthour = substr($end,0,$fpos1);
		$firstmin = substr($end,$fpos1+1,$fpos2-$fpos1-1);
		$firstsec = substr($end,$fpos2+1);

		$spos1 = strpos($start,':',0);
                $spos2 = strpos($start,':',$spos1+1);
		$secondhour = substr($start,0,$spos1);
                $secondmin = substr($start,$spos1+1,$spos2-$spos1-1);
                $secondsec = substr($start,$spos2+1);

		$firsttime = ($firsthour*3600) + ($firstmin*60) + $firstsec;
		$secondtime = ($secondhour*3600) + ($secondmin*60) + $secondsec;

		$seconds = $firsttime - $secondtime;

		$hours = floor($seconds / 3600);
		$seconds -= $hours * 3600;
		$minutes = floor($seconds / 60);
		$seconds -= $minutes * 60;
		$newret = $hours.":".$minutes.":".$seconds;

		return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
	}
	function sum_the_time_2($time1, $time2)
	{
		// subtract time	
		$times = array($time1);
		$seconds = 0;
		foreach ($times as $time) {
			list($hour, $minute, $second) = explode(':', $time);
			$time2 = explode(':', $time2);
			//print_r($time2);
			$seconds += (0 - ($time2[0] - $hour) * 3600);
			$seconds += (0 - ($time2[1] - $minute) * 60);
			$seconds += (0 - ($time2[2] - $second));
		}
		$hours = floor($seconds / 3600);
		$seconds -= $hours * 3600;
		$minutes  = floor($seconds / 60);
		$seconds -= $minutes * 60;
		return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
		//return "{$hours}:{$minutes}:{$seconds}";
	}

	function sip_status()
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "_admin  ";
		$sql .= " where admin_id = " . $_SESSION[$db_prefix . '_UserId'];
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
	}

	function select($fields, $tbl, $where)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select $fields from " . $db_prefix . "_$tbl where 1=1 ";
		if (!empty($where)) {
			$sql .= "and $where ";
		}
		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); 
		return $rs->fields["$fields"];
	}
	function get_o_channels($fields, $tbl, $where)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select table2.$fields, admin.full_name as agent_name from " . $db_prefix . "_$tbl as table2
		LEFT OUTER JOIN cc_admin AS admin
		    ON admin.admin_id = table2.staff_id
		 where 1=1 ";
		if (!empty($where)) {
			$sql .= "and $where ";
		}
		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); 
		return $rs;  //$rs->fields["$fields"];
	}

	function update_cdr($unique_id, $agent_id)
	{
		global $db_conn;
		global $db_prefix;

		$sql = "UPDATE " . $db_prefix . "_cdr set staff_id = '" . $agent_id . "', call_status = 'ANSWERED' where 1=1 ";
		if (!empty($unique_id)) {
			$sql .= "and uniqueid = '" . $unique_id . "'";
		}
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	//update_cdr
	function is_multi2($array)
	{

		if (count($array) == count($array, COUNT_RECURSIVE)) {
			//$temp[][]=new array();
			$temp = array(array());
			foreach ($array as $key => $value) {
				$temp[0][$key] = $value;
				//echo $value;
				//echo $temp[0][$key];
			}
			//exit;
			/*
			
				for($i=0;$i<count($array);$i++){
					echo $array[$i];
					$temp[0][$i]=$array[$i];
				} exit;
			*/
			return ($temp);
			//echo 'array is not multidimensional';
		} else {
			return ($array);
			//echo 'array is multidimensional';
		}
	}
	function is_multi($array)
	{
		return (count($array) != count($array, 1));
	}
	function get_caller_id($agent_id)
	{
		global $db_conn;
		global $db_prefix;

		$sql = "UPDATE " . $db_prefix . "_admin set staff_updated_date = NOW() where 1=1 ";
		if (!empty($agent_id)) {
			$sql .= "and admin_id = '" . $agent_id . "'";
		}

		/*		$sql = "UPDATE ".$db_prefix."_login_activity set update_datetime = NOW() where 1=1 ";
		if(!empty($agent_id)){
			$sql.= "and admin_id = '".$agent_id ."'";
		}
*/
		$abc = $db_conn->Execute($sql);
		//echo $abc."--";
		$sql = "SELECT id,unique_id,caller_id,staff_id,status,update_datetime,MINUTE(TIMEDIFF(NOW(),staff_start_datetime)) AS minutes,SECOND(TIMEDIFF(NOW(),staff_start_datetime)) AS seconds FROM " . $db_prefix . "_queue_stats where 1=1 ";
		if (!empty($agent_id)) {
			$sql .= "and staff_id = '" . $agent_id . "' and (status !=0 ) ";
		}
		$sql .= " ORDER BY id desc LIMIT 1 ";
		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); //exit;
		return $rs;
	}
	function get_client_detail($caller_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT id FROM ts_user WHERE phone = '" . $caller_id . "' LIMIT 1";
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function returnFieldVal($field, $tbl, $where)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select $field from " . $db_prefix . "_$tbl where $where ";
		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql);
		while (!$rs->EOF) {
			return $rs->fields["$field"];
			$rs->MoveNext();
		}
	}
	function returnCountVal($tbl, $where)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select count(*) as count from " . $db_prefix . "_$tbl ";
		if (!empty($where)) {
			$sql .= "where $where ";
		}
		$rs = $db_conn->Execute($sql);
		while (!$rs->EOF) {
			return $rs->fields["count"];
			$rs->MoveNext();
		}
	}
	function GetCurrentDateTime()
	{
		$curdate = date("Y-m-d H:i:s");
		return $curdate;
	}
	function GetCurrentDate()
	{
		$curdate = date("Y-m-d");
		return $curdate;
	}
	function GetCurrentTime()
	{
		$curdate = date("H:i:s");
		return $curdate;
	}
	function encryptId($pid)
	{
		return $pid;
		//return round($pid*240880);
	}
	function decryptId($pid)
	{
		return $pid;
		//return round($pid/240880);
	}
	function getCountries($id = "0")
	{
		global $db_conn;
		global $db_prefix;
		if ($id != "0") {
			$sql_condition = "and id='" . $id . "'";
		}
		$sql = "select * from " . $db_prefix . "_countries where status=1 " . $sql_condition . "; ";
		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql);
		return $rs;
	}
	function getProductUnitsType($id = "0")
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "_products_production_units where status=1 ";
		if (!empty($id)) {
			$sql .= " and id = '" . $id . "'";
		}
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function getCurrency($id = "0")
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "_products_currency where status=1 ";
		if (!empty($id)) {
			$sql .= " and id = '" . $id . "'";
		}
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function getPaymentTerms($id = "0", $array = "0")
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "_products_payment_type where status=1";
		if (!empty($id)) {
			$sql .= " and id = '" . $id . "'";
		} elseif (!empty($array)) {
			$sql .= " and id in (0, " . $array . ")";
		}
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function getTimeUnits($id = "0")
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "_products_time_units where status=1 ";
		if (!empty($id)) {
			$sql .= " and id = '" . $id . "'";
		}
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function getTimeValidity($id = "0")
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "_products_time_validity where status=1 ";
		if (!empty($id)) {
			$sql .= " and id='" . $id . "'";
		}
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function getstatus($status = 0)
	{
		if ($status == 0) {
			return "In Active";
		} elseif ($status == 1) {
			return "Active";
		} elseif ($status == 2) {
			return "Expired";
		} elseif ($status == 3) {
			return "Deleted";
		}
	}

	function getcombo2($table, $combo_id = "id", $value_feild = "id", $text_feild = "title", $combo_selected = "", $disabled, $class = "", $onchange = "", $title = "", $condtion = "", $multiple = "")
	{
		//echo ($table.'-'.$combo_id.'-'.$value_feild.'-'.$text_feild.'-'.$combo_selected);
		if ($table <> "") {
			global $db_conn;
			global $db_prefix;
			$sql = "select DISTINCT(rank) from cc_call_ranking ";
			if (!empty($condtion)) {
				$sql .= " and " . $condtion . " ";
			} //echo $sql;
			$rs = $db_conn->Execute($sql);
			if ($disabled == true)
				$output = "<select id='$combo_id' name='$combo_id' class='$class' onchange='$onchange' disabled=\"disabled\" $multiple >";
			else
				$output = "<select id='$combo_id' name='$combo_id' class='$class' onchange=\"$onchange\" $multiple>";
			if ($combo_selected == "")
				$output .= "<option value='0'>Please Select " . $title . "</option>";
			while (!$rs->EOF) {

				if ($table == 'admin') {
					$agent_status = $rs->fields['status'] == '1' ? 'Active' : 'Inactive';
					$output .= "<option value=" . $rs->fields[$value_feild] . " >" . $rs->fields[$text_feild] . "&nbsp;(" . $rs->fields['agent_exten'] . "," . $agent_status . ")" . "</option>";
				} else if ($rs->fields[$value_feild] == $combo_selected) {
					$output .= "<option value=" . $rs->fields[$value_feild] . " selected=\"selected\">" . $rs->fields[$text_feild] . "</option>";
				} else {
					$output .= "<option value=" . $rs->fields[$value_feild] . " >" . $rs->fields[$text_feild] . "</option>";
				}
				$rs->MoveNext();
			}
			$output .= "</select>";
		} else if ($table == "status") {
			// not getting from config files that why place over here temporary
			$global_status_inactive				= 0;
			$global_status_active 				= 1;
			$global_status_expired 				= 2;
			$global_status_deleted 				= 3;

			if ($disabled == true)
				$output = "<select id='$combo_id' name='$combo_id' disabled=\"disabled\">";
			else
				$output = "<select id='$combo_id' name='$combo_id'>";
			if ($combo_selected == "")
				$output .= "<option value='-1' selected=\"selected\">Please Select</option>";

			$output .= '<option value="' . $global_status_inactive . '"';
			if ($combo_selected == $global_status_inactive && $combo_selected != "") {
				$output .= 'selected="selected"';
			}
			$output .= '>InActive</option>';
			$output .= '<option value="' . $global_status_active . '"';
			if ($combo_selected == $global_status_active) {
				$output .= 'selected="selected"';
			}
			$output .= '>Active</option>';
			$output .= '<option value="' . $global_status_expired . '"';
			if ($combo_selected == $global_status_expired) {
				$output .= 'selected="selected"';
			}
			$output .= '>Expired</option>';
			$output .= '<option value="' . $global_status_deleted . '"';
			if ($combo_selected == $global_status_deleted) {
				$output .= 'selected="selected"';
			}
			$output .= '>Deleted</option>';
			$output .= "</select>";
		} else {
			$output = "";
		}
		return $output;
	}




	function getcombo_new($table, $combo_id = "id", $value_feild = "id", $text_feild = "title", $combo_selected = "", $disabled, $class = "", $onchange = "", $title = "", $condtion = "", $multiple = "")
	{
		//echo ($table.'-'.$combo_id.'-'.$value_feild.'-'.$text_feild.'-'.$combo_selected);
		if ($table <> "") {
			global $db_conn;
			global $db_prefix;
			$sql = "select * from " . $db_prefix . "_" . $table . " where 1=1 ";
			if (!empty($condtion)) {
				$sql .= " and " . $condtion . " ";
			}
			$rs = $db_conn->Execute($sql);
			if ($disabled == true) {
				$output = "<select id='$combo_id' name='$combo_id' class='$class' onchange='$onchange' disabled=\"disabled\" $multiple >";
			} else {
				$output = "<select id='$combo_id' name='$combo_id' class='$class' onchange=\"$onchange\" $multiple>";
			}

			//if($combo_selected == "")
			#$output.="<option value='0'>Please Select ".$title."</option>";
			$output .= "<option value='0'>Admin (me)</option>";
			while (!$rs->EOF) {

				if ($table == 'admin') {
					$agent_status = $rs->fields['status'] == '1' ? 'Active' : 'Inactive';
					if ($rs->fields[$value_feild] == $combo_selected) {
						$output .= "<option value=" . $rs->fields[$value_feild] . " selected=\"selected\">" . $rs->fields[$text_feild] . "&nbsp;(" . $rs->fields['agent_exten'] . "," . $agent_status . ")" . "</option>";
					} else {
						$output .= "<option value=" . $rs->fields[$value_feild] . " >" . $rs->fields[$text_feild] . "&nbsp;(" . $rs->fields['agent_exten'] . "," . $agent_status . ")" . "</option>";
					}
				} else if ($rs->fields[$value_feild] == $combo_selected) {
					$output .= "<option value=" . $rs->fields[$value_feild] . " selected=\"selected\">" . $rs->fields[$text_feild] . "</option>";
				} else {
					$output .= "<option value=" . $rs->fields[$value_feild] . " >" . $rs->fields[$text_feild] . "</option>";
				}
				$rs->MoveNext();
			}
			$output .= "</select>";
		} else if ($table == "status") {
			// not getting from config files that why place over here temporary
			$global_status_inactive				= 0;
			$global_status_active 				= 1;
			$global_status_expired 				= 2;
			$global_status_deleted 				= 3;

			if ($disabled == true)
				$output = "<select id='$combo_id' name='$combo_id' disabled=\"disabled\">";
			else
				$output = "<select id='$combo_id' name='$combo_id'>";
			if ($combo_selected == "")

				$output .= "<option value='-1' selected=\"selected\">Please Select</option>";

			$output .= '<option value="' . $global_status_inactive . '"';
			if ($combo_selected == $global_status_inactive && $combo_selected != "") {
				$output .= 'selected="selected"';
			}
			$output .= '>InActive</option>';
			$output .= '<option value="' . $global_status_active . '"';
			if ($combo_selected == $global_status_active) {
				$output .= 'selected="selected"';
			}
			$output .= '>Active</option>';
			$output .= '<option value="' . $global_status_expired . '"';
			if ($combo_selected == $global_status_expired) {
				$output .= 'selected="selected"';
			}
			$output .= '>Expired</option>';
			$output .= '<option value="' . $global_status_deleted . '"';
			if ($combo_selected == $global_status_deleted) {
				$output .= 'selected="selected"';
			}
			$output .= '>Deleted</option>';
			$output .= "</select>";
		} else {
			$output = "";
		}
		return $output;
	}

	function getcombo($table, $combo_id = "id", $value_feild = "id", $text_feild = "title", $combo_selected = "", $disabled, $class = "", $onchange = "", $title = "", $condtion = "", $multiple = "")
	{
		if ($table <> "") {
			global $db_conn;
			global $db_prefix;
			$sql = "select * from " . $db_prefix . "_" . $table . " where 1=1 ";
			if (!empty($condtion)) {
				$sql .= " and " . $condtion . " ";
			}
			$rs = $db_conn->Execute($sql);
			if ($disabled == true) {
				$output = "<select id='$combo_id' name='$combo_id' class='$class' onchange='$onchange' disabled=\"disabled\" $multiple >";
			} else {
				$output = "<select id='$combo_id' name='$combo_id' class='$class' onchange=\"$onchange\" $multiple>";
			}
 
			$output .= "<option value='0'>All " . $title . "</option>";
			while (!$rs->EOF) {

				if ($table == 'admin') {
					$agent_status = $rs->fields['status'] == '1' ? 'Active' : 'Inactive';
					if ($rs->fields[$value_feild] == $combo_selected) {
						$output .= "<option value=" . $rs->fields[$value_feild] . " selected=\"selected\">" . $rs->fields[$text_feild] . "&nbsp;(" . $rs->fields['agent_exten'] . "," . $agent_status . ")" . "</option>";
					} else {
						$output .= "<option value=" . $rs->fields[$value_feild] . " >" . $rs->fields[$text_feild] . "&nbsp;(" . $rs->fields['agent_exten'] . "," . $agent_status . ")" . "</option>";
					}
				} else if ($rs->fields[$value_feild] == $combo_selected) {
					$output .= "<option value=" . $rs->fields[$value_feild] . " selected=\"selected\">" . $rs->fields[$text_feild] . "</option>";
				} else {
					$output .= "<option value=" . $rs->fields[$value_feild] . " >" . $rs->fields[$text_feild] . "</option>";
				}
				$rs->MoveNext();
			}
			$output .= "</select>";
		} else if ($table == "status") {
			$global_status_inactive				= 0;
			$global_status_active 				= 1;
			$global_status_expired 				= 2;
			$global_status_deleted 				= 3;

			if ($disabled == true)
				$output = "<select id='$combo_id' name='$combo_id' disabled=\"disabled\">";
			else
				$output = "<select id='$combo_id' name='$combo_id'>";
			if ($combo_selected == "")

				$output .= "<option value='-1' selected=\"selected\">Please Select</option>";

			$output .= '<option value="' . $global_status_inactive . '"';
			if ($combo_selected == $global_status_inactive && $combo_selected != "") {
				$output .= 'selected="selected"';
			}
			$output .= '>InActive</option>';
			$output .= '<option value="' . $global_status_active . '"';
			if ($combo_selected == $global_status_active) {
				$output .= 'selected="selected"';
			}
			$output .= '>Active</option>';
			$output .= '<option value="' . $global_status_expired . '"';
			if ($combo_selected == $global_status_expired) {
				$output .= 'selected="selected"';
			}
			$output .= '>Expired</option>';
			$output .= '<option value="' . $global_status_deleted . '"';
			if ($combo_selected == $global_status_deleted) {
				$output .= 'selected="selected"';
			}
			$output .= '>Deleted</option>';
			$output .= "</select>";
		} else {
			$output = "";
		}
		return $output;
	}


	function getYears($table, $combo_id = "id", $value_feild = "id", $text_feild = "title", $combo_selected = "", $disabled)
	{
		$output = "<select id='$combo_id' name='$combo_id' ";
		if ($disabled == true) $output .= "disabled=\"disabled\"";
		$output .= ">";
		for ($i = 1901; $i <= $year = date("Y"); $i++) {
			if ($i == $combo_selected) {
				$output .= '<option value="' . $i . '" selected="selected" title="' . $i . '">' . $i . '</option>';
			} else {
				$output .= '<option value="' . $i . '" title="' . $i . '">' . $i . '</option>';
			}
		}
		$output .= "</select>";
		return $output;
	}
	function sendEmail($fromemail, $toemail, $toname, $subject, $emaildata, $isHTML = '1', $bcc = '')
	{
		global $company_name;
		if (!empty($isHTML)) {
			$isHTML = true;
		} else {
			$isHTML = false;
		}
		$this->PHPMailer($fromemail, $company_name, $toemail, $toname, $subject, $emaildata, $isHTML);
		return true;

		$headers = "";
		if (!empty($isHTML)) {
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		}
		$headers .= "From: " . $fromemail . "\r\n";
		if (!empty($bcc)) {
			$headers .= "Bcc: " . $bcc . "\r\n";
		}
		$headers .= "Reply-To: " . $fromemail . "\r\n";
		$headers .= "X-Mailer: PHP/" . phpversion();

		if (!empty($toname)) {
			$to		  = $toname . " <" . $toemail . ">"; // note the comma
		} else {
			$to		  = $toemail; // note the comma
		}
		@mail($to, $subject, $emaildata, $headers);
		return true;
	}	// end of function SendEmail

	function PHPMailer($from, $fromName, $to, $toName, $subject, $msgBody, $isHTML = true, $new_file_name = '', $attachment_location = '', $bcc = '', $replyToName = '', $replyToEmail = '')
	{


		global $site_root;
		//include_once($site_root."classes/phpmailer.php");
		//global $smtp_host_1; global $smtp_host_2; global $smtp_user; global $smtp_pass;
		$smtp_host_1    = "10.1.107.202";
		$smtp_host_2    = "";
		$port                   = 25;
		$SMTP_secure    = false;
		$SMTP_Auth      = true;
		$smtp_user              = "mkhurram@ublfunds.com"; //enter here your id
		$smtp_pass              = "ubl@100"; //enter your id password
		$from                   = "mkhurram@ublfunds.com"; //enter sender's email
		$from_name              = "UBL FUND MANAGERS";

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPDebug  = 1;
		$mail->Host = $smtp_host_1 . ";" . $smtp_host_2;
		$mail->SMTPAuth = true;
		$mail->Username = $smtp_user;
		$mail->Password = $smtp_pass;
		//include_once("templates_email.php");
		$mail->AddAttachment("upload" . "/" . $_FILES['file']['name']);
		$mail->From = $from;
		$mail->FromName = $from_name;
		if (empty($replyToEmail)) {
			$mail->AddReplyTo($from, $from_name);
		} else {
			$mail->AddReplyTo($replyToEmail, $replyToName);
		}
		$mail->Subject = $_POST['subject'];
		if (!empty($bcc)) {
			$bcclist = explode(",", $_POST[bcc]);
			foreach ($bcclist as $bcc_add) {
				$mail->AddBCC($bcc_add, 'Member');
			}
		}
		$mail->AddAddress($_POST['to']);
		if ($attachment_location != '') {
		}
		$mail->Body = $_POST['body'];
		//echo "www";exit();
		if ($mail->Send()) {
			$sent = TRUE; //exit();
		} else {
			$sent = FALSE;
			//exit();
		}
		$mail->ClearAddresses();
		unset($mail);
		return true;
	}


	/*	function PHPMailer($from, $fromName, $to, $toName, $subject, $msgBody, $isHTML=true){
		global $site_root;
		include_once($site_root."classes/phpmailer.php");
		global $smtp_host_1; global $smtp_host_2; global $smtp_user; global $smtp_pass;
		$mail = new PHPMailer();
		// SMTP settings
		$mail->IsSMTP();
		$mail->Host = $smtp_host_1;//.";".$smtp_host_2;
		$mail->SMTPAuth = true;
		$mail->Username = $smtp_user;
		$mail->Password = $smtp_pass;

		// message headers
		$mail->From = $from;
		$mail->FromName = $fromName;
		$mail->AddReplyTo($from,$fromName);
		$mail->Subject = $subject;

		// additional parameters
		//$mail->WordWrap = 50;
		$mail->IsHTML($isHTML);

		// set recipient address(es)
		$mail->AddAddress($to,$toName);

		// build message
		$mail->Body = $msgBody;

		// send message
		if($mail->Send()){
			$sent = TRUE;
		}
		// clear mail addresses for next send
		$mail->ClearAddresses();
		// unset mail object
		unset($mail);
		return true;
	 } */
	function getcustomcombo($table, $combo_id = "id", $value_feild = "id", $text_feild = "title", $combo_selected = "", $disabled, $class = "", $multiple = false, $size = 10)
	{
		if ($table <> "") {
			global $db_conn;
			global $db_prefix;
			$combo_selected = explode(',', $combo_selected);
			//print_r($combo_selected);
			$sql = "select * from " . $db_prefix . "_" . $table . " where 1=1 ";
			//echo $value_feild;
			//$sql.= "and id = 0";

			$rs = $db_conn->Execute($sql);
			$combo_id .= "[]";
			$output = "<select id='$combo_id' name='$combo_id' class='$class' size='$size'";
			if ($disabled == true) $output .= "disabled=\"disabled\" ";
			if ($multiple == true) $output .= "multiple=\"multiple\" ";
			$output .= ">";
			#			if($combo_selected == "")
			$output .= "<option value='0'>Please Select " . $title . "</option>";
			while (!$rs->EOF) {
				$exist = false;
				foreach ($combo_selected as $key => $value) {
					if ($rs->fields[$value_feild] == trim($value)) {
						$exist = true;
					}
				}

				if ($exist) {
					$output .= "<option value=" . $rs->fields[$value_feild] . " selected=\"selected\">" . $rs->fields[$text_feild] . "</option>";
				} else {
					$output .= "<option value=" . $rs->fields[$value_feild] . " >" . $rs->fields[$text_feild] . "</option>";
				}
				$rs->MoveNext();
			}
			$output .= "</select>";
		} else {
			$output = "";
		}
		return $output;
	}
	function randomdigit($digits)
	{
		static  $startseed  =  0;
		if (!$startseed) {
			$startseed  =  (float)microtime() * getrandmax();
			srand($startseed);
		}
		$range  =  8;
		$start  =  1;
		$i  =  1;
		while ($i < $digits) {
			$range  =  $range  .  9;
			$start  =  $start  .  0;
			$i++;
		}
		return (rand() % $range + $start);
	}
	function SelectRecordsWithIN($tablename, $columnname1 = '', $value1 = '', $sortcolumn = '', $sortby = 'ASC')
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "select * from " . $db_prefix . "_" . $tablename . " where 1=1 ";

		if (!empty($columnname1) && !empty($value1))
			$sql .= " and $columnname1 IN $value1";
		if (!empty($sortcolumn))
			$sql .= " order by $sortcolumn $sortby";

		//echo("<br>".$sql);

		return $rs = $db_conn->Execute($sql);
	}
	function encrypt_string($su_email)
	{
		return md5($su_email);
	}
	function getJoinNumber($country_code, $city_code, $number)
	{
		$rs = $country_code . "|" . $city_code . "|" . $number;
		return $rs;
	}
	// Get The Client IP Address
	function getRealIpAddr()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	function query_execute($sql)
	{
		global $db_conn;
		global $db_prefix;
		$rs  = $db_conn->Execute($sql);
		return $rs;
	}
	function break_long_string($stringToBreak, $length = 23)
	{
		if (strlen($stringToBreak) > $length) {
			if (strpos($stringToBreak, " ")) {
				$strarr = explode(" ", $stringToBreak);
				for ($i = 0; $i < sizeof($strarr); $i++) {
					if (strlen($strarr[$i]) > $length) {
						$loopsize = round(strlen($strarr[$i]) / $length);
						$j = 0;
						for ($k = 0; $k <= $loopsize; $k++) {
							$strreturn .= substr($strarr[$i], $j, $length) . " ";
							$j = $j + $length;
						}
					} else {
						$strreturn .= $strarr[$i] . " ";
					}
				} #end FOR
			} else {
				$loopsize = strlen($stringToBreak) / $length;
				$j = 0;
				for ($i = 0; $i < $loopsize; $i++) {
					$strreturn .= substr($stringToBreak, $j, $length) . " ";
					$j = $j + $length;
				}
			}
		} else {
			$strreturn = $stringToBreak;
		}
		return $strreturn;
	}
	function get_advance_search_combo($table, $combo_id = "id", $value_feild = "id", $text_feild = "title", $combo_selected = "", $disabled, $class = "")
	{
		if ($table == "filters") {
			// not getting from config files that why place over here temporary
			$id					=	"id";
			$first_name			=	"first_name";
			$last_name			=	"last_name";
			$email				=	"email";
			$user_pass			=	"user_pass";
			$products			=	"products";
			$email_code			=	"email_code";
			$company_name		=	"company_name";
			$type				=	"type";
			$industry			=	"industry";
			$country			=	"country";
			$ip					=	"ip";
			$email_verified		=	"email_verified";
			$verified_date		=	"verified_date";
			$registration_date	=	"registration_date";
			$membership_type	=	"membership_type";
			$status				=	"status";
			$job_title			=	"job_title";
			$business_street	=	"business_street";
			$business_phone_no	=	"business_phone_no";
			$business_fax_no	=	"business_fax_no";
			$business_mobile_no	=	"business_mobile_no";
			$business_city		=	"business_city";
			$business_state		=	"business_state";
			$business_zipcode	=	"business_zipcode";
			$business_country	=	"business_country";
			$business_type		=	"business_type";
			$business_registration_year	=	"business_registration_year";
			$business_total_employees	=	"business_total_employees";
			$business_markets			=	"business_markets";
			$business_logo				=	"business_logo";
			$business_description		=	"business_description";
			$business_url				=	"business_url";
			$msr_status					=	"msr_status";
			$updated_time				=	"updated_time";
			$staff_id					=	"staff_id";
			$staff_updated_date			=	"staff_updated_date";

			$output = "<select id='$combo_id' name='$combo_id' class='$class' ";
			if ($disabled == true) $output .= "disabled=\"disabled\"";
			$output .= ">";
			if ($combo_selected == "") $output .= "<option value='0' selected=\"selected\">Please Select Filter</option>";

			//$output.='<option value="'.$id.'"'; if($combo_selected==$id){$output.= 'selected="selected"';}	$output.='>Member ID</option>';
			$output .= '<option value="' . $first_name . '"';
			if ($combo_selected == $first_name) {
				$output .= 'selected="selected"';
			}
			$output .= '>Name</option>';
			//$output.='<option value="'.$last_name.'"'; if($combo_selected==$last_name){$output.= 'selected="selected"';}	$output.='>Last Name</option>';
			$output .= '<option value="' . $email . '"';
			if ($combo_selected == $email) {
				$output .= 'selected="selected"';
			}
			$output .= '>Email</option>';
			//$output.='<option value="'.$user_pass.'"'; if($combo_selected==$user_pass){$output.= 'selected="selected"';}	$output.='>Member Password</option>';
			$output .= '<option value="' . $products . '"';
			if ($combo_selected == $products) {
				$output .= 'selected="selected"';
			}
			$output .= '>Products</option>';
			//$output.='<option value="'.$email_code.'"'; if($combo_selected==$email_code){$output.= 'selected="selected"';}	$output.='>Email Code</option>';
			$output .= '<option value="' . $company_name . '"';
			if ($combo_selected == $company_name) {
				$output .= 'selected="selected"';
			}
			$output .= '>Company Name</option>';
			$output .= '<option value="' . $type . '"';
			if ($combo_selected == $type) {
				$output .= 'selected="selected"';
			}
			$output .= '>Type</option>';
			$output .= '<option value="' . $industry . '"';
			if ($combo_selected == $industry) {
				$output .= 'selected="selected"';
			}
			$output .= '>Industry</option>';
			$output .= '<option value="' . $country . '"';
			if ($combo_selected == $country) {
				$output .= 'selected="selected"';
			}
			$output .= '>Country</option>';
			//$output.='<option value="'.$ip.'"'; if($combo_selected==$ip){$output.= 'selected="selected"';}	$output.='>IP</option>';			
			$output .= '<option value="' . $email_verified . '"';
			if ($combo_selected == $email_verified) {
				$output .= 'selected="selected"';
			}
			$output .= '>Email Verified</option>';
			$output .= '<option value="' . $verified_date . '"';
			if ($combo_selected == $verified_date) {
				$output .= 'selected="selected"';
			}
			$output .= '>Verfied Date</option>';
			$output .= '<option value="' . $registration_date . '"';
			if ($combo_selected == $registration_date) {
				$output .= 'selected="selected"';
			}
			$output .= '>Reg Date</option>';
			$output .= '<option value="' . $membership_type . '"';
			if ($combo_selected == $membership_type) {
				$output .= 'selected="selected"';
			}
			$output .= '>Membership Type</option>';
			$output .= '<option value="' . $status . '"';
			if ($combo_selected == $status) {
				$output .= 'selected="selected"';
			}
			$output .= '>Status</option>';
			$output .= '<option value="' . $job_title . '"';
			if ($combo_selected == $job_title) {
				$output .= 'selected="selected"';
			}
			$output .= '>Job Title</option>';
			$output .= '<option value="' . $business_street . '"';
			if ($combo_selected == $business_street) {
				$output .= 'selected="selected"';
			}
			$output .= '>Street</option>';
			$output .= '<option value="' . $business_phone_no . '"';
			if ($combo_selected == $business_phone_no) {
				$output .= 'selected="selected"';
			}
			$output .= '>Phone No</option>';
			$output .= '<option value="' . $business_fax_no . '"';
			if ($combo_selected == $business_fax_no) {
				$output .= 'selected="selected"';
			}
			$output .= '>Fax No.</option>';
			$output .= '<option value="' . $business_mobile_no . '"';
			if ($combo_selected == $business_mobile_no) {
				$output .= 'selected="selected"';
			}
			$output .= '>Mobile No.</option>';
			$output .= '<option value="' . $business_city . '"';
			if ($combo_selected == $business_city) {
				$output .= 'selected="selected"';
			}
			$output .= '>City</option>';
			$output .= '<option value="' . $business_state . '"';
			if ($combo_selected == $business_state) {
				$output .= 'selected="selected"';
			}
			$output .= '>State</option>';
			$output .= '<option value="' . $business_zipcode . '"';
			if ($combo_selected == $business_zipcode) {
				$output .= 'selected="selected"';
			}
			$output .= '>Zip Code</option>';
			$output .= '<option value="' . $business_country . '"';
			if ($combo_selected == $business_country) {
				$output .= 'selected="selected"';
			}
			$output .= '>Country</option>';
			$output .= '<option value="' . $business_type . '"';
			if ($combo_selected == $business_type) {
				$output .= 'selected="selected"';
			}
			$output .= '>Business Type</option>';
			$output .= '<option value="' . $business_registration_year . '"';
			if ($combo_selected == $business_registration_year) {
				$output .= 'selected="selected"';
			}
			$output .= '>Reg Year</option>';
			$output .= '<option value="' . $business_total_employees . '"';
			if ($combo_selected == $business_total_employees) {
				$output .= 'selected="selected"';
			}
			$output .= '>Total Employees</option>';
			$output .= '<option value="' . $business_markets . '"';
			if ($combo_selected == $business_markets) {
				$output .= 'selected="selected"';
			}
			$output .= '>Markets</option>';
			$output .= '<option value="' . $business_logo . '"';
			if ($combo_selected == $business_logo) {
				$output .= 'selected="selected"';
			}
			$output .= '>Logo</option>';
			$output .= '<option value="' . $business_description . '"';
			if ($combo_selected == $business_description) {
				$output .= 'selected="selected"';
			}
			$output .= '>Description</option>';
			$output .= '<option value="' . $business_url . '"';
			if ($combo_selected == $business_url) {
				$output .= 'selected="selected"';
			}
			$output .= '>URL</option>';
			//$output.='<option value="'.$msr_status.'"'; if($combo_selected==$msr_status){$output.= 'selected="selected"';}	$output.='>Email</option>';
			$output .= '<option value="' . $updated_time . '"';
			if ($combo_selected == $updated_time) {
				$output .= 'selected="selected"';
			}
			$output .= '>Updated Time</option>';
			$output .= '<option value="' . $staff_id . '"';
			if ($combo_selected == $staff_id) {
				$output .= 'selected="selected"';
			}
			$output .= '>Staff</option>';
			$output .= '<option value="' . $staff_updated_date . '"';
			if ($combo_selected == $staff_updated_date) {
				$output .= 'selected="selected"';
			}
			$output .= '>Staff Updated Time</option>';

			$output .= "</select>";
		} else if ($table == "criteria") {

			$less_than				=	"<";
			$less_than_equal_to		=	"<=";
			$greater_than			=	">";
			$greater_than_equal_to	=	">=";
			$equal_to				=	"=";
			$not_equal_to			=	"<>";
			$contains				=	"like";



			$output = "<select id='$combo_id' name='$combo_id' class='$class' ";
			if ($disabled == true) $output .= "disabled=\"disabled\"";
			$output .= ">";

			if ($combo_selected == "") $output .= "<option value='0' selected=\"selected\">Please Select Operator</option>";

			$output .= '<option value="' . $less_than . '"';
			if ($combo_selected == $less_than) {
				$output .= 'selected="selected"';
			}
			$output .= '>' . $less_than . '</option>';
			$output .= '<option value="' . $less_than_equal_to . '"';
			if ($combo_selected == $less_than_equal_to) {
				$output .= 'selected="selected"';
			}
			$output .= '>' . $less_than_equal_to . '</option>';
			$output .= '<option value="' . $greater_than . '"';
			if ($combo_selected == $greater_than) {
				$output .= 'selected="selected"';
			}
			$output .= '>' . $greater_than . '</option>';
			$output .= '<option value="' . $greater_than_equal_to . '"';
			if ($combo_selected == $greater_than_equal_to) {
				$output .= 'selected="selected"';
			}
			$output .= '>' . $greater_than_equal_to . '</option>';
			$output .= '<option value="' . $equal_to . '"';
			if ($combo_selected == $equal_to) {
				$output .= 'selected="selected"';
			}
			$output .= '>' . $equal_to . '</option>';
			$output .= '<option value="' . $not_equal_to . '"';
			if ($combo_selected == $not_equal_to) {
				$output .= 'selected="selected"';
			}
			$output .= '>' . $not_equal_to . '</option>';
			$output .= '<option value="' . $contains . '"';
			if ($combo_selected == $contains) {
				$output .= 'selected="selected"';
			}
			$output .= '>' . $contains . '</option>';

			$output .= "</select>";
		} else {
			$output = "";
		}
		return $output;
	}
	function validateEmail($email)
	{
		if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $email)) {
			return true;
		}
		return false;
	}
	function validateAlphaString($val)
	{
		if (preg_match('/^([a-zA-Z0-9._-\space\&,])+$/', $val)) {
			return true;
		}
		return false;
	}
	function validateString($val)
	{
		if (preg_match('/^([a-zA-Z_-\space])+$/', $val)) {
			return true;
		}
		return false;
	}
	function validateNumber($val)
	{
		if (preg_match('/^([0-9_-\space])+$/', $val) && is_numeric($val)) {
			return true;
		}
		return false;
	}
	function validateFloat($val)
	{
		// -- /^([0-9.]+)$/
		if (preg_match('/^[0-9]*\.?[0-9]+$/', $val) && (is_float($val) || is_numeric($val))) {
			return true;
		}
		return false;
	}
	function validateURL($val)
	{
		#	if(preg_match('((^ht|f)tps?://([-\w\.]+)+(:\d+)?(/([\w/_\.]?)?)?)', $val)){
		#	if(preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?\/?/i', $val)){
		if (preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $val)) {
			#		'^(https?://)?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-z_!~*'()-]+\.)*([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\.[a-z]{2,6})(:[0-9]{1,4})?((/?)|(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$'
			#		$regex="";
			#		if(preg_match('(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?',$val)){
			return true;
		}
		#		elseif(preg_match('@(([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@', $val)){
		#		 return true;
		#	 	}
		return false;
	}
	/* 1st Oct 2010*/
	function queryDataFilter($dataValue)
	{
		if (is_array($dataValue)) {
			foreach ($dataValue as $d) {
				$data[] = htmlentities(strip_tags($d), ENT_QUOTES);
			}
			return $data;
		} else {
			return htmlentities(strip_tags($dataValue), ENT_QUOTES);
		}
	}
	function getChildCategoriesByParentID($parent_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "_categories where status=1 and parent_id=$parent_id order by category_title;";
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function findexts($filename)
	{
		$filename = strtolower($filename);
		$exts = split("[/\\.]", $filename);
		$n = count($exts) - 1;
		$exts = $exts[$n];
		return $exts;
	}
	function get_link_hits($from_date = '', $to_date = '', $startRec, $endRec, $field, $order, $link_id = '', $code = '')
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select ck.id,ck.keyword_title,ck.keyword_url,c.channel_title,sum(counter) as hit_counts from " . $db_prefix . "_partner_link_hits plh ";
		if ($code = 'mt') {
			$sql .= " , " . $db_prefix . "_wot_admin_channels_keyword ck ";
			$sql .= " , " . $db_prefix . "_wot_admin_channels c ";
		}
		$sql .= " where 1=1 ";
		if ($code = 'mt') {
			$sql .= " and ck.id = SUBSTRING(plh.partner_code,4)  and plh.partner_code like 'mt-%' and c.id = ck.channel_id ";
			if (!empty($link_id)) {
				$sql .= " and ck.id = '" . $link_id . "' ";
			}
		}
		if (!empty($from_date) && !empty($to_date)) {
			$sql .= " and activity_date > '" . $from_date . "' and activity_date < '" . $to_date . "' ";
		}
		if (!empty($link_id) && !empty($code)) {
			$sql .= " and partner_code = '" . $code . "-" . $link_id . "' ";
		}
		$sql .= " GROUP BY plh.partner_code ";
		$sql .= " order by $field $order ";
		$sql .= "limit $startRec, $endRec;";
		#echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function get_link_hits_count($from_date = '', $to_date = '', $link_id = '', $code = '')
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "_partner_link_hits plh  ";
		if ($code = 'mt') {
			$sql .= " , " . $db_prefix . "_wot_admin_channels_keyword ck ";
			$sql .= " , " . $db_prefix . "_wot_admin_channels c ";
		}
		$sql .= " where 1=1 ";
		if ($code = 'mt') {
			$sql .= " and ck.id = SUBSTRING(plh.partner_code,4)  and plh.partner_code like 'mt-%' and c.id = ck.channel_id ";
			if (!empty($link_id)) {
				$sql .= " and ck.id = '" . $link_id . "' ";
			}
		}
		if (!empty($from_date) && !empty($to_date)) {
			$sql .= " and plh.activity_date > '" . $from_date . "' and plh.activity_date < '" . $to_date . "'";
		}
		if (!empty($link_id)) {
			$sql .= " and plh.partner_code = '" . $code . "-" . $link_id . "' ";
		}
		$sql .= " GROUP BY plh.partner_code ";
		#echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs->rowCount();
	}
	function generate_code($ref = "A")
	{
		global $res_code;
		$ref = preg_replace("/[^A-Za-z0-9 ]/", "", trim($ref));
		$ref = preg_replace('/\s+/', '-', trim($ref));
		//'rs-'
		return trim($ref);
	}
	function validateresellercode($code)
	{
		if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\.-])*+$/", $code)) {
			return true;
		}
		return false;
	}
	function set_session_tree($unique_id, $key, $value)
	{
		/*global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_call_session ";
		$sql .= " (id, unique_id, key, value, status, update_datetime) ";
		$sql .= " values ('', '".$unique_id."','".$key."','".$value."','0',now())";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);*/
	}
}
