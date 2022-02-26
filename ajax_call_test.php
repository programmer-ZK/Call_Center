<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "ajax_call";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "ajax_call";
        $page_menu_title = "ajax_call";
?>

<?php //include_once($site_root."includes/check.auth.php"); ?>
<?php
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
	
		$param_1 = $_REQUEST['param_1'];
		$param_2 = $_REQUEST['param_2'];
		$param_3 = $_REQUEST['param_3'];
		$param_4 = $_REQUEST['param_4'];
		$param_5 = $_REQUEST['param_5'];
		$param_6 = $_REQUEST['param_6'];
		$param_7 = $_REQUEST['param_7'];
	
	if($param_1 == "ISchemes" && $param_2 != ""){
		$method = 'GetInvestmentSolution';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'Type1' => $param_2);
		//print_r($params); exit;
		echo $soap_client->get_combo($method, $params, $combo_id=$param_3, $value_feild="Code", $text_feild="Name", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="javascript:get_types_of_units(".$param_3.",".$param_3.".id )", $title="");
	}

	elseif($param_1 == "FundCode" && $param_2 != ""){
		$method = 'GetTypeOfunits';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'FundCode' => $param_2);
		//print_r($params); exit;
		echo $soap_client->get_combo($method, $params, $combo_id=$param_4."_types_of_units", $value_feild="UnitTypeCode", $text_feild="UnitName", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="", $title="");
	}
	
	/******************* GET BALANCE **********************/
	elseif($param_1 == "GBAL" && $param_2 != ""){
		$method = 'GetBalanceDetail';
		$params = array('AccessKey' => $access_key,'AccountNo' => $param_4 ,'CustomerId' => $param_5,'Channel' => $channel,'Type1' => $param_2, 'AvailableHolding' => 'yes', 'TransactionType' =>  $param_6);
		//print_r($params);
		$rs2 = $soap_client->call_soap_method($method,$params); 
		//print_r($rs2); //exit;
		$param_3--;
		// $param_3 =0;
		//echo round($rs2[0]["TotalUnits"],4)."|".round($rs2[0]["InvestmentAmount"],4)."---";
		//echo round($rs2[1]["TotalUnits"],4)."|".round($rs2[1]["InvestmentAmount"],4)."---";
		//echo round($rs2[2]["TotalUnits"],4)."|".round($rs2[2]["InvestmentAmount"],4)."END";
		
		
		//echo $rs2[$param_3]["TotalUnits"];
		if(!empty($rs2[$param_3]["TotalUnits"]) || !empty($rs2[$param_3]["InvestmentAmount"])){
			echo round($rs2[$param_3]["TotalUnits"],4)."|".round($rs2[$param_3]["InvestmentAmount"],4);
		}
		else{
			echo "0|0";
		}
	}
	/******************* BALANCE END **********************/

	elseif($param_1 == "GBD" && $param_2 != ""){

		$method = 'GetBalanceDetail';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'Type1' => $param_2, 'AccountNo' => $param_3, 'CustomerId' => $param_4 , 'AvailableHolding' => 'yes', 'TransactionType' => $param_6);
		echo $soap_client->get_combo($method, $params, $combo_id="solution_type", $value_feild=$param_2."Code", $text_feild="FundName", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="javascript:get_types_of_units(this.selectedIndex, this.id, '".$param_2."');", $title="");
	}
	
	elseif($param_1 == "GBDCONVERSION" && $param_2 != ""){
	
		
		$method = 'GetBalanceDetail';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'Type1' => $param_2, 'AccountNo' => $param_3, 'CustomerId' => $param_4, 'AvailableHolding' => 'yes', 'TransactionType' => 'COUT' );
		// comment by waleed
		 if ($param_2 == 'Fund' ){

			echo $soap_client->get_combo($method, $params, $combo_id=$param_6, $value_feild="FundCode", $text_feild="FundName", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="javascript:get_types_of_units(".$param_6.",".$param_6.".id,'".$param_2."',this.selectedIndex)", $title="");
// comment close
			}
		if ($param_2 == 'Plan' )
		{
		echo $soap_client->get_combo($method, $params, $combo_id=$param_6, $value_feild="PlanCode", $text_feild="FundName", $combo_selected="", $disabled=false, $class="txtbox-short", $onchange="javascript:get_types_of_units(".$param_6.",".$param_6.".id,'".$param_2."',this.selectedIndex)", $title="");
		 }      


	}
	elseif($param_1 == "GetCaller"){
		include_once("includes/agent_status_bar.php"); 
	}
	elseif($param_1 == "GetPinStatus"){
		include_once("includes/pin_status_popup.php"); 
	}
    elseif($param_1 == "CheckHangup"){
           	$rst = $tools_admin->get_caller_id($_SESSION[$db_prefix.'_UserId']); 

			$id 				= $rst->fields["id"];
			$unique_id 			= $rst->fields["unique_id"];
			$caller_id 			= $rst->fields["caller_id"];
			$status 			= $rst->fields["status"];
			$update_datetime	= $rst->fields["update_datetime"];
			$minutes			= $rst->fields["minutes"];
			$seconds			= $rst->fields["seconds"];
			if($status == '-1'){
				include_once("classes/user_pin.php");
        		$user_pin = new user_pin();
				$user_pin->update_user_status($unique_id,$caller_id,'-1',0,$_SESSION[$db_prefix.'_UserId']);
				
				//$tools_admin->exec_query("update cc_admin set is_busy=0 where admin_id='".$_SESSION[$db_prefix.'_UserId']."'and status='1'");
				
				$que_str =  "unique_id=".$unique_id."&caller_id=".$caller_id;
				echo $que_str;
				exit;
			}		
			else
			{
				exit;
			}

        }
		elseif($param_1 == "SetPin"){

			$method = 'SetPin';

			$params = array('AccessKey' => $access_key,'Channel' => $channel, 'AccountNo' => $param_2, 'CustomerId' => $param_3, 'CallerId' => $param_4, 'Mode' => $param_5, 'Pin' => $param_6, 'CallLogId' => $param_7 );
			//print_r($params);
			$trans_id = $soap_client->call_soap_method_2($method,$params);
			echo $trans_id; exit;
		}
                elseif($param_1 == "GetPriorityCustomer"){

                        $method = 'GetPriorityCustomer';

                        $params = array('AccessKey' => $access_key,'Channel' => $channel, 'AccountNo' => $param_5, 'CustomerId' => $param_4, 'CallerId' => $param_3, 'CNIC' => $param_2 );
                        //print_r($params);
                        $trans_id = $soap_client->call_soap_method_2_test($method,$params);
                        echo $trans_id; exit;
                }
		elseif($param_1 == "Change_Status"){
			include_once("classes/admin.php");
			$admin = new admin();
			$_SESSION[$db_prefix.'_UserStatus']	= $param_2;
			$admin->crm_status_change($_SESSION[$db_prefix.'_UserId'], $param_2);
			echo "success"; exit;
		}
	elseif($param_1 == "GetQuickMsgs" && $param_2="Ajax"){
		$is_ajax = true;
		include_once("classes/quick_msgs.php");
		$quick_msgs = new quick_msgs();
		
		include_once("includes/quick_msg_list.php"); 
	}
		
?>
