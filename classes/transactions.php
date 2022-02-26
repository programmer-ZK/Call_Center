<?php
class transactions{
	function transactions(){
	}
	 function set_redemption($account_no, $customer_id, $solution_type, $types_of_units, $unit, $amount, $percentage, $modeofpayment, $city_name, $account_type, $bank_account_no, $bank_account_title, $bank_name, $bank_branch_name, $bank_branch_code, $trans_id,$type1, $unique_id2, $caller_id2){
                global $db_conn; global $db_prefix;

                $sql  = "insert into ".$db_prefix."_redemption ";
                $sql .= " (id, account_no, customer_id, type1,solution_type, types_of_units, unit, amount, percentage, modeofpayment, city_name, account_type, bank_account_no, bank_account_title, bank_name, bank_branch_name, bank_branch_code, trans_id, channel, update_datetime, staff_id, unique_id, caller_id) ";
                $sql .= " values ('', '".$account_no."', '".$customer_id."', '".$type1."', '".$solution_type."', '".$types_of_units."', '".$unit."', '".$amount."', '".$percentage."', '".$modeofpayment."', '".$city_name."', '".$account_type."', '".$bank_account_no."', '".$bank_account_title."', '".$bank_name."', '".$bank_branch_name."', '".$bank_branch_code."', '".$trans_id."', 'IVR', NOW(), '".$_SESSION[$db_prefix.'_UserId']."','".$unique_id2."', '".$caller_id2."')";
               // echo($sql."<br/>$admin_site_id");
                //exit();
															
		return $db_conn->Execute($sql);
	
        }
		
		function set_conversion($account_no, $customer_id, $transaction_type, $transaction_nature, $from_fund, $from_unit_type, $to_fund, $to_unit_type, $units, $amount, $percentage, $trans_id, $channel='IVR',$unique_id, $caller_id){
                global $db_conn; global $db_prefix;

                $sql  = "insert into ".$db_prefix."_conversion ";
                $sql .= " (id, account_no, customer_id, transaction_type, transaction_nature, from_fund, from_unit_type, to_fund, to_unit_type, units, amount, percentage, trans_id, channel, update_datetime, staff_id, unique_id, caller_id) ";
                $sql .= " values ('', '".$account_no."', '".$customer_id."', '".$transaction_type."', '".$transaction_nature."', '".$from_fund."', '".$from_unit_type."', '".$to_fund."', '".$to_unit_type."', '".$units."', '".$amount."', '".$percentage."' , '".$trans_id."', 'IVR', NOW(), '".$_SESSION[$db_prefix.'_UserId']."','".$unique_id."', '".$caller_id."')";
                //echo($sql."<br/>$admin_site_id");
                //exit();
															
		return $db_conn->Execute($sql);
	
        }







}
?>
