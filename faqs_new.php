<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "faqs_new.php";
	$page_title = "Add/Update FAQs Templates Settings";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Add/Update FAQs Templates Settings";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	

	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/templates_faqs.php");
	$templates_faqs = new templates_faqs();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function msg_validate(){
//      alert('Hi');
//        return false;
	//var template = this.document.getElementById('template');
    //    if(template.value == 'email')
	//{
	//	var description    = this.document.getElementById('wysiwyg');
	//}
	//else
	//{
		var description    = this.document.getElementById('description');
	//}
	var category    = this.document.getElementById('category');
        var query    = this.document.getElementById('query');
//	var body    = this.document.getElementById('body');
	var flag = true;
        var err_msg = '';

        if(category.value == ''){
                err_msg+= 'Enter Title\n';
                this.document.getElementById('category_error').style.display="";
        }
	 if(query.value == ''){
                err_msg+= 'Enter Subject\n';
                this.document.getElementById('query_error').style.display="";
        }
	 if(description.value == ''){
                err_msg+= 'Enter Body\n';
                this.document.getElementById('description_error').style.display="";
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

	$template_id 				= $tools_admin->decryptId($_REQUEST['template_id']);
	$template 					= $_REQUEST['template'];

	$category	 				= $_REQUEST['category'];
	$query 						= $_REQUEST['query'];

	$description	 					= $_REQUEST['description'];


	$category_error 			= "display:none;";
	$query_error 				= "display:none;";
	$description_error	 				= "display:none;";

if(isset($_REQUEST['add']) || isset($_REQUEST['edit'])){
	
    $flag = true;
	 if($category == ''){
			$category_error = "display:inline;";//$tools->isEmpty('Caller ID');
			$flag = false;
	 }
	if($query == ''){
        	        $query_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }
	if($description == ''){
        	        $description_error = "display:inline;";//$tools->isEmpty('Caller ID');
	                $flag = false;
        	 }

        if($flag == true)
        {

		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"]))
		{
				$templates_faqs->insert_template($category, $query, $description, $template_id, '1', $template);
				$_SESSION[$db_prefix.'_GM'] = "[".$category."] FAQ Template  create successfully.";
				header ("Location: faqs_list.php");
				exit();
		}	
	
		if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"]))
		{	

				$templates_faqs->update_template($template_id, $category, $query, $description,  '1',$template);
				$_SESSION[$db_prefix.'_GM'] = "[".$category."] for ".$template." updated successfully.";
				header ("Location: faqs_list.php");
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
			
			$rsAdmin	=	$templates_faqs->get_template_by_id($template_id, $template);
			if($rsAdmin->EOF){
				$_SESSION[$db_prefix.'_RM'] = "Admin panel user updation rejected or not found.";
				header ("Location: admin.php");
				exit();
			}
			$category	 		= 	$rsAdmin->fields['category'];
			$query 				= 	$rsAdmin->fields['question'];
			$description 		= 	$rsAdmin->fields['body'];
		}		

?>

      	<div class="box">      
      		<h4 class="white">FAQs Templates Settings</h4>
        <div class="box-container">
      		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
		<input type="hidden" id="template_id" name="template_id" value="<?php echo $tools_admin->encryptId($template_id); ?>"/>
		<!--<input type="hidden" value="<?php //echo $template; ?>" id="template" name="template" />-->

      			<h3>Add / Update</h3>
      			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
      				<fieldset>
      					<legend>Fieldset Title</legend>
      					<ol>
						<li class="even"><label class="field-title">Category <em>*</em>:</label> <label>
						<!--<input name="category" id="category" class="txtbox-short" >-->
						<select  name="category" id="category" class="txtbox-short" >
						<option value="FAQ 1" <?php echo ($category=="FAQ 1")?"selected":"" ?>>FAQ 1</option>
						<option value="FAQ 2" <?php echo ($category=="FAQ 2")?"selected":"" ?>>FAQ 2</option>
						<option value="FAQ 3" <?php echo ($category=="FAQ 3")?"selected":"" ?>>FAQ 3</option>
						<option value="FAQ 4" <?php echo ($category=="FAQ 4")?"selected":"" ?>>FAQ 4</option>
						</select>
						<span class="form-error-inline" id="category_error" title="Please Insert Category"  style="<?php echo($category_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
                                                <li ><label class="field-title">Query <em>*</em>:</label> <label><input name="query" id="query" class="txtbox-short" value="<?php echo $query; ?>"><span class="form-error-inline" id="query_error" title="Please Insert Query"  style="<?php echo($query_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
                                                <li class="even"><label class="field-title">Description  <em>*</em>:</label><label> <textarea id="<?php echo("description"); ?>" name ="description" rows="7" cols="25"><?php echo $description; ?></textarea><span class="form-error-inline" id="description_error" title="Please Insert Description"   style="<?php echo($description_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
                                                
      					</ol><!-- end of form elements -->
      				</fieldset>
      				<p class="align-right">
					<?php   if(isset($template_id) && !empty($template_id)){?>
						<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return msg_validate('xForm');" ><span>Update</span></a>
						<input type="hidden" value="UPDATE FAQ TEMPLATE >>" id="edit" name="edit"/>
                			<?php    }
                			else{
                			?>
                    				<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return msg_validate('xForm');"><span>Add</span></a>
						<input type="hidden" value="CREATE NEW FAQ TEMPLATE >>" id="add" name="add" />
               				<?php    }?>					

				</p>
      				<span class="clearFix">&nbsp;</span>
      		</form>
        </div>
      	</div>

<?php include($site_root."includes/footer.php"); ?> 
