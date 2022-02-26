<?php
class all_agent{
    function all_agent(){
    }
	
function get_agent_campaign_abandon_calls($admin_id,$date){

			global $db_conn; global $db_prefix;
			$sql = "SELECT count(*) as trec
FROM ".$db_prefix."_abandon_calls
WHERE 1=1 ";

					$sql.= " AND staff_id ='".$admin_id."' and unique_id in (select unique_id from cc_campaign_detail where staff_id ='".$admin_id."' AND DATE(update_datetime)='".$date."' )";

			$sql.= " AND DATE(update_datetime)='".$date."' ";
		//echo $sql;exit;
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
			
			
        }	
	
	function all_agents()
{ global $db_conn; global $db_prefix;
  
		$sql = "SELECT * FROM cc_admin WHERE STATUS = 1 AND designation = 'Agents' order by admin_id ";
        $rs = $db_conn->Execute($sql);
        return $rs;
    }	
	
	
	
	function get_agent_work_times($admin_id,$date){

			global $db_conn; global $db_prefix; //echo $admin_id;exit;
			
			$sql = "SELECT COUNT(*) AS trec,staff_id,TIME(MIN(login_datetime)) AS login_time,
TIME(MAX(logout_datetime)) AS logout_time, 
CASE TIME(MAX(login_datetime)) WHEN  TIME(MAX(logout_datetime)) THEN TIME(NOW()) 
	ELSE TIME(MAX(logout_datetime))
	END 
AS logout_time, 
CASE TIME(MAX(login_datetime)) WHEN   TIME(MAX(logout_datetime)) THEN TIMEDIFF(NOW(),MIN(login_datetime)) 
ELSE TIMEDIFF(MAX(logout_datetime),MIN(login_datetime)) 
	END AS duration 
		FROM cc_login_activity 
	WHERE  1=1 ";
		
		$sql.= "AND staff_id ='".$admin_id."'";//echo("<br>".$sql); //exit;

			$sql.= "AND DATE(login_datetime)='".$date."' AND DATE(logout_datetime)='".$date."'";
			$sql.= "GROUP BY staff_id order by staff_id";
			//echo $sql;//exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
        }
	
	
	
	
	
	
	
		function get_agent_break_times_sum($admin_id,$date,$status){

			global $db_conn; global $db_prefix;
			$sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) AS duration,STATUS as crm_status FROM ".$db_prefix."_crm_activity WHERE 1=1 ";
			
					$sql.= "AND staff_id ='".$admin_id."'";
			
			$sql.= "AND DATE(update_datetime)='".$date."'";
			$sql.= " AND STATUS <> 6 ";
			$sql.= " AND STATUS <> 1 AND STATUS = '".$status."' ";
			$sql.= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			$sql.= " GROUP BY status ";
	
