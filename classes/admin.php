<?php
#		$user_pin->update_user_status($unique_id,$caller_id,3,201,$_SESSION[$db_prefix.'_UserId']);  // from talking to pin genration

class admin
{
	function admin()
	{
		//	echo 'dsd';die;
	}

	function location_wise_pie_chart($fdate, $tdate)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT COUNT(ticket.ticket_id) AS rec,location FROM cc_admin  LEFT  JOIN  ts_ticket AS ticket ON ticket.who_created = cc_admin.admin_id";
		if ($fdate && $tdate) {
			$sql .= " AND DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "' ";
		}
		$sql .= " GROUP BY location";
		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function product_wise_pie_chart($fdate, $tdate)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT COUNT(ticket.ticket_id) AS rec,product.p_title AS product FROM cc_products product LEFT JOIN ts_ticket AS ticket ON ticket.product =product.p_title ";
		if ($fdate && $tdate) {
			$sql .= " AND DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "' ";
		}
		$sql .= " WHERE product.parent_id = 0  GROUP BY product.p_title ";
		//echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function ticket_status_wise_pie_chart($fdate, $tdate)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT COUNT(ticket.ticket_id) AS rec,t_status.name FROM ts_ticket_status AS t_status LEFT JOIN ts_ticket AS ticket ON ticket.status_id = t_status.id";
		if ($fdate && $tdate) {
			$sql .= " AND DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "' ";
		}
		$sql .= " WHERE t_status.id IN(1,2,3) GROUP BY t_status.id ";
		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function ticket_priority_wise_pie_chart($fdate, $tdate)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT COUNT(ticket.ticket_id) AS rec,priority.priority_desc FROM ts_ticket_priority AS priority
  			   LEFT JOIN ts_ticket__cdata AS cdata ON cdata.priority = priority.priority_id LEFT JOIN ts_ticket AS ticket 
			   ON ticket.ticket_id = cdata.ticket_id ";
		if ($fdate && $tdate) {
			$sql .= " AND DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "' ";
		}
		$sql .= " GROUP BY priority.priority_id ";
		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function found_rows()
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select FOUND_ROWS()";
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function pagination($row, $per_page = 10, $page = 1, $url = '?')
	{
		//global $conDB; 
		//echo $query;
		//$row = mysql_fetch_array(mysql_query($query));
		// $row = mysql_fetch_array(mysql_query($query));
		//$row = ;
		// print_r($row);
		//die;
		//$total = $row['num'];
		$total = $row[0]; // mysql_num_rows(mysql_query($query));
		$adjacents = "2";

		$prevlabel = "&lsaquo; Prev";
		$nextlabel = "Next &rsaquo;";
		$lastlabel = "Last &rsaquo;&rsaquo;";

		$page = ($page == 0 ? 1 : $page);
		$start = ($page - 1) * $per_page;

		$prev = $page - 1;
		$next = $page + 1;

		$lastpage = ceil($total / $per_page);

		$lpm1 = $lastpage - 1; // //last page minus 1

		$pagination = "";
		if ($lastpage > 1) {
			$pagination .= "<ul>";
			//if ($page < $counter - 1) {
			//$pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
			// }  
			if ($page > 1) $pagination .= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";

			if ($lastpage < 7 + ($adjacents * 2)) {
				for ($counter = 1; $counter <= $lastpage; $counter++) {
					if ($counter == $page)
						$pagination .= "<li class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
					else
						$pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
				}
			} elseif ($lastpage > 5 + ($adjacents * 2)) {

				if ($page < 1 + ($adjacents * 2)) {

					for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
						if ($counter == $page)
							$pagination .= "<li  class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
						else
							$pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
					}
					$pagination .= "<li class='dot'>...</li>";
					$pagination .= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
					$pagination .= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
				} elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

					$pagination .= "<li><a href='{$url}page=1'>1</a></li>";
					$pagination .= "<li><a href='{$url}page=2'>2</a></li>";
					$pagination .= "<li class='dot'>...</li>";
					for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
						if ($counter == $page)
							$pagination .= "<li class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
						else
							$pagination .= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";
					}
					$pagination .= "<li class='dot'>..</li>";
					$pagination .= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
					$pagination .= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";
				} else {

					$pagination .= "<li><a href='{$url}page=1'>1</a></li>";
					$pagination .= "<li><a href='{$url}page=2'>2</a></li>";
					$pagination .= "<li class='dot'>..</li>";
					for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
						if ($counter == $page)
							$pagination .= "<li class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
						else
							$pagination .= "<li><a  href='{$url}page={$counter}'>{$counter}</a></li>";
					}
				}
			}

			if ($page < $counter - 1) {
				//$pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
				$pagination .= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";

				// $pagination.= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
			}

			$pagination .= "</ul>";
		}

		return $pagination;
	}

	// Time format is UNIX timestamp or
	// PHP strtotime compatible strings
	function dateDiff($time1, $time2, $precision = 3)
	{
		// If not numeric then convert texts to unix timestamps
		if (!is_int($time1)) {
			$time1 = strtotime($time1);
		}
		if (!is_int($time2)) {
			$time2 = strtotime($time2);
		}

		// If time1 is bigger than time2
		// Then swap time1 and time2
		if ($time1 > $time2) {
			$ttime = $time1;
			$time1 = $time2;
			$time2 = $ttime;
		}

		// Set up intervals and diffs arrays
		$intervals = array('day', 'hour', 'minute');
		$diffs = array();

		// Loop thru all intervals
		foreach ($intervals as $interval) {
			// Set default diff to 0
			$diffs[$interval] = 0;
			// Create temp time from time1 and interval
			$ttime = strtotime("+1 " . $interval, $time1);

			// Loop until temp time is smaller than time2
			while ($time2 >= $ttime) {
				$time1 = $ttime;
				$diffs[$interval]++;
				// Create new temp time from time1 and interval
				$ttime = strtotime("+1 " . $interval, $time1);
			}
		}

		$count = 0;
		$times = array();
		// Loop thru all diffs
		foreach ($diffs as $interval => $value) {
			// Break if we have needed precission
			if ($count >= $precision) {
				break;
			}
			// Add value and interval 
			// if value is bigger than 0
			if ($value > 0) {
				// Add s if value is not 1
				if ($value != 1) {
					$interval .= "s";
				}
				// Add value and interval to times array
				$times[] = $value . " " . $interval;
				$count++;
			}
		}

		// Return string with times
		return implode(", ", $times);
	}

	function callcenter_crm_detailed_report($startpoint, $per_page, $fdate, $tdate, $product, $priority, $status, $agent_id, $location, $natures, $intime_over_due, $depart, $sec, $frdate, $trdate, $complaint_id)
	{
		global $db_conn;
		global $db_prefix;
		//  echo $startpoint;
		// echo $per_page;
		$prefix = "ts";
		$sql = "SELECT SQL_CALC_FOUND_ROWS ticket.number,DATE_FORMAT(ticket.created, '%d-%m-%Y %h:%i:%s %p') AS   date_time,ticket.created,ticket.lastmessage,";
		$sql .= "DATE_FORMAT(responder.due_date, '%d-%m-%Y %h:%i:%s %p') AS time_assigned,responder.product,responder.nature,responder.others,";
		$sql .= "css_agent_owner.full_name as creater,css_agent.full_name,css_agent.location AS location,responder.poster AS firstname,depart.dept_name,staff.section,teams.name AS tdepart_name,tdepart.dept_name AS  old_depart,";
		$sql .= "DATE_FORMAT(responder.created , '%d-%m-%Y %h:%i:%s %p') AS response_datetime,responder.created AS response_time,responder.thread_type AS action_type,";
		$sql .= "(SELECT MAX(created) FROM ts_ticket_thread WHERE id < responder.id AND ticket_id = ticket.ticket_id AND thread_type <> 'N' AND poster <> 'SYSTEM') AS last_agent_response, ";
		$sql .= "tstatus.name,responder.status AS status_id,tpriority.priority_desc,responder.is_overdue isoverdue,ticket.updated AS close_date FROM ts_ticket AS ticket ";
		//(thread_type <> 'E' OR 
		$sql .= " LEFT JOIN ts_ticket_thread AS responder ON responder.ticket_id = ticket.ticket_id AND responder.poster <> 'SYSTEM'  AND responder.thread_type <> 'N' ";


		$sql .= "INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		if ($frdate && $trdate) {
			$sql .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "' AND responder.thread_type <>'A') ";
		}
		$sql .= " INNER JOIN cc_admin AS css_agent_owner ON css_agent_owner.admin_id = ticket.who_created ";

		if ($agent_id) {
			$sql .= " AND ticket.who_created = '" . $agent_id . "'";
		}
		if ($complaint_id) {
			$sql .= " AND ticket.ticket_id='" . $complaint_id . "'";
		}

		if ($location) {
			$sql .= " AND css_agent.location = '" . $location . "' ";
		}
		/* $sql.=" LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		  if($sec){
				  $sql.=" AND staff.section ='".$sec."'";
			  } */
		/*if($sec){
			    $sql.="INNER JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
				  $sql.=" AND staff.section ='".$sec."'";
			  }else{
				$sql.="LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";  
			  }*/

		$sql .= "LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		$sql .= "LEFT JOIN ts_department AS depart ON depart.dept_id = staff.dept_id  ";
		$sql .= "LEFT JOIN ts_department AS tdepart ON tdepart.dept_id = ticket.dept_id  ";
		$sql .= "LEFT JOIN ts_team AS teams ON teams.team_id = responder.team_id ";
		$sql .= "LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id=ticket.status_id ";
		// $sql.="LEFT JOIN ts_ticket__cdata AS tcdata ON tcdata.ticket_id = ticket.ticket_id ";
		$sql .= " LEFT JOIN ts_ticket__cdata AS tcdata  ON tcdata.ticket_id = responder.ticket_id ";
		if ($sec) {
			$sql .= "LEFT JOIN ts_team AS tteams ON tteams.team_id = ticket.team_id ";
		}
		/*$sql.="INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		   if($priority){
			  $sql.=" AND tcdata.priority ='".$priority."'";
		   }  */
		/*
		    if($priority){
			    $sql.="INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = responder.priority_id  ";
				$sql.=" AND tcdata.priority ='".$priority."'";
			   }else{
					$sql.="LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = responder.priority_id  ";
			   }  */

		$sql .= " LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = responder.priority_id  ";


		$sql .= " WHERE DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "'";

		if ($depart) {
			$sql .= " AND ticket.team_id='" . $depart . "' ";
			//$sql.=" AND responder.team_id='".$depart."' ";
		}
		if ($sec) {
			//$sql.=" AND teams.name LIKE '%".$sec."%'";  // AND tteams.name
			$sql .= " AND tteams.name LIKE '%" . $sec . "%'";
		}
		if ($intime_over_due != "") {
			$sql .= " AND ticket.isoverdue='" . $intime_over_due . "' ";
			//$sql.=" AND responder.is_overdue='".$intime_over_due."' ";

		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($priority) {
			//$sql.=" AND responder.priority_id ='".$priority."'";
			$sql .= " AND tcdata.priority  ='" . $priority . "'";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "'";  // AND responder.status = '1'
			// $sql.=" AND responder.status='".$status."'";
		}
		$sql .= " GROUP BY responder.id  ORDER BY responder.id DESC  ";
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		//echo $sql; 
		$rs = $db_conn->Execute($sql);
		return $rs;
	}




	function callcenter_crm_report($startpoint, $per_page, $fdate, $tdate, $product, $priority, $status, $agent_id, $location, $natures, $intime_over_due, $depart, $sec, $frdate, $trdate, $complaint_id)
	{
		global $db_conn;
		global $db_prefix;
		//  echo $startpoint;
		// echo $per_page;
		$prefix = "ts";
		$sql = "SELECT SQL_CALC_FOUND_ROWS ticket.number,DATE_FORMAT(ticket.created, '%d-%m-%Y %h:%i:%s %p') AS   date_time,ticket.created,ticket.lastmessage,";
		$sql .= " DATE_FORMAT(ticket.duedate, '%d-%m-%Y %h:%i:%s %p') AS time_assigned,responder.product,responder.nature,responder.others, ";
		$sql .= "css_agent_owner.full_name as creater,css_agent.full_name,css_agent.location AS location,responder.poster AS firstname,depart.dept_name,staff.section,teams.name AS tdepart_name,";
		$sql .= "DATE_FORMAT(responder.created , '%d-%m-%Y %h:%i:%s %p') AS response_datetime,responder.created AS response_time,responder.thread_type AS action_type,";
		$sql .= "(SELECT MAX(created) FROM ts_ticket_thread WHERE id < responder.id AND ticket_id = ticket.ticket_id AND thread_type <> 'N'
       AND poster <> 'SYSTEM' ) AS last_agent_response, ";
		$sql .= "tstatus.name,tstatus.id AS status_id,tpriority.priority_desc,responder.is_overdue AS isoverdue,ticket.updated AS close_date FROM ts_ticket AS ticket ";

		$sql .= " LEFT JOIN ts_ticket_thread AS responder  ON responder.id = (SELECT MAX(thread.id)  FROM ts_ticket_thread AS thread WHERE thread.ticket_id = ticket.ticket_id 
		  AND thread.poster <> 'SYSTEM' AND thread.thread_type <> 'N' ORDER BY thread.id DESC LIMIT 1 )";

		// $sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		//$sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ticket.who_created ";  
		$sql .= "INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		if ($frdate && $trdate) {
			$sql .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "' AND responder.thread_type <>'A') ";
		}
		if ($agent_id) {
			$sql .= " AND ticket.who_created = '" . $agent_id . "'";
		}
		if ($complaint_id) {
			$sql .= " AND ticket.ticket_id='" . $complaint_id . "'";
		}

		if ($location) {
			$sql .= " AND css_agent.location = '" . $location . "' ";
		}

		// $sql.=" AND thread.staff_id <> 0 ORDER BY thread.id DESC LIMIT 1 ) AND responder.staff_id <> 0 ";
		//$sql.=" LEFT JOIN ts_ticket_thread AS responder ON responder.ticket_id = ticket.ticket_id  AND responder.poster <> 'SYSTEM'";

		//if($sec){
		//  $sql.="INNER JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		// $sql.=" AND staff.section ='".$sec."'";
		// }else{
		$sql .= "LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		//}
		$sql .= " LEFT JOIN ts_department AS depart ON depart.dept_id = staff.dept_id  ";
		$sql .= " LEFT JOIN ts_team AS teams ON teams.team_id = ticket.team_id  ";

		$sql .= "LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id=ticket.status_id ";
		$sql .= "LEFT JOIN ts_ticket__cdata AS tcdata ON tcdata.ticket_id = ticket.ticket_id ";


		if ($priority) {
			$sql .= "INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
			$sql .= " AND tcdata.priority ='" . $priority . "'";
		} else {
			$sql .= "LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		}
		$sql .= " INNER JOIN cc_admin AS css_agent_owner ON css_agent_owner.admin_id = ticket.who_created ";

		$sql .= " WHERE DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "'";

		if ($depart) {
			$sql .= " AND ticket.team_id='" . $depart . "' ";
		}
		if ($sec) {
			$sql .= " AND teams.name LIKE '%" . $sec . "%'";
		}
		if ($intime_over_due != "") {
			$sql .= " AND ticket.isoverdue='" . $intime_over_due . "' ";
			//$sql.=" AND  responder.is_overdue ='".$intime_over_due."' ";
		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "'";
		}
		$sql .= " GROUP BY ticket.ticket_id  ORDER BY ticket.created DESC  "; // ,responder.created 
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		// echo $sql; 
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function callcenter_crm_report_v2($startpoint, $per_page, $fdate, $tdate, $product, $priority, $status, $agent_id, $location, $natures, $intime_over_due, $depart, $sec, $frdate, $trdate, $complaint_id)
	{
		global $db_conn;
		global $db_prefix;
		//  echo $startpoint;
		// echo $per_page;
		$prefix = "ts";
		$sql = "SELECT SQL_CALC_FOUND_ROWS ticket.number,DATE_FORMAT(ticket.created, '%d-%m-%Y %h:%i:%s %p') AS   date_time,ticket.created,ticket.lastmessage,";
		$sql .= " DATE_FORMAT(ticket.duedate, '%d-%m-%Y %h:%i:%s %p') AS time_assigned,responder.product,responder.nature,responder.others, ";
		$sql .= "css_agent_owner.full_name as creater,css_agent.full_name,css_agent.location AS location,responder.poster AS firstname,depart.dept_name,staff.section,teams.name AS tdepart_name,";
		$sql .= "DATE_FORMAT(responder.created , '%d-%m-%Y %h:%i:%s %p') AS response_datetime,responder.created AS response_time,responder.thread_type AS action_type,";
		$sql .= "(SELECT MAX(created) FROM ts_ticket_thread WHERE id < responder.id AND ticket_id = ticket.ticket_id AND thread_type <> 'N'
       AND poster <> 'SYSTEM' ) AS last_agent_response, ";
		$sql .= "tstatus.name,tstatus.id AS status_id,tpriority.priority_desc,responder.is_overdue AS isoverdue,ticket.updated AS close_date,ticket.isoverdue AS is_overdue FROM ts_ticket AS ticket ";

		$sql .= " LEFT JOIN ts_ticket_thread AS responder  ON responder.id = (SELECT MAX(thread.id)  FROM ts_ticket_thread AS thread WHERE thread.ticket_id = ticket.ticket_id 
		  AND thread.poster <> 'SYSTEM' AND thread.thread_type <> 'N' ORDER BY thread.id DESC LIMIT 1 )";

		// $sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		//$sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ticket.who_created ";  
		$sql .= "INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		if ($frdate && $trdate) {
			$sql .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "' AND responder.thread_type <>'A') ";
		}
		if ($agent_id) {
			$sql .= " AND ticket.who_created = '" . $agent_id . "'";
		}
		if ($complaint_id) {
			$sql .= " AND ticket.ticket_id='" . $complaint_id . "'";
		}

		if ($location) {
			$sql .= " AND css_agent.location = '" . $location . "' ";
		}

		// $sql.=" AND thread.staff_id <> 0 ORDER BY thread.id DESC LIMIT 1 ) AND responder.staff_id <> 0 ";
		//$sql.=" LEFT JOIN ts_ticket_thread AS responder ON responder.ticket_id = ticket.ticket_id  AND responder.poster <> 'SYSTEM'";

		//if($sec){
		//  $sql.="INNER JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		// $sql.=" AND staff.section ='".$sec."'";
		// }else{
		$sql .= "LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		//}
		$sql .= " LEFT JOIN ts_department AS depart ON depart.dept_id = staff.dept_id  ";
		$sql .= " LEFT JOIN ts_team AS teams ON teams.team_id = ticket.team_id  ";

		$sql .= "LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id=ticket.status_id ";
		$sql .= "LEFT JOIN ts_ticket__cdata AS tcdata ON tcdata.ticket_id = ticket.ticket_id ";


		if ($priority) {
			$sql .= "INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
			$sql .= " AND tcdata.priority ='" . $priority . "'";
		} else {
			$sql .= "LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		}
		$sql .= " INNER JOIN cc_admin AS css_agent_owner ON css_agent_owner.admin_id = ticket.who_created ";

		$sql .= " WHERE DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "'";

		if ($depart) {
			$sql .= " AND ticket.team_id='" . $depart . "' ";
		}
		if ($sec) {
			$sql .= " AND teams.name LIKE '%" . $sec . "%'";
		}
		if ($intime_over_due != "") {
			$sql .= " AND ticket.isoverdue='" . $intime_over_due . "' ";
			//$sql.=" AND  responder.is_overdue ='".$intime_over_due."' ";
		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "'";
		}
		$sql .= " GROUP BY ticket.ticket_id  ORDER BY ticket.created DESC  "; // ,responder.created 
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		// echo $sql; 
		$rs = $db_conn->Execute($sql);
		return $rs;
	}


	function callcenter_crm_detailed_report_v2($startpoint, $per_page, $fdate, $tdate, $product, $priority, $status, $agent_id, $location, $natures, $intime_over_due, $depart, $sec, $frdate, $trdate, $complaint_id)
	{
		global $db_conn;
		global $db_prefix;
		//  echo $startpoint;
		// echo $per_page;
		$prefix = "ts";
		$sql = "SELECT SQL_CALC_FOUND_ROWS ticket.number,DATE_FORMAT(ticket.created, '%d-%m-%Y %h:%i:%s %p') AS   date_time,ticket.created,ticket.lastmessage,";
		$sql .= "DATE_FORMAT(responder.due_date, '%d-%m-%Y %h:%i:%s %p') AS time_assigned,responder.product,responder.nature,responder.others,";
		$sql .= "css_agent_owner.full_name as creater,css_agent.full_name,css_agent.location AS location,responder.poster AS firstname,depart.dept_name,staff.section,teams.name AS tdepart_name,tdepart.dept_name AS  old_depart,";
		$sql .= "DATE_FORMAT(responder.created , '%d-%m-%Y %h:%i:%s %p') AS response_datetime,responder.created AS response_time,responder.thread_type AS action_type,";
		$sql .= "(SELECT MAX(created) FROM ts_ticket_thread WHERE id < responder.id AND ticket_id = ticket.ticket_id AND thread_type <> 'N' AND poster <> 'SYSTEM') AS last_agent_response, ";
		$sql .= "tstatus.name,responder.status AS status_id,tpriority.priority_desc,responder.is_overdue isoverdue,ticket.updated AS close_date,ticket.isoverdue AS is_overdue FROM ts_ticket AS ticket ";
		//(thread_type <> 'E' OR 
		$sql .= " LEFT JOIN ts_ticket_thread AS responder ON responder.ticket_id = ticket.ticket_id AND responder.poster <> 'SYSTEM'  AND responder.thread_type <> 'N' ";


		$sql .= "INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		if ($frdate && $trdate) {
			$sql .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "' AND responder.thread_type <>'A') ";
		}
		$sql .= " INNER JOIN cc_admin AS css_agent_owner ON css_agent_owner.admin_id = ticket.who_created ";

		if ($agent_id) {
			$sql .= " AND ticket.who_created = '" . $agent_id . "'";
		}
		if ($complaint_id) {
			$sql .= " AND ticket.ticket_id='" . $complaint_id . "'";
		}

		if ($location) {
			$sql .= " AND css_agent.location = '" . $location . "' ";
		}
		/* $sql.=" LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		  if($sec){
				  $sql.=" AND staff.section ='".$sec."'";
			  } */
		/*if($sec){
			    $sql.="INNER JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
				  $sql.=" AND staff.section ='".$sec."'";
			  }else{
				$sql.="LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";  
			  }*/

		$sql .= "LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		$sql .= "LEFT JOIN ts_department AS depart ON depart.dept_id = staff.dept_id  ";
		$sql .= "LEFT JOIN ts_department AS tdepart ON tdepart.dept_id = ticket.dept_id  ";
		$sql .= "LEFT JOIN ts_team AS teams ON teams.team_id = responder.team_id ";
		$sql .= "LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id=ticket.status_id ";
		// $sql.="LEFT JOIN ts_ticket__cdata AS tcdata ON tcdata.ticket_id = ticket.ticket_id ";
		$sql .= " LEFT JOIN ts_ticket__cdata AS tcdata  ON tcdata.ticket_id = responder.ticket_id ";
		if ($sec) {
			$sql .= "LEFT JOIN ts_team AS tteams ON tteams.team_id = ticket.team_id ";
		}
		/*$sql.="INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		   if($priority){
			  $sql.=" AND tcdata.priority ='".$priority."'";
		   }  */
		/*
		    if($priority){
			    $sql.="INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = responder.priority_id  ";
				$sql.=" AND tcdata.priority ='".$priority."'";
			   }else{
					$sql.="LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = responder.priority_id  ";
			   }  */

		$sql .= " LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = responder.priority_id  ";


		$sql .= " WHERE DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "'";

		if ($depart) {
			$sql .= " AND ticket.team_id='" . $depart . "' ";
			//$sql.=" AND responder.team_id='".$depart."' ";
		}
		if ($sec) {
			//$sql.=" AND teams.name LIKE '%".$sec."%'";  // AND tteams.name
			$sql .= " AND tteams.name LIKE '%" . $sec . "%'";
		}
		if ($intime_over_due != "") {
			$sql .= " AND ticket.isoverdue='" . $intime_over_due . "' ";
			//$sql.=" AND responder.is_overdue='".$intime_over_due."' ";

		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($priority) {
			//$sql.=" AND responder.priority_id ='".$priority."'";
			$sql .= " AND tcdata.priority  ='" . $priority . "'";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "'";  // AND responder.status = '1'
			// $sql.=" AND responder.status='".$status."'";
		}
		$sql .= " GROUP BY responder.id  ORDER BY responder.id DESC  ";
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		// echo $sql; 
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function callcenter_crm_detailed_report_18_3_16($startpoint, $per_page, $fdate, $tdate, $product, $priority, $status, $agent_id, $location, $natures, $intime_over_due, $depart, $sec, $frdate, $trdate, $complaint_id)
	{
		global $db_conn;
		global $db_prefix;
		//  echo $startpoint;
		// echo $per_page;
		$prefix = "ts";
		$sql = "SELECT SQL_CALC_FOUND_ROWS ticket.number,DATE_FORMAT(ticket.created, '%d-%m-%Y %h:%i:%s %p') AS   date_time,ticket.created,ticket.lastmessage,";
		$sql .= "DATE_FORMAT(ticket.duedate, '%d-%m-%Y %h:%i:%s %p') AS time_assigned,ticket.product,ticket.nature,ticket.others,";
		$sql .= "css_agent_owner.full_name as creater,css_agent.full_name,css_agent.location AS location,responder.poster AS firstname,depart.dept_name,staff.section,teams.name AS tdepart_name,tdepart.dept_name AS  old_depart,";
		$sql .= "DATE_FORMAT(responder.created , '%d-%m-%Y %h:%i:%s %p') AS response_datetime,responder.created AS response_time,responder.thread_type AS action_type,";
		$sql .= "(SELECT MAX(created) FROM ts_ticket_thread WHERE id < responder.id AND ticket_id = ticket.ticket_id) AS last_agent_response, ";
		$sql .= "tstatus.name,responder.status AS status_id,tpriority.priority_desc,responder.is_overdue isoverdue,ticket.updated AS close_date FROM ts_ticket AS ticket ";

		$sql .= " LEFT JOIN ts_ticket_thread AS responder ON responder.ticket_id = ticket.ticket_id AND responder.poster <> 'SYSTEM' ";


		$sql .= "INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		if ($frdate && $trdate) {
			$sql .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "' AND responder.thread_type <>'A') ";
		}
		$sql .= " INNER JOIN cc_admin AS css_agent_owner ON css_agent_owner.admin_id = ticket.who_created ";

		if ($agent_id) {
			$sql .= " AND ticket.who_created = '" . $agent_id . "'";
		}
		if ($complaint_id) {
			$sql .= " AND ticket.ticket_id='" . $complaint_id . "'";
		}

		if ($location) {
			$sql .= " AND css_agent.location = '" . $location . "' ";
		}
		/* $sql.=" LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		  if($sec){
				  $sql.=" AND staff.section ='".$sec."'";
			  } */
		/*if($sec){
			    $sql.="INNER JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
				  $sql.=" AND staff.section ='".$sec."'";
			  }else{
				$sql.="LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";  
			  }*/

		$sql .= "LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";

		$sql .= "LEFT JOIN ts_department AS depart ON depart.dept_id = staff.dept_id  ";
		$sql .= "LEFT JOIN ts_department AS tdepart ON tdepart.dept_id = ticket.dept_id  ";
		$sql .= "LEFT JOIN ts_team AS teams ON teams.team_id = ticket.team_id ";
		$sql .= "LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id=ticket.status_id ";
		$sql .= "LEFT JOIN ts_ticket__cdata AS tcdata ON tcdata.ticket_id = ticket.ticket_id ";
		/*$sql.="INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		   if($priority){
			  $sql.=" AND tcdata.priority ='".$priority."'";
		   }  */
		if ($priority) {
			$sql .= "INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
			$sql .= " AND tcdata.priority ='" . $priority . "'";
		} else {
			$sql .= "LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		}

		$sql .= " WHERE DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "'";
		if ($depart) {
			$sql .= " AND ticket.team_id='" . $depart . "' ";
		}
		if ($sec) {
			$sql .= " AND teams.name LIKE '%" . $sec . "%'";
		}
		if ($intime_over_due != "") {
			$sql .= " AND ticket.isoverdue='" . $intime_over_due . "' ";
		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "'";
		}
		$sql .= " GROUP BY responder.id  ORDER BY responder.created DESC  ";
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		//echo $sql; 
		$rs = $db_conn->Execute($sql);
		return $rs;
	}




	function callcenter_crm_report_18_3_16($startpoint, $per_page, $fdate, $tdate, $product, $priority, $status, $agent_id, $location, $natures, $intime_over_due, $depart, $sec, $frdate, $trdate, $complaint_id)
	{
		global $db_conn;
		global $db_prefix;
		//  echo $startpoint;
		// echo $per_page;
		$prefix = "ts";
		$sql = "SELECT SQL_CALC_FOUND_ROWS ticket.number,DATE_FORMAT(ticket.created, '%d-%m-%Y %h:%i:%s %p') AS   date_time,ticket.created,ticket.lastmessage,";
		$sql .= "DATE_FORMAT(ticket.duedate, '%d-%m-%Y %h:%i:%s %p') AS time_assigned,ticket.product,ticket.nature,ticket.others,";
		$sql .= "css_agent_owner.full_name as creater,css_agent.full_name,css_agent.location AS location,responder.poster AS firstname,depart.dept_name,staff.section,teams.name AS tdepart_name,";
		$sql .= "DATE_FORMAT(responder.created , '%d-%m-%Y %h:%i:%s %p') AS response_datetime,responder.created AS response_time,responder.thread_type AS action_type,";
		$sql .= "(SELECT MAX(created) FROM ts_ticket_thread WHERE id < responder.id AND ticket_id = ticket.ticket_id AND staff_id <>0) AS last_agent_response, ";
		$sql .= "tstatus.name,tstatus.id AS status_id,tpriority.priority_desc,ticket.isoverdue,ticket.updated AS close_date FROM ts_ticket AS ticket ";

		$sql .= " LEFT JOIN ts_ticket_thread AS responder  ON responder.id = (SELECT MAX(thread.id)  FROM ts_ticket_thread AS thread WHERE thread.ticket_id = ticket.ticket_id 
		  AND thread.poster <> 'SYSTEM' ORDER BY thread.id DESC LIMIT 1 )";


		// $sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		//$sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ticket.who_created ";  
		$sql .= "INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		if ($frdate && $trdate) {
			$sql .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "' AND responder.thread_type <>'A') ";
		}
		if ($agent_id) {
			$sql .= " AND ticket.who_created = '" . $agent_id . "'";
		}
		if ($complaint_id) {
			$sql .= " AND ticket.ticket_id='" . $complaint_id . "'";
		}

		if ($location) {
			$sql .= " AND css_agent.location = '" . $location . "' ";
		}

		// $sql.=" AND thread.staff_id <> 0 ORDER BY thread.id DESC LIMIT 1 ) AND responder.staff_id <> 0 ";
		//$sql.=" LEFT JOIN ts_ticket_thread AS responder ON responder.ticket_id = ticket.ticket_id  AND responder.poster <> 'SYSTEM'";

		//if($sec){
		//  $sql.="INNER JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		// $sql.=" AND staff.section ='".$sec."'";
		// }else{
		$sql .= "LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		//}
		$sql .= " LEFT JOIN ts_department AS depart ON depart.dept_id = staff.dept_id  ";
		$sql .= " LEFT JOIN ts_team AS teams ON teams.team_id = ticket.team_id  ";

		$sql .= "LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id=ticket.status_id ";
		$sql .= "LEFT JOIN ts_ticket__cdata AS tcdata ON tcdata.ticket_id = ticket.ticket_id ";


		if ($priority) {
			$sql .= "INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
			$sql .= " AND tcdata.priority ='" . $priority . "'";
		} else {
			$sql .= "LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		}
		$sql .= " INNER JOIN cc_admin AS css_agent_owner ON css_agent_owner.admin_id = ticket.who_created ";

		$sql .= " WHERE DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "'";

		if ($depart) {
			$sql .= " AND ticket.team_id='" . $depart . "' ";
		}
		if ($sec) {
			$sql .= " AND teams.name LIKE '%" . $sec . "%'";
		}
		if ($intime_over_due != "") {
			$sql .= " AND ticket.isoverdue='" . $intime_over_due . "' ";
		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "'";
		}
		$sql .= " GROUP BY ticket.ticket_id  ORDER BY ticket.created DESC  "; // ,responder.created 
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		//echo $sql; 
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function callcenter_crm_detailed_report_13_3_16($startpoint, $per_page, $fdate, $tdate, $product, $priority, $status, $agent_id, $location, $natures, $intime_over_due, $depart, $sec, $frdate, $trdate, $complaint_id)
	{
		global $db_conn;
		global $db_prefix;
		//  echo $startpoint;
		// echo $per_page;
		$prefix = "ts";
		$sql = "SELECT SQL_CALC_FOUND_ROWS ticket.number,DATE_FORMAT(ticket.created, '%d-%m-%Y %h:%i:%s %p') AS   date_time,ticket.created,ticket.lastmessage,";
		$sql .= "DATE_FORMAT(ticket.duedate, '%d-%m-%Y %h:%i:%s %p') AS time_assigned,ticket.product,ticket.nature,ticket.others,";
		$sql .= "css_agent.full_name,css_agent.location AS location,responder.poster AS firstname,depart.dept_name,staff.section,teams.name AS tdepart_name,tdepart.dept_name AS  old_depart,";
		$sql .= "DATE_FORMAT(responder.created , '%d-%m-%Y %h:%i:%s %p') AS response_datetime,responder.created AS response_time,responder.thread_type AS action_type,";
		$sql .= "(SELECT MAX(created) FROM ts_ticket_thread WHERE id < responder.id AND ticket_id = ticket.ticket_id) AS last_agent_response, ";
		$sql .= "tstatus.name,responder.status AS status_id,tpriority.priority_desc,responder.is_overdue isoverdue,ticket.updated AS close_date FROM ts_ticket AS ticket ";

		$sql .= " LEFT JOIN ts_ticket_thread AS responder ON responder.ticket_id = ticket.ticket_id AND responder.poster <> 'SYSTEM' ";

		//$sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ticket.who_created "; 
		$sql .= "INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		if ($frdate && $trdate) {
			$sql .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "' AND responder.thread_type <>'A') ";
		}
		if ($agent_id) {
			$sql .= " AND ticket.who_created = '" . $agent_id . "'";
		}
		if ($complaint_id) {
			$sql .= " AND ticket.ticket_id='" . $complaint_id . "'";
		}

		if ($location) {
			$sql .= " AND css_agent.location = '" . $location . "' ";
		}
		/* $sql.=" LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		  if($sec){
				  $sql.=" AND staff.section ='".$sec."'";
			  } */
		/*if($sec){
			    $sql.="INNER JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
				  $sql.=" AND staff.section ='".$sec."'";
			  }else{
				$sql.="LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";  
			  }*/

		$sql .= "LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";

		$sql .= "LEFT JOIN ts_department AS depart ON depart.dept_id = staff.dept_id  ";
		$sql .= "LEFT JOIN ts_department AS tdepart ON tdepart.dept_id = ticket.dept_id  ";
		$sql .= "LEFT JOIN ts_team AS teams ON teams.team_id = ticket.team_id ";
		$sql .= "LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id=ticket.status_id ";
		$sql .= "LEFT JOIN ts_ticket__cdata AS tcdata ON tcdata.ticket_id = ticket.ticket_id ";
		/*$sql.="INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		   if($priority){
			  $sql.=" AND tcdata.priority ='".$priority."'";
		   }  */
		if ($priority) {
			$sql .= "INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
			$sql .= " AND tcdata.priority ='" . $priority . "'";
		} else {
			$sql .= "LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		}

		$sql .= " WHERE DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "'";
		if ($depart) {
			$sql .= " AND ticket.team_id='" . $depart . "' ";
		}
		if ($sec) {
			$sql .= " AND teams.name LIKE '%" . $sec . "%'";
		}
		if ($intime_over_due != "") {
			$sql .= " AND ticket.isoverdue='" . $intime_over_due . "' ";
		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "'";
		}
		$sql .= " GROUP BY responder.id  ORDER BY responder.created DESC  ";
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function callcenter_crm_report_13_3_16($startpoint, $per_page, $fdate, $tdate, $product, $priority, $status, $agent_id, $location, $natures, $intime_over_due, $depart, $sec, $frdate, $trdate, $complaint_id)
	{
		global $db_conn;
		global $db_prefix;
		//  echo $startpoint;
		// echo $per_page;
		$prefix = "ts";
		$sql = "SELECT ticket.number,DATE_FORMAT(ticket.created, '%d-%m-%Y %h:%i:%s %p') AS   date_time,ticket.created,ticket.lastmessage,";
		$sql .= "DATE_FORMAT(ticket.duedate, '%d-%m-%Y %h:%i:%s %p') AS time_assigned,ticket.product,ticket.nature,ticket.others,";
		$sql .= "css_agent.full_name,css_agent.location AS location,responder.poster AS firstname,depart.dept_name,staff.section,teams.name AS tdepart_name,";
		$sql .= "DATE_FORMAT(responder.created , '%d-%m-%Y %h:%i:%s %p') AS response_datetime,responder.created AS response_time,responder.thread_type AS action_type,";
		$sql .= "(SELECT MAX(created) FROM ts_ticket_thread WHERE id < responder.id AND ticket_id = ticket.ticket_id AND staff_id <>0) AS last_agent_response, ";
		$sql .= "tstatus.name,tstatus.id AS status_id,tpriority.priority_desc,ticket.isoverdue,ticket.updated AS close_date FROM ts_ticket AS ticket ";

		$sql .= " LEFT JOIN ts_ticket_thread AS responder  ON responder.id = (SELECT MAX(thread.id)  FROM ts_ticket_thread AS thread WHERE thread.ticket_id = ticket.ticket_id 
		  AND thread.poster <> 'SYSTEM' ORDER BY thread.id DESC LIMIT 1 )";


		// $sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		//$sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ticket.who_created ";  
		$sql .= "INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
		if ($frdate && $trdate) {
			$sql .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "' AND responder.thread_type <>'A') ";
		}
		if ($agent_id) {
			$sql .= " AND ticket.who_created = '" . $agent_id . "'";
		}
		if ($complaint_id) {
			$sql .= " AND ticket.ticket_id='" . $complaint_id . "'";
		}

		if ($location) {
			$sql .= " AND css_agent.location = '" . $location . "' ";
		}

		// $sql.=" AND thread.staff_id <> 0 ORDER BY thread.id DESC LIMIT 1 ) AND responder.staff_id <> 0 ";
		//$sql.=" LEFT JOIN ts_ticket_thread AS responder ON responder.ticket_id = ticket.ticket_id  AND responder.poster <> 'SYSTEM'";

		//if($sec){
		//  $sql.="INNER JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		// $sql.=" AND staff.section ='".$sec."'";
		// }else{
		$sql .= "LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
		//}
		$sql .= " LEFT JOIN ts_department AS depart ON depart.dept_id = staff.dept_id  ";
		$sql .= " LEFT JOIN ts_team AS teams ON teams.team_id = ticket.team_id  ";

		$sql .= "LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id=ticket.status_id ";
		$sql .= "LEFT JOIN ts_ticket__cdata AS tcdata ON tcdata.ticket_id = ticket.ticket_id ";


		if ($priority) {
			$sql .= "INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
			$sql .= " AND tcdata.priority ='" . $priority . "'";
		} else {
			$sql .= "LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
		}
		$sql .= " WHERE DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "'";

		if ($depart) {
			$sql .= " AND ticket.team_id='" . $depart . "' ";
		}
		if ($sec) {
			$sql .= " AND teams.name LIKE '%" . $sec . "%'";
		}
		if ($intime_over_due != "") {
			$sql .= " AND ticket.isoverdue='" . $intime_over_due . "' ";
		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "'";
		}
		$sql .= " GROUP BY ticket.ticket_id  ORDER BY ticket.created DESC  "; // ,responder.created 
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		// echo $sql; 
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function recursive_product_make_tree($parent_id)
	{
		global $db_conn;
		global $db_prefix;
		//global $html; 

		$sql   = "SELECT * FROM " . $db_prefix . "_products WHERE parent_id = '" . $parent_id . "' ";
		$sql  .= " AND  status='1' ";
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	// hbm for export functionality
	function getCurrentAgentCalls($agent_id, $type)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT stats.caller_id, stats.call_datetime, users.id client_id, users.name client_name, ticket.ticket_id,ticket.number,
	 GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes FROM cc_queue_stats stats ";
		$sql .= " LEFT JOIN ts_user users ON users.phone = stats.caller_id 
	       LEFT JOIN ts_ticket ticket ON stats.id = ticket.unique_id
           AND DATE(ticket.created) = DATE(NOW())
           AND HOUR(ticket.created) = HOUR(stats.call_datetime) 
		   LEFT JOIN cc_vu_workcodes AS t1 ON t1.unique_id = stats.unique_id 
     AND DATE(t1.staff_updated_date) = DATE(stats.call_datetime) ";
		$sql .= " WHERE stats.staff_id = '" . $agent_id . "' AND DATE(stats.call_datetime) = DATE(NOW()) AND t1.staff_id = '" . $agent_id . "' ";
		$sql .= "AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) > '00:00:00' AND stats.status = 0 AND stats.call_type= '" . $type . "' GROUP BY stats.unique_id ";
		//$sql .= " AND stats.status = 0 AND stats.call_type= '" . $type . "' GROUP BY stats.unique_id ";

		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function getCurrentAgentAbandonedCalls($agent_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT distinct unique_id,caller_id,update_datetime FROM  cc_abandon_calls ";
		$sql .= " WHERE staff_id = '" . $agent_id . "' AND DATE(update_datetime) = DATE(NOW()) GROUP BY unique_id ";
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}

	function getCurrentAgentDropCalls($agent_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT distinct unique_id,caller_id,update_datetime FROM  cc_abandon_calls ";
		$sql .= " WHERE staff_id = '" . $agent_id . "' AND DATE(update_datetime) = DATE(NOW()) GROUP BY unique_id ";
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}

	function getofftimecalls($fdate, $tdate)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT caller_id,
							call_status,
							DATE_FORMAT(update_datetime,'%Y-%m-%e %H:%i:%s') AS call_date
							FROM cc_queue_stats WHERE
							DATE_FORMAT(update_datetime, '%Y-%m-%e %H:%i:%s') 
							Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s')
							AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s')
							AND call_status = 'OFFTIME'";
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function getrobocalls($fdate, $tdate)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT caller_id, response,k_response,order_status, DATE_FORMAT(update_datetime,'%b %d %Y %h:%i %p') AS update_datetime FROM outsource ";
		//        $sql .=" WHERE DATE(update_datetime) BETWEEN '".$fdate."' AND '".$tdate."' ";
		$sql .= " WHERE  DATE_FORMAT(update_datetime,'%d-%m-%Y') BETWEEN '" . $fdate . "' AND '" . $tdate . "' ";

		//echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function getAgentsTickets($agent_id, $fdate, $tdate, $status = '1', $frdate, $trdate)
	{
		global $db_conn;
		global $db_prefix;
		$select = ' SELECT
		ticket.ticket_id,
		ticket.`number`,
		ticket.dept_id,
		ticket.staff_id,
		ticket.team_id,
		initiator.full_name,
		ticket.user_id,
		dept.dept_name,
		tstatus.name AS STATUS,
		ticket.source,
		ticket.isoverdue,
		ticket.isanswered,
		ticket.duedate,
		ticket.created,
		CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.reopened, 0), ticket.created) AS DATETIME) AS effective_date,
		CONCAT_WS(" ", staff.firstname, staff.lastname) AS staff,
		team.name         AS team,
		IF(staff.staff_id IS NULL,team.name,CONCAT_WS(" ", staff.lastname, staff.firstname)) AS assigned,
		IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(" / ", ptopic.topic, topic.topic)) AS helptopic,
		cdata.priority    AS priority_id,
		cdata.subject,
		tuser.name,
		email.address     AS email';

		$from = ' FROM ts_ticket AS ticket
		LEFT JOIN ts_ticket_status tstatus
			ON tstatus.id = ticket.status_id
		LEFT JOIN ts_user tuser
			ON tuser.id = ticket.user_id
		LEFT JOIN  cc_admin  initiator 
		ON initiator.admin_id = ticket.who_created 
		LEFT JOIN ts_user_email email
			ON tuser.id = email.user_id
		LEFT JOIN ts_user_account account
			ON (ticket.user_id = account.user_id)
		LEFT JOIN ts_department dept
			ON ticket.dept_id = dept.dept_id
		LEFT JOIN ts_staff staff
			ON (ticket.staff_id = staff.staff_id)
		LEFT JOIN ts_team team
			ON (ticket.team_id = team.team_id)
		LEFT JOIN ts_help_topic topic
			ON (ticket.topic_id = topic.topic_id)
		LEFT JOIN ts_help_topic ptopic
			ON (ptopic.topic_id = topic.topic_pid)
		LEFT JOIN ts_ticket__cdata cdata
			ON (cdata.ticket_id = ticket.ticket_id)
		LEFT JOIN ts_ticket_priority pri
			ON (pri.priority_id = cdata.priority)
		LEFT JOIN ts_ticket_thread responder ON  ticket.ticket_id = responder.ticket_id';

		if ($agent_id) {
			$where = 'WHERE ticket.who_created = ' . $agent_id;
			if ($fdate) {
				$where .= " AND DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "' AND ticket.status_id='" . $status . "'";
			}
			if ($frdate) {
				$where .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "'
                  AND (responder.thread_type <> 'A' OR  responder.thread_type <> 'E') AND responder.poster <> 'SYSTEM') ";
			}
			$query = "$select $from $where ORDER BY ticket.created DESC ";
		} else {
			if ($fdate)
				$where .= " where DATE(ticket.created) BETWEEN '" . $fdate . "' AND '" . $tdate . "' AND ticket.status_id ='" . $status . "'";
			if ($frdate) {
				$where .= " AND (DATE(responder.created) BETWEEN '" . $frdate . "' AND '" . $trdate . "'
                  AND (responder.thread_type <> 'A' OR  responder.thread_type <> 'E') AND responder.poster <> 'SYSTEM') ";
			}
			$query = "$select $from $where GROUP BY ticket.ticket_id ORDER BY ticket.created DESC ";
		}

		//echo $query;
		$rs = $db_conn->Execute($query);
		return $rs;
	}

	function get_agent_summary_vu($agent_id, $date)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT * FROM cc_vu_call_summary WHERE DATE(update_datetime) = '" . $date . "'";
		if ($agent_id) {
			$sql .= " AND admin_id = '" . $agent_id . "'";
		}
		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	// blow methods are to show call_detialed_report 14_3_16
	function get_agent_detailed_report($agent_id, $fdate, $tdate, $startpoint, $per_page)
	{
		global $db_conn;
		global $db_prefix;

		$sql = "SELECT SQL_CALC_FOUND_ROWS staff_id,login_datetime,logout_datetime,DATE(login_datetime) AS  update_datetime FROM cc_login_activity AS login_activety";
		$sql .= " WHERE 1=1 AND DATE(login_activety.login_datetime)  BETWEEN '" . $fdate . "' AND '" . $tdate . "'";
		//$sql.=" AND (stats.staff_id IS NOT NULL) AND (stats.staff_id <> '0')";
		if ($agent_id) {
			$sql .= " AND login_activety.staff_id='" . $agent_id . "'";
		}
		$sql .= " GROUP BY login_datetime,staff_id ORDER BY login_datetime DESC";
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}

	function get_agent_in_detailed($agent_id, $fdatetime, $tdatetime)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT COUNT(stats.unique_id) AS inbound_call_no, 
                    SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS inbound_call_duration,
                    SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF( stats.update_datetime,stats.staff_end_datetime)))) AS inbound_busy_duration ";
		$sql .= " FROM cc_queue_stats AS stats 
                    WHERE stats.update_datetime BETWEEN '" . $fdatetime . "' AND '" . $tdatetime . "'  
                    AND stats.call_type = 'INBOUND' AND (stats.call_status = 'ANSWERED' OR stats.call_status = 'TRANSFER') AND stats.staff_id = '" . $agent_id . "'";
		// AND (stats.staff_id IS NOT NULL) AND  (stats.staff_id <>'0')

		//  $sql.=" GROUP BY stats.call_type";
		// AND stats.call_status = 'ANSWERED'
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}
	function get_agent_ob_detailed($agent_id, $fdatetime, $tdatetime)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT 
                    COUNT( DISTINCT stats.id) AS outbound_call_no, 
                    SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS outbound_call_duration,
                    SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(stats.update_datetime,stats.staff_end_datetime)))) AS outbound_busy_duration,
                    COUNT(DISTINCT abandoned.id) AS abandon_calls ";
		$sql .= " FROM cc_queue_stats AS stats 
                        LEFT JOIN cc_abandon_calls AS abandoned ON stats.staff_id = abandoned.staff_id
                     AND DATE(abandoned.update_datetime) = DATE(stats.update_datetime)
                     WHERE stats.update_datetime BETWEEN '" . $fdatetime . "' AND '" . $tdatetime . "'  
					
                    AND stats.call_type = 'OUTBOUND' AND (stats.call_status = 'ANSWERED' OR stats.call_status = 'TRANSFER')  AND (stats.staff_id IS NOT NULL) AND  (stats.staff_id <>'0')
                    AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) > '00:00:00'
					AND stats.staff_id = '" . $agent_id . "'
                    ";  //GROUP BY stats.call_type
		$rs = $db_conn->Execute($sql);
		// echo $sql;
		return $rs;
	}
	function get_agent_login_detailed($agent_id, $fdatetime, $tdatetime)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(logout_datetime,login_datetime)))) AS login_duration, 
                    TIME_FORMAT(TIME(MIN(login_datetime)), '%h:%i:%s %p') AS login_time, 
                    TIME_FORMAT(TIME(MAX(logout_datetime)), '%h:%i:%s %p') AS logout_time ";
		$sql .= " FROM cc_login_activity AS login_activety
                        WHERE login_activety.staff_id='" . $agent_id . "' 
                        AND login_activety.login_datetime ='" . $fdatetime . "' 
                        AND login_activety.logout_datetime ='" . $tdatetime . "'";
		$rs = $db_conn->Execute($sql);
		// echo $sql;
		return $rs;
	}
	function get_agent_break_assign_detailed($agent_id, $fdatetime, $tdatetime)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(break.end_datetime,break.start_datetime)))) AS break_time,
                    (SELECT SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(assignment.end_datetime, assignment.start_datetime))))
                    FROM cc_crm_activity AS assignment 
                    WHERE assignment.staff_id=break.staff_id
                    AND assignment.status = 6 AND DATE(assignment.update_datetime) = DATE(break.update_datetime)) AS assignment_time  ";
		$sql .= " FROM cc_crm_activity AS break 
                          WHERE break.staff_id='" . $agent_id . "'
                          AND break.status <> '6' 
                          AND break.status <> '1' 
                          AND  break.update_datetime BETWEEN '" . $fdatetime . "' AND '" . $tdatetime . "' ";
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}
	function get_agent_drop_detailed($agent_id, $fdatetime, $tdatetime)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT full_name, department,is_crm_login, COUNT(DISTINCT stats.unique_id) AS droped_calls ";
		$sql .= " FROM cc_admin AS admin
                            LEFT JOIN cc_queue_stats AS stats
                              ON admin.admin_id = stats.staff_id
                                AND stats.call_status = 'DROP'  AND stats.call_type = 'INBOUND'
                                AND stats.update_datetime BETWEEN '" . $fdatetime . "' AND '" . $tdatetime . "'
                          WHERE admin.admin_id = '" . $agent_id . "'";
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}
	function get_agent_abandoned_detialed($agent_id, $fdatetime, $tdatetime)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT COUNT(DISTINCT abandoned.id) AS abandon_calls  ";
		$sql .= " FROM  cc_abandon_calls AS abandoned,cc_queue_stats 
					        WHERE abandoned.update_datetime BETWEEN '" . $fdatetime . "' AND '" . $tdatetime . "'
							AND abandoned.unique_id = cc_queue_stats.unique_id
							AND cc_queue_stats.call_type = 'INBOUND' 							
                            AND abandoned.staff_id = '" . $agent_id . "'";
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}
	//   call_detialed_report methods end   

	// 1
	function get_agent_summary($agent_id, $fdate, $tdate, $startpoint, $per_page)
	{
		global $db_conn;
		global $db_prefix;

		$sql = "SELECT  SQL_CALC_FOUND_ROWS  staff_id,DATE(login_datetime) AS  update_datetime FROM cc_login_activity AS login_activety";
		// $sql .= " WHERE 1=1 AND DATE(login_activety.login_datetime)  BETWEEN '" . $fdate . "' AND '" . $tdate . "'";
		$sql .= " WHERE 1=1 AND DATE(login_activety.login_datetime)  BETWEEN '" . $fdate . "' AND '" . $tdate . "'";
		//$sql.=" AND (stats.staff_id IS NOT NULL) AND (stats.staff_id <> '0')";
		if ($agent_id) {
			$sql .= " AND login_activety.staff_id='" . $agent_id . "'";
		}
		$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9036' AND staff_id <> '9035' ";
		$sql .= " GROUP BY DATE(login_datetime),staff_id ";
		if ($per_page) {
			//$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}

	function get_agent_summary_13_3_16($agent_id, $fdate, $tdate, $startpoint, $per_page)
	{
		global $db_conn;
		global $db_prefix;

		$sql = "SELECT staff_id,DATE(login_datetime) AS  update_datetime FROM cc_login_activity AS login_activety";
		$sql .= " WHERE 1=1 AND DATE(login_activety.login_datetime)  BETWEEN '" . $fdate . "' AND '" . $tdate . "'";
		//$sql.=" AND (stats.staff_id IS NOT NULL) AND (stats.staff_id <> '0')";
		if ($agent_id) {
			$sql .= " AND login_activety.staff_id='" . $agent_id . "'";
		}
		$sql .= " AND staff_id <> '9030' AND staff_id <> '9039' AND staff_id <> '9036' ";
		$sql .= " GROUP BY DATE(login_datetime),staff_id ";
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}
	/*function get_agent_summary($agent_id,$fdate,$tdate,$startpoint,$per_page){
	  global $db_conn; global $db_prefix;
	  
  $sql ="SELECT stats.staff_id,DATE(stats.update_datetime) update_datetime FROM cc_queue_stats AS stats";
  $sql.=" WHERE DATE(stats.update_datetime)  BETWEEN '".$fdate."' AND '".$tdate."'";
  $sql.=" AND (stats.staff_id IS NOT NULL) AND (stats.staff_id <> '0')";
	if($agent_id){
      $sql.=" AND stats.staff_id='".$agent_id."'"; 
     } 
  $sql.=" GROUP BY stats.staff_id,DATE(stats.update_datetime) ";
  if($per_page){
	  $sql.=" LIMIT {$startpoint},{$per_page} ";
	 }
  $rs = $db_conn->Execute($sql);
      echo $sql;
      return $rs; 	 
}*/
	function get_agent_in_summary($agent_id, $date)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT COUNT(stats.unique_id) AS inbound_call_no, 
                    SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS inbound_call_duration,
                    SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF( stats.call_datetime,stats.staff_end_datetime)))) AS inbound_busy_duration ";
		$sql .= " FROM cc_queue_stats AS stats 
                    WHERE  DATE(stats.call_datetime) = '" . $date . "' 
                    AND stats.call_type = 'INBOUND' AND (stats.call_status = 'ANSWERED' OR stats.call_status = 'TRANSFER') AND stats.staff_id = '" . $agent_id . "'";
		// AND (stats.staff_id IS NOT NULL) AND  (stats.staff_id <>'0')

		$sql .= " GROUP BY stats.call_type";
		// AND stats.call_status = 'ANSWERED'
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}

	// 2
	function get_agent_ob_summary($agent_id, $date)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT 
                    COUNT( DISTINCT stats.id) AS outbound_call_no, 
                    SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS outbound_call_duration,
                    SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(stats.call_datetime,stats.staff_end_datetime)))) AS outbound_busy_duration,
                    COUNT(DISTINCT abandoned.id) AS abandon_calls ";
		$sql .= " FROM cc_queue_stats AS stats 
                        LEFT JOIN cc_abandon_calls AS abandoned ON stats.staff_id = abandoned.staff_id
                     AND DATE(abandoned.update_datetime) = DATE(stats.call_datetime)
                    WHERE  DATE(stats.call_datetime) = '" . $date . "' 
					
                    AND stats.call_type = 'OUTBOUND' AND (stats.call_status = 'ANSWERED' OR stats.call_status = 'TRANSFER')  AND (stats.staff_id IS NOT NULL) AND  (stats.staff_id <>'0')
                    AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) > '00:00:00'
					AND stats.staff_id = '" . $agent_id . "'
                    GROUP BY stats.call_type";
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}
	// 3 
	function get_agent_login_summary($agent_id, $date)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(logout_datetime,login_datetime)))) AS login_duration, 
                    TIME_FORMAT(TIME(MIN(login_datetime)), '%H:%i:%s ') AS login_time, 
                    TIME_FORMAT(TIME(MAX(logout_datetime)), '%H:%i:%s ') AS logout_time ";
		$sql .= " FROM cc_login_activity AS login_activety
                        WHERE login_activety.staff_id='" . $agent_id . "' 
                        AND DATE(login_activety.login_datetime)='" . $date . "' 
                        AND DATE(login_activety.logout_datetime)='" . $date . "'";
		$rs = $db_conn->Execute($sql);
		// echo $sql;
		return $rs;
	}
	// 4
	function get_agent_break_assign_summary($agent_id, $date)
	{
		global $db_conn;
		global $db_prefix;
		/* $sql =" SELECT SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(break.end_datetime,break.start_datetime)))) AS break_time,
                    (SELECT SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(assignment.end_datetime, assignment.start_datetime))))
                    FROM cc_crm_activity AS assignment 
                    WHERE assignment.staff_id= break.staff_id
                    AND assignment.status = 6 AND DATE(assignment.update_datetime) = DATE(break.update_datetime)) AS assignment_time  "; 
                    $sql.=" FROM cc_crm_activity AS break 
                          WHERE break.staff_id='".$agent_id."'
                          AND break.status <> '6' 
                          AND break.status <> '1' 
                          AND DATE(break.update_datetime) = '".$date."'";  */
		$sql = " SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(break.end_datetime,break.start_datetime)))) AS break_time,
                    (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(assignment.end_datetime, assignment.start_datetime))))
                    FROM cc_crm_activity AS assignment 
                    WHERE assignment.staff_id= break.staff_id
                    AND assignment.status = 6 AND DATE(assignment.update_datetime) = DATE(break.update_datetime)) AS assignment_time  ";
		$sql .= " FROM cc_crm_activity AS break 
                          WHERE break.staff_id='" . $agent_id . "'
                          AND break.status <> '6' 
                          AND break.status <> '1' 
                          AND DATE(break.update_datetime) = '" . $date . "'";
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}

	// 5
	function get_agent_drop_summary($agent_id, $date)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT full_name, department,is_crm_login, COUNT(DISTINCT stats.unique_id) AS droped_calls ";
		$sql .= " FROM cc_admin AS admin
                            LEFT JOIN cc_queue_stats AS stats
                              ON admin.admin_id = stats.staff_id
                                AND stats.call_status = 'DROP'
                                AND DATE(stats.call_datetime) = '" . $date . "'
                          WHERE admin.admin_id = '" . $agent_id . "'";
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}
	function get_agent_abandoned_summary($agent_id, $date)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT COUNT(DISTINCT id) AS abandon_calls  ";
		$sql .= " FROM  cc_abandon_calls WHERE DATE(update_datetime) = '" . $date . "'
                            AND abandoned.staff_id = '" . $agent_id . "'";
		$rs = $db_conn->Execute($sql);
		//echo $sql;
		return $rs;
	}
	function agent_summary_log_activity($agent_id, $date)
	{
		global $db_conn;
		global $db_prefix;

		$sql = " SELECT SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(break.end_datetime,break.start_datetime)))) AS break_time, 
            SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(assignment.end_datetime, assignment.start_datetime)))) AS assignment_time, 
            SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(logout_datetime,login_datetime)))) AS login_duration, 
            TIME_FORMAT(TIME(MIN(login_datetime)), '%h:%i:%s %p') AS login_time,
            TIME_FORMAT(TIME(MAX(logout_datetime)), '%h:%i:%s %p') AS logout_time ";

		$sql .= " FROM cc_admin AS admin LEFT JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id 
           AND DATE(stats.update_datetime) = '" . $date . "' AND stats.call_type = 'INBOUND' 
           AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) <> '00:00:00' ";

		$sql .= "LEFT JOIN cc_crm_activity AS break ON admin.admin_id = break.staff_id  AND break.status <> '6' AND break.status <> '1' 
        AND DATE(break.update_datetime) = '" . $date . "'
        LEFT JOIN cc_crm_activity AS assignment ON admin.admin_id = assignment.staff_id  AND assignment.status = 6 
        AND DATE(assignment.update_datetime) = '" . $date . "' ";

		$sql .= "LEFT JOIN cc_login_activity AS login_activety ON admin.admin_id = login_activety.staff_id 
        AND DATE(login_activety.login_datetime)='" . $date . "' 
        AND DATE(login_activety.logout_datetime)='" . $date . "'";
		if ($agent_id) {
			$sql .= " WHERE admin.admin_id = '" . $agent_id . "'";
		}

		$sql .= "GROUP BY admin.admin_id";
		//echo $sql;
		//$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function agent_summary_in_outbound_calls($agent_id, $date)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT admin_id,full_name,COUNT( DISTINCT stats.id) AS inbound_call_no,
SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS inbound_call_duration,
SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF( stats.update_datetime,stats.staff_end_datetime)))) AS inbound_busy_duration, 
COUNT(DISTINCT stats2.id) AS outbound_call_no, 
SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats2.staff_end_datetime,stats2.staff_start_datetime)))) AS outbound_call_duration, 
SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats2.update_datetime,stats2.staff_end_datetime)))) AS outbound_busy_duration, 
COUNT(DISTINCT abandoned.id) AS abandon_calls, COUNT(DISTINCT stats3.call_status) AS droped_calls,department ";

		$sql .= " FROM cc_admin AS admin LEFT JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id 
           AND DATE(stats.update_datetime) = '" . $date . "' AND stats.call_type = 'INBOUND' 
           AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) <> '00:00:00' ";
		$sql .= "LEFT JOIN cc_queue_stats AS stats2 ON admin.admin_id = stats2.staff_id 
        AND DATE(stats2.update_datetime) = '" . $date . "' AND stats2.call_type = 'OUTBOUND' 
        LEFT JOIN cc_queue_stats AS stats3 ON admin.admin_id = stats3.staff_id 
        AND DATE(stats3.update_datetime) = '" . $date . "'
        AND stats3.call_status = 'DROP' 
        LEFT JOIN cc_abandon_calls AS abandoned ON admin.admin_id = abandoned.staff_id 
        AND DATE(abandoned.update_datetime) = '" . $date . "'";
		if ($agent_id) {
			$sql .= " WHERE admin.admin_id = '" . $agent_id . "'";
		}

		$sql .= "GROUP BY admin.admin_id,stats.call_type,stats2.call_type,stats3.call_status";
		//echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function getworkcodes()
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT wc_title,wc_title AS title_value  FROM cc_workcodes_new ORDER BY wc_title ASC";
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function hourly_summarm_hbm_old($fdate, $tdate, $starthour, $endhour)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT COUNT(id) AS calls_count, 
  CONCAT(HOUR(call_datetime),':00 - ',HOUR(call_datetime),':59') time_slots, 
  HOUR(call_datetime) hourly, 
  MONTHNAME(call_datetime) AS month_name 
  FROM cc_queue_stats  
  WHERE DATE(call_datetime) BETWEEN '" . $fdate . "' AND '" . $tdate . "'
  AND  TIME(call_datetime)BETWEEN TIME('" . $starthour . "') AND TIME('" . $endhour . "')
   GROUP BY hourly";
		echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function hourly_summarm_hbm($fdate, $tdate, $starthour, $endhour)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT COUNT(id) AS calls_count,
            CONCAT(HOUR(call_datetime),':00 - ',HOUR(call_datetime),':59')    time_slots,
            HOUR(call_datetime)    hourly,";
		$sql .= " (SELECT
     COUNT(id)
   FROM cc_queue_stats WHERE call_type = 'INBOUND' AND call_status = 'ANSWERED'
       AND DATE(call_datetime) BETWEEN '" . $fdate . "' AND '" . $tdate . "'
       AND TIME(call_datetime) BETWEEN TIME('" . $starthour . "') AND TIME('" . $endhour . "')) AS inbound,";
		$sql .= " (SELECT
     COUNT(id)
   FROM cc_queue_stats WHERE call_type = 'OUTBOUND' AND call_status = 'ANSWERED'
       AND DATE(call_datetime) BETWEEN '" . $fdate . "' AND '" . $tdate . "'
       AND TIME(call_datetime) BETWEEN TIME('" . $starthour . "') AND TIME('" . $endhour . "')) AS outbound,";
		$sql .= " MONTHNAME(call_datetime) AS month_name 
      FROM cc_queue_stats  
      WHERE DATE(call_datetime) BETWEEN '" . $fdate . "' AND '" . $tdate . "'
      AND  TIME(call_datetime)  BETWEEN TIME('" . $starthour . "') AND TIME('" . $endhour . "')
      GROUP BY hourly ";
		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function hourly_ratio_summary($fdate, $tdate, $hour)
	{
		global $db_conn;
		global $db_prefix;

		$sql = " SELECT
                    COUNT(id) AS calls_count,
                    CONCAT(HOUR(call_time),':00 - ',HOUR(call_time),':59') time_slots, 
                    HOUR(call_time) hourly, 
                    MONTHNAME(update_datetime) AS month_name";
		$sql .= " FROM cc_vu_queue_stats ";
		$sql .= " WHERE DATE(update_datetime) BETWEEN  '" . $fdate . "' and '" . $tdate . "' ";
		/*$sql .= " WHERE (MONTH(update_datetime) = '".$month."'
                AND YEAR(update_datetime) = '".$year."')";*/
		/*$sql .= " AND  (TIME(call_time)BETWEEN TIME('00:00:00') AND TIME('00:59:00')
         OR TIME(call_time) BETWEEN TIME('01:00:00') AND TIME('01:59:00') 
         OR TIME(call_time) BETWEEN TIME('03:00:00') AND TIME('03:59:00')
         OR TIME(call_time) BETWEEN TIME('04:00:00') AND TIME('04:59:00')
         OR TIME(call_time) BETWEEN TIME('05:00:00') AND TIME('05:59:00')
         OR TIME(call_time) BETWEEN TIME('06:00:00') AND TIME('06:59:00')
         OR TIME(call_time) BETWEEN TIME('07:00:00') AND TIME('07:59:00')
         OR TIME(call_time) BETWEEN TIME('08:00:00') AND TIME('08:59:00')
         OR TIME(call_time) BETWEEN TIME('09:00:00') AND TIME('09:59:00')
         OR TIME(call_time) BETWEEN TIME('10:00:00') AND TIME('10:59:00')
         OR TIME(call_time) BETWEEN TIME('11:00:00') AND TIME('11:59:00')
         OR TIME(call_time) BETWEEN TIME('12:00:00') AND TIME('12:59:00')
         OR TIME(call_time) BETWEEN TIME('13:00:00') AND TIME('13:59:00')
         OR TIME(call_time) BETWEEN TIME('14:00:00') AND TIME('14:59:00')
         OR TIME(call_time) BETWEEN TIME('15:00:00') AND TIME('15:59:00')
         OR TIME(call_time) BETWEEN TIME('16:00:00') AND TIME('16:59:00')
         OR TIME(call_time) BETWEEN TIME('17:00:00') AND TIME('17:59:00')
         OR TIME(call_time) BETWEEN TIME('18:00:00') AND TIME('18:59:00')
         OR TIME(call_time) BETWEEN TIME('19:00:00') AND TIME('19:59:00')
         OR TIME(call_time) BETWEEN TIME('20:00:00') AND TIME('20:59:00')
         OR TIME(call_time) BETWEEN TIME('21:00:00') AND TIME('21:59:00')
         OR TIME(call_time) BETWEEN TIME('22:00:00') AND TIME('22:59:00')
         OR TIME(call_time) BETWEEN TIME('23:00:00') AND TIME('23:59:00') ) ";*/
		$sql .= " GROUP BY hourly";
		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function work_code_summary($fromdate, $todate, $workcode = "")
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT  GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes, COUNT( DISTINCT t2.unique_id) AS inbound, COUNT( DISTINCT t3.unique_id) AS outbound,
                t1.staff_updated_date,t2.update_datetime FROM cc_vu_workcodes AS t1 ";

		$sql .= " LEFT JOIN     
              cc_queue_stats AS t2 ON t1.unique_id = t2.unique_id
               AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime)
               AND t2.call_type ='INBOUND' ";

		$sql .= " LEFT JOIN     
              cc_queue_stats AS t3 ON t1.unique_id = t3.unique_id
            AND DATE(t1.staff_updated_date) = DATE(t3.update_datetime)
            AND t3.call_type ='OUTBOUND' ";

		$sql .= " WHERE 1 = 1  AND DATE(t1.staff_updated_date) BETWEEN '" . $fromdate . "' AND  '" . $todate . "'";

		if ($workcode) {
			$sql .= " AND t1.workcodes LIKE ' " . $workcode . "%' ";
		}

		$sql .= " GROUP BY workcodes ORDER BY workcodes ";
		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function get_call_unique_id($agent_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT stats.id as unique_id FROM cc_admin INNER JOIN cc_queue_stats stats ON stats.staff_id = admin_id ";
		$sql .= " WHERE admin_id ='" . $agent_id . "' AND (is_busy=3 OR is_busy=1) ORDER BY stats.id DESC LIMIT 1 ";

		//$sql ="SELECT unique_id FROM cc_admin WHERE admin_id ='".$agent_id."' AND (is_busy=3 OR is_busy=1)  LIMIT 1";
		/*$sql = "SELECT unique_id FROM cc_queue_stats  AS stats WHERE ";
    	$sql .=" staff_id = '".$agent_id."' AND stats.status='3' ORDER BY id DESC LIMIT 1"; */
		//echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function inbound_call_report($startpoint, $per_page, $agent_id, $fromdate, $todate, $compalaint_id, $workcodes, $product, $natures, $status)
	{
		//echo $startpoint.':'.$per_page.':'.$agent_id.':'.$fromdate.':'.$todate.':'.$compalaint_id.':'.$workcodes.':'.$product.':'.$natures.':'.$status;
		//die;
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT SQL_CALC_FOUND_ROWS admin_id,full_name,DATE(stats.update_datetime) AS call_date,TIME(stats.call_datetime) AS TIME ,";
		$sql .= " SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS inbound_call_duration, ";
		$sql .= " SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF( stats.dequeue_datetime,stats.enqueue_datetime)))) AS wait_in_queue, ";
		$sql .= " stats.caller_id AS caller_id,stats.unique_id AS call_id,stats.call_status,department,users.cmid,users.uin,ticket.product,ticket.nature,ticket.others,ticket.number,ticket_data.subject,teams.name AS dept_name,tstatus.name,t1.detail AS remarks,GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes  ";
		$sql .= " FROM cc_admin AS admin";

		$sql .= " INNER JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id 
    	         AND DATE(stats.update_datetime) BETWEEN '" . $fromdate . "' AND  '" . $todate . "'
				 AND stats.call_type = 'INBOUND'
                 AND (stats.call_status = 'ANSWERED' OR stats.call_status = 'TRANSFER') ";

		//$sql .=" LEFT JOIN cc_vu_workcodes  AS t1 ON stats.unique_id = t1.unique_id  AND stats.staff_id = t1.staff_id";
		if ($workcodes) {
			$sql .= " INNER JOIN cc_vu_workcodes  AS t1 ON stats.unique_id = t1.unique_id  AND stats.staff_id = t1.staff_id";
			$sql .= " AND t1.workcodes LIKE '%" . $workcodes . "%' ";
		} else {
			$sql .= " LEFT JOIN cc_vu_workcodes  AS t1 ON stats.unique_id = t1.unique_id  AND stats.staff_id = t1.staff_id";
		}

		if ($compalaint_id || $product || $natures || $status) {
			$sql .= " INNER JOIN ts_ticket AS ticket ON stats.id = ticket.unique_id";
		} else {
			$sql .= " LEFT JOIN ts_ticket AS ticket ON stats.id = ticket.unique_id";
		}
		$sql .= " AND stats.staff_id =ticket.who_created ";
		if ($compalaint_id) {
			$sql .= " AND ticket.ticket_id='" . trim((int)$compalaint_id) . "' ";
		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "' ";
		}
		$sql .= " LEFT JOIN ts_user AS users ON ticket.user_id = users.id ";

		$sql .= " LEFT JOIN ts_ticket__cdata AS ticket_data ON ticket.ticket_id = ticket_data.ticket_id ";

		//$sql .=" LEFT JOIN ts_department AS depart ON ticket.dept_id=depart.dept_id  "; 
		$sql .= " LEFT JOIN ts_team AS teams  ON teams.team_id = ticket.team_id  ";

		$sql .= " LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id= ticket.status_id  ";

		//$sql .=" LEFT JOIN cc_vu_workcodes  AS wk ON stats.caller_id = wk.caller_id AND stats.unique_id = wk.unique_id";

		if ($agent_id) {
			$sql .= " WHERE admin.admin_id = '" . $agent_id . "'";
		}
		$sql .= " GROUP BY TIME(stats.call_datetime) ORDER BY stats.id DESC ";
		//$sql .=" GROUP BY TIME(stats.update_datetime) ORDER BY stats.id DESC ";
		if ($per_page) {
			$sql .= "  LIMIT {$startpoint},{$per_page} ";
		}
		//echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function inbound_call_report_13_3_16($startpoint, $per_page, $agent_id, $fromdate, $todate, $compalaint_id, $workcodes, $product, $natures, $status)
	{
		//echo $startpoint.':'.$per_page.':'.$agent_id.':'.$fromdate.':'.$todate.':'.$compalaint_id.':'.$workcodes.':'.$product.':'.$natures.':'.$status;
		//die;
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT admin_id,full_name,DATE(stats.update_datetime) AS call_date,TIME(stats.call_datetime) AS TIME ,";
		$sql .= " SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS inbound_call_duration, ";
		$sql .= " SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF( stats.dequeue_datetime,stats.enqueue_datetime)))) AS wait_in_queue, ";
		$sql .= " stats.caller_id AS caller_id,stats.unique_id AS call_id,department,users.cmid,users.uin,ticket.product,ticket.nature,ticket.others,ticket.number,ticket_data.subject,teams.name AS dept_name,tstatus.name,wk.detail AS remarks,GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes  ";
		$sql .= " FROM cc_admin AS admin";

		$sql .= " INNER JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id 
    	         AND DATE(stats.update_datetime) BETWEEN '" . $fromdate . "' AND  '" . $todate . "'
				 AND stats.call_type = 'INBOUND'
                 AND (stats.call_status = 'ANSWERED' OR stats.call_status = 'TRANSFER') ";

		//$sql .=" LEFT JOIN cc_vu_workcodes  AS t1 ON stats.unique_id = t1.unique_id  AND stats.staff_id = t1.staff_id";
		if ($workcodes) {
			$sql .= " INNER JOIN cc_vu_workcodes  AS t1 ON stats.unique_id = t1.unique_id  AND stats.staff_id = t1.staff_id";
			$sql .= " AND t1.workcodes LIKE '%" . $workcodes . "%' ";
		} else {
			$sql .= " LEFT JOIN cc_vu_workcodes  AS t1 ON stats.unique_id = t1.unique_id  AND stats.staff_id = t1.staff_id";
		}


		if ($compalaint_id || $product || $natures || $status) {
			$sql .= " INNER JOIN ts_ticket AS ticket ON stats.unique_id = ticket.unique_id";
		} else {
			$sql .= " LEFT JOIN ts_ticket AS ticket ON stats.unique_id = ticket.unique_id";
		}
		$sql .= " AND stats.staff_id =ticket.who_created ";
		if ($compalaint_id) {
			$sql .= " AND ticket.ticket_id='" . trim((int)$compalaint_id) . "' ";
		}
		if ($product) {
			$sql .= " AND ticket.product='" . $product . "' ";
		}
		if ($natures) {
			$sql .= " AND ticket.nature='" . $natures . "' ";
		}
		if ($status) {
			$sql .= " AND ticket.status_id='" . $status . "' ";
		}
		$sql .= " LEFT JOIN ts_user AS users ON ticket.user_id = users.id ";

		$sql .= " LEFT JOIN ts_ticket__cdata AS ticket_data ON ticket.ticket_id = ticket_data.ticket_id ";

		//$sql .=" LEFT JOIN ts_department AS depart ON ticket.dept_id=depart.dept_id  "; 
		$sql .= " LEFT JOIN ts_team AS teams  ON teams.team_id = ticket.team_id  ";

		$sql .= " LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id= ticket.status_id  ";

		$sql .= " LEFT JOIN cc_vu_workcodes  AS wk ON stats.caller_id = wk.caller_id AND stats.unique_id = wk.unique_id";

		if ($agent_id) {
			$sql .= " WHERE admin.admin_id = '" . $agent_id . "'";
		}
		$sql .= " GROUP BY TIME(stats.call_datetime) ORDER BY stats.id DESC ";
		//$sql .=" GROUP BY TIME(stats.update_datetime) ORDER BY stats.id DESC ";
		if ($per_page) {
			$sql .= "  LIMIT {$startpoint},{$per_page} ";
		}
		//	echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function abandoned_call_report($agent_id, $fromdate, $todate)
	{
		global $db_conn;
		global $db_prefix;

		$sql = "SELECT * from cc_abandon_calls WHERE 1=1 ";
		$sql .= "AND DATE_FORMAT(update_datetime, '%Y-%m-%e %H:%i:%s')
							Between DATE_FORMAT('$fromdate', '%Y-%m-%e %H:%i:%s')
							AND DATE_FORMAT('$todate', '%Y-%m-%e %H:%i:%s')";
		if (!empty($agent_id)) {
			$takeagent = "SELECT admin_id from cc_admin where full_name = " . $agent_id;
			$newrs = $db_conn->Execute($takeagent);
			$admin_new_id = $newrs->fields['admin_id'];
			$sql . " AND staff_id = " . $admin_new_id;
		}
		//$sql .= " GROUP BY update_datetime ";
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function dropped_call_report($agent_id, $fromdate, $todate, $startpoint, $per_page)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT SQL_CALC_FOUND_ROWS  (SELECT full_name FROM cc_admin WHERE admin_id = stats.staff_id ) AS full_name, DATE(stats.call_datetime) AS call_date,";
		$sql .= " TIME(stats.call_datetime) AS TIME,";
		$sql .= " IFNULL(SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,call_datetime)))),'00:00:00') AS duration,";
		$sql .= " stats.caller_id,stats.call_type,stats.call_status,stats.disconnect_by,stats.unique_id AS call_id ";
		$sql .= " FROM cc_queue_stats AS stats ";
		if ($agent_id) {
			$sql .= " WHERE stats.staff_id = '" . $agent_id . "' AND ";
		} else {
			$sql .= " WHERE ";
		}
		$sql .= "DATE_FORMAT(stats.call_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fromdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$todate ', '%Y-%m-%e %H:%i:%s')";
		$sql .= " AND stats.call_status = 'DROP' AND stats.call_type = 'INBOUND'";
		$sql .= " GROUP BY stats.call_datetime order by stats.call_datetime desc";

		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function out_bound_calls_report($agent_id, $fromdate, $todate, $startpoint, $per_page)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT admin_id,full_name,  (stats.call_datetime) AS call_date,";
		$sql .= " TIME(stats.call_datetime) AS TIME,";
		$sql .= " TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) AS duration,";
		$sql .= " stats.caller_id,stats.call_type,stats.call_status,stats.disconnect_by,stats.unique_id,wk.detail AS remarks ";
		$sql .= " FROM cc_admin AS admin";
		$sql .= " INNER JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id ";
		$sql .= " AND DATE_FORMAT(stats.call_datetime, '%Y-%m-%e %H:%i:%s') 
							Between DATE_FORMAT('$fromdate', '%Y-%m-%e %H:%i:%s')
							AND DATE_FORMAT('$todate', '%Y-%m-%e %H:%i:%s')";
		$sql .= " AND stats.call_type = 'OUTBOUND'";
		//$sql .= " AND stats.call_status = 'ANSWERED'";
		// $sql .=" AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) <> '00:00:00' ";
		$sql .= " LEFT JOIN cc_vu_workcodes  AS wk ON stats.caller_id = wk.caller_id AND stats.unique_id = wk.unique_id";
		if ($agent_id) {
			$sql .= " WHERE admin.admin_id = '" . $agent_id . "'";
		}

		$sql .= " ORDER BY stats.id DESC ";
		if ($per_page) {
			$sql .= " LIMIT {$startpoint},{$per_page} ";
		}
		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function in_bound_calls_report($agent_id, $fromdate, $todate)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT admin_id,full_name, DATE(stats.call_datetime) AS call_date,";
		$sql .= " TIME(stats.call_datetime) AS TIME,";
		$sql .= " TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) AS duration,";
		$sql .= " stats.caller_id,stats.call_type,stats.call_status,stats.disconnect_by,stats.unique_id,wk.detail AS remarks ";
		$sql .= " FROM cc_admin AS admin";
		$sql .= " INNER JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id ";
		$sql .= " AND DATE_FORMAT(stats.call_datetime, '%Y-%m-%e %H:%i:%s') 
							Between DATE_FORMAT('$fromdate', '%Y-%m-%e %H:%i:%s')
							AND DATE_FORMAT('$todate', '%Y-%m-%e %H:%i:%s')";
		$sql .= " AND stats.call_type = 'INBOUND'";
		$sql .= " AND stats.call_status = 'ANSWERED'";
		$sql .= " LEFT JOIN cc_vu_workcodes  AS wk ON stats.caller_id = wk.caller_id AND stats.unique_id = wk.unique_id";
		if ($agent_id) {
			$sql .= " WHERE admin.admin_id = '" . $agent_id . "'";
		}

		$sql .= " ORDER BY stats.id DESC ";
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function get_agent_summary_20($agent_id, $fdate, $tdate)
	{

		global $db_conn;
		global $db_prefix;
		$sql = "SELECT admin_id,full_name,COUNT( DISTINCT stats.id) AS inbound_call_no,";
		$sql .= " SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS inbound_call_duration,";
		$sql .= " SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF( stats.update_datetime,stats.staff_end_datetime)))) AS inbound_busy_duration,";
		$sql .= " COUNT(DISTINCT stats2.id)  AS outbound_call_no,";
		$sql .= " SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats2.staff_end_datetime,stats2.staff_start_datetime)))) AS outbound_call_duration,";
		$sql .= " SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats2.update_datetime,stats2.staff_end_datetime)))) AS outbound_busy_duration,";
		$sql .= " COUNT(DISTINCT abandoned.id) AS abandon_calls, COUNT(DISTINCT stats3.call_status) AS droped_calls, ";
		$sql .= " SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(break.end_datetime, break.start_datetime)))) AS break_time,";
		$sql .= " SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(assignment.end_datetime, assignment.start_datetime)))) AS assignment_time,";
		$sql .= "  SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(logout_datetime,login_datetime)))) AS login_duration, TIME_FORMAT(TIME(MIN(login_datetime)), '%h:%i:%s %p') AS login_time,";
		$sql .= " TIME_FORMAT(TIME(MAX(logout_datetime)), '%h:%i:%s %p') AS logout_time, department";

		$sql .= " FROM cc_admin AS admin LEFT JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id  AND DATE(stats.update_datetime) BETWEEN '" . $fdate . "' AND '" . $tdate . "'
        AND stats.call_type = 'INBOUND'
        AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) <> '00:00:00'";

		$sql .= " LEFT JOIN cc_queue_stats AS stats2 ON admin.admin_id = stats2.staff_id AND stats2.call_type = 'OUTBOUND' ";

		$sql .= " LEFT JOIN cc_queue_stats AS stats3 ON admin.admin_id = stats3.staff_id AND stats3.call_status = 'DROP' ";

		$sql .= " LEFT JOIN  cc_abandon_calls AS abandoned ON admin.admin_id = abandoned.staff_id  AND DATE(abandoned.update_datetime) = DATE(stats.update_datetime) ";

		$sql .= " LEFT JOIN cc_crm_activity AS break ON admin.admin_id = break.staff_id AND break.status <> '6' AND break.status <> '1'";

		$sql .= "  LEFT JOIN cc_crm_activity AS assignment ON admin.admin_id = assignment.staff_id AND assignment.status = 6 ";

		$sql .= "  LEFT JOIN  cc_login_activity AS login_activety ON admin.admin_id = login_activety.staff_id  
                   AND DATE(login_activety.login_datetime)= DATE(stats.update_datetime)
                   AND DATE(login_activety.logout_datetime)= DATE(stats.update_datetime)";


		if ($agent_id) {
			$sql .= " WHERE admin_id = '" . $agent_id . "'";
		}
		$sql .= " GROUP BY admin.admin_id,stats.call_type,stats2.call_type,stats3.call_status,DATE(stats.update_datetime)";
		//echo $sql;
		//$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function get_agent_summary_old($agent_id, $date)
	{

		global $db_conn;
		global $db_prefix;
		$sql = "SELECT admin_id,full_name,COUNT( DISTINCT stats.id) AS inbound_call_no,";
		$sql .= " SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime)))) AS inbound_call_duration,";
		$sql .= " SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF( stats.update_datetime,stats.staff_end_datetime)))) AS inbound_busy_duration,";
		$sql .= " COUNT(DISTINCT stats2.id)  AS outbound_call_no,";
		$sql .= " SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats2.staff_end_datetime,stats2.staff_start_datetime)))) AS outbound_call_duration,";
		$sql .= " SEC_TO_TIME(SUM( DISTINCT TIME_TO_SEC(TIMEDIFF(stats2.update_datetime,stats2.staff_end_datetime)))) AS outbound_busy_duration,";
		$sql .= " COUNT(DISTINCT abandoned.id) AS abandon_calls, COUNT(DISTINCT stats3.call_status) AS droped_calls, ";
		$sql .= " SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(break.end_datetime, break.start_datetime)))) AS break_time,";
		$sql .= " SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(assignment.end_datetime, assignment.start_datetime)))) AS assignment_time,";
		$sql .= "  SEC_TO_TIME(SUM(DISTINCT TIME_TO_SEC(TIMEDIFF(logout_datetime,login_datetime)))) AS login_duration, TIME_FORMAT(TIME(MIN(login_datetime)), '%h:%i:%s %p') AS login_time,";
		$sql .= " TIME_FORMAT(TIME(MAX(logout_datetime)), '%h:%i:%s %p') AS logout_time, department";

		$sql .= " FROM cc_admin AS admin LEFT JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id  AND DATE(stats.update_datetime) = '" . $date . "'
        AND stats.call_type = 'INBOUND'
        AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) <> '00:00:00'";

		$sql .= " LEFT JOIN cc_queue_stats AS stats2 ON admin.admin_id = stats2.staff_id AND stats2.call_type = 'OUTBOUND' ";

		$sql .= " LEFT JOIN cc_queue_stats AS stats3 ON admin.admin_id = stats3.staff_id AND stats3.call_status = 'DROP' ";

		$sql .= " LEFT JOIN  cc_abandon_calls AS abandoned ON admin.admin_id = abandoned.staff_id  AND DATE(abandoned.update_datetime) = '" . $date . "'";

		$sql .= " LEFT JOIN cc_crm_activity AS break ON admin.admin_id = break.staff_id AND break.status <> '6' AND break.status <> '1'";

		$sql .= "  LEFT JOIN cc_crm_activity AS assignment ON admin.admin_id = assignment.staff_id AND assignment.status = 6 ";

		$sql .= "  LEFT JOIN  cc_login_activity AS login_activety ON admin.admin_id = login_activety.staff_id  
                   AND DATE(login_activety.login_datetime)='" . $date . "' 
                   AND DATE(login_activety.logout_datetime)='" . $date . "'";


		if ($agent_id) {
			$sql .= " WHERE admin_id = '" . $agent_id . "'";
		}
		$sql .= " GROUP BY admin.admin_id,stats.call_type,stats2.call_type,stats3.call_status,DATE(stats.update_datetime)";
		// echo $sql;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	/*function get_agent_on_call_busy_times_for_summary($admin_id,$date,$type){

                global $db_conn; global $db_prefix;
                $sql = "SELECT count(*) as cnt, staff_id,call_type,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(staff_end_datetime,staff_start_datetime)))) AS call_duration,
                SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(update_datetime,staff_end_datetime)))) AS busy_duration
                FROM ".$db_prefix."_queue_stats
                WHERE 1=1 ";
                if($admin_id !=0 ){
                $sql.= "AND staff_id ='".$admin_id."'";                          
                }
                $sql.= "AND DATE(update_datetime)='".$date."' AND  call_type = '".$type."' ";
                $sql.= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";
                $sql.= "GROUP BY staff_id,call_type ";//echo("<br>".$sql); exit;
                //echo $sql;
                $rs = $db_conn->Execute($sql);
                //echo("<br>".$sql); 
                //exit;
                return $rs;
        }*/



	// ends hbm	
	function update_profile_customeer($unique_id, $caller_id, $customer_id, $account_no, $payment, $MailingAddress, $CityName, $email, $mobile, $residence, $office, $humail, $husms, $huemail, $MaritalStatus, $staff_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "insert into " . $db_prefix . "_profile_update  ";
		$sql .= "(unique_id,caller_id,customer_id,account_no,payment_frequency,MailingAddress,CityName,email,mobile,residence,office,hold_mail,hold_sms,hold_email,MaritalStatus,staff_id,update_datetime) ";
		$sql .= "values( 
		'" . $unique_id . "',
		'" . $caller_id . "',
		'" . $customer_id . "',
		'" . $account_no . "',
		'" . $account_no . "',
		'" . strip_tags($MailingAddress) . "',
		'" . $CityName . "',
		'" . $email . "',
		'" . $mobile . "',
		'" . $residence . "',
		'" . $office . "', 
		'" . $humail . "', 
		'" . $husms . "', 
		'" . $huemail . "', 
		'" . $MaritalStatus . "', 
		'" . $_SESSION[$db_prefix . '_UserId'] . "',
		NOW()
		)";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
	}
	function get_data_by_token($key)
	{
		global $db_conn;
		global $db_prefix;
		$sql2  = "SELECT * FROM cc_config WHERE `key`='$key'; ";
		//echo($sql2);
		//exit();
		return $rs2 = $db_conn->Execute($sql2);
	}
	function insert_admin_config($namespace, $key, $value)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "insert into " . $db_prefix . "_config ";
		$sql .= "(`namespace`,`key`,`value`) ";
		$sql .= "values ('" . $namespace . "','" . $key . "','" . $value . "')";
		//echo $sql;
		//die;
		return $db_conn->Execute($sql);
	}
	/*function sendmail($email,$admin_id){

            $encrypt = $admin_id;
            //$message = "Your password reset link send to your e-mail address.";
            $to='outsource@outsourceinteractive.com';//$email;
            $subject="Forget Password";
            $from = 'outsource@outsourceinteractive.com';
            $body='Hi, <br/><br/>Your Membership ID is '.$admin_id.
            '<br><br>Click here to reset your password http://10.100.50.56/outsource_crm/reset.php?token='.$encrypt.'&action=reset<br/><br/>--<br>http://10.100.50.51/outsource_crm/<br>Solve your problems.';
            $headers = "From: " . strip_tags($from) . "\r\n";
            $headers .= "Reply-To: ". strip_tags($from) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            return $tools->sendEmail($from, $to,'outsource', $subject,$body);
 
          //return  mail($to,$subject,$body,$headers);
    }	*/


	function change_password($admin_id, $newpassword = '')
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "update " . $db_prefix . "_admin set password='" . md5($newpassword) . "' where admin_id='" . $admin_id . "'";
		return $rs = $db_conn->Execute($sql);
	}
	function no_of_login_users()
	{
		global $db_conn;
		global $db_prefix;
		$sql1  = "SELECT COUNT(is_crm_login) AS Users FROM cc_admin WHERE is_crm_login !='0' and designation = 'Agents'";
		//echo($sql);
		//exit();
		return $rs1 = $db_conn->Execute($sql1);
	}
	function get_user_by_email($email_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql2  = "SELECT * FROM cc_admin WHERE email='$email_id'; ";
		//       echo($sql2);
		//exit();
		return $rs2 = $db_conn->Execute($sql2);
	}

	function desig_of_login_users_by_id($admin_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql2  = "SELECT designation FROM cc_admin WHERE admin_id='$admin_id'; ";
		//       echo($sql2);
		//exit();
		return $rs2 = $db_conn->Execute($sql2);
	}
	function desig_of_login_users($email_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql2  = "SELECT designation FROM cc_admin WHERE email='$email_id'; ";
		//       echo($sql2);
		//exit();
		return $rs2 = $db_conn->Execute($sql2);
	}


	function check_admin_auth($email = '', $password = '', $status = '1')
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "select * from " . $db_prefix . "_admin where 1=1  and email='" . $email . "' and password='" . md5($password) . "' and status='" . $status . "'";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
	}
	function admin_change_password($Select_Agent = '', $newpassword = '', $status = '1')
	{
		global $db_conn;
		global $db_prefix;
		if ($Select_Agent == 0) {
			$Select_Agent = $_SESSION[$db_prefix . '_UserId'];
		}
		$sql  = "update " . $db_prefix . "_admin set password='" . md5($newpassword) . "' where 1=1 and admin_id='" . $Select_Agent . "' and status='" . $status . "' ";
		//echo($sql);
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
	function admin_all_change_password2MD5($admin_id = '')
	{
		global $db_conn;
		global $db_prefix;

		$sql = "SELECT * from " . $db_prefix . "_admin ";
		//		echo($sql);
		//		exit();
		$rs = $db_conn->Execute($sql);
		while (!$rs->EOF) {
			$admin_id = $rs->fields["admin_id"];
			$email 	  = $rs->fields["email"];
			$password = $rs->fields["password"];

			$this->AdminChangePassword($email, md5($password));
			$rs->MoveNext();
		}
		return 1;
	}
	function get_iver_selection($unique_id)
	{
		global $db_conn;
		global $db_prefix;

		$sql = " SELECT ivr_selection ";
		$sql .= " from " . $db_prefix . "_queue_stats ";
		$sql .= " WHERE unique_id ='" . $unique_id . "' and staff_id='" . $_SESSION[$db_prefix . '_UserId'] . "'";
		//echo($sql);
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
	function get_available_user_list()
	{
		global $db_conn;
		global $db_prefix;

		$sql = " SELECT * ";
		$sql .= " from " . $db_prefix . "_admin ";
		$sql .= " WHERE is_phone_login=1 and is_crm_login = 1 and is_busy=0";
		//		echo($sql);
		//		exit();
		return $rs = $db_conn->Execute($sql);
	}
	function get_admin_user_listing($admin_id = '')
	{
		global $db_conn;
		global $db_prefix;

		$sql = " SELECT *, a.status as status ";
		$sql .= " from " . $db_prefix . "_admin a, " . $db_prefix . "_admin_groups ag ";
		$sql .= " WHERE a.group_id = ag.id ";

		//		$sql.= "order by FullName";
		//		echo($sql);
		//		exit();
		return $rs = $db_conn->Execute($sql);
	}
	function get_records_count($alpha = "")
	{

		global $db_conn;
		global $db_prefix;
		$sql = "select count(*) tRec from " . $db_prefix . "_admin where 1=1 ";
		if (!empty($alpha)) {
			$sql .= "and full_name like '" . $alpha . "%' ";
		}
		$rs = $db_conn->Execute($sql);
		return $rs->fields["tRec"];
	}
	function get_records($alpha = "", $startRec, $totalRec = 80, $field = "staff_updated_date", $order = "asc")
	{

		global $db_conn;
		global $db_prefix;
		$sql = "select a.*,ag.group_name,(SELECT full_name FROM " . $db_prefix . "_admin WHERE admin_id = staff_id) AS staff_name from " . $db_prefix . "_admin a," . $db_prefix . "_admin_groups ag where 1=1 ";
		if (!empty($alpha)) {
			$sql .= "and a.full_name like '" . $alpha . "%'";
		}
		$sql .= "and a.group_id = ag.id";
		$sql .= " order by $field $order";
		$sql .= " limit $startRec, $totalRec";

		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); exit;
		return $rs;
	}
	function get_agent_name($agent_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT `password`, full_name, department FROM " . $db_prefix . "_admin WHERE admin_id = '" . $agent_id . "' ";

		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); exit;
		return $rs;
	}

	function get_agent_list_hold($fullname, $callerid)
	{

		global $db_conn;
		global $db_prefix;

		$nsql = "SELECT admin_id from cc_admin where full_name='" . $fullname . "'";
		$nrs = $db_conn->Execute($nsql);
		$staffid = $nrs->fields["admin_id"];

		$sql = " SELECT TIMEDIFF(TIME(NOW()), TIME(start_datetime)) as new_t_time from cc_hold_calls where staff_id = " . $staffid . " and status=0 and caller_id = '" . $callerid . "'";

		$rs = $db_conn->Execute($sql);
		//      echo("<br>".$sql);
		//exit;
		return $rs;
	}

	function get_particular_hold($uniqueid)
	{

		global $db_conn;
		global $db_prefix;

		$sql = "select SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(TIME(end_datetime), TIME(start_datetime))))) as new_t_time from cc_hold_calls where unique_id='" . $uniqueid . "'";

		$rs = $db_conn->Execute($sql);
		//      echo("<br>".$sql);
		//exit;          
		return $rs;
	}

	function get_agent_hold_new_time($staff_id, $update_datetime)
	{

		global $db_conn;
		global $db_prefix;

		$sql = "select SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(TIME(end_datetime), TIME(start_datetime))))) as hold_time from cc_hold_calls where staff_id='" . $staff_id . "'";
		if (!empty($update_datetime)) {
			$sql .= "  AND DATE(update_datetime) = DATE('" . $update_datetime . "')";
		}
		$rs = $db_conn->Execute($sql);
		//      echo("<br>".$sql);
		//exit;
		return $rs;
	}

	function get_agent_list($alpha = "", $startRec, $totalRec = 80, $field = "full_name", $order = "asc", $fdate, $tdate)
	{

		global $db_conn;
		global $db_prefix;
		/*$sql = " SELECT full_name,email,agent_exten,is_crm_login,is_phone_login,is_busy,unique_id, (SELECT caller_id FROM cc_queue_stats WHERE unique_id = cc_admin.unique_id) AS caller_id FROM ".$db_prefix."_admin where 1=1 && is_crm_login=1 && is_phone_login=1 ";
		$sql.= " order by $field $order";
		$sql.= " limit $startRec, $totalRec";*/
		$sql = " SELECT  admin.admin_id,admin.full_name,admin.email,admin.agent_exten,admin.is_crm_login,admin.is_phone_login,admin.is_busy,admin.unique_id,queue.caller_id, queue.call_type,  ";
		$sql .= " ";
		$sql .= " CASE admin.is_busy
 				 WHEN '1' THEN TIMEDIFF(TIME(NOW()), TIME(queue.staff_start_datetime)) 
  				 WHEN '0' THEN TIMEDIFF(TIME(NOW()), TIME(queue.update_datetime)) 
 				 WHEN '2' THEN TIMEDIFF(TIME(NOW()), TIME(queue.update_datetime)) 
 				 WHEN '3' THEN TIMEDIFF(TIME(NOW()), TIME(queue.update_datetime)) 
 				 END AS t_duration ";
		$sql .= " FROM " . $db_prefix . "_admin AS admin LEFT OUTER JOIN " . $db_prefix . "_queue_stats AS queue ON admin.unique_id = queue.unique_id where 1=1 ";
		$sql .= " AND DATE(admin.staff_updated_date) = DATE(NOW()) ";
		$sql .= " AND designation = 'Agents' ";
		$sql .= " AND admin.status = 1 ";
		$sql .= " AND admin.is_crm_login !=0";
		$sql .= " AND admin.is_phone_login !=0";
		$sql .= " GROUP BY admin.full_name ";
		//$sql.= " order by admin.$field $order";
		$sql .= " order by admin.full_name";
		$sql .= " limit $startRec, $totalRec";


		$rs = $db_conn->Execute($sql);
		//	echo("<br>".$sql); 
		//exit;
		return $rs;
	}

	function get_agent_comp_list($alpha = "", $startRec, $totalRec = 80, $field = "full_name", $order = "asc", $fdate, $tdate)
	{

		global $db_conn;
		global $db_prefix;
		$sql = " SELECT  admin.admin_id,admin.full_name,admin.email,admin.agent_exten,admin.is_crm_login,admin.is_phone_login,admin.is_busy,admin.unique_id,queue.caller_id, queue.call_type,  ";
		$sql .= " ";
		$sql .= " CASE admin.is_busy
                                 WHEN '1' THEN TIMEDIFF(TIME(NOW()), TIME(queue.staff_start_datetime))
                                 WHEN '0' THEN TIMEDIFF(TIME(NOW()), TIME(queue.update_datetime))
                                 WHEN '2' THEN TIMEDIFF(TIME(NOW()), TIME(queue.update_datetime))
                                 WHEN '3' THEN TIMEDIFF(TIME(NOW()), TIME(queue.update_datetime))
                                 END AS t_duration ";
		$sql .= " FROM " . $db_prefix . "_admin AS admin LEFT OUTER JOIN " . $db_prefix . "_queue_stats AS queue ON admin.unique_id = queue.unique_id where 1=1 ";
		$sql .= " AND DATE(admin.staff_updated_date) = DATE(NOW()) ";
		$sql .= " AND designation = 'Agents' ";
		$sql .= " AND admin.status = 1 ";
		//$sql .= " AND admin.is_crm_login !=0";
		//$sql .= " AND admin.is_phone_login !=0";
		$sql .= " GROUP BY admin.full_name ";
		//$sql.= " order by admin.$field $order";
		$sql .= " order by admin.full_name";
		$sql .= " limit $startRec, $totalRec";


		$rs = $db_conn->Execute($sql);
		//      echo("<br>".$sql);             
		//exit;
		return $rs;
	}


	function get_queue_stats($alpha = "", $startRec, $totalRec = 80, $field = "staff_updated_date", $order = "asc")
	{

		global $db_conn;
		global $db_prefix;
		$sql = " SELECT stats.*, Time(stats.enqueue_datetime) as q_start_time ,TIMEDIFF(NOW(),enqueue_datetime) AS duration, admin.full_name as agent_name FROM " . $db_prefix . "_queue_stats AS stats
			LEFT OUTER JOIN cc_admin AS admin ON admin.admin_id = stats.staff_id WHERE   ";
		$sql .= " stats.STATUS <> '0' AND stats.enqueue_datetime = stats.dequeue_datetime ";
		$sql .= " AND (stats.STATUS = 1 OR stats.STATUS = 2)";
		/* By Yahya 13/09/2012*/
		$sql .= " AND (stats.call_status <> 'IVR' AND stats.call_status <> 'OFFTIME')";
		/* By Yahya End 13/09/2012*/

		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); exit;
		return $rs;
	}
	function last_call_id($agent_id)
	{

		global $db_conn;
		global $db_prefix;
		$sql = " SELECT caller_id from  " . $db_prefix . "_queue_stats where 1=1 ";
		$sql .= " AND staff_id='" . $agent_id . "' ORDER BY id DESC LIMIT 1";
		//echo("<br>".$sql); exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function ringing_id($agent_id)
	{

		global $db_conn;
		global $db_prefix;
		$sql = " SELECT caller_id from  " . $db_prefix . "_queue_stats where 1=1 ";
		$sql .= " AND staff_id='" . $agent_id . "' and status = '2' ORDER BY id DESC LIMIT 1";
		//echo("<br>".$sql); exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function get_queue_wait_stats_x($agent_id, $alpha = "", $startRec, $totalRec = 80, $field = "staff_updated_date", $order = "asc", $fdate, $tdate)
	{
		// echo $agent_id;
		//die;
		global $db_conn;
		global $db_prefix;

		$sql = " SELECT stats.*,TIMEDIFF(dequeue_datetime,enqueue_datetime) AS duration, Date(update_datetime) as date , Time(update_datetime) as time, 
		admin.full_name as agent_name ,SEC_TO_TIME(cc_cdr.duration) AS t_duration
		FROM cc_queue_stats as stats 
		LEFT OUTER JOIN cc_admin AS admin
			ON admin.admin_id = stats.staff_id
		INNER	JOIN cc_cdr
    		ON stats.unique_id = cc_cdr.uniqueid
		 WHERE  1=1 ";
		//$sql.= " AND HOUR(update_datetime)-1  "; //AND STATUS <> '-1'";
		$sql .= " AND TIMEDIFF(stats.staff_end_datetime,stats.staff_start_datetime) <> '00:00:00' ";
		//$sql.= " AND TIMEDIFF(stats.dequeue_datetime,stats.enqueue_datetime) > '00:00:10' ";
		if (!empty($fdate) && !empty($tdate)) {
			$sql .= "  AND stats.update_datetime Between  '" . $fdate . "' AND '" . $tdate . "' ";
		} else {
			$sql .= " AND DATE(stats.update_datetime) = DATE(NOW()) ";
		}
		$sql .= " AND stats.call_type = 'INBOUND'  ";
		$sql .= " ORDER BY stats.id DESC"; //" order by $field $order";
		//$sql.= " LIMIT 5";//" limit $startRec, $totalRec";

		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); exit;
		return $rs;
	}

	function max_call_duration($agent_id, $alpha = "", $startRec, $totalRec = 1, $field = "staff_updated_date", $order = "asc", $fdate, $tdate)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "  SELECT  max(talk_time) AS t_duration, caller_id,  enqueue_duration AS duration,  DATE(call_datetime) AS DATE,  TIME(call_datetime) AS TIME,  full_name AS agent_name  FROM cc_xvu_queue_stats where 1=1 ";
		if ($agent_id) {
			$sql .= " AND staff_id='" . $agent_id . "'";
		}
		$sql .= " AND call_type = 'INBOUND' ";
		$sql .= " AND call_status = 'ANSWERED' ";
		if (!empty($fdate) && !empty($tdate)) {
			$sql .= "  AND DATE_FORMAT(call_datetime, '%Y-%m-%e %H:%i:%s') 
								Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s')
								AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s')";
		} else {
			$sql .= " AND DATE(call_datetime) = DATE(NOW()) ";
		}
		// $sql.= " AND call_type = 'INBOUND'  ";
		$sql .= " LIMIT 0,1";
		// $sql.= " ORDER BY id ASC";//" order by $field $order";
		// $sql.= " LIMIT 1";//" limit $startRec, $totalRec";

		$rs = $db_conn->Execute($sql);
		//echo $sql;
		//echo("<br>".$sql); exit;
		return $rs;
	}
	function min_call_duration($agent_id, $alpha = "", $startRec, $totalRec = 1, $field = "staff_updated_date", $order = "asc", $fdate, $tdate)
	{
		//echo $agent_id;
		//die;
		global $db_conn;
		global $db_prefix;

		// $sql = " SELECT  *,  enqueue_duration AS duration,  DATE(update_datetime) AS DATE,  TIME(update_datetime) AS TIME,  full_name AS agent_name,  talk_time AS t_duration FROM cc_vu_queue_stats where 1=1 ";
		//farhan			    $sql = " SELECT  *,  enqueue_duration AS duration,  DATE(update_datetime) AS DATE,  TIME(call_datetime) AS TIME,  full_name AS agent_name,  talk_time AS t_duration FROM cc_vu_queue_stats where 1=1 ";
		$sql = " SELECT MIN(talk_time)  AS t_duration, caller_id,  enqueue_duration AS duration,  DATE(call_datetime) AS DATE,  TIME(call_datetime) AS TIME,  full_name AS agent_name FROM cc_xvu_queue_stats where 1=1  ";
		if ($agent_id) {
			$sql .= " AND staff_id='" . $agent_id . "'";
		}
		//$sql.= " AND HOUR(update_datetime)-1  "; //AND STATUS <> '-1'";
		$sql .= " AND call_type = 'INBOUND' ";
		$sql .= " AND call_status = 'ANSWERED' ";

		//$sql.= " AND TIMEDIFF(stats.dequeue_datetime,stats.enqueue_datetime) > '00:00:10' ";
		if (!empty($fdate) && !empty($tdate)) {
			$sql .= "  AND DATE_FORMAT(call_datetime, '%Y-%m-%e %H:%i:%s') 
									Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s')
									AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s')";
		} else {
			$sql .= " AND DATE(call_datetime) = DATE(NOW()) ";
		}
		// $sql.= " AND call_type = 'INBOUND'  ";
		$sql .= " LIMIT 0,1";
		// $sql.= " ORDER BY id DESC";//" order by $field $order";
		// $sql.= " LIMIT 1";//" limit $startRec, $totalRec";

		$rs = $db_conn->Execute($sql);
		//echo $sql;
		//echo("<br>".$sql); exit;
		// var_dump($rs);
		return $rs;
	}

	function get_queue_wait_stats($agent_id, $alpha = "", $startRec, $totalRec = 80, $field = "staff_updated_date", $order = "asc", $fdate, $tdate)
	{
		global $db_conn;
		global $db_prefix;


		$sql = " SELECT *,  enqueue_duration AS duration,  DATE(call_datetime) AS DATE,  TIME(call_datetime) AS TIME,  full_name AS agent_name,  talk_time AS t_duration FROM cc_vu_queue_stats where 1=1 ";
		if ($agent_id) {
			$sql .= " AND staff_id='" . $agent_id . "'";
		}
		$sql .= " AND call_status ='ANSWERED' ";
		if (!empty($fdate) && !empty($tdate)) {
			$sql .= "  AND call_datetime Between  '" . $fdate . "' AND '" . $tdate . "' ";
		} else {
			$sql .= " AND DATE(call_datetime) = DATE(NOW()) ";
		}
		$sql .= " AND call_type = 'INBOUND'  ";
		$sql .= " ORDER BY id DESC";

		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	function get_queue_wait_stats_pdf($agent_id, $fdate, $tdate)
	{
		global $db_conn;
		global $db_prefix;


		$sql = " SELECT *,  enqueue_duration AS duration,  DATE(call_datetime) AS DATE,  TIME(call_datetime) AS TIME,  full_name AS agent_name,  talk_time AS t_duration FROM cc_vu_queue_stats where 1=1 ";
		if ($agent_id) {
			$sql .= " AND staff_id='" . $agent_id . "'";
		}
		$sql .= " AND call_status ='ANSWERED' ";
		if (!empty($fdate) && !empty($tdate)) {
			$sql .= "  AND call_datetime Between  '" . $fdate . "' AND '" . $tdate . "' ";
		} else {
			$sql .= " AND DATE(call_datetime) = DATE(NOW()) ";
		}
		$sql .= " AND call_type = 'INBOUND'  ";
		$sql .= " ORDER BY id DESC";

		$rs = $db_conn->Execute($sql);
		return $rs;
	}

	/*function get_agents_monthly_stats($month){

                global $db_conn; global $db_prefix;

                //$sql = " SELECT * FROM cc_vu_queue_stats  WHERE (MONTH(update_datetime) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH))) ";
                $sql = "SELECT COUNT(id) AS calls_count, full_name, caller_id, MONTHNAME(update_datetime) AS month_name
						FROM cc_vu_queue_stats  WHERE (MONTH(update_datetime) = ".$month.") GROUP BY full_name ";
                $rs = $db_conn->Execute($sql);
                //echo("<br>".$sql); exit;
                return $rs;
        }*/
	function get_agents_monthly_stats_sub_query($month, $staff_id, $work_type)
	{
		global $db_conn;
		global $db_prefix;
		$year =  strstr($month, '/');
		$monthNum = strtok($month, '/');;
		$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
		$year1 = str_replace("/", "", $year);
		$sql = " SELECT
    				 COUNT(DISTINCT cc_call_workcodes.unique_id) as workcode_wise
   					 FROM cc_call_workcodes 
   					 INNER JOIN cc_queue_stats  q2  ON q2.unique_id = cc_call_workcodes.unique_id AND q2.call_type = 'INBOUND'
					 AND q2.call_status = 'ANSWERED'
   					 WHERE cc_call_workcodes.staff_id = " . $staff_id . "
      			     AND (workcodes LIKE ' %" . $work_type . "')
      				 AND (MONTH(`staff_updated_date`) = " . $monthNum . "
                     AND YEAR(`staff_updated_date`) = " . $year1 . ")";
		//echo $sql;	 
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	function get_agents_monthly_stats($month)
	{

		global $db_conn;
		global $db_prefix;

		$year =  strstr($month, '/');
		$monthNum = strtok($month, '/');;
		$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
		$year1 = str_replace("/", "", $year);
		$sql = " SELECT
					  `q`.`staff_id`,`a`.`full_name` AS `full_name`,
					  MONTHNAME(`q`.`update_datetime`) AS month_name,
					  COUNT(`q`.`id`) AS `calls_count`,
					  SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(`q`.`staff_end_datetime`,`q`.`staff_start_datetime`)))) AS avg_talk_time";
		$sql .= " FROM (`cc_queue_stats` `q`  JOIN `cc_admin` `a`)
					WHERE (`q`.`staff_id` = `a`.`admin_id`)
					AND `q`.`call_type` = 'INBOUND' AND AND `q`.`call_status` = 'ANSWERED'
				    AND (MONTH(`q`.`update_datetime`) = '" . $monthNum . "'
					AND YEAR(`q`.`update_datetime`) =  '" . $year1 . "') GROUP BY a.full_name";

		// echo $sql;
		$rs = $db_conn->Execute($sql);


		return $rs;
	}
	function get_agents_monthly_stats_old($month)
	{

		global $db_conn;
		global $db_prefix;

		$year =  strstr($month, '/');
		$monthNum = strtok($month, '/');;
		$monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
		$year1 = str_replace("/", "", $year);
		// echo $year1;
		/// echo $monthNum;
		// die;
		//$sql = " SELECT * FROM cc_vu_queue_stats  WHERE (MONTH(update_datetime) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH))) ";
		$sql = " SELECT t1.full_name,
                          MONTHNAME(t1.update_datetime) AS month_name,
                          COUNT(t1.id) AS calls_count,
                          GROUP_CONCAT(DISTINCT t2.workcodes SEPARATOR ' | ') AS inquiry,
                          GROUP_CONCAT(DISTINCT t3.workcodes SEPARATOR ' | ') AS  complaint,
                          SEC_TO_TIME(AVG(TIME_TO_SEC(t1.talk_time))) AS avg_talk_time,
                          t1.caller_id";
		$sql	.= " FROM cc_vu_queue_stats as t1 LEFT JOIN  cc_vu_workcodes AS t2 ON t1.unique_id = t2.unique_id AND t2.workcodes LIKE ' Inquiry%'
                            LEFT JOIN  cc_vu_workcodes AS t3 ON t1.unique_id = t3.unique_id AND t3.workcodes LIKE ' Complaint%' WHERE (MONTH(update_datetime) = " . $monthNum . " AND YEAR(update_datetime) = " . $year1 . ") AND call_type = 'INBOUND' GROUP BY t1.full_name ";
		// echo $sql;
		$rs = $db_conn->Execute($sql);

		//echo("<br>".$sql); exit;
		return $rs;
	}

	function get_drop_call_stats($agent_id, $alpha = "", $startRec, $totalRec = 80, $field = "staff_updated_date", $order = "asc", $fdate, $tdate)
	{

		global $db_conn;
		global $db_prefix;
		$sql = " SELECT full_name, call_date as date, call_time as time, TIMEDIFF(dequeue_datetime,enqueue_datetime) AS duration, caller_id, unique_id FROM cc_xvu_queue_stats where 1=1";
		if ($agent_id) {
			$sql .= " AND staff_id ='" . $agent_id . "' ";
		}
		if (!empty($fdate) && !empty($tdate)) {
			$sql .= "  AND call_datetime Between  '" . $fdate . "' AND '" . $tdate . "' AND status = 0  ";
		} else {
			$sql .= " AND DATE(call_datetime) = DATE(NOW()) AND status = 0  ";
		}
		$sql .= "AND call_status ='DROP' ";
		$sql .= " AND call_type = 'INBOUND' ORDER BY id DESC"; //" order by $field $order";

		$rs = $db_conn->Execute($sql);

		return $rs;
	}

	function get_abandon_dashboard($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime ", $order = "desc", $fdate, $tdate)
	{

		global $db_conn;
		global $db_prefix;

		$sql = "SELECT caller_id as clid, DATE(call_datetime) AS DATE, TIME(call_datetime) AS TIME, TIMEDIFF(dequeue_datetime, enqueue_datetime) AS duration from cc_xvu_queue_stats WHERE 1=1 AND call_type='INBOUND' AND call_status='ABANDONED'";
		if (!empty($fdate) && !empty($tdate)) {
			$sql .= "  AND call_datetime Between  '" . $fdate . "' AND '" . $tdate . "' AND status = 0  ";
		} else {
			$sql .= " AND DATE(call_datetime) = DATE(NOW()) AND status = 0  ";
		}
		$sql .= " ORDER BY call_datetime desc ";
		$rs = $db_conn->Execute($sql);
		return $rs;
	}



	function get_off_time_stats($alpha = "", $startRec, $totalRec = 80, $field = "staff_updated_date", $order = "asc", $fdate, $tdate)
	{

		global $db_conn;
		global $db_prefix;

		$sql = "SELECT caller_id as clid, DATE(call_datetime) AS DATE, TIME(call_datetime) AS TIME, TIMEDIFF(dequeue_datetime, enqueue_datetime) AS duration, full_name as agent_name FROM cc_queue_stats left join cc_admin on cc_admin.admin_id  = cc_queue_stats.staff_id WHERE cc_queue_stats.status = 0 AND cc_queue_stats.call_type = 'INBOUND' AND  cc_queue_stats.call_status = 'ABANDONED' ";
		if (!empty($fdate) && !empty($tdate)) {
			$sql .= "   AND  call_datetime BETWEEN  '" . $fdate . "' AND '" . $tdate . "' ";
		}
		$rs = $db_conn->Execute($sql);
		return $rs;
	}


	function admin_user_name_exists($username, $Admin_ID = 0)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "select * from " . $db_prefix . "_admin where 1=1 ";
		$sql .= " and full_name='" . $username . "'";
		if (!empty($Admin_ID))
			$sql .= " and admin_id <> '" . $Admin_ID . "'";
		//echo($sql);
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
	function insert_admin_user($agent_exten, $full_name, $password, $email, $designation, $department, $group_id, $status = '1')
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "insert into " . $db_prefix . "_admin  ";
		$sql .= "(agent_exten ,full_name, password , email, designation, department, group_id, status, staff_id) ";
		$sql .= "values( '" . $agent_exten . "','" . strip_tags($full_name) . "', '" . $password . "', '" . strip_tags($email) . "', '" . $designation . "', '" . $department . "','" . $group_id . "', '" . $status . "', '" . $_SESSION[$db_prefix . '_UserId'] . "')";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
	}
	function insert_admin_groups($group_name, $status = '1')
	{
		global $db_conn;
		global $db_prefix;

		$sql  = "insert into " . $db_prefix . "_admin_groups ";
		$sql .= "(group_name,status, staff_id) ";
		$sql .= "values ('" . strip_tags($group_name) . "', '" . $status . "', '" . $_SESSION[$db_prefix . '_UserId'] . "')";
		//echo($sql."<br/>$admin_site_id");
		//exit();
		return $db_conn->Execute($sql);
	}
	function get_groups_details($group_id = '0', $startRec = 0, $totalRec = 80, $field = "staff_updated_date", $order = "asc")
	{
		global $db_conn;
		global $db_prefix;
		$sqladmin  = "select pg.*,a.full_name  from " . $db_prefix . "_admin_groups pg, " . $db_prefix . "_admin a where 1=1";
		$sqladmin .= " and pg.staff_id = a.admin_id";
		if (!empty($group_id)) {
			$sqladmin .= " and pg.id='" . $group_id . "'";
		}
		$sqladmin .= " order by $field $order";
		//$sqladmin.= " limit $startRec, $totalRec;";
		//echo($sqladmin); exit();
		return $db_conn->Execute($sqladmin);
	}
	function get_page_groups_details($page_group_id = '0')
	{
		global $db_conn;
		global $db_prefix;
		/*SELECT * FROM `th_admin_privileges` ap,`th_admin_groups` ag,`th_pages` p,`th_pages_groups` pg WHERE ap.Page_ID=p.page_id and ap.Page_Group_ID=pg.group_id and ap.Group_ID=ag.id*/

		$sql  = "SELECT * from " . $db_prefix . "_pages p , " . $db_prefix . "_pages_groups pg ";
		$sql .= " WHERE p.group_id = pg.group_id  ";

		if (!empty($page_group_id))
			$sql .= " and pg.group_id='" . $page_group_id . "'";

		//		echo($sql);
		//		exit();
		return $db_conn->Execute($sql);
	}
	function delete_admin_privileges($page_id, $page_group_id, $group_id, $status = '1')
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "DELETE FROM " . $db_prefix . "_admin_privileges ";
		$sql .=  "where Page_Group_ID='" . $page_group_id . "' and Group_ID='" . $group_id . "' ";;
		//Page_ID=".$page_id." and
		//echo $sql;
		$db_conn->Execute($sql);
	}
	function insert_admin_privileges($page_id, $page_group_id, $group_id, $status = '1')
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "insert into " . $db_prefix . "_admin_privileges ";
		$sql .= "(Page_ID, Page_Group_ID, Group_ID, Allow) ";
		$sql .= "values ('" . $page_id . "','" . $page_group_id . "','" . $group_id . "','" . $status . "')";
		//echo $sql;
		return $db_conn->Execute($sql);
	}
	function get_admin_by_id($Admin_ID)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT * FROM " . $db_prefix . "_admin ";
		$sql .=  "where admin_id = '" . $Admin_ID . "' ";
		//echo $sql;
		return $db_conn->Execute($sql);
	}
	function get_admin_group_by_id($AdminGroup_ID)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "SELECT * FROM " . $db_prefix . "_admin_groups ";
		$sql .=  "where id = '" . $AdminGroup_ID . "'";
		//echo $sql;
		return $db_conn->Execute($sql);
	}
	function update_admin_groups($group_id, $group_name, $status = '1')
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "update " . $db_prefix . "_admin_groups ";
		$sql .= " set group_name = '" . $group_name . "',";
		$sql .= " status = '" . $status . "',";
		$sql .= " staff_id = '" . $_SESSION[$db_prefix . '_UserId'] . "'";
		$sql .= " where id = '" . $group_id . "'";
		//echo($sql."<br/>$admin_site_id");
		//exit();
		return $db_conn->Execute($sql);
	}
	function update_admin_user($admin_id, $agent_exten, $full_name, $email, $designation, $department, $group_id, $status = '1')
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "update " . $db_prefix . "_admin ";
		$sql .= "set agent_exten= '" . $agent_exten . "',full_name = '" . strip_tags($full_name) . "', email = '" . strip_tags($email) . "', designation = '" . $designation . "', department = '" . $department . "', group_id = '" . $group_id . "', status = '" . $status . "'";

		$sql .= "where admin_id = '" . $admin_id . "'";
		//echo($sql);
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
	function update_admin_user_password($admin_id, $password)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "update " . $db_prefix . "_admin ";
		$sql .= "set password = '" . $password . "'";
		$sql .= "where admin_id = '" . $admin_id . "' ";
		//		echo($sql);
		//		exit();
		return $rs = $db_conn->Execute($sql);
	}
	function delete_admin_user($admin_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "update " . $db_prefix . "_admin ";
		$sql .= "set status = '0' ";
		$sql .= "where admin_id = '" . $admin_id . "'";
		//		echo($sql);
		//		exit();
		return $rs = $db_conn->Execute($sql);
	}
	function delete_admin_groups($group_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "update " . $db_prefix . "_admin_groups ";
		$sql .= "set status = '0' ";
		$sql .= "where id = '" . $group_id . "'";
		//		echo($sql."<br/>$admin_site_id");
		//		exit();
		$db_conn->Execute($sql);

		$sql  = "update " . $db_prefix . "_admin ";
		$sql .= "set status = '0' ";
		$sql .= "where group_id = '" . $group_id . "'";
		//		echo($sql."<br/>$admin_site_id");
		//		exit();
		return $db_conn->Execute($sql);
	}
	function usr_auth($user_name, $password)
	{
		global $db_conn;
		global $db_prefix;
		$sql = "select * from " . $db_prefix . "_admin where 1=1 ";
		$sql .= "and email='" . $user_name . "' ";
		$sql .= "and password='" . md5($password) . "' ";
		//$sql .= "and status='1' ";
		//$sql .= "and status='1' and is_crm_login='0' and (is_phone_login='1' or designation='Supervisor')";
		//              $sql .= "and status='1'  and (is_phone_login='1' or designation='Supervisor')";


		$rs = $db_conn->Execute($sql);
		//echo $sql;
		//echo($sql."<br/>$admin_site_id"); exit();
		if ($rs->RecordCount()) {
			$sql  = "insert into " . $db_prefix . "_login_activity ";
			$sql .= "( staff_id, login_datetime, logout_datetime, status, update_datetime) ";
			$sql .= "values ('" . $rs->fields["admin_id"] . "',NOW(),NOW(), '2',NOW())";
			//echo $sql;
			//exit();
			$db_conn->Execute($sql);
			$sql  = "SELECT LAST_INSERT_ID() as login_id";
			//			echo $sql;
			$login_id = $db_conn->Execute($sql);
			//			echo($login_id->fields["login_id"]); exit();

			$_SESSION[$db_prefix . '_LoginId']	 = $login_id->fields["login_id"];
			$_SESSION[$db_prefix . '_UserId'] 	 = $rs->fields["admin_id"];
			$_SESSION[$db_prefix . '_UserName'] 	 = $rs->fields["full_name"];
			$_SESSION[$db_prefix . '_UserEmail']   = $rs->fields['email'];
			$_SESSION[$db_prefix . '_UserPassword']   = $rs->fields['password'];
			$_SESSION[$db_prefix . '_AgentExten']  = $rs->fields["agent_exten"];
			$_SESSION[$db_prefix . '_UserGroupId'] = $rs->fields['group_id'];
			//$_SESSION[$db_prefix.'_chk_desig'] = $rs->fields['designation'];      
			$sql   = "SELECT DATE_FORMAT(login_datetime, '%W, %D %M %Y  %r') as login_date FROM cc_login_activity ";
			$sql  .= " where staff_id= '" . $_SESSION[$db_prefix . '_UserId'] . "'";
			$sql  .= " ORDER BY login_datetime DESC ";
			//$sql  .= " DESC LIMIT 2, 1";
			$sql  .= "LIMIT 1 OFFSET 1";
			//echo $sql; exit();
			$l_login = $db_conn->Execute($sql);

			if ($l_login->RecordCount()) {
				$_SESSION[$db_prefix . '_LLoginTime']     = $l_login->fields["login_date"];
			} else {
				$_SESSION[$db_prefix . '_LLoginTime'] = "";
			}
			/********************* select user group name *****************************/
			//SELECT  g.group_name FROM cc_admin AS a ,cc_admin_groups AS g WHERE g.id = a.group_id AND a.email = '54321';
			/*$sql  = "SELECT g.group_name FROM ".$db_prefix."_admin AS a ,".$db_prefix."_admin_groups AS g ";
			$sql .= " WHERE g.id = a.group_id AND a.email = '".$user_name."' ";*/
			//echo $sql; exit();
			/*$g_name = $db_conn->Execute($sql); 
			if($g_name->fields["group_name"] == "Agent")
			{
				
			}
			else
			{
				
			}*/
			/**************************************************************************/
			/**************************** update admin Status ************************/
			$sql  = "update " . $db_prefix . "_admin ";
			$sql .= " set is_crm_login = '1'  ";
			$sql .= " where  email='" . $user_name . "' ";
			$sql .= " and status='1'";
			//echo($sql."<br/>$admin_site_id"); exit();
			$db_conn->Execute($sql);
			/*************************************************************************/

			return true;
		} else {
			return false;
		}
	}
	function send_msg($title, $message)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "insert into " . $db_prefix . "_quick_msgs ";
		$sql .= "( title, message, staff_id, update_datetime) ";
		$sql .= "values ('" . $title . "','" . $message . "','" . $_SESSION[$db_prefix . '_UserId'] . "',NOW())";
		//echo $sql;
		//exit();
		return $rs = $db_conn->Execute($sql);
	}

	function usr_logout($user_name, $id)
	{
		global $db_conn;
		global $db_prefix;

		//$sql  = " update ".$db_prefix."_crm_activity SET end_datetime=NOW() WHERE 1=1 ";
		//$sql .= " and staff_id='".$id."' AND DATE(update_datetime)=DATE(NOW())  ORDER BY id DESC  LIMIT 1";
		//$db_conn->Execute($sql);	


		$sql  = "update " . $db_prefix . "_admin ";
		$sql .= " set is_crm_login = '0' , is_phone_login = 1 , is_busy='0' ";
		//$sql .= " where  email='".$user_name."' and admin_id='".$id."' ";
		$sql .= " where  email='" . $user_name . "' ";
		$sql .= " and status='1'";
		//echo($sql."<br/>$admin_site_id"); exit();
		$db_conn->Execute($sql);

		$sql  = "update " . $db_prefix . "_login_activity ";
		$sql .= " set logout_datetime = NOW() , update_datetime = NOW() , status = '1'";
		$sql .= " where  staff_id='" . $id . "' and status = '2'";
		//$sql .= " and status='1'";
		//echo($sql."<br/>$admin_site_id"); exit();
		$db_conn->Execute($sql);

		$sql  = "update " . $db_prefix . "_queue_stats ";
		$sql .= " set status = 0 , update_datetime = NOW() ";
		//	$sql .= " where staff_id='".$id."' and status = '-1'";
		$sql .= " where staff_id='" . $id . "'";
		$db_conn->Execute($sql);

		$sql  = "update cc_admin set is_busy='0' where admin_id='" . $id . "'and status='1'";
		$db_conn->Execute($sql);
	}
	function usr_pin_session_reset($user_name, $id)
	{
		global $db_conn;
		global $db_prefix;

		$sql  = "update " . $db_prefix . "_queue_stats ";
		$sql .= " set status = 0 , update_datetime = NOW() ";
		$sql .= " where staff_id='" . $id . "' AND status <> 0 AND LENGTH(status) >= 3";
		//echo($sql."<br/>"); exit();			
		$db_conn->Execute($sql);

		$sql  = "update cc_admin set is_busy='0' where admin_id='" . $id . "'and status='1'";
		$db_conn->Execute($sql);
	}
	function crm_status_change($agent_id, $status)
	{
		global $db_conn;
		global $db_prefix;

		$sql  = " update " . $db_prefix . "_crm_activity SET end_datetime=NOW() WHERE 1=1 ";
		$sql .= " and staff_id='" . $agent_id . "' AND DATE(update_datetime)=DATE(NOW())  ORDER BY id DESC  LIMIT 1";
		$db_conn->Execute($sql);

		$sql  = " update " . $db_prefix . "_admin ";
		$sql .= " set is_crm_login = '" . $status . "' ";
		$sql .= " where admin_id='" . $agent_id . "' ";
		$db_conn->Execute($sql);

		$sql  = "insert into " . $db_prefix . "_crm_activity ";
		$sql .= "( staff_id, start_datetime, end_datetime, status ,update_datetime) ";
		$sql .= "values ('" . $_SESSION[$db_prefix . '_UserId'] . "',NOW(),NOW(),'" . $status . "',NOW())";
		//echo $sql;
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
	function cc_refresh($agent_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = " update " . $db_prefix . "_admin set is_crm_login = '0',is_phone_login=0, is_busy='0' ";
		$sql .= " where is_crm_login<>'0' OR is_phone_login<>'0' OR is_busy<>'0'";
		$db_conn->Execute($sql);

		$sql  = "update " . $db_prefix . "_queue status status = '0',update_datetime=NOW() ";
		$sql .= "where status<>'0'";
		$db_conn->Execute($sql);
	}
	/******************* KAAM CHALAO KAAM CRM STATUS TIME AND LAST CAL BUSY TIME *******************************/
	function crm_status_time($staff_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT  TIMEDIFF(NOW(), start_datetime) AS start_time ";
		$sql .= " FROM " . $db_prefix . "_crm_activity  where 1=1 ";
		$sql .= " AND DATE(update_datetime) = DATE(NOW()) ";
		$sql .= " AND staff_id = '" . $staff_id . "' ";
		$sql .= " ORDER BY id DESC LIMIT 1 ";
		//$sql.= " limit $startRec, $totalRec";
		//echo $sql;
		$rs = $db_conn->Execute($sql);
		return  $rs->fields["start_time"];
	}
	function crm_30_last_time($full_name)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT  count(call_datetime) AS start_30_time ";
		$sql .= " FROM " . $db_prefix . "_xvu_queue_stats  where 1=1 ";
		$sql .= " AND call_datetime > NOW() - INTERVAL 30 MINUTE ";
		$sql .= " AND full_name = '" . $full_name . "' ";
		$sql .= " AND call_status = 'ANSWERED' ";
		$sql .= " ORDER BY id DESC LIMIT 1 ";
		//$sql.= " limit $startRec, $totalRec";
		//echo $sql;
		$rs = $db_conn->Execute($sql);
		return  $rs->fields["start_30_time"];
	}
	function last_busy_time($staff_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql = " SELECT  TIMEDIFF(  ";
		$sql .= " (SELECT TIME(update_datetime) AS end_time FROM cc_queue_stats  WHERE staff_id = '" . $staff_id . "' AND DATE(update_datetime) = DATE(NOW()) AND STATUS = '0'  ORDER BY id DESC LIMIT 1),  ";
		$sql .= " (SELECT TIME(update_datetime) AS end_time FROM cc_queue_stats_logs  WHERE staff_id = '" . $staff_id . "' AND DATE(update_datetime) = DATE(NOW()) AND STATUS = '-1'  ORDER BY id DESC LIMIT 1)) AS duration  ";
		//echo $sql;
		$rs = $db_conn->Execute($sql);
		return  $rs->fields["duration"];
	}

	/***********************************************************************************************************/


	/*************************** Get agent list for (Agent Session Reset) page ********************************/

	function get_agents_list()
	{
		global $db_conn;
		global $db_prefix;

		$sql = " SELECT *";
		$sql .= " from " . $db_prefix . "_admin ";
		$sql .= " WHERE designation = 'Agents' ";

		//		$sql.= "order by FullName";
		//echo($sql);exit;
		//		exit();
		return $rs = $db_conn->Execute($sql);
	}



	function get_agents_list_all()
	{
		global $db_conn;
		global $db_prefix;

		$sql = " SELECT *";
		$sql .= " from " . $db_prefix . "_admin ";
		$sql .= " WHERE 1=1 ";

		//              $sql.= "order by FullName";
		//echo($sql);exit;
		//              exit();
		return $rs = $db_conn->Execute($sql);
	}

	/**********************************************************************************************************/

	/************************* Insert Agent (Add agent functionality) *****************************************************/

	function insert_agent($agent_exten, $full_name, $email, $password, $designation, $department, $group_id, $staff_id)
	{

		global $db_conn;
		global $db_prefix;

		$sql  = " insert into " . $db_prefix . "_admin ";
		$sql .= " (agent_exten, full_name, password, email, designation, department, group_id, staff_id) ";
		$sql .= " values( '" . $agent_exten . "','" . $full_name . "', '" . md5($password) . "', '" . $email . "','" . $designation . "', '" . $department . "', '" . $group_id . "', '" . $staff_id . "')";
		return $rs = $db_conn->Execute($sql);
	}

	function update_prev_agent($agent_id)
	{

		global $db_conn;
		global $db_prefix;

		$sql  = " update " . $db_prefix . "_admin ";
		$sql .= " SET STATUS='0', staff_updated_date = NOW() ";
		$sql .= " WHERE admin_id = '" . $agent_id . "'";
		//echo $sql;
		//exit;
		$db_conn->Execute($sql);
	}
}


