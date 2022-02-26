<?php
class security{
	function check_page_info($page_title, $page_name, $page_level, $page_menu_title, $page_group_id){
		global $db_conn; global $db_prefix;
		$sql  = "select * from ".$db_prefix."_pages where page_name='".$page_name."'";
		//echo($sql);exit;
		$rsPageExists = $db_conn->Execute($sql);
		if($rsPageExists->EOF){
			$sql  = "insert into ".$db_prefix."_pages ";
			$sql .= "(page_title, page_name, page_level, group_id, menu_title) ";
			$sql .= "values('".$page_title."', '".$page_name."', '".$page_level."', '".$page_group_id."', '".$page_menu_title."')";
			//echo($sql);exit;
			$rs = $db_conn->Execute($sql);
			return $db_conn->Insert_ID();
		}else{
			return $rsPageExists->fields['page_id'];
		}
		//echo($sql);
	}
	function get_page_privilege_by_group($group_id, $page_id){
		global $db_conn; global $db_prefix;
		$sql = "select Allow from ".$db_prefix."_admin_privileges where 1=1 ";
		$sql.= " and group_id='".$group_id."'";
		$sql.= " and page_id='".$page_id."'";
		$rs  = $db_conn->Execute($sql);
		//echo($sql."<br>");
		//exit;
		return $rs->fields['Allow'];
	}
}
?>
