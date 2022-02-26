<?php
class campaign{
    function campaign(){
    }
	
function campaign_name($id)
	{
	global $db_conn; global $db_prefix;global $site_root;
		$sql ="SELECT campaign_name FROM cc_campaign WHERE campaign_id='".$id."' ";
		//echo $sql;exit;
		$rs = $db_conn->Execute($sql);
		
		return $rs;
	}





	function campaign_status($campaign_id)
	{
	global $db_conn; global $db_prefix;global $site_root;
		$sql ="SELECT COUNT(*) as numbers FROM cc_campaign_detail WHERE  STATUS!=0 AND attempts<3 AND campaign_id='".$campaign_id."' ";
		//echo $sql;exit;
		$rs = $db_conn->Execute($sql);
		
		return $rs;
	}

	
	
	 function update_campaign_status($campaign_id,$campaign_status){
	//echo $offer_id;exit;

	global $db_conn; global $db_prefix;global $site_root;
		$sql ="UPDATE cc_campaign SET campaign_status='".$campaign_status."', update_datetime = NOW() where campaign_id='".$campaign_id."' ";
		//echo $sql;exit;
		$rs = $db_conn->Execute($sql);
		
		return $rs;
	}

	
	
	
 function get_count_numbers($campaign_id,$startRec, $totalRec=80, $field="update_datetime", $order="desc", $name, $cnic, $caller_id,$caller_id2, $caller_id3, $city,$source,$other){
        global $db_conn; global $db_prefix;
        $sql = "SELECT count(*) as tRec from ".$db_prefix."_campaign_detail where campaign_id='$campaign_id' ORDER BY update_datetime DESC  ";
			//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs->fields["tRec"];
    }
	
	
	function get_numbers($campaign_id,$startRec, $totalRec=80, $field="update_datetime", $order="desc",  $name, $cnic, $caller_id,$caller_id2, $caller_id3, $city,$source,$other){
        global $db_conn; global $db_prefix;
        $sql = "SELECT * from ".$db_prefix."_campaign_detail where campaign_id='$campaign_id'  ORDER BY update_datetime DESC LIMIT $startRec ,$totalRec";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
    }
	
	
	
function update_caller_list($campaign_id,$name, $cnic, $caller_id,$caller_id2, $caller_id3, $city,$ic,$source,$other){

        global $db_conn; global $db_prefix;

        $sql  = "update ".$db_prefix."_campaign_detail";
        $sql .= " set name = '".strip_tags($name)."', cnic = '".strip_tags($cnic)."',caller_id = '".$caller_id."', caller_id2 = '".$caller_id2."',caller_id3='".$caller_id3."',city='".$city."', ic = '".ic."', source = '".$source."'";
        $sql .= " where campaign_id = '".$campaign_id."' ";
       	//echo($sql);exit();
        return $rs = $db_conn->Execute($sql);
    }
	
	
	
	
	

function campaign_answers($campaign_id,$unique_id,$question,$answer){
        global $db_conn; global $db_prefix;
        $sql  = "insert into ".$db_prefix."_campaign_answers";
        $sql .= "(campaign_id,unique_id,question,answer) ";
       $sql .= "values('".$campaign_id."', '".$unique_id."','".$question."','".$answer."')";
       
      
   //  echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $db_conn->Insert_ID();
    }
function total_hours($campaign_id)
{
global $db_conn; global $db_prefix;
$sql="SELECT SEC_TO_TIME(AVG(TIME_TO_SEC(talktime))) as avg_time,SEC_TO_TIME(SUM(TIME_TO_SEC(talktime))) as tRec from cc_vu_cam_analytics WHERE unique_id IN (SELECT unique_id  FROM cc_campaign_detail WHERE campaign_id='$campaign_id')";
//echo $sql;exit;
$rs = $db_conn->Execute($sql );
return $rs;

}
function no_of_calls($campaign_id)
{global $db_conn; global $db_prefix;
$sql="SELECT sum(attempts) as tRec FROM cc_campaign_detail WHERE campaign_id ='$campaign_id'";
$rs = $db_conn->Execute($sql );
return $rs->fields["tRec"];
}
function count_agents($campaign_id)
{
global $db_conn; global $db_prefix;

$sql1="SELECT agent FROM cc_campaign WHERE campaign_id='$campaign_id'";
$rs1 = $db_conn->Execute($sql1);
//echo $sql1;exit;
$sql="SELECT count(*) as count_agents FROM cc_admin WHERE admin_id IN ( ".$rs1->fields['agent'].")";
//echo $sql;exit;
$rs = $db_conn->Execute($sql);
return $rs;

}
function hold_time($campaign_id)
{
 global $db_conn; global $db_prefix;
$sql="SELECT SEC_TO_TIME(AVG(TIMEDIFF(end_datetime,start_datetime))) as on_hold FROM cc_hold_calls WHERE unique_id IN (SELECT unique_id  FROM cc_campaign_detail WHERE campaign_id='$campaign_id')";
$rs = $db_conn->Execute($sql);
//echo $sql;exit;
//print_r ($rs);exit;
return $rs;

}


function agent_wise($campaign_id)
{
 global $db_conn; global $db_prefix;
$sql="SELECT cc_vu_queue_stats.full_name,SEC_TO_TIME(SUM(TIMEDIFF(cc_hold_calls.end_datetime,cc_hold_calls.start_datetime))) as time ,cc_hold_calls.unique_id FROM cc_hold_calls,cc_vu_queue_stats WHERE cc_vu_queue_stats.unique_id = cc_hold_calls.unique_id AND cc_hold_calls.unique_id IN (SELECT unique_id FROM cc_campaign_detail WHERE campaign_id='$campaign_id')

 ";
 //echo $sql;exit;
$rs = $db_conn->Execute($sql);
//echo $rs;exit;
return $rs;


}

function campaign_statistics($campaign_id)
{
global $db_conn; global $db_prefix;
	$sql="SELECT DISTINCT(call_status),COUNT(call_status) as call_status_count FROM cc_vu_queue_stats WHERE unique_id IN (SELECT unique_id  FROM cc_campaign_detail WHERE campaign_id='$campaign_id') GROUP BY call_status
";
	//echo $sql;exit;
	$rs = $db_conn->Execute($sql );
	//print_r ($rs);exit;
return $rs;

}

function campaign_duration($campaign_id)
{
global $db_conn; global $db_prefix;


$sql="SELECT DISTINCT(full_name),COUNT(full_name) as count_full_name FROM cc_vu_queue_stats WHERE unique_id IN (SELECT unique_id FROM cc_campaign_detail WHERE campaign_id='$campaign_id') GROUP BY full_name";


	$rs = $db_conn->Execute($sql );
	//print_r ($rs);exit;
return $rs;

}



function timeremaining($campaign_id)
{

global $db_conn; global $db_prefix;
	$sql="SELECT DATEDIFF(end_datetime,NOW()) as tRec FROM cc_campaign WHERE campaign_id = '$campaign_id'";
	//echo $sql;exit;
	$rs = $db_conn->Execute($sql );
return $rs->fields["tRec"];
}


function Number_of_days_hours($campaign_id)
{
global $db_conn; global $db_prefix;
$sql = "SELECT DATEDIFF(end_datetime,start_datetime) as tRec1 ,DATEDIFF(end_datetime,start_datetime)*24 as tRec FROM cc_campaign WHERE campaign_id = '$campaign_id';";
//echo $sql;exit;
$rs = $db_conn->Execute($sql);
return $rs;
}






function agent_wisetime($campaign_id){
      global $db_conn; global $db_prefix;
		$sql="SELECT full_name,SEC_TO_TIME(AVG(TIME_TO_SEC(talk_time))) AS agent_time FROM cc_vu_queue_stats WHERE unique_id IN (SELECT unique_id FROM cc_campaign_detail WHERE campaign_id='$campaign_id') AND call_status='CONNECTED' GROUP BY full_name";
//echo $sql;exit;
		$rs = $db_conn->Execute($sql);
		return $rs;
	} 



function name($campaign_id)
{
global $db_conn; global $db_prefix;

$sql1="SELECT agent FROM cc_campaign WHERE campaign_id='$campaign_id'";
$rs1 = $db_conn->Execute($sql1);
$sql="select admin_id,full_name from cc_admin WHERE admin_id IN ( ".$rs1->fields['agent'].")";
$rs = $db_conn->Execute($sql);
//echo $sql;exit;
return $rs;
}

function  campaign_progress($campaign_id)
{global $db_conn; global $db_prefix;
$sql1="SELECT agent FROM cc_campaign WHERE campaign_id='$campaign_id'";
$rs1 = $db_conn->Execute($sql1);
$sql="SELECT full_name ,status FROM cc_admin WHERE admin_id IN ( ".$rs1->fields['agent'].")";
$rs = $db_conn->Execute($sql);
return $rs;
}

function total_numbers($campaign_id)
{
global $db_conn; global $db_prefix;
$sql = "select count(caller_id) as tRec from cc_campaign_detail where  	campaign_id= '$campaign_id'";
$rs = $db_conn->Execute($sql);
return $rs->fields["tRec"];
}
	
	
	
	
	function questions($campaign_id){
      global $db_conn; global $db_prefix;
		$sql2="select  * from cc_campaign_questions  where campaign_id='$campaign_id'";
		//echo $sql2;exit;
		$result2 = $db_conn->Execute($sql2);
		return $result2;
		
	
	} 


  
   /* function create_campaign($cname,$cnature,$agent,$start_datetime,$end_datetime,$ischeme,$campaign_script,$campaign_status,$staff_id){
        global $db_conn; global $db_prefix;

        $sql  = "insert into ".$db_prefix."_campaign";
        $sql .= "(campaign_name, campaign_nature ,agent, start_datetime, end_datetime, investment_scheme, campaign_script";
        $sql .= ",campaign_status, staff_id,status, update_datetime) ";
        $sql .= "values('".strip_tags($cname)."', '".strip_tags($cnature)."', '".strip_tags($agent)."','".$start_datetime."','".$end_datetime."', '".strip_tags($ischeme)."','".$campaign_script."','".$campaign_status."','".$staff_id."','1',  NOW())";
         $rs = $db_conn->Execute($sql);
        return $db_conn->Insert_ID();
    } */


