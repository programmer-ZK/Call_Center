<?php

class pin_reports{
        function pin_reports(){
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
		
/************** PIN GENERATE *******************/		
		function get_records_generate($alpha="", $startRec= '0', $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today){
			global $db_conn; global $db_prefix;
			
			global $site_root;
			
			 $csv = '' ;
			 $userfield = " ,userfield ";
			 if($isexport == 0){
			 $userfield = "";
			 	 $db_export = $site_root."download/Pin_Generated_Records_".$today.".csv";
	             $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//pin.*
			$sql = "select pin.unique_id, pin.caller_id, pin.customer_id, pin.status,date(pin.update_datetime) as date, time(pin.update_datetime) as time, full_name as agent_name ".$userfield." ".$csv." from ".$db_prefix."_user_pin 
			as pin 
			INNER JOIN cc_vu_queue_stats
    			ON pin.unique_id = cc_vu_queue_stats.unique_id
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(pin.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
					$sql.= " AND pin.caller_id = '".$keywords."' AND DATE(pin.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(pin.update_datetime) = DATE(NOW())  ";
			}
			/*if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
			}*/
			//$sql.= "and (pin.channel LIKE '%DAHDI%')";
			$sql.= " order by pin.$field $order";
			$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); exit;
			return $rs;
        }
		function get_counts_generate($alpha="", $startRec= '0', $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			
			
			$sql = "select count(*) tRec from ".$db_prefix."_user_pin 
			as pin 
			INNER JOIN cc_vu_queue_stats
    			ON pin.unique_id = cc_vu_queue_stats.unique_id
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(pin.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
					$sql.= " AND pin.caller_id = '".$keywords."' AND DATE(pin.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(pin.update_datetime) = DATE(NOW())  ";
			}
			
			$rs = $db_conn->Execute($sql);
            		return $rs->fields["tRec"];
        }
/************** PIN CHANGE *******************/	
		function get_records_change($alpha="", $startRec= '0', $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today){
			global $db_conn; global $db_prefix;
			global $site_root;
			
			 $csv = '' ;
			 $userfield = " ,userfield ";
			 if($isexport == 0){
			 	$userfield = "";
			 	$db_export = $site_root."download/Pin_Change_Records_".$today.".csv";
	             	 	$csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
			}
			
			$sql = "select pin.unique_id, pin.caller_id, pin.customer_id, pin.status,date(pin.update_datetime) as date, time(pin.update_datetime) as time, full_name as agent_name ".$userfield." ".$csv." from ".$db_prefix."_user_pin_change 
			as pin 
			INNER JOIN cc_vu_queue_stats
    			ON pin.unique_id = cc_vu_queue_stats.unique_id
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(pin.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
					$sql.= " AND pin.caller_id = '".$keywords."' AND DATE(pin.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(pin.update_datetime) = DATE(NOW())  ";
			}
			$sql.= " order by pin.$field $order";
			$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			return $rs;
        }
		function get_counts_change($alpha="", $startRec= '0', $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			$sql = "select count(*) tRec from ".$db_prefix."_user_pin_change 
			as pin
			INNER JOIN cc_vu_queue_stats
    			ON pin.unique_id = cc_vu_queue_stats.unique_id
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(pin.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
					$sql.= " AND pin.caller_id = '".$keywords."' AND DATE(pin.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(pin.update_datetime) = DATE(NOW())  ";
			}
			
			$rs = $db_conn->Execute($sql);
            		return $rs->fields["tRec"];
        }
/************** PIN VERIFY *******************/	
		function get_records_verified($alpha="", $startRec = '0', $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today){
			global $db_conn; global $db_prefix;
			global $site_root;
			
			 $csv = '' ;
			 $userfield = " ,userfield ";
			 if($isexport == 0){
			 $userfield = "";
			 	 $db_export = $site_root."download/Pin_Verification_Records_".$today.".csv";
	             $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			
			$sql = "select pin.unique_id, pin.caller_id, pin.customer_id, pin.status,date(pin.update_datetime) as date, time(pin.update_datetime) as time, full_name as agent_name ".$userfield." ".$csv." from ".$db_prefix."_user_pin_verify 
			as pin 
			INNER JOIN cc_vu_queue_stats
    			ON pin.unique_id = cc_vu_queue_stats.unique_id
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
				$sql.= " AND DATE(pin.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
				$sql.= " AND pin.caller_id = '".$keywords."' AND DATE(pin.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(pin.update_datetime) = DATE(NOW())  ";
			}
			$sql.= " order by pin.$field $order";
			$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
        }
		function get_counts_verified($alpha="", $startRec= '0', $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			$sql = "select count(*) tRec from ".$db_prefix."_user_pin_verify 
			as pin 
			INNER JOIN cc_vu_queue_stats
    			ON pin.unique_id = cc_vu_queue_stats.unique_id
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
				$sql.= " AND DATE(pin.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
				$sql.= " AND pin.caller_id = '".$keywords."' AND DATE(pin.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(pin.update_datetime) = DATE(NOW())  ";
			}
			
			$rs = $db_conn->Execute($sql);
            		return $rs->fields["tRec"];
        }
/************** PIN RESET *******************/	
		function get_records_reset($alpha="", $startRec='0', $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today){
			global $db_conn; global $db_prefix;
			global $site_root;
			
			 $csv = '' ;
			 $userfield = " ,userfield ";
			 if($isexport == 0){
			 $userfield = "";
			 	 $db_export = $site_root."download/Pin_Reset_Records_".$today.".csv";
	             $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			
			$sql = "select pin.unique_id, pin.caller_id, pin.customer_id, pin.status,date(pin.update_datetime) as date, time(pin.update_datetime) as time, full_name as agent_name ".$userfield." ".$csv." from ".$db_prefix."_user_pin_reset
			as pin 
			INNER JOIN cc_vu_queue_stats
    			ON pin.unique_id = cc_vu_queue_stats.unique_id
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
				$sql.= " AND DATE(pin.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
				$sql.= " AND pin.caller_id = '".$keywords."' AND DATE(pin.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(pin.update_datetime) = DATE(NOW())  ";
			}
			$sql.= " order by pin.$field $order";
			$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			return $rs;
        }
		function get_counts_reset($alpha="", $startRec= '0', $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			$sql = "select count(*) tRec from ".$db_prefix."_user_pin_reset
			as pin 
			INNER JOIN cc_vu_queue_stats
    			ON pin.unique_id = cc_vu_queue_stats.unique_id
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
				$sql.= " AND DATE(pin.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
				$sql.= " AND pin.caller_id = '".$keywords."' AND DATE(pin.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(pin.update_datetime) = DATE(NOW())  ";
			}
			
			$rs = $db_conn->Execute($sql);
            		return $rs->fields["tRec"];
        }
}
?>
