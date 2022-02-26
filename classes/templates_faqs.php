<?php
class templates_faqs{
	function templates_faqs(){
	}
	
	function insert_template($title, $subject, $body, $template_id, $status='1',$template = ''){
		global $db_conn; global $db_prefix;
		$sql  = "insert into ".$db_prefix."_faqs_template  ";
		$sql .= "(category, question , body, status, staff_id, update_datetime) ";
		$sql .= "values('".strip_tags($title)."', '".$subject."', '".strip_tags($body)."', '".$status."', '".$_SESSION[$db_prefix.'_UserId']."', NOW())";
		//echo($sql); exit();
		return $rs = $db_conn->Execute($sql);
	}
	
	
	function get_template_by_id($template_id, $template=''){
		global $db_conn; global $db_prefix;
		$sql = "SELECT * FROM ".$db_prefix."_faqs_template ";
		$sql.=  " where id = '".$template_id."' " ;
		//echo $sql; exit;
		return $db_conn->Execute($sql);
	}
	function update_template($template_id,$title, $subject, $body, $status='1', $template){
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_faqs_template ";
		$sql .= " set category = '".strip_tags($title)."', question = '".strip_tags($subject)."', body = '".$body."', staff_id = '".$_SESSION[$db_prefix.'_UserId']."', status = '".$status."'";

		$sql .= " where id = '".$template_id."'";
		//echo($sql);
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
	function get_records($alpha="", $startRec, $totalRec=80, $field="staff_updated_date", $order="asc", $query=''){

                global $db_conn; global $db_prefix;
               // $sql = "select *,(SELECT full_name FROM cc_admin WHERE admin_id = staff_id) AS staff_name from ".$db_prefix."_faqs_template where 1=1 ";
			   $sql = "select * from ".$db_prefix."_faqs_template where 1=1 ";
                if(!empty($alpha)){
                        $sql.= "and a.full_name like '".$alpha."%'";
		//	old===>>  $sql.= "and a.group_id = ag.id";
                }
				if(!empty($query)){
					$sql.= $query;
				 }
		//	old===>>  $sql.= " and a.group_id = ag.id";
               // $sql.= " order by $field $order";
              //  $sql.= " limit $startRec, $totalRec;";
               // echo $sql;
                $rs = $db_conn->Execute($sql);
                //	old===>>  echo("<br>".$sql); exit;
                return $rs;
        }
	

}
?>
