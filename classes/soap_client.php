<?php

class soap_client{
	
    function soap_client(){
	}
	
	function exec_command()	{
		global $web_service_url;
		$client = new soapclient($web_service_url, true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
                $err = $client->getError();
                if ($err)
                {
                       return 0;
                }
		else
		{
			return 1;
		}

	}
	function call_soap_method_2($method,$params){
		global $web_service_url; global $access_key; global $channel;
		/*
			$method = 'GetBankDetail';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNumber' => '000'.$account_no,'CustomerId' => '000'.$customer_id);
		*/
		$start_datetime= date("d/m/y : H:i:s", time()) ;
		$client = new soapclient($web_service_url, true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
		$err = $client->getError();
		if ($err){
			$flag = 0;
		}
		else{
			$flag = 1;
		}	
		if ($flag == 1){
			$client->setUseCurl($useCURL);
			$result = $client->call($method, $params, '', '', false, true);
			$end_datetime= date("d/m/y : H:i:s", time()) ;
			$this->webservice_log($start_datetime, $end_datetime, $method, $params);
			if ($client->fault) {
			    return $result;
			    exit;
			}
			else {
			        $err = $client->getError();
			        if ($err){
			               return $err;
			        }
				else {
					//print_r($result[$method.'Result']['diffgram']['NewDataSet']['Table1']); exit;
					//$rs =  $this->is_multi2($result[$method.'Result']['diffgram']['NewDataSet']['Table1']);
					$rs = $result[$method.'Result'];
					return $rs;
        			}
			}	
		}
		else{
		       return 0;
                       exit;
		}	
	}		

        function call_soap_method_2_test($method,$params){
                global $web_service_url_test; global $access_key; global $channel;
                /*
                        $method = 'GetBankDetail';
                        $params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNumber' => '000'.$account_no,'CustomerId' => '000'.$customer_id);
                */
                $start_datetime= date("d/m/y : H:i:s", time()) ;
                $client = new soapclient($web_service_url_test, true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
                $err = $client->getError();
                if ($err){
                        $flag = 0;
                }
                else{
                        $flag = 1;
                }
                if ($flag == 1){
                        $client->setUseCurl($useCURL);
                        $result = $client->call($method, $params, '', '', false, true);
                        $end_datetime= date("d/m/y : H:i:s", time()) ;
                        $this->webservice_log($start_datetime, $end_datetime, $method, $params);
                        if ($client->fault) {
                            return $result;
                            exit;
                        }
                        else {
                                $err = $client->getError();
                                if ($err){
                                       return $err;
                                }
                                else {
                                        //print_r($result[$method.'Result']['diffgram']['NewDataSet']['Table1']); exit;
                                        //$rs =  $this->is_multi2($result[$method.'Result']['diffgram']['NewDataSet']['Table1']);
                                        $rs = $result[$method.'Result'];
                                        return $rs;
                                }
                        }
                }
                else{
                       return 0;
                       exit;
                }
        }

	function call_soap_method($method,$params){
		global $web_service_url; global $access_key; global $channel;
				//print_r($params); exit;
		/*
			$method = 'GetBankDetail';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNumber' => '000'.$account_no,'CustomerId' => '000'.$customer_id);
		*/
		$start_datetime= date("d/m/y : H:i:s", time()) ;
		$client = new soapclient($web_service_url, true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
		$err = $client->getError();
		if ($err){
			$flag = 0;
		}
		else{
			$flag = 1;
		}	
		if ($flag == 1){
			$client->setUseCurl($useCURL);
			$result = $client->call($method, $params, '', '', false, true);
			$end_datetime= date("d/m/y : H:i:s", time()) ;
			$this->webservice_log($start_datetime, $end_datetime, $method, $params);
			if ($client->fault) {
			    return $result;
			    exit;
			}
			else {
			        $err = $client->getError();
			        if ($err){
			               return $err;
			        }
				else {
					//print_r($result); exit;				
					//print_r($result[$method.'Result']['diffgram']['NewDataSet']['Table1']); exit;
					$rs =  $this->is_multi2($result[$method.'Result']['diffgram']['NewDataSet']['Table1']);
					//print_r($rs); exit;
					return $rs;
        			}
			}	
		}
		else{
		       return 0;
                       exit;
		}	
	}
	
	function get_combo($method, $params, $combo_id="id", $value_feild="id", $text_feild="title", $combo_selected="", $disabled=false, $class="", $onchange="", $title=""){
		//echo "farhan"; exit();
		global $web_service_url; global $access_key; global $channel;
		//echo $method." -- ".$combo_id; print_r($params);exit;
		//echo $web_service_url." -- ".$proxyhost." -- ".$proxyport." -- ".$proxyusername." -- ".$proxypassword;
		$start_datetime= date("d/m/y : H:i:s", time()) ;		 
		$client = new soapclient($web_service_url, true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
		//echo $web_service_url." -- ".$proxyhost."".$proxyport."".$proxyusername."".$proxypassword; exit;
		$err = $client->getError();
		
		if ($err){
			$flag = 0;
			
		}
		else{
			$flag = 1;
		}	
		if ($flag == 1)
		{
			$client->setUseCurl($useCURL);
			$result = $client->call($method, $params, '', '', false, true);
			$end_datetime= date("d/m/y : H:i:s", time()) ;
			$this->webservice_log($start_datetime, $end_datetime, $method, $params);
			if ($client->fault) 
			{
			    return $result;
			    exit;
			}
			else {
			        $err = $client->getError();
			        if ($err){
			               return $err;
				       exit;
			        }
					else
					{
						//print_r($result[$method.'Result']['diffgram']['NewDataSet']['Table1']); //exit;
						$rs =  $this->is_multi2($result[$method.'Result']['diffgram']['NewDataSet']['Table1']);
						
						$count = 0;
						if($disabled==true)
						$output="<select id='$combo_id' name='$combo_id' class='$class' onchange='$onchange' disabled=\"disabled\" >";
						else
						$output="<select id='$combo_id' name='$combo_id' class='$class' onchange=\"$onchange\">";
					
						if($combo_selected == "")
						$output.="<option value='0'>Please Select ".$title."</option>";
//						echo $rs[0][$value_feild]; echo "hiii"; exit;
        		        while($count != count($rs) && !empty($rs[0][$value_feild])){ 
						//echo $rs[$count]["Mobile"]; 
							if($rs[$count][$value_feild] == $combo_selected){
								$output.="<option value=".$rs[$count][$value_feild]." selected=\"selected\">".$rs[$count][$text_feild]."</option>";
							}
							else{
								$output.="<option value=".$rs[$count][$value_feild]." >".$rs[$count][$text_feild]."</option>";
							}
                        	$count++;
                	}
					$output.="</select>";
					return $output;
        		}
			}	
		}
		else{
		       return 0;
                       exit;
		}	
	}
	
	function is_multi2($array) {
		
		if (count($array) == count($array, COUNT_RECURSIVE)) {
			
			$temp = array(array());
			foreach ($array as $key => $value) {
				$temp[0][$key]=$value;
				
			}
			
			return ($temp); 
			
		}
		else{
			return ($array);
			
		}
	}
	function webservice_log($start_datetime, $end_datetime, $method, $param){
		global $site_root;
		// Create log line
		$logline = $start_datetime . '|' . $end_datetime . '|' . $method . '|' . implode(',',$param) ."\n";

		// Write to log file:
		$logfile = $site_root.'server_log/webservice_log_'.date("dmY").'.txt';
		// Open the log file in "Append" mode
		if (!$handle = fopen($logfile, 'a+')) {
		    die("Failed to open log file");
		}
		// Write $logline to our logfile.
		if (fwrite($handle, $logline) === FALSE) {
		    die("Failed to write to log file");
		}
		fclose($handle);

	}
}	
?>
