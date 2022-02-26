		
		<?php include_once("includes/config.php"); ?>
		<?php
			$page_name = "campaign_new2.php";
			$page_title = "Add/Update Campaign ";
			$page_level = "2";
			$page_group_id = "1";
			$page_menu_title = "Add/Update Campaign ";
		?>
		<?php include_once($site_root."includes/check.auth.php"); ?>
		<?php 	
			include_once("classes/tools_admin.php");
			$tools_admin = new tools_admin();
			include_once("classes/templates.php");
			$templates = new templates();
			include_once("classes/campaign.php");
			$campaign = new campaign();
		?>
		<?php include($site_root."includes/header.php"); ?>
	
		<script type="text/javascript">
var i=0;
	function hidetb()
	{
	document.getElementById("a"+i).style.display="none";
	document.getElementById("btn"+i).style.display="none";
	i++;
	}

	function addInput(divName){
		var newdiv = document.createElement('div');
		i=document.getElementById("hide").value;
		var ni = document.getElementById('dynamicInput');
		var divIdName = 'my'+i+'Div'; 
		newdiv.setAttribute('id',divIdName); 
		newdiv.innerHTML =  '<p><li  class=even><label class=field-title>Campaign Questions:</label> <label><textarea style=resize:none; name=campaign_questions'+i+' id=campaign_questions'+i+'></textarea></label><p><label class=field-title>Answer Type:</label><label><select name=answer_type'+i+' id=answer_type'+i+'><option value=Please Select selected=selected>Please Select</option><option value=Descriptive>Descriptive</option><option value=Yes/No>Yes/No</option><option value=Likert_questions>Likert Questions</option><option value=Right_Scale_Questions>Right Scale Questions</option></select></label><span class=clearFix>&nbsp;</span></li></li><input type=button value=Delete onclick="javascript:remove('+divIdName+')">';
		ni.appendChild(newdiv); 
		i++;
 		document.getElementById("hide").value = i;
} 

	function remove(dId) { 
		var ni = document.getElementById('dynamicInput'); 
		ni.removeChild(dId); 
} 
		
 	function hidetb2()
	{
		document.getElementById("a"+i).style.display="none";
		i++;
	}
	
     
	function DateCheck()
	{
	  	var StartDate= document.getElementById('fdate').value;
	  	var EndDate= document.getElementById('tdate').value;
	  	var eDate = new Date(EndDate);
	  	var sDate = new Date(StartDate);
	  	if(StartDate!= '' && StartDate!= '' && sDate> eDate)
		{
		
		alert("Please ensure that the End Date is greater than or equal to the Start Date.");
		return false;
		}
	}
			
	function msg_validate(){

				var cname    	= this.document.getElementById('cname');
				var cnature    	= this.document.getElementById('cnature');
				var file   		= this.document.getElementById('file');
				//var start_date  = this.document.getElementById('fdate');
				//var end_date    = this.document.getElementById('tdate');
				var ischeme    	= this.document.getElementById('ischeme');
				var campaign_script =this.document.getElementById('campaign_script')
				var flag 		= true;
				var err_msg 	= '';
			
				if(cname.value == ''){
							err_msg+= 'Enter Campaign Name\n';
							this.document.getElementById('cname_error').style.display= "";   
					}
					else
					{
					this.document.getElementById('cname_error').style.display= "none";  
					
					}
				if(cnature.value == ''){
							err_msg+= 'Enter Campaign nature\n';
							this.document.getElementById('cnature_error').style.display="";
							
					}
					else
					{
					this.document.getElementById('cnature_error').style.display= "none";  	
					}

				 if(ischeme.value == ''){
							err_msg+= 'Enter ischeme\n';
							this.document.getElementById('ischeme_error').style.display="";
							
					}
					else
					{
					this.document.getElementById('ischeme_error').style.display= "none";  
					
					}
			
			
				if(campaign_script.value == ''){
							err_msg+= 'Enter ischeme\n';
							this.document.getElementById('campaign_script_error').style.display="";
							
					}
					else
					{
					this.document.getElementById('campaign_script_error').style.display= "none";  
					
					}
				//		if(document.xForm["options[]"].value == ''){
//						err_msg+= 'Enter Caller ID\n';
//						this.document.getElementById('agent_error').style.display="";
//						
//				}
//
//
//				else
//				{
//				this.document.getElementById('agent_error').style.display= "none";  
//				
//				}
				
				if(err_msg == '' && IsEmpty(err_msg)){
						
							return true;
					}
					else{
				
							return false;
					}
					
			}
			
			</script>
		
		<?php
		
					$campaign_id 				= $tools_admin->encryptId($_REQUEST['campaign_id']);
					$num 						= $_POST['hide'];
					$cname		 				= $_POST['cname'];
					$cnature 					= $_POST['cnature'];
					$file						= $_POST['file'];
					$start_datetime 			= $_POST['fdate'];
					$end_datetime 				= $_POST['tdate'];
					$ischeme 					= $_POST['ischeme'];
					$campaign_script			= $_POST['campaign_script'];
					$attempt					= $_POST['attempt'];
   					$source						= $_POST['source'];
					
					$cname_error 				= "display:none;";
					$cnature_error 				= "display:none;";
					$file_error	 				= "display:none;";
					$fdate_error 				= "display:none;";
					$tdate_error				= "display:none;";
					$ischeme_error	 			= "display:none;";
					$agent_error				= "display:none;";
					$campaign_script_error		= "display:none;";
		
					if(isset($_POST['edit'])){
					$flag = true;
					if($cname == ''){
								$cname_error = "display:inline;";
								$flag = false;
						}
					if($cnature == ''){
								$cnature_error = "display:inline;";
								$flag = false;
						}
						
					if($campaign_script == ''){
							  $campaign_script_error = "display:inline;";
							  $flag = false;
						}
						
					if($ischeme == ''){
								$ischeme_error = "display:inline;";
								$flag = false;
						 }
			
			
					if($flag == true)
					{
					
if(isset($_POST["edit"]) && !empty($_POST["edit"]))
					{ //echo'waleed';exit;
					
	  $folder = ($site_root."/upload");
        if (file_exists($folder)) {
        }
        else {
        }
        mkdir("$folder", 777);

        $ext = strtolower(substr(strrchr($_FILES["file"]["name"], "."), 1));
        $file_name = date("YmdHis").'.'.$ext;
        $fname = $_FILES["file"]["name"];
		
		
		       $agent=implode(",", $_POST['options']);
             // $campaign_id = $campaign->update_campaign($campaign_id,$cname,$cnature,$agent,$start_datetime,$end_datetime,$ischeme,$staff_id,$status='1',$campaign_script);
		
			$campaign->update_campaign($campaign_id,$cname,$cnature,$agent,$start_datetime,$end_datetime,$ischeme,$staff_id,$status='1',$campaign_script,$source,$attempt);

			 
   $i=0;
  // mysql_query("delete from cc_campaign_questions where campaign_id='$campaign_id'");
  $campaign->delete_questions($campaign_id);
                while($i<$num){ 
			
                    $questions		= str_replace(","," ",$_POST["campaign_questions$i"]);
                    $answer_type	= $_POST["answer_type$i"];
                    $campaign->create_campaign_questions($campaign_id,$questions,$answer_type);
                    $i++;
                }
        if($_FILES["file"]["size"] >= 0 ){//echo 'waleed';exit;
          if( move_uploaded_file($_FILES["file"]["tmp_name"],"$folder"."/".$_FILES["file"]["name"])){//echo 'waleed';exit;
			
                $fn = "$folder"."/".$_FILES["file"]["name"];
                $handle = fopen($fn, 'r');
				
		
				
				

        
             
                $row=0;
$selected = $_POST['radio'];

     if ($selected == "Replace"){
 $campaign->set_campaign_detail_replace_new1($campaign_id,$_SESSION[$db_prefix.'_UserId']);}
  

                while($csv_line = fgetcsv($handle,filesize)) {
                    $row++;
                    if ($row>1) {
                        $selected = $_POST['radio'];
                            $tmp = $csv_line;
                           // echo $selected;exit;
                            if ($selected == "Duplicate"){//echo $campaign_id;exit;
                                    $campaign->set_campaign_detail_duplicate($campaign_id,$tmp[0],$tmp[1], $tmp[2], $tmp[3], $tmp[4], $tmp[5], $tmp[6], $tmp[7], $tmp[8], $_SESSION[$db_prefix.'_UserId']);


                            }
                            else if ($selected == "Replace"){
                                  //  $campaign->set_campaign_detail_replace($campaign_id,$tmp[0],$tmp[1], $tmp[2], $tmp[3], $tmp[4], $tmp[5], $tmp[6], $tmp[7], $tmp[8], $_SESSION[$db_prefix.'_UserId']);
              

 $campaign->set_campaign_detail_replace_new($campaign_id,$tmp[0],$tmp[1], $tmp[2], $tmp[3], $tmp[4], $tmp[5], $tmp[6], $tmp[7], $tmp[8], $_SESSION[$db_prefix.'_UserId']);
                        
   }
                            else if ($selected == "Ignore"){
                                    $campaign->set_campaign_detail_ignore($campaign_id,$tmp[0],$tmp[1], $tmp[2], $tmp[3], $tmp[4], $tmp[5], $tmp[6], $tmp[7], $tmp[8], $_SESSION[$db_prefix.'_UserId']);
                            }
                    }
                }
            
		}}
		   $_SESSION[$db_prefix.'_BM'] = "".$cname." Campaign Updates Successfully.";
                header ("Location:campaign.php");
                exit();
		//}	
		}
		
		 
		}
		}
				if(isset($campaign_id) && !empty($campaign_id))
				{
				$rsAdmin	=	$campaign->get_campaign_by_id($campaign_id);
				if($rsAdmin->EOF){
				$_SESSION[$db_prefix.'_RM'] = "Admin panel user updation rejected or not found.";
				header ("Location: admin.php");
				exit();
				}			
				$cname		 				= $rsAdmin->fields['campaign_name'];
				$cnature 					= $rsAdmin->fields['campaign_nature'];
				$file						= $rsAdmin->fields['title'];
				$start_datetime 			= $rsAdmin->fields['start_datetime'];
				$end_datetime 				= $rsAdmin->fields['end_datetime'];
				$ischeme 					= $rsAdmin->fields['investment_scheme'];
			 	$campaign_script 			= $rsAdmin->fields['campaign_script'];
				$source			 			= $rsAdmin->fields['source'];
				$attempt 					= $rsAdmin->fields['attempts'];
				}

		?>
		
				<div class="box">      
				<h4 class="white">Campaign Settings</h4>
				<div class="box-container">
				<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" enctype="multipart/form-data">
				<input type="hidden" id="campaign_id" name="campaign_id" value="<?php echo $tools_admin->encryptId($campaign_id); ?>"/>
				
				<h3>Add / Update</h3>
				<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
				<fieldset>
				<legend>Fieldset Title</legend>
				<ol>
				  <li class="even"><label class="field-title">Campaign Name <em>*</em>:</label> <label><input name="cname" id="cname" class="txtbox-short" maxlength="30" value="<?php echo $cname; ?>" ><span class="form-error-inline" id="cname_error" title="Please Insert Campaign name"  style="<?php echo($cname_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
                    <li class="odd"><label class="field-title">Campaign Nature <em>*</em>:</label> <label><input name="cnature" id="cnature" maxlength="40" class="txtbox-short" value="<?php echo $cnature; ?>" ><span class="form-error-inline" id="cnature_error" title="Please Insert Campaign Nature"  style="<?php echo($cnature_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
                    <li class="even"><label class="field-title">Caller List <em>*</em>:</label>
                        <label>
                            <input type="file" name="file" id="file">
                            <span class="form-error-inline" id="file_error" title="Please Select CSV file"  style="<?php echo($file_error); ?>"></span>
                        </label>
                        <span class="clearFix">&nbsp;</span>
                    </li>
                    <li class="even"><label class="field-title"> &nbsp;</label>
                        <input type="radio" name="radio" id="cb1" value="Replace" />Replace
                        <input type="radio" name="radio" id="cb2" value="Ignore"/>Ignore
                        <input type="radio" name="radio" id="cb3" value="Duplicate"/>Duplicate
                    </li>
                    <li class="odd"><label class="field-title">Agents <em>*</em>:</label><label>
				
					
					<?php echo $tools_admin->getcombo("admin","options[]","admin_id","full_name","1",false,"","",""," 1=1 and group_id = '2' and designation = 'Agents' and status = '1'", "multiple='multiple'"); ?>
	<br/><?
					$Rs=$campaign->campaign_progress($_GET['campaign_id']);
					echo "Currently selected Agents are :";
					while (!$Rs->EOF){
					echo " <br/> ".$Rs->fields['full_name'];
					$Rs->MoveNext();
					}?>						
