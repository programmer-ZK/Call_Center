	<?php

	class reports
	{
		function reports()
		{
		}



		function get_msisdn_count_wk($agent_id_out, $campaign_id, $attempts)
		{

			global $db_conn;
			global $db_prefix;
			//   $sql = "SELECT full_name, admin_id FROM ".$db_prefix."_admin WHERE group_id = '2' AND status = '1' ";
			$sql = "SELECT count(*) as msisdn_count FROM cc_campaign_detail WHERE  caller_id != '' and campaign_id = $campaign_id and (status = 1 OR status = $agent_id_out) AND attempts < $attempts ";
			//$sql.= " LIMIT 0,5";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); //exit;
			return $rs;
		}

		function get_msisdn_out_list_wk($agent_id_out, $campaign_id, $agent_id, $attempts)
		{

			global $db_conn;
			global $db_prefix;
			//   $sql = "SELECT full_name, admin_id FROM ".$db_prefix."_admin WHERE group_id = '2' AND status = '1' ";
			//  $sql = "SELECT * FROM cc_campaign_detail WHERE staff_id = $agent_id_out and campaign_id = $campaign_id and status = 1 ";
			$sql = "SELECT * FROM cc_campaign_detail WHERE  caller_id != '' and campaign_id = $campaign_id and (status = 1 OR status = $agent_id)  AND attempts < $attempts ORDER BY attempts limit 1";
			//$sql.= " LIMIT 0,5";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		function iget_blackNumber_records()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT * FROM cc_blacklist";
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_priorityAlert_records()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT * FROM cc_priorityalerts";
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		function iget_priorityAlertOne_records()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT `Number` FROM cc_priorityalerts Where Alert = 1";
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		function attempts_vice_call($campaign_id)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT attempts FROM cc_campaign WHERE  campaign_id = $campaign_id ";
			//echo $sql;exit;
			$rs = $db_conn->Execute($sql);

			return $rs;
		}




























		function get_workcode_details_newxx($field = "staff_updated_date", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $newsearch)
		{ //print_r ($newsearch);exit;
			$count = count($newsearch);
			//echo $count;exit;
			//echo $isexport.'as';exit;
			$newsearch2 = implode(",", $newsearch);
			//echo $newsearch2;exit; 
			global $db_conn;
			global $db_prefix;
			global $site_root;
			//	echo $level1.$level2.$level3.$level4.$level5;exit;
			$csv = '';
			if ($isexport == true) {
				$db_export = $site_root . "download/Workcode_report_" . $today . ".csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//t1.staff_id
			$sql = "SELECT
  t1.unique_id,
  t1.caller_id,
  t2.customer_id,
  t2.call_type,
  GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes,
  t1.staff_updated_date,
  (SELECT
     full_name
   FROM cc_admin
   WHERE admin_id = t1.staff_id ORDER BY t1.id) AS agent_name,
  detail
  
 ";





			if ($isexport != true) {
				$sql .= " , t2.update_datetime  ";
			}

			//$sql .= $csv." FROM cc_vu_workcodes AS t1,
			// cc_queue_stats AS t2

			$sql .= $csv . " FROM cc_call_workcodes AS t1,
 cc_queue_stats AS t2
 

 "; //t1.caller_id = t2.caller_id
			$sql .= "WHERE 1=1     AND t1.unique_id = t2.unique_id   ";
			$sql .= " AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime) 
	    AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime)
   

	";

			if (!empty($keywords)) {

				if ($search_keyword == 'call-track_id') {

					$sql .= " AND t1.unique_id = '" . $keywords . "' ";
				}

				if ($search_keyword == 'caller_id') {

					$sql .= " AND t1.caller_id = '" . $keywords . "' ";
				}

				/*if ($search_keyword == 'workcode') {
		
			$sql .= " AND t1.workcodes = '".$keywords."' ";
		}*/

				if ($search_keyword == 'agent_name') {

					$sql1 = "SELECT admin_id FROM cc_admin WHERE full_name LIKE '%$keywords%'";
					//echo "<br>".$sql1;
					$rs1 		= $db_conn->Execute($sql1);
					$admin_id 	= $rs1->fields['admin_id'];

					$sql .= " AND t1.staff_id = '" . $admin_id . "' ";
				}
			}
			if (!empty($where_in)) {

				$sql .= " AND ltrim(t1.workcodes) IN 
			(SELECT wc_title FROM cc_workcodes_new WHERE id IN 
(SELECT id FROM cc_workcodes_new WHERE id IN   
			
			(" . $where_in . ") AND parent_id IN (" . $where_in . ") )";
				//unset($_SESSION['workcodes']);
			}
			if (!empty($fdate) && !empty($tdate)) {

				$sql .= "
		
		 AND DATE(t1.staff_updated_date)BETWEEN DATE('" . $fdate . "') AND DATE('" . $tdate . "')
		
		";
			}
			if (!empty($newsearch) && $count > 1) {
				$sql .= "
	AND ltrim(t1.workcodes) IN (SELECT wc_title FROM cc_workcodes_new WHERE id IN 
(SELECT id FROM cc_workcodes_new WHERE id IN   
			
			(" . $newsearch2 . ") AND parent_id IN (" . $newsearch2 . ") ))";
			}

			if (!empty($newsearch) && $count == 1) {
				$sql .= "
	AND ltrim(t1.workcodes)  IN (SELECT wc_title FROM cc_workcodes_new WHERE id IN 
(SELECT id FROM cc_workcodes_new WHERE id IN   
			
			(" . $newsearch2 . ") AND parent_id IN (" . $newsearch2 . "))  ";
			}



			$sql .= " GROUP BY t1.staff_updated_date 
-- order by t1.staff_updated_date DESC
order by t1.id ASC 

 ";

			//echo("<br>".$sql);// exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}




		function call_comments($unique_id, $admin_id, $i)
		{
			global $db_conn;
			global $db_prefix;

			//		$sql = "SELECT question_no,question_code, admin_id , Qgroup, Percent as percent FROM cc_vu_evaluation
			//				WHERE unique_id = '".$unique_id."'  AND admin_id ='".$admin_id."'
			//				GROUP BY admin_id,Qgroup, question_no ";

			$sql = "SELECT
				 comments
				FROM cc_evaluation
				WHERE unique_id = '" . $unique_id . "' AND admin_id ='" . $admin_id . "' AND question_no ='" . $i . " '
				ORDER BY question_no";

			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}


		function feedback_export($field = "staff_updated_date", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $rank, $staff_id)
		{
			//echo $staff_id.$rank;exit;
			global $db_conn;
			global $db_prefix;
			global $site_root;
			$csv = '';
			$db_export = $site_root . "download/CustomerFeedback_Report_" . $today . ".csv";
			$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			//echo $csv; exit;
			$sql = "select cdr.caller_id AS 'CALLER ID', cdr.full_name 'AGENT NAME',cc_call_ranking.rank AS 'RANK' 
, cdr.unique_id 'CALL ID',GROUP_CONCAT(DISTINCT cc_vu_workcodes.workcodes SEPARATOR ' | ') AS 'WORKCODES'";
			$sql .= $csv . " from cc_vu_queue_stats cdr,cc_call_ranking,cc_vu_workcodes where  cdr.unique_id = cc_call_ranking.unique_id
AND cdr.unique_id = cc_vu_workcodes.unique_id  "; //t1.caller_id = t2.caller_id
			if (!empty($staff_id) && ($staff_id != '0')) {
				$sql .= " AND cc_call_ranking.staff_id = '$staff_id' ";
			}

			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE(cdr.call_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
			}
			if (!empty($rank) && ($rank != '0')) {
				$sql .= " AND  cc_call_ranking.rank = '" . $rank . "' ";
			}
			$sql .= "GROUP BY cdr.caller_id";


			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}




		function get_workcode_details_newxxbackup30072013($field = "staff_updated_date", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $newsearch)
		{ //print_r ($newsearch);exit;
			$count = count($newsearch);
			//echo $isexport.'as';exit;
			$newsearch2 = implode(",", $newsearch);
			//echo $newsearch2;exit; 
			global $db_conn;
			global $db_prefix;
			global $site_root;
			//	echo $level1.$level2.$level3.$level4.$level5;exit;
			$csv = '';
			if ($isexport == true) {
				$db_export = $site_root . "download/Workcode_report_" . $today . ".csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//t1.staff_id
			$sql = "SELECT
  t1.unique_id,
  t1.caller_id,
  t2.customer_id,
  t2.call_type,
  GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes,
  t1.staff_updated_date,
  (SELECT
     full_name
   FROM cc_admin
   WHERE admin_id = t1.staff_id ORDER BY t1.id) AS agent_name,
  detail
 ";





			if ($isexport != true) {
				$sql .= " , t2.update_datetime  ";
			}

			//$sql .= $csv." FROM cc_vu_workcodes AS t1,
			// cc_queue_stats AS t2

			$sql .= $csv . " FROM cc_call_workcodes AS t1,
 cc_queue_stats AS t2
 

 "; //t1.caller_id = t2.caller_id
			$sql .= "WHERE 1=1     AND t1.unique_id = t2.unique_id   ";
			$sql .= " AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime) 
	    AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime)
   

	";

			if (!empty($keywords)) {

				if ($search_keyword == 'call-track_id') {

					$sql .= " AND t1.unique_id = '" . $keywords . "' ";
				}

				if ($search_keyword == 'caller_id') {

					$sql .= " AND t1.caller_id = '" . $keywords . "' ";
				}

				/*if ($search_keyword == 'workcode') {
		
			$sql .= " AND t1.workcodes = '".$keywords."' ";
		}*/

				if ($search_keyword == 'agent_name') {

					$sql1 = "SELECT admin_id FROM cc_admin WHERE full_name LIKE '%$keywords%'";
					//echo "<br>".$sql1;
					$rs1 		= $db_conn->Execute($sql1);
					$admin_id 	= $rs1->fields['admin_id'];

					$sql .= " AND t1.staff_id = '" . $admin_id . "' ";
				}
			}
			if (!empty($where_in)) {

				$sql .= " AND t1.workcodes IN (" . $where_in . ") ";
				//unset($_SESSION['workcodes']);
			}
			if (!empty($fdate) && !empty($tdate)) {

				$sql .= "
		
		 AND DATE(t1.staff_updated_date)BETWEEN DATE('" . $fdate . "') AND DATE('" . $tdate . "')
		
		";
			}
			if (!empty($newsearch) && $count > 1) {
				$sql .= "
	AND ltrim(t1.workcodes)  IN (select wc_title from cc_workcodes_new where id IN (" . $newsearch2 . ")
	
	) ";
			}

			if (!empty($newsearch) && $count == 1) {
				$sql .= "
	AND t1.workcodes  IN (select wc_title from cc_workcodes_new where id ='" . $newsearch2 . "'
	
	or parent_id = '" . $newsearch2 . "'
	
	) ";
			}



			$sql .= " GROUP BY t1.staff_updated_date  order by staff_updated_date DESC ";

			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}












		function get_sum_agent_assignment_times($admin_id = 0, $date)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "select SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) as duration
 FROM " . $db_prefix . "_crm_activity WHERE 1=1 ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND DATE(update_datetime)='" . $date . "'";
			$sql .= " AND STATUS = 6 ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			$rs = $db_conn->Execute($sql);
			//	echo("<br>".$sql);// exit;
			return $rs;
		}



		function get_agent_drop_calls2($admin_id = 0, $date, $staff_id, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT count(*) as trec
						FROM " . $db_prefix . "_xvu_queue_stats
						WHERE 1=1 ";
			if ($admin_id != 0) {
				$sql .= " AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND DATE(call_datetime) BETWEEN '" . $date . "' AND '" . $tdate . "' AND call_status='DROP' AND staff_id = '" . $staff_id . "'";
			//$sql.= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";
			//$sql.= "GROUP BY call_type ";
			//echo("<br>".$sql);
			//exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['trec'];
		}






		function get_agent_abandon_calls2($admin_id = 0, $date, $staff_id)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT count(*) as trec
FROM " . $db_prefix . "_abandon_calls
WHERE 1=1 ";
			if ($admin_id != 0) {
				$sql .= " AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND DATE(update_datetime)='" . $date . "' AND staff_id = '" . $staff_id . "'";
			//$sql.= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";
			//$sql.= "GROUP BY call_type ";
			//echo("<br>".$sql); 
			//exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['trec'];
		}


		function count_call_center_timings($fdate, $tdate, $startRec, $totalRec = 80, $field = "update_datetime", $order = "desc")
		{
			global $db_conn;
			global $db_prefix;
			$sql = "SELECT count(*) as tRec
					FROM cc_schadule_config_log 
					WHERE 1=1 ";
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= "AND start_time>='" . $fdate . "' AND end_time<='" . $tdate . "' ";
			}
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields["tRec"];
		}

		function get_call_center_timings($fdate, $tdate, $startRec, $totalRec = 80, $field = "update_datetime", $order = "desc")
		{
			global $db_conn;
			global $db_prefix;
			$sql = "SELECT *
					FROM cc_schadule_config_log 
					WHERE  ";
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= "DATE_FORMAT(update_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') ";
				// $sql .= "update_datetime >='" . $fdate . "' AND DATE(update_datetime)<='" . $tdate . "' ";
			}
			$sql .= "order by update_datetime  LIMIT $startRec ,$totalRec ";
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}


		function get_call_center_timings2($fdate, $tdate, $startRec, $totalRec = 80, $field = "update_datetime", $order = "desc")
		{
			global $db_conn;
			global $db_prefix;
			$sql = "SELECT *
					FROM cc_schadule_config_log 
					WHERE 1=1 ";
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE_FORMAT(update_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') ";
				// $sql .= "AND DATE(update_datetime) >= '" . $fdate . "' AND DATE(update_datetime) <= ''" . $tdate . "' '";
			}
			$sql .= "GROUP BY update_datetime DESC  ";
			//echo("<br>".$sql); exit;//LIMIT $startRec ,$totalRec
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function get_agents_name($staff_id)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT full_name from cc_admin where admin_id='$staff_id'";
			//$sql.= "AND admin_id='$staff_id'";

			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		/*function get_records_count($alpha=""){

			global $db_conn; global $db_prefix;
			$sql = "select count(*) tRec from ".$db_prefix."_cdr where 1=1 ";
			if(!empty($alpha)){
					$sql.= "and (src like '".$alpha."%' or uniqueid like '".$alpha."%')";
			}
			$sql.= "and (src like '".$alpha."%' or uniqueid like '".$alpha."%')";
			$sql.= "and (channel LIKE '%DAHDI%')";
			$rs = $db_conn->Execute($sql);
            return $rs->fields["tRec"];
        }*/
		function get_records_count($alpha = "", $startRec, $totalRec = 80, $field = "calldate", $order = "desc", $fdate, $tdate, $search_keyword, $keywords)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "select count(*) as tRec from " . $db_prefix . "_cdr 
			as cdr 
			LEFT OUTER JOIN cc_admin AS admin
		    ON admin.admin_id = cdr.staff_id
			 where 1=1 ";
			if (!empty($fdate) && !empty($tdate) && empty($keywords)) {
				if ($search_keyword == "off_time") {
					$sql .= " AND cdr.call_status = 'OFFTIME' AND DATE(cdr.calldate) Between DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "ans_call") {
					$sql .= " AND cdr.call_status = 'ANSWERED' AND DATE(cdr.calldate) Between DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "drop_call") {
					$sql .= " AND cdr.call_status = 'DROP' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "agent_name") {
					$sql .= "  AND  admin.full_name <> '' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "in_bound") {
					$sql .= "  AND  cdr.call_type = 'INBOUND' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "out_bound") {
					$sql .= " AND cdr.call_type = 'OUTBOUND' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				} else {
					$sql .= "  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
				}
			} else if (!empty($fdate) && !empty($tdate) && !empty($keywords)) {
				//$sql.= " AND clid = '".$keywords."' or uniqueid = '".$keywords."' or uniqueid = '".$keywords."' AND DATE(calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				if ($search_keyword == "caller_id") {
					$sql .= " AND cdr.clid = '" . $keywords . "' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				/*if($search_keyword == "customer_id")
				{
					$sql.= " ";
					
				}*/
				if ($search_keyword == "call-track_id") {
					$sql .= "  AND cdr.uniqueid = '" . $keywords . "' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				/*if($search_keyword == "call_status")
				{
					$sql.= "  ";
				}*/
				if ($search_keyword == "agent_name") {
					$sql .= "  AND  admin.full_name =  UPPER('" . $keywords . "') AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "off_time") {
					$sql .= "  AND  cdr.call_status = 'OFFTIME' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "ans_call") {
					$sql .= "  AND  cdr.call_status = 'ANSWERED' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "drop_call") {
					$sql .= "  AND  cdr.call_status = 'DROP' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "in_bound") {
					$sql .= "  AND  cdr.call_type = 'INBOUND' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "out_bound") {
					$sql .= "  AND  cdr.call_type =  'OUTBOUND' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
			} else {
				$sql .= " AND DATE(cdr.calldate) = DATE(NOW())  ";
			}
			if (!empty($alpha)) {
				$sql .= "and (src like '" . $alpha . "%' or cdr.uniqueid like '" . $alpha . "%')";
			}
			//$sql.= " and (channel LIKE '%DAHDI%')";
			//echo("<br>".$sql); 
			//exit;
			$rs = $db_conn->Execute($sql);

			return $rs->fields["tRec"];
		}
		/****************************** GET RECORDS  ************************************/
		function get_records($alpha = "", $startRec, $totalRec = 80, $field = "calldate", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			if ($isexport == 0) {
				$db_export = $site_root . "download/Call_Records_" . $today . ".csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//cdr.*
			$sql = "select cdr.dst, cdr.clid, cdr.call_status, cdr.call_type, cdr.uniqueid ,date(cdr.calldate) as date, time(cdr.calldate) as time, SEC_TO_TIME(cdr.duration) as Duration, admin.full_name as agent_name, admin.admin_id as agent_id  ";
			if ($isexport != 0) {
				$sql .= " , cdr.userfield as userfield  ";
			}
			$sql .= $csv . " from " . $db_prefix . "_cdr 
			as cdr 
			LEFT OUTER JOIN cc_admin AS admin
		    ON admin.admin_id = cdr.staff_id
			 where 1=1 ";
			if (!empty($fdate) && !empty($tdate) && empty($keywords)) {
				if ($search_keyword == "off_time") {
					$sql .= " AND cdr.call_status = 'OFFTIME' AND DATE(cdr.calldate) Between DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "ans_call") {
					$sql .= " AND cdr.call_status = 'ANSWERED' AND  cdr.call_type = 'INBOUND' AND DATE(cdr.calldate) Between DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "drop_call") {
					$sql .= " AND cdr.call_status = 'DROP' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "agent_name") {
					$sql .= "  AND  admin.full_name <> '' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "in_bound") {
					$sql .= "  AND  cdr.call_type = 'INBOUND' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "out_bound") {
					$sql .= " AND cdr.call_type = 'OUTBOUND' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				} else {
					$sql .= "  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
				}
			} else if (!empty($fdate) && !empty($tdate) && !empty($keywords)) {
				//$sql.= " AND clid = '".$keywords."' or uniqueid = '".$keywords."' or uniqueid = '".$keywords."' AND DATE(calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				if ($search_keyword == "caller_id") {
					$sql .= " AND cdr.clid = '" . $keywords . "' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				/*if($search_keyword == "customer_id")
				{
					$sql.= " ";
					
				}*/
				if ($search_keyword == "call-track_id") {
					$sql .= "  AND cdr.uniqueid = '" . $keywords . "' AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				/*if($search_keyword == "call_status")
				{
					$sql.= "  ";
				}*/
				if ($search_keyword == "agent_name") {
					$sql .= "  AND  admin.full_name =  UPPER('" . $keywords . "') AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "off_time") {
					$sql .= "  AND  cdr.call_status = 'OFFTIME' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "ans_call") {
					$sql .= "  AND  cdr.call_status = 'ANSWERED' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "drop_call") {
					$sql .= "  AND  cdr.call_status = 'DROP' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "in_bound") {
					$sql .= "  AND  cdr.call_type = 'INBOUND' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
				if ($search_keyword == "out_bound") {
					$sql .= "  AND  cdr.call_type =  'OUTBOUND' AND cdr.clid = '" . $keywords . "'  AND DATE(cdr.calldate) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')  ";
				}
			} else {
				$sql .= " AND DATE(cdr.calldate) = DATE(NOW())  ";
			}
			if (!empty($alpha)) {
				$sql .= "and (src like '" . $alpha . "%' or cdr.uniqueid like '" . $alpha . "%')";
			}
			//$sql.= "and (cdr.channel LIKE '%DAHDI%') or (cdr.dstchannel LIKE '%DAHDI%')";
			$sql .= " order by $field $order";
			//$sql.= " limit $startRec, $totalRec";
			if ($isexport == 0) {
				//echo("<br>".$sql); exit;
			}
			//echo("<br>".$sql);//exit;
			$rs = $db_conn->Execute($sql);

			//exit;
			return $rs;
		}

		/****************** Agent Work times ***************************/
		function get_agent_work_times_15_3_16($admin_id = 0, $date)
		{
			global $db_conn;
			global $db_prefix;

			$sql = "SELECT count(*) AS trec, TIME(MIN(login_datetime)) AS login_time,staff_id,
					TIME(MAX(logout_datetime))  AS logout_time, 
					TIMEDIFF(MAX(logout_datetime),MIN(login_datetime))  AS duration
					FROM cc_login_activity 
					WHERE 1=1  ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= "AND DATE(login_datetime)='" . $date . "' AND DATE(logout_datetime)='" . $date . "' GROUP BY login_datetime";
			//echo $sql;
			//echo("<br>".$sql); //exit; is query mai group by dala hai and staff_id
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function get_agent_work_times($admin_id = 0, $date, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			//$sql = "SELECT time(MIN(login_datetime)) as login_time, time(MAX(logout_datetime)) as logout_time, TIMEDIFF(MAX(logout_datetime),MIN(login_datetime)) as duration FROM ".$db_prefix."_login_activity WHERE 1=1 ";
			$sql = "SELECT count(*) AS trec, TIME(MIN(login_datetime)) AS login_time,staff_id,
					TIME(MAX(logout_datetime)) AS max_logout_time, 
					CASE TIME(MAX(login_datetime)) WHEN  TIME(MAX(logout_datetime)) THEN TIME(NOW()) 
					ELSE TIME(MAX(logout_datetime))
					END 
					AS logout_time, 
					CASE TIME(MAX(login_datetime)) WHEN   TIME(MAX(logout_datetime)) THEN TIMEDIFF(NOW(), MIN(login_datetime)) 
					ELSE TIMEDIFF(MAX(logout_datetime),MIN(login_datetime)) 
					END AS duration 
					FROM cc_login_activity 
					WHERE 1=1  ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' ";
			$sql .= "AND DATE(update_datetime) BETWEEN '" . $date . "' AND '" . $tdate . "' GROUP BY login_datetime Order by login_time desc";
			//echo $sql;
			//echo("<br>".$sql); //exit; is query mai group by dala hai and staff_id
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function get_agent_work_times_new_live($admin_id = 0, $fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT count(*) AS trec,
		 				MIN(login_datetime) AS login_time,staff_id,
						MAX(logout_datetime) AS max_logout_time,
						CASE MAX(login_datetime) WHEN  MAX(logout_datetime) THEN NOW()
						ELSE MAX(logout_datetime)
						END
						AS logout_time,
						CASE MAX(login_datetime) WHEN   MAX(logout_datetime) THEN TIMEDIFF(NOW(), MIN(login_datetime))
						ELSE TIMEDIFF(MAX(logout_datetime),MIN(login_datetime))
						END AS duration
						FROM cc_login_activity
						WHERE 1=1  ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' ";
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE_FORMAT(login_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') GROUP BY login_datetime";
			} else {
				$sql .= " AND DATE(login_datetime) = Date(Now()) GROUP BY login_datetime";
			}

			$rs = $db_conn->Execute($sql);
			return $rs;
		}


		/****************** Agent Break times ***************************/
		function get_agent_break_times($admin_id = 0, $date)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT time(start_datetime) as start_time,staff_id,time(end_datetime) as end_time,TIMEDIFF(end_datetime, start_datetime) AS duration,STATUS as crm_status FROM " . $db_prefix . "_crm_activity WHERE 1=1 ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' ";
			$sql .= "AND DATE(update_datetime)='" . $date . "'";
			$sql .= " AND STATUS <> 6 ";
			$sql .= " AND STATUS <> 1 ";
			$sql .= "AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";

			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		function get_agent_break_times_sum($admin_id = 0, $fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) AS duration,STATUS as crm_status FROM " . $db_prefix . "_crm_activity WHERE 1=1 ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' 	";
			$sql .= "AND DATE(update_datetime) BETWEEN '" . $fdate . "' AND '" . $tdate . "'";
			$sql .= " AND STATUS <> 6 ";
			$sql .= " AND STATUS <> 1 ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			$sql .= " GROUP BY status ";
			//echo $sql;
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		/****************** Agent Break times sum***************************/

		function get_agent_break_times_new_live($admin_id = 0, $date, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT start_datetime as start_time,staff_id,end_datetime as end_time,TIMEDIFF(end_datetime, start_datetime) AS duration,STATUS as crm_status FROM " . $db_prefix . "_crm_activity WHERE 1=1 ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' ";
			$sql .= "AND DATE(update_datetime) BETWEEN '" . $date . "' AND '" . $tdate . "'";
			$sql .= " AND STATUS <> 6 ";
			$sql .= " AND STATUS <> 1 ";
			$sql .= "AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";

			//echo("<br>".$sql); exit;    
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_all_breaks($search_keyword, $fdate, $tdate, $stime, $etime, $status)
		{
			global $db_conn;
			global $db_prefix;
			$sql = "SELECT staff_id, 
							start_datetime,
							Date(start_datetime) as date,
							Time(start_datetime) as time,
							status,
							SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) AS duration
							FROM " . $db_prefix . "_crm_activity WHERE 1=1 ";
			if ($search_keyword != 0) {
				$sql .= " AND staff_id ='" . $search_keyword . "'";
			}

			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' 	";

			$sql .= " AND Date(update_datetime) >= Date('$fdate') AND Date(update_datetime) <= Date('$tdate')";
			$sql .= " AND Time(update_datetime) >= Time('$stime') AND Time(update_datetime) <= Time('$etime')";

			$sql .= " AND STATUS = '$status' ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			$sql .= " GROUP BY status ";
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_all_breaks_sum($search_keyword, $fdate, $tdate, $stime, $etime)
		{
			global $db_conn;
			global $db_prefix;
			$sql = "SELECT  
							SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) AS duration
							FROM " . $db_prefix . "_crm_activity WHERE 1=1 ";
			if ($search_keyword != 0) {
				$sql .= " AND staff_id ='" . $search_keyword . "'";
			}

			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' 	";

			$sql .= " AND Date(update_datetime) >= Date('$fdate') AND Date(update_datetime) <= Date('$tdate')";
			$sql .= " AND Time(update_datetime) >= Time('$stime') AND Time(update_datetime) <= Time('$etime')";

			$sql .= " AND STATUS <> 1 AND STATUS <> 7 ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function get_agent_break_times_sum_nopara()
		{
			global $db_conn;
			global $db_prefix;
			$sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) AS duration,STATUS as crm_status FROM " . $db_prefix . "_crm_activity WHERE 1=1 ";

			$sql .= " AND staff_id <> '9030' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' 	";
			$sql .= "AND DATE(update_datetime) = Date(NOW())";
			$sql .= " AND STATUS <> 6 ";
			$sql .= " AND STATUS <> 1 ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			$sql .= " GROUP BY status ";
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		/****************** Agent Assignment times ***************************/
		function get_agent_assignment_times($admin_id = 0, $date)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT 'ACW' as assignment,staff_id, time(start_datetime) as start_time, time(end_datetime) as end_time, TIMEDIFF(end_datetime, start_datetime) AS duration, STATUS as crm_status FROM " . $db_prefix . "_crm_activity WHERE 1=1 ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9036' AND staff_id <> '9035'  ";
			$sql .= " AND DATE(update_datetime)='" . $date . "'";
			$sql .= " AND STATUS = 6 ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			//echo $sql;
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		function get_agent_hold_times_new_live($admin_id = 0, $date, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT DISTINCT unique_id, staff_id, caller_id from cc_hold_calls WHERE 1=1 ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9036' AND staff_id <> '9035'  ";
			$sql .= " AND DATE(update_datetime) BETWEEN '" . $date . "' AND '" . $tdate . "'";
			//echo $sql;
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		function get_agent_hold_times_new_live_times($uniqueid)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "select SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) as hold_time from cc_hold_calls where 1=1 ";
			if ($uniqueid != 0) {
				$sql .= " AND unique_id='" . $uniqueid . "'";
			}
			//echo $sql;  
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		function get_agent_hold_times_new_live_agents($adminid = 0, $date, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "select SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) as hold_time from cc_hold_calls where 1=1 ";
			if ($adminid != 0) {
				$sql .= " AND staff_id='" . $adminid . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9036' AND staff_id <> '9035'  ";
			$sql .= " AND DATE(update_datetime) BETWEEN '" . $date . "' AND '" . $tdate . "'";
			//echo $sql;
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		function get_agent_hold_calls($adminid = 0, $date, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "select COUNT(DISTINCT unique_id) as hold_calls from cc_hold_calls where 1=1 ";
			if ($adminid != 0) {
				$sql .= " AND staff_id='" . $adminid . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9036' AND staff_id <> '9035'  ";
			$sql .= " AND DATE(update_datetime) BETWEEN '" . $date . "' AND '" . $tdate . "'";
			//echo $sql;
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		function get_agent_assignment_times_new_live($admin_id = 0, $date, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT 'ACW' as assignment,staff_id, start_datetime as start_time, end_datetime as end_time, TIMEDIFF(end_datetime, start_datetime) AS duration, STATUS as crm_status FROM " . $db_prefix . "_crm_activity WHERE 1=1 ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035'  ";
			$sql .= " AND DATE(update_datetime) BETWEEN '" . $date . "' AND '" . $tdate . "'";
			$sql .= " AND STATUS = 6 ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			//echo $sql;              
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}


		/****************** Agent On Call and Busy times ***************************/
		function get_agent_on_call_busy_times($admin_id = 0, $date)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT count(*) as cnt,staff_id, call_type,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(staff_end_datetime,staff_start_datetime)))) AS call_duration,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(dequeue_datetime,staff_end_datetime)))) AS busy_duration
FROM " . $db_prefix . "_queue_stats
WHERE 1=1 AND call_type!='' ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' ";
			$sql .= "AND DATE(dequeue_datetime)='" . $date . "' ";
			$sql .= "AND call_status='ANSWERED' ";
			//$sql .= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";  // added condtions 6-3-16
			$sql .= "GROUP BY staff_id,call_type ";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			//echo $sql;
			return $rs;
		}

		function get_agent_on_call_busy_times_new_live($admin_id = 0, $date, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT count(*) as cnt,staff_id,call_type,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(staff_end_datetime,staff_start_datetime)))) AS call_duration,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(dequeue_datetime,staff_end_datetime)))) AS busy_duration
FROM " . $db_prefix . "_queue_stats  
WHERE 1=1 AND call_type!='' ";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' ";
			$sql .= "AND DATE(call_datetime) BETWEEN'" . $date . "' AND '" . $tdate . "'";
			$sql .= "AND call_status='ANSWERED' ";
			//$sql .= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";  // added condtions 6-3-16
			$sql .= "GROUP BY staff_id,call_type ";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;    
			//echo $sql;
			return $rs;
		}

		function get_agent_on_call_busy_times_new_live2($admin_id = 0, $date, $tdate)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT count(*) as cnt,staff_id,call_type,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(staff_end_datetime,staff_start_datetime)))) AS call_duration,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(dequeue_datetime,staff_end_datetime)))) AS busy_duration