		//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
        }
	
	
	
		function get_agent_break_times_sum_2($admin_id,$date){

			global $db_conn; global $db_prefix;
			$sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) AS duration,STATUS as crm_status FROM ".$db_prefix."_crm_activity WHERE 1=1 ";
			
					$sql.= "AND staff_id ='".$admin_id."'";
			
			$sql.= "AND DATE(update_datetime)='".$date."'";
			$sql.= " AND STATUS <> 6 ";
			$sql.= " AND STATUS <> 1 AND STATUS IN (2,3,4,5) ";
			$sql.= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			
			//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
        }
		
				function get_agent_work_times_sum_2($admin_id,$date){

			global $db_conn; global $db_prefix;
			$sql = "SELECT COUNT(*) AS trec,staff_id,TIME(MIN(login_datetime)) AS login_time,
TIME(MAX(logout_datetime)) AS logout_time, 
CASE TIME(MAX(login_datetime)) WHEN  TIME(MAX(logout_datetime)) THEN TIME(NOW()) 
	ELSE TIME(MAX(logout_datetime))
	END 
AS logout_time, 
CASE TIME(MAX(login_datetime)) WHEN   TIME(MAX(logout_datetime)) THEN TIMEDIFF(NOW(),MIN(login_datetime)) 
ELSE TIMEDIFF(MAX(logout_datetime),MIN(login_datetime)) 
	END AS duration 
		FROM cc_login_activity 
	WHERE  1=1 ";
		
		$sql.= "AND staff_id ='".$admin_id."'";//echo("<br>".$sql); //exit;

			$sql.= "AND DATE(login_datetime)='".$date."' AND DATE(logout_datetime)='".$date."'";

			$rs = $db_conn->Execute($sql);
			return $rs;
        }
	
		
		
	
	
	function get_assignment_times_sum($admin_id,$date){

			global $db_conn; global $db_prefix;
			$sql = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime, start_datetime)))) AS duration,STATUS as crm_status FROM ".$db_prefix."_crm_activity WHERE 1=1 ";
			
					$sql.= "AND staff_id ='".$admin_id."'";
			
			$sql.= "AND DATE(update_datetime)='".$date."'";
			$sql.= " AND STATUS = 6 ";
			$sql.= " AND STATUS <> 1 ";
			$sql.= " AND TIMEDIFF(end_datetime, start_datetime) <> '00:00:00' ";
			
			
		//echo("<br>".$sql); //exit;
			$rs = $db_conn->Execute($sql);
			return $rs;
        }
	
	
	function get_agent_on_call_busy_times($admin_id,$date,$type){

			global $db_conn; global $db_prefix;
			$sql = "SELECT count(*) as cnt, staff_id,call_type,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(staff_end_datetime,staff_start_datetime)))) AS call_duration,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(update_datetime,staff_end_datetime)))) AS busy_duration
FROM ".$db_prefix."_queue_stats
WHERE 1=1 ";
			if($admin_id !=0 ){
					$sql.= "AND staff_id ='".$admin_id."'";
				
			}
		$sql.= "AND DATE(update_datetime)='".$date."' AND  call_type = '".$type."' ";
			$sql.= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";
			$sql.= "GROUP BY staff_id,call_type ";//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
        }
		
		function get_agent_abandon_calls2($admin_id,$date){

			global $db_conn; global $db_prefix;
			$sql = "SELECT count(*) as trec
FROM ".$db_prefix."_abandon_calls
WHERE 1=1 ";

					$sql.= " AND staff_id ='".$admin_id."'";

			$sql.= " AND DATE(update_datetime)='".$date."' ";
		//echo $sql;exit;
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
			
			
        }
		function get_work_time_utilized($admin_id,$date){

			global $db_conn; global $db_prefix;
			$sql = "SELECT count(*) as cnt, staff_id,call_type,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(staff_end_datetime,staff_start_datetime)))) AS call_duration,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(update_datetime,staff_end_datetime)))) AS busy_duration
FROM ".$db_prefix."_queue_stats
WHERE 1=1 ";
			if($admin_id !=0 ){
					$sql.= "AND staff_id ='".$admin_id."'";
				
			}
		$sql.= "AND DATE(update_datetime)='".$date."' ";
			$sql.= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";
			//$sql.= "GROUP BY staff_id,call_type ";//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
        }
		
	
	
	
		function get_agent_on_call_busy_times_sum($admin_id,$date){

			global $db_conn; global $db_prefix;
			$sql = "SELECT count(*) as cnt, staff_id,call_type,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(staff_end_datetime,staff_start_datetime)))) AS call_duration,SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(update_datetime,staff_end_datetime)))) AS busy_duration
FROM ".$db_prefix."_queue_stats
WHERE 1=1 ";
			
					$sql.= "AND staff_id ='".$admin_id."'";
				
	
		$sql.= "AND DATE(update_datetime)='".$date."' ";
			$sql.= "AND TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00' ";
	
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
        }
	
	
	
	
	
	
	
	
	
} ?>