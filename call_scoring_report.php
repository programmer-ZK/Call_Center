<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "call_scoring_report.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Call Scoring Report";
        $page_menu_title = "Call Scoring Report";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/reports.php");
	$reports = new reports();
	
	include_once("classes/cc_evaluation.php");
	$cc_evaluation = new cc_evaluation();
?>	
<?php include($site_root."includes/iheader.php"); ?>	
   
<?php	
	
	$unique_id 	= 	$_REQUEST['unique_id'];
	$agent_name =  	$_REQUEST['agent_name'];
	$duration 	= 	$_REQUEST['duration'];
	$call_type 	= 	$_REQUEST['call_type'];
	//$evaluate_agent_id =  $_REQUEST['evaluate_agent_id'];

	$recStartFrom = 0;
	$field = empty($_REQUEST["field"])?"staff_updated_date":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"asc":$_REQUEST["order"];
	//$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order,'','');
	$groups = $reports->get_evaluation_groups();
	$question_list = $reports->get_question_list();
	$evaluator_list = $reports->get_evaluator_list();
	$avg = array();
	$eval_count = array();
?>
<script type="text/javascript" language="javascript1.2">

function showComments(comm){
	if(comm || 0 !== comm.length){
		alert(comm);
	}
	else{
		alert("No Comments available!");
	}
}
</script>
<?php 
/************************* Export to Excel ******************/
/*if(isset($_REQUEST['export'])){
	
	$stringData			= trim($_REQUEST['stringData']);
	$db_export_fix = $site_root."download/Productivity_Report.csv";
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
 	ob_end_clean();
	header('Content-disposition: attachment; filename='.basename($db_export_fix));
	header('Content-type: text/csv');
	readfile($db_export_fix);
    if(file_exists($db_export_fix) && !empty($file_name)){
    	unlink($db_export_fix);
    }
    exit();	 
}

if(isset($_REQUEST['export_pdf']))
{
								
	$stringData			= trim($_REQUEST['stringData']);
	$db_export_fix = $site_root."download/Productivity_Report.csv";
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix);
	ob_end_clean();
	$tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 10, 'Productivity_Records.pdf', 'D', 60, 7, 1);
	exit();
}*/
/******************************************************************************/	
//$stringData	 = '';
?>


