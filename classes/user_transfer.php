<?php
class user_transfer{
     function user_transfer(){
     }



	 function insert_user_transfer_process($unique_id,$caller_id,$account_no,$customer_id,$from_staff_id, $to_staff_id='', $user_verification)
     {
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_call_transfer ";
		$sql .= "(unique_id, caller_id, account_no, customer_id, from_staff_id, to_staff_id, user_verification, status, update_datetime) ";
		$sql .= " values ('".$unique_id."','".$caller_id."','".$account_no."','".$customer_id."','".$from_staff_id."','".$to_staff_id."','".$user_verification."','1',now())";
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
	 //update cc_user_pin set enc_pin ='', status ='3', update_datetime = NOW() where unique_id= '".$unique_id."' AND status = 2"
	 function user_pin_process_fail($unique_id,$caller_id,$account_no,$customer_id,$staff_id)
     {
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_user_pin ";
		$sql  .= " set status ='3', update_datetime = NOW()  ";
		$sql  .= " where unique_id= '".$unique_id."' AND status = 2";
		//echo $sql; exit();
		return $rs = $db_conn->Execute($sql);
     }

}
