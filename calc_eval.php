<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "calc_eval.php";
	$page_title = "call evaluation";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "call evaluation";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
	
	include_once("classes/cc_evaluation.php");
	$cc_evaluation = new cc_evaluation();
	
	include_once("classes/user_tools.php");		
        $user_tools = new user_tools();

	
?>
<?php include($site_root."includes/iheader.php"); ?>
		
<?php	
	
	$get_questions 	= $cc_evaluation->get_questions($txtSearch);
	$get_points 	= $cc_evaluation->get_points($txtSearch);
	
	
	$count = $get_questions->RecordCount();
	//echo $count2; exit;
?>


<script type="text/javascript">
function is_check(index)
{

	//var combo_type  = this.document.getElementById('transaction_nature');
	var flag = this.document.getElementById('flag_call').value;
	var t_need = this.document.getElementById('training_need').value;
	if(flag == '-1' && t_need == '-1')
	{
		this.document.getElementById('btn_flag').style.display="none";
	}else
	{
		this.document.getElementById('btn_flag').style.display="";
	}
	
}


function evaluation_validate(){
/*	alert('Hi');
	return false;
*/
	var admin_id 	= this.document.getElementById('admin_id');
	var agent_exten	= this.document.getElementById('agent_exten');
	var full_name 	= this.document.getElementById('full_name');
	var email 		= this.document.getElementById('email');
	var password 	= this.document.getElementById('password');
	var re_password = this.document.getElementById('re_password');
	var designation	= this.document.getElementById('designation');
	var department 	= this.document.getElementById('department');
	var group_id 	= this.document.getElementById('group_id');
	var flag = true;
	var err_msg = '';
	
	if(agent_exten.value == ''){
		err_msg+= 'Missing Agent Exten\n';
		this.document.getElementById('agent_exten_error').style.display="";
	}
	if(full_name.value == ''){
		err_msg+= 'Missing Full Name\n';
		this.document.getElementById('full_name_error').style.display="";
	}
	if(email.value == ''){
		err_msg+= 'Missing Email\n';
		this.document.getElementById('email_error').style.display="";
	}
	
	
	if(admin_id.value == '' || admin_id.value == 0){
		if(password.value == ''){
			err_msg+= 'Missing Password\n';
			this.document.getElementById('password_error').style.display="";	
			flag =false;
		}
		if(re_password.value == ''){
			err_msg+= 'Missing Confirm Password\n';
			this.document.getElementById('re_password_error').style.display="";
			flag =false;
		}
		if((password.value != re_password.value) && (flag==true)){
			err_msg+= 'Both Password must be same\n';
			this.document.getElementById('re_password_error').style.display="";
		}
	}
	
	if(designation.value == ''){
		err_msg+= 'Missing Designation\n';
		this.document.getElementById('designation_error').style.display="";
	}
	
	if(department.value == ''){
		err_msg+= 'Missing Department\n';
		this.document.getElementById('department_error').style.display="";
	}
	
	if(group_id.value == 0){
		err_msg+= 'Missing Group\n';
		this.document.getElementById('group_id_error').style.display="";
	}

	if(err_msg == '' && IsEmpty(err_msg)){
		return true;
	}
	else{
		//alert(err_msg);
		return false;
	}
}
</script>
<script type="text/javascript">
$.validator.setDefaults({
	submitHandler: function() { alert("submitted!");  /*$("#xForm").submit(); */ }
});

$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	
	// validate signup form on keyup and submit
	$("#xForm").validate({
		rules: {
			agent_exten: "required",
			full_name: "required",
			password: "required",
			re_password: "required",
            designation: "required",
            department: "required",
		},
		messages: {
			agent_exten: "Please enter agent extension",
			full_name: "Please enter user name",
			password: "Please enter password",
			re_password: "Please enter confirm password",
            designation: "Please enter designation",
            department: "Please enter department",
		}
	});
});
</script>


<?php
$is_submit = 0;

$var_yes 		=   $get_points->fields["value"]; 
$pvar_yes 		=   $get_points->fields["points"];
$get_points->MoveNext(); 
$var_no			=   $get_points->fields["value"];
$pvar_no 		=   $get_points->fields["points"];
$get_points->MoveNext(); 
$var_nimp 		=   $get_points->fields["value"];
$pvar_nimp 		=   $get_points->fields["points"];
$get_points->MoveNext(); 
$var_na 		=   $get_points->fields["value"];
$pvar_na 		=   $get_points->fields["points"];
$get_points->MoveNext(); 
//$count2 = $cc_evaluation->get_record_count($alpha);

 for($i=0; $i < $count; $i++)
{	
				  
	$RadioGroup_error[$i] = "display:none;";
	$_comment_error[$i] = "display:none;";
	
	//echo $RadioGroup_error[$count2];
	//echo $_comment_error[$count2];
}


