<?php
class customers{

	function customers(){
	}
	function get_records($alpha="", $startRec, $totalRec=80, $field="staff_updated_date", $order="asc"){

		global $db_conn; global $db_prefix;
		$sql = "select * from ".$db_prefix."_customers where 1=1 ";
		if(!empty($alpha)){
			$sql.= "and first_name like '".$alpha."%' ";
		}
		$sql.= " order by $field $order";
		$sql.= " limit $startRec, $totalRec;";

		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); exit;
		return $rs;
	}
	function get_records_count($alpha=""){
		
		global $db_conn; global $db_prefix;
		$sql = "select count(*) tRec from ".$db_prefix."_customers where 1=1 ";
		if(!empty($alpha)){
			$sql.= "and first_name like '".$alpha."%' ";
		}
		$rs = $db_conn->Execute($sql);
		return $rs->fields["tRec"];
	}
	function insert_customers($caller_id, $first_name, $last_name, $father_name, $cnic, $email, $address, $city, $country, $contact_no, $cell_no, $product_info, $description, $status, $staff_id){
		global $db_conn; global $db_prefix;

			 $sql  = "INSERT INTO ".$db_prefix."_customers (caller_id,first_name,last_name,father_name,cnic,email,address,city,country,contact_no,cell_no,product_info,description,status,staff_id,update_datetime) values ";
			 $sql.= "('".$caller_id."','".$first_name."','".$last_name."','".$father_name."','".$cnic."','".$email."','".$address."','".$city."','".$country."','".$contact_no."','".$cell_no."','".$product_info."','".$description."','".$status."','".$staff_id."',NOW())";
      		 $rs = $db_conn->Execute($sql);
			 
	 		 //echo("<br>".$sql); exit;
			 return true;
	}
	function get_export_file($alpha="", $startRec, $totalRec=80, $field='name', $order="asc"){

		global $db_conn; global $db_prefix; global $site_root;
		$db_export = $site_root."table_1.csv";
		$csv =" INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
		
		$sql = "select name, email ".$csv."from ".$db_prefix."_table_1 where 1=1 ";
		if(!empty($alpha)){
			$sql.= "and name like '".$alpha."%' ";
		}
		$sql.= " order by $field $order";
		$sql.= " limit $startRec, $totalRec;";
		$rs = $db_conn->Execute($sql);
		//echo("<br>".$sql); exit;
		return $rs;
	}
	
	function integrety_check($cnic)	{
		//echo "start";
		#global $db_conn; global $db_prefix;
		$sql = "select * from ".$db_prefix."_customers where cnic=".$cnic;
		$rs = $db_conn->Execute($sql);
		//echo("<br>".$rs); exit;
		//return $rs;
	}
  	function get_customer($rec_id=0,$caller_id=0)
        {
               global $db_conn; global $db_prefix;
               $sql = "select * from ".$db_prefix."_customers where 1=1 ";
		if(!empty($rec_id)){
			$sql.=" and id='".$rec_id."'";
		}
		if(!empty($caller_id)){
                        $sql.=" and caller_id='".$caller_id."'";
                }
	       //echo $sql; exit;
               $rs = $db_conn->Execute($sql);
               return $rs;
        }
	function customer_update($caller_id,$first_name,$last_name,$father_name,$mother_name,$cnic,$email,$pin,$company_name,$city,$country,$type,$gender,$desc,$cell,$query,$staff_id,$id)
	{
		 global $db_conn; global $db_prefix;
	 	$sql  = "update ".$db_prefix."_customers SET caller_id='".$caller_id."',first_name='".$first_name."',last_name='".$last_name."',email='".$email."',company_name='".$company_name."',city='".$city."',gender='".$gender."',description='".$desc."',cell_no='".$cell."',query='".$query."' WHERE id ='".$id."'";
//               echo $sql; exit;
                $rs = $db_conn->Execute($sql);
                return true;
	
		//UPDATE Persons SET Age = '36'
	}	

}
?>