<br/>
					
					<span class="form-error-inline" id="agent_error" title="Please Select Agents"  style="<?php echo($agent_error); ?>"></span></label>
					
					<span class="clearFix">&nbsp;</span></li>
                    <li class="even" ><label class="field-title">Start Date:</label> <label><input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo $start_datetime; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown',true,'24',true)"><span class="form-error-inline" id="fdate_error" title="Please Insert Start Date"  style="<?php echo($fdate_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
                    <li class="odd" ><label class="field-title">End Date:</label> <label><input name="tdate" id="tdate"  class="txtbox-short-date"  value ="<?php echo $end_datetime; ?>" onblur="DateCheck();"  autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('tdate','yyyyMMdd', 'dropdown',true,'24',true)"><span class="form-error-inline" id="tdate_error" title="Please Insert End Date"  style="<?php echo($tdate_error); ?>" ></span></label><span class="clearFix">&nbsp;</span></li>
                    <li class="even" ><label class="field-title">Investment Scheme <em>*</em>:</label> <label><input name="ischeme" id="ischeme" maxlength="40" class="txtbox-short" value="<?php echo $ischeme; ?>" ><span class="form-error-inline" id="ischeme_error" title="Please Insert Investment Scheme"  style="<?php echo($ischeme_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					
							 <li class="odd" ><label class="field-title">Source :</label> <label><input name="source" id="source" maxlength="250" class="txtbox-short" value="<?php echo $source; ?>" >
					</label><span class="clearFix">&nbsp;</span></li>
					
					<li class="even" ><label class="field-title">Attempts :</label> <label><input name="attempt" id="attempt" maxlength="250" class="txtbox-short" value="<?php echo $attempt; ?>" >
					</label><span class="clearFix">&nbsp;</span></li>
					
					
					
                    <li class="odd" ><label class="field-title">Campaign Script <em>*</em>:</label> <label><textarea style="resize: none;" rows="10" cols="14" name="campaign_script" id="campaign_script"  value="<?php echo $campaign_script; ?>" ><?php  echo $campaign_script; ?></textarea><br/><span class="form-error-inline" id="campaign_script_error" title="Please Insert Campaign Script"  style="<?php echo($campaign_script_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
					
					
					
					
		<?php 		
		
		$result2=$campaign->questions($campaign_id);
		for($i=0;$i<$result2->RecordCount();$i++)
		//while (!$result2->EOF)
		{
		
		?>	
			
				<li  id="a<?=$i?>" class="even"><label class="field-title">Campaign Questions:</label> <label><textarea style="resize:none"; name="campaign_questions<?=$i ?>" id="campaign_questions<?=$i ?>"><?php echo  $result2->fields['questions']; ?></textarea></label><p><label class="field-title">Answer Type:</label><label><select name="answer_type<?=$i ?>" id="answer_type<?=$i ?>"><option value="Please Select" >Please Select</option><option value="Descriptive" <?  if ($result2->fields['answer_type']=="Descriptive"){?>selected="selected" <? } ?>>Descriptive</option><option value="Yes/No" <?  if ($result2->fields['answer_type']=="Yes/No"){?>selected="selected" <? } ?>>Yes/No</option><option value="Likert_questions" <?  if ($result2->fields['answer_type']=="Likert_questions"){?>selected="selected" <? } ?>>Likert Questions</option><option value="Right_Scale_Questions" <?  if ($result2->fields['answer_type']=="Right_Scale_Questions"){?>selected="selected" <? } ?>>Right Scale Questions</option></select></label><span class=clearFix>&nbsp;</span></li></li><input type="button" name="button" id="btn<?=$i ?>" value="Delete" onclick="hidetb()"/>  	
					
					<?php 
					$result2->MoveNext();
					} ?>
					
					
					
                    <div id="dynamicInput"><input type="hidden" name="hide" id="hide" value="<?php echo $i;?>" /></div>
                    <input type="button" value="Add Question" onClick="addInput('dynamicInput');">
					
					
					
					
              </ol>
            </fieldset>
            <p class="align-right">
               
				<?php   if(isset($campaign_id) && !empty($campaign_id)){
				?>
				<a class="button" href="campaign.php" ><span>Back</span></a>
				<a class="button" href="javascript:document.xForm.submit();" onClick="javascript:return msg_validate('xForm');" ><span>Save Changes</span></a>
				<input type="hidden" value="UPDATE CAMPAIGN >>" id="edit" name="edit"/>
				<?php } ?>
		
							
				</p>
				<span class="clearFix">&nbsp;</span>		
				</form>
				</div>
				</div>
				<?php include($site_root."includes/footer.php"); ?> 
