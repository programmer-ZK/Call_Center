



<?php
include_once("classes/database.php");

class work_codes
{

	function work_codes()
	{
	}
	function insert_work_codes($unique_id, $caller_id, $workcodes, $agent_id, $value_desc)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "insert into " . $db_prefix . "_call_workcodes ";
		$sql .= "( unique_id, caller_id, workcodes,detail, staff_id, staff_updated_date) ";
		$sql .= "values ('" . $unique_id . "','" . $caller_id . "','" . $workcodes . "','" . $value_desc . "','" . $agent_id . "',NOW())";
		//echo $sql;exit();			
		return $rs = $db_conn->Execute($sql);
	}
	function get_workcodes_for_values($unique_id, $caller_id, $account_no, $customer_id, $staff_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql   = "SELECT wc_title FROM cc_workcodes WHERE wc_title IN ";
		$sql  .= " (SELECT workcodes FROM cc_call_workcodes where unique_id= '" . $unique_id . "' AND staff_id = '" . $staff_id . "' AND status = 1)";
		$sql  .= "AND wc_value='1' AND status='1'";
		$rs = $db_conn->Execute($sql);
		//echo $sql; exit();
		return $rs;
	}
	function update_work_codes($unique_id, $caller_id, $workcodes, $detail, $staff_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "update " . $db_prefix . "_call_workcodes ";
		$sql .= "set detail = '" . $detail . "' ";
		$sql .= "where unique_id= '" . $unique_id . "' AND caller_id = '" . $caller_id . "' AND workcodes = '" . $workcodes . "' AND staff_id = '" . $staff_id . "' ";
		//echo $sql; exit();			
		return $rs = $db_conn->Execute($sql);
	}
	function get_workcodes($parent_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql   = "SELECT * FROM " . $db_prefix . "_workcodes WHERE parent_id = '" . $parent_id . "' ";
		$sql  .= " AND  status='1' ";
		$rs = $db_conn->Execute($sql);
		//echo $sql; exit();
		return $rs;
	}
	function insert_workcodes($workcode_title, $parent_id, $agent_id, $wc_value = '1')
	{
		global $db_conn;
		global $db_prefix;
		$sql   = "INSERT INTO " . $db_prefix . "_workcodes (wc_title, parent_id, wc_value, staff_id, status, update_datetime) VALUES ('" . $workcode_title . "','" . $parent_id . "','" . $wc_value . "','" . $agent_id . "','1',NOW())";
		//echo $sql; exit();
		return $db_conn->Execute($sql);
	}
	function update_workcodes($workcode_title, $workcode_id, $agent_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "update " . $db_prefix . "_workcodes ";
		$sql .= "set wc_title = '" . $workcode_title . "', staff_id = '" . $staff_id . "'  ";
		$sql .= " where id = '" . $workcode_id . "' ";
		//echo $sql;exit();			
		return $rs = $db_conn->Execute($sql);
	}
	function delete_workcodes($workcode_title, $workcode_id, $agent_id)
	{
		global $db_conn;
		global $db_prefix;
		$sql  = "update " . $db_prefix . "_workcodes  ";
		$sql .= "set status= '0' , staff_id = '" . $staff_id . "'   ";
		$sql .= " where id = '" . $workcode_id . "' ";
		//echo $sql;exit();			
		return $rs = $db_conn->Execute($sql);
	}
	function recursive_make_tree($parent_id)
	{
		global $db_conn;
		global $db_prefix;
		global $html;

		$sql   = "SELECT * FROM " . $db_prefix . "_workcodes_new WHERE parent_id = '" . $parent_id . "' ";
		$sql  .= " AND  status='1' ";

		//echo $sql.'<br\>';//exit();

		$rs = $db_conn->Execute($sql);
		$count = $rs->RecordCount();

		if ($count > 0) {
			$html .= "<ul> ";
			while (!$rs->EOF) {
				$html .= "	<li>" . $rs->fields["wc_title"];

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
		} else {
			/*
				$html .= "	<li>".$rs->fields["wc_title"];
				$html .= "	<input type='checkbox' id='cb[]' name='cb[]' value='".$rs->fields["id"]."' />";
				$html .= "	</li>";
				*/
		}
		return $html;
	}

	function irecursive_make_tree($parent_id, $parent_name = '')
	{
		global $db_conn;
		global $db_prefix;
		global $html;

		$sql   = "SELECT * FROM " . $db_prefix . "_workcodes_new WHERE parent_id = '" . $parent_id . "' ";
		$sql  .= " AND  status='1' ";

		$rs = $db_conn->Execute($sql);
		$count = $rs->RecordCount();
		//if($parent_id == 5) return 1;

		if ($count > 0) {
			$html .= "<div id=\"navcontainer\"><ul id=\"navlist\"> ";
			while (!$rs->EOF) {

				if ($this->is_child_exists($rs->fields["id"])) {

					//$html .= "	<li><input type='radio' id='cb[]' name='cb[]' value='".$rs->fields["wc_title"]."' />".$rs->fields["wc_title"];
					//$html .= " <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
					$html .= "<li>" . $rs->fields["wc_title"] . "&nbsp;";
					$html .= "	<a  href='workcode_new.php?parent_id=" . $rs->fields["id"] . "' title='" . $rs->fields["wc_title"] . "' class='table-add-link'>  </a>";
					$html .= "	<a  href='workcode_new.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-edit-link'>  </a>";
					$html .= "	<a  href='workcode_delete.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-delete-link'>  </a> ";
					$this->irecursive_make_tree($rs->fields["id"], $rs->fields["wc_title"]);
					$html .= "	</li><br>";
				} else {

					$html .= "<li>";
					//$html .= "	<li><input type='radio' id='cb[]' name='cb[]' value='".$rs->fields["wc_title"]."' />".$rs->fields["wc_title"]."</li><br>";						
					//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
					$html .= $rs->fields["wc_title"] . "&nbsp;";
					$html .= "	<a  href='workcode_new.php?parent_id=" . $rs->fields["id"] . "' title='" . $rs->fields["wc_title"] . "' class='table-add-link'>  </a>";
					$html .= "	<a  href='workcode_new.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-edit-link'>  </a>";
					$html .= "	<a  href='workcode_delete.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-delete-link'>  </a> ";
					$html .= "	</li><br>";
				}

				$rs->MoveNext();
			}
			$html .= " </ul></div> ";
		} else {
			$is_child = 0;
			$html .= "	<li>";
			//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
			$html .= $rs->fields["wc_title"] . "&nbsp;";
			$html .= "	<a  href='workcode_new.php?parent_id=" . $rs->fields["id"] . "' title='" . $rs->fields["wc_title"] . "' class='table-add-link' >  </a>";
			$html .= "	<a  href='workcode_new.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-edit-link'>  </a>";
			$html .= "	<a  href='workcode_delete.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-delete-link'>  </a>";
			//$html .= "	<input type='checkbox' id='cb[]' name='cb[]' value='".$parent_name."' />".$parent_name;

			$html .= "	</li>";
		}

		return $html;
	}
	function xrecursive_make_tree($parent_id, $parent_name = '')
	{
		global $db_conn;
		global $db_prefix;
		global $html;

		$sql   = "SELECT * FROM " . $db_prefix . "_workcodes_new WHERE parent_id = '" . $parent_id . "' ";
		$sql  .= " AND  status='1' ";

		$rs = $db_conn->Execute($sql);
		$count = $rs->RecordCount();
		//if($parent_id == 5) return 1;
		if ($count > 0) {

			//if($rs->fields[parent_id]!==0){ $div_chk =  "style=\"display:none;\"";}

			$html .= "<div id=\"navcontainer" . $rs->fields[parent_id] . "\"";
			if ($rs->fields[parent_id] != 0) {
				$html .= "style=\"display:none;\"";
			}
			//$html .= " onclick=\"javascript:container_visible();\"";
			$html .= "><ul id=\"navlist\"> ";
			while (!$rs->EOF) {

				if ($this->is_child_exists($rs->fields["id"])) {
					$html .= "	<li style=\"padding-left:15px;\" ><input type='checkbox' id='cb[]' name='cb[]' value='" . $rs->fields["id"] . "'";
					$html .= " onclick=\"javascript:container_visible(" . $rs->fields[id] . ");\"";
					$html .= " />" . $rs->fields["wc_title"];
					//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
					$this->xrecursive_make_tree($rs->fields["id"], $rs->fields["wc_title"]);
					$html .= "	</li><br>";
				} else {
					$html .= "	<li style=\"padding-left:15px;\"><input type='checkbox' id='cb[]' name='cb[]' value='" . $rs->fields["id"] . "' />" . $rs->fields["wc_title"] . "</li><br>";
					//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
				}

				$rs->MoveNext();
			}
			$html .= " </ul></div> ";
		} else {
			$is_child = 0;
			$html .= "	<li>";
			//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
			$html .= "	<input type='checkbox' id='cb[]' name='cb[]' value='" . $parent_name . "' />" . $parent_name;

			$html .= "	</li>";
		}
		return $html;
	}
	function is_child_exists($parent_id, $parent_name = '')
	{
		global $db_conn;
		global $db_prefix;
		global $html;
		global $is_child;
		global $func_count;


		$sql   = "SELECT * FROM " . $db_prefix . "_workcodes_new WHERE parent_id = '" . $parent_id . "' ";
		$sql  .= " AND  status='1' ";

		$rs = $db_conn->Execute($sql);
		$count = $rs->RecordCount();

		if ($count > 0) {
			$is_child = true;
		} else {
			$is_child = false;
		}
		return $is_child;
	}





	function xrecursive_make_tree2($parent_id, $parent_name = '')
	{
		global $db_conn;
		global $db_prefix;
		global $html;
		$sql   = "SELECT * FROM " . $db_prefix . "_workcodes_new WHERE parent_id = '" . $parent_id . "' ";
		$sql  .= " AND  status='1' ";
		$rs = $db_conn->Execute($sql);
		$count = $rs->RecordCount();
		//if($parent_id == 5) return 1;
		if ($count > 0) {
			//if($rs->fields[parent_id]!==0){ $div_chk =  "style=\"display:none;\"";}

?>
				<?php
				if ($rs->fields[parent_id] != 0) {
					$html .= "style=\"display:none;\"";
				}
				//$html .= " onclick=\"javascript:container_visible();\"";
				$html .= "><ul id=\"navlist\"> ";
				while (!$rs->EOF) {

					if ($this->is_child_exists($rs->fields["id"])) {
						$html .= "	<li style=\"padding-left:15px;\" ><input id=liChild" . $rs->fields[id] . " type='checkbox' ' name='ch" . $rs->fields[parent_id] . "' value='" . $rs->fields["wc_title"] . "'";
						$html .= " onclick=\"javascript:container_visible(" . $rs->fields[id] . ");javascript:togglecheckboxes('ch" . $rs->fields[id] . "');\"";
						$html .= " />" . $rs->fields["wc_title"];
						// id='cb[] $html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
						$this->xrecursive_make_tree2($rs->fields["id"], $rs->fields["wc_title"]);
						$html .= "	</li><br>";
					} else {
						$html .= "	<li  style=\"padding-left:15px;\"><input class='liChild' type='checkbox' id='ch" . $rs->fields[parent_id] . "' name='ch" . $rs->fields[parent_id] . "' value='" . $rs->fields["wc_title"] . "' />" . $rs->fields["wc_title"] . "</li><br>";
						//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
					}
					$rs->MoveNext();
				}
				$html .= " </ul></div> ";
			} else {
				$is_child = 0;
				$html .= "	<li>";
				//$html .= "	<a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
				$html .= "	<input type='checkbox'  id='cb[]' name='cb[]' value='" . $parent_name . "' />" . $parent_name;

				$html .= "	</li>";
			}
			return $html;
		}








		function xrecursive_make_tree_new($parent_id, $parent_name = '')
		{
			global $db_conn;
			global $db_prefix;
			global $html;
			$sql   = "SELECT * FROM " . $db_prefix . "_workcodes_new WHERE parent_id = '" . $parent_id . "' ";
			$sql  .= " AND  status='1' ";

			$rs = $db_conn->Execute($sql);
			$count = $rs->RecordCount();
			//if($parent_id == 5) return 1;
			if ($count > 0) {
				//if($rs->fields[parent_id]!==0){ $div_chk =  "style=\"display:none;\"";}
				$html .= "<div ' id=\"navcontainer" . $rs->fields[parent_id] . "\"";
				?>
                                <?php
																if ($rs->fields[parent_id] != 0) {
																	$html .= "style=\"display:none;\"";
																}
																//$html .= " onclick=\"javascript:container_visible();\"";
																$html .= "><ul id=\"navlist\"> ";
																while (!$rs->EOF) {

																	if ($this->is_child_exists($rs->fields["id"])) {
																		$html .= "      <li style=\"padding-left:15px;\" ><input id=liChild" . $rs->fields[id] . " type='checkbox' ' name='cb[]' value='" . $rs->fields["wc_title"] . "'";
																		$html .= " onclick=\"javascript:container_visible(" . $rs->fields[id] . ");javascript:togglecheckboxes('ch" . $rs->fields[id] . "');\"";
																		$html .= " />" . $rs->fields["wc_title"];
																		// id='cb[] $html .= "  <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																		$html .= "";
																		$html .= "      <a  href='workcode_new.php?parent_id=" . $rs->fields["id"] . "' title='" . $rs->fields["wc_title"] . "' class='table-add-link'>  </a>";
																		$html .= "      <a  href='workcode_new.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-edit-link'>  </a>";
																		$html .= "      <a  href='workcode_delete.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-delete-link'>  </a> ";

																		$this->xrecursive_make_tree_new($rs->fields["id"], $rs->fields["wc_title"]);
																		$html .= " ";
																	} else {
																		$html .= "      <li  style=\"padding-left:15px;\"><input class='liChild' type='checkbox' id='ch" . $rs->fields[parent_id] . "' name='cb[]' value='" . $rs->fields["wc_title"] . "' />" . $rs->fields["wc_title"];
																		$html .= "      <a  href='workcode_new.php?parent_id=" . $rs->fields["id"] . "' title='" . $rs->fields["wc_title"] . "' class='table-add-link'>  </a>";
																		$html .= "      <a  href='workcode_new.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-edit-link'>  </a>";
																		$html .= "      <a  href='workcode_delete.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-delete-link'>  </a> ";

																		$html .= "</li>";
																		//$html .= "    <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																	}
																	$rs->MoveNext();
																}
																$html .= " </ul></div> ";
															} else {
																$is_child = 0;
																$html .= "      <li>";
																//$html .= "    <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																$html .= "      <input type='checkbox'  id='cb[]' name='cb[]' value='" . $parent_name . "' />" . $parent_name;
																$html .= "      <a  href='workcode_new.php?parent_id=" . $rs->fields["id"] . "' title='" . $rs->fields["wc_title"] . "' class='table-add-link' >  </a>";
																$html .= "      <a  href='workcode_new.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-edit-link'>  </a>";
																$html .= "      <a  href='workcode_delete.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["wc_title"] . "' title='" . $rs->fields["wc_title"] . "' class='table-delete-link'>  </a>";


																$html .= "      </li>";
															}
															return $html;
														}
														function xrecursive_make_tree_product($parent_id, $parent_name = '')
														{
															global $db_conn;
															global $db_prefix;
															global $html;
															$sql   = "SELECT * FROM " . $db_prefix . "_products WHERE parent_id = '" . $parent_id . "' ";
															$sql  .= " AND  status='1' ";

															$rs = $db_conn->Execute($sql);
															$count = $rs->RecordCount();
															//if($parent_id == 5) return 1;
															if ($count > 0) {
																//if($rs->fields[parent_id]!==0){ $div_chk =  "style=\"display:none;\"";}
																$html .= "<div ' id=\"navcontainer" . $rs->fields[parent_id] . "\"";
																?>
                                <?php
																if ($rs->fields[parent_id] != 0) {
																	$html .= "style=\"display:none;\"";
																}
																//$html .= " onclick=\"javascript:container_visible();\"";
																$html .= "><ul id=\"navlist\"> ";
																while (!$rs->EOF) {

																	if ($this->is_child_exists($rs->fields["id"])) {
																		$html .= "      <li style=\"padding-left:15px;\" ><input id=liChild" . $rs->fields[id] . " type='checkbox' ' name='cb[]' value='" . $rs->fields["p_title"] . "'";
																		$html .= " onclick=\"javascript:container_visible(" . $rs->fields[id] . ");javascript:togglecheckboxes('ch" . $rs->fields[id] . "');\"";
																		$html .= " />" . $rs->fields["p_title"];
																		// id='cb[] $html .= "  <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																		$html .= "";
																		$html .= "      <a  href='workcode_new.php?parent_id=" . $rs->fields["id"] . "' title='" . $rs->fields["p_title"] . "' class='table-add-link'>  </a>";
																		$html .= "      <a  href='workcode_new.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["p_title"] . "' title='" . $rs->fields["p_title"] . "' class='table-edit-link'>  </a>";
																		$html .= "      <a  href='workcode_delete.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["p_title"] . "' title='" . $rs->fields["p_title"] . "' class='table-delete-link'>  </a> ";

																		$this->xrecursive_make_tree_product($rs->fields["id"], $rs->fields["p_title"]);
																		$html .= " ";
																	} else {
																		$html .= "      <li  style=\"padding-left:15px;\"><input class='liChild' type='checkbox' id='ch" . $rs->fields[parent_id] . "' name='cb[]' value='" . $rs->fields["p_title"] . "' />" . $rs->fields["p_title"];
																		$html .= "      <a  href='workcode_new.php?parent_id=" . $rs->fields["id"] . "' title='" . $rs->fields["p_title"] . "' class='table-add-link'>  </a>";
																		$html .= "      <a  href='workcode_new.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["p_title"] . "' title='" . $rs->fields["p_title"] . "' class='table-edit-link'>  </a>";
																		$html .= "      <a  href='workcode_delete.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["p_title"] . "' title='" . $rs->fields["p_title"] . "' class='table-delete-link'>  </a> ";

																		$html .= "</li>";
																		//$html .= "    <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																	}
																	$rs->MoveNext();
																}
																$html .= " </ul></div> ";
															} else {
																$is_child = 0;
																$html .= "      <li>";
																//$html .= "    <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																$html .= "      <input type='checkbox'  id='cb[]' name='cb[]' value='" . $parent_name . "' />" . $parent_name;
																$html .= "      <a  href='workcode_new.php?parent_id=" . $rs->fields["id"] . "' title='" . $rs->fields["p_title"] . "' class='table-add-link' >  </a>";
																$html .= "      <a  href='workcode_new.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["p_title"] . "' title='" . $rs->fields["p_title"] . "' class='table-edit-link'>  </a>";
																$html .= "      <a  href='workcode_delete.php?workcode_id=" . $rs->fields["id"] . "&detail=" . $rs->fields["p_title"] . "' title='" . $rs->fields["p_title"] . "' class='table-delete-link'>  </a>";


																$html .= "      </li>";
															}
															return $html;
														}



														function recursive_make_tree_jq($parent_id, $parent_name = '')
														{
															global $db_conn;
															global $db_prefix;
															global $html;
															$sql   = "SELECT * FROM " . $db_prefix . "_workcodes_new WHERE parent_id = '" . $parent_id . "' ";
															$sql  .= " AND  status='1' ";
															$rs = $db_conn->Execute($sql);
															$count = $rs->RecordCount();
															//if($parent_id == 5) return 1;
															if ($count > 0) {
																//if($rs->fields[parent_id]!==0){ $div_chk =  "style=\"display:none;\"";}
																// $html .= "<div ' id=\"navcontainer".$rs->fields[parent_id]."\">as";
																?>
                                <?php
																if ($rs->fields[parent_id] != 0) {
																	$html .= "<ul style=\"display:none;\" id=\"navcontainer" . $rs->fields[parent_id] . "\" >";
																}
																//$html .= " onclick=\"javascript:container_visible();\"";
																$html .= " <ul  > ";

																while (!$rs->EOF) {

																	if ($this->is_child_exists($rs->fields["id"])) {
																		//$html .= "<ul id=\"treeList\"> ";
																		$html .= "      <li  ><input  type='checkbox'  name='cb[]' value='" . $rs->fields['wc_title'] . "'";
																		$html .= " onmouseover=\"javascript:container_visible(" . $rs->fields[id] . ");\"";


																		$html .= " onclick=\"javascript:togglecheckboxes('ch" . $rs->fields[id] . "');\"";


																		$html .= " />" . $rs->fields["wc_title"];
																		//$html .= "<ul> <li>";
																		// id='cb[] $html .= "  <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																		$this->recursive_make_tree_jq($rs->fields["id"], $rs->fields["wc_title"]);
																		$html .= "      </li>";
																	} else {
																		$html .= " <li><input class='liChild' type='checkbox'  name='cb[]' value='" . $rs->fields["wc_title"] . "' />" . $rs->fields["wc_title"] . "</li>";
																		//$html .= "    <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																	}
																	$rs->MoveNext();
																}
																$html .= " </ul> ";
																//$html .= "</div>";
															} else {
																$is_child = 0;
																$html .= "      <li>";
																//$html .= "    <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																$html .= "      <input type='checkbox'  id='selectedRole' name='cb[]' value='" . $parent_name . "' />" . $parent_name;

																$html .= "      </li>";
															}
															return $html;
														}





														function recursive_make_tree_jq2($parent_id, $parent_name)
														{
															global $db_conn;
															global $db_prefix;
															global $html;
															$sql   = "SELECT * FROM " . $db_prefix . "_workcodes_new WHERE parent_id = '" . $parent_id . "' ";
															$sql  .= " AND  status='1' ";
															$rs = $db_conn->Execute($sql);
															$count = mysql_num_rows($rs);
															//print_r($rs);//exit();
															$count = $rs->RecordCount();
															//	 $count = $rs->	RowCount();
															//if($parent_id == 5) return 1;
															//echo $count ."dsfsF";
															if ($count > 0) {
																//if($rs->fields[parent_id]!==0){ $div_chk =  "style=\"display:none;\"";}
																// $html .= "<div ' id=\"navcontainer".$rs->fields[parent_id]."\">as";
																?>
                                <?php
																if ($rs->fields[parent_id] != 0) {
																	//$html .= "<ul style=\"display:none;\" id=\"navcontainer".$rs->fields[parent_id]."\" >";
																}
																//$html .= " onclick=\"javascript:container_visible();\"";
																// $html .= "  {title: \"\" ";

																while (!$rs->EOF) {
																	if ($this->is_child_exists($rs->fields["id"])) {
																		//$html .= "<ul id=\"treeList\"> ";
																		$html .= "  {title: \"" . $rs->fields['wc_title'] . "\" , key: \"" . $rs->fields['wc_title'] . "\" ,
						children: [";
																		$this->recursive_make_tree_jq2($rs->fields["id"], $rs->fields["wc_title"]);
																		$html .= " },  ";
																	} else {
																		$html .= "  {title: \"" . $rs->fields['wc_title'] . "\" , key: \"" . $rs->fields['wc_title'] . "\"},";
																		// if($this->is_child_exists($rs->fields["id"])){
																		// $html .= ", }]";
																		//}
																	}
																	$rs->MoveNext();
																}
																$html .= " ] ";
																//$html .= "</div>";
															} else {
																$is_child = 0;
																$html .= "      ";
																//$html .= "    <a  href='workcode_new.php?parent_id=".$rs->fields["id"]."' title='".$rs->fields["wc_title"]."' >".$rs->fields["wc_title"]."</a><br>";
																$html .= "      {title: \"" . $parent_name . "\" ";

																$html .= "       ]};";
															}
															return $html;
														}
													}

																?>