  function create_campaign($cname,$cnature,$agent,$start_datetime,$end_datetime,$ischeme,$campaign_script,$campaign_status,$staff_id,$source,$attempt){
        global $db_conn; global $db_prefix;

        $sql  = "insert into ".$db_prefix."_campaign";
        $sql .= "(campaign_name, campaign_nature ,agent, start_datetime, end_datetime, investment_scheme, campaign_script";
        $sql .= ",campaign_status, staff_id,status, update_datetime,source,attempts) ";
        $sql .= "values('".strip_tags($cname)."', '".strip_tags($cnature)."', '".strip_tags($agent)."','".$start_datetime."','".$end_datetime."', '".strip_tags($ischeme)."','".$campaign_script."','".$campaign_status."','".$staff_id."','1',  NOW(),'".strip_tags($source)."','".$attempt."')";
		//echo $sql;exit;
         $rs = $db_conn->Execute($sql);
        return $db_conn->Insert_ID();
    }


	function delete_questions($campaign_id){
	 global $db_conn; global $db_prefix;
        $sql  = "delete from cc_campaign_questions where campaign_id='$campaign_id'";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $rs;
	
	
	}
    function create_campaign_questions($campaign_id,$questions,$answer_type){
        global $db_conn; global $db_prefix;
        $sql  = "insert into ".$db_prefix."_campaign_questions";
        $sql .= "(campaign_id,questions ,answer_type) ";
        $sql .= "values('".$campaign_id."', '".$questions."','".$answer_type."')";
		//echo $sql;exit;
        $rs = $db_conn->Execute($sql);
        return $db_conn->Insert_ID();
    }

