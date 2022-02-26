<?php

class registration_reports{
        function registration_reports(){
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

/************** IVR REGISTARTION TRANSACTION *******************/		
		function get_records_ivr($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			
			global $db_conn; global $db_prefix;
			$sql = "select ivr.*, userfield,date(ivr.update_datetime) as date, time(ivr.update_datetime) as time, admin.full_name as agent_name from ".$db_prefix."_ivr_registration as ivr 
			LEFT OUTER JOIN cc_admin AS admin
		    	ON admin.admin_id = ivr.staff_id
			INNER JOIN cc_cdr
    			ON ivr.unique_id = cc_cdr.uniqueid
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(ivr.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
			$sql.= " AND ivr.caller_id = '".$keywords."' AND DATE(ivr.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(ivr.update_datetime) = DATE(NOW())  ";
			}
			/*if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
			}*/
			//$sql.= "and (pin.channel LIKE '%DAHDI%')";
			$sql.= " order by $field $order";
			//$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
        }
		function get_records_ivr_counts($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			$sql = "select count(*) tRec from ".$db_prefix."_ivr_registration as ivr 
			LEFT OUTER JOIN cc_admin AS admin
		    	ON admin.admin_id = ivr.staff_id
			INNER JOIN cc_cdr
    			ON ivr.unique_id = cc_cdr.uniqueid
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(ivr.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
			$sql.= " AND ivr.caller_id = '".$keywords."' AND DATE(ivr.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(ivr.update_datetime) = DATE(NOW())  ";
			}
			/*if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
			}*/
			//$sql.= "and (pin.channel LIKE '%DAHDI%')";
			//$sql.= " order by $field $order";
			//$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			return $rs->fields["tRec"];
			//echo("<br>".$sql); 
			//exit;
			//return $rs;
        }
/************** SMS REGISTARTION TRANSACTION *******************/	
		function get_records_sms($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			$sql = "select sms.*, userfield,date(sms.update_datetime) as date, time(sms.update_datetime) as time, admin.full_name as agent_name from ".$db_prefix."_sms_registration as sms
			LEFT OUTER JOIN cc_admin AS admin
		    	ON admin.admin_id = sms.staff_id
			INNER JOIN cc_cdr
    			ON sms.unique_id = cc_cdr.uniqueid
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(sms.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
					$sql.= " AND sms.caller_id = '".$keywords."' AND DATE(sms.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(sms.update_datetime) = DATE(NOW())  ";
			}
			/*if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
			}*/
			//$sql.= "and (pin.channel LIKE '%DAHDI%')";
			$sql.= " order by $field $order";
			//$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
        }
		function get_records_sms_counts($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			$sql = "select count(*) tRec from ".$db_prefix."_sms_registration as sms
			LEFT OUTER JOIN cc_admin AS admin
		    	ON admin.admin_id = sms.staff_id
			INNER JOIN cc_cdr
    			ON sms.unique_id = cc_cdr.uniqueid
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(sms.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
					$sql.= " AND sms.caller_id = '".$keywords."' AND DATE(sms.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(sms.update_datetime) = DATE(NOW())  ";
			}
			/*if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
			}*/
			//$sql.= "and (pin.channel LIKE '%DAHDI%')";
			//$sql.= " order by $field $order";
			//$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			return $rs->fields["tRec"];
			//echo("<br>".$sql); 
			//exit;
			//return $rs;
        }

}
?>
