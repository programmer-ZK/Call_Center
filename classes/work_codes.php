<?php

class work_codes{
        function work_codes(){
        }
	 	function insert_work_codes($unique_id, $caller_id, $workcodes, $agent_id,$value_desc) {
			global $db_conn; global $db_prefix;
			$sql  = "insert into ".$db_prefix."_call_workcodes ";
			$sql .= "( unique_id, caller_id, workcodes,detail, staff_id, staff_updated_date) ";
			$sql .= "values ('".$unique_id."','".$caller_id."','".$workcodes."','".$value_desc."','".$agent_id."',NOW())";
			//echo $sql;exit();			
			return $rs = $db_conn->Execute($sql);
        }
		function get_workcodes_for_values($unique_id,$caller_id,$account_no,$customer_id,$staff_id){
			global $db_conn; global $db_prefix;
			$sql   = "SELECT wc_title FROM cc_workcodes WHERE wc_title IN ";
			$sql  .= " (SELECT workcodes FROM cc_call_workcodes where unique_id= '".$unique_id."' AND staff_id = '".$staff_id."' AND status = 1)";
			$sql  .= "AND wc_value='1' AND status='1'";
			$rs = $db_conn->Execute($sql);
			//echo $sql; exit();
			return $rs;
     	}
		function update_work_codes($unique_id, $caller_id, $workcodes, $detail, $staff_id){		
			global $db_conn; global $db_prefix;
			$sql  = "update ".$db_prefix."_call_workcodes ";
			$sql .= "set detail = '".$detail."' ";
			$sql .= "where unique_id= '".$unique_id."' AND caller_id = '".$caller_id."' AND workcodes = '".$workcodes."' AND staff_id = '".$staff_id."' ";
			//echo $sql; exit();			
			return $rs = $db_conn->Execute($sql);
		}
		function get_workcodes($parent_id){
			global $db_conn; global $db_prefix;
			$sql   = "SELECT * FROM ".$db_prefix."_workcodes WHERE parent_id = '".$parent_id."' ";
			$sql  .= " AND  status='1' ";
			$rs = $db_conn->Execute($sql);
			//echo $sql; exit();
			return $rs;
     	}
		function insert_workcodes($workcode_title, $parent_id, $agent_id, $wc_value='1'){
			global $db_conn; global $db_prefix;
			
			$sql12 = "SELECT MAX(id)+1 as rec FROM cc_workcodes_new";
			$rs2 = $db_conn->Execute($sql12);
			
			$sql   = "INSERT INTO ".$db_prefix."_workcodes_new (id,wc_title, parent_id, wc_value, staff_id, status, update_datetime) VALUES ('".$rs2->fields[rec]."','".$workcode_title."','".$parent_id."','".$wc_value."','".$agent_id."','1',NOW())";
			//echo $sql; exit();
			return $db_conn->Execute($sql);
		}
		function update_workcodes($workcode_title, $workcode_id, $agent_id){
			global $db_conn; global $db_prefix;
			$sql  = "update ".$db_prefix."_workcodes_new ";
			$sql .= "set wc_title = '".$workcode_title."', staff_id = '".$staff_id."'  ";
			$sql .= " where id = '".$workcode_id."' ";
			//echo $sql;exit();			
			return $rs = $db_conn->Execute($sql);
		}
		function delete_workcodes($workcode_title, $workcode_id, $agent_id){
			global $db_conn; global $db_prefix;
			$sql  = "update ".$db_prefix."_workcodes_new  ";
			$sql .= "set status= '0' , staff_id = '".$staff_id."'   ";
			$sql .= " where id = '".$workcode_id."' ";
			//echo $sql;exit();			
			return $rs = $db_conn->Execute($sql);
		}
		function recursive_make_tree($parent_id){
			global $db_conn; global $db_prefix;
			global $html; 
			
			$sql   = "SELECT * FROM ".$db_prefix."_workcodes WHERE parent_id = '".$parent_id."' ";
			$sql  .= " AND  status='1' ";
			
			//echo $sql.'<br\>';//exit();
			
			$rs = $db_conn->Execute($sql);
			$count = $rs->RecordCount();

			if($count > 0)
			{
				$html .= "<ul> ";
				while(!$rs->EOF){
					$html .= "	<li>".$rs->fields["wc_title"];

					/*
						$html .= "	<li>".$rs->fields["wc_title"]."
						<div id=\"navcontainer\">
						<ul id=\"navlist\"> ";
						$html .= $this->recursive_make_tree1($rs->fields["id"],$html);
						$html .= " </ul> </div> </li>";
					*/
					$this->recursive_make_tree($rs->fields["id"]);
					$html .= "</li>";
					$rs->MoveNext();
				}
				$html .= " </ul> ";
			}
			else{
				/*
				$html .= "	<li>".$rs->fields["wc_title"];
				$html .= "	<input type='checkbox' id='cb[]' name='cb[]' value='".$rs->fields["id"]."' />";
				$html .= "	</li>";
				*/
			}
			return $html;
     	}
		

