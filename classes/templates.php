<?php
class templates{
	function templates(){
	}
	function get_admin_user_listing($admin_id=''){
		global $db_conn; global $db_prefix;

		$sql = " SELECT *, a.status as status ";
		$sql.= " from ".$db_prefix."_admin a, ".$db_prefix."_admin_groups ag ";
		$sql.= " WHERE a.group_id = ag.id ";

//		$sql.= "order by FullName";
//		echo($sql);
//		exit();
		return $rs = $db_conn->Execute($sql);
	}
	function get_records_count($alpha=""){

                global $db_conn; global $db_prefix;
                $sql = "select count(*) tRec from ".$db_prefix."_admin where 1=1 ";
                if(!empty($alpha)){
                        $sql.= "and full_name like '".$alpha."%' ";
                }
                $rs = $db_conn->Execute($sql);
                return $rs->fields["tRec"];
        }
	function get_records($alpha="", $startRec, $totalRec=80, $field="staff_updated_date", $order="asc", $template=''){

                global $db_conn; global $db_prefix;
                $sql = "select *,(SELECT full_name FROM cc_admin WHERE admin_id = staff_id) AS staff_name from ".$db_prefix."_".$template."_template where 1=1 ";
                if(!empty($alpha)){
                        $sql.= "and a.full_name like '".$alpha."%'";
		//	$sql.= "and a.group_id = ag.id";
                }
		//$sql.= " and a.group_id = ag.id";
                $sql.= " order by $field $order";
                $sql.= " limit $startRec, $totalRec;";

                $rs = $db_conn->Execute($sql);
                //echo("<br>".$sql); exit;
                return $rs;
        }

	function admin_user_name_exists($username,$Admin_ID=0){
		global $db_conn; global $db_prefix;
		$sql  = "select * from ".$db_prefix."_admin where 1=1 ";
		$sql .= " and full_name='".$username."'";
		if(!empty($Admin_ID))
		$sql .= " and admin_id <> '".$Admin_ID."'";
		//echo($sql);
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
	function insert_template($title, $subject, $body, $template_id, $status='1',$template = ''){
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_".$template."_template  ";
		$sql .= "(title, subject , body, status, staff_id, update_datetime) ";
		$sql .= "values('".strip_tags($title)."', '".$subject."', '".strip_tags($body)."', '".$status."', '".$_SESSION[$db_prefix.'_UserId']."', NOW())";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
	}
	function delete_admin_privileges($page_id,$page_group_id,$group_id,$status='1'){
		global $db_conn; global $db_prefix;
		$sql  = "DELETE FROM ".$db_prefix."_admin_privileges ";
		$sql.=  "where Page_Group_ID='".$page_group_id."' and Group_ID='".$group_id."' "; ;
		//Page_ID=".$page_id." and
		//echo $sql;
		$db_conn->Execute($sql);
	}
	function insert_admin_privileges($page_id,$page_group_id,$group_id,$status='1'){
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_admin_privileges ";
		$sql .= "(Page_ID, Page_Group_ID, Group_ID, Allow) ";
		$sql .= "values ('".$page_id."','".$page_group_id."','".$group_id."','".$status."')";
		//echo $sql;
		return $db_conn->Execute($sql);
	}
	function get_template_by_id($template_id, $template=''){
		global $db_conn; global $db_prefix;
		$sql = "SELECT * FROM ".$db_prefix."_".$template."_template ";
		$sql.=  " where id = '".$template_id."' " ;
		//echo $sql; exit;
		return $db_conn->Execute($sql);
	}
	function update_template($template_id,$title, $subject, $body, $status='1', $template){
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_".$template."_template ";
		$sql .= " set title = '".strip_tags($title)."', subject = '".strip_tags($subject)."', body = '".$body."', staff_id = '".$_SESSION[$db_prefix.'_UserId']."', status = '".$status."'";

		$sql .= " where id = '".$template_id."'";
		//echo($sql);
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
	function update_admin_user_password($admin_id, $password){
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_admin ";
		$sql .= "set password = '".$password."'";
		$sql .= "where admin_id = '".$admin_id."' ";
//		echo($sql);
//		exit();
		return $rs = $db_conn->Execute($sql);
	}
	function delete_template($template_id, $template=''){
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_".$template."_template ";
		$sql .= "set status = '0' ";
		$sql .= "where id = '".$template_id."'";
//		echo($sql);
//		exit();
		return $rs = $db_conn->Execute($sql);
	}

}
?>
