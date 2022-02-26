<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "workcode_new.php";
	$page_title = "Add/Update Workcode";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "New WorkCode";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/work_codes.php");
	$work_codes = new work_codes();	
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function wc_validate(){
		return true;
        var workcode_title    = this.document.getElementById('workcode_title');
        var flag = true;
        var err_msg = '';

        if(workcode_title.value == ''){
                err_msg+= 'Enter Work Code Title\n';
                this.document.getElementById('workcode_title_error').style.display="";
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
<?php 
$agent_id 			= $_SESSION[$db_prefix.'_UserId'];
$parent_id       	= $tools_admin->decryptId($_REQUEST['parent_id']);
$workcode_id       	= $tools_admin->decryptId($_REQUEST['workcode_id']);
$parent_name     	= $_REQUEST['parent_name'];
//$workcode_title 	=  $_REQUEST['workcode_title'];
$workcode_title				= $_REQUEST['detail'];
$workcode_title_error = "display:none;";

if(isset($_REQUEST['add']) || isset($_REQUEST["update"]))
{
	$workcode_title 	=  $_REQUEST['workcode_title'];
 	$flag = true;
	 if($workcode_title == ''){
			$workcode_title_error = "display:inline;";//$tools->isEmpty('Caller ID');
			$flag = false;
	 }
 	if($flag == true)
	{
	
		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"])){
			$work_codes->insert_workcodes($workcode_title, $parent_id, $agent_id, '1');
			$_SESSION[$db_prefix.'_GM'] = "[".$workcode_title."] added successfully.";
			header ("Location: workcodes_list.php");
			exit();
		}
		else if(isset($_REQUEST["update"]) && !empty($_REQUEST["update"])){
			$work_codes->update_workcodes($workcode_title, $workcode_id, $agent_id);
			$_SESSION[$db_prefix.'_GM'] = "[".$workcode_title."] updated successfully.";
			header ("Location: workcodes_list.php");
			exit();
		}

		/*
		if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"])){
				$admin->update_admin_groups($group_id,$group_name, '1');
				$_SESSION[$db_prefix.'_GM'] = "[".$group_name."] group updated successfully.";
				header ("Location: admin_groups_list.php");
				exit();
		}
		*/
	}
}
?>

<div class="box">
	<h4 class="white"><?php echo $page_title;?></h4>
	<div class="box-container">
		<form action="<?php  echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms" name="xForm" onsubmit="javascript:return wc_validate('xForm');">
			<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $tools_admin->encryptId($parent_id); ?>"> 
			<input type="hidden" name="workcode_id" id="workcode_id" value="<?php echo $tools_admin->encryptId($workcode_id); ?>">   
			<h3>Add / Update</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>Fieldset Title</legend>
				<ol>
					<li class="even"><label class="field-title">WorkCode Title <em>*</em>:</label> <label><input name="workcode_title" id="workcode_title" class="txtbox-short" value="<?php echo $workcode_title; ?>" /><span class="form-error-inline" id="workcode_title_error" style=" <?php echo $workcode_title_error; ?>">Please Insert Workcode Title</span></label><span class="clearFix">&nbsp;</span></li>
				</ol>
			</fieldset>
			<p class="align-right">
				<?php if(!empty($parent_id)){?>
				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return wc_validate('xForm');"><span>Add</span></a>
				<input type="hidden" value="add" id="add" name="add" />
				<?php } ?>
				<?php if(!empty($workcode_id)){?>
				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return wc_validate('xForm');"><span>Update</span></a>
				<input type="hidden" value="update" id="update" name="update" />
				<?php } ?>
			</p>
			<span class="clearFix">&nbsp;</span>      
		</form>
	</div>
</div>

<?php include($site_root."includes/footer.php"); ?>
