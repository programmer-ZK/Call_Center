<?php
class agent{
    function agent(){
    }
function agents_name($agent_id){
      global $db_conn; global $db_prefix;
		$sql="SELECT full_name from cc_admin where admin_id = '".$agent_id."'";
$rs = $db_conn->Execute($sql);

		
		return $rs;
	} 

	
function call_statuses($agent_id,$sdate,$edate,$campaign_id)
{//echo $campaign_id;exit;
global $db_conn; global $db_prefix;
	$sql="SELECT DISTINCT(call_status),COUNT(call_status) as call_status_count FROM cc_vu_queue_stats   WHERE 1=1
";
if($sdate != '' and $edate != ''){
$sql .= "  and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}
if($agent_id != ''){
$sql .= "  and staff_id = '".$agent_id."'";
}
if  ($campaign_id != 'all'){
$sql .= "and unique_id IN (select unique_id from cc_campaign_detail where campaign_id='".$campaign_id."')";
}
if  ($campaign_id == 'all'){
$sql .= "and unique_id IN (select unique_id from cc_campaign_detail where campaign_id IN (select campaign_id from cc_campaign where status = 1 AND unique_id IS NOT NULL))";
}
$sql .= "GROUP BY call_status";
//echo $sql;exit;
	$rs = $db_conn->Execute($sql );
	//print_r ($rs);exit;
return $rs;

}

function get_count_numbers($campaign_id,$startRec, $totalRec=80, $field="update_datetime", $order="desc", $attempts){//echo $value;exit;
        global $db_conn; global $db_prefix;
        $sql = "SELECT count(*) as tRec from ".$db_prefix."_campaign_detail_logs where campaign_id='$campaign_id' ";
		
		if($attempts != 'all'){
$sql .= "  and attempts = '".$attempts."'";
}
		$sql .= " ORDER BY update_datetime DESC  ";
	//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs->fields["tRec"];
    }


function get_numbers($campaign_id,$startRec, $totalRec=80, $field="update_datetime", $order="desc", $attempts ){
        global $db_conn; global $db_prefix;
        $sql = "SELECT * from ".$db_prefix."_campaign_detail_logs where campaign_id='$campaign_id' 
		
		";
		if(($attempts != 'all') &&($attempts != '')){
$sql .= "  and attempts = '".$attempts."'";
}
	
	
		$sql .= " ORDER BY update_datetime DESC LIMIT $startRec ,$totalRec";
		
		//echo $sql;//exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }

function campaign_number_feedback($number){
        global $db_conn; global $db_prefix;
        $sql = "SELECT rank from ".$db_prefix."_call_ranking where unique_id='$number' 
		
		";
		//echo $sql;//exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }

function call_number_feedback($number){
        global $db_conn; global $db_prefix;
        $sql = "SELECT workcodes from ".$db_prefix."_call_workcodes where unique_id='$number' 
		
		";
		//echo $sql;//exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }




function campaign_answers_data2($campaign_id,$question,$name,$caller_id)
{ global $db_conn; global $db_prefix;
  
		$sql = "SELECT answer FROM cc_campaign_answers WHERE campaign_id='$campaign_id' and question LIKE '$question' and unique_id=(select  distinct(unique_id) from cc_campaign_detail where campaign_id='$campaign_id' ";
		
		if ($name != ''){
		
		$sql .="and name='$name') ";
		}
		else {
		$sql .="and caller_id='$caller_id') ";
		}
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }	



function campaign_questions_second($campaign_id)
{ global $db_conn; global $db_prefix;
  
		$sql = "SELECT question,answer,count(answer) as tRec FROM cc_campaign_answers WHERE campaign_id='$campaign_id' group by answer  ";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }	


function customer_info($campaign_id,$recStartFrom, $page_records_limit)
{ global $db_conn; global $db_prefix;
       
		$sql = "SELECT name,caller_id,id  FROM cc_campaign_detail WHERE campaign_id='$campaign_id' LIMIT $recStartFrom ,$page_records_limit";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
		//echo $rs->fields["tRec"];
        return $rs;
    }
	
function count_customer_info($campaign_id,$recStartFrom, $page_records_limit, $field, $order)
{ global $db_conn; global $db_prefix;
       
		$sql = "SELECT count(*) as tRec  FROM cc_campaign_detail WHERE campaign_id='$campaign_id'";
	//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
		//echo $rs->fields["tRec"];
        return $rs->fields["tRec"];
    }	

function campaign_answers_data($campaign_id)
{ global $db_conn; global $db_prefix;
  
		$sql = "SELECT DISTINCT(question) FROM cc_campaign_answers WHERE campaign_id='$campaign_id' group by question ";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }		



	function campaign_questions_report($campaign_id)
{ global $db_conn; global $db_prefix;
  
		$sql = "SELECT DISTINCT(question) FROM cc_campaign_answers WHERE campaign_id='$campaign_id'  ";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }	
		function campaign_questions_report2($campaign_id)
{ global $db_conn; global $db_prefix;
  
		$sql = "SELECT answer FROM cc_campaign_answers WHERE campaign_id='$campaign_id'";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }	
	



	
function campaign_answers($campaign_id)
{ global $db_conn; global $db_prefix;
        $sql = "SELECT  *,COUNT(answer) as total FROM cc_campaign_answers where campaign_id='$campaign_id' GROUP BY answer";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }

function agents($agent_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT  * FROM ".$db_prefix."_admin ORDER BY full_name ";
		//echo("<br>".$sql); exit;
        $rs = $db_conn->Execute($sql);
		//print_r ($rs);exit;
        // echo("<br>".$sql); exit;
        return $rs;
    }	

 
function crm_campaign_activity($agent_id,$sdate,$edate,$start_datetime,$end_datetime,$campaign_id)
{global $db_conn; global $db_prefix;

$sql="
SELECT FLOOR(HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime,start_datetime)))))/24) AS DAY ,
SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end_datetime,start_datetime)))) AS time
FROM cc_crm_activity WHERE STATUS = 7 ";
if($agent_id != '0' ){
$sql .= "and staff_id='".$agent_id."'";
}
if($sdate != '' and $edate != ''){
$sql .= "and start_datetime >= '".$sdate."' and end_datetime < '".$edate."'";
}

