<?php
class registration{
	function registration(){
	}
	 function set_ivr_registration($unique_id, $caller_id,$account_no, $customer_id, $residence, $residence_status, $office, $office_status, $mobile_no, $mobile_no_status, $staff_id, $status,$trans_id){
        global $db_conn; global $db_prefix;

		$sql  = "INSERT INTO `cc_ivr_registration`
		(`id`, `unique_id`, `caller_id`, `customer_id`, `account_no`, `residence`, `residence_status`,
		`office`, `office_status`, `mobile_no`, `mobile_no_status`, `staff_id`, `status`,
		`update_datetime`,`trans_id`) ";
		$sql .= " values ('', '".$unique_id."', '".$caller_id."', '".$account_no."', '".$customer_id."', '".$residence."', '".$residence_status."', '".$office."', '".$office_status."', '".$mobile_no."', '".$mobile_no_status."', '".$staff_id."',1,NOW(), '".$trans_id."')";
				
		//echo($sql."<br/>$admin_site_id");
		//exit();															
		return $db_conn->Execute($sql);
	
        }
		
	 function set_sms_registration($unique_id, $caller_id,$account_no, $customer_id, $mobile_no, $mobile_no_status, $staff_id, $status,$trans_id){
        global $db_conn; global $db_prefix;

		$sql  = "INSERT INTO `cc_sms_registration`
		(`id`, `unique_id`, `caller_id`, `customer_id`, `account_no`, `mobile_no`, `mobile_no_status`, `staff_id`, `status`,`update_datetime`,`trans_id`) ";
		$sql .= " values ('', '".$unique_id."', '".$caller_id."', '".$account_no."', '".$customer_id."','".$mobile_no."', '".$mobile_no_status."', '".$staff_id."',1,NOW(), '".$trans_id."')";
				
		//echo($sql."<br/>$admin_site_id");
		//exit();								
		return $db_conn->Execute($sql);
	
        }
}
?>
