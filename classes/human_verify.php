<?php
class human_verify{
	function human_verify(){
	}
	function insert_human_verify($unique_id, $caller_id, $customer_id, $account_no, $name, $residence, $cnic_exp, $father_name, $mobile_no, $dob, $address, $secret_word, $mother_m_name,$status='1',$staff_id=0){
		global $db_conn; global $db_prefix;

		$sql  = "update ".$db_prefix."_queue_stats  ";
		$sql .= "set customer_id='".$customer_id."', account_no='".$account_no."' ";
		$sql .= "where unique_id='".$unique_id."' and caller_id='".$caller_id."' and staff_id='".$staff_id."'";		
		
		$rs = $db_conn->Execute($sql);
		
		$sql  = "insert into ".$db_prefix."_human_verify  ";
		$sql .= "(id, unique_id, caller_id, customer_id, account_no, name, residence, cnic_exp, father_name, mobile_no, dob, address, secret_word, mother_m_name, staff_id, status, update_datetime) ";
		$sql .= " values( '','".$unique_id."','".$caller_id."', '".$customer_id."', '".$account_no."', '".$name."', '".$residence."','".$cnic_exp."','".$father_name."','".$mobile_no."','".$dob."','".$address."','".$secret_word."' , '".$mother_m_name."', '".$staff_id."', '".$status."',NOW())";

		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
	}
	function check_human_verify($unique_id){
		global $db_conn; global $db_prefix;
		$sql  = "select * from ".$db_prefix."_human_verify  ";
		$sql .= " where unique_id =".$unique_id;
		return $rs = $db_conn->Execute($sql);
		//echo($sql); exit();
		//return $rs->fields["count"];
		
	}
	function skip_human_verify($unique_id, $caller_id, $customer_id, $account_no, $reason, $remarks, $staff_id, $status=1){
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_skip_verify  ";
		$sql .= "(id, unique_id, caller_id, customer_id, account_no, reason, remarks, staff_id, status, update_datetime) ";
		$sql .= " values( '','".$unique_id."','".$caller_id."', '".$customer_id."', '".$account_no."', '".$reason."', '".$remarks."','".$staff_id."','".$status."', NOW())";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
	}	
	
}
?>
