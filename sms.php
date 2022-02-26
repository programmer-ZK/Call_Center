
<?php
class sms{

function email(){
	}
	
	function sms_show($sms_id)
	{
		global $db_conn; global $db_prefix;
		$sql  = "SELECT * FROM cc_sms where id='$sms_id'";
		//echo $sql;exit;
		return $rs = $db_conn->Execute($sql);
	}
	
	
	
	
function sms_save($number,$body,$datetime,$staff_id)
	{
		global $db_conn; global $db_prefix;
		$sql  = "insert into cc_sms";
		$sql .= "(number,body,sending_datetime,staff_id) ";
		$sql .= "values('".$number."','".strip_tags($body)."', NOW(),'".$_SESSION[$db_prefix.'_UserId']."')";
		//echo $sql;exit;
		return $rs = $db_conn->Execute($sql);
	}
	
function get_name($user_id)
{
		global $db_conn; global $db_prefix;
		 $sql = "SELECT full_name as tRec from cc_admin where admin_id ='".$user_id."'   ";
			
			$rs = $db_conn->Execute($sql);
			 echo("<br>".$sql); exit;
            return $rs->fields["tRec"];

}
	
	function get_links_counts($startRec, $totalRec=2, $field="sending_datetime", $order="desc",$to,$bcc, $subject, $body,$datetime,$staff_id){
			global $db_conn; global $db_prefix;
		 $sql = "SELECT count(*) as tRec from cc_sms ORDER BY sending_datetime DESC   ";
			
			$rs = $db_conn->Execute($sql);
			     // echo("<br>".$sql); exit;
            return $rs->fields["tRec"];
        }
		

function get_records($startRec, $totalRec=80, $field="sending_datetime", $order="desc",$to,$bcc, $subject, $body,$datetime,$staff_id){

                global $db_conn; global $db_prefix;
                $sql = "SELECT * from cc_sms  ORDER BY sending_datetime  DESC LIMIT $startRec ,$totalRec";
                $rs = $db_conn->Execute($sql);
            //  echo("<br>".$sql); exit;
                return $rs;
        }
		
	}
?>