                function irecursive_make_tree($parent_id,$parent_name=''){
                        global $db_conn; global $db_prefix;
                        global $html;

                        $sql   = "SELECT * FROM ".$db_prefix."_workcodes_new WHERE parent_id = '".$parent_id."' ";
                        $sql  .= " AND  status='1' ";
                                //echo $sql;
                        $rs = $db_conn->Execute($sql);
                        $count = $rs->RecordCount();

                        //if($parent_id == 5) return 1;

                        if($count > 0)
                        {

                                $html .= "<div id=\"navcontainer\"><ul id=\"navlist\"> ";

                                while(!$rs->EOF){

                                        if($this->is_child_exists($rs->fields["id"])){

                                                //$html .= "    <li><input type='radio' id='cb[]' name='cb[]' value='".$rs->fields["wc_title"]."' />".$rs->fields["wc_title"];
                                                //$html .= " <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";

                                        if ($parent_id != '0'){
                                                $html .= "&nbsp;&nbsp;&nbsp;<li><h6>&nbsp;&nbsp;&nbsp;".$rs->fields["wc_title"]."&nbsp;";
                                                 $heading = "</h6>";
                                                 }
                                                else if ($parent_id == '0')
                                                {
                                                        $html .= "<li><h3>".$rs->fields["wc_title"]."&nbsp;";
                                                        $heading = "</h3>";
                                                }




                                                $html .= "      <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' class='table-add-link'>  </a>";
                                                $html .= "      <a  href='workcode_new.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-edit-link'>  </a>";
                                                $html .= "      <a  href='workcode_delete.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-delete-link'>  </a> ";
                                                $html .= $heading;
                                                $this->irecursive_make_tree($rs->fields["id"],$rs->fields["wc_title"]);
                                                $html .= "      </li><br>";

                                        }
                                        else{

                                                $html .= "<li>";
                                                //$html .= "    <li><input type='radio' id='cb[]' name='cb[]' value='".$rs->fields["wc_title"]."' />".$rs->fields["wc_title"]."</li><br>";
                                                //$html .= "    <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
                                                $html .= $rs->fields["wc_title"]."&nbsp;";
                                                $html .= "      <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' class='table-add-link'>  </a>";
                                                $html .= "      <a  href='workcode_new.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-edit-link'>  </a>";
                                                $html .= "      <a  href='workcode_delete.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-delete-link'>  </a> ";
                                                $html .= "      </li><br>";
                                        }

                                        $rs->MoveNext();
                                }
                                $html .= " </ul></div> ";
                        }
                        else{
                                $is_child =0;
                                $html .= "      <li>";
                                //$html .= "    <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
                                                $html .= $rs->fields["wc_title"]."&nbsp;";
                                                $html .= "      <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' class='table-add-link' >  </a>";
                                                $html .= "      <a  href='workcode_new.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-edit-link'>  </a>";
                                                $html .= "      <a  href='workcode_delete.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-delete-link'>  </a>";
                                //$html .= "    <input type='checkbox' id='cb[]' name='cb[]' value='".$parent_name."' />".$parent_name;

                                $html .= "      </li>";
                        }

                        return $html;
        }

