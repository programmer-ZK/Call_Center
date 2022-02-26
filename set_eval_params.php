<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "set_eval_params.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Set Evaluation Parameters";
        $page_menu_title = "Set Evaluation Parameters";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/reports.php");
	$reports = new reports();
		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
	
	include_once("classes/cc_evaluation.php");
	$cc_evaluation = new cc_evaluation();
	/*require("../fpdf17/fpdf.php");
	require("/classes/pdfgen.php");*/
?>	
<?php

	$get_questions 	= $cc_evaluation->get_questions($txtSearch);
	$get_points 	= $cc_evaluation->get_points($txtSearch);

?>
<?php include($site_root."includes/header.php"); ?>	

<?php
 for ($i=0; $i<=3; $i++)
 {
 	$p_val_error[$i] = "display: none;";
 }	

 if(isset($_REQUEST['set_eval2']))
 { 
	$admin_id = $tools_admin->decryptId($_REQUEST['admin_id']);
	$count = $_REQUEST['count'];
	for ($i=0; $i <= $count; $i++)
	{
		$flag = true;
		//echo $_REQUEST['points'.$i]."---".$_REQUEST['p_val'.$i]."-----" ."----".$admin_id."    ";
		$j = ($i == 0)?$i:$i - 1;
		$pre_value = $_REQUEST['p_val'.$j];
		
		if ($_REQUEST['p_val'.$i] == "" || $_REQUEST['p_val'.$i] == NULL)
		{
			$flag = false;
			$p_val_error[$i] = "";
		}
		if ($flag == true && !empty($pre_value))
		{
			$cc_evaluation->update_evaluation_points($_REQUEST['points'.$i],$_REQUEST['p_val'.$i], $admin_id);
			$count_updated_params .= $i;
			//echo $i;
		}
	}
	//exit;
	if ($count_updated_params == "0123")
	{
		$_SESSION[$db_prefix.'_GM'] = "Evaluation parameters successfully updated.";
		header('Location:set_eval_params.php');
	}
 }
?>

<div class="box">
	<h4 class="white"><?php echo($page_title); ?></h4>
	<div class="box-container">	
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
            	<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $tools_admin->encryptId($_SESSION[$db_prefix.'_UserId']); ?>">
                    
				<fieldset>
					<h3><?php echo($page_title); ?></h3>
					<ol>
                    <?php
					
					  $row_color = 'even';
                      $i = 0;
					  while(!$get_points->EOF){ 
					?>
                    	<li class="<?php echo $row_color;?>">
							<label class="field-title"><?php echo strtoupper($get_points->fields["points"]);?> <font color="red"><em>*</em></font>:</label>
							<input id="p_val" name="p_val<?php echo $i;?>" maxlength="2" size="2" value="<?php echo $get_points->fields["value"];?>" />
							<span id="p_val_error<?php echo $i;?>" class="form-error-inline" style="<?php echo($p_val_error[$i]); ?>">Please don't left this field blank.</span>	
                            <input type="hidden" id="points" name="points<?php echo $i;?>" value="<?php echo $get_points->fields["points"];?>" />
                            <input type="hidden" id="count" name="count" value="<?php echo $i;?>" />
                            
							<?php  //echo $txtcaller_id_error;?>
						</li>	
                        	
					<?php
						  
						  if ($row_color == 'even')
						  {
							  $row_color = '';
						  }
						  else
						  {
							  $row_color = 'even';
						  }
		                  $i++;
						  $get_points->MoveNext(); 

                		}
                	?>		
					</ol>
					<p class="align-right">
						<a class="button" href="javascript:document.xForm.submit();"><span>Update</span></a>
						<input type="hidden" value="SUBMIT EVAL FORM >>"     name="set_eval2" id="set_eval2"/>	
					</p>
				</fieldset>      

    	</form>
	</div>
</div> 
<?php include($site_root."includes/footer.php"); ?> 