    function id_get($campaign_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT  *,campaign_id FROM ".$db_prefix."_campaign ORDER BY campaign_id DESC LIMIT 1";
        $rs = $db_conn->Execute($sql);
        // echo("<br>".$sql); exit;
        return $rs;
    }
function id_get2($campaign_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT  *,campaign_id FROM ".$db_prefix."_campaign ORDER BY campaign_id DESC";
        $rs = $db_conn->Execute($sql);
       //echo("<br>".$sql); exit;
        return $rs;
    }
function id_agent_wise($campaign_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT  * FROM ".$db_prefix."_campaign where campaign_id='$campaign_id'";
        $rs = $db_conn->Execute($sql);
        //echo("<br>".$sql); exit;
        return $rs;
    }


    function get_records($startRec, $totalRec=80, $field="update_datetime", $order="desc", $cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT * from ".$db_prefix."_campaign where status=1 ORDER BY campaign_id DESC LIMIT $startRec ,$totalRec";
        $rs = $db_conn->Execute($sql);
        //echo("<br>".$sql); exit;
        return $rs;
    }


    function get_list($staff_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT * from ".$db_prefix."_campaign where status=1  and DATE(NOW()) between DATE(start_datetime) and DATE(end_datetime) and campaign_status !='Postponed/Hold' and campaign_status!='Cancelled' ORDER BY update_datetime DESC ";
        $rs = $db_conn->Execute($sql);
    //echo("<br>".$sql);// exit;
        return $rs;
    }
  
  
    function delete_campaign($campaign_id){
        global $db_conn; global $db_prefix;
        $sql  = "update ".$db_prefix."_campaign ";
        $sql .= "set status = '0' ";
        $sql .= "where campaign_id = '".$campaign_id."'";
        //echo($sql);exit();
        return $rs = $db_conn->Execute($sql);
    }
    function get_campaign_by_id($campaign_id,$campaign){
        global $db_conn; global $db_prefix;
        $sql = "SELECT * FROM ".$db_prefix."_campaign ";
        $sql.=  "where campaign_id = '".$campaign_id."' ";
        //echo $sql;exit;
        return $db_conn->Execute($sql);
    }
  /*   function update_campaign($campaign_id,$cname,$cnature,$agent,$start_datetime,$end_datetime,$ischeme,$staff_id,$status='1',$campaign_script){
        global $db_conn; global $db_prefix;

        $sql  = "update ".$db_prefix."_campaign";
        $sql .= " set campaign_name = '".strip_tags($cname)."', campaign_nature = '".strip_tags($cnature)."'";
	if ($agent !='')	{$sql.= ",agent='".$agent."'";}
		$sql.=",start_datetime = '".$start_datetime."',end_datetime='".$end_datetime."',investment_scheme='".$ischeme."', staff_id = '".$_SESSION[$db_prefix.'_UserId']."', status = '".$status."',campaign_script='".strip_tags($campaign_script)."'";
        $sql .= " where campaign_id = '".$campaign_id."'";
        //echo($sql);exit();
        return $rs = $db_conn->Execute($sql);
    }*/

