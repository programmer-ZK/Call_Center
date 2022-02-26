<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "test_scores.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Test Scores";
        $page_menu_title = "Test Scores";
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

<?php include($site_root."includes/header.php"); ?>	


<?php
$combo_agent_id_error = "display: none;";
$t_code_error = "display: none;";
$t_name_error = "display: none;";
$t_date_error ="display: none;";
$t_score_error ="display: none;";

if(isset($_REQUEST['t_score_add']))
 { 
 	$flag = true;
 
	$admin_id = $tools_admin->decryptId($_REQUEST['admin_id']);
	$agent_id = $_REQUEST['combo_agent_id'];
	$test_code = $_REQUEST['t_code'];
	$test_name = $_REQUEST['t_name'];
	$test_date = $_REQUEST['t_date'];
	$test_score = $_REQUEST['t_score'];
	$test_comment = $_REQUEST['t_comment'];
	if($agent_id == 0){
	$flag = false;
	$combo_agent_id_error = "";
	}
	if($test_code == ""){
	$flag = false;
	$t_code_error = "";
	}
	if($test_name == ""){
	$flag = false;
	$t_name_error = "";
	}
	if($test_date == ""){
	$flag = false;
	$t_date_error ="";
	}
	if($test_score == ""){
	$flag = false;
	$t_score_error ="";
	}
	if($flag == true){

		//echo $_REQUEST['points'.$i]."---".$_REQUEST['p_val'.$i]."-----" ."----".$admin_id."    ";
		$cc_evaluation->insert_evaluation_test_scores($agent_id, strtoupper($test_code), $test_name, $test_date, $test_score, $admin_id, $test_comment);
		//exit;
		$_SESSION[$db_prefix.'_GM'] = "Test score successfully added.";
		header('Location:test_scores.php?operation=add');
	}
 }
 
 if ($_REQUEST['operation'] == "edit")
 {
 	$admin_id = $tools_admin->decryptId($_REQUEST['admin_id']);
	$agent_id = $_REQUEST['combo_agent_id'];
	$test_code = $_REQUEST['t_code'];
	$test_name = $_REQUEST['t_name'];
	$test_date = $_REQUEST['t_date'];
	$test_score = $_REQUEST['t_score'];
	$test_comment = $_REQUEST['t_comment'];
	$id = $_REQUEST['id'];
 }
 if(isset($_REQUEST['t_score_edit']))
 { 
 	$flag = true;
 
	$admin_id = $tools_admin->decryptId($_REQUEST['admin_id']);
	$agent_id = $_REQUEST['combo_agent_id'];
	$test_code = $_REQUEST['t_code'];
	$test_name = $_REQUEST['t_name'];
	$test_date = $_REQUEST['t_date'];
	$test_score = $_REQUEST['t_score'];
	$test_comment = $_REQUEST['t_comment'];
	$id = $_REQUEST['id'];
	$del_bit = 0;
	
	if($agent_id == 0){
	$flag = false;
	$combo_agent_id_error = "";
	}
	if($test_code == ""){
	$flag = false;
	$t_code_error = "";
	}
	if($test_name == ""){
	$flag = false;
	$t_name_error = "";
	}
	if($test_date == ""){
	$flag = false;
	$t_date_error ="";
	}
	if($test_score == ""){
	$flag = false;
	$t_score_error ="";
	}
	if($flag == true){

		//echo $_REQUEST['points'.$i]."---".$_REQUEST['p_val'.$i]."-----" ."----".$admin_id."    ";
		$cc_evaluation->update_evaluation_test_scores($id, $agent_id,strtoupper($test_code), $test_name, $test_date, $test_score, $admin_id, $del_bit, $test_comment);
		//exit;
		$_SESSION[$db_prefix.'_GM'] = "Test score successfully updated.";
		header('Location:test_scores_list.php');
	}
 }
?>

