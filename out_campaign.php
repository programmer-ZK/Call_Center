<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "outbound.php";
	$page_title = "Outbound Campaign";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "User Outbound";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php include_once($site_root."classes/reports.php"); 
  $reports = new reports();
?>
<?php
	include_once('lib/nusoap.php');
        include_once("classes/tools.php");
        $tools = new tools();
		
	global $tools;
?>
<?php
	include_once("classes/admin.php");
	$admin = new admin();
			
?>

<?php include($site_root."includes/header.php"); ?>
<?php

	$campaign_id = $_REQUEST['campaign_id'];
	$_SESSION[$db_prefix.'_OCID'] = $campaign_id;
 if(isset($_REQUEST['new_customer'])){

	 $flag = true;
	 
	 if($flag == true){
	 	$caller_id 		=	$_REQUEST['txtcaller_id'];
		$description	=	$_REQUEST['txtdesc'];
		//if(preg_match('/^021/', $caller_id)){
	    	//$caller_id 		=substr($caller_id,3);
	  	//}
		//$_SESSION[$db_prefix.'_UserStatus']	= $param_2;
		////$admin->crm_status_change($_SESSION[$db_prefix.'_UserId'], 1);
			//echo $caller_id; exit;
		$command = "cat ".$site_root."templates/outgoing.template";
		$logline = shell_exec($command);
		
		$logline = str_replace("<caller_id>",$caller_id,$logline);
		$logline = str_replace("<agent_exten>",$_SESSION[$db_prefix.'_AgentExten'],$logline);
		$logline = str_replace("<agent_id>",$_SESSION[$db_prefix.'_UserId'],$logline);
		$logline = str_replace("<key_selection>","0",$logline);
		$logline = str_replace("<lang>","ur",$logline);		
		$logline = str_replace("<call_type>","CAMPAIGN",$logline);
		$logline = str_replace("<campaign_id>",$campaign_id,$logline);
		// Create call file
		
		// Write to log file:
		$logfile = $site_root.'ioutgoing_spool/'.$caller_id.'_'.date("dmYHms").'.call';
		//echo $logfile ; exit;
		// Open the log file in "Append" mode
		if (!$handle = fopen($logfile, 'a+')) {
			die("Failed to open call file");
		}
		// Write $logline to our logfile.
		if (fwrite($handle, $logline) ==FALSE) {
			die("Failed to write to call file");
		}
		fclose($handle);
		
		
	 	if(!$register_success){
			echo "Call Generating... soon you will recive a call back";		
			$_SESSION[$db_prefix.'_GM'] = "Call Generating... soon you will recive a call back";
			// $rs = $reports->update_msisdn_out_list($caller_id,$_SESSION[$db_prefix.'_UserId'],$campaign_id);
 $rs = $reports->update_msisdn_out_list($caller_id,$_SESSION[$db_prefix.'_UserId'],$campaign_id);
                  header( "Location: campaign_answer.php?campaign_id=".$campaign_id) ;



                         exit;
		}
		else{
			echo "User Already Exists";
		}
	}
 }
?>
	<div class="box">
		<h4 class="white"><?php echo($page_title); ?> </h4>
        <div class="box-container">

<?
$agent_id_out =  $_SESSION[$db_prefix.'_UserId'];
//$rs = $reports->get_msisdn_count($agent_id_out,$campaign_id);

//waleed below fnction 28082013

$rs0 = $reports->attempts_vice_call($campaign_id);


$rs = $reports->get_msisdn_count_wk($agent_id_out,$campaign_id,$rs0->fields['attempts']);