 function update_campaign($campaign_id,$cname,$cnature,$agent,$start_datetime,$end_datetime,$ischeme,$staff_id,$status='1',$campaign_script,$source,$attempt){
        global $db_conn; global $db_prefix;
//echo $status;exit;
        $sql  = "update ".$db_prefix."_campaign";
        $sql .= " set staff_id = '".$_SESSION[$db_prefix.'_UserId']."', status = '".$status."'";
		
		if ($cname !='')	{
		   $sql .=",campaign_name = '".strip_tags($cname)."'";}
		if ($cnature !='')	{
		   $sql .=",campaign_nature = '".strip_tags($cnature)."'";}
		if ($agent !='')	{
		   $sql .=",agent = '".strip_tags($agent)."'";}
		if ($start_datetime !='')	{
		   $sql .=",start_datetime = '".strip_tags($start_datetime)."'";}
		if ($end_datetime !='')	{
		   $sql .=",end_datetime = '".strip_tags($end_datetime)."'";}
		if ($ischeme !='')	{
		   $sql .=",investment_scheme = '".strip_tags($ischeme)."'";}
		if ($campaign_script !='')	{
		   $sql .=",campaign_script = '".strip_tags($campaign_script)."'";}
		if ($source !='')	{
		   $sql .=",source = '".strip_tags($source)."'";}
		 if ($attempt !='')	{
		   $sql .=",attempts = '".strip_tags($attempt)."'";}
		
		
			$sql .= " where campaign_id = '".$campaign_id."'";
		

   
      // echo($sql);exit();
        return $rs = $db_conn->Execute($sql);
    }


    function get_links($startRec, $totalRec=80, $field="update_datetime", $order="desc", $cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT * from ".$db_prefix."_campaign where status=1 ORDER BY update_datetime DESC LIMIT $startRec ,$totalRec  ";
        return $rs = $db_conn->Execute($sql);
    }
		
