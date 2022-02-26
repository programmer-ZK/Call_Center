
<?php 
include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();

        include_once("classes/reports.php");
	    $reports = new reports();

        $rs = $reports->iget_priorityAlertOne_records();
        $blink_me = $rs->fields["Number"] ? 'blink_me' : '';

?>
<script type="text/javascript" language="javascript1.2">
function get_agent_status(){
	var rnd = Math.random();
    var url="ajax_call.php?id="+rnd+"&param_1=GetCaller";
    mpostRequest(url);
	//popup_show('popup', 'popup_drag', 'popup_exit', 'screen-bottom-right', -20, -20);
	//popitup('user_hangup.php');
}
function popitup(url) {
	newwindow=window.open(url,'name','height=800,width=600');
	if (window.focus) {newwindow.focus()}
	return false;
}
function stopTimer() {
	//document.getElementById("timer").innerHTML = "" ;
}
function mpostRequest(strURL){
        var xmlHttp;
          if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                 var xmlHttp = new XMLHttpRequest();
            }else if (window.ActiveXObject) { // IE
                var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlHttp.open('POST', strURL, true);
            xmlHttp.setRequestHeader
              ('Content-Type', 'application/x-www-form-urlencoded');
                xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
				document.getElementById("agent_status_bar").innerHTML = xmlHttp.responseText ;
                //alert(xmlHttp.responseText);
              }
           }
         xmlHttp.send(strURL);
}
</script>

<?php 	
	$rst = $tools_admin->get_caller_id($_SESSION[$db_prefix.'_UserId']); 
	
	$id 				= $rst->fields["id"];
	$unique_id 			= $rst->fields["unique_id"];
	$caller_id 			= $rst->fields["caller_id"];
	$status 			= $rst->fields["status"];
	$update_datetime	= $rst->fields["update_datetime"];
	$minutes			= $rst->fields["minutes"];
	$seconds			= $rst->fields["seconds"];
	

	$sip = $tools_admin->sip_status();
	
	$_SESSION['unique_id'] = $unique_id;
	$_SESSION['caller_id'] = $caller_id;

	if($status == "2" )
		$status_str = "Ringing";
	else if($status == "3" )
		$status_str = "Talking with";	
/********************** PIN GENERATION **********************/
	else if($status == "201" )
		$status_str = "Pin Generation";		
	else if($status == "202" )
		$status_str = "Re-Enter Pin";	
	else if($status == "-200" )
		$status_str = "Pin Generation Failure";
	else if($status == "200" )
		$status_str = "Pin Generation Successfully";			
		
/********************** PIN RESET ****************************/		
	else if($status == "401" )
		$status_str = "Pin Reset";		
	else if($status == "402" )
		$status_str = "Re-Enter Pin";	
	else if($status == "-400" )
		$status_str = "Pin Reset Failure";
	else if($status == "400" )
		$status_str = "Pin Reset Successfully";
		
/********************** PIN VERIFICATION *********************/		
	else if($status == "301" )
		$status_str = "Pin Verify";
	else if($status == "-300" )
		$status_str = "Pin Verification Failure";
	else if($status == "300" ){
		$_SESSION[$db_prefix.'_UserPinVerification']= true;
		$status_str = "Pin Verfication Successfully";
	}

/********************** PIN change ****************************/		
	else if($status == "501" )
		$status_str = "Pin Verify";
	else if($status == "-500" )
		$status_str = "Pin Verification Failure";
	else if($status == "500" )
		$status_str = "Pin Verfication Successfully";
	else if($status == "601" )
		$status_str = "Pin Change";		
	else if($status == "602" )
		$status_str = "Re-Enter Pin";	
	else if($status == "-600" )
		$status_str = "Pin Change Failure";
	else if($status == "600" )
		$status_str = "Pin Change Successfully";
		
		
	
	/*else if($status == "300" ){
		$user_pin->update_user_status($unique_id,$caller_id,'-5',3,$_SESSION[$db_prefix.'_UserId']);					
		$status_str = "Pin Generated Successfully";	
	}
	else if($status == "200" ){
		$status_str = "Pin Verified Successfully";
		$user_pin->update_user_status($unique_id,$caller_id,'-6',3,$_SESSION[$db_prefix.'_UserId']);					
	}*/
	else if($status == "-1" ){
		$_SESSION[$db_prefix.'_UserPinVerification']= false;
		$_SESSION[$db_prefix.'_CustomerName'] = '';
		$_SESSION['ValidUser'] = 0;
		//echo "Pin verification --> ".$_SESSION[$db_prefix.'_UserPinVerification']." Valid user ---> ".$_SESSION['ValidUser'];
		//exit;
		$status_str = "Please Set WorkCodes";
		$que_str =  "unique_id=".$unique_id."&caller_id=".$caller_id;									
	}
