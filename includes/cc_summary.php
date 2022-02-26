<?php 
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();
		
        include_once("classes/user_tools.php");
        $user_tools = new user_tools();		
		//exit;
        //$rs = $user_tools->callcenter_stats();
		$total_count = 0;
		while(!$rs->EOF){
			$total_count += $rs->fields["cnt"];
			if($rs->fields["status"] == "0"){
				$hangup = $rs->fields["cnt"]; 
			}	
			else if($rs->fields["status"] == "1"){
				$enqueue_state = $rs->fields["cnt"]; 
			}
			else if($rs->fields["status"] == "2"){
				$enqueue_state = $rs->fields["cnt"]; 
			}
			else if($rs->fields["status"] == "3"){
				$ringing_state = $rs->fields["cnt"]; 
			}
			else if($rs->fields["status"] == "4"){
				$enqueue_state = $rs->fields["cnt"]; 
			}
			else if($rs->fields["status"] == "5"){
				$pin_generation = $rs->fields["cnt"]; 
			}
			else if($rs->fields["status"] == "-1"){
				$work_codes = $rs->fields["cnt"]; 
			}
			else if($rs->fields["status"] == "-4"){
				$pin_generation_failure = $rs->fields["cnt"]; 
			}
			else if($rs->fields["status"] == "-5"){
				$pin_generation_failure = $rs->fields["cnt"]; 
			}
			else if($rs->fields["status"] == "-6"){
				$pin_verification_failure = $rs->fields["cnt"]; 
			}
			else {
				//$pin_generation_failure = $rs->fields["cnt"]; 
			}	
			//$cur_answer = $rs->fields["cnt"];
		}
?>

        <div class="box">
        <h4 class="white" style="margin-top: 30px;">Customer Detail</h4>
        <div class="box-container">
                <form action="" method="post" class="middle-forms">
					<fieldset>
							<legend>Fieldset Title</legend>
							<ol>							
								<li class="even">
									<label class="field-title"> ENQUEUE:</label> 
									<label><?php echo $rs; ?></label>
									<span class="clearFix">&nbsp;</span>
								</li>																																																																		
							</ol>
					</fieldset>
					<span class="clearFix">&nbsp;</span>
                </form>
        </div>
        </div>
