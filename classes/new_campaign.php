<?php
class new_campaign{
    function new_campaign(){
    }
	
	function  questions($campaign_id)
{global $db_conn; global $db_prefix;

$sql2="SELECT
 
GROUP_CONCAT(DISTINCT `cc_campaign_questions`.`questions` ORDER BY questions SEPARATOR ',') AS `questions` 
FROM cc_campaign_questions 


  where campaign_id = '".$campaign_id."' order by questions";
//echo $sql;//exit;
$rs2 = $db_conn->Execute($sql2);
//print_r ($rs2);exit;
return $rs2;
}
	
	function campaign_export_fw($campaign_id,$today){
        global $db_conn; global $db_prefix;
	global $site_root;
		
	$csv = '' ;
		
		 $db_export = $site_root."download/Campaign_Report.csv";
		 $csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\t' LINES TERMINATED BY '\n' ";
		
		
        $sql = "SELECT 
	IFNULL(cc_campaign_detail.name,''),
		IFNULL(cc_campaign_detail.cnic,''),
		IFNULL(cc_campaign_detail.caller_id,''),
		IFNULL(cc_campaign_detail.caller_id2,''),
		IFNULL(cc_campaign_detail.caller_id3,''),
		IFNULL(cc_campaign_detail.city,''),
		IFNULL(cc_campaign_detail.ic,''),
		IFNULL(cc_campaign_detail.source,''),
		IFNULL(cc_campaign_detail.other,''),
		IFNULL(cc_campaign_detail.attempts,''),
		
		cc_vu_latest.call_datetime,
		
		IFNULL(cc_vu_latest.customer_id,''),
		
		IFNULL(cc_vu_latest.account_no,''),
		
		
		cc_vu_latest.workcodes,
		IFNULL(cc_vu_latest.full_name,''),
		-- cc_vu_latest.detail,
		-- cc_vu_latest.answer
 IFNULL(cc_vu_latest.detail , ''),
		
	

	 IFNULL(cc_vu_latest.answer , '')
		
		";
		$sql .= $csv." 
		from cc_campaign_detail , cc_vu_latest 
		where cc_campaign_detail.campaign_id='$campaign_id' AND  
		cc_campaign_detail.unique_id=cc_vu_latest.unique_id
		
		
		ORDER BY cc_campaign_detail.update_datetime DESC ";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
function campaign_export($campaign_id){
        global $db_conn; global $db_prefix;
	global $site_root;
		
	$csv = '' ;
		
		 $db_export = $site_root."download/Campaign_Report_".$today.".csv";
		 $csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
		
		
        $sql = "SELECT cc_campaign_detail.name,
		cc_campaign_detail.cnic,
		cc_campaign_detail.caller_id,
		cc_campaign_detail.caller_id2,
		cc_campaign_detail.caller_id3,
		cc_campaign_detail.city,
		cc_campaign_detail.ic,
		cc_campaign_detail.source,
		cc_campaign_detail.other,
		cc_campaign_detail.attempts,
		GROUP_CONCAT(DISTINCT cc_call_workcodes.workcodes SEPARATOR ' | ') AS workcodes,
		(SELECT full_name FROM cc_admin WHERE admin_id = cc_call_workcodes.staff_id ) AS agent_name";
		$sql .= $csv." 
		from cc_campaign_detail , cc_call_workcodes 
		where cc_campaign_detail.campaign_id='$campaign_id' and 
		cc_campaign_detail.unique_id=cc_call_workcodes.unique_id ORDER BY cc_campaign_detail.update_datetime DESC ";
		echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }
	
	
	
	
function  change_campaign_statuses($status,$campaign_id)
{global $db_conn; global $db_prefix;

$sql="update cc_campaign set campaign_status = '".$status."' where campaign_id = '".$campaign_id."'";
//echo $sql;exit;
$rs = $db_conn->Execute($sql);
return $rs;
}




function  campaign_progress($campaign_id)
{global $db_conn; global $db_prefix;
$sql1="SELECT agent FROM cc_campaign WHERE campaign_id='$campaign_id'";
$rs1 = $db_conn->Execute($sql1);
$sql="SELECT full_name ,status FROM cc_admin WHERE admin_id IN ( ".$rs1->fields['agent'].")";
//echo $sql;exit;
$rs = $db_conn->Execute($sql);
return $rs;
}
function  associated_agents($campaign_id)
{global $db_conn; global $db_prefix;
$sql1="SELECT agent FROM cc_campaign WHERE campaign_id='$campaign_id'";
$rs1 = $db_conn->Execute($sql1);
$sql="SELECT count(*)as tRec FROM cc_admin WHERE admin_id IN ( ".$rs1->fields['agent'].")";
//echo $sql;//exit;
$rs = $db_conn->Execute($sql);
return $rs;
}


function total_numbers($campaign_id)
{
global $db_conn; global $db_prefix;
$sql = "select count(caller_id) as trec from cc_campaign_detail where  	campaign_id= '$campaign_id'";
$rs = $db_conn->Execute($sql);
//echo $sql;exit;
return $rs;
}
	
function total_questions($campaign_id)
{
global $db_conn; global $db_prefix;
$sql = "select count(distinct(question)) as trec from cc_campaign_answers where  	campaign_id= '$campaign_id'";
$rs = $db_conn->Execute($sql);
//echo $sql;exit;
return $rs;
}


function total_questions_new($campaign_id)
{
global $db_conn; global $db_prefix;
$sql = "select count(distinct(questions)) as trec from cc_campaign_questions where  	campaign_id= '$campaign_id'";
$rs = $db_conn->Execute($sql);
//echo $sql;exit;
return $rs;
}



    function id_get(){
        global $db_conn; global $db_prefix;
        $sql = "SELECT  * FROM ".$db_prefix."_campaign where status =1 ORDER BY campaign_id DESC ";
        $rs = $db_conn->Execute($sql);
        // echo("<br>".$sql); exit;
        return $rs;
    }
	function campaign_data($campaign_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT  *,campaign_id,date(start_datetime) as st , date(end_datetime) as et,datediff(end_datetime,start_datetime) as no_of_days FROM ".$db_prefix."_campaign where campaign_id = '".$campaign_id."' ORDER BY campaign_id DESC";
       
 //echo("<br>".$sql); exit;

 $rs = $db_conn->Execute($sql);
      
        return $rs;
    }





/*function no_of_calls($agent_id,$sdate,$edate,$campaign_id)
{global $db_conn; global $db_prefix;
$sql="SELECT COUNT(full_name) AS count_no_of_calls ,full_name FROM cc_vu_queue_stats WHERE call_type='CAMPAIGN' ";

if($sdate != '' and $edate != ''){
$sql .= "and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}
if ($campaign_id != ''){
$sql .= "and unique_id IN (select unique_id from cc_campaign_detail_logs where campaign_id='".$campaign_id."')";
}

echo $sql;exit;
$rs = $db_conn->Execute($sql );
return $rs;
}*/


function no_of_calls($agent_id,$sdate,$edate,$campaign_id)
{global $db_conn; global $db_prefix;
$sql="SELECT COUNT(full_name) AS count_no_of_calls ,full_name FROM cc_vu_new WHERE 1=1  ";

if($sdate != '' and $edate != ''){
$sql .= "and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}
if ($campaign_id != ''){
$sql .= "and  campaign_id='".$campaign_id."'";
}

//echo $sql;exit;
$rs = $db_conn->Execute($sql );
return $rs;
}
function no_of_callsnew($agent_id,$sdate,$edate,$campaign_id)
{global $db_conn; global $db_prefix;
$sql="SELECT sum(attempts) AS count_no_of_calls FROM cc_campaign_detail WHERE 1=1  ";

if($sdate != '' and $edate != ''){
$sql .= "and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}
if ($campaign_id != ''){
$sql .= "and  campaign_id='".$campaign_id."'";
}

//echo $sql;exit;
$rs = $db_conn->Execute($sql );
return $rs;
}


/*function agent_wisetime_time_hold($agent_id,$sdate,$edate,$campaign_id){
      global $db_conn; global $db_prefix;
		$sql="SELECT SEC_TO_TIME(SUM(TIMEDIFF(end_datetime,start_datetime))) as on_hold ,SEC_TO_TIME(AVG(TIMEDIFF(end_datetime,start_datetime))) as on_hold_avg FROM cc_hold_calls  WHERE 1=1  ";

if($sdate != '' and $edate != ''){
$sql .= "and start_datetime >= '".$sdate."' and end_datetime < '".$edate."'";
}
if ($campaign_id != ''){
$sql .= "and unique_id IN (select unique_id from cc_campaign_detail_logs where campaign_id='".$campaign_id."')";
}

$rs = $db_conn->Execute($sql);

//echo $sql;exit;
		
		return $rs;
	} */










function agent_wisetime_time_hold($agent_id,$sdate,$edate,$campaign_id){
      global $db_conn; global $db_prefix;
		$sql="SELECT SEC_TO_TIME(SUM(TIMEDIFF(end_datetime,start_datetime))) as on_hold ,SEC_TO_TIME(AVG(TIMEDIFF(end_datetime,start_datetime))) as on_hold_avg FROM cc_vu_new2  WHERE 1=1  ";

if($sdate != '' and $edate != ''){
$sql .= "and start_datetime >= '".$sdate."' and end_datetime < '".$edate."'";
}
if ($campaign_id != ''){
$sql .= "and campaign_id='".$campaign_id."'";
}

$rs = $db_conn->Execute($sql);

//echo $sql;exit;
		
		return $rs;
	} 




/*function agent_wisetime_time($agent_id,$sdate,$edate,$campaign_id){
      global $db_conn; global $db_prefix;
		$sql="SELECT full_name,SEC_TO_TIME(SUM(TIME_TO_SEC(talk_time))) AS agent_time,SEC_TO_TIME(AVG(TIME_TO_SEC(talk_time))) AS avg_agent_time FROM cc_vu_queue_stats WHERE  call_type='CAMPAIGN' ";
		
	
		
if($sdate != '' and $edate != ''){
$sql .= "and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}
if  ($campaign_id != ''){
$sql .= "and unique_id IN (select unique_id from cc_campaign_detail_logs where campaign_id='".$campaign_id."')";
}



		//echo $sql;exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
	} */


function agent_wisetime_time($agent_id,$sdate,$edate,$campaign_id){
      global $db_conn; global $db_prefix;
		$sql="SELECT full_name,SEC_TO_TIME(SUM(TIME_TO_SEC(talk_time))) AS agent_time,SEC_TO_TIME(AVG(TIME_TO_SEC(talk_time))) AS avg_agent_time FROM cc_vu_new WHERE 1=1  ";
		
	
		
if($sdate != '' and $edate != ''){
$sql .= "and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}
if  ($campaign_id != ''){
$sql .= "and campaign_id='".$campaign_id."'";
}



		//echo $sql;exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
	} 



function agent_wisetime_busy_time($agent_id,$sdate,$edate,$campaign_id){
      global $db_conn; global $db_prefix;
		$sql="SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(update_datetime,staff_end_datetime)))) AS busy_duration FROM cc_vu_new WHERE 1=1  ";
		
	
		
if($sdate != '' and $edate != ''){
$sql .= "and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}
if  ($campaign_id != ''){
$sql .= "and campaign_id='".$campaign_id."'";
}



		//echo $sql;exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
	} 



/*function call_statuses($agent_id,$sdate,$edate,$campaign_id)
{//echo $campaign_id;exit;
global $db_conn; global $db_prefix;
	$sql="SELECT DISTINCT(call_status),COUNT(call_status) as call_status_count FROM cc_vu_queue_stats   WHERE 1=1
";
if($sdate != '' and $edate != ''){
$sql .= "  and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}

if  ($campaign_id != ''){
$sql .= "and unique_id IN (select unique_id from cc_campaign_detail_logs where campaign_id='".$campaign_id."')";
}

$sql .= "GROUP BY call_status";
echo $sql;exit;
	$rs = $db_conn->Execute($sql );
	//print_r ($rs);exit;
return $rs;

}*/


function call_statuses($agent_id,$sdate,$edate,$campaign_id)
{//echo $campaign_id;exit;
global $db_conn; global $db_prefix;
	$sql="SELECT DISTINCT(workcodes) as call_status,COUNT(workcodes) as call_status_count FROM cc_vu_status  WHERE 1=1
";
if($sdate != '' and $edate != ''){
$sql .= "  and staff_start_datetime >= '".$sdate."' and staff_end_datetime < '".$edate."'";
}

if  ($campaign_id != ''){
$sql .= "and  campaign_id='".$campaign_id."'";
}

$sql .= "GROUP BY workcodes";
//echo $sql;exit;
	$rs = $db_conn->Execute($sql );
	//print_r ($rs);exit;
return $rs;

}


















}
?>