$agent_id = $_SESSION[$db_prefix.'_UserId'];
$unique_id = $_REQUEST['unique_id'];
$evaluate_agent_id =  $_REQUEST['evaluate_agent_id'];
$duration = $_REQUEST['duration'];
$call_type = $_REQUEST['call_type'];
$calldate = $_REQUEST['calldate'];



		$url	= 'http://crm:8080/index.php?action=DetailView&module=HelpDesk&parenttab=Support&record=[TicketNumber]';
		$replace_pattern	= '[TicketNumber]';
	$wcodes = "";
	$rsw = $user_tools->get_call_workcodes($unique_id);
	while(!$rsw->EOF){
		$wcodes.= $rsw->fields["workcodes"].';'.$user_tools->make_url($rsw->fields["detail"],$url,$replace_pattern).'<br>';
		$rsw->MoveNext();
	}



$get_score	    = $cc_evaluation->get_score($_REQUEST['unique_id'], $agent_id,$evaluate_agent_id );

	if(isset($_REQUEST['flag_save']) )
	{	
		$flag_call = $_REQUEST['flag_call'];
		$training_need = $_REQUEST['training_need'];
		$cc_evaluation->update_evaluation_scores($unique_id, $agent_id, $evaluate_agent_id,$flag_call,$training_need);
		$_SESSION[$db_prefix.'_GM'] = "Flag Saved Successfully";
	}

	if(isset($_REQUEST['eval_form']) )
	{	
		$countYes 	=0;
		$countNo 	=0;
		$countNimp 	=0;
		$countNa	=0;
		$flag = true;
		$count = $_REQUEST['count'];
		 for($i=0; $i < $count; $i++)
		{
	    	  $point[$i] = $_REQUEST['RadioGroup'.$i];
			  $comment[$i] = $_REQUEST['_comment'.$i];
			  if($point[$i] == "")
			  {
			  	$flag = false;
				$RadioGroup_error[$i] = " ";
			  	//echo "point-error";
			  }else if($point[$i] == $var_nimp)
			  {
			  	if($comment[$i] == "")
				{
					$flag = false;
					$_comment_error[$i] = " ";
					//echo "comment-error";
				}
			  }
			  if($point[$i] == $var_yes && $point[$i] != ""){$ischeckedYes[$i] = "checked=\"checked\""; $countYes++;}
			  if($point[$i] == $var_no && $point[$i] != ""){$ischeckedNo[$i] = "checked=\"checked\""; $countNo++;}
			  if($point[$i] == $var_nimp && $point[$i] != ""){$ischeckedNimp[$i] = "checked=\"checked\""; $countNimp++;}
			  if($point[$i] == $var_na && $point[$i] != ""){$ischeckedNa[$i] = "checked=\"checked\""; $countNa++;}
			  
			 // print_r($point);
			  //echo $point; 
		  	  //$flag = false;
	  	}
		if($flag == true)
		{
			$final_score = ((($countYes * $var_yes) + ($countNimp * $var_nimp) + ($countNo * $var_no)) / (($count - $countNa) * 3)) * 100;
			$position = strpos($final_score, "-");
			if ($position === false && $count != $countNa)
    			{}
			else
				{$final_score = 0;}
			//echo $final_score; exit;
		    $cc_evaluation->insert_evaluation_scores($unique_id, $agent_id, $final_score, $count, $evaluate_agent_id,$countYes,$countNo,$countNimp,$countNa,$calldate);
			for($i=0; $i < $count; $i++)
			{
	    	  $point = $_REQUEST['RadioGroup'.$i];
			  $comment2 = $_REQUEST['_comment'.$i];
			  
			  if($point == $var_yes){$point_type = $pvar_yes;}
			  if($point == $var_no){$point_type = $pvar_no;}
			  if($point == $var_nimp){$point_type = $pvar_nimp;}
			  if($point == $var_na){$point_type = $pvar_na;}
			  
			 // echo $count; exit;
		  	 $cc_evaluation->insert_evaluation($unique_id, $agent_id, $point, $comment2, $i+1, $point_type,$evaluate_agent_id,$calldate,$final_score);
	  		}
			$is_submit = 1;
  		}
		
	}
	

?>

