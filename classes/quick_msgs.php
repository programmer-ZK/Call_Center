<?php

class quick_msgs{
        function quick_msgs(){
        }
	 	function send_msg($title, $message) {
			global $db_conn; global $db_prefix;
			$sql  = "insert into ".$db_prefix."_quick_msgs ";
			$sql .= "( title, message, staff_id, update_datetime) ";
			$sql .= "values ('".$title."','".$message."','".$_SESSION[$db_prefix.'_UserId']."',NOW())";
			//echo $sql;exit();
			return $rs = $db_conn->Execute($sql);
        }
		function get_quick_msgs(){
			global $db_conn; global $db_prefix;
			$sql = " select title, message ";
			$sql.= " from ".$db_prefix."_quick_msgs";
			$sql.= " order by update_datetime";
			$sql.= " desc";
			//echo $sql;exit();
			return $rs = $db_conn->Execute($sql);
        }
}
