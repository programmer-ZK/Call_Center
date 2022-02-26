<?php
class user_tools{
	function user_tools(){
	}
	
		function get_user_workcodes($caller_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT GROUP_CONCAT(DISTINCT cc_call_workcodes.workcodes SEPARATOR ' | ') AS workcodes
FROM cc_call_workcodes  WHERE 1=1 ";
		$sql.= "AND caller_id ='".$caller_id."' GROUP BY unique_id  ORDER BY staff_updated_date DESC  LIMIT 10";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
    }
	
	
	
	function insert_human_verify($unique_id, $caller_id, $customer_id, $account_no, $name, $residence, $cnic_exp, $father_name, $mobile_no, $dob, $address, $status='1'){
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_human_verify  ";
		$sql .= "(id, unique_id, caller_id, customer_id, account_no, name, residence, cnic_exp, father_name, mobile_no, dob, address, staff_id, status, update_datetime) ";
		$sql .= " values( '','".$unique_id."','".$caller_id."', '".$customer_id."', '".$account_no."', '".$name."', '".$residence."','".$cnic_exp."','".$father_name."','".$mobile_no."','".$dob."','".$address."', '".$_SESSION[$db_prefix.'_UserId']."', '".$status."',NOW())";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
	}
    function get_agent_calls($agent_id){
		global $db_conn; global $db_prefix;
		$sql = "select DISTINCT(caller_id) from ".$db_prefix."_queue_stats ";
		if(!empty($agent_id)){
			$sql .= "where staff_id= '".$agent_id."'";
		}
		$sql.=" ORDER BY staff_updated_date desc ";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
    }
	function callcenter_stats(){
		global $db_conn; global $db_prefix;
		$sql = "SELECT status,COUNT(*) as cnt FROM ".$db_prefix."_queue_stats WHERE 1=1 AND DATE(update_datetime)= DATE(NOW()) GROUP BY status ORDER BY status DESC  ";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
    }
	function get_user_calls($caller_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT stats.unique_id,stats.update_datetime, admin.full_name as agent_name FROM ".$db_prefix."_queue_stats stats LEFT OUTER JOIN cc_admin AS admin
		    ON admin.admin_id = stats.staff_id WHERE 1=1 ";
		$sql.= "AND stats.caller_id ='".$caller_id."' AND stats.status = 0 and stats.staff_id ='".$_SESSION[$db_prefix.'_UserId']."' limit 5";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
    }
	function get_call_workcodes($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT * FROM ".$db_prefix."_call_workcodes WHERE 1=1 ";
		$sql.= "AND unique_id ='".$unique_id."'";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
    }
	function make_url($string,$url,$replace_pattern){
		/*
		$string 				= '<12345>';
		$url					= 'http://crm:8080/index.php?action=DetailView&module=HelpDesk&parenttab=Support&record=[TicketNumber]';
		$replace_pattern	= '[TicketNumber]';
		*/
		$patterns 				= "/^<\d+>$/";
		
		
		if(preg_match($patterns, $string)){
			//echo 'Match found';
			$string = str_replace('<', '', $string);
			$string = str_replace('>', '', $string);
			$url = str_replace($replace_pattern,$string,$url);
			return " &nbsp;<a href='".$url."' title='click here'>[".$string."]</a> &nbsp;";
		}
		else{
			//echo 'No match found';
			return $string;
		}
	}
	
