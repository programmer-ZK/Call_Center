<?php

class cc_evaluation {
	function cc_evaluation(){
	}
	/*function get_records($alpha="", $startRec, $totalRec=80, $field="staff_updated_date", $order="asc"){
	
		global $db_conn; global $db_prefix;
		$sql = "select a.*,ag.group_name,(SELECT full_name FROM ".$db_prefix."_admin WHERE admin_id = staff_id) AS staff_name from ".$db_prefix."_admin a,".$db_prefix."_admin_groups ag where 1=1 ";
		if(!empty($alpha)){
				$sql.= "and a.full_name like '".$alpha."%'";
		}
		$sql.= "and a.group_id = ag.id";
		$sql.= " order by $field $order";
		$sql.= " limit $startRec, $totalRec";
			
		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); exit;
		return $rs;
    }*/
	function get_record_count($alpha=""){

                global $db_conn; global $db_prefix;
                $sql = "select count(*) tRec from ".$db_prefix."_evaluation_questions where 1=1 ";
                if(!empty($alpha)){
                        $sql.= "and question like '".$alpha."%' ";
                }
				$sql.= " and status = 1 ";
                $rs = $db_conn->Execute($sql);
                return $rs->fields["tRec"];
				//return $rs;
    }
		
	function insert_evaluation($unique_id, $agent_id, $point, $comment, $i, $point_type,$evaluate_agent_id,$calldate,$scores){
		global $db_conn; global $db_prefix;
		
		if ($point_type == 'na'){
			$max_points = 0;
		} else {
		$sql2 = "select MAX(value) as max_pints from cc_evaluation_points where status = 1";
		$rs2 = $db_conn->Execute($sql2);
		$max_points = $rs2->fields["max_pints"];
		}
		$sql  = "insert into ".$db_prefix."_evaluation ";
		$sql .= " (unique_id, question_no, points, points_type, comments, evaluate_agent_id, scores, max_points,admin_id,call_datetime, update_datetime) ";
		$sql .= " values( '".$unique_id."','".$i."', '".$point."', '".$point_type."','".$comment."', '".$evaluate_agent_id."', '".round($scores,2)."', '".$max_points."','".$agent_id."','".$calldate."', NOW())";
		//echo("<br>".$sql);//exit
		return $rs = $db_conn->Execute($sql);
	}
	
	function insert_evaluation_scores($unique_id, $agent_id, $scores, $i,$evaluate_agent_id,$countYes,$countNo,$countNimp,$countNa,$calldate){
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_evaluation_scores ";
		$sql .= " (unique_id, no_of_questions, no_of_yes, no_of_no, no_of_nimp, no_of_na,scores,  evaluate_agent_id, admin_id, update_datetime,call_datetime) ";
		$sql .= " values( '".$unique_id."','".$i."','".$countYes."','".$countNo."','".$countNimp."','".$countNa."', '".round($scores,2)."', '".$evaluate_agent_id."','".$agent_id."', NOW(),'".$calldate."')";
		//echo("<br>".$sql);// exit;
		return $rs = $db_conn->Execute($sql);
	}
	function update_evaluation_scores($unique_id, $agent_id, $evaluate_agent_id,$flag_call,$training_need)
	{
		global $db_conn; global $db_prefix;
		$sql  = "update  ".$db_prefix."_evaluation_scores ";
		$sql .= " set flag_call='".$flag_call."',training_need='".$training_need."' where unique_id = '".$unique_id."' and evaluate_agent_id='".$evaluate_agent_id."' and admin_id='".$agent_id."' ";
		//echo("<br>".$sql); exit;
		return $rs = $db_conn->Execute($sql);
	}
	
	
	function get_questions($alpha=""){

                global $db_conn; global $db_prefix;
                $sql = "select * from ".$db_prefix."_evaluation_questions where 1=1 ";
                if(!empty($alpha)){
                        $sql.= "and question like '".$alpha."%' ";
                }
				$sql.= " and status = 1 ";
                $rs = $db_conn->Execute($sql);
                //return $rs->fields["tRec"];
				return $rs;
    }
	