?>

<div id="content-top">
	<h2>Dashboard</h2>
	 <h2> <?php if($tools_admin->is_call_center_on()){?>
    	<div  style="color: #6da827; margin-left: 90px">Call Center Is Live</div>
    <?php }else{?>
   	 	<div style="color: #ce2700; margin-left: 90px">Call Center Is Close</div>
    <?php } ?></h2>
	<?php $sip_status = $sip->fields["is_phone_login"];
	if($sip_status == 1)
	{
	 	if(empty($caller_id)  && $status <> "-1") 
		{ 	?>	
			<div style="float: right;" class="<?php echo $blink_me?>">
				<img src="images/icon-off-call.png" alt="Agent is Free" />
                <?php if($rs->fields["Number"]){ ?>
				Priority Call Alert <?php echo $rs->fields["Number"];?>
			<?php }else{?>
                    Agent is Free
                <?php } ?>
                </div> 
			<?php 
		}
		else if($status == "1") 
		{
			?>
			<div style="float: right;" class="<?php echo $blink_me?>">
				<img src="images/icon-off-call.png" alt="Agent is Free" />
				<?php if($rs->fields["Number"]){ ?>
				Priority Call Alert <?php echo $rs->fields["Number"];?>
			<?php }else{?>
                    Agent is Free
                <?php } ?>
			</div> 
			<?php
		}		  
		else if($status == "-1") 
		{	
			echo "<script language='javascript'>document.getElementById('timer').innerHTML = '';</script>";
		?>
			
		 	 <a href="#" onclick="javascript: popitup('call_hangup.php?+<?php echo $que_str; ?>');" id="topLink" title="Click here"><?php echo $status_str;?></a>
<?php 	}
		  else if($status == "200" || $status == "300" || $status == "400" || $status == "600") {?>
			<a href="<?php echo $_SESSION[$db_prefix.'_Page'];?>" id="topLink" title="Click here"><?php echo $status_str;?></a>
<?php 	} 
 		  else if($status == "-200" || $status == "-300" || $status == "-400" || $status == "-600") {?>
			<a href="<?php echo $_SESSION[$db_prefix.'_FPage'];?>" id="topLink" title="Click here"><?php echo $status_str;?></a>
<?php 	}
		else { ?>
			
			<a href="<?php if($status == "3"){ echo "index.php?caller_id=".$caller_id; }else{echo "#";} ?>" id="topLink" title="Click here for details">
				<?php echo $status_str;?> <img src="images/icon-on-call.png" alt="Click here for details"  />  <?php echo $caller_id;?> 
				<?php /*if($status == "3") { $que_str =  "unique_id=".$unique_id."&caller_id=".$caller_id;?><div id="timer" name="timer" style="color:#FF0000;float:right;"></div><a href="" onclick="javascript: popitup('call_hangup.php?+<?php echo $que_str; ?>');" title="Click here"><?php echo "Please Set WorkCodes";?></a> <?php }*/?>
			</a>
	<?php 	  } 
	}
	else{
	?>
		<div style="float: right;">
		<img src="images/icon-off-call.png" alt="Please Login Your Phone"  />Please login your soft phone.
		</div> 
	<?php 
	}
	?>
	<input id="last_status" name="last_status" type="hidden" value=<?php echo($status);?> />
	<input id="caller_id" name="caller_id" type="hidden" value=<?php echo($caller_id);?> />
	<input id="unique_id" name="unique_id" type="hidden" value=<?php echo($unique_id);?> />
	<span class="clearFix">&nbsp;</span>
	
	<?php 
/*		$customer_id	= $_REQUEST['customer_id'];
		$account_no		= $_REQUEST['account_no'];
	
		$method = 'IsPinExists';
		$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no,'CustomerId' => $customer_id);
		$isPinGenerated = $soap_client->call_soap_method_2($method,$params);
*/
	?>
	<!--<div >
		<label>Pin Generated :</label>
		<label><?php //echo empty($isPinGenerated)?"No":"Yes"; ?></label>
	</div>-->

	
</div>
	<?php if(!empty($caller_id)) { ?>
<script> 
	var milisec=0 
	var seconds=<?php echo $seconds;?> 
	var minutes=<?php echo $minutes;?> 

	function display(){ 
		if (milisec>=9){ 
			milisec=0 
			seconds+=1 
		}
		if (seconds>=59){ 
			milisec=0 
			seconds=0 
			minutes+=1
		}  
		else 
		milisec+=1 
		//document.counter.timer.value=minutes+":"+seconds+"."+milisec  
		document.getElementById('timer').innerHTML = minutes+":"+seconds+"."+milisec
		setTimeout("display()",100) 
	} 
	display() 
</script> 
<?php } ?>