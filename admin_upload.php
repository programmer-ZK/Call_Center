<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "admin_upload";
	$page_title = "Admin Upload";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Admin Upload";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
?>
<?php include($site_root."includes/header.php"); ?>
<?php 
$group_id       	= $tools_admin->decryptId($_REQUEST['group_id']);

$file_upload_error 	= "display:none;";

if(isset($_REQUEST['update']) || isset($_REQUEST["edit"]))
{

 	$flag = true;
	if(isset($_REQUEST['file_upload'])){

			$file_upload_error = "display:inline;";
			$flag = false;
	}
 	if($flag == true)
	{
		if(isset($_REQUEST["update"]) && !empty($_REQUEST["update"])){
			$folder = ($site_root."upload/");  
			if (file_exists($folder)) {  
				//echo "The directory $dirname exists";  
			} else {  
				mkdir("$folder", 777);  
				//echo "The directory $dirname was successfully created.";  
			}
			
			$ext = strtolower(substr(strrchr($_FILES["file_upload"]["name"], "."), 1));
			$file_name = date("YmdHis").'.'.$ext;
			
			//$file_name = $_FILES["keyword_file"]["name"];
			
			if($_FILES["file_upload"]["size"] > 0 ){
				move_uploaded_file($_FILES["file_upload"]["tmp_name"],"$folder" . "$file_name");
				$cmd = "mv -f ".$folder.$file_name." /var/lib/asterisk/sounds/usr_sounds/call_center/music_on_hold/spec.wav";
				shell_exec($cmd);
				//echo $cmd;exit;
				
			}
			else{
				$_SESSION[$db_prefix.'_RM'] = "import file is rejected or invalid. ";
				header ("Location: index.php");
				exit;
			}
			$_SESSION[$db_prefix.'_GM'] = "promotion file uplaoded successfully.";
			header ("Location: index.php");
			exit();
		}	
	}
}
	/*if(isset($group_id) && !empty($group_id))
	{
		$rsAdmin=$admin->get_admin_group_by_id($group_id);
		if($rsAdmin->EOF)
		{
			$_SESSION[$db_prefix.'_RM'] = "Admin group updation rejected or not found.";
			header ("Location: admin_groups_list.php");
			exit();
		}
		$group_name = $rsAdmin->fields['group_name'];
	}*/
?>
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">File Upload</div>
 <div class="box">
        <h4 class="white"><?php echo $page_title;?></h4>
        <div class="box-container">
                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms" name="xForm"  enctype="multipart/form-data">
        			<input type="hidden" name="file_id" value="<?php //echo $tools_admin->encryptId($file_id); ?>" />    
	            	<h3>Upload File</h3>
					<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
						<fieldset>
								<legend>Fieldset Title</legend>
								<ol>
										<li class="even"><label class="field-title">Upload File <em>*</em>:</label> <label><input name="file_upload" id="file_upload" class="txtbox-short" value="<?php //echo $group_name; ?>" type="file" ><span class="form-error-inline" id="file_upload_error" style="<?php echo $file_upload_error; ?>">Please Select File to Upload</span></label><span class="clearFix">&nbsp;</span></li>
								</ol>
						</fieldset>
						<p class="align-right">
							  Max Upload size 10MB
							<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return group_validate('xForm');"><span>Update</span></a>
							<input type="hidden" value="update" id="update" name="update" />
						</p>
						<span class="clearFix">&nbsp;</span>
                </form>
        </div>
        </div>
<?php include($site_root."includes/footer.php"); ?>