    function get_links_counts($startRec, $totalRec=2, $field="update_datetime", $order="desc",$cname, $cnature, $ischeme, $start_dtaetime, $end_datetime, $staff_id){
        global $db_conn; global $db_prefix;
        $sql = "SELECT count(*) as tRec from ".$db_prefix."_campaign where status=1 ORDER BY update_datetime DESC  ";
        $rs = $db_conn->Execute($sql);
        return $rs->fields["tRec"];
    }
    function set_campaign_detail_replace($campaign_id,$name,$cnic, $caller_id, $caller_id2, $caller_id3, $city, $ic, $source, $other, $staff_id){
        global $db_conn; global $db_prefix;
        $other = str_replace(",","",$other );
        $sql = "UPDATE ".$db_prefix."_campaign_detail SET staff_id = '".$staff_id."', status = 0, update_datetime= NOW() WHERE caller_id = '$caller_id'";
        $rs = $db_conn->Execute($sql);



 $other = str_replace(",","",$other );
        $sql = "INSERT INTO ".$db_prefix."_campaign_detail (campaign_id, name, cnic, caller_id, caller_id2, caller_id3, city, ic, source, other, staff_id, status, update_datetime)";
        $sql .= "values ('".$campaign_id."','".$name."','".$cnic."','0".$caller_id."','0".$caller_id2."','0".$caller_id3."','".$city."','".$ic."','".$source."','".$other."','".$staff_id."','1',NOW())";
       
//echo $sql1;exit;
 $rs = $db_conn->Execute($sql);
    }







   function set_campaign_detail_replace_new1($campaign_id,$staff_id){
        global $db_conn; global $db_prefix;
      $sql1 = "UPDATE ".$db_prefix."_campaign_detail SET staff_id = '".$staff_id."', status = 0 WHERE campaign_id = '$campaign_id'";
        $rs1 = $db_conn->Execute($sql1);
    }









   function set_campaign_detail_replace_new($campaign_id,$name,$cnic, $caller_id, $caller_id2, $caller_id3, $city, $ic, $source, $other, $staff_id){
        global $db_conn; global $db_prefix;
        $other = str_replace(",","",$other );
 

        $sql = "INSERT INTO ".$db_prefix."_campaign_detail (campaign_id, name, cnic, caller_id, caller_id2, caller_id3, city, ic, source, other, staff_id, status, update_datetime)";
        $sql .= "values ('".$campaign_id."','".$name."','".$cnic."','0".$caller_id."','".$caller_id2."','".$caller_id3."','".$city."','".$ic."','".$source."','".$other."','".$staff_id."','1',NOW())";
       
//echo $sql;exit;
 $rs = $db_conn->Execute($sql);
    }

















    function set_campaign_detail_duplicate($campaign_id,$name,$cnic, $caller_id, $caller_id2, $caller_id3, $city, $ic, $source, $other, $staff_id){
        global $db_conn; global $db_prefix;
	 $other = str_replace(",","",$other );
        $sql = "INSERT INTO ".$db_prefix."_campaign_detail (campaign_id, name, cnic, caller_id, caller_id2, caller_id3, city, ic, source, other, staff_id, status, update_datetime)";
        $sql .= "values ('".$campaign_id."','".$name."','".$cnic."','0".$caller_id."','".$caller_id2."','".$caller_id3."','".$city."','".$ic."','".$source."','".$other."','".$staff_id."','1',NOW())";
        $rs = $db_conn->Execute($sql);
    }
    function set_campaign_detail_ignore($campaign_id,$name,$cnic, $caller_id, $caller_id2, $caller_id3, $city, $ic, $source, $other, $staff_id){
        global $db_conn; global $db_prefix;
        $sql = "select * from ".$db_prefix."_campaign_detail WHERE caller_id = '0".$caller_id."' AND campaign_id = '".$campaign_id."' ";
        $rs = $db_conn->Execute($sql);
//echo $sql;exit;
        if($rs->RecordCount() == 0){
	 $other = str_replace(",","",$other );
            $sql = "INSERT INTO ".$db_prefix."_campaign_detail (campaign_id, name, cnic, caller_id, caller_id2, caller_id3, city, ic, source, other, staff_id, status, update_datetime)";
            $sql .= "values ('".$campaign_id."','".$name."','".$cnic."','0".$caller_id."','".$caller_id2."','".$caller_id3."','".$city."','".$ic."','".$source."','".$other."','".$staff_id."','1',NOW())";
            $rs = $db_conn->Execute($sql);
        }
    }
}
?>