<?php if ($_REQUEST['operation'] == "add" || $_REQUEST['operation'] == "edit" || isset($_REQUEST['t_score_add']) || isset($_REQUEST['t_score_edit']))
{ ?>
<div class="box">
	<h4 class="white"><?php echo($page_title); ?></h4>
	<div class="box-container">	
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return score_validate(this);">
            		<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $tools_admin->encryptId($_SESSION[$db_prefix.'_UserId']); ?>">
                    
				<fieldset>
					<h3><?php echo($page_title); ?></h3>
					<ol>
                    <?php
					
					  /*$row_color = 'even';
                      $i = 0;
					  while(!$get_points->EOF){ */
					?>
                    	<li class="even">
							<label class="field-title">Agent Name <font color="red"><em>*</em></font>:</label>
							<?php  
							if (isset($_REQUEST['combo_agent_id']) && $_REQUEST['combo_agent_id'] != 0)
							{
								$combo_value = $_REQUEST['combo_agent_id'];
							}
							else
							{
								$combo_value = "";
							}
							
							echo $tools_admin->getcombo('admin','combo_agent_id','admin_id','full_name',$combo_value,"","form-select","","an agent",'group_id = 2 order by full_name asc'); 
							?>     
							<span id="combo_agent_id_error" class="form-error-inline" style="<?php echo($combo_agent_id_error); ?>"></span>
							<?php  //echo $txtcaller_id_error;?>
						</li>	
						<li class="even">
							<label class="field-title">Test Code <font color="red"><em>*</em></font>:</label>
							<input style="width:163px;" maxlength="50" id="t_code" name="t_code" value="<?php echo $test_code; ?>"/> 
							<span id="t_code_error" class="form-error-inline" style="<?php echo($t_name_error); ?>"></span>
							<?php  //echo $txtcaller_id_error;?>
						</li>	
						<li class="">
							<label class="field-title">Test Name <font color="red"><em>*</em></font>:</label>
							<input style="width:163px;" maxlength="50" id="t_name" name="t_name" value="<?php echo $test_name; ?>"/> 
							<span id="t_name_error" class="form-error-inline" style="<?php echo($t_name_error); ?>"></span>
							<?php  //echo $txtcaller_id_error;?>
						</li>	
						<li class="even">
							<label class="field-title">Test Date <font color="red"><em>*</em></font>:</label>
							<input style="width:163px;" onclick="javascript:NewCssCal ('t_date','yyyyMMdd', 'dropdown')" readonly="readonly" autocomplete="off" value="<?php echo $test_date; ?>" class="txtbox-short-date" id="t_date" name="t_date">   
							<span id="t_date_error" class="form-error-inline" style="<?php echo($t_date_error); ?>"></span>
							<?php  //echo $txtcaller_id_error;?>
						</li>
                        <li class="">
							<label class="field-title">Test Score (%)<font color="red"><em>*</em></font>:</label>
                            <input style="width:163px;" maxlength="20" id="t_score" name="t_score" value="<?php echo $test_score; ?>"/>
							<span id="t_score_error" class="form-error-inline" style="<?php echo($t_score_error); ?>"></span>
							<?php  //echo $txtcaller_id_error;?>
						</li>
						<li class="even">
							<label class="field-title">Comment :</label>
                            <input style="width:163px;" maxlength="255" id="t_comment" name="t_comment" value="<?php echo $test_comment; ?>"/>
							<!--<span id="t_comment_error" class="form-error-inline" style="<?php //echo($t_comment_error); ?>"></span>-->
							<?php  //echo $txtcaller_id_error;?>
						</li>
					<?php
						  
						 /* if ($row_color == 'even')
						  {
							  $row_color = '';
						  }
						  else
						  {
							  $row_color = 'even';
						  }
		                 // $i++;
						 // $get_points->MoveNext(); 

                		//}*/
                	?>			
					</ol>
					<p class="align-right">
					<?php if ((isset($_REQUEST['operation']) && $_REQUEST['operation'] == "add")){?>
						<a class="button" href="javascript:document.xForm.submit();"><span>Add</span></a>
						<input type="hidden" value="SUBMIT T_SCORE FORM >>"     name="t_score_add" id="t_score_add"/>	
						<input type="hidden" value="add" name="operation" id="operation"/>	
					<?php } ?>
					<?php if ((isset($_REQUEST['operation']) && $_REQUEST['operation'] == "edit")){?>
						<a class="button" href="javascript:document.xForm.submit();"><span>Update</span></a>
						<input type="hidden" value="SUBMIT T_SCORE FORM >>"     name="t_score_edit" id="t_score_edit"/>	
						<input type="hidden" value="<?php echo $id; ?>"     name="id" id="id"/>
					<?php } ?>
						<a class="button" href="test_scores_list.php"><span>List</span></a>		
					</p>
				</fieldset>      

    	</form>
	</div>
</div> 
<?php } ?>
<?php include($site_root."includes/footer.php"); ?> 
