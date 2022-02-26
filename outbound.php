<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "outbound.php";
	$page_title = "User Outbound";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "User Outbound";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
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

 if(isset($_REQUEST['new_customer'])){

	 $flag = true;

	 if($flag == true){
	 	$caller_id 		=	$_REQUEST['txtcaller_id'];
		$description	=	$_REQUEST['txtdesc'];
		//if(preg_match('/^021/', $caller_id)){
	    	//$caller_id 		=substr($caller_id,3);
	  	//}
		//$_SESSION[$db_prefix.'_UserStatus']	= $param_2;
		//$admin->crm_status_change($_SESSION[$db_prefix.'_UserId'], 1);
			//echo $caller_id; exit;
		$command = "cat ".$site_root."templates/outgoing.template";
		$logline = shell_exec($command);

		$logline = str_replace("<caller_id>",$caller_id,$logline);
		$logline = str_replace("<agent_exten>",$_SESSION[$db_prefix.'_AgentExten'],$logline);
		$logline = str_replace("<agent_id>",$_SESSION[$db_prefix.'_UserId'],$logline);
		$logline = str_replace("<key_selection>","0",$logline);
		$logline = str_replace("<lang>","ur",$logline);
		$logline = str_replace("<call_type>","OUTBOUND",$logline);
		// Create call file
        //echo $logline;
		// Write to log file:
		//echo $logfile = $site_root.'/out/'.$caller_id.'_'.date("dmYHms").'.call';
		$logfile = $site_root.'ioutgoing_spool/'.$caller_id.'_'.date("dmYHms").'.call';
			//	echo $logfile ; exit;
		// Open the log file in "Append" mode
		if (!$handle = fopen($logfile, 'a+')) {
			die("Failed to open call file");
		}
		// Write $logline to our logfile.
		if (fwrite($handle, $logline) ==FALSE) {
			die("Failed to write to call file");
		}
		fclose($handle);
`chmod 777 $logfile`;
`cp -f  $logfile /var/spool/asterisk/outgoing/`;
$cmd="cp -f  $logfile /var/spool/asterisk/outgoing/";
//echo $cmd;exit();
//exec($cmd);
		//$register_success = $customers->insert_customers($caller_id, $first_name, $last_name, $father_name, $cnic, $email, $address, $city, $country, $contact_no, $cell_no, $product_info, $description,'1', $_SESSION[$db_prefix.'_UserId']);

	 	if(!$register_success){
			echo "Call Generating... soon you will recive a call back";
			$_SESSION[$db_prefix.'_GM'] = "Call Generating... soon you will recive a call back";
			$_SESSION['LAST_CALL'] = $caller_id;
			header( 'Location: index.php' ) ;
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
			<form class="middle-forms cmxform" name="xForm" id="xForm" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
				<fieldset>
					<h3><?php echo($page_title); ?></h3>
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION[$db_prefix.'_UserId'];?>"/>
					<ol>
                    	<li class="even">
							<label class="field-title">Caller ID<font color="red"> <em>*</em></font>:</label>
							<input id="txtcaller_id" name="txtcaller_id" value="<?php echo $caller_id;?>" />
							<?php  echo $txtcaller_id_error;?>
						</li>
			 <li class="even">
						 <label class="field-title">Last Dial<font color="red"> <em></em></font>:</label>
                                                        <input id="last_caller_id" name="last_caller_id" value="<?php echo $_SESSION['LAST_CALL'];?>" />
                                                        <?php  echo $txtcaller_id_error;?>
                                                </li>

						<li  class="even" style="display:none">
								<label class="field-title">Description<font color="red"><em>*</em></font>:</label>
								<textarea id="txtdesc" name="txtdesc" rows="5" cols="40"></textarea>
								<?php echo $txtdesc_error; ?>
						</li>
					</ol>
					<p class="align-right">
						<a id="btn_submit" class="button" href="javascript:document.xForm.submit();" onclick="javascript:document.xForm.submit();"><span>Submit</span></a>
						<input type="hidden" value="Submit" name="new_customer" id="new_customer" />
					</p>
				</fieldset>

			</form>
 		</div>
    </div>
<?php include($site_root."includes/footer.php"); ?>

