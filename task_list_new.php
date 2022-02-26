<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "task_list_new.php";
	$page_title = "Add/Update Task Settings";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Task Settings";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/task_list.php");
	$task_list = new task_list();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function list_validate(){
/*	alert('Hi');
	return false;
*/
	//var id 		= this.document.getElementById('id');
	var title 			= this.document.getElementById('title');
	var description 	= this.document.getElementById('description');
	var deadline 		= this.document.getElementById('deadline');

	var flag 			= true;
	var err_msg 		= '';
	
	if(title.value == ''){
		err_msg+= 'Missing Title\n';
		this.document.getElementById('title_error').style.display="";
	}
	if(description.value == ''){
		err_msg+= 'Missing Description\n';
		this.document.getElementById('description_error').style.display="";
	}

	
	if(deadline.value == ''){
		err_msg+= 'Missing Deadline\n';
		this.document.getElementById('deadline_error').style.display="";
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
			title			: "required",
			description		: "required",
			deadline		: "required",
 
		},
		messages: {
			title			: "Please Enter Title",
			description		: "Please Enter Description",
			deadline		: "Please Enter Deadline",
   
		}
	});
});
</script>
<?php
	$id 			= $tools_admin->decryptId($_REQUEST['id']);
	$title 				= $_REQUEST['title'];
	$description 		= $_REQUEST['description'];
	$deadline 			= $_REQUEST['deadline'];
	$assign_to 			= $_REQUEST['assign_to'];



$title_error 			= "display:none;";
$description_error 		= "display:none;";
$deadline_error 		= "display:none;";



if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{
//echo "yahya"; exit;
        $flag = true;
         if($_REQUEST['title'] == '')
		 {
                $title_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
		if($_REQUEST['description'] == '')
		{
        	        $description_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
    	}
		if($_REQUEST['deadline'] == '')
		{
        	        $deadline_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
    	}

		if($flag == true)
        {
			if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))
			{	
				$rsAdmUser = $task_list->set_tasks($title, $description, $deadline, $assign_to);
				//if($rsAdmUser->EOF)	
				//{
					//$admin->insert_admin_user($title, $url, '1');
					$_SESSION[$db_prefix.'_GM'] = "Task list for Title: [".$title."] create successfully.";
					header ("Location: task_list_new.php");
					exit();
				//}
				//else
				//{
				//	$_SESSION[$db_prefix.'_RM'] = "Quick link for Title: [".$title."] already exists.";
				//}	
			}	
	
			if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"]))
			{
		
					$task_list->update_task($id, $title, $description, $deadline, '1');
					$_SESSION[$db_prefix.'_GM'] = "Task List updated successfully.";
					header ("Location: task_list_new.php");
					exit();
			}
			
		}
		
}
		if(isset($id) && !empty($id))
		{
			$rsAdmin  		= 	$task_list->get_task_by_id($id);
			if($rsAdmin->EOF){
				$_SESSION[$db_prefix.'_RM'] = "Admin panel user updation rejected or not found.";
				header ("Location: admin.php");
				exit();
			}
			$title 				= 	$rsAdmin->fields['title'];
			$description 		= 	$rsAdmin->fields['description'];
			$deadline 			= 	$rsAdmin->fields['deadline'];


		}		

?>

      	<div class="box">      
      		<h4 class="white">Task Settings</h4>
        <div class="box-container">
      		<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return list_validate(this);">
		<input type="hidden" id="id" name="id" value="<?php echo $tools_admin->encryptId($id); ?>">
      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
              <legend>Fieldset Title</legend>
              <ol>
                      <li class="even">
                  <label class="field-title">Title <em>*</em>:</label>
                  <label>
                        <input name="title" id="title" class="txtbox-short" value="<?php echo $title; ?>">
                        <span id="title_error" class="form-error-inline" title = "Please Insert Title" style="<?php echo($title_error); ?>"></span></label>
                  <span class="clearFix">&nbsp;</span></li>
                      <li >
                  <label class="field-title">Description <em>*</em>:</label>
                  <label>
                        <input name="description" id="description" class="txtbox-short" value="<?php echo $description; ?>">
                        <span id="description_error" class="form-error-inline" title = "Please Insert Description" style="<?php echo($description_error); ?>"></span></label>
                  <span class="clearFix">&nbsp;</span></li>
                  <li class="even">
                  <label class="field-title">Deadline <em>*</em>:</label>
                  <label>
				  		
				        <input name="deadline" id="deadline" class="txtbox-short" value="<?php echo $deadline; ?>" autocomplete = "off">
						<img src="images/cal.gif" onclick="javascript:NewCssCal ('deadline','yyyyMMdd','dropdown',true,'24',true)" style="cursor:pointer"/>

                        
                        <span id="deadline_error" class="form-error-inline" title = "Please Insert Deadline" style="<?php echo($deadline_error); ?>"></span></label>
                  <span  class="clearFix">&nbsp;</span>
				  </li>
				  <li>
				  <?php  if($ADMIN_ID1 == $_SESSION[$db_prefix.'_UserId'] || $ADMIN_ID2 == $_SESSION[$db_prefix.'_UserId'] 
	 || $ADMIN_ID3 == $_SESSION[$db_prefix.'_UserId'] || $ADMIN_ID4 == $_SESSION[$db_prefix.'_UserId']
	 || $ADMIN_ID5 == $_SESSION[$db_prefix.'_UserId']) {  ?>
				  		<label class="field-title">Assig To <em>*</em>:</label> <label>
						 <?php  echo $tools_admin->getcombo("admin","assign_to","admin_id","full_name","",false,"form-select","","","admin_id <>".$_SESSION[$db_prefix.'_UserId']); ?>
<!--						 <span id="group_id_error" class="form-error-inline" style="<?php //echo($admin_groups_error); ?>">Please Select Agent</span></label><span class="clearFix">&nbsp;</span>-->
				  <?php    }else { ?>
				  <?php  } ?>
				  </li>
                      
                    </ol>
              </fieldset>
      				<p class="align-right">
					<?php   if(isset($id) && !empty($id)){?>
						<a class="button" href="javascript:document.xForm.submit();"  ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return list_validate('xForm');"><span>Add</span></a>
						<input type="hidden" value="CREATE NEW ADMIN >>" id="add" name="add" />
               				<?php    }?>					
					<!--<input type="image" src="images/bt-send-form.gif" />-->
				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?> 
