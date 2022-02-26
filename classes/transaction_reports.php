<?php

class transaction_reports{
        function transaction_reports(){
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
		
/************** CONVERSION TRANSACTION *******************/		
		function get_records_conversion_x($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today){
			global $db_conn; global $db_prefix;
			global $site_root;
			
			 $csv = '' ;
			 $userfield = " ,userfield ";
			 if($isexport == 0){
			 $userfield = "";
			 	 $db_export = $site_root."download/Conversion_Records_".$today.".csv";
	             $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			// conversion.*
			$sql = "select conversion.unique_id, conversion.caller_id, conversion.customer_id, conversion.trans_id,date(conversion.update_datetime) as date, time(conversion.update_datetime) as time, admin.full_name as agent_name ".$userfield." ".$csv." from ".$db_prefix."_conversion as conversion 
			LEFT OUTER JOIN cc_admin AS admin
		    	ON admin.admin_id = conversion.staff_id
			INNER JOIN cc_cdr
    			ON conversion.unique_id = cc_cdr.uniqueid
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(conversion.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
			$sql.= " AND conversion.caller_id = '".$keywords."' AND DATE(conversion.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(conversion.update_datetime) = DATE(NOW())  ";
			}
			/*if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
			}*/
			//$sql.= "and (pin.channel LIKE '%DAHDI%')";
			$sql.= " and (conversion.trans_id LIKE 'IV%')";
			$sql.= " order by $field $order";
			$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
        }

                function get_records_conversion($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today){
                        global $db_conn; global $db_prefix;
                        global $site_root;

                         $csv = '' ;
                         $userfield = " ,userfield ";
                         if($isexport == 0){
                         $userfield = "";
                                 $db_export = $site_root."download/Conversion_Records_".$today.".csv";
                     $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
                                //echo $csv; exit;
                        }
                        // conversion.*
                        $sql = "SELECT  conversion.unique_id,  conversion.caller_id,  conversion.customer_id,  conversion.trans_id,  DATE(conversion.update_datetime) AS DATE,  TIME(conversion.update_datetime) AS TIME,  full_name        AS agent_name   ".$userfield." ".$csv." from ".$db_prefix."_conversion as conversion     INNER JOIN cc_vu_queue_stats   ON conversion.unique_id = cc_vu_queue_stats.unique_id  where 1=1 ";
                        if(!empty($fdate) && !empty($tdate) && empty($keywords))
                        {
                                        $sql.= " AND DATE(conversion.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";

                        }else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
                        {
                        $sql.= " AND conversion.caller_id = '".$keywords."' AND DATE(conversion.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
                        }
                        else{
                                $sql.= " AND DATE(conversion.update_datetime) = DATE(NOW())  ";
                        }
                        /*if(!empty($alpha)){
                                $sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
                        }*/
                        //$sql.= "and (pin.channel LIKE '%DAHDI%')";
                        $sql.= " and (conversion.trans_id LIKE 'IV%')";
                        $sql.= " order by conversion.$field $order";
                        $sql.= " limit $startRec, $totalRec";

                        $rs = $db_conn->Execute($sql);
                        //echo("<br>".$sql);
                        //exit;
                        return $rs;
}
		function get_counts_conversion_x($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			$sql = "select count(*) tRec from ".$db_prefix."_conversion as conversion 
			LEFT OUTER JOIN cc_admin AS admin
		    	ON admin.admin_id = conversion.staff_id
			INNER JOIN cc_cdr
    			ON conversion.unique_id = cc_cdr.uniqueid
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(conversion.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
			$sql.= " AND conversion.caller_id = '".$keywords."' AND DATE(conversion.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(conversion.update_datetime) = DATE(NOW())  ";
			}
			/*if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
			}*/
			$sql.= " and (conversion.trans_id LIKE 'IV%')";
			//$sql.= "and (pin.channel LIKE '%DAHDI%')";
			//$sql.= " order by $field $order";
			//$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			echo("<br>".$sql);
			exit;
            return $rs->fields["tRec"];
        }
                function get_counts_conversion($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
                        global $db_conn; global $db_prefix;
                        $sql = "select count(*) tRec from ".$db_prefix."_conversion as conversion
                          INNER JOIN cc_vu_queue_stats
			   ON conversion.unique_id = cc_vu_queue_stats.unique_id
                         where 1=1 ";
                        if(!empty($fdate) && !empty($tdate) && empty($keywords))
                        {
                                        $sql.= " AND DATE(conversion.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";

                        }else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
                        {
                        $sql.= " AND conversion.caller_id = '".$keywords."' AND DATE(conversion.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
                        }
                        else{
                                $sql.= " AND DATE(conversion.update_datetime) = DATE(NOW())  ";
                        }
                        /*if(!empty($alpha)){
                                $sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
                        }*/
                        $sql.= " and (conversion.trans_id LIKE 'IV%')";
                        //$sql.= "and (pin.channel LIKE '%DAHDI%')";
                        //$sql.= " order by $field $order";
                        //$sql.= " limit $startRec, $totalRec";

                        $rs = $db_conn->Execute($sql);
                      //  echo("<br>".$sql);
                       // exit;
            return $rs->fields["tRec"];
        }

/************** REDEMPTION  TRANSACTION *******************/	
		function get_records_redemption_x($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today){
			global $db_conn; global $db_prefix;
			global $site_root;
			
			 $csv = '' ;
			 $userfield = " ,userfield ";
			 if($isexport == 0){
			 $userfield = "";
			 	 $db_export = $site_root."download/Redemption_Records_".$today.".csv";
	             $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
				//echo $csv; exit;
			}
			//redemption.*
			$sql = "select redemption.unique_id, redemption.caller_id, redemption.customer_id, redemption.trans_id,date(redemption.update_datetime) as date, time(redemption.update_datetime) as time, admin.full_name as agent_name ".$userfield." ".$csv." from ".$db_prefix."_redemption as redemption
			LEFT OUTER JOIN cc_admin AS admin
		    	ON admin.admin_id = redemption.staff_id
			INNER JOIN cc_cdr
    			ON redemption.unique_id = cc_cdr.uniqueid
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(redemption.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
					$sql.= " AND redemption.caller_id = '".$keywords."' AND DATE(redemption.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(redemption.update_datetime) = DATE(NOW())  ";
			}
			/*if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
			}*/
			$sql.= " and (redemption.trans_id LIKE 'IV%')";
			//$sql.= "and (pin.channel LIKE '%DAHDI%')";
			$sql.= " order by $field $order";
			$sql.= " limit $startRec, $totalRec";
			
			$rs = $db_conn->Execute($sql);
			//echo("<br>".$sql); 
			//exit;
			return $rs;
        }
                function get_records_redemption($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today){
                        global $db_conn; global $db_prefix;
                        global $site_root;

                         $csv = '' ;
                         $userfield = " ,userfield ";
                         if($isexport == 0){
                         $userfield = "";
                                 $db_export = $site_root."download/Redemption_Records_".$today.".csv";
                     $csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
                                //echo $csv; exit;
                        }
                        //redemption.*
                        $sql = "SELECT  redemption.unique_id,  redemption.caller_id,  redemption.customer_id,  redemption.trans_id,  DATE(redemption.update_datetime) AS DATE,  TIME(redemption.update_datetime) AS TIME,  full_name  AS agent_name ".$userfield." ".$csv." from ".$db_prefix."_redemption as redemption
                         INNER JOIN cc_vu_queue_stats
			   ON redemption.unique_id = cc_vu_queue_stats.unique_id
                         where 1=1 ";
                        if(!empty($fdate) && !empty($tdate) && empty($keywords))
                        {
                                        $sql.= " AND DATE(redemption.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";

                        }else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
                        {
                                        $sql.= " AND redemption.caller_id = '".$keywords."' AND DATE(redemption.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
                        }
                        else{
                                $sql.= " AND DATE(redemption.update_datetime) = DATE(NOW())  ";
                        }
                        /*if(!empty($alpha)){
                                $sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
                        }*/
                        $sql.= " and (redemption.trans_id LIKE 'IV%')";
                        //$sql.= "and (pin.channel LIKE '%DAHDI%')";
                        $sql.= " order by redemption.$field $order";
                        $sql.= " limit $startRec, $totalRec";

                        $rs = $db_conn->Execute($sql);
                        //echo("<br>".$sql);
                        //exit;
                        return $rs;
}
		function get_counts_redemption_x($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			$sql = "select count(*) tRec from ".$db_prefix."_redemption as redemption
			LEFT OUTER JOIN cc_admin AS admin
		    	ON admin.admin_id = redemption.staff_id
			INNER JOIN cc_cdr
    			ON redemption.unique_id = cc_cdr.uniqueid
			 where 1=1 ";
			if(!empty($fdate) && !empty($tdate) && empty($keywords))
			{
					$sql.= " AND DATE(redemption.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";
				
			}else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
			{
					$sql.= " AND redemption.caller_id = '".$keywords."' AND DATE(redemption.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
			}
			else{
				$sql.= " AND DATE(redemption.update_datetime) = DATE(NOW())  ";
			}
			/*if(!empty($alpha)){
				$sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
			}*/
			$sql.= " and (redemption.trans_id LIKE 'IV%')";
			//$sql.= " order by $field $order";
			//$sql.= " limit $startRec, $totalRec";
                       // echo("<br>".$sql);
                       // exit;
 		
			$rs = $db_conn->Execute($sql);
            return $rs->fields["tRec"];
        }

                function get_counts_redemption($alpha="", $startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
                        global $db_conn; global $db_prefix;
                        $sql = "select count(*) tRec from ".$db_prefix."_redemption as redemption
			 INNER JOIN cc_vu_queue_stats
			   ON redemption.unique_id = cc_vu_queue_stats.unique_id
                         where 1=1 ";
                        if(!empty($fdate) && !empty($tdate) && empty($keywords))
                        {
                                        $sql.= " AND DATE(redemption.update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."')  ";

                        }else if(!empty($fdate) && !empty($tdate) && !empty($keywords))
                        {
                                        $sql.= " AND redemption.caller_id = '".$keywords."' AND DATE(redemption.update_datetime) Between  DATE('".$fdate."') AND DATE('".$tdate."')  ";
                        }
                        else{
                                $sql.= " AND DATE(redemption.update_datetime) = DATE(NOW())  ";
                        }
                        /*if(!empty($alpha)){
                                $sql.= "and (src like '".$alpha."%' or pin.uniqueid like '".$alpha."%')";
                        }*/
                        $sql.= " and (redemption.trans_id LIKE 'IV%')";
                        //$sql.= " order by $field $order";
                        //$sql.= " limit $startRec, $totalRec";
                       //echo("<br>".$sql);
                        //exit;

  
                        $rs = $db_conn->Execute($sql);
            return $rs->fields["tRec"];
        }


}
?>
