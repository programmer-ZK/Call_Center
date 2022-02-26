<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "templetes_new.php";
	$page_title = "Add/Update Templates Settings";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Templates Settings";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	

	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/templates.php");
	$templates = new templates();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function msg_validate(){
//      alert('Hi');
//        return false;
	var template = this.document.getElementById('template');
        if(template.value == 'email')
	{
		var body    = this.document.getElementById('wysiwyg');
	}
	else
	{
		var body    = this.document.getElementById('body');
	}
	var title    = this.document.getElementById('title');
        var subject    = this.document.getElementById('subject');
//	var body    = this.document.getElementById('body');
	var flag = true;
        var err_msg = '';

        if(title.value == ''){
                err_msg+= 'Enter Title\n';
                this.document.getElementById('title_error').style.display="";
        }
	 if(subject.value == ''){
                err_msg+= 'Enter Subject\n';
                this.document.getElementById('subject_error').style.display="";
        }
	 if(body.value == ''){
                err_msg+= 'Enter Body\n';
                this.document.getElementById('body_error').style.display="";
        }




        if(err_msg == '' && IsEmpty(err_msg)){
                return true;
        }
        else{
            //    alert(err_msg);
                return false;
        }
}
</script>


<?php

	$template_id 			= $tools_admin->decryptId($_REQUEST['template_id']);
	$template 				= $_REQUEST['template'];

	$title	 				= $_REQUEST['title'];
	$subject 				= $_REQUEST['subject'];

	$body	 				= $_REQUEST['body'];


	$title_error 		= "display:none;";
	$subject_error 		= "display:none;";
	$body_error	 		= "display:none;";

if(isset($_REQUEST['add']) || isset($_REQUEST['edit'])){
	
    $flag = true;
	 if($title == ''){
			$title_error = "display:inline;";//$tools->isEmpty('Caller ID');
			$flag = false;
	 }
	if($subject == ''){
        	        $subject_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($body == ''){
        	        $body_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }

        if($flag == true)
        {

		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))
		{
				echo $body; //exit;
				$templates->insert_template($title, $subject, $body, $template_id, '1', $template);
				$_SESSION[$db_prefix.'_GM'] = "[".$title."] Template  create successfully.";
				header ("Location: templates.php?template=".$template);
				exit();
		}	
	
		if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"]))
		{	

				$templates->update_template($template_id, $title, $subject, $body,  '1',$template);
				$_SESSION[$db_prefix.'_GM'] = "[".$title."] for ".$template." updated successfully.";
				header ("Location: templates.php?template=".$template);
				exit();
			//			}
			//	else{
			//	echo  $full_name." ,".$password." ,".$email." ,".$designation." ,".$department." ,".$group_id.", ".$is_active.", ";
			//	echo "Condition 5"; exit;
			//		$_SESSION[$db_prefix.'_EM'] = "[".$title."] for admin panel already exists.";
			//			}	
		}
	}	
}
		if(isset($template_id) && !empty($template_id))
		{
			
			$rsAdmin	=	$templates->get_template_by_id($template_id, $template);
			if($rsAdmin->EOF){
				$_SESSION[$db_prefix.'_RM'] = "Admin panel user updation rejected or not found.";
				header ("Location: admin.php");
				exit();
			}
			$title	 		= 	$rsAdmin->fields['title'];
			$subject 		= 	$rsAdmin->fields['subject'];
			$body 			= 	$rsAdmin->fields['body'];
		}		

?>

      	<div class="box">      
      		<h4 class="white">Templates Settings</h4>
        <div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
		<input type="hidden" id="template_id" name="template_id" value="<?php echo $tools_admin->encryptId($template_id); ?>"/>
		<input type="hidden" value="<?php echo $template; ?>" id="template" name="template" />

      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
						<li class="even"><label class="field-title">Title <em>*</em>:</label> <label><input name="title" id="title" class="txtbox-short" value="<?php echo $title; ?>"><span class="form-error-inline" id="title_error" title="Please Insert Title"  style="<?php echo($title_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
                                                <li ><label class="field-title">Subject <em>*</em>:</label> <label><input name="subject" id="subject" class="txtbox-short" value="<?php echo $subject; ?>"><span class="form-error-inline" id="subject_error" title="Please Insert Subject"  style="<?php echo($subject_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
                                                <li class="even"><label class="field-title">Body  <em>*</em>:</label><label> 
												
												<?php // if($template=="email") { ?>
												<script type="text/javascript">
													/*$(function()
													{
													$('#wysiwyg').wysiwyg(
													{
													controls : {
													separator01 : { visible : true },
													separator03 : { visible : true },
													separator04 : { visible : true },
													separator00 : { visible : true },
													insertOrderedList : { visible : true },
													insertUnorderedList : { visible : true },
													undo: { visible : true },
													redo: { visible : true },
													justifyLeft: { visible : true },
													justifyCenter: { visible : true },
													justifyRight: { visible : true },
													justifyFull: { visible : true },
													subscript: { visible : true },
													superscript: { visible : true },
													underline: { visible : true }
													}
													} );
													});*/
												</script>
												<textarea id="<?php echo(($template=="email")?"wysiwyg":"body"); ?>" name ="body" rows="7" cols="25" ><?php echo $body; ?></textarea>
												<?php// } else{?>										
												<!--<textarea id="body" name ="body" rows="7" cols="25"><?php //echo $body; ?></textarea>-->
												<?php// } ?>
												<!--<textarea id="<?php //echo(($template=="email")?"wysiwyg":"body"); ?>" name ="body" rows="7" cols="25"><?php //echo $body; ?></textarea>-->
												<span class="form-error-inline" id="body_error" title="Please Insert Body"   style="<?php echo($body_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
                                                
      					</ol><!-- end of form elements -->
      				</fieldset>
      				<p class="align-right">
					<?php   if(isset($template_id) && !empty($template_id)){?>
						<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return msg_validate('xForm');" ><span>Update</span></a>
						<input type="hidden" value="UPDATE TEMPLATE >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return msg_validate('xForm');"><span>Add</span></a>
						<input type="hidden" value="CREATE NEW TEMPLATE >>" id="add" name="add" />
               				<?php    }?>					

				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div>
      	</div>

<?php include($site_root."includes/footer.php"); ?> 