	function get_call_details($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT enqueue_datetime AS call_date,TIMEDIFF(NOW(),enqueue_datetime) AS wait_duration,TIMEDIFF(dequeue_datetime,enqueue_datetime) AS duration,full_name AS agent_name,".$db_prefix."_queue_stats.customer_id AS customer_id  FROM ".$db_prefix."_queue_stats,".$db_prefix."_admin WHERE ".$db_prefix."_queue_stats.staff_id=".$db_prefix."_admin.admin_id ";
		$sql.= "AND ".$db_prefix."_queue_stats.unique_id ='".$unique_id."'";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
    }
    function get_cdr_details($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT * from ".$db_prefix."_cdr WHERE uniqueid ='".$unique_id."'";
		//$sql = "SELECT * from ".$db_prefix."_cdr as cdr, ".$db_prefix."_queue_stats as stats WHERE stats.unique_id ='".$unique_id."' and cdr.uniqueid = stats.unique_id";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
    }
    function iget_cdr_details($unique_id,$id=""){
		global $db_conn; global $db_prefix;
		if($id){
		 $sql = "SELECT * from ".$db_prefix."_vu_queue_stats WHERE unique_id ='".$unique_id."' AND id='".$id."'";
		}else{
		 $sql = "SELECT * from ".$db_prefix."_vu_queue_stats WHERE unique_id ='".$unique_id."'";
		}
		
                //echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
    }
    function iget_call_workcodes($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT GROUP_CONCAT(workcodes) as workcodes FROM ".$db_prefix."_call_workcodes WHERE 1=1 ";
		$sql.= "AND unique_id ='".$unique_id."'";
                //echo($sql); exit();
                $rs = $db_conn->Execute($sql);
		return $rs->fields["workcodes"];
    }
    function iget_call_pin_generate($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT count(*) as cnt FROM ".$db_prefix."_user_pin s , ".$db_prefix."_vu_queue_stats q WHERE s.unique_id = q.unique_id AND s.staff_id=q.staff_id ";
		$sql.= "AND s.unique_id ='".$unique_id."'";
                //echo($sql); exit();
                $rs = $db_conn->Execute($sql);
		return $rs->fields["cnt"];
    }
    function iget_call_pin_verify($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT count(*) as cnt FROM ".$db_prefix."_user_pin_verify s , ".$db_prefix."_vu_queue_stats q WHERE s.unique_id = q.unique_id AND s.staff_id=q.staff_id ";
		$sql.= "AND s.unique_id ='".$unique_id."'";
                //echo($sql); exit();
                $rs = $db_conn->Execute($sql);
		return $rs->fields["cnt"];
    }
    function iget_call_pin_reset($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT count(*) as cnt FROM ".$db_prefix."_user_pin_reset s , ".$db_prefix."_vu_queue_stats q WHERE s.unique_id = q.unique_id AND s.staff_id=q.staff_id ";
		$sql.= "AND s.unique_id ='".$unique_id."'";
                //echo($sql); exit();
                $rs = $db_conn->Execute($sql);
		return $rs->fields["cnt"];
    }
    function iget_call_pin_change($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT count(*) as cnt FROM ".$db_prefix."_user_pin_change s , ".$db_prefix."_vu_queue_stats q WHERE s.unique_id = q.unique_id AND s.staff_id=q.staff_id ";
		$sql.= "AND s.unique_id ='".$unique_id."'";
                $rs = $db_conn->Execute($sql);
		return $rs->fields["cnt"];
    }
    function iget_holdtime($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT SEC_TO_TIME( SUM( TIME_TO_SEC(TIMEDIFF(end_datetime,start_datetime) ) ) ) AS total_holdtime FROM ".$db_prefix."_hold_calls s , ".$db_prefix."_vu_queue_stats q WHERE s.unique_id = q.unique_id AND s.staff_id=q.staff_id ";
		$sql.= "AND s.unique_id ='".$unique_id."'";
                //echo($sql); exit();
                $rs = $db_conn->Execute($sql);
		return $rs->fields["total_holdtime"];
    }
    function iget_call_abandon($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT GROUP_CONCAT(full_name) as full_name FROM ".$db_prefix."_abandon_calls s , ".$db_prefix."_admin q WHERE s.staff_id=q.admin_id ";
		$sql.= "AND s.unique_id ='".$unique_id."'";
                //echo($sql); exit();
                $rs = $db_conn->Execute($sql);
		return $rs->fields["full_name"];
    }
    function iget_conversion($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT GROUP_CONCAT(trans_id) as trans_id FROM ".$db_prefix."_conversion s , ".$db_prefix."_vu_queue_stats q WHERE s.unique_id = q.unique_id AND s.staff_id=q.staff_id ";
		$sql.= "AND s.unique_id ='".$unique_id."'";
                //echo($sql); exit();
                $rs = $db_conn->Execute($sql);
		return $rs->fields["trans_id"];
    }
    function iget_redemption($unique_id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT GROUP_CONCAT(trans_id) as trans_id FROM ".$db_prefix."_redemption s , ".$db_prefix."_vu_queue_stats q WHERE s.unique_id = q.unique_id AND s.staff_id=q.staff_id ";
		$sql.= "AND s.unique_id ='".$unique_id."'";
                //echo($sql); exit();
                $rs = $db_conn->Execute($sql);
		return $rs->fields["trans_id"];
    }
}
?>