FROM " . $db_prefix . "_queue_stats
WHERE 1=1 AND call_type='INBOUND' AND staff_id!=''";
			if ($admin_id != 0) {
				$sql .= "AND staff_id ='" . $admin_id . "'";
			}
			$sql .= " AND staff_id <> '9030' AND staff_id <> '9031' AND staff_id <> '9039' AND staff_id <> '9036' AND staff_id <> '9035' ";
			$sql .= "AND DATE(dequeue_datetime) BETWEEN'" . $date . "' AND '" . $tdate . "'";
			$sql .= "AND call_status='DROP' ";
			//$sql .= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";  // added condtions 6-3-16
			$sql .= "GROUP BY staff_id,call_type ";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			//echo $sql;
			return $rs;
		}

		/******************************** get agent abandoned calls *******************************************/
		function get_agent_abandon_calls($admin_id = 0, $date)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT count(*) as trec
FROM " . $db_prefix . "_abandon_calls
WHERE 1=1 ";
			//if(!empty($admin_id)){
			$sql .= " AND staff_id ='" . $admin_id . "'";
			//}
			$sql .= " AND DATE(update_datetime)='" . $date . "' ";
			//$sql.= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";
			//$sql.= "GROUP BY call_type ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['trec'];
		}

		/********************************************************** Agent Performance Report *********************************************************************/
		/******************* get evaluation groups ******************************/
		function get_evaluation_groups()
		{
			global $db_conn;
			global $db_prefix;
			$sql = "SELECT *  FROM " . $db_prefix . "_evaluation_groups WHERE 1=1 ";
			$sql .= " AND status = '1' ";
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);

			return $rs;
		}
		/******************* get Question List **********************************/

		function get_evaluation_group_question($search_keyword, $fdate, $tdate)
		{
			global $db_conn;
			global $db_prefix;
			/*$sql = "SELECT  question,G.id, group_name, Q.group_id  FROM ".$db_prefix."_evaluation_questions  Q INNER JOIN  ".$db_prefix."_evaluation_groups  G ON group_id = G.id ";
			$sql.= "AND Q.status = '1' ";*/
			//$sql = "SELECT Question, Qgroup ,SUM(Epoints), SUM(Qcount), SUM(Maxpoints), ROUND(SUM(Epoints) / SUM(Maxpoints) * 100)
			$sql = "SELECT Question, question_code,Qgroup ,SUM(Epoints), SUM(Qcount), SUM(Maxpoints), ROUND(SUM(Epoints) / SUM(Maxpoints) * 100)	as Percent,
			SUM(IF(points_type='yes',Qcount,0)) AS Yes,
  			SUM(IF(points_type='no',Qcount,0)) AS 'No',
  			SUM(IF(points_type='nimp',Qcount,0)) AS nimp,
  			SUM(IF(points_type='na',Qcount,0)) AS NA,
  			COUNT(DISTINCT WEEK)AS week_count
					FROM cc_vu_evaluation
					WHERE evaluate_agent_id = '" . $search_keyword . "'
					AND CallDate BETWEEN '" . $fdate . "' AND '" . $tdate . "'
					GROUP BY Question, Qgroup ORDER BY Qgroup ASC";
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		//SELECT COUNT(DISTINCT admin_id) AS agent_id FROM cc_evaluation WHERE evaluate_agent_id = '9027' AND update_datetime BETWEEN '2012-01-25' AND '2012-01-26'
		/******************* get Evaluator Count **********************************/

		function get_evaluator_count($search_keyword, $fdate, $tdate)
		{
			global $db_conn;
			global $db_prefix;
			/*$sql = "SELECT  question,G.id, group_name, Q.group_id  FROM ".$db_prefix."_evaluation_questions  Q INNER JOIN  ".$db_prefix."_evaluation_groups  G ON group_id = G.id ";
			$sql.= "AND Q.status = '1' ";*/
			//$sql = "SELECT Question, Qgroup ,SUM(Epoints), SUM(Qcount), SUM(Maxpoints), ROUND(SUM(Epoints) / SUM(Maxpoints) * 100)
			$sql = "SELECT COUNT(DISTINCT admin_id) AS count FROM cc_vu_evaluation WHERE evaluate_agent_id = '" . $search_keyword . "' AND date(CallDate) BETWEEN date('" . $fdate . "') AND date('" . $tdate . "') ";
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields["count"];
			//return $rs;
		}
		//SELECT call_type, COUNT(call_type), COUNT(no_of_questions)
		//FROM cc_vu_evaluated_calls
		//WHERE staff_id = '9027'
		//AND update_datetime BETWEEN '2012-01-05' AND '2012-01-26'   
		//GROUP BY call_type
		/******************* get Evaluator Count **********************************/

		function get_evaluated_calls_count($search_keyword, $fdate, $tdate)
		{
			global $db_conn;
			global $db_prefix;
			/*$sql = "SELECT call_type, COUNT(call_type) as call_taken, COUNT(no_of_questions) as evaluated_call
			FROM cc_vu_evaluated_calls
			WHERE staff_id = '".$search_keyword."'
			AND update_datetime BETWEEN '".$fdate."' AND '".$tdate."'   
			GROUP BY call_type";*/
			$sql = "SELECT SUM(IF(call_type='INBOUND' AND no_of_questions IS NULL,1,0)) AS UN_InBound, SUM(IF(call_type='OUTBOUND' AND no_of_questions IS NULL,1,0)) AS UN_OutBound, ";
			$sql .= "SUM(IF(call_type='INBOUND' AND no_of_questions IS NOT NULL,1,0)) AS InBound, SUM(IF(call_type='OUTBOUND' AND no_of_questions IS NOT NULL,1,0)) AS OutBound ";
			$sql .= "FROM cc_vu_evaluated_calls ";
			$sql .= "WHERE staff_id = '" . $search_keyword . "' AND AND DATE_FORMAT(update_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s')";
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			// 
			//return $rs->fields["count"];
			return $rs;
		}

		function get_evaluator_list()
		{
			global $db_conn;
			global $db_prefix;
			$sql = "SELECT full_name, admin_id FROM " . $db_prefix . "_admin WHERE group_id = '1' ";
			//$sql.= " LIMIT 0,5";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		function call_scoring($unique_id, $admin_id)
		{
			global $db_conn;
			global $db_prefix;

			//		$sql = "SELECT question_no,question_code, admin_id , Qgroup, Percent as percent FROM cc_vu_evaluation
			//				WHERE unique_id = '".$unique_id."'  AND admin_id ='".$admin_id."'
			//				GROUP BY admin_id,Qgroup, question_no ";

			$sql = "SELECT
				  question_no,
				  question_code,
				  admin_id,
				  Qgroup,
				  points_type,
				  Percent       AS percent
				FROM cc_vu_evaluated_agents
				WHERE unique_id = '" . $unique_id . "' AND admin_id ='" . $admin_id . "'
				ORDER BY question_no";

			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function get_question_list()
		{
			global $db_conn;
			global $db_prefix;
			$sql = "SELECT question_code, question FROM " . $db_prefix . "_evaluation_questions WHERE status = '1' ";

			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		//******************** call center Reports *************************/
		function nature_of_calls($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			/*********************************With Time************************************/

			$sql = "SELECT call_type,
						COUNT(DISTINCT unique_id) AS total_calls ,
								(SELECT COUNT(DISTINCT unique_id) FROM cc_queue_stats
                WHERE call_type!='' AND
                call_status='ANSWERED' and
                call_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'
										) AS total,
								COUNT(DISTINCT unique_id)/
							(SELECT COUNT(DISTINCT unique_id) FROM cc_queue_stats
							WHERE call_type!='' AND
											call_status='ANSWERED' and
							call_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'
							) * 100 AS percent
							FROM cc_queue_stats
							WHERE call_type!='' AND
							call_status='ANSWERED' and
							call_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'
							GROUP BY call_type";

			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function drop_calls($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			/*********************************With out Time************************************/

			/*SELECT * FROM cc_cdr WHERE (DATE(calldate)BETWEEN DATE('2012-02-08')
    AND DATE('2012-02-09')) AND call_status = 'DROP';*/

			//    $sql ="SELECT COUNT(DISTINCT unique_id) AS drop_calls FROM cc_queue_stats WHERE 1=1 ";
			//    $sql.=" AND (TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) = '00:00:00' OR staff_id IS NULL)"; 
			//	if(!empty($fdate) && !empty($tdate)){
			//	$sql.= " AND date(dequeue_datetime) Between  date('".$fdate."') AND  date('".$tdate."') AND status = 0 ";
			//	}else{
			//	$sql.= " AND DATE(dequeue_datetime) = DATE(NOW()) AND status = 0 ";
			//	}
			//	$sql.= " AND call_type = 'INBOUND'";


			/*********************************With Time************************************/

			$sql = "SELECT COUNT(DISTINCT unique_id) AS drop_calls FROM cc_queue_stats WHERE 1=1 ";
			$sql .= " AND call_status='DROP'";
			//if(!empty($fdate) && !empty($tdate)){
			$sql .= " AND dequeue_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "' AND status = 0 ";
			$sql .= " AND (call_status <> 'IVR' AND call_status <> 'OFFTIME')";
			//}else{
			//$sql.= " AND DATE(dequeue_datetime) = DATE(NOW()) AND status = 0 ";
			//}
			$sql .= " AND call_type = 'INBOUND'";
			//echo $sql; exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function off_time_calls($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			//    $sql = "SELECT call_status, COUNT(DISTINCT uniqueid) as off_calls FROM cc_cdr
			//    WHERE
			//    date(calldate) Between  date('".$fdate."') AND  date('".$tdate."') AND
			//    call_status = 'OFFTIME'
			//    GROUP BY call_status";

			/*
    $sql = "SELECT call_status, COUNT(DISTINCT uniqueid) as off_calls FROM cc_cdr
    WHERE
    calldate Between  '".$fdate."' AND  '".$tdate."' AND
    call_status = 'OFFTIME'
    GROUP BY call_status";
*/

			$sql = "SELECT call_status, COUNT(DISTINCT unique_id) AS off_calls FROM cc_queue_stats 
    WHERE
    dequeue_datetime BETWEEN  '" . $fdate . "' AND  '" . $tdate . "' AND
    call_status = 'OFFTIME' 
    GROUP BY call_status";
			//echo $sql;
			//echo $sql; //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		function abandon_new_calls($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			$sql = "SELECT COUNT(DISTINCT unique_id) AS abandon_calls FROM cc_queue_stats
    WHERE
    dequeue_datetime BETWEEN  '" . $fdate . "' AND  '" . $tdate . "' AND
    call_status = 'ABANDONED'
    GROUP BY call_status";
			//echo $sql;
			//echo $sql; //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}



		function total_talk_time($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			/*********************************With out Time************************************/
			//    $sql = "SELECT call_type, 
			//COUNT(DISTINCT unique_id) AS no_of_calls, (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))) AS talk_time
			//FROM cc_queue_stats
			//WHERE
			//TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> '00:00:00' AND
			//date(dequeue_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')) AS total_time,
			//SEC_TO_TIME(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))) AS talk_time
			//FROM cc_queue_stats
			//WHERE
			//TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> '00:00:00' AND
			//    date(dequeue_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')
			//    GROUP BY call_type";

			/*********************************With Time************************************/
			$sql = "SELECT call_type, 
COUNT(DISTINCT unique_id) AS no_of_calls, (SELECT TIME(SEC_TO_TIME(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime)))))) AS talk_time
FROM cc_queue_stats
WHERE call_type!='' AND
TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> '00:00:00' AND
dequeue_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "') AS total_time,
SEC_TO_TIME(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))) AS talk_time
FROM cc_queue_stats
WHERE call_type!='' AND
TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> '00:00:00' AND
    dequeue_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'
    GROUP BY call_type";
			//echo $sql; exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		function avg_total_talk_time($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			/*********************************With out Time************************************/
			//    $sql = "SELECT call_type, 
			//COUNT(DISTINCT unique_id) AS no_of_calls, (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))) AS talk_time
			//FROM cc_queue_stats
			//WHERE
			//TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> '00:00:00' AND
			//date(dequeue_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')) AS total_time,
			//SEC_TO_TIME(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))/COUNT(DISTINCT unique_id)) AS talk_time
			//FROM cc_queue_stats
			//WHERE
			//TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> '00:00:00' AND
			//    date(dequeue_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')
			//    GROUP BY call_type";

			/*********************************With Time************************************/
			$sql = "SELECT call_type, 
COUNT(DISTINCT unique_id) AS no_of_calls, (SELECT SEC_TO_TIME(ROUND(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime)))))) AS talk_time
FROM cc_queue_stats
WHERE call_type!='' AND
TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> '00:00:00' AND
dequeue_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "') AS total_time,
SEC_TO_TIME(ROUND(SUM(TIME_TO_SEC(TIME(TIMEDIFF(staff_end_datetime,staff_start_datetime))))/COUNT(DISTINCT unique_id))) AS talk_time
FROM cc_queue_stats
WHERE call_type!='' AND
TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> '00:00:00' AND
    dequeue_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'
    GROUP BY call_type";
			//echo $sql; exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}


		function busy_time($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			/*********************************With out Time************************************/
			//    $sql = "SELECT Q.call_type ,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(Q.dequeue_datetime , L.dequeue_datetime)))) AS busy_time
			//    FROM cc_queue_stats Q
			//    INNER JOIN cc_queue_stats_logs L
			//               ON Q.unique_id = L.unique_id
			//                  AND Q.staff_id = L.staff_id
			//    WHERE L.status = '-1'
			//      AND Q.status = '0' AND
			//      date(Q.dequeue_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')
			//    GROUP BY Q.call_type";

			/*********************************With Time************************************/
			$sql = "SELECT Q.call_type ,TIME(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(Q.dequeue_datetime , L.dequeue_datetime))))) AS busy_time
    FROM cc_queue_stats Q
    INNER JOIN cc_queue_stats_logs L
               ON Q.unique_id = L.unique_id
                  AND Q.staff_id = L.staff_id
    WHERE L.status = '-1'
      AND Q.status = '0' AND
      Q.dequeue_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'
    GROUP BY Q.call_type";
			//echo $sql; exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		function avg_busy_time($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			/*********************************With out Time************************************/
			//    $sql = "SELECT Q.call_type ,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(Q.dequeue_datetime , L.dequeue_datetime)))/ COUNT(*)) AS AvgBusyTime
			//    FROM cc_queue_stats Q
			//    INNER JOIN cc_queue_stats_logs L
			//               ON Q.unique_id = L.unique_id
			//                  AND Q.staff_id = L.staff_id
			//    WHERE L.status = '-1'
			//      AND Q.status = '0' AND
			//      date(Q.dequeue_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')
			//    GROUP BY Q.call_type";

			/*********************************With Time************************************/
			$sql = "SELECT Q.call_type ,SEC_TO_TIME(ROUND(SUM(TIME_TO_SEC(TIMEDIFF(Q.dequeue_datetime , L.dequeue_datetime)))/ COUNT(*))) AS AvgBusyTime
    FROM cc_queue_stats Q
    INNER JOIN cc_queue_stats_logs L
               ON Q.unique_id = L.unique_id
                  AND Q.staff_id = L.staff_id
    WHERE L.status = '-1'
      AND Q.status = '0' AND
      Q.dequeue_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'
    GROUP BY Q.call_type";
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function average_queue_time($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			/*********************************With out Time************************************/
			//    $sql = "SELECT
			//    SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(TIME(dequeue_datetime),TIME(enqueue_datetime))))) as avg_queu_time
			//    FROM cc_queue_stats
			//    WHERE
			//    TIMEDIFF(dequeue_datetime,enqueue_datetime) <> '00:00:00' AND TIMEDIFF(dequeue_datetime,enqueue_datetime) > '00:00:10' AND
			//    date(dequeue_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')";

			/*********************************With Time************************************/
			$sql = "SELECT
    SEC_TO_TIME(AVG(TIME_TO_SEC(TIMEDIFF(TIME(dequeue_datetime),TIME(enqueue_datetime))))) as avg_queu_time
    FROM cc_queue_stats
    WHERE
    TIMEDIFF(dequeue_datetime,enqueue_datetime) <> '00:00:00' AND TIMEDIFF(dequeue_datetime,enqueue_datetime) > '00:00:10' AND
    dequeue_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'";

			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function pin_report($fdate, $tdate)
		{
			global $db_conn;
			global $db_prefix;

			/*********************************With out Time************************************/
			//    $sql = "
			//	SELECT 	pin_type, 
			//	COUNT(pin_type) AS no_pins, 
			//	ROUND(COUNT(pin_type)/(SELECT COUNT(pin_type) FROM cc_vu_pins_report WHERE  update_datetime BETWEEN '".$fdate."' AND '".$tdate."') * 100, 2) AS percent,
			//	(SELECT COUNT(pin_type) FROM cc_vu_pins_report WHERE date(update_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')) as total
			//FROM cc_vu_pins_report
			//WHERE date(update_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')
			//GROUP BY pin_type ";

			/*********************************With Time************************************/
			$sql = "
	SELECT 	pin_type, 
	COUNT(pin_type) AS no_pins, 
	ROUND(COUNT(pin_type)/(SELECT COUNT(pin_type) FROM cc_vu_pins_report WHERE update_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "') * 100, 2) AS percent,
	(SELECT COUNT(pin_type) FROM cc_vu_pins_report WHERE update_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "') as total
FROM cc_vu_pins_report
WHERE update_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'
GROUP BY pin_type ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}


		function trans_report($fdate, $tdate)
		{
			global $db_conn;
			global $db_prefix;

			/*********************************With out Time************************************/
			//    $sql = "SELECT 	trans_type, 
			//	COUNT(trans_type) AS no_trans, 
			//	ROUND(COUNT(trans_type)/(SELECT COUNT(trans_type) FROM cc_vu_transactions WHERE  update_datetime BETWEEN '".$fdate."' AND '".$tdate."') * 100, 2) AS percent,
			//	(SELECT COUNT(trans_type) FROM cc_vu_transactions WHERE  date(update_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')) as total
			//FROM cc_vu_transactions
			//WHERE date(update_datetime) BETWEEN date('".$fdate."') AND date('".$tdate."')
			//GROUP BY trans_type ";

			/*********************************With Time************************************/
			$sql = "SELECT 	trans_type, 
	COUNT(trans_type) AS no_trans, 
	ROUND(COUNT(trans_type)/(SELECT COUNT(trans_type) FROM cc_vu_transactions WHERE  update_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "') * 100, 2) AS percent,
	(SELECT COUNT(trans_type) FROM cc_vu_transactions WHERE  update_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "') as total
FROM cc_vu_transactions
WHERE update_datetime BETWEEN '" . $fdate . "' AND '" . $tdate . "'
GROUP BY trans_type ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		/*************************************** Dropped Calls Report *******************/

		function avg_waiting_time($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			$sql = "SELECT
    COUNT(*) AS trec,
    SUM(TIME_TO_SEC(TIMEDIFF(t1.dequeue_datetime, t1.enqueue_datetime))) AS total_waiting_time_sec,
    SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(t1.dequeue_datetime, t1.enqueue_datetime)))/COUNT(*)) AS avg_wait_time
    FROM cc_vu_queue_stats AS t1  WHERE 1=1 ";
			$sql .= " AND (TIMEDIFF(t1.staff_end_datetime,t1.staff_start_datetime) = '00:00:00' OR t1.staff_id IS NULL)";
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE(t1.dequeue_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') AND status = 0 ";
			} else {
				$sql .= " AND DATE(t1.dequeue_datetime) = DATE(NOW()) AND status = 0  ";
			}
			$sql .= " AND t1.call_type = 'INBOUND' AND (t1.call_status <> 'IVR' AND t1.call_status <> 'OFFTIME')";

			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); //exit;
			return $rs;
		}

		function get_agent_list()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT full_name, admin_id FROM " . $db_prefix . "_admin WHERE group_id = '2' AND status = '1' ";
			//$sql.= " LIMIT 0,5";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		function get_dropped_calls_details($fdate, $tdate, $startRec = '', $totalRec = '')
		{

			global $db_conn;
			global $db_prefix;

			$sql = "SELECT *, t1.staff_id AS STAFF_ID, TIME(t1.call_datetime) AS CALLTIME, TIME(t1.enqueue_datetime) AS ENQUEUETIME, t1.enqueue_datetime AS ENQUEUE_DATETIME,DATE(t1.update_datetime) AS UPDATEDATE, t1.update_datetime AS update_datetime, TIMEDIFF(t1.update_datetime, t1.enqueue_datetime) AS WAIT_IN_QUEUE ,t1.unique_id as unique_id FROM cc_queue_stats AS t1  WHERE 1=1 ";
			$sql .= "AND (TIMEDIFF(t1.staff_end_datetime,t1.staff_start_datetime) = '00:00:00' OR t1.staff_id IS NULL) ";
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND (DATE(t1.update_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')) AND t1.status = 0  ";
			} else {
				$sql .= " AND DATE(t1.update_datetime) = DATE(NOW()) AND t1.status = 0  ";
			}
			$sql .= " AND t1.call_type = 'INBOUND'  AND (t1.call_status <> 'IVR' AND t1.call_status <> 'OFFTIME')  ORDER BY t1.id DESC";
			$sql .= " limit $startRec, $totalRec";


			/*$sql = " SELECT *, Time(enqueue_datetime) as time, Date(update_datetime) as date, TIMEDIFF(dequeue_datetime,enqueue_datetime) AS duration FROM cc_queue_stats WHERE  1=1 ";
	//$sql.= " AND HOUR(dequeue_datetime)-1  "; //AND STATUS <> '-1'";
	$sql.= " AND (TIMEDIFF(staff_end_datetime,staff_start_datetime) = '00:00:00' OR staff_id IS NULL)";
	if(!empty($fdate) && !empty($tdate)){
	$sql.= " AND (DATE(dequeue_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')) AND status = 0  ";
	}else{
	$sql.= " AND DATE(dequeue_datetime) = DATE(NOW()) AND status = 0  ";
	}
	$sql.= " AND call_type = 'INBOUND'  ORDER BY id DESC";//" order by $field $order";
	//$sql.= " LIMIT 5";//" limit $startRec, $totalRec";*/

			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);

			return $rs;
		}
		function drop_calls2($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;


			/*SELECT * FROM cc_cdr WHERE (DATE(calldate)BETWEEN DATE('2012-02-08')
    AND DATE('2012-02-09')) AND call_status = 'DROP';*/

			$sql = "SELECT COUNT(DISTINCT unique_id) AS drop_calls FROM cc_vu_queue_stats WHERE 1=1 ";
			$sql .= " AND (TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) = '00:00:00' OR staff_id IS NULL)";
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND date(dequeue_datetime) Between  date('" . $fdate . "') AND  date('" . $tdate . "') AND status = 0 ";
			} else {
				$sql .= " AND DATE(dequeue_datetime) = DATE(NOW()) AND status = 0 ";
			}
			$sql .= " AND call_type = 'INBOUND'   AND (call_status <> 'IVR' AND call_status <> 'OFFTIME')";
			//echo $sql; exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function get_drop_calls_records_count($fdate, $tdate)
		{

			global $db_conn;
			global $db_prefix;

			$sql = "SELECT COUNT(*) AS trec FROM cc_queue_stats AS t1  WHERE 1=1 ";
			$sql .= "AND (TIMEDIFF(t1.staff_end_datetime,t1.staff_start_datetime) = '00:00:00' OR t1.staff_id IS NULL) ";
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND (DATE(t1.dequeue_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "')) AND t1.status = 0  ";
			} else {
				//$sql.= " AND DATE(t1.dequeue_datetime) = DATE(NOW()) AND t1.status = 0  ";
				$sql .= " AND DATE(t1.dequeue_datetime) = DATE(NOW()) AND t1.status = 0  ";
			}
			$sql .= " AND t1.call_type = 'INBOUND' AND (t1.call_status <> 'IVR' AND t1.call_status <> 'OFFTIME')  ORDER BY t1.id DESC";

			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs->fields['trec'];
		}

		/*function count_online_agents($fdate, $tdate) {

	global $db_conn; global $db_prefix;
	
	$sql = " SELECT COUNT(DISTINCT staff_id) AS count_agents FROM cc_crm_activity WHERE 1=1 ";
	$sql.= " AND STATUS = 1 ";
	if(!empty($fdate) && !empty($tdate)){
	$sql.= " AND DATE(update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."') ";
	}else{
	$sql.= " AND DATE(update_datetime) = DATE(NOW()) ";
	}
	
	$rs = $db_conn->Execute($sql);
	//echo("<br>".$sql); exit;
	return $rs;
}*/

		function agent_login_status($call_datetime, $staff_id)
		{

			global $db_conn;
			global $db_prefix;

			$sql = "SELECT login_datetime,COUNT(*) AS trec FROM cc_login_activity WHERE 1=1 ";
			$sql .= " AND (('" . $call_datetime . "' BETWEEN login_datetime AND logout_datetime)
		   	OR
			(DATE('" . $call_datetime . "') = DATE(login_datetime) AND STATUS = '2') ) ";
			//$sql.=" AND STATUS = 2";(TIME('".$update_datetime."')  >= TIME(login_datetime)
			$sql .= " AND staff_id = '" . $staff_id . "'";

			//new line added for getting correct login status of agent
			$sql .= " GROUP BY DATE(login_datetime)
HAVING TIME('" . $call_datetime . "') > TIME(MIN(login_datetime)) ";

			//echo("--".$sql."<br><br>");//exit;
			$rs = $db_conn->Execute($sql);

			//if (!empty($rs->fields['trec']) && $rs->fields['trec'] != 0){

			//echo("<br>if: ".$sql);//exit;
			//echo "<br> total rec: ".$rs->fields['trec'];
			return $rs->fields['trec'] . "|" . $rs->fields['login_datetime'];
			//}
			//else{
			//echo("<br>else: ".$sql);// exit;
			//	return FALSE;
			//}
		}


		function agent_status_details($fdate, $tdate, $call_datetime, $update_datetime, $staff_id)
		{ //agent_status_details($fdate, $tdate, $staff_id)

			global $db_conn;
			global $db_prefix;

			/*$sql = "SELECT t1.status AS AGENT_STATUS, t2.staff_id AS STAFF_ID, TIMEDIFF(TIME('".$call_datetime."'),TIME(t1.start_datetime)) AS status_duration , t2.update_datetime AS call_end_time FROM cc_crm_activity AS t1 INNER JOIN cc_queue_stats AS t2 ON t1.staff_id = t2.staff_id WHERE 1=1 "; 
	$sql.=" AND (('".$call_datetime."' 
				BETWEEN 
				t1.start_datetime
				AND
				t1.end_datetime)
			OR
				('".$update_datetime."'
				BETWEEN 
				t1.start_datetime
				AND
				t1.end_datetime))";
	$sql.=" AND t1.staff_id='".$staff_id."'";
	$sql.=" GROUP BY t2.staff_id";*/
			$sql = "SELECT t1.status AS AGENT_STATUS, TIMEDIFF(TIME('" . $call_datetime . "'),TIME(t1.start_datetime)) AS status_duration  
FROM cc_crm_activity AS t1 
	WHERE 1=1 ";
			$sql .= " AND (('" . $call_datetime . "' 
				BETWEEN 
				t1.start_datetime
				AND
				t1.end_datetime)
			OR
				('" . $update_datetime . "'
				BETWEEN 
				t1.start_datetime
				AND
				t1.end_datetime)
			OR
				(t1.start_datetime = t1.end_datetime AND DATE(t1.start_datetime) = DATE('" . $call_datetime . "'))
				)";
			$sql .= " AND t1.staff_id='" . $staff_id . "'";


			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);

			return $rs;
		}
		// time calculation for only login agents(CRM Status not changed yet)
		function agent_status_details_negative($fdate, $tdate, $call_datetime, $update_datetime, $staff_id)
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT t1.status AS AGENT_STATUS, TIMEDIFF(TIME('" . $call_datetime . "'),TIME(t1.login_datetime)) AS status_duration  
FROM cc_login_activity AS t1 
	WHERE 1=1 ";
			$sql .= " AND (('" . $call_datetime . "' 
				BETWEEN 
				t1.login_datetime
				AND
				t1.logout_datetime)
			OR
				('" . $update_datetime . "'
				BETWEEN 
				t1.login_datetime
				AND
				t1.logout_datetime)
			OR
				(t1.login_datetime = t1.logout_datetime AND DATE(t1.login_datetime) = DATE('" . $call_datetime . "'))
				)";
			$sql .= " AND t1.staff_id='" . $staff_id . "'";


			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);

			return $rs;
		}

		function is_abandonned($unique_id, $staff_id)
		{

			global $db_conn;
			global $db_prefix;

			$sql = "SELECT COUNT(*) AS trec FROM cc_abandon_calls WHERE unique_id = '" . $unique_id . "' AND staff_id = '" . $staff_id . "'";

			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);

			//if (!empty($rs->fields['trec']) && $rs->fields['trec'] != 0){

			//echo("<br>if: ".$rs->fields['trec']);//exit;

			return $rs->fields['trec'];

			//}
			//else{
			//echo("<br>else: ".$sql);// exit;
			//	return FALSE;
			//}

		}
		function get_agent_xxx($staff_id, $call_datetime, $update_datetime)
		{

			global $db_conn;
			global $db_prefix;

			//$sql = "SELECT *  FROM cc_admin_logs WHERE admin_id = '".$staff_id."' and last_call_datetime = '".$call_time."' and status = 1 limit 1";
			$sql = "SELECT  COUNT(c.is_busy) AS agent_count, c.is_busy as busy FROM cc_admin_status AS c
WHERE 1 = 1 ";
			$sql .= " AND ('" . $call_datetime . "' BETWEEN c.update_datetime AND ADDTIME(c.update_datetime,'00:00:02')) ";
			$sql .= " AND is_crm_login = '1' AND is_phone_login = '1' ";
			//$sql .= " AND (('".$call_datetime."' BETWEEN c.last_call_datetime AND c.staff_updated_date) ";
			//$sql .= " OR ('".$update_datetime."' BETWEEN c.last_call_datetime AND c.staff_updated_date)) ";
			$sql .= " AND c.admin_id = '" . $staff_id . "' ORDER BY c.update_datetime DESC  LIMIT 1";
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);

			//if (!empty($rs->fields['trec']) && $rs->fields['trec'] != 0){

			//echo("<br>if: ".$rs->fields['trec']);//exit;

			return $rs;

			//}
			//else{
			//echo("<br>else: ".$sql);// exit;
			//	return FALSE;
			//}

		}
		function get_agent($staff_id, $call_datetime, $update_datetime, $unique_id)
		{

			global $db_conn;
			global $db_prefix;

			//$sql = "SELECT *  FROM cc_admin_logs WHERE admin_id = '".$staff_id."' and last_call_datetime = '".$call_time."' and status = 1 limit 1";
			$sql = "SELECT  c.is_busy AS agent_count, c.is_busy as busy FROM cc_admin_status AS c
WHERE 1 = 1 ";
			// $sql .= " AND ('".$call_datetime."' > c.update_datetime AND date(c.update_datetime) = date('".$call_datetime."')) ";
			$sql .= " AND is_crm_login = '1' AND is_phone_login = '1' and call_id = '" . $unique_id . "'";
			//$sql .= " AND (('".$call_datetime."' BETWEEN c.last_call_datetime AND c.staff_updated_date) ";
			//$sql .= " OR ('".$update_datetime."' BETWEEN c.last_call_datetime AND c.staff_updated_date)) ";
			$sql .= " AND c.admin_id = '" . $staff_id . "' ORDER BY c.update_datetime DESC  LIMIT 1";
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);

			//if (!empty($rs->fields['trec']) && $rs->fields['trec'] != 0){

			//echo("<br>if: ".$rs->fields['trec']);//exit;

			return $rs;

			//}
			//else{
			//echo("<br>else: ".$sql);// exit;
			//      return FALSE;
			//}

		}


		/***************************** Work code report ************************************/
		// workcode old function

		function get_workcode_details($field = "staff_updated_date", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $where_in = '')
		{

			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			if ($isexport == true) {
				$db_export = $site_root . "download/Workcode_report_" . $today . ".csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//t1.staff_id
			$sql = "SELECT
  t1.unique_id,
  t1.caller_id,
  t2.customer_id,
  t2.call_type,
  GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes,
  t1.staff_updated_date,
  (SELECT
     full_name
   FROM cc_admin
   WHERE admin_id = t1.staff_id ORDER BY t1.id) AS agent_name,
  detail
  
 ";





			if ($isexport != true) {
				$sql .= " , t2.update_datetime  ";
			}

			$sql .= $csv . " FROM cc_vu_workcodes AS t1,
  cc_queue_stats AS t2

 "; //t1.caller_id = t2.caller_id
			// $sql .= "WHERE 1=1     AND t1.unique_id = t2.unique_id "; 
			$sql .= "WHERE 1=1     AND t1.unique_id = t2.unique_id  ";
			// 
			$sql .= " AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime) 
	    AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime)
   

	";

			if (!empty($keywords)) {

				if ($search_keyword == 'call-track_id') {

					$sql .= " AND t1.unique_id = '" . $keywords . "' ";
				}

				if ($search_keyword == 'caller_id') {

					$sql .= " AND t1.caller_id = '" . $keywords . "' ";
				}

				/*if ($search_keyword == 'workcode') {
		
			$sql .= " AND t1.workcodes = '".$keywords."' ";
		}*/

				if ($search_keyword == 'agent_name') {

					$sql1 = "SELECT admin_id FROM cc_admin WHERE full_name LIKE '%$keywords%'";
					//echo "<br>".$sql1;
					$rs1 		= $db_conn->Execute($sql1);
					$admin_id 	= $rs1->fields['admin_id'];

					$sql .= " AND t1.staff_id = '" . $admin_id . "' ";
				}
			}
			if (!empty($where_in)) {

				$sql .= " AND t1.workcodes IN (" . $where_in . ") ";
				//unset($_SESSION['workcodes']);
			}
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE_FORMAT(t1.staff_updated_date, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') ";
			}

			$sql .= "GROUP BY TIME(staff_updated_date)";
			$sql .= " order by $field $order ";
			//echo $sql;
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}





		// workcode new function by waleed


		function get_workcode_details_new($field = "staff_updated_date", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $level1, $level2, $level3, $level4, $level5)
		{

			global $db_conn;
			global $db_prefix;
			global $site_root;
			//	echo $level1.$level2.$level3.$level4.$level5;exit;
			$csv = '';
			if ($isexport == true) {
				$db_export = $site_root . "download/Workcode_report_" . $today . ".csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//t1.staff_id
			$sql = "SELECT  t1.unique_id, t1.caller_id, t2.customer_id, t2.call_type, GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes, t1.staff_updated_date, 
	(SELECT full_name FROM cc_admin WHERE admin_id = t1.staff_id ) AS agent_name ";

			if ($isexport != true) {
				$sql .= " , t2.update_datetime  ";
			}

			$sql .= $csv . " FROM cc_call_workcodes AS t1 INNER JOIN cc_queue_stats AS t2
ON t1.unique_id = t2.unique_id "; //t1.caller_id = t2.caller_id
			$sql .= "WHERE 1=1 ";
			$sql .= " AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime) ";

			if (!empty($keywords)) {

				if ($search_keyword == 'call-track_id') {

					$sql .= " AND t1.unique_id = '" . $keywords . "' ";
				}

				if ($search_keyword == 'caller_id') {

					$sql .= " AND t1.caller_id = '" . $keywords . "' ";
				}












				/*if ($search_keyword == 'workcode') {
		
			$sql .= " AND t1.workcodes = '".$keywords."' ";
		}*/

				if ($search_keyword == 'agent_name') {

					$sql1 = "SELECT admin_id FROM cc_admin WHERE full_name LIKE '%$keywords%'";
					//echo "<br>".$sql1;
					$rs1 		= $db_conn->Execute($sql1);
					$admin_id 	= $rs1->fields['admin_id'];

					$sql .= " AND t1.staff_id = '" . $admin_id . "' ";
				}
			}
			if (!empty($where_in)) {

				$sql .= " AND t1.workcodes IN (" . $where_in . ") ";
				//unset($_SESSION['workcodes']);
			}
			if (!empty($fdate) && !empty($tdate)) {

				$sql .= " AND (t1.staff_updated_date) BETWEEN ('" . $fdate . "') AND ('" . $tdate . "')  ";
			}

			if (!empty($level5)) {
				$sql .= "
	AND t1.workcodes  = (select wc_title from cc_workcodes where id = '" . $level5 . "') ";
			} else if (!empty($level4)) {
				$sql .= "
	AND t1.workcodes  = (select wc_title from cc_workcodes where id = '" . $level4 . "') ";
			} else if (!empty($level3)) {
				$sql .= "
	AND t1.workcodes  = (select wc_title from cc_workcodes where id = '" . $level3 . "') ";
			} else if (!empty($level2)) {
				$sql .= "
	AND  t1.workcodes  = (select wc_title from cc_workcodes where id = '" . $level2 . "') ";
			} else if (!empty($level1)) {
				$sql .= "
	AND  t1.workcodes  = (select wc_title from cc_workcodes where id = '" . $level1 . "') ";
			}







			$sql .= " GROUP BY t1.unique_id  order by staff_updated_date DESC ";

			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
























		/**********************************Call Center Wallboard******************************/

		/********Total Calls*******/
		function get_ccw_total_calls()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT
	  COUNT(unique_id) AS TOTAL_CALLS
	FROM cc_queue_stats
	WHERE STATUS = 0
	    AND call_type <> ''
		AND DATE(dequeue_datetime) = DATE(NOW()) ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['TOTAL_CALLS'];
		}

		/*******Inbound Calls*****/
		function get_ccw_inbound_calls()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT
	  COUNT(unique_id) AS INBOUND_CALLS
	FROM cc_queue_stats
	WHERE STATUS = 0
		AND call_type = 'INBOUND'
		AND DATE(dequeue_datetime) = DATE(NOW()) AND  (call_status = 'ANSWERED' OR call_status = 'DROP' OR call_status = 'ABANDONED')";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['INBOUND_CALLS'];
		}

		function get_ccw_inbound_calls_answer()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT
          COUNT(DISTINCT(unique_id)) AS INBOUND_CALLS
        FROM cc_queue_stats
        WHERE STATUS = 0
                AND call_type = 'INBOUND'
                AND DATE(dequeue_datetime) = DATE(NOW()) AND  (call_status = 'ANSWERED' )";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['INBOUND_CALLS'];
		}

		function get_ccw_inbound_calls_ivr()
		{

			global $db_conn;
			global $db_prefix;
			$sql  = " SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) AS AGENT_ASSIGNMENT_TIME ";
			$sql .= " FROM cc_crm_activity ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			$sql .= " AND STATUS = 6 ";
			$sql .= " AND DATE(update_datetime) = DATE(NOW()) ";

			// $sql = "SELECT
			// 		COUNT(unique_id) AS IVR_CALLS
			//     FROM cc_queue_stats
			//     WHERE STATUS = 0
			// 		AND call_type = 'INBOUND'
			// 		AND DATE(dequeue_datetime) = DATE(NOW()) AND  (call_status = 'TRANSFER' )";

			// Now it returns Assignment time also known as or considered as After Call Work ACW.
			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_ASSIGNMENT_TIME'];
		}

		function get_ccw_shift_calls()
		{

			global $db_conn;
			global $db_prefix;
			// $sql = "SELECT
			// 				COUNT(unique_id) AS SHIFT_CALLS
			// 				FROM cc_queue_stats
			// 				WHERE STATUS = 0
			// 				AND call_type = 'INBOUND'
			// 				AND DATE(dequeue_datetime) = DATE(NOW()) AND  (call_status = 'SHIFT' )";

			$sql = "SELECT
		 		CASE WHEN start_datetime IS NOT NULL THEN SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime,			start_datetime))))ELSE '00:00:00' END AS holdtime
				FROM cc_vu_hold_time WHERE 1=1 AND date(update_datetime) = date(NOW())";
			$rs = $db_conn->Execute($sql);
			return $rs->fields['holdtime'];
		}
		function get_ccw_inbound_calls_ivr_13_3_16()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT
          COUNT(DISTINCT(unique_id)) AS IVR_CALLS
        FROM cc_queue_stats
        WHERE STATUS = 0
                AND call_type = 'INBOUND'
                AND DATE(dequeue_datetime) = DATE(NOW()) AND  (call_status = 'IVR' )";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['IVR_CALLS'];
		}

		function get_ccw_inbound_calls_offtime()
		{

			global $db_conn;
			global $db_prefix;
			// $sql = "SELECT
			//       COUNT(DISTINCT(unique_id)) AS OFFTIME_CALLS
			//     FROM cc_queue_stats
			//     WHERE STATUS = 0
			//             AND call_type = 'INBOUND'
			//             AND DATE(dequeue_datetime) = DATE(NOW()) AND  (call_status = 'OFFTIME' )";

			$sql = "";

			// echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['OFFTIME_CALLS'];
		}

		function get_ccw_inbound_calls_drop()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT
          COUNT(DISTINCT(unique_id)) AS INBOUND_CALLS
        FROM cc_queue_stats
        WHERE STATUS = 0
                AND call_type = 'INBOUND'
                AND DATE(dequeue_datetime) = DATE(NOW()) AND  (call_status = 'DROP' )";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['INBOUND_CALLS'];
		}

		function get_ccw_Abandon_calls()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT 
						Count(	cc_abandon_calls.caller_id) AS Abandon_calls
					 FROM cc_admin cdr ,cc_abandon_calls,cc_queue_stats WHERE 1=1 AND cc_abandon_calls.staff_id = cdr.admin_id  AND cc_abandon_calls.unique_id = cc_queue_stats.unique_id
    AND cc_queue_stats.call_type = 'INBOUND' AND DATE(cc_abandon_calls.update_datetime) = DATE(NOW())";
			$rs = $db_conn->Execute($sql);
			return $rs->fields['Abandon_calls'];
		}


		/****Break Agents****/
		function get_break_agents()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT COUNT(*) AS break from cc_admin where 1=1 AND is_crm_login > 1 AND is_crm_login!=6 AND is_crm_login < 8";
			$rs = $db_conn->Execute($sql);
			return $rs->fields['break'];
		}

		/*******Outbound Calls*****/
		function get_ccw_outbound_calls()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT
	  COUNT(DISTINCT(unique_id)) AS OUTBOUND_CALLS
	FROM cc_queue_stats
	WHERE STATUS = 0
		AND call_type = 'OUTBOUND'
		AND DATE(dequeue_datetime) = DATE(NOW()) ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['OUTBOUND_CALLS'];
		}

		/*******Drop Calls*****/
		function get_ccw_drop_calls()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT
	  COUNT(DISTINCT unique_id) AS DROP_CALLS
	FROM cc_queue_stats
	WHERE 1 = 1
		AND (TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) = '00:00:00'
			  OR staff_id IS NULL)
		AND DATE(dequeue_datetime) = DATE(NOW())
		AND STATUS = 0
		AND call_type = 'INBOUND' ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['DROP_CALLS'];
		}

		/*******Service Level*****/
		/*function get_ccw_service_level(){

	global $db_conn; global $db_prefix;
	$sql = "SELECT (
			(
				SELECT
				  COUNT(DISTINCT(unique_id))
				FROM cc_queue_stats
				WHERE STATUS = 0 
				  AND DATE(update_datetime) = DATE(NOW())
			) 
			/ 
			(
			 (
				SELECT
					COUNT(DISTINCT(unique_id))
				FROM cc_queue_stats
				WHERE STATUS = 0
					AND DATE(update_datetime) = DATE(NOW())
					AND call_type = 'INBOUND'
			 )
			 +
			 (
				SELECT
					COUNT(DISTINCT unique_id)
				FROM cc_queue_stats
				WHERE 1 = 1
					AND (TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) = '00:00:00'
					  OR staff_id IS NULL)
					AND DATE(update_datetime) = DATE(NOW())
					AND STATUS = 0
					AND call_type = 'INBOUND'
			  )
			)
	)   AS SERVICE_LEVEL ";
	//echo("<br>".$sql); //exit;
	$rs = $db_conn->Execute($sql);
	return $rs->fields['SERVICE_LEVEL'];
}*/

		/***************** Abondoned calls ************************************/
		function get_ccw_abandoned_calls()
		{

			global $db_conn;
			global $db_prefix;
			$sql = "SELECT
	  COUNT(*) AS abadon
	FROM cc_abandon_calls
	WHERE DATE(update_datetime) = DATE(NOW()) ";
			// echo("<br>".$sql); 
			$rs = $db_conn->Execute($sql);
			return $rs->fields['abadon'];
		}

		/*********************** Number of Agents On Call **********************/
		function get_ccw_busy_agents()
		{

			global $db_conn;
			global $db_prefix;
			$sql = " SELECT
	  COUNT(*) AS BUSY_AGENTS
	FROM cc_admin
	WHERE is_busy = 3 AND group_id = 2 ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['BUSY_AGENTS'];
		}

		/*********************** Number of Agents On Call **********************/
		function get_ccw_on_call_agents()
		{

			global $db_conn;
			global $db_prefix;
			$sql = " SELECT
	  COUNT(*) AS ON_CALL_AGENTS
	FROM cc_admin
	WHERE is_busy = 1 AND group_id = 1 ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['ON_CALL_AGENTS'];
		}

		/***************************Agents on ACW***************/

		function get_after_cw_agents()
		{

			global $db_conn;
			global $db_prefix;
			$sql = " SELECT 
          COUNT(*) AS ACW
        FROM cc_admin
        WHERE is_crm_login = 6 AND group_id = 1 ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['ACW'];
		}

		/***************************Agents on Hold***************/

		function get_onhold_agents()
		{

			global $db_conn;
			global $db_prefix;
			$sql = " SELECT
          COUNT(*) AS HOLD           
        FROM cc_admin
        WHERE is_busy = 5 AND group_id = 1 ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['HOLD'];
		}

		/*****************************Call Center Wallboard End****************************************/


		/*****************************Agent Stats Summary****************************************/

		function get_asum_agents_names_all()
		{

			global $db_conn;
			global $db_prefix;

			$sql  = " SELECT admin.admin_id AS ADMIN_ID, admin.full_name AS FULL_NAME";
			$sql .= " FROM cc_admin AS admin ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND admin.designation = 'Agents' ";
			$sql .= " ORDER BY admin.full_name ";

			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}


		function get_asum_agents_names()
		{

			global $db_conn;
			global $db_prefix;

			$sql  = " SELECT admin.admin_id AS ADMIN_ID, admin.full_name AS FULL_NAME";
			$sql .= " FROM cc_admin AS admin ";
			$sql .= " WHERE 1=1 ";
			//$sql .= " AND DATE(admin.staff_updated_date) = DATE(NOW())"; 
			$sql .= " AND admin.designation = 'Agents' ";
			$sql .= " AND admin.is_crm_login !=0 ";
			$sql .= " AND admin.is_phone_login !=0 ";
			//$sql .= " AND admin.group_id = '2' ";
			$sql .= " ORDER BY admin.full_name ";

			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function get_asum_inbound_calls($agent_id)
		{

			global $db_conn;
			global $db_prefix;
			# remove on 11 feb 16 SELECT COUNT(DISTINCT(unique_id))AS AGENT_INBOUND_CALLS ";	
			$sql  = " SELECT COUNT(DISTINCT(unique_id))AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_queue_stats ";
			$sql .= " WHERE 1=1 ";
			//$sql .= " AND STATUS = 0 ";
			$sql .= " AND call_type = 'INBOUND' ";
			$sql .= " AND DATE(dequeue_datetime) = DATE(NOW()) ";
			$sql .= " AND call_status = 'ANSWERED' ";
			$sql .= " AND staff_id = '" . $agent_id . "' ";

			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}

		function get_asum_outbound_calls($agent_id)
		{

			global $db_conn;
			global $db_prefix;
			$sql  = " SELECT COUNT(DISTINCT(unique_id)) AS AGENT_OUTBOUND_CALLS ";
			$sql .= " FROM cc_queue_stats ";
			$sql .= " WHERE 1=1 ";
			//$sql .= " AND STATUS = 0 ";
			$sql .= " AND call_type = 'OUTBOUND' ";
			$sql .= " AND DATE(dequeue_datetime) = DATE(NOW()) ";
			// for showing answered dialed calls [for showing unanswered calls == '00:00:00' used]
			$sql .= " AND TIMEDIFF(TIME(staff_end_datetime),TIME(staff_start_datetime)) <> '00:00:00' ";
			$sql .= " AND staff_id = '" . $agent_id . "' ";

			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_OUTBOUND_CALLS'];
		}

		function get_asum_break_time($agent_id)
		{

			global $db_conn;
			global $db_prefix;

			$sql  = " SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime))))AS AGENT_BREAK_TIME ";
			$sql .= " FROM cc_crm_activity ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			$sql .= " AND STATUS <> 6 ";
			$sql .= " AND STATUS <> 1 ";
			$sql .= " AND DATE(update_datetime) = DATE(NOW()) ";
			$sql .= " AND staff_id = '" . $agent_id . "' ";
			$sql .= " GROUP BY staff_id ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_BREAK_TIME'];
		}

		function get_asum_assignment_time($agent_id)
		{

			global $db_conn;
			global $db_prefix;

			$sql  = " SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) AS AGENT_ASSIGNMENT_TIME ";
			$sql .= " FROM cc_crm_activity ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			$sql .= " AND STATUS = 6 ";
			$sql .= " AND DATE(update_datetime) = DATE(NOW()) ";
			$sql .= " AND staff_id = '" . $agent_id . "' ";
			$sql .= " GROUP BY staff_id ";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_ASSIGNMENT_TIME'];
		}

		function get_asum_agent_login_time($agent_id)
		{

			global $db_conn;
			global $db_prefix;
			//$sql = "SELECT time(MIN(login_datetime)) as login_time, time(MAX(logout_datetime)) as logout_time, TIMEDIFF(MAX(logout_datetime),MIN(login_datetime)) as duration FROM ".$db_prefix."_login_activity WHERE 1=1 ";
			$sql = "SELECT count(*) AS trec, TIME(MIN(login_datetime)) AS login_time,
			-- time(MAX(logout_datetime)) AS logout_time, 
			CASE TIME(MAX(login_datetime)) WHEN  TIME(MAX(logout_datetime)) THEN TIME(NOW()) 
			ELSE TIME(MAX(logout_datetime))
			END 
			AS logout_time, 
			CASE TIME(MAX(login_datetime)) WHEN   TIME(MAX(logout_datetime)) THEN TIMEDIFF(NOW(),MIN(login_datetime)) 
			ELSE TIMEDIFF(MAX(logout_datetime),MIN(login_datetime)) 
			END AS duration 
			FROM cc_login_activity 
			WHERE 1=1  ";
			//if(!empty($admin_id)){
			$sql .= "AND staff_id ='" . $agent_id . "'";
			//}
			$sql .= " AND DATE(login_datetime)=DATE(NOW()) AND DATE(logout_datetime)=DATE(NOW()) ";

			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['duration'];
		}

		function get_asum_busy_time($agent_id)
		{

			global $db_conn;
			global $db_prefix;

			$sql  = " SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(TIME(s.dequeue_datetime), TIME(l.dequeue_datetime))))) AS AGENT_BUSY_TIME ";
			$sql .= " FROM cc_queue_stats s INNER JOIN cc_queue_stats_logs l ON s.unique_id = l.unique_id ";
			$sql .= " AND s.status = '0' ";
			$sql .= " AND l.status = '-1' ";
			$sql .= " AND s.staff_id = l.staff_id ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND s.staff_id = '" . $agent_id . "' AND DATE(s.update_datetime) = DATE(NOW())";
			//echo $sql;
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_BUSY_TIME'];
		}

		function get_msisdn_count($agent_id_out, $campaign_id)
		{

			global $db_conn;
			global $db_prefix;
			//   $sql = "SELECT full_name, admin_id FROM ".$db_prefix."_admin WHERE group_id = '2' AND status = '1' ";
			$sql = "SELECT count(*) as msisdn_count FROM cc_campaign_detail WHERE  caller_id != '' and campaign_id = $campaign_id and (status = 1 OR status = $agent_id_out) ";
			//$sql.= " LIMIT 0,5";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); //exit;
			return $rs;
		}

		function get_msisdn_out_list($agent_id_out, $campaign_id, $agent_id)
		{

			global $db_conn;
			global $db_prefix;
			//   $sql = "SELECT full_name, admin_id FROM ".$db_prefix."_admin WHERE group_id = '2' AND status = '1' ";
			//  $sql = "SELECT * FROM cc_campaign_detail WHERE staff_id = $agent_id_out and campaign_id = $campaign_id and status = 1 ";
			$sql = "SELECT * FROM cc_campaign_detail WHERE  caller_id != '' and campaign_id = $campaign_id and (status = 1 OR status = $agent_id) and attempts < 3 ORDER BY attempts limit 1";
			//$sql.= " LIMIT 0,5";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}

		function update_msisdn_out_list($caller_id, $agent_id_out, $campaign_id)
		{

			global $db_conn;
			global $db_prefix;
			//   $sql = "SELECT full_name, admin_id FROM ".$db_prefix."_admin WHERE group_id = '2' AND status = '1' ";
			$sql = "UPDATE cc_campaign_detail set status = 0 WHERE campaign_id = $campaign_id and caller_id = $caller_id ";
			//$sql.= " LIMIT 0,5";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}
		//by waleed
		function update_msisdn_out_list_new($caller_id, $agent_id_out, $campaign_id, $name)
		{

			global $db_conn;
			global $db_prefix;
			//   $sql = "SELECT full_name, admin_id FROM ".$db_prefix."_admin WHERE group_id = '2' AND status = '1' ";
			$sql = "UPDATE cc_campaign_detail set status = 0 WHERE campaign_id = $campaign_id and caller_id = $caller_id and name = $name   ";
			//$sql.= " LIMIT 0,5";
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
		}
		#update_get_msisdn_out_list
		function update_get_msisdn_out_list($id, $agent_id)
		{

			global $db_conn;
			global $db_prefix;
			//   $sql = "SELECT full_name, admin_id FROM ".$db_prefix."_admin WHERE group_id = '2' AND status = '1' ";
			$sql1 = "UPDATE cc_campaign_detail set status = $agent_id WHERE id = $id ";
			//$sql.= " LIMIT 0,5";
			$rs1 = $db_conn->Execute($sql1);
			// echo("<br>".$sql1); exit;
			return $rs1;
		}

		function get_category_count($search_keyword, $date)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;
			if ($search_keyword) {
				$finalData = array();


				$sql = "Select DISTINCT(full_name) from cc_xvu_queue_stats where full_name != ''";
				$query = $db_conn->Execute($sql);
				$agentID = $search_keyword;
				//
				$mobQuery = $db_conn->Execute("SELECT COUNT(`id`) as countid from `cc_xvu_queue_stats` where length(caller_id)>4 and (`caller_id` like '03%' or `caller_id` like '3%' or `caller_id` like '00923%' or `caller_id` like '003%') and `full_name` = '$agentID' and `full_name` != '' and `call_date` = '" . $date . "' ");
				foreach ($mobQuery as  $value2) {
					$countMob = $value2['countid'];
				}
				//
				$landQuery = $db_conn->Execute("SELECT COUNT(`id`) as countid from `cc_xvu_queue_stats` where length(caller_id)>4 and (`caller_id` not like '03%' and `caller_id` not like '3%' and `caller_id` not like '00923%' and `caller_id` not like '003%') and `full_name` = '$agentID' and `full_name` != '' and `call_date` = '" . $date . "' ");
				foreach ($landQuery as  $value3) {
					$countLand = $value3['countid'];
				}
				//    //
				$extQuery = $db_conn->Execute("SELECT COUNT(`id`) as countid from `cc_xvu_queue_stats` where  (length(caller_id) = 4 || length(caller_id) = 3) and `full_name` = '$agentID'  and `full_name` != '' and `call_date` = '" . $date . "' ");
				foreach ($extQuery as  $value4) {
					$countExt = $value4['countid'];
				}

				//
				$finalData[$key]['agentID'] = $agentID;
				$finalData[$key]['countMob'] = $countMob;
				$finalData[$key]['countLand'] = $countLand;
				$finalData[$key]['countExt'] = $countExt;
			} else {

				$finalData = array();
				$sql = "Select DISTINCT(full_name) from cc_xvu_queue_stats where full_name != ''";
				$query = $db_conn->Execute($sql);
				foreach ($query as $key => $value) {
					$agentID = $value['full_name'];
					//
					$mobQuery = $db_conn->Execute("SELECT COUNT(`id`) as countid from `cc_xvu_queue_stats` where length(caller_id)>4 and (`caller_id` like '03%' or `caller_id` like '3%' or `caller_id` like '00923%' or `caller_id` like '003%') and `full_name` = '$agentID' and `full_name` != '' and `call_date` = '" . $date . "' ");
					foreach ($mobQuery as  $value2) {
						$countMob = $value2['countid'];
					}
					//
					$landQuery = $db_conn->Execute("SELECT COUNT(`id`) as countid from `cc_xvu_queue_stats` where length(caller_id)>4 and (`caller_id` not like '03%' and `caller_id` not like '3%' and `caller_id` not like '00923%' and `caller_id` not like '003%') and `full_name` = '$agentID' and `full_name` != '' and `call_date` = '" . $date . "' ");
					foreach ($landQuery as  $value3) {
						$countLand = $value3['countid'];
					}
					//    //
					$extQuery = $db_conn->Execute("SELECT COUNT(`id`) as countid from `cc_xvu_queue_stats` where  (length(caller_id) = 4 || length(caller_id) = 3) and `full_name` = '$agentID'  and `full_name` != '' and `call_date` = '" . $date . "' ");
					foreach ($extQuery as  $value4) {
						$countExt = $value4['countid'];
					}
					//    var_dump($search_keyword);
					//         var_dump($date);
					//
					$finalData[$key]['agentID'] = $agentID;
					$finalData[$key]['countMob'] = $countMob;
					$finalData[$key]['countLand'] = $countLand;
					$finalData[$key]['countExt'] = $countExt;
				}
			}
			return $finalData;
		}
		function record_outbound_count($search_keyword, $times)
		{
			global $db_conn;
			global $db_prefix;
			$sql  = " SELECT full_name, COUNT(call_type) AS AGENT_OUTBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'OUTBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND talk_time != '00:00:00' ";

			$sql .= " AND DATE(call_datetime) = DATE('" . $times . "') ";

			$sql .= " AND full_name = '" . $search_keyword . "' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_OUTBOUND_CALLS'];
		}
		function record_inbound_count($search_keyword, $times)
		{
			global $db_conn;
			global $db_prefix;
			$sql  = " SELECT full_name, COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'INBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND talk_time != '00:00:00' ";
			$sql .= " AND DATE(call_datetime) = DATE('" . $times . "') ";
			$sql .= " AND full_name = '" . $search_keyword . "' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}

		function record_search_outbound_count($search_keyword, $times)
		{
			global $db_conn;
			global $db_prefix;
			$sql  = " SELECT full_name, COUNT(call_type) AS AGENT_OUTBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'OUTBOUND' ";
			$sql .= " AND call_type != '' ";

			$sql .= " AND DATE(call_datetime) = DATE('" . $times . "') ";

			$sql .= " AND full_name = '" . $search_keyword . "' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_OUTBOUND_CALLS'];
		}
		function record_search_inbound_count($search_keyword, $times)
		{
			global $db_conn;
			global $db_prefix;
			$sql  = " SELECT full_name, COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'INBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND DATE(call_datetime) = DATE('" . $times . "') ";

			$sql .= " AND full_name = '" . $search_keyword . "' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}

		function daily_inbound_report($times, $hour)
		{
			global $db_conn;
			global $db_prefix;
			$sql  = " SELECT COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'INBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND call_datetime >= '" . $times . " " . $hour . ":00:00' ";
			$sql .= " AND call_datetime <= '" . $times . " " . $hour . ":59:59' ";


			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}
		function daily_outbound_report($times, $hour)
		{
			global $db_conn;
			global $db_prefix;
			$sql  = " SELECT COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'OUTBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND call_datetime >= '" . $times . " " . $hour . ":00:00' ";
			$sql .= " AND call_datetime <= '" . $times . " " . $hour . ":59:59' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}
		function monthly_inbound_report($month, $date)
		{
			global $db_conn;
			global $db_prefix;
			$year = date("Y");
			$sql  = " SELECT COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'INBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND call_datetime >= '" . $year . "-" . $month . "-" . $date . " 00:00:00' ";
			$sql .= " AND call_datetime <= '" . $year . "-" . $month . "-" . $date . " 23:59:59' ";


			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}
		function monthly_outbound_report($month, $date)
		{
			global $db_conn;
			global $db_prefix;
			$year = date("Y");
			$sql  = " SELECT COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'OUTBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND call_datetime >= '" . $year . "-" . $month . "-" . $date . " 00:00:00' ";
			$sql .= " AND call_datetime <= '" . $year . "-" . $month . "-" . $date . " 23:59:59' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}
		function yearly_inbound_report($year, $month)
		{
			global $db_conn;
			global $db_prefix;
			if (strlen($month) == 1) {
				$month = "0" . $month;
			}
			$sql  = " SELECT COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'INBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND call_datetime like '" . $year . "-" . $month . "-%' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}
		function yearly_outbound_report($year, $month)
		{
			global $db_conn;
			global $db_prefix;
			if (strlen($month) == 1) {
				$month = "0" . $month;
			}
			$sql  = " SELECT COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'OUTBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND call_datetime like '" . $year . "-" . $month . "-%' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}
		function weekly_inbound_report($sweek, $eweek, $date)
		{
			global $db_conn;
			global $db_prefix;

			$sql  = " SELECT COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'INBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND call_datetime >= '" . $sweek . "-" . $date . " 00:00:00' ";
			$sql .= " AND call_datetime <= '" . $eweek . "-" . $date . " 23:59:59' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}
		function weekly_outbound_report($sweek, $eweek, $date)
		{
			global $db_conn;
			global $db_prefix;
			$sql  = " SELECT COUNT(call_type) AS AGENT_INBOUND_CALLS ";
			$sql .= " FROM cc_xvu_queue_stats ";
			$sql .= " WHERE 1=1 ";
			$sql .= " AND call_type = 'OUTBOUND' ";
			$sql .= " AND call_type != '' ";
			$sql .= " AND call_datetime >= '" . $sweek . "-" . $date . " 00:00:00' ";
			$sql .= " AND call_datetime <= '" . $eweek . "-" . $date . " 23:59:59' ";

			$rs = $db_conn->Execute($sql);
			return $rs->fields['AGENT_INBOUND_CALLS'];
		}

		function iget_records_new_live($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			if ($isexport == 0) {
				$db_export = $site_root . "download/Call_Records.csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			}

			$sql = "select
                                                DISTINCT cdr.unique_id,
                                                cdr.id,
                                                cdr.caller_id,
                                                cdr.call_status,
                                                cdr.call_type,
						call_datetime AS call_date,
                                                DATE_FORMAT(call_time,'%h:%i:%s %p') as call_time,
                                                IFNULL(talk_time,'00:00:00') as call_duration,
                                                IFNULL(talk_time,'00:00:00') as talk_time,
                                                IFNULL(cdr.full_name,'') as full_name,
                                                IFNULL(cdr.staff_id,'') as staff_id,
                                                cdr.userfield ";

			$sql .= $csv . " from " . $db_prefix . "_xvu_queue_stats cdr where 1=1 ";
			$sql .= " AND caller_id !='' ";
			if (!empty($search_keyword) && empty($keywords) && $search_keyword <> "caller_id" && $search_keyword <> "full_name") {
				if ($search_keyword == "ANSWERED") {
					$sql .= " AND cdr.call_status = 'ANSWERED' AND cdr.call_type = 'INBOUND' ";
				} elseif ($search_keyword == "DROP") {
					$sql .= " AND cdr.call_status = '" . $search_keyword . "' AND cdr.call_type = 'INBOUND' ";
				} elseif ($search_keyword == "INBOUND") {
					$sql .= " AND cdr.call_type = 'INBOUND' ";
				} elseif ($search_keyword == "OUTBOUND") {
					$sql .= " AND cdr.call_type = 'OUTBOUND' ";
				} elseif ($search_keyword == "DIALED") {
					$sql .= " AND cdr.call_type = 'OUTBOUND' AND cdr.talk_time = '00:00:00' ";
				} else {
				}
			} else {
				if (!empty($search_keyword) && !empty($keywords)) {
					$sql .= " AND cdr." . $search_keyword . " = '" . $keywords . "' ";
				}
			}
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE_FORMAT(cdr.call_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') ";
			} else {
				$sql .= " AND DATE(cdr.calldate) = DATE(NOW())  ";
			}
			$sql .= " order by $field $order ";
			if ($isexport == 0) {
			}
			$rs = $db_conn->Execute($sql);
			return $rs;
		}



		function iget_records($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			if ($isexport == 0) {
				$db_export = $site_root . "download/Call_Records.csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			}
			//  $sql = "select cdr.caller_id, cdr.call_status, cdr.call_type, cdr.unique_id ,call_date, call_time,IFNULL(call_duration,'00:00:00') as call_duration, IFNULL(cdr.full_name,'') as full_name, IFNULL(cdr.staff_id,'') as staff_id, cdr.userfield ";
			// $sql = "select DISTINCT cdr.unique_id ,cdr.id, cdr.caller_id, cdr.call_status, cdr.call_type, call_date, TIME(update_datetime) AS call_time,IFNULL(call_duration,'00:00:00') as call_duration,IFNULL(talk_time,'00:00:00') as talk_time, IFNULL(cdr.full_name,'') as full_name, IFNULL(cdr.staff_id,'') as staff_id, cdr.userfield "; old 6-3-16 
			$sql = "select
						DISTINCT cdr.unique_id,
						cdr.id,
						cdr.caller_id,
						cdr.call_status,
						cdr.call_type,
						call_datetime AS call_date,
						DATE_FORMAT(call_time,'%h:%i:%s %p') as call_time,
						IFNULL(talk_time,'00:00:00') as call_duration,
						IFNULL(talk_time,'00:00:00') as talk_time,
						IFNULL(cdr.full_name,'') as full_name,
						IFNULL(cdr.staff_id,'') as staff_id,
						cdr.userfield ";

			$sql .= $csv . " from " . $db_prefix . "_xvu_queue_stats cdr where 1=1 ";
			$sql .= " AND caller_id !='' ";
			if (!empty($search_keyword) && empty($keywords) && $search_keyword <> "caller_id" && $search_keyword <> "unique_id") {
				if ($search_keyword == "INBOUND") {
					$sql .= " AND cdr.call_status = 'ANSWERED' AND cdr.call_type = '" . $search_keyword . "' ";
				} elseif ($search_keyword == "DROP") {
					$sql .= " AND cdr.call_status = '" . $search_keyword . "' AND cdr.call_type = 'INBOUND' ";
				} else {
				}
			} //else{
			//$sql.= " AND cdr.call_type <> '' ";		
			// }
			if (!empty($search_keyword) && !empty($keywords)) {
				$sql .= " AND cdr." . $search_keyword . " = '" . $keywords . "' ";
			}
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE_FORMAT(cdr.call_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') ";
			} else {
				$sql .= " AND DATE(cdr.calldate) = DATE(NOW())  ";
			}
			$sql .= " order by $field $order ";
			//$sql.= " group by cdr.unique_id ";
			if ($isexport == 0) {
			}
			//echo $sql;
			// echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_records_new($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $stime, $etime, $search_keyword, $keywords, $isexport)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			if ($isexport == 0) {
				$db_export = $site_root . "download/Call_Records.csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			}
			//  $sql = "select cdr.caller_id, cdr.call_status, cdr.call_type, cdr.unique_id ,call_date, call_time,IFNULL(call_duration,'00:00:00') as call_duration, IFNULL(cdr.full_name,'') as full_name, IFNULL(cdr.staff_id,'') as staff_id, cdr.userfield ";
			// $sql = "select DISTINCT cdr.unique_id ,cdr.id, cdr.caller_id, cdr.call_status, cdr.call_type, call_date, TIME(update_datetime) AS call_time,IFNULL(call_duration,'00:00:00') as call_duration,IFNULL(talk_time,'00:00:00') as talk_time, IFNULL(cdr.full_name,'') as full_name, IFNULL(cdr.staff_id,'') as staff_id, cdr.userfield "; old 6-3-16 
			$sql = "select DISTINCT 
		cdr.caller_id,
		cdr.call_status,
		cdr.unique_id ,
		cdr.id,
		call_datetime,
		DATE_FORMAT(call_date,'%d-%m-%Y') as call_date,
		DATE_FORMAT(call_time,'%h:%i:%s %p') as call_time,
		IFNULL(talk_time,'00:00:00') as call_duration,
		IFNULL(cdr.full_name,'') as full_name,
		IFNULL(cdr.staff_id,'') as staff_id,
		cdr.userfield ";

			$sql .= $csv . " from " . $db_prefix . "_xvu_queue_stats cdr where 1=1 ";
			$sql .= " AND caller_id !='' ";
			if (!empty($search_keyword) && empty($keywords) && $search_keyword <> "caller_id" && $search_keyword <> "unique_id") {
				if ($search_keyword == "INBOUND") {
					$sql .= " AND cdr.call_status = 'ANSWERED' AND cdr.call_type = '" . $search_keyword . "' ";
				} elseif ($search_keyword == "DROP") {
					$sql .= " AND cdr.call_status = '" . $search_keyword . "' AND cdr.call_type = 'INBOUND' ";
				} else {
					$sql .= " AND (cdr.call_status = '" . $search_keyword . "' OR cdr.call_type = '" . $search_keyword . "')";
				}
			} //else{
			//$sql.= " AND cdr.call_type <> '' ";		
			// }

			if (!empty($search_keyword) && !empty($keywords)) {
				$sql .= " AND cdr." . $search_keyword . " = '" . $keywords . "' ";
			}
			if (!empty($fdate) && !empty($tdate)) {
				// $sql .= " AND DATE(cdr.call_datetime) Between DATE('$fdate') AND DATE('$tdate') ";
				$sql .= " AND DATE_FORMAT(cdr.call_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') ";
			} else {
				$sql .= " AND DATE(cdr.calldate) = DATE(NOW())  ";
			}

			// Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') ";

			if (!empty($stime) && !empty($etime)) {
				// $sql .= " AND DATE_FORMAT(cdr.call_datetime, '%H:%i:%s') Between DATE_FORMAT('$stime', '%H:%i:%s') AND DATE_FORMAT('$etime', '%H:%i:%s') ";
				// 	$sql .= " AND TIME_FORMAT('cdr.call_time', '%H:%i') Between '$stime' AND '$etime'";
			}
			$sql .= " order by $field $order ";
			//$sql .= " group by cdr.unique_id ";
			if ($isexport == 0) {
			}
			//echo $sql;
			// echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}


		function iget_call_center_main_answered($fdate, $ftime, $dtime)
		{
			global $db_conn;
			global $db_prefix;

			$sql = "SELECT Count(id) AS answered_calls FROM cc_xvu_queue_stats WHERE call_status = 'ANSWERED' AND call_type='INBOUND' AND call_date = '" . $fdate . "' AND DATE_FORMAT(call_time, '%H:%i:%s') BETWEEN '" . $ftime . "' AND '" . $dtime . "'";

			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_call_center_main_abandoned($fdate, $ftime, $dtime)
		{
			global $db_conn;
			global $db_prefix;

			$sql = "SELECT Count(id) AS abandoned_calls FROM cc_xvu_queue_stats WHERE call_status = 'ABANDONED' AND call_type='INBOUND' AND call_date = '" . $fdate . "' AND DATE_FORMAT(call_time, '%H:%i:%s') BETWEEN '" . $ftime . "' AND '" . $dtime . "'";

			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_call_center_main_drop($fdate, $ftime, $dtime)
		{
			global $db_conn;
			global $db_prefix;

			$sql = "SELECT Count(id) AS drop_calls FROM cc_xvu_queue_stats WHERE call_status = 'DROP' AND call_type='INBOUND' AND call_date = '" . $fdate . "' AND DATE_FORMAT(call_time, '%H:%i:%s') BETWEEN '" . $ftime . "' AND '" . $dtime . "'";

			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_call_center_main_total($fdate, $ftime, $dtime)
		{
			global $db_conn;
			global $db_prefix;

			$sql = "SELECT Count(id) AS total_calls FROM cc_xvu_queue_stats WHERE call_type='INBOUND' AND call_date = '" . $fdate . "' AND DATE_FORMAT(call_time, '%H:%i:%s') BETWEEN '" . $ftime . "' AND '" . $dtime . "'";

			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_records_pdf($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			if ($isexport == 0) {
				$db_export = $site_root . "download/Call_Records.csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			}
			//  $sql = "select cdr.caller_id, cdr.call_status, cdr.call_type, cdr.unique_id ,call_date, call_time,IFNULL(call_duration,'00:00:00') as call_duration, IFNULL(cdr.full_name,'') as full_name, IFNULL(cdr.staff_id,'') as staff_id, cdr.userfield ";
			// $sql = "select DISTINCT cdr.unique_id ,cdr.id, cdr.caller_id, cdr.call_status, cdr.call_type, call_date, TIME(update_datetime) AS call_time,IFNULL(call_duration,'00:00:00') as call_duration,IFNULL(talk_time,'00:00:00') as talk_time, IFNULL(cdr.full_name,'') as full_name, IFNULL(cdr.staff_id,'') as staff_id, cdr.userfield "; old 6-3-16 
			$sql = "select DISTINCT 
		cdr.caller_id,
		cdr.call_status,
		cdr.call_type,
		call_datetime,
		id,
		unique_id,
		DATE_FORMAT(call_time,'%h:%i:%s %p') as call_time,
		IFNULL(talk_time,'00:00:00') as call_duration,
		IFNULL(cdr.full_name,'') as full_name,
		IFNULL(cdr.staff_id,'') as staff_id,
		cdr.userfield ";

			$sql .= $csv . " from " . $db_prefix . "_xvu_queue_stats cdr where 1=1 ";
			$sql .= " AND caller_id !='' ";
			if (!empty($search_keyword) && empty($keywords) && $search_keyword <> "caller_id" && $search_keyword <> "unique_id") {
				if ($search_keyword == "INBOUND") {
					$sql .= " AND cdr.call_status = 'ANSWERED' AND cdr.call_type = '" . $search_keyword . "' ";
				} elseif ($search_keyword == "DROP") {
					$sql .= " AND cdr.call_status = '" . $search_keyword . "' AND cdr.call_type = 'INBOUND' ";
				} else {
					$sql .= " AND (cdr.call_status = '" . $search_keyword . "' OR cdr.call_type = '" . $search_keyword . "')";
				}
			} //else{
			//$sql.= " AND cdr.call_type <> '' ";		
			// }

			if (!empty($search_keyword) && !empty($keywords)) {
				$sql .= " AND cdr." . $search_keyword . " = '" . $keywords . "' ";
			}
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE_FORMAT(cdr.call_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') ";
			} else {
				$sql .= " AND DATE(cdr.calldate) = DATE(NOW())  ";
			}

			$sql .= " order by $field $order ";
			//$sql .= " group by cdr.unique_id ";
			if ($isexport == 0) {
			}
			//echo $sql;
			// echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_records_count($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $stime, $etime, $search_keyword, $keywords, $isexport)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			/*
        if($isexport == 0){
            $db_export = $site_root."download/Call_Records_".$today.".csv";
            $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
        }
        */
			$sql = "select count(*) ";

			$sql .= $csv . " from " . $db_prefix . "_xvu_queue_stats cdr where 1=1 ";
			if (!empty($search_keyword) && empty($keyword) && $search_keyword <> "caller_id" && $search_keyword <> "unique_id") {
				$sql .= " AND (cdr.call_status = '" . $search_keyword . "' OR cdr.call_type = '" . $search_keyword . "'";
			}
			if (!empty($search_keyword) && !empty($keyword)) {
				$sql .= " AND cdr." . $search_keyword . " = '" . $keyword . "' ";
			}
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE(cdr.call_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
			} else {
				$sql .= " AND DATE(cdr.calldate) = DATE(NOW())  ";
			}
			$sql .= " order by $field $order";
			if ($isexport == 0) {
			}
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}



		// Category Records...
		function iget_category_records($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			if ($isexport == 0) {
				$db_export = $site_root . "download/Call_Records.csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			}
			//  $sql = "select cdr.caller_id, cdr.call_status, cdr.call_type, cdr.unique_id ,call_date, call_time,IFNULL(call_duration,'00:00:00') as call_duration, IFNULL(cdr.full_name,'') as full_name, IFNULL(cdr.staff_id,'') as staff_id, cdr.userfield ";
			// $sql = "select DISTINCT cdr.unique_id ,cdr.id, cdr.caller_id, cdr.call_status, cdr.call_type, call_date, TIME(update_datetime) AS call_time,IFNULL(call_duration,'00:00:00') as call_duration,IFNULL(talk_time,'00:00:00') as talk_time, IFNULL(cdr.full_name,'') as full_name, IFNULL(cdr.staff_id,'') as staff_id, cdr.userfield "; old 6-3-16 
			$sql = "select DISTINCT
		cdr.caller_id,
		cdr.call_status,
		cdr.call_Type,
		DATE_FORMAT(call_date,'%m-%d-%Y') as call_date,
		DATE_FORMAT(call_time,'%h:%i:%s %p') as call_time,
		IFNULL(talk_time,'00:00:00') as call_duration,
		IFNULL(cdr.full_name,'') as full_name,
		IFNULL(cdr.staff_id,'') as staff_id,
		cdr.userfield ";

			$sql .= $csv . " from " . $db_prefix . "_xvu_queue_stats cdr where 1=1 ";
			if (!empty($search_keyword) && empty($keywords) && $search_keyword <> "caller_id" && $search_keyword <> "unique_id") {
				if ($search_keyword == "INBOUND") {
					$sql .= " AND cdr.call_status = 'ANSWERED' AND cdr.call_type = '" . $search_keyword . "' ";
				} elseif ($search_keyword == "DROP") {
					$sql .= " AND cdr.call_status = '" . $search_keyword . "' AND cdr.call_type = 'INBOUND' ";
				} else {
					$sql .= " AND (cdr.call_status = '" . $search_keyword . "' OR cdr.call_type = '" . $search_keyword . "')";
				}
			} //else{
			//$sql.= " AND cdr.call_type <> '' ";		
			// }
			if (!empty($search_keyword) && !empty($keywords)) {
				$sql .= " AND cdr." . $search_keyword . " = '" . $keywords . "' ";
			}
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE(cdr.call_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
			} else {
				$sql .= " AND DATE(cdr.calldate) = DATE(NOW())  ";
			}
			$sql .= " order by $field $order ";
			//$sql.= " group by cdr.unique_id ";
			if ($isexport == 0) {
			}
			//echo $sql;
			// echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}


		function wget_records_count($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $unique_id, $time, $staff_id, $rank)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';

			$sql = "select count(*) ";

			$sql .= $csv . " from " . $db_prefix . "_vu_queue_stats cdr where  cdr.unique_id IN (select unique_id from cc_call_ranking) ";

			if (!empty($staff_id) || ($staff_id != '0')) {
				$sql .= " AND cc_call_ranking.staff_id = '$staff_id' ";
			}

			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE(cdr.call_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
			}


			if (($rank != '') && ($rank != '0')) {
				$sql .= " AND  cc_call_ranking.rank = '" . $rank . "' ";
			}

			//echo $sql;exit;
			// $rs = $db_conn->Execute($sql);	//print_r($rs);exit;
			return $rs;
		}

		function wget_records($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $unique_id, $time, $staff_id, $rank)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			if ($isexport == 0) {
				$db_export = $site_root . "download/Call_Records_" . $today . ".csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			}
			$sql = "select cdr.caller_id, cdr.call_status, cdr.call_type, cdr.unique_id ,cdr.call_date, cdr.call_time, cdr.call_duration, cdr.full_name , cdr.staff_id, cdr.userfield,cc_call_ranking.rank ";

			$sql .= $csv . " from " . $db_prefix . "_vu_queue_stats cdr,cc_call_ranking where  cdr.unique_id = cc_call_ranking.unique_id";



			if (!empty($staff_id) || ($staff_id != '0')) {
				$sql .= " AND cc_call_ranking.staff_id = '$staff_id' ";
			}

			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE(cdr.call_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
			}



			if (($rank != '') && ($rank != '0')) {
				$sql .= " AND  cc_call_ranking.rank = '" . $rank . "' ";
			}


			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function wget_records_export($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $unique_id, $time, $staff_id, $rank)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			//  if($isexport == 0){
			$db_export = $site_root . "download/feedback_report_" . $today . ".csv";
			$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			// }
			$sql = "select cdr.caller_id , cdr.full_name ,cc_call_ranking.rank  , cdr.unique_id ,GROUP_CONCAT(DISTINCT cc_call_workcodes.workcodes SEPARATOR ' | ')";
			$sql .= $csv . " from cc_vu_queue_stats cdr,cc_call_ranking,cc_call_workcodes where  cdr.unique_id = cc_call_ranking.unique_id
AND cdr.unique_id = cc_call_workcodes.unique_id ";



			if (!empty($staff_id) && ($staff_id != '0')) {
				$sql .= " AND cc_call_ranking.staff_id = '$staff_id' ";
			}

			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE(cdr.call_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
			}



			if (($rank != '') && ($rank != '0')) {
				$sql .= " AND  cc_call_ranking.rank = '" . $rank . "' ";
			}
			$sql .= "GROUP BY cdr.caller_id ";

			// echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
		function call_ranking($staff_id)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;
			$sql = "select * from cc_call_ranking ";
			//echo $sql;exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function ranking($staff_id, $fdate, $tdate, $rank)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;
			//echo $rank.'a';exit;
			$sql = "select * from cc_call_ranking where 1=1 ";

			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE(update_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
			}
			if (!empty($rank) && !empty($rank)) {
				$sql .= " AND rank = '$rank' ";
			}
			if (!empty($staff_id) && !empty($staff_id)) {
				$sql .= " AND staff_id = '$staff_id' GROUP BY id";
			} else {
				$sql .= " GROUP BY id ";
			}
			//echo $sql;exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}


		################ABANDON	
		function iget_fullname($staff_id)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$sql = "select full_name from cc_admin where admin_id ='" . $staff_id . "'";
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_aband_records($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			if ($isexport == 0) {
				$db_export = $site_root . "download/Abandoned_calls.csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			}
			$sql = "SELECT *, update_datetime AS update_date, TIME(update_datetime) AS update_time";
			$sql .= $csv . " from " . $db_prefix . "_abandon_calls where 1=1";

			if (!empty($search_keyword) && !empty($keywords)) {
				$sql .= " AND " . $search_keyword . " = '" . $keywords . "'";
			}
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE_FORMAT(update_datetime, '%Y-%m-%e %H:%i:%s') Between DATE_FORMAT('$fdate', '%Y-%m-%e %H:%i:%s') AND DATE_FORMAT('$tdate', '%Y-%m-%e %H:%i:%s') ";
			} else {
				$sql .= " AND DATE(update_datetime) = DATE(NOW())  ";
			}
			$sql .= "ORDER BY id DESC";
			if ($isexport == 0) {
			}

			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		function iget_aband_records_count($alpha = "", $startRec, $totalRec = 80, $field = "call_datetime", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today)
		{
			global $db_conn;
			global $db_prefix;
			global $site_root;

			$csv = '';
			/*
        if($isexport == 0){
            $db_export = $site_root."download/Call_Records_".$today.".csv";
            $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
        }
        */
			$sql = "select count(*) ";
			//      $sql ="SELECT cc_abandon_calls.caller_id, cc_abandon_calls.unique_id ,  cc_abandon_calls.staff_id, cc_abandon_calls.update_datetime";
			$sql .= $csv . " from " . $db_prefix . "_admin cdr ,cc_abandon_calls WHERE 1=1 AND cc_abandon_calls.staff_id = cdr.admin_id";


			//    $sql .= $csv." from ".$db_prefix."_xvu_queue_stats cdr ,cc_abandon_calls where 1=1 and cdr.unique_id = cc_abandon_calls.unique_id and cc_abandon_calls.staff_id = cdr.staff_id AND cdr.call_type != 'OUTBOUND' AND cdr.call_type != 'CAMPAIGN'";
			if (!empty($search_keyword) && empty($keyword) && $search_keyword <> "caller_id" && $search_keyword <> "unique_id") {
				$sql .= " AND (cdr.call_status = '" . $search_keyword . "' OR cdr.call_type = '" . $search_keyword . "'";
			}
			if (!empty($search_keyword) && !empty($keyword)) {
				$sql .= " AND cdr." . $search_keyword . " = '" . $keyword . "' ";
			}
			if (!empty($fdate) && !empty($tdate)) {
				$sql .= " AND DATE(update_datetime) Between  DATE('" . $fdate . "') AND DATE('" . $tdate . "') ";
			} else {
				$sql .= " AND DATE(update_datetime) = DATE(NOW())  ";
			}
			$sql .= " order by update_datetime $order";
			if ($isexport == 0) {
			}
			// $sql = "select count(*) from cc_abandon_calls limit 1000";
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}

		############
		function get_workcode_details_new2($field = "staff_updated_date", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $level1, $level2, $level3, $level4, $level5)
		{
			//echo $level1.$level2.$level3.$level4.$level5;exit;
			global $db_conn;
			global $db_prefix;
			global $site_root;
			//	echo $level1.$level2.$level3.$level4.$level5;exit;
			$csv = '';
			if ($isexport == true) {
				$db_export = $site_root . "download/Workcode_report_" . $today . ".csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//t1.staff_id
			$sql = "SELECT  t1.unique_id, t1.caller_id, t2.customer_id, t2.call_type, 
	
	(SELECT wc_title FROM cc_workcodes_new WHERE id = (SELECT parent_id FROM cc_workcodes_new
WHERE id = ";

			if (!empty($level5)) {
				$sql .= "'" . $level5 . "'";
			} else if (!empty($level4)) {
				$sql .= "'" . $level4 . "'";
			} else if (!empty($level3)) {
				$sql .= "'" . $level3 . "'";
			} else if (!empty($level2)) {
				$sql .= "'" . $level2 . "'";
			} elseif (!empty($level1)) {
				$sql .= "'" . $level1 . "'";
			}


			$sql .= " )) as workcodes1 , GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes, t1.staff_updated_date, 
	(SELECT full_name FROM cc_admin WHERE admin_id = t1.staff_id ) AS agent_name, detail";

			if ($isexport != true) {
				$sql .= " , t2.update_datetime  ";
			}

			$sql .= $csv . " FROM cc_call_workcodes AS t1 INNER JOIN cc_queue_stats AS t2
ON t1.unique_id = t2.unique_id "; //t1.caller_id = t2.caller_id
			$sql .= "WHERE 1=1 ";
			$sql .= " AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime) ";

			if (!empty($keywords)) {

				if ($search_keyword == 'call-track_id') {

					$sql .= " AND t1.unique_id = '" . $keywords . "' ";
				}

				if ($search_keyword == 'caller_id') {

					$sql .= " AND t1.caller_id = '" . $keywords . "' ";
				}


				/*if ($search_keyword == 'workcode') {
		
			$sql .= " AND t1.workcodes = '".$keywords."' ";
		}*/

				if ($search_keyword == 'agent_name') {

					$sql1 = "SELECT admin_id FROM cc_admin WHERE full_name LIKE '%$keywords%'";
					//echo "<br>".$sql1;
					$rs1 		= $db_conn->Execute($sql1);
					$admin_id 	= $rs1->fields['admin_id'];

					$sql .= " AND t1.staff_id = '" . $admin_id . "' ";
				}
			}
			if (!empty($where_in)) {

				$sql .= " AND LTRIM(t1.workcodes) IN (" . $where_in . ") ";
				//unset($_SESSION['workcodes']);
			}
			if (!empty($fdate) && !empty($tdate)) {

				$sql .= " AND (t1.staff_updated_date) BETWEEN ('" . $fdate . "') AND ('" . $tdate . "')  ";
			}

			if (!empty($level5)) {
				$sql .= "
	AND LTRIM(t1.workcodes)  IN (select wc_title from cc_workcodes_new where id = '" . $level5 . "'
	OR parent_id = '" . $level5 . "'
	) ";
			} else if (!empty($level4)) {
				$sql .= "
	AND LTRIM(t1.workcodes)  IN (select wc_title from cc_workcodes_new where id = '" . $level4 . "'
	
	OR parent_id = '" . $level4 . "'
	) ";
			} else if (!empty($level3)) {
				$sql .= "
	AND LTRIM(t1.workcodes)  IN (select wc_title from cc_workcodes_new where id = '" . $level3 . "'
	OR parent_id = '" . $level3 . "'
	) ";
			} else if (!empty($level2)) {
				$sql .= "
	AND  LTRIM(t1.workcodes)  IN (select wc_title from cc_workcodes_new where id = '" . $level2 . "'
	OR parent_id = '" . $level2 . "'
	) ";
			} else if (!empty($level1)) {
				$sql .= "
	AND  LTRIM(t1.workcodes)  IN (select wc_title from cc_workcodes_new where id = '" . $level1 . "'
	OR parent_id = '" . $level1 . "'
	) ";
			}
			$sql .= " GROUP BY t1.unique_id  order by staff_updated_date DESC ";
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}













		###########
		function get_workcode_details_new2_26072013($field = "staff_updated_date", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $level1, $level2, $level3, $level4, $level5)
		{
			//echo $level1.$level2.$level3.$level4.$level5;exit;
			global $db_conn;
			global $db_prefix;
			global $site_root;
			echo $level1 . $level2 . $level3 . $level4 . $level5;
			exit;
			$csv = '';
			if ($isexport == true) {
				$db_export = $site_root . "download/Workcode_report_" . $today . ".csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//t1.staff_id
			$sql = "SELECT  t1.unique_id, t1.caller_id, t2.customer_id, t2.call_type, GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes, t1.staff_updated_date, 
	(SELECT full_name FROM cc_admin WHERE admin_id = t1.staff_id ) AS agent_name ";

			if ($isexport != true) {
				$sql .= " , t2.update_datetime  ";
			}

			$sql .= $csv . " FROM cc_call_workcodes AS t1 INNER JOIN cc_queue_stats AS t2
ON t1.unique_id = t2.unique_id "; //t1.caller_id = t2.caller_id
			$sql .= "WHERE 1=1 ";
			$sql .= " AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime) ";

			if (!empty($keywords)) {

				if ($search_keyword == 'call-track_id') {

					$sql .= " AND t1.unique_id = '" . $keywords . "' ";
				}

				if ($search_keyword == 'caller_id') {

					$sql .= " AND t1.caller_id = '" . $keywords . "' ";
				}


				/*if ($search_keyword == 'workcode') {
		
			$sql .= " AND t1.workcodes = '".$keywords."' ";
		}*/

				if ($search_keyword == 'agent_name') {

					$sql1 = "SELECT admin_id FROM cc_admin WHERE full_name LIKE '%$keywords%'";
					//echo "<br>".$sql1;
					$rs1 		= $db_conn->Execute($sql1);
					$admin_id 	= $rs1->fields['admin_id'];

					$sql .= " AND t1.staff_id = '" . $admin_id . "' ";
				}
			}
			if (!empty($where_in)) {

				$sql .= " AND t1.workcodes IN (" . $where_in . ") ";
				//unset($_SESSION['workcodes']);
			}
			if (!empty($fdate) && !empty($tdate)) {

				$sql .= " AND (t1.staff_updated_date) BETWEEN ('" . $fdate . "') AND ('" . $tdate . "')  ";
			}

			if (!empty($level5)) {
				$sql .= "
	AND t1.workcodes  IN (select wc_title from cc_workcodes_new where id = '" . $level5 . "'
	OR parent_id = '" . $level5 . "'
	) ";
			} else if (!empty($level4)) {
				$sql .= "
	AND t1.workcodes  IN (select wc_title from cc_workcodes_new where id = '" . $level4 . "'
	
	OR parent_id = '" . $level4 . "'
	) ";
			} else if (!empty($level3)) {
				$sql .= "
	AND t1.workcodes  IN (select wc_title from cc_workcodes_new where id = '" . $level3 . "'
	OR parent_id = '" . $level3 . "'
	) ";
			} else if (!empty($level2)) {
				$sql .= "
	AND  t1.workcodes  IN (select wc_title from cc_workcodes_new where id = '" . $level2 . "'
	OR parent_id = '" . $level2 . "'
	) ";
			} else if (!empty($level1)) {
				$sql .= "
	AND  t1.workcodes  IN (select wc_title from cc_workcodes_new where id = '" . $level1 . "'
	OR parent_id = '" . $level1 . "'
	) ";
			}







			$sql .= " GROUP BY t1.unique_id  order by staff_updated_date DESC ";

			echo ("<br>" . $sql);
			exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}


























		function get_workcode_details_new3($field = "staff_updated_date", $order = "desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $newsearch)
		{ //print_r ($newsearch);exit;
			$count = count($newsearch);
			//echo $isexport.'as';exit;
			$newsearch2 = implode(",", $newsearch);
			//echo $newsearch2;exit; 
			global $db_conn;
			global $db_prefix;
			global $site_root;
			//	echo $level1.$level2.$level3.$level4.$level5;exit;
			$csv = '';
			if ($isexport == true) {
				$db_export = $site_root . "download/Workcode_report_" . $today . ".csv";
				$csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//t1.staff_id
			$sql = "SELECT  t1.unique_id, t1.caller_id, t2.customer_id, t2.call_type, GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes, t1.staff_updated_date, 
	(SELECT full_name FROM cc_admin WHERE admin_id = t1.staff_id ) AS agent_name ";

			if ($isexport != true) {
				$sql .= " , t2.update_datetime  ";
			}

			$sql .= $csv . " FROM cc_call_workcodes AS t1 INNER JOIN cc_queue_stats AS t2
ON t1.unique_id = t2.unique_id "; //t1.caller_id = t2.caller_id
			$sql .= "WHERE 1=1 ";
			$sql .= " AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime) ";

			if (!empty($keywords)) {

				if ($search_keyword == 'call-track_id') {

					$sql .= " AND t1.unique_id = '" . $keywords . "' ";
				}

				if ($search_keyword == 'caller_id') {

					$sql .= " AND t1.caller_id = '" . $keywords . "' ";
				}


				/*if ($search_keyword == 'workcode') {
		
			$sql .= " AND t1.workcodes = '".$keywords."' ";
		}*/

				if ($search_keyword == 'agent_name') {

					$sql1 = "SELECT admin_id FROM cc_admin WHERE full_name LIKE '%$keywords%'";
					//echo "<br>".$sql1;
					$rs1 		= $db_conn->Execute($sql1);
					$admin_id 	= $rs1->fields['admin_id'];

					$sql .= " AND t1.staff_id = '" . $admin_id . "' ";
				}
			}
			if (!empty($where_in)) {

				$sql .= " AND t1.workcodes IN (" . $where_in . ") ";
				//unset($_SESSION['workcodes']);
			}
			if (!empty($fdate) && !empty($tdate)) {

				$sql .= " AND (t1.staff_updated_date) BETWEEN ('" . $fdate . "') AND ('" . $tdate . "')  ";
			}

			if (!empty($newsearch) && $count > 1) {
				$sql .= "
	AND t1.workcodes  IN (select wc_title from cc_workcodes_new where id IN (" . $newsearch2 . ")
	
	) ";
			}

			if (!empty($newsearch) && $count == 1) {
				$sql .= "
	AND t1.workcodes  IN (select wc_title from cc_workcodes_new where id ='" . $newsearch2 . "'
	
	or parent_id = '" . $newsearch2 . "'
	
	) ";
			}









			$sql .= " GROUP BY t1.unique_id  order by staff_updated_date DESC ";

			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
		}
	}
