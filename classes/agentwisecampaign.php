<?php
class agent{
    function agentwisecampaign(){
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





function crm_campaign_activity($agent_id,$sdate,$edate,$start_datetime,$end_datetime,$campaign_id)
{global $db_conn; global $db_prefix;

$sql="SELECT SEC_TO_TIME(SUM(TIMEDIFF(end_datetime,start_datetime))) as time,(SUM(DATEDIFF(end_datetime,start_datetime))) AS DAY  FROM cc_vu_new WHERE  ";
if($agent_id != '0' ){
$sql .= "and staff_id='".$agent_id."'";
}
if($sdate != '' and $edate != ''){
$sql .= "and start_datetime >= '".$sdate."' and end_datetime < '".$edate."'";
}

if (($campaign_id != 'all') && ($campaign_id != '')){
$sql .= "AND campaign_id='".$campaign_id."')";
}


//echo $sql;exit;
$rs = $db_conn->Execute($sql);
//echo $sql;exit;
return $rs;
}














    
}
?>