//echo "farhan";exit;
		if($rs->fields['msisdn_count'] > 0){
?>

			<form class="middle-forms cmxform" name="xForm" id="xForm" method="post" action="<? echo $_SERVER['PHP_SELF'] ?>" >
				<fieldset>
					<h3><?php echo($page_title); ?></h3>
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION[$db_prefix.'_UserId'];?>"/>
					<ol>

                <?

                        //$agent_id_out =  $_SESSION[$db_prefix.'_UserId'];
			//echo $agent_id_out; exit;
                      //  $rs = $reports->get_msisdn_out_list($agent_id_out,$campaign_id,$_SESSION[$db_prefix.'_UserId']);
   //$rswww = $reports->get_msisdn_out_list($agent_id_out,$campaign_id,$_SESSION[$db_prefix.'_UserId']);
	$rs = $reports->get_msisdn_out_list_wk($agent_id_out,$campaign_id,$_SESSION[$db_prefix.'_UserId'],$rs0->fields['attempts']);
 $rswww = $reports->get_msisdn_out_list_wk($agent_id_out,$campaign_id,$_SESSION[$db_prefix.'_UserId'],$rs0->fields['attempts']);

		//print_r($rs);//exit;

			$rs1 = $reports->update_get_msisdn_out_list($rs->fields['id'],$_SESSION[$db_prefix.'_UserId']);
                ?>

			<li class="even">
			<!--
					<td class="col-first" width="10">	<select id="txtcaller_id" name="txtcaller_id" size="1">
						<?php// while(!$rs->EOF){  ?>
						<option value="<? //echo $rs->fields['caller_id'];?>"><?// echo $rs->fields['caller_id']."|".$rs->fields['name']."|".$rs->fields['cnic']."|".$rs->fields['city']."|".$rs->fields['source']."|".$rs->fields['caller_id2'];?></option>
						<?
					//	 $rs->MoveNext();
					//	}?>	
						</select></td><br />!-->
			<table style="border:1px solid rgba(0, 0, 0, 0.27);" width="100%">
				<tr><!--<td class="col-firstf" style="border:1px solid rgba(0, 0, 0, 0.27);">*</td>!-->
				
				<td class="col-firstf" width="100%">Name</td>
				<td class="col-firstf" width="30%">Caller ID</td>
<td class="col-firstf" width="70%">Status</td>
				<td class="col-firstf" width="70%">Amount</td>
<td class="col-firstf" >CNIC</td>
				
				</tr>
					   <?php while(!$rs->EOF){  $_SESSION['name']=$rs->fields['name']; ?>
					<tr><!--<td class="col-secondf">!--><Input type = 'hidden' name ='txtcaller_id' value= '<? echo $rs->fields['caller_id'];?>'><!--</td>!-->
					
					<td class="col-secondf"><? echo $rs->fields['name'];?></td>
					<td class="col-secondf"><? echo $rs->fields['caller_id'];?></td>
	<td class="col-secondf"><? echo $rs->fields['caller_id2'];?></td>
					<td class="col-secondf"><? echo $rs->fields['caller_id3'];?></td>
<td class="col-secondf"><? echo $rs->fields['cnic'];?></td>
					</tr>
				
						
			                        <?
                                                 $rs->MoveNext();
                                                }?>





<tr>
				
<td class="col-firstf">City</td>
				<td class="col-firstf" >IC</td>
			
				<td class="col-firstf" width="70%">Source</td>
				<td class="col-firstf" width="70%">Other</td></tr>
					   <?php while(!$rswww->EOF){  ?>

					<td class="col-secondf" width="1px"><? echo $rswww->fields['city'];?></td>
					<td class="col-secondf" width="1px"><? echo $rswww->fields['ic'];?></td>
					<td class="col-secondf"><? echo $rswww->fields['source'];?></td>
					<td class="col-secondf"><? echo $rswww->fields['other'];?></td></tr>
						
					</tr>
						
			                        <?
                                                 $rswww->MoveNext();
                                                }?>











			</table>
					 </li>
					<input type="hidden" value="<? echo $campaign_id; ?>" name="campaign_id" id="campaign_id" />
                                        </ol>

			

					<p class="align-right">
						   <a id="btn_submit" class="button" href="select_campaign.php"><span>Select Campaign</span></a>

						<a id="btn_submit" class="button" href="javascript:document.xForm.submit();" onclick="javascript:document.xForm.submit();"><span>Submit</span></a>
					





















	<input type="hidden" value="Submit" name="new_customer" id="new_customer" />	
					</p>
				</fieldset>
				
			</form>
		<?}else{?>

					<ol>
						<li class="even">
							No number in campaign to dial...
						</li>
					 <p class="align-right">
                                                   <a id="btn_submit" class="button" href="select_campaign.php"><span>Select Campaign</span></a>

                                        </p>

					</ol>
		<?}?>
 		</div>
    </div>
<?php include($site_root."includes/footer.php"); ?>    

