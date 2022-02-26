
<?php
class email{

function email(){
	}
	
	function email_show($email_id)
	{
		global $db_conn; global $db_prefix;
		$sql  = "SELECT * FROM cc_email_functionality where id='$email_id'";
		//echo $sql;exit;
		return $rs = $db_conn->Execute($sql);
	}
	
	
		function get_agents_name($staff_id){

			global $db_conn; global $db_prefix; 
			$sql = "SELECT full_name from cc_admin where admin_id='$staff_id'";
	
			//echo("<br>".$sql); exit;
			$rs = $db_conn->Execute($sql);//print_r($rs);
			return $rs;
        }	
	
function email_functionality($to,$cc,$bcc, $subject, $body,$datetime,$staff_id,$fname)
	{
		global $db_conn; global $db_prefix;
		$sql  = "insert into cc_email_functionality";
		$sql .= "(to_address,cc,bcc,subject_of_email, body,sending_datetime,staff_id,filename) ";
		$sql .= "values('".$to."','".$cc."','".$bcc."', '".$subject."', '".strip_tags($body)."', NOW(),'".$_SESSION[$db_prefix.'_UserId']."','".$fname."')";
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
		 $sql = "SELECT count(*) as tRec from cc_email_functionality ORDER BY sending_datetime DESC   ";
			
			$rs = $db_conn->Execute($sql);
			     // echo("<br>".$sql); exit;
            return $rs->fields["tRec"];
        }
		

function get_records($startRec, $totalRec=80, $field="sending_datetime", $order="desc",$to,$bcc, $subject, $body,$datetime,$staff_id){

                global $db_conn; global $db_prefix;
                $sql = "SELECT * from cc_email_functionality  ORDER BY sending_datetime  DESC LIMIT $startRec ,$totalRec";
                $rs = $db_conn->Execute($sql);
            //  echo("<br>".$sql); exit;
                return $rs;
        }
		
	}
?>
