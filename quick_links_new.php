<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "quick_links_new";
	$page_title = "Add/Update Quick Links";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update Quick Links";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/quick_links.php");
	$quick_links = new quick_links();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function admin_validate(){

	var title 		= this.document.getElementById('title');
	var url 		= this.document.getElementById('url');
	var flag = true;
	var err_msg = '';
	
	if(title.value == ''){
		err_msg+= 'Missing Title\n';
		this.document.getElementById('title_error').style.display="";
	}
	if(url.value == ''){
		err_msg+= 'Missing URL\n';
		this.document.getElementById('url_error').style.display="";
	}
	if(err_msg == '' && IsEmpty(err_msg)){
		return true;
	}
	else{

		return false;
	}
}
</script>

<?php
	$id 				= $tools_admin->decryptId($_REQUEST['id']);
	$title 					= $_REQUEST['title'];
	$url 					= $_REQUEST['url'];

	$title_error 			= "display:none;";
	$url_error 				= "display:none;";
	
if(isset($_REQUEST['add']) || isset($_REQUEST['edit']))
{
//echo "yahya"; exit;
        $flag = true;
         if($_REQUEST['title'] == '')
		 {
                $title_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
	if($_REQUEST['url'] == '')
	{
        	        $url_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
    }
	if($flag == true)
    {

		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))
		{
			$rsAdmUser = $quick_links->set_links($title, $url);
			if($rsAdmUser->EOF)	
			{
				//$admin->insert_admin_user($title, $url, '1');
				$_SESSION[$db_prefix.'_GM'] = "Quick link for Title: [".$title."] create successfully.";
				header ("Location: quick_links_list.php");
				exit();
			}
			else
			{
				$_SESSION[$db_prefix.'_RM'] = "Quick link for Title: [".$title."] already exists.";
			}	
		}	
	
		if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"]))
		{
		
			//$rsAdmUser = $quick_links->list_id_exists($id);
			//if($rsAdmUser->EOF)	
			//{
				
					$quick_links->update_link_list($id, $title, $url, '1');
					$_SESSION[$db_prefix.'_GM'] = "Link updated successfully.";
					header ("Location: quick_links_list.php");
					exit();
				
			//}
			//else
			//{		
			///	$_SESSION[$db_prefix.'_RM'] = "Link already exists.";
			//}	
		}
	}	
}
		if(isset($id) && !empty($id))
		{
			//$rsAdmin  		= 	$admin->get_admin_by_id($admin_id);
			$rsAdmin  		= 	$quick_links->get_links_by_id($id);
			if($rsAdmin->EOF)
			{
				$_SESSION[$db_prefix.'_RM'] = "Links updation rejected or not found.";
				header ("Location: admin.php");
				exit();
			}
			$title 		= 	$rsAdmin->fields['title'];
			$url 		= 	$rsAdmin->fields['url'];
		}		

?>

      	<div class="box">      
      		<h4 class="white"><?php echo $$page_menu_title;?></h4>
        <div class="box-container">
      		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="javascript:return admin_validate(this);">
		<input type="hidden" id="id" name="id" value="<?php echo $tools_admin->encryptId($id); ?>">
      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
							<li class="even"><label class="field-title">Title <em>*</em>:</label> <label><input name="title" id="title" class="txtbox-short" value="<?php echo $title; ?>"><span id="title_error" class="form-error-inline" title = "Please Insert Title" style="<?php echo($title_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
							
							<li ><label class="field-title">URL <em>*</em>:</label> <label><input name="url" id="url" class="txtbox-short" value="<?php echo $url; ?>"><span id="url_error" class="form-error-inline" title = "Please Insert URL" style="<?php echo($url_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
							
							<!-- <li class="even"><label class="field-title">Password <em>*</em>:</label> <label><input name="password" id="password" class="txtbox-short" value="<?php //echo NULL; ?>" autocomplete = "off"><span id="password_error" class="form-error-inline" style="<?php echo($password_error); ?>">Please Insert Password</span></label><span  class="clearFix">&nbsp;</span></li>
                                                
							<li ><label class="field-title">Re-Password <em>*</em>:</label> <label><input name="re_password" id="re_password" class="txtbox-short" value="<?php //echo NULL; ?>" autocomplete = "off"><span id="re_password_error" class="form-error-inline" style="<?php //echo($re_password_error); ?>">Re Enter Password</span></label><span class="clearFix">&nbsp;</span></li>

                            <li class="even"><label class="field-title">Designation <em>*</em>:</label> <label><input name="designation" id="designation" class="txtbox-short" value="<?php //echo $designation; ?>"><span  id="designation_error" class="form-error-inline" style="<?php //echo($designation_error); ?>">Enter your Designation </span></label><span class="clearFix">&nbsp;</span></li>
						
							<li><label class="field-title"> Department<em>*</em>:</label> <label><input name="department" id="department" class="txtbox-short" value="<?php // echo $department; ?>"><span id="department_error" class="form-error-inline" style="<?php echo($department_error); ?>">Enter Department Name </span></label><span class="clearFix">&nbsp;</span></li>
							
                            <li class="even"><label class="field-title">Group <em>*</em>:</label> <label> <?php //echo $tools_admin->getcombo("admin_groups","group_id","id","group_name",$group_id,false,"form-select","","Group",""); ?><span id="group_id_error" class="form-error-inline" style="<?php //echo($admin_groups_error); ?>">Please Select group</span></label><span class="clearFix">&nbsp;</span></li> -->
									
      					</ol>
      				</fieldset> 
      				<p class="align-right">
					<?php   if(isset($id) && !empty($id)){?>
						<a class="button" href="javascript:document.xForm.submit();"  onclick="javascript:return admin_validate('xForm');" ><span>Update</span></a>
						<input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Add</span></a>
						<input type="hidden" value="CREATE NEW ADMIN >>" id="add" name="add" />
               				<?php    }?>					
					<!--<input type="image" src="images/bt-send-form.gif" />-->
				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?> 
