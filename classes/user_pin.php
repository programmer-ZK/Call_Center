<?php
class user_pin{
     function user_pin(){
     }
	 function insert_user_pin_process($unique_id,$caller_id,$account_no,$customer_id,$staff_id)
     {
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_user_pin ";
		$sql .= "(unique_id, caller_id, account_no, customer_id, staff_id, status, update_datetime) ";
		$sql .= " values ('".$unique_id."','".$caller_id."','".$account_no."','".$customer_id."','".$staff_id."','2',now())";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     }
	 function insert_user_pin_change($unique_id,$caller_id,$account_no,$customer_id,$staff_id)
     {
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_user_pin_change ";
		$sql .= "(unique_id, caller_id, account_no, customer_id, staff_id, status, update_datetime) ";
		$sql .= " values ('".$unique_id."','".$caller_id."','".$account_no."','".$customer_id."','".$staff_id."','2',now())";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     }
	  function insert_user_pin_reset($unique_id,$caller_id,$account_no,$customer_id,$staff_id)
     {
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_user_pin_reset ";
		$sql .= "(unique_id, caller_id, account_no, customer_id, staff_id, status, update_datetime) ";
		$sql .= " values ('".$unique_id."','".$caller_id."','".$account_no."','".$customer_id."','".$staff_id."','2',now())";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     }
	 function insert_user_pin_verfiy($unique_id,$caller_id,$account_no,$customer_id,$staff_id)
     {
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_user_pin_verify ";
		$sql .= "(unique_id, caller_id, account_no, customer_id, staff_id, status, update_datetime) ";
		$sql .= "values ('".$unique_id."','".$caller_id."','".$account_no."','".$customer_id."','".$staff_id."','2',now())";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     }	 
	 function update_user_status($unique_id,$caller_id,$old_status,$new_status)
     {
		global $db_conn; global $db_prefix;
		$sql  = "update cc_queue_stats set status= '".$new_status."', update_datetime=NOW() where unique_id='".$unique_id."' and status='".$old_status."'";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     }

	 function user_pin_process_fail($unique_id,$caller_id,$account_no,$customer_id,$staff_id)
     {
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_user_pin ";
		$sql  .= " set status ='3', update_datetime = NOW()  ";
		$sql  .= " where unique_id= '".$unique_id."' AND status = 2";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     }
	 function user_pin_reset_fail($unique_id,$caller_id,$account_no,$customer_id,$staff_id)
     {
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_user_pin_reset ";
		$sql  .= " set status ='3', update_datetime = NOW()  ";
		$sql  .= " where unique_id= '".$unique_id."' AND status = 2";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     }
	 function user_pin_change_fail($unique_id,$caller_id,$account_no,$customer_id,$staff_id)
     {
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_user_pin_change ";
		$sql  .= " set status ='3', update_datetime = NOW()  ";
		$sql  .= " where unique_id= '".$unique_id."' AND status = 2";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     }
	 function user_pin_verify_check($unique_id,$caller_id,$account_no,$customer_id,$staff_id)
     {
		global $db_conn; global $db_prefix;
		$sql  = "select count(*) as cnt from ".$db_prefix."_user_pin_verify ";
		$sql  .= " where unique_id= '".$unique_id."' AND status = 1";
		$rs = $db_conn->Execute($sql);
		//echo $sql; exit();
		return $rs->fields["cnt"];
     }
	 ////////////////////////////////////////////
	 function user_outbound_hangup_no($unique_id)
     {
		global $db_conn; global $db_prefix;
		$sql   = "update ".$db_prefix."_outgoing_transfer_pin ";
		$sql  .= " set status ='2', update_datetime = NOW() ";
		$sql  .= " where (from_unique_id= '".$unique_id."' OR to_unique_id= '".$unique_id."') AND status = 1";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     } 
	 function user_outbound_hangup_yes($unique_id)
     {
		global $db_conn; global $db_prefix;
		$sql   = "update ".$db_prefix."_outgoing_transfer_pin ";
		$sql  .= " set status ='1', update_datetime = NOW() ";
		$sql  .= " where (from_unique_id= '".$unique_id."' OR to_unique_id= '".$unique_id."') AND status = 2";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     } 
}