	function get_points($alpha=""){

                global $db_conn; global $db_prefix;
                $sql = "select * from ".$db_prefix."_evaluation_points where 1=1 ";
                if(!empty($alpha)){
                        $sql.= "and points like '".$alpha."%' ";
                }
				$sql.= " and status = 1 ";
                $rs = $db_conn->Execute($sql);
                //return $rs->fields["tRec"];
				return $rs;
    }
	
	function get_score($alpha="", $evaluator_id, $evaluated_agent_id){

                global $db_conn; global $db_prefix;
                $sql = "select *, date(update_datetime) as updated_datetime from ".$db_prefix."_evaluation_scores where 1=1 ";

                $sql.= " and unique_id='".$alpha."' ";
				if ($evaluated_agent_id != NULL && $evaluated_agent_id != ''){
					$sql.= " and evaluate_agent_id='".$evaluated_agent_id."' ";
				}
				$sql.= " and admin_id='".$evaluator_id."' ";
				//echo "<br>".$sql;//exit;
                $rs = $db_conn->Execute($sql);
				return $rs;
    }
		
	function is_score_exist($alpha=""){
				
				//echo $alpha;
                global $db_conn; global $db_prefix;
                $sql = "select unique_id from ".$db_prefix."_evaluation_scores where 1=1 ";
                //if(!empty($alpha)){
                $sql.= " and unique_id='".$alpha."' ";
				$sql.= " and admin_id='".$_SESSION[$db_prefix.'_UserId']."' ";
                //}
                $rs = $db_conn->Execute($sql);
                //return $rs->fields["tRec"];
				//print_r($rs);exit;
				
				//echo $rs->fields['unique_id'];
				
				//echo "----query:".$sql;exit;
				
				if (!empty($rs->fields['unique_id']))
				{
					return true;
				}
				else
				{
			     	return false;
				}
    }
		
	function update_evaluation_points($points, $value, $admin_id){
		global $db_conn; global $db_prefix;
		/*$sql  = "insert into ".$db_prefix."_evaluation ";
		$sql .= " (unique_id, question_no, points, comments, admin_id, update_datetime) ";
		$sql .= " values( '".$unique_id."','".$i."', '".$point."', '".$comment."', '".$staff_id."', NOW())";*/
		
		$sql  = "update ".$db_prefix."_evaluation_points ";
		$sql .= "set value = '".$value."', admin_id = '".$admin_id."', update_datetime = NOW() ";
		$sql .= " where points = '".$points."'";
		//echo $sql;
		return $rs = $db_conn->Execute($sql);
	}

////////Test Scores Report	
	function insert_evaluation_test_scores($agent_id, $test_code, $test_name, $test_date, $test_score, $admin_id, $comment){
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_evaluation_test_scores ";
		$sql .= " (agent_id, test_code, test_name, test_date, test_score, admin_id, status, update_datetime, comment) ";
		$sql .= " values( '".$agent_id."', '".$test_code."', '".$test_name."', '".$test_date."', '".$test_score."', '".$admin_id."', '1', NOW(), '".$comment."')";
		//echo("<br>".$sql); exit;
		return $rs = $db_conn->Execute($sql);
	}
	
	function update_evaluation_test_scores($id, $agent_id, $test_code, $test_name, $test_date, $test_score, $admin_id, $del_bit, $comment){
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_evaluation_test_scores ";
		$sql .= "set agent_id = '".$agent_id."',test_code = '".$test_code."', test_name = '".$test_name."', test_date = '".$test_date."', test_score = '".$test_score."', admin_id = '".$admin_id."', update_datetime = NOW(), comment = '".$comment."', ";
		if ($del_bit == 0)
		{
			$sql .= " status = '1' ";
		}
		else if ($del_bit == 1)
		{
			$sql .= " status = '0' ";
		}
		$sql .= " where id = '".$id."'";
		/*$sql .= " (agent_id, test_name, test_date, test_score, admin_id, status, update_datetime) ";
		$sql .= " values( '".$agent_id."','".$test_name."', '".$test_date."', '".$test_score."', '".$admin_id."', '1', NOW())";*/
		//echo("<br>".$sql); exit;
		return $rs = $db_conn->Execute($sql);
	}
	
///////////////////////////////////// TEST SCORE /////////////////////////////////////////

