<?php

class quick_links{
        function quick_links(){
        }
	 function send_msg($title, $message) {
			global $db_conn; global $db_prefix;
			$sql  = "insert into ".$db_prefix."_quick_msgs ";
			$sql .= "( title, message, staff_id, update_datetime) ";
			$sql .= "values ('".$title."','".$message."','".$_SESSION[$db_prefix.'_UserId']."',NOW())";
			//echo $sql;exit();
			return $rs = $db_conn->Execute($sql);
        }
	function get_links($startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			
			/*
			$sql = " SELECT ".$db_prefix."_quick_links.* , ".$db_prefix."_admin.full_name ";
			$sql.= " from ".$db_prefix."_quick_links,  ".$db_prefix."_admin where 1=1 ";
			$sql.= " AND ".$db_prefix."_quick_links.staff_id = ".$db_prefix."_admin.admin_id"; 
			$sql.= " ORDER BY update_datetime";
			$sql.= " DESC";
			*/
			
			$sql = " SELECT ".$db_prefix."_quick_links.* ";
			$sql.= " from ".$db_prefix."_quick_links where 1=1 ";
			if($search_keyword == "title")
			{
				$sql.= " AND title like '%".$keywords."%'  AND DATE(update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."') ";
			}
			if($search_keyword == "url")
			{
				$sql.= " AND url like '%".$keywords."%'  AND DATE(update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."') ";
			}
			
			else
			{
				$sql.= " AND  DATE(update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."') ";
			}
			//$sql.= " AND status = '1' "; 
			$sql.= " ORDER BY $field ";
			$sql.= " $order";

			//echo($sql);exit();
			return $rs = $db_conn->Execute($sql);
        }
		function get_links_counts($startRec, $totalRec=80, $field="update_datetime", $order="desc", $fdate, $tdate, $search_keyword, $keywords){
			global $db_conn; global $db_prefix;
			$sql = " SELECT count(*) as tRec ";
			$sql.= " from ".$db_prefix."_quick_links where 1=1 ";
			if($search_keyword == "title")
			{
				$sql.= " AND title like '%".$keywords."%'  AND DATE(update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."') ";
			}
			if($search_keyword == "url")
			{
				$sql.= " AND url like '%".$keywords."%'  AND DATE(update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."') ";
			}
			else
			{
				$sql.= " AND  DATE(update_datetime) Between DATE('".$fdate."') AND DATE('".$tdate."') ";
			}
			//$sql.= " AND status = '1' "; 
			//$sql.= " ORDER BY $field ";
			//$sql.= " $order";

			//echo($sql);exit();
			$rs = $db_conn->Execute($sql);
            return $rs->fields["tRec"];
        }
	function get_links_active($field = 'update_datetime', $order='desc'){
			global $db_conn; global $db_prefix;
			$sql = " SELECT ".$db_prefix."_quick_links.* ";
			$sql.= " from ".$db_prefix."_quick_links where 1=1 ";
			$sql.= " AND status = '1' "; 
			$sql.= " ORDER BY $field ";
			$sql.= " $order";

			//echo($sql);exit();
			return $rs = $db_conn->Execute($sql);
        }
		
	function set_links($title, $url){
			global $db_conn; global $db_prefix;
			$sql  = "insert into ".$db_prefix."_quick_links ";
			$sql .= "(id, title, url, status, staff_id, update_datetime) ";
			$sql .= "values ('','".$title."','".$url."','1','".$_SESSION[$db_prefix.'_UserId']."',NOW())";
			//echo $sql;exit();
			return $rs = $db_conn->Execute($sql);
        }
	function get_links_by_id($id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT * FROM ".$db_prefix."_quick_links ";
		$sql.=  "where id = '".$id."'" ;
		//echo $sql;
		return $db_conn->Execute($sql);
	}
	function list_id_exists($id=0){
		global $db_conn; global $db_prefix;
		$sql  = "select * from ".$db_prefix."_quick_links where 1=1 ";
		if(!empty($id))
			$sql .= " and id <> '".$id."'";
		//echo($sql);exit();
		return $rs = $db_conn->Execute($sql);
	}
	function update_link_list($id, $title, $url, $status='1'){
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_quick_links ";
		$sql .= " set title = '".strip_tags($title)."', url = '".strip_tags($url)."', staff_id='".$_SESSION[$db_prefix.'_UserId']."' , update_datetime = NOW() ,status = '".$status."' ";
		$sql .= " where id = '".$id."'";
		//echo($sql);exit();
		return $rs = $db_conn->Execute($sql);
	}
	function delete_link($link_id){
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_quick_links ";
		$sql .= "set status = '0' ";
		$sql .= "where id = '".$link_id."'";
//		echo($sql);
//		exit();
		return $rs = $db_conn->Execute($sql);
	}
}
?>
