<?php

class task_list{
        function task_list(){
        }



	 function send_msg($title, $message)
        {
                        global $db_conn; global $db_prefix;
                        $sql  = "insert into ".$db_prefix."_task_list ";
                        $sql .= "( title, message, staff_id, update_datetime) ";
                        $sql .= "values ('".$title."','".$message."','".$_SESSION[$db_prefix.'_UserId']."',NOW())";
                        //echo $sql;
                        //exit();
                        return $rs = $db_conn->Execute($sql);


        }
	function get_tasks($from){
                global $db_conn; global $db_prefix;

                $sql = " SELECT ".$db_prefix."_task_list.* , ".$db_prefix."_admin.full_name ";
                $sql.= " from ".$db_prefix."_task_list,  ".$db_prefix."_admin";
                $sql.= " WHERE ".$db_prefix."_task_list.staff_id = ".$db_prefix."_admin.admin_id"; 
				if($from == "todo"){
					$sql.= " and DATEDIFF(NOW(),".$db_prefix."_task_list.deadline ) > 0" ;
				}
				else if($from == "complete")
				{
					$sql.= " and DATEDIFF(NOW(),".$db_prefix."_task_list.deadline ) < 0" ;
				}
				//$sql.= " order by $field $order";
				$sql.= " ORDER BY update_datetime";
				$sql.= " DESC";
		//$sql.= " LIMIT 0, 3; ";

//              $sql.= "order by FullName";
              //echo($sql);
              //exit();
                return $rs = $db_conn->Execute($sql);
        }
		
	function get_user_tasks($time){
                global $db_conn; global $db_prefix;

                $sql = " SELECT ".$db_prefix."_task_list.* , ".$db_prefix."_admin.full_name ";
                $sql.= " from ".$db_prefix."_task_list,  ".$db_prefix."_admin";
                $sql.= " WHERE ".$db_prefix."_task_list.staff_id = ".$db_prefix."_admin.admin_id ";
				$sql.= " and ".$db_prefix."_task_list.assigned_to =".$_SESSION[$db_prefix.'_UserId']; 
				if($time){
					$sql.= " and DATEDIFF(".$db_prefix."_task_list.deadline ,NOW()) > 0" ;
				}
				else
				{
					$sql.= " and DATEDIFF(".$db_prefix."_task_list.deadline ,NOW() ) < 0" ;
				}
				$sql.= " ORDER BY update_datetime";
				$sql.= " DESC limit 5";
		//$sql.= " LIMIT 0, 3; ";

//              $sql.= "order by FullName";
              //echo($sql);
              //exit();
                return $rs = $db_conn->Execute($sql);
        }
	function set_tasks($title, $description, $deadline, $assign_to)
        {
                        global $db_conn; global $db_prefix;
                        $sql  = "insert into ".$db_prefix."_task_list ";
                        $sql .= "(id, staff_id, title, description, deadline, assigned_to, status,  update_datetime) ";
						if($assign_to == '' || $assign_to == 0)
						{
                        	$sql .= "values ('', '".$_SESSION[$db_prefix.'_UserId']."','".$title."','".$description."','".$deadline."','".$_SESSION[$db_prefix.'_UserId']."', '1',NOW())";
                        }
						else
						{
							$sql .= "values ('', '".$_SESSION[$db_prefix.'_UserId']."','".$title."','".$description."','".$deadline."','".$assign_to."', '1',NOW())";
						}
						//echo $sql;
                        //exit();
                        return $rs = $db_conn->Execute($sql);


        }
	function get_task_by_id($id){
		global $db_conn; global $db_prefix;
		$sql = "SELECT * FROM ".$db_prefix."_task_list ";
		$sql.=  "where id = '".$id."'" ;
		//echo $sql;
		return $db_conn->Execute($sql);
	}
	function task_id_exists($id=0){
		global $db_conn; global $db_prefix;
		$sql  = "select * from ".$db_prefix."_task_list where 1=1 ";
//		$sql .= " and full_name='".$username."'";
		if(!empty($id))
		$sql .= " and id <> '".$id."'";
		//echo($sql);
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
	function update_task($id, $title, $description, $deadline, $status='1'){
		global $db_conn; global $db_prefix;
		$sql  = "update ".$db_prefix."_task_list ";
		$sql .= " set title = '".strip_tags($title)."', description = '".strip_tags($description)."', deadline='".$deadline."', staff_id='".$_SESSION[$db_prefix.'_UserId']."' , assigned_to='".$_SESSION[$db_prefix.'_UserId']."' , update_datetime = NOW() ,status = '".$status."' ";

		$sql .= " where id = '".$id."'";
		//echo($sql);
		//exit();
		return $rs = $db_conn->Execute($sql);
	}
}
?>