	function get_evaluation_test_scores($test_code="", $startRec=0, $totalRec=0, $field="test_date", $order="asc", $fdate="", $tdate="", $agent_id=""){
	
		global $db_conn; global $db_prefix;
		
		$sql = "select t1.*, t2.admin_id, t2.full_name from ".$db_prefix."_evaluation_test_scores t1 left join ".$db_prefix."_admin t2 on t1.agent_id = t2.admin_id where 1=1 ";

		if((!empty($test_code)) && ($test_code != '0')){
			
			$sql.= " and t1.test_code = '".$test_code."' ";
		}
		
		if(!empty($agent_id) && $agent_id != 0){
			
			$sql.= " and t1.agent_id = ".$agent_id;
		}
		
		if(!empty($fdate) && !empty($tdate)){
			
			$sql.= " and (t1.test_date BETWEEN '".$fdate."' AND '".$tdate."')";
		}
		
		$sql.= " and t1.status = 1 ";
		//$sql.= " order by t1.$field $order";
		
		if ($startRec >= 0 && $totalRec > 0){
			$sql.= " limit ".$startRec.", ".$totalRec;
		}
		
		//echo $startRec."--".$totalRec;
		//echo("<br>".$sql); //exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	
	function get_distinct_testnames($test_code="", $startRec=0, $totalRec=0, $field="test_date", $order="asc", $fdate="", $tdate="") {
	
		global $db_conn; global $db_prefix;
		
		$sql = "select Distinct t1.test_name AS distinct_tname, t1.test_code AS distinct_tcode from ".$db_prefix."_evaluation_test_scores t1 where 1=1 ";
		
		if((!empty($test_code)) && ($test_code != '0')){
			
			$sql.= " and t1.test_code = '".$test_code."' ";
		}
		
		if(!empty($fdate) && !empty($tdate)){
			
			$sql.= " and (t1.test_date BETWEEN '".$fdate."' AND '".$tdate."')";
		}
		
		$sql.= " and t1.status = 1 ";
		//$sql.= " order by t1.$field $order";
		
		if ($startRec >= 0 && $totalRec > 0){
			$sql.= " limit ".$startRec.", ".$totalRec;
		}
		
		//echo $startRec."--".$totalRec;
		//echo("<br>".$sql); //exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
	
	function get_test_agents($agent_id="", /*$test_code="",*/ $field="test_date", $order="asc", $fdate="", $tdate=""){
	
		global $db_conn; global $db_prefix;
		
		$sql = "select distinct t1.agent_id AS agent_id, t2.full_name as full_name from ".$db_prefix."_evaluation_test_scores t1 left join ".$db_prefix."_admin t2 on t1.agent_id = t2.admin_id where 1=1 ";
		
/*		if((!empty($test_code)) && ($test_code != '0')){
			
			$sql.= " and t1.test_code = '".$test_code."' ";
		}		*/
		
/*		if(!empty($agent_id) && $agent_id != 0){
			
			$sql.= " and t1.agent_id = ".$agent_id;
		}*/
		
//		if(!empty($fdate) && !empty($tdate)){
//			
//			$sql.= " and (t1.test_date BETWEEN '".$fdate."' AND '".$tdate."')";
//		}
		$sql.= " and t1.status = 1 ";
		//$sql.= " order by t1.$field $order";
		
		//echo $startRec."--".$totalRec;
		//echo("<br>".$sql); //exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	
	/****************************** IGET RECORDS  ************************************/
		function iget_records($alpha="", $startRec, $totalRec=80, $field="calldate", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today){
			global $db_conn; global $db_prefix; 
			global $site_root;
			
			 $csv = '' ;
			 if($isexport == 0){
			 	 $db_export = $site_root."download/Call_Records_".$today.".csv";
	             $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//cdr.*
			$sql = "select cdr.dst, cdr.clid, cdr.call_status, cdr.call_type, cdr.uniqueid ,date(cdr.calldate) as date, time(cdr.calldate) as time, SEC_TO_TIME(cdr.duration) as Duration, admin.full_name as agent_name, admin.admin_id as agent_id  ";
			 if($isexport != 0)
			 {
			 	$sql .= " , cdr.calldate as calldate,  cdr.userfield as userfield  ";
			 }
			 $sql .= $csv." from ".$db_prefix."_cdr 
			as cdr 
			LEFT OUTER JOIN cc_admin AS admin
		    ON admin.admin_id = cdr.staff_id
			 where 1=1 ";
			 $sql.= " AND cdr.staff_id <> '' ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords)){
				if($search_keyword == "off_time")
				{
					$sql.= " AND cdr.call_status = 'OFFTIME' AND DATE(cdr.calldate) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				if($search_keyword == "ans_call")
				{
					$sql.= " AND cdr.call_status = 'ANSWERED' AND  cdr.call_type = 'INBOUND' AND DATE(cdr.calldate) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				if($search_keyword == "drop_call")
				{
					$sql.= " AND cdr.call_status = 'DROP' AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				if($search_keyword == "agent_name")
				{
					$sql.= "  AND  admin.full_name <> '' AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				if($search_keyword == "in_bound")
				{
					$sql.= "  AND  cdr.call_type = 'INBOUND' AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				if($search_keyword == "out_bound")
				{
					$sql.= " AND cdr.call_type = 'OUTBOUND' AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				else
				{
					$sql.= "  AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."') ";
				}
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords)){
				//$sql.= " AND clid = '".$keywords."' or uniqueid = '".$keywords."' or uniqueid = '".$keywords."' AND DATE(calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				if($search_keyword == "caller_id")
				{
					$sql.= " AND cdr.clid = '".$keywords."' AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				/*if($search_keyword == "customer_id")
				{
					$sql.= " ";
					
				}*/
				if($search_keyword == "call-track_id")
				{
					$sql.= "  AND cdr.uniqueid = '".$keywords."' AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				/*if($search_keyword == "call_status")
				{
					$sql.= "  ";
				}*/
				if($search_keyword == "agent_name")
				{
					$sql.= "  AND  admin.full_name =  UPPER('".$keywords."') AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
					
				}
				if($search_keyword == "off_time")
				{
					$sql.= "  AND  cdr.call_status = 'OFFTIME' AND cdr.clid = '".$keywords."'  AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				if($search_keyword == "ans_call")
				{
					$sql.= "  AND  cdr.call_status = 'ANSWERED' AND cdr.clid = '".$keywords."'  AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				if($search_keyword == "drop_call")
				{
					$sql.= "  AND  cdr.call_status = 'DROP' AND cdr.clid = '".$keywords."'  AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				if($search_keyword == "in_bound")
				{
					$sql.= "  AND  cdr.call_type = 'INBOUND' AND cdr.clid = '".$keywords."'  AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
				if($search_keyword == "out_bound")
				{
					$sql.= "  AND  cdr.call_type =  'OUTBOUND' AND cdr.clid = '".$keywords."'  AND DATE(cdr.calldate) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
				}
			}
			else{
				$sql.= " AND DATE(cdr.calldate) = DATE(NOW())  ";
			}
			if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or cdr.uniqueid like '".$alpha."%')";
			}
			//$sql.= "and (cdr.channel LIKE '%DAHDI%') or (cdr.dstchannel LIKE '%DAHDI%')";
			
			$sql.= " order by $field $order";
			//$sql.= " limit $startRec, $totalRec";
			if($isexport == 0){
			//echo("<br>".$sql); exit;
			}
			//echo("<br>".$sql);exit;
			$rs = $db_conn->Execute($sql);
			
			//exit;
			return $rs;
        }
/********************************IGet Records End**************************************************/		
}
?>