function insert_extention($ex_number, $ex_name, $ex_password, $ex_right)
{
	global $db_conn;

	$sql  = "INSERT into cc_extensions";
	$sql .= "(extension_num, extension_name, password, rights ) ";
	$sql .= " values('$ex_number', '$ex_name', '" .  $ex_password  . "', '$ex_right')";
	$db_conn->Execute($sql);

	// All At Once
	// $sip = "[" . $ex_number . "]
	// username = " . $ex_number . "
	// type = friend
	// host = dynamic
	// secret = " . $ex_password . "
	// context = " . $ex_right . "
	// callerid = " . $ex_number . "
	// mailbox = " . $ex_number . "@" . $ex_right . "
	// qualify = yes
	// call-limit = 1 
	// ";
	// $add_to_sip = "echo " . ($sip) . " >> asterisk_conf/custom_sip123.conf";
	// shell_exec($add_to_sip);

	// LINE BY LINE
	// asterisk_conf/custom_sip.conf
	$sip = "     ";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "[" . $ex_number . "]";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "username = " . $ex_number . "";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "type = friend";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "host = dynamic";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "secret = " . $ex_password . "";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "context = " . $ex_right . "";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "callerid = " . $ex_number . "";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "mailbox = " . $ex_number . "@" . $ex_right . "";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "qualify = yes";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);
	$sip = "call-limit = 1";
	$add_to_sip = "echo " . $sip . " >> asterisk_conf/custom_sip.conf";
	shell_exec($add_to_sip);

	if ($ex_right == "call_center") {
		$sql  = "INSERT into cc_admin";
		$sql .= "(agent_exten,
						full_name,
						password,
						email,
						designation,
						department,
						location,
						group_id,
						is_agent,
						is_crm_login,
						is_phone_login,
						is_busy,
						status,
						staff_id,
						priority ) ";
		$sql .= " values(
						'$ex_number',
						'$ex_name', 
						'" . md5($ex_password) . "',
						'$ex_name',
						'Agents',
						'ICT-Call Center',
						'K',
						'1',
						'0',
						'0',
						'0',
						'0',
						'1',
						'9030',
						'1')";
		$db_conn->Execute($sql);
	}

	shell_exec('/usr/sbin/asterisk -rx "sip reload"');
}