		function irecursive_make_tree_2702013($parent_id,$parent_name=''){
			global $db_conn; global $db_prefix;
			global $html;
			
			$sql   = "SELECT * FROM ".$db_prefix."_workcodes WHERE parent_id = '".$parent_id."' ";
			$sql  .= " AND  status='1' ";
					
			$rs = $db_conn->Execute($sql);
			$count = $rs->RecordCount();
			//if($parent_id == 5) return 1;
			
			if($count > 0)
			{
				$html .= "<div id=\"navcontainer\"><ul id=\"navlist\"> ";
				while(!$rs->EOF){
					
					if($this->is_child_exists($rs->fields["id"])){
						
						//$html .= "	<li><input type='radio' id='cb[]' name='cb[]' value='".$rs->fields["wc_title"]."' />".$rs->fields["wc_title"];
						//$html .= " <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
						$html .= "<li>".$rs->fields["wc_title"]."&nbsp;";
						$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' class='table-add-link'>  </a>";
						$html .= "	<a  href='workcode_new.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-edit-link'>  </a>";
						$html .= "	<a  href='workcode_delete.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-delete-link'>  </a> ";
						$this->irecursive_make_tree($rs->fields["id"],$rs->fields["wc_title"]);
						$html .= "	</li><br>";	
							
					}
					else{
					
						$html .= "<li>";
						//$html .= "	<li><input type='radio' id='cb[]' name='cb[]' value='".$rs->fields["wc_title"]."' />".$rs->fields["wc_title"]."</li><br>";						
						//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
						$html .= $rs->fields["wc_title"]."&nbsp;";
						$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' class='table-add-link'>  </a>";
						$html .= "	<a  href='workcode_new.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-edit-link'>  </a>";
						$html .= "	<a  href='workcode_delete.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-delete-link'>  </a> ";
						$html .= "	</li><br>";
					}

					$rs->MoveNext();
				}
				$html .= " </ul></div> ";
			}
			else{
				$is_child =0;
				$html .= "	<li>";
				//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
						$html .= $rs->fields["wc_title"]."&nbsp;";
						$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' class='table-add-link' >  </a>";
						$html .= "	<a  href='workcode_new.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-edit-link'>  </a>";
						$html .= "	<a  href='workcode_delete.php?workcode_id=".$rs->fields["id"]."&detail=".$rs->fields["wc_title"]."' title='".$rs->fields["wc_title"]."' class='table-delete-link'>  </a>";
				//$html .= "	<input type='checkbox' id='cb[]' name='cb[]' value='".$parent_name."' />".$parent_name;
				
				$html .= "	</li>";	
			}
			
			return $html;
     	}
		function xrecursive_make_tree($parent_id,$parent_name=''){
			global $db_conn; global $db_prefix;
			global $html;
			
			$sql   = "SELECT * FROM ".$db_prefix."_workcodes WHERE parent_id = '".$parent_id."' ";
			$sql  .= " AND  status='1' ";
					
			$rs = $db_conn->Execute($sql);
			$count = $rs->RecordCount();
			//if($parent_id == 5) return 1;
			if($count > 0)
			{
				$html .= "<div id=\"navcontainer\"><ul id=\"navlist\"> ";
				while(!$rs->EOF){
					
					if($this->is_child_exists($rs->fields["id"])){
						$html .= "	<li><input type='checkbox' id='cb[]' name='cb[]' value='".$rs->fields["wc_title"]."' />".$rs->fields["wc_title"];
						//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
						$this->xrecursive_make_tree($rs->fields["id"],$rs->fields["wc_title"]);
						$html .= "	</li><br>";			
					}
					else{
						$html .= "	<li><input type='checkbox' id='cb[]' name='cb[]' value='".$rs->fields["wc_title"]."' />".$rs->fields["wc_title"]."</li><br>";						
						//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
					}

					$rs->MoveNext();
				}
				$html .= " </ul></div> ";
			}
			else{
				$is_child =0;
				$html .= "	<li>";
				//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
				$html .= "	<input type='checkbox' id='cb[]' name='cb[]' value='".$parent_name."' />".$parent_name;
				
				$html .= "	</li>";	
			}
			return $html;
     	}		
		function is_child_exists($parent_id,$parent_name=''){
			global $db_conn; global $db_prefix;
			global $html; global $is_child;
			global $func_count;
			
			
			$sql   = "SELECT * FROM ".$db_prefix."_workcodes WHERE parent_id = '".$parent_id."' ";
			$sql  .= " AND  status='1' ";
					
			$rs = $db_conn->Execute($sql);
			$count = $rs->RecordCount();

			if($count > 0){
				$is_child =true;
			}
			else{
				$is_child =false;
			}
			return $is_child;
     	}	





//new function for workcode report by waleed 

function get_workcode_details($field="staff_updated_date", $order="desc", $fdate, $tdate, $search_keyword, $keywords, $isexport, $today, $level1,$level2,$level3,$level4,$level5) {

	global $db_conn; global $db_prefix;
	global $site_root;
	//	echo $level1.$level2.$level3.$level4.$level5;exit;
	$csv = '' ;
	if($isexport == true){
		 $db_export = $site_root."download/Workcode_report_".$today.".csv";
		 $csv = " INTO OUTFILE '$db_export' FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\n' ";
		//echo $csv; exit;
	}
		//t1.staff_id
	$sql = "SELECT  t1.unique_id, t1.caller_id, t2.customer_id, t2.call_type, GROUP_CONCAT(DISTINCT t1.workcodes SEPARATOR ' | ') AS workcodes, t1.staff_updated_date, 
	(SELECT full_name FROM cc_admin WHERE admin_id = t1.staff_id ) AS agent_name ";
	
	if($isexport != true)
	{
		$sql .= " , t2.update_datetime  ";
	}
	
	$sql .= $csv." FROM cc_call_workcodes AS t1 INNER JOIN cc_queue_stats AS t2
ON t1.unique_id = t2.unique_id "; //t1.caller_id = t2.caller_id
	$sql .= "WHERE 1=1 "; 
	$sql .= " AND DATE(t1.staff_updated_date) = DATE(t2.update_datetime) ";
	
	if (!empty($keywords)){
		
		if ($search_keyword == 'call-track_id') {
		
			$sql .= " AND t1.unique_id = '".$keywords."' ";
		}
		
		if ($search_keyword == 'caller_id') {
		
			$sql .= " AND t1.caller_id = '".$keywords."' ";
		}
		
		
		

		
		
		
		
		
		
		
		
		/*if ($search_keyword == 'workcode') {
		
			$sql .= " AND t1.workcodes = '".$keywords."' ";
		}*/
		
		if ($search_keyword == 'agent_name') {
			
			$sql1 = "SELECT admin_id FROM cc_admin WHERE full_name LIKE '%$keywords%'";
			//echo "<br>".$sql1;
			$rs1 		= $db_conn->Execute($sql1);
			$admin_id 	= $rs1->fields['admin_id'];
			
			$sql .= " AND t1.staff_id = '".$admin_id ."' ";
		}
	}
	if (!empty($where_in)) {
		
			$sql .= " AND t1.workcodes IN (".$where_in.") ";
			//unset($_SESSION['workcodes']);
	}
	if (!empty($fdate) && !empty($tdate)) {
	
		$sql .= " AND (t1.staff_updated_date) BETWEEN ('".$fdate."') AND ('".$tdate."')  ";
	}
	
	if (!empty($level5)){
	$sql.= "
	AND t1.workcodes  = (select wc_title from cc_workcodes where id = '".$level5."') "; 
	}
	else if (!empty($level4)){
	$sql.= "
	AND t1.workcodes  = (select wc_title from cc_workcodes where id = '".$level4."') "; 
	}
	else if (!empty($level3)){
	$sql.= "
	AND t1.workcodes  = (select wc_title from cc_workcodes where id = '".$level3."') "; 
	}	 
	else if (!empty($level2)){
	$sql.= "
	AND  t1.workcodes  = (select wc_title from cc_workcodes where id = '".$level2."') "; 
	}
	else if (!empty($level1)){
	$sql.= "
	AND  t1.workcodes  = (select wc_title from cc_workcodes where id = '".$level1."') "; 
	}	 
		
		
			
			
		
	
	
	$sql.= " GROUP BY t1.unique_id  order by staff_updated_date DESC ";

	echo("<br>".$sql); //exit;
	$rs = $db_conn->Execute($sql);
	return $rs;
}
















	
}
?>
