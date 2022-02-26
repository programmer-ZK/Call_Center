<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "campaign_answer.php";
	$page_title = "Campaign Answer";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Campaign Answer";
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

include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
	
	include_once("classes/cc_evaluation.php");
	$cc_evaluation = new cc_evaluation();
	
	include_once("classes/user_tools.php");		
        $user_tools = new user_tools();


	include_once("classes/campaign.php");
	$campaign= new campaign();
			
?>


<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function msg_validate(){
for (var i=0; i<100; i++) {
//var answer = document.getElementById("answer" + i).value;





   // var err_msg 	= '';
//alert('waleed');return false;
    if(document.getElementById("answer0").value == ''){
	alert('asdad');
        err_msg+= 'Enter Answer\n';
        this.document.getElementById('answer_error').style.display= "";
		return false;
    }
 //   else{
    //    this.document.getElementById('answer_error').style.display= "none";
   // }
 
   // if(err_msg == '' && IsEmpty(err_msg)){
          //  return true;
   // }
   // else{
          //return false;
   // }
}



    //var answer    	= this.document.getElementById('answer');

    
}

</script>

<?php $campaign_id 				= $tools_admin->encryptId($_REQUEST['campaign_id']);

		$num 						= $_POST['hide'];
//		for ($k=0;$k<=100;$k++)
//{	 $answer	= $_REQUEST['answer'.$k];
//}
//for ($k=0;$k<=100;$k++)
//{	$answer = $_POST['answer'.$k];}
    $answer_error            = "display:none;";	
if(isset($_POST['save']) && !empty($_POST["save"]))
{ $answer_error            = "display:none;";	//echo $num;exit;
for ($k=0;$k<$num;$k++)
	{$answer = $_POST['answer'.$k]; 
	//echo $answer.'kig';
	if($answer == ''){ $blankanswer=true;
	}
	}
				
					if($blankanswer){//echo 'waleed';exit;
								$answer_error = "display:inline;";
							$flag=false;
						}
						
				else
					{//echo $answer.'checking';//exit;
	
					
	 
       
                $i=0;
                while($i<$num){
                 //  $question	= $_POST["question$i"];
                 //  $answer	= $_POST["answer$i"];
		 $question	=  str_replace(","," ",$_POST["question$i"]);
		 $answer	=  str_replace(","," ",$_POST["answer$i"]);
		   
				  // echo $_POST["answer2"];exit;
                   $campaign-> campaign_answers($campaign_id,$unique_id,$question,$answer);
                 $i++;    }
             
        
		
		    	$_SESSION[$db_prefix.'_GM'] = "".$cname." Campaign Answer Save Successfully.";
                header ("Location:index.php");
                exit();
	
		}
				
}
		
		
		
				?>
				
				<div class="box">      
				<h4 class="white">Campaign Answers</h4>
				<div class="box-container">
				<form action="<? echo $_SERVER['PHP_SELF']."?campaign_id=".$campaign_id; ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm"  >
				<input type="hidden" id="campaign_id" name="campaign_id" value="<?php echo $tools_admin->encryptId($campaign_id); ?>"/>
				
				<h3>Add</h3>
				<!--<p>Please complete the form below. Mandatory fields marked <em>*</em></p>-->
				<fieldset>
				<legend>Fieldset Title</legend>
				<ol>
				
		<?php 		
			$count=0;
		$result2=$campaign->questions($campaign_id);
		$questio_no=1;
		for($i=0;$i<$result2->RecordCount();$i++)
		{
		
		?>	
				<li class="even"><label class="field-title">Question#<?php echo $questio_no;?></label> <label><textarea style="resize: none; border:none;" readonly="readonly"  name="question<?=$i ?>" id="question<?=$i ?>"><?php echo  $result2->fields['questions']; ?></textarea></label><span class="clearFix">&nbsp;</span></li><li class="odd"><label class="field-title">Answer:</label>
				
				
				<?php if ($result2->fields['answer_type']=='Descriptive'){?>
				
				<textarea  name="answer<?=$i ?>" id="answer<?=$i ?>" rows="2" cols="20" style="resize:none"> <?php echo $result2->fields['answer'];; ?></textarea>
				
				<span class="form-error-inline" id="answer_error" title="Please Insert Answer"  style="<?php echo($answer_error); ?>"></span></li>
				
				
				
				<? }
				else if ($result2->fields['answer_type']=='Likert_questions'){?>
				
<br/><input  id="answer<?=$i ?>"    type="radio" name="answer<?=$i ?>"  value="StronglyAgree">Strongly Agree<br/>
<input  id="answer<?=$i ?>"   type="radio" name="answer<?=$i ?>" checked="checked"  value="Agree">Agree<br/>
<input  id="answer<?=$i ?>"   type="radio" name="answer<?=$i ?>"  value="NeitherAgreeorDisagree"> Neither Agree or Disagree <br/>
<input  id="answer<?=$i ?>"   type="radio"name="answer<?=$i ?>"  value="Disagree">Disagree<br/>
<input  id="answer<?=$i ?>"   type="radio" name="answer<?=$i ?>"  value="StronglyDisagree">Strongly Disagree<br/><span class="form-error-inline" id="answer_error" title="Please Insert Answer"  style="<?php echo($answer_error); ?>"></span>


				
				<? } else if ($result2->fields['answer_type']=='Yes/No'){?>
				
 <input  id="answer<?=$i ?>" name="answer<?=$i ?>" type="radio"   value="Yes">Yes
<input  id="answer<?=$i ?>" name="answer<?=$i ?>" type="radio"  value="No">No<br/><span class="form-error-inline" id="answer_error" title="Please Insert Answer"  style="<?php echo($answer_error); ?>"></span>

					<? }	else if ($result2->fields['answer_type']=='Right_Scale_Questions'){?>
					
<br/><input  id="answer<?=$i ?>" name="answer<?=$i ?>" type="radio" name="Right_Scale_Questions" value="Excellent">Excellent Agree<br/>
<input  id="answer<?=$i ?>"  name="answer<?=$i ?>"type="radio" value="Good">Good<br/>
<input  id="answer<?=$i ?>" type="radio" name="answer<?=$i ?>"value="Fair "> Fair <br/>
<input  id="answer<?=$i ?>" type="radio" name="answer<?=$i ?>"  value="Poor">Poor<br/>
<input  id="answer<?=$i ?>" type="radio" name="answer<?=$i ?>" value="VeryPoor">Very Poor<br/><span class="form-error-inline" id="answer_error" title="Please Insert Answer"  style="<?php echo($answer_error); ?>"></span>			
					<? } ?>
					<?php 
					$result2->MoveNext();
				$questio_no++;	} ?>
					
					
					
               <input type="hidden" name="hide" id="hide" value="<?php echo $i;?>" />
					
              </ol>
            </fieldset>
            <p class="align-right">
               
				<?php   if(isset($campaign_id) && !empty($campaign_id)){
				?>
				<a class="button" href="index.php" ><span>Skip</span></a>
				<a class="button" href="javascript:document.xForm.submit();" ><span>Save</span></a>
				<input type="hidden" value="UPDATE CAMPAIGN >>" id="save" name="save"/>
				<?php } ?>
		
							
				</p>
				<span class="clearFix">&nbsp;</span>		
				</form>
				</div>
				</div>
				<?php include($site_root."includes/footer.php"); ?> 