function fetch_extention()
{
	global $db_conn;

	$sql  = "SELECT * FROM cc_extensions";
	return $db_conn->Execute($sql);
}

function if_extension_exists($ex_num)
{
	global $db_conn;

	$sql        =     "SELECT * FROM cc_extensions WHERE extension_num = '$ex_num'";
	$rs         =     $db_conn->Execute($sql);
	$rsCount    =     $rs->rowCount();
	if ($rsCount > 0) {
		return 1;
	}
	if ($rsCount < 1) {
		return 0;
	}
}

function delete_extention($id, $ex)
{
	global $db_conn;

	$sql  = "SELECT * FROM cc_extensions WHERE id = '$id'";
	$rs = $db_conn->Execute($sql);

	$sip = "[" . $rs->fields['extension_num'] . "]\nusername = " . $rs->fields['extension_num'] . "\ntype = friend\nhost = dynamic\nsecret = " . $rs->fields['password'] . "\ncontext = " . $rs->fields['rights'] . "\ncallerid = " . $rs->fields['extension_num'] . "\nmailbox = " . $rs->fields['extension_num'] . "@" . $rs->fields['rights'] . "\nqualify = yes\ncall-limit = 1";

	//$add_to_sip = "echo '" . ($sip) . "' >> asterisk_conf/custom_sip.conf";
	//shell_exec($add_to_sip);
	//shell_exec('/usr/sbin/asterisk -rx "sip reload"'));

	$contents = file_get_contents("asterisk_conf/custom_sip.conf");
	$contents = str_replace($sip, '', $contents);
	file_put_contents("asterisk_conf/custom_sip.conf", $contents);

	$sql  = "DELETE FROM cc_extensions WHERE id = '$id'";
	$db_conn->Execute($sql);

	$sql  = "DELETE FROM cc_admin WHERE agent_exten = '$ex'";
	$db_conn->Execute($sql);

	shell_exec('/usr/sbin/asterisk -rx "sip reload"');
}