<div>
	<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">

		<div id="mid-col" class="mid-col">
			<div class="box" style="width:920px"><h4 class="white"><?php echo "Call Summary"; ?></h4>
			<div class="box-container"  >  
				<table style=" border-style:solid; width:270; background-color:#E8E8DD;" class="table-short" >
				<tbody>
				<tr><td style=" padding-top:10">
				<h3 style="color:#000000; font-size:14px">Agent Name:&nbsp;<?php echo $agent_name; ?></h3>
				<h3 style="color:#000000; font-size:14px">Call Traking ID:&nbsp;<?php echo $unique_id; ?></h3>
				<h3 style="color:#000000; font-size:14px">Call Type :&nbsp;<?php echo $call_type; ?></h3>
				<h3 style="color:#000000; font-size:14px">Call Duration :&nbsp;<?php echo $duration; ?></h3>
				</td></tr>
				</tbody>
				</table>
			</div>
			<div class="box-container"  > 	
						<table class="table-short" style=" width:910px;border:solid;">
							<thead>
								<tr>
									<td colspan="12" class="paging"><?php //echo($paging_block);?></td>
								</tr>
								<tr>
									<td class="col-head2">Questions</td>
									<?php $i=0; while(!$evaluator_list->EOF){ ?>
									 <td class="col-head2"><?php echo $evaluator_list->fields['full_name']; ?></td>
									<?php 	
											$evaluator_id[$i] = $evaluator_list->fields['admin_id'];
											$evaluator_list->MoveNext(); 
											$i++;
										} 

										for ($j=0;$j < count($evaluator_id);$j++)
										{
											$rs = $cc_evaluation->get_score($unique_id,$evaluator_id[$j],'');
											$evaluated_scores[$j] = $rs->fields['scores'];
											
											if ($evaluated_scores[$j] != '' && $evaluated_scores[$j] != NULL) {
												$count_eval_col ++;
											}
											
											$total_call_score += $evaluated_scores[$j];
										}
									?> 
									<td class="col-head2">Score</td>
								
									<!--<td class="col-head2">E2</td>
									<td class="col-head2">E3</td>
									<td class="col-head2">E4</td>
									<td class="col-head2">E5</td>-->
								</tr>
							</thead>
							<tbody>
								<tr>
									<td id="col1">
										<table >
										<?php $ques_count=0; while(!$question_list->EOF){ ?>
											<tr>
												<td style=" font-size:11px;">
												 <?php echo $question_list->fields['question_code']; ?>
												</td>
											</tr>
										<?php $ques_count++; $question_list->MoveNext(); } ?>
										</table>
									</td>
									<td id="col2">
										<table >
											<?php 
											$eval_score = $reports->call_scoring($unique_id, $evaluator_id[0]);
											$count=0;
											//$eval_count=0;
											//echo $eval_score->RecordCount();exit;
											if ($eval_score->RecordCount() > 0){
												$flag_evaluator = true;
												
											$i = 1;
											while($count < $ques_count && $flag_evaluator){ //!$eval_score->EOF
										    ?>
											<tr>
												<!--<td style=" font-size:11px;" colspan="100">-->
					<td colspan="110">
				
					<?			 				
							 $rsw = $reports->call_comments($unique_id, $evaluator_id[0],$i);
                              while (!$rsw->EOF){
                                   
                                    $comments =$rsw->fields['comments'];
                                  
                                    $rsw->MoveNext();
                                } $i++;
                            ?>					
												
												
		<a href="#"  name="<?php echo $comments;?>" onclick="showComments(this.name)" ><?php echo $eval_score->fields['percent']==NULL?'0':$eval_score->fields['percent'];
		
		?></a>
		<?
												if($eval_score->fields['percent']==0)
													{
														$avg[$count] += 0;
														$eval_count[$count] += 0;
													}
												else{
												 		$avg[$count] += $eval_score->fields['percent'];
														$eval_count[$count] += 1;
													}
												?>
												</td>
											</tr>
										 <?php $count++; $eval_score->MoveNext();} 
										 
										 }
										 ?>	
										</table>
									</td>
									<td id="col3">
										<table>
											<?php 
											$eval_score = $reports->call_scoring($unique_id, $evaluator_id[1]);
											$count=0;
											if ($eval_score->RecordCount() > 0){
												$flag_evaluator = true;
												
											$i=1;
											while($count < $ques_count && $flag_evaluator){ //!$eval_score->EOF
										    ?>
											<tr>
												<td style=" font-size:11px;">
												<?			 				
							 $rsw = $reports->call_comments($unique_id, $evaluator_id[0],$i);
                              while (!$rsw->EOF){
                                   
                                    $comments =$rsw->fields['comments'];
                                  
                                    $rsw->MoveNext();
                                } $i++;
                            ?>					
												
												
		<a href="#"  name="<?php echo $comments;?>" onclick="showComments(this.name)" ><?php echo $eval_score->fields['percent']==NULL?'0':$eval_score->fields['percent'];
		
		?></a>
		<?
												if($eval_score->fields['percent']==0)
													{
														$avg[$count] += 0;
														$eval_count[$count] += 0;
													}
												else{
												 		$avg[$count] += $eval_score->fields['percent'];
														$eval_count[$count] += 1;
													}
												?>
												</td>
											</tr>
										 <?php $count++; $eval_score->MoveNext();} 
										 
										 }
										 ?>	
										</table>
									</td>
									<td id="col4">
										<table>
											<?php 
											$eval_score = $reports->call_scoring($unique_id, $evaluator_id[2]);
											$count=0;
											if ($eval_score->RecordCount() > 0){
												$flag_evaluator = true;
												
											$i=1;
											while($count < $ques_count && $flag_evaluator){ //!$eval_score->EOF
										    ?>
											<tr>
												<td style=" font-size:11px;">
												<?			 				
							 $rsw = $reports->call_comments($unique_id, $evaluator_id[0],$i);
                              while (!$rsw->EOF){
                                   
                                    $comments =$rsw->fields['comments'];
                                  
                                    $rsw->MoveNext();
                                } $i++;
                            ?>					
												
												
		<a href="#"  name="<?php echo $comments;?>" onclick="showComments(this.name)" ><?php echo $eval_score->fields['percent']==NULL?'0':$eval_score->fields['percent'];
		
		?></a>
		<?	if($eval_score->fields['percent']==0)
													{
														$avg[$count] += 0;
														$eval_count[$count] += 0;
													}
												else{
												 		$avg[$count] += $eval_score->fields['percent'];
														$eval_count[$count] += 1;
													}
												?>
												</td>
											</tr>
										 <?php $count++; $eval_score->MoveNext();} 
										 
										 }
										 ?>	
										</table>
									</td>
									<td id="col5">
										<table>
											<?php 
											$eval_score = $reports->call_scoring($unique_id, $evaluator_id[3]);
											$count=0;
											if ($eval_score->RecordCount() > 0){
												$flag_evaluator = true;
												
											$i=1;
											while($count < $ques_count && $flag_evaluator){ //!$eval_score->EOF
										    ?>
											<tr>
												<td style=" font-size:11px;">
												<?			 				
							 $rsw = $reports->call_comments($unique_id, $evaluator_id[0],$i);
                              while (!$rsw->EOF){
                                   
                                    $comments =$rsw->fields['comments'];
                                  
                                    $rsw->MoveNext();
                                } $i++;
                            ?>					
												
												
		<a href="#"  name="<?php echo $comments;?>" onclick="showComments(this.name)" ><?php echo $eval_score->fields['percent']==NULL?'0':$eval_score->fields['percent'];
		
		?></a>
		<?
												if($eval_score->fields['percent']==0)
													{
														$avg[$count] += 0;
														$eval_count[$count] += 0;
													}
												else{
												 		$avg[$count] += $eval_score->fields['percent'];
														$eval_count[$count] += 1;
													}
												?>
												</td>
											</tr>
										 <?php $count++; $eval_score->MoveNext();} 
										 
										 }
										 ?>	
										</table>
									</td>
									<td id="col6">
										<table>
											<?php 
											$eval_score = $reports->call_scoring($unique_id, $evaluator_id[4]);
											$count=0;
											if ($eval_score->RecordCount() > 0){
												$flag_evaluator = true;
												
											
											while($count < $ques_count && $flag_evaluator){ //!$eval_score->EOF
										    ?>
											<tr>
												<td style=" font-size:11px;">
												
													<?			 				
							 $rsw = $reports->call_comments($unique_id, $evaluator_id[0],$i);
                              while (!$rsw->EOF){
                                   
                                    $comments =$rsw->fields['comments'];
                                  
                                    $rsw->MoveNext();
                                } $i++;
                            ?>					
												
												
		<a href="#"  name="<?php echo $comments;?>" onclick="showComments(this.name)" ><?php echo $eval_score->fields['percent']==NULL?'0':$eval_score->fields['percent'];
		
		?></a>
		<?
												
												
									
												if($eval_score->fields['percent']==0)
													{
														$avg[$count] += 0;
														$eval_count[$count] += 0;
													}
												else{
												 		$avg[$count] += $eval_score->fields['percent'];
														$eval_count[$count] += 1;
													}
												?>
												</td>
											</tr>
										 <?php $count++; $eval_score->MoveNext();} 
										 
										 }
										 ?>	
										</table>
									</td><td></td>
									<td id="col7">
									
										<table>
											<?php 
											//$eval_score = $reports->call_scoring($unique_id, $evaluator_id[4]);
											$count=0;
											$sum=0;
											$total_avg=0;
											while($count < $ques_count){ //17
										    ?>
											<tr>
												<td style=" font-size:11px;">
												<?php //echo $eval_score->fields['percent'];
												 if($eval_count[$count] == 0){
												 	echo '0';
												 	$count++;
												 }
												 else{
												 	$total = $avg[$count]/$eval_count[$count];
												 	$sum += $total;
												 	echo round($total,2);
												 	$count++;
													$total_avg++;
													}
												}?>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</tbody>
						</table>
						</div>	
						<h2 style="float:right">Total Call Score:&nbsp;
						<?php 
							//echo round($sum/$total_avg,2) ; 
							echo round(($total_call_score/$count_eval_col),2);
						?>
						</h2>		
					</div>
				</div>
			</div>	
		</form>
	</div>
<?php include($site_admin_root."includes/ifooter.php"); ?>