<?php
$dateTime = date("Y-m-d");
// it should be implemeted to extracted evaluated agent score details and display after click on call id (form not open in case of evaluated agent)
	if ($_REQUEST['evaluated'] == 'true')
	{
		$count = $get_score->fields['no_of_questions'];
		$final_score = $get_score->fields['scores'];
		$countYes = $get_score->fields['no_of_yes'];
		$countNo = $get_score->fields['no_of_no'];
		$countNimp = $get_score->fields['no_of_nimp'];
		$countNa = $get_score->fields['no_of_na'];
		$dateTime = $get_score->fields['updated_datetime'];
		$callFlag = $get_score->fields['flag_call'];
		$trainingNeed = $get_score->fields['training_need'];
		//this fields should be added in table
		/*$get_score->fields['no_counts'];
		$get_score->fields['yes_counts'];
		$get_score->fields['nimp_counts'];
		$get_score->fields['na_questions'];*/
	}

?>

<?php if($is_submit == 1 || $_REQUEST['evaluated'] == 'true'){ ?>
<div class="box" >      
<h4 class="white">Call Evaluation Score</h4>
  <div style="border:solid" class="box-container" >


<form name="xForm2" id="xForm2" class="middle-forms cmxform">
      		<fieldset>
      			<legend>Total Scores</legend>

<ol >
<label style="width:auto" class="field-title"><b>
Call Tracking ID: &nbsp;<?php echo $unique_id; ?><br> 
	<?php echo "Call Duration: ".$duration." <br> Call Type: ".$call_type; 
	$rs_agent_name = $admin->get_agent_name($evaluate_agent_id);
	
	echo " <br> Agent Name - ".$rs_agent_name->fields["full_name"];






	

	echo " <br> Work Codes - ".$wcodes."<br><br>";
	?> </b>

</label>
 <table >
		<tbody>
		<tr ><label>
		<td  style="width:150px; font-size:12px; border-bottom:inset; border-bottom-width:1px"> Evaluated Date:&nbsp;</td>
		<td style="width:50px; font-size:12px; border-bottom:inset; border-bottom-width:1px " ><?php echo $dateTime; ?>
		</td></label></tr>
		
		<?php if($callFlag != "" && $trainingNeed  != "")
		{ ?>
			<tr>
		<label> <td style="width:150px; font-size:12px; border-bottom:inset; border-bottom-width:1px"> 
		Call Flag:&nbsp;  </td> <td style="width:50px; font-size:12px; border-bottom:inset; border-bottom-width:1px "><?php echo $callFlag; ?></td></label></tr>
		<tr>
		<label> <td style="width:150px; font-size:12px; border-bottom:inset; border-bottom-width:1px"> 
		Training Needs:&nbsp;  </td> <td style="width:50px; font-size:12px; border-bottom:inset; border-bottom-width:1px "><?php echo $trainingNeed; ?></td></label></tr>
		
		<?php
		}
		?>
		
		<tr >
		<td  style="width:150px; font-size:12px; border-bottom:inset; border-bottom-width:1px "> <label>Total Questions:&nbsp;</td>
		<td style="width:50px; font-size:12px; border-bottom:inset; border-bottom-width:1px " ><?php echo $count; ?>
		</label></td></tr>
		<tr>
		<td  style="width:150px; font-size:12px; border-bottom:inset; border-bottom-width:1px "><label>
		Yes:&nbsp;</td> <td style="width:50px; font-size:12px; border-bottom:inset; border-bottom-width:1px "><?php echo $countYes; ?></label></td></tr>
		<tr>
		<td style="width:150px; font-size:12px; border-bottom:inset; border-bottom-width:1px "> <label>
		NO:&nbsp;</td><td style="width:50px; font-size:12px; border-bottom:inset; border-bottom-width:1px "><?php echo $countNo; ?></label></td></tr>
		<tr>
		<td style="width:150px; font-size:12px; border-bottom:inset; border-bottom-width:1px "> <label>
		Not Important:&nbsp;</td> <td style="width:50px; font-size:12px; border-bottom:inset; border-bottom-width:1px "><?php echo $countNimp; ?></label></td></tr>
		<tr>
		<td style="width:150px; font-size:12px; border-bottom:inset; border-bottom-width:1px "> <label>
		Not Applicable:&nbsp;</td> <td style="width:50px; font-size:12px; border-bottom:inset; border-bottom-width:1px "><?php echo $countNa; ?></label></td></tr>
		
		<tr>
		<td style="width:150px; font-size:12px; border-bottom:inset; border-bottom-width:1px "> <label>
		<b>Final Score:&nbsp; </b> </td> <td style="width:50px; font-size:12px; border-bottom:inset; border-bottom-width:1px "><b><?php echo round($final_score,2); ?></b></label></td></tr>
		
		<?php  if($_REQUEST['evaluated'] != 'true'){ ?>
		<tr><td><br /></td></tr>
		<tr>
		<td style="width:150px; font-size:12px; "> <label>
		Flag Call:&nbsp;  </td>
		 <td style="width:150px; font-size:12px;  ">
			<select name="flag_call" id="flag_call" class="txtbox-short"  onchange="javascript:is_check(this.selectedIndex)">
			<option value="-1">Please Select</option>
			<option value="fame">Hall Of Fame</option>
			<option value="shame">Hall Of Shame</option>
			</select>
		</td>
		</tr>
		<tr>
		<td style="width:150px; font-size:12px; "> <label>
		Training Needs:&nbsp;  </td>
		 <td style="width:150px; font-size:12px;  ">
			<select name="training_need" id="training_need" class="txtbox-short" onchange="javascript:is_check(this.selectedIndex)">
			<option value="-1">Please Select</option>
			<option value="services">Value Services</option>
			<option value="products">Products</option>
			<option value="procedures">Procedures</option>
			</select>
		</td>
		</tr>
		<?php } ?>
		</tbody>
</table>            
</ol>
<div align="right">
<a class="button" href="javascript:document.xForm2.submit();"  name="btn_flag" id="btn_flag" style="display:none"  ><span>Save Flag</span></a>
						<input type="hidden" value="<?php echo $count; ?>" id="count" name="count" />
						<input type="hidden" value="<?php  echo $agent_id; ?>" id="agent_id" name="agent_id"/>
						<input type="hidden" value="<?php  echo $evaluate_agent_id; ?>" id="evaluate_agent_id" name="evaluate_agent_id"/>
						<input type="hidden" value="<?php echo $unique_id; ?>" id="unique_id" name="unique_id" />
						<input type="hidden" value="<?php echo $duration; ?>" id="duration" name="duration" />
						<input type="hidden" value="<?php echo $call_type; ?>" id="call_type" name="call_type" />
						<input type="hidden" value="<?php echo $calldate; ?>" id="calldate" name="calldate" />
						<input type="hidden" value="<?php echo "true"; ?>" id="evaluated" name="evaluated" />
						<input type="hidden" value="FLAG SAVE" id="flag_save" name="flag_save" />
						
<a class="button" href="" onclick="closeAndRefresh();"><span>Close</span></a>

</fieldset> 
</form>
 </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->

<script type="text/javascript">
function closeAndRefresh() {
if (window.opener &&!window.opener.closed) {
//window.opener.document.location='index.php';
window.close();
}
}
</script> 
<?php } else{
?>
      	<div class="box" style="height:500px">   
		
	<h4 class="white"><?php 
	$rs_agent_name = $admin->get_agent_name($evaluate_agent_id);
	
	echo "Agent Evaluation Form  <br> Agent Name - ".$rs_agent_name->fields["full_name"]."<br> Tracking ID : ".$unique_id."<br> 
	Call Duration: ".$duration." <br> Call Type: ".$call_type."  <br> Call Date: ".$calldate."   <br> Work Codes : ".$wcodes; 
	//$stringData .= "Agent Productivity Report\r\n";
	//$stringData .= "Agent Name - ".$rs_agent_name->fields["full_name"]." \r\nDate: ".$fdate."\r\n";
	?></h4>   
        <div style="border:solid" class="box-container" style="height:500px">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return evaluation_validate(this);">
		<!--<input type="hidden" id="admin_id" name="admin_id" value="<?php //echo $tools_admin->encryptId($_SESSION[$db_prefix.'_UserId']); ?>">-->
      			<!--<h3>Add / Update</h3>-->
      			<!--<p>Please complete the form below. Mandatory fields marked <em>*</em></p>-->
      		<fieldset>
      			<legend>Fieldset Title</legend>
      				<ol style="overflow:auto; height:500px">
					<?php
							
							$count =0;
			                while(!$get_questions->EOF){
							
							 ?>
						
						<li class="even" id="ev[]"><label style="width:auto" class="field-title"><?php echo $get_questions->fields["question"]; ?></label>
             
                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" <?php echo $ischeckedYes[$count] ?> name="RadioGroup<?php echo $count; ?>" value="<?php echo $var_yes; ?>" id="RadioGroup<?php echo $count; ?>" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" <?php echo $ischeckedNo[$count] ?> name="RadioGroup<?php echo $count; ?>" value="<?php echo $var_no; ?>" id="RadioGroup<?php echo $count; ?>" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" <?php echo $ischeckedNimp[$count] ?> name="RadioGroup<?php echo $count; ?>" value="<?php echo $var_nimp; ?>" id="RadioGroup<?php echo $count; ?>" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" <?php echo $ischeckedNa[$count] ?> name="RadioGroup<?php echo $count; ?>" value="<?php echo $var_na; ?>" id="RadioGroup<?php echo $count; ?>" />
                                  N/A</label></td>
								  <td>
								<span id="RadioGroup_error<?php echo $count; ?>" class="form-error-inline" style="<?php echo($RadioGroup_error[$count]); ?>"></span>
								</td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment<?php echo $count; ?>" id= "_comment<?php echo $count; ?>" cols="" rows="2"  style="background-color:#FFFFFF; border:none"><?php echo $comment[$count]; ?></textarea>
                                </td>
								<td>
								<span id="_comment_error<?php echo $count; ?>" class="form-error-inline" style="<?php echo($_comment_error[$count]); ?>"></span>
								</td>
                              </tr>
                            </tbody>
                          </table>                       
                        </li>
						 <?php
						 		$count++;
		                        $get_questions->MoveNext();
                			}
                		?>
						
						
<!--                        <li><label style="width:auto" class="field-title">Was client verification taken?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li class="even"><label style="width:auto" class="field-title">Was client's concern / query properly understood?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li><label style="width:auto" class="field-title">Was client's concern / query clearly understood?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li class="even"><label style="width:auto" class="field-title">Was relevant information passed on to client?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li><label style="width:auto" class="field-title">Was the information provided in a quality way?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li class="even"><label style="width:auto" class="field-title">Was the information provided correct?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li><label style="width:auto" class="field-title">Was the information provided complete?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li class="even"><label style="width:auto" class="field-title">Were proper alternatives given?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li><label style="width:auto" class="field-title">Were information clearly communicated(i.e. no jargons used)?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li class="even"><label style="width:auto" class="field-title">Was the attitude helpful and energetic? </label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li><label style="width:auto" class="field-title">Was the client informed about value added services?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li class="even"><label style="width:auto" class="field-title">Was the client pitch to meet with advisor convincing?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li><label style="width:auto" class="field-title">Was the hold time during the call justified?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>
                        <li class="even"><label style="width:auto" class="field-title">In the case of Compliant/Service Request was reference number given?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li><label style="width:auto" class="field-title">Was standard closing greeting given to client?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>	
                        <li class="even"><label style="width:auto" class="field-title">Was proper work code selected for the call?</label>


                         <table style="width:250px; font-size:12px; margin-top:10px">
                            <tbody>
                              <tr>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="yes" id="RadioGroup2_0" />
                                  Yes</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="no" id="RadioGroup2_1" />
                                  No</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="nimp" id="RadioGroup2_2" />
                                  N.Imp</label></td>
                                <td><label>
                                  <input type="radio" name="RadioGroup2" value="na" id="RadioGroup2_3" />
                                  N/A</label></td>
                              </tr>
                            </tbody>
                          </table>
                          <table style="width:250px; font-size:12px;">
                            <tbody>
                              <tr>
                                <td style="padding-top:10px">
                                <label><b>Comments (Mandatory in case of 'N.imp'):</b></label><textarea name="_comment2" cols="" rows="2"></textarea>
                                </td>
                              </tr>
                            </tbody>
                          </table> 
       					</li>-->		
      				</ol>
      			</fieldset> 
      			<p class="align-right">
						<a class="button" href="javascript:document.xForm.submit();"  ><span>Submit</span></a>
						<input type="hidden" value="SUBMIT EVAL FORM >>" id="eval_form" name="eval_form"/>
						<input type="hidden" value="<?php echo $count; ?>" id="count" name="count" />
						<input type="hidden" value="<?php  echo $agent_id; ?>" id="agent_id" name="agent_id"/>
						<input type="hidden" value="<?php  echo $evaluate_agent_id; ?>" id="evaluate_agent_id" name="evaluate_agent_id"/>
						<input type="hidden" value="<?php echo $unique_id; ?>" id="unique_id" name="unique_id" />
						<input type="hidden" value="<?php echo $duration; ?>" id="duration" name="duration" />
						<input type="hidden" value="<?php echo $call_type; ?>" id="call_type" name="call_type" />
						<input type="hidden" value="<?php echo $calldate; ?>" id="calldate" name="calldate" />
						
						

 				</p>
      			<span class="clearFix">&nbsp;</span>
      		</form>
        </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->
<?php } ?>
<?php include($site_root."includes/ifooter.php"); ?> 