if (($campaign_id != 'all') && ($campaign_id != '')){
$sql .= "AND DATE(update_datetime) 
IN(SELECT DISTINCT
(DATE(update_datetime)) FROM cc_campaign_detail WHERE campaign_id='".$campaign_id."')";
}

//if  ($campaign_id == 'all'){
//$sql .= "and DATE(start_datetime) IN (select date(start_datetime) from cc_campaign )
//AND DATE(end_datetime)IN (select date(end_datetime) from cc_campaign )";
//}
//echo $sql;exit;
$rs = $db_conn->Execute($sql);
//echo $sql;exit;
return $rs;
}




function no_of_calls($agent_id,$sdate,$edate,$campaign_id)
{global $db_conn; global $db_prefix;
$sql="SELECT COUNT(full_name) AS count_no_of_calls ,full_name FROM cc_vu_new WHERE   ";


if($agent_id != '0' ){
$sql .= " staff_id='".$agent_id."'";
}

if($sdate != '' and $edate != ''){
$sql .= "and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}
if (($campaign_id != 'all') && ($campaign_id != '')){
$sql .= "and campaign_id ='".$campaign_id."'";
}

//echo $sql;exit;
$rs = $db_conn->Execute($sql );
return $rs;
}


function agent_wisetime_time($agent_id,$sdate,$edate,$campaign_id){

      global $db_conn; global $db_prefix;
		$sql="SELECT full_name,SEC_TO_TIME(SUM(TIME_TO_SEC(talk_time))) AS agent_time,SEC_TO_TIME(AVG(TIME_TO_SEC(talk_time))) AS avg_agent_time FROM cc_vu_new WHERE  ";
		
	
if($agent_id != '0' ){
$sql .= " staff_id='".$agent_id."' ";
}		
if($sdate != '' and $edate != ''){
$sql .= "and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}
if (($campaign_id != 'all') && ($campaign_id != '')){
$sql .= "and campaign_id ='".$campaign_id."' ";
}



	//echo $sql;exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
}

 
	
function agent_wisetime_time_hold($agent_id,$sdate,$edate,$campaign_id){
      global $db_conn; global $db_prefix;
		$sql="SELECT SEC_TO_TIME(SUM(TIMEDIFF(end_datetime,start_datetime))) as on_hold ,SEC_TO_TIME(AVG(TIMEDIFF(end_datetime,start_datetime))) as on_hold_avg FROM cc_vu_new2  WHERE   ";


if($agent_id != '0'){
$sql .= " staff_id='".$agent_id."'";
}

if($sdate != '' and $edate != ''){
$sql .= "and start_datetime >= '".$sdate."' and end_datetime < '".$edate."'";
}
if (($campaign_id != 'all') && ($campaign_id != '')){
$sql .= "and campaign_id ='".$campaign_id."'";
}
//echo $sql;exit;
$rs = $db_conn->Execute($sql);


		
		return $rs;
	}
  function new_agents($agent_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT  admin_id,full_name FROM ".$db_prefix."_admin ORDER BY full_name ";
		//echo("<br>".$sql); exit;
        $rs = $db_conn->Execute($sql);
		//print_r ($rs);exit;
        // echo("<br>".$sql); exit;
        return $rs;
    }	
  function new_campaign($campaign_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT  campaign_id,campaign_name FROM ".$db_prefix."_campaign ORDER BY campaign_id DESC";
        $rs = $db_conn->Execute($sql);
      // echo("<br>".$sql); exit;
        return $rs;
    }
	function id_agent_wise($campaign_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT  start_datetime,end_datetime FROM ".$db_prefix."_campaign ";
		if ($campaign_id != 'all'){
		
	 $sql .= 	"where campaign_id='$campaign_id'";
	 }
        $rs = $db_conn->Execute($sql);
        //echo("<br>".$sql); exit;
        return $rs;
    }
    
}
?>