function update_extention($id, $ex_num, $ex_prev, $ex_name, $ex_pass, $ex_right)
{

	global $db_conn;

	$sql  = "SELECT * FROM cc_extensions WHERE id = '$id'";
	$rs = $db_conn->Execute($sql);

	$sip = "[" . $rs->fields['extension_num'] . "]\nusername = " . $rs->fields['extension_num'] . "\ntype = friend\nhost = dynamic\nsecret = " . $rs->fields['password'] . "\ncontext = " . $rs->fields['rights'] . "\ncallerid = " . $rs->fields['extension_num'] . "\nmailbox = " . $rs->fields['extension_num'] . "@" . $rs->fields['rights'] . "\nqualify = yes\ncall-limit = 1";

	$sip_new = "[" . $ex_num . "]\nusername = " . $ex_num . "\ntype = friend\nhost = dynamic\nsecret = " . $ex_pass . "\ncontext = " . $ex_right . "\ncallerid = " . $ex_num . "\nmailbox = " . $ex_num . "@" . $ex_right . "\nqualify = yes\ncall-limit = 1";

	$contents = file_get_contents("asterisk_conf/custom_sip.conf");
	$contents = str_replace($sip, $sip_new, $contents);
	file_put_contents("asterisk_conf/custom_sip.conf", $contents);

	$sql  = "UPDATE cc_extensions SET ";
	$sql .= "extension_num='$ex_num',";
	$sql .= "extension_name='$ex_name',";
	$sql .= "password='$ex_pass',";
	$sql .= "rights='$ex_right'";
	$sql .= "WHERE id = '$id'";
	$db_conn->Execute($sql);

	// Select : if exist 
	$sql  = "SELECT * FROM cc_admin WHERE agent_exten = '$ex_prev' LIMIT 1";
	$rs = $db_conn->Execute($sql);
	$rsCount = $rs->rowCount();

	// Delete : if exist & right is not equal to call_center
	if ($rsCount > 0 && $ex_right != "call_center") {
		$sql  = "DELETE FROM cc_admin WHERE agent_exten = '$ex_prev'";
		$db_conn->Execute($sql);
	}

	// Insert : if doesn't exist & right is equal to call_Center
	if ($rsCount < 1 && $ex_right == "call_center") {
		$sql  = "INSERT into cc_admin";
		$sql .= "(agent_exten,
						full_name,
						password,
						email,
						designation,
						department,
						location,
						group_id,
						is_agent,
						is_crm_login,
						is_phone_login,
						is_busy,
						status,
						staff_id,
						priority ) ";
		$sql .= " values(
						'$ex_num',
						'$ex_name', 
						'" . md5($ex_pass) . "',
						'$ex_name',
						'Agents',
						'ICT-Call Center',
						'K',
						'1',
						'0',
						'0',
						'0',
						'0',
						'1',
						'9030',
						'1')";
		$db_conn->Execute($sql);
	}

	$md5Pass = md5($ex_pass);
	$sql2  = "UPDATE cc_admin SET
	agent_exten = '$ex_num',
	full_name = '$ex_name',
	password = '$md5Pass',
	email = '$ex_name'
	WHERE agent_exten = '$ex_prev'";
	$db_conn->Execute($sql2);

	// Update : if exist & right is equal to call_Center
	if ($rsCount > 0 && $ex_right == "call_center") {
	}


	shell_exec('/usr/sbin/asterisk -rx "sip reload"');
}

