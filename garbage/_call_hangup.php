<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "call_hangup.php";
	$page_title = "Call Hangup | Step 1";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Call Hangup";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/work_codes.php");
	$work_codes = new work_codes();
	
?>
<?php include($site_root."includes/iheader.php");?>
<?php
  $cb = $_POST['cb'];

if(isset($_REQUEST['submitwc'])){
  if(empty($cb)){
    echo("You didn't select any workcodes.");
  }
  else{
	$unique_id = $_REQUEST["unique_id"];
	$caller_id = $_REQUEST["caller_id"];
	$agent_id = $_SESSION[$db_prefix.'_UserId'];
    $N = count($cb);
    	//echo("You selected $N workcodes(s): ");
    for($i=0; $i < $N; $i++){
      	//echo($cb[$i] . " ");
	  $workcodes =$cb[$i];
	  $work_codes->insert_work_codes($unique_id, $caller_id, $workcodes, $agent_id);
	  $que_str =  "unique_id=".$unique_id."&caller_id=".$caller_id; 
	  
    }
	header ("Location: call_hangup2.php?".$que_str);
	$tools_admin->update_cdr($unique_id, $agent_id);
  }
}
?>
<div class="box">      

	<h4 class="white"><?php echo "Set Work Codes" ;?></h4>
		<div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
				<input type="hidden" id="caller_id" name="caller_id" value="<?php echo $_REQUEST["caller_id"];?>"/>
				<input type="hidden" id="unique_id" name="unique_id" value="<?php echo $_REQUEST["unique_id"];?>"/>
				<div style="padding:10px; overflow-y: auto; height:450px; ">
					<?php  
						$html =''; //$is_child=0; $func_count=0;
						echo $work_codes->xrecursive_make_tree(0,'root'); 
					?>					
				</div>	
			<div style="padding:10px;">
				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Submit</span></a>
				<input type="hidden" value="submitwc" id="submitwc" name="submitwc" />
			</div>	
			</form>
    	</div>
</div>
<?php include($site_root."includes/ifooter.php"); ?> 