function upload_ivr($ex_num)
{
	global $db_conn;

	$sql        =     "SELECT * FROM cc_extensions WHERE extension_num = '$ex_num'";
	$rs         =     $db_conn->Execute($sql);
	$rsCount    =     $rs->rowCount();
}


function submit_rating($rating, $unique_id, $call_date, $call_duration, $user)
{
	global $db_conn;

	$url = "/usr/bin/php /var/www/cgi-bin/pushrating.php";
	$params =  `$rating $unique_id $call_date $call_duration $user`;
	$currentDateTime = date("Y-m-d H:i:s");
	$sql        =     "SELECT * FROM cc_rating WHERE unique_id = '$unique_id'";
	$rs         =     $db_conn->Execute($sql);
	$rsCount    =     $rs->rowCount();

	if ($rsCount > 0) {
		$sql  = "UPDATE cc_rating SET ";
		$sql .= "rating='$rating' WHERE unique_id = '$unique_id' ";
		$db_conn->Execute($sql);
	}
	if ($rsCount < 1) {
		$sql  = "INSERT into cc_rating ";
		$sql .= "(unique_id, rating) ";
		$sql .= " values('$unique_id', '$rating')";
		$db_conn->Execute($sql);
	}
	$url = $url . " $unique_id $call_date $call_duration $rating $currentDateTime $user";
	//system($url);
	shell_exec('/usr/bin/php /var/www/cgi-bin/pushrating.php ' . $rating . ' ' . $unique_id . ' ' . $call_date . ' ' . $call_duration . ' ' . $user);
}

function fetch_rating($unique_id)
{
	global $db_conn;

	$sql  = "SELECT * FROM cc_rating WHERE unique_id = " . $unique_id;
	return $db_conn->Execute($sql);
}

function delete_extention_guide($id, $ex)
{
	global $db_conn;

	$sql  = "SELECT * FROM cc_extensions WHERE id = '$id'";
	$rs = $db_conn->Execute($sql);
	return $rs;
}


function fetch_ivr_robo()
{
	global $db_conn;

	$sql  = "SELECT * FROM cc_ivr_robo";
	return $db_conn->Execute($sql);
}

function delete_IVR($id)
{
	global $db_conn;

	$sql  = "SELECT * FROM cc_ivr_robo where id = '$id' ORDER BY id DESC limit 1";

	$rs = $db_conn->Execute($sql);

	$file_name = $rs->fields['file_name'];
	$file_dir = "/var/lib/asterisk/sounds/robocalls/$file_name.wav";

	unlink("robo_calls/$file_name.wav");
	if (unlink($file_dir)) {
		// file was successfully deleted
		$sql  = "DELETE FROM cc_ivr_robo WHERE id = '$id'";
		$db_conn->Execute($sql);
	} else {
		// there was a problem deleting the file
	}
}


function insert_IVR_robocall($ivr_name, $file_name)
{
	global $db_conn;

	$sql  = "INSERT into cc_ivr_robo";
	$sql .= "(ivr_name, file_name ) ";
	$sql .= " values('$ivr_name', '$file_name')";

	$db_conn->Execute($sql);
}

function ivr_file_pre_name()
{
	global $db_conn;

	$sql  = "SELECT * FROM cc_ivr_robo ORDER BY id DESC limit 1";

	$rs = $db_conn->Execute($sql);

	return $rs->fields['file_name'];
}

function fetch_robo()
{
	global $db_conn;
	$sql  = "SELECT * FROM cc_robo_primary";
	return $db_conn->Execute($sql);
}

function delete_roboCall($id)
{
	global $db_conn;
	$sql  = "DELETE FROM cc_robo_primary WHERE id = '$id'";
	$db_conn->Execute($sql);
}

function insert_roboCall($name, $IVR_name, $phone_number, $startTime, $retries)
{
	global $db_conn;

	$upload_date = date("Y-m-d H:i:s");

	$sql  = "INSERT into cc_robo_primary";
	$sql .= "(name, ivr_name, upload_date, phone_number, timetostart, retries, noofcalls ) ";
	$sql .= " values('$name', '$IVR_name', '$upload_date', '$phone_number', '$startTime', '$retries', 0)";

	$db_conn->Execute($sql);
}

function if_roboCall_name_exists($name)
{
	global $db_conn;
	$sql        =     "SELECT * FROM cc_robo_primary where name ='$name'";
	$rs         =     $db_conn->Execute($sql);
	$rsCount    =     $rs->rowCount();

	if ($rsCount > 0) {
		return true;
	}
	if ($rsCount < 1) {
		return false;
	}
}


function if_ivr_roboCall_name_exists($name)
{
	global $db_conn;
	$sql        =     "SELECT * FROM cc_ivr_robo where ivr_name='$name'";
	$rs         =     $db_conn->Execute($sql);
	$rsCount    =     $rs->rowCount();

	if ($rsCount > 0) {
		return true;
	}
	if ($rsCount < 1) {
		return false;
	}
}

function robo_calls_report($fromdate, $todate)
{
	global $db_conn;
	global $db_prefix;
	$sql = "SELECT * from cc_robo_final where DATE_FORMAT(upload_date, '%Y-%m-%e %H:%i:%s')
                                                        Between DATE_FORMAT('$fromdate', '%Y-%m-%e %H:%i:%s')
                                                        AND DATE_FORMAT('$todate', '%Y-%m-%e %H:%i:%s')";
	$sql .= " ORDER BY id";
	$rs = $db_conn->Execute($sql);
	return $rs;
}
