<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "admin_groups_new.php";
	$page_title = "Add/Update Admin Settings";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "New Admin Group";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
function group_validate(){
/*      alert('Hi');
        return false;
*/
        var group_name    = this.document.getElementById('group_name');
        var flag = true;
        var err_msg = '';

        if(group_name.value == ''){
                err_msg+= 'Enter Group Name\n';
                this.document.getElementById('group_name_error').style.display="";
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
$group_id       = $tools_admin->decryptId($_REQUEST['group_id']);
$group_name     = $_REQUEST['group_name'];
$txtcaller_id_error = "display:none;";
if(isset($_REQUEST['add']) || isset($_REQUEST["edit"]))
{
 	$flag = true;
         if($_REQUEST['group_name'] == ''){
                $txtcaller_id_error = "display:inline;";//$tools->isEmpty('Caller ID');
                $flag = false;
         }
 	if($flag == true)
	{
	
		if(isset($_REQUEST["add"]) && !empty($_REQUEST["add"])){
				$admin->insert_admin_groups($group_name, '1');
				$_SESSION[$db_prefix.'_GM'] = "[".$group_name."] group created successfully.";
				header ("Location: admin_groups_list.php");
				exit();
			}

		if(isset($_REQUEST["edit"]) && !empty($_REQUEST["edit"])){
				$admin->update_admin_groups($group_id,$group_name, '1');
				$_SESSION[$db_prefix.'_GM'] = "[".$group_name."] group updated successfully.";
				header ("Location: admin_groups_list.php");
				exit();
		}	
	}
}
	//if(isset($_REQUEST["Update"]) && !empty($_REQUEST["Update"]))	{
	if(isset($group_id) && !empty($group_id))
	{
		$rsAdmin=$admin->get_admin_group_by_id($group_id);
		if($rsAdmin->EOF)
		{
			$_SESSION[$db_prefix.'_RM'] = "Admin group updation rejected or not found.";
			header ("Location: admin_groups_list.php");
			exit();
		}
		$group_name = $rsAdmin->fields['group_name'];
	}	

	

?>

 <div class="box">
                <h4 class="white">Admin Group Settings</h4>
        <div class="box-container">
                <form action="<? echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms" name="xForm">
        	<input type="hidden" name="group_id" value="<?php echo $tools_admin->encryptId($group_id); ?>">    
	            <h3>Add / Update</h3>
                        <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
                                <fieldset>
                                        <legend>Fieldset Title</legend>
                                        <ol>
                                                <li class="even"><label class="field-title">Group Name <em>*</em>:</label> <label><input name="group_name" id="group_name" class="txtbox-short" value="<?php echo $group_name; ?>"><span class="form-error-inline" id="group_name_error"  style="<?php echo $txtcaller_id_error; ?>">Please Insert Group Name.</span></label><span class="clearFix">&nbsp;</span></li>
                                        </ol><!-- end of form elements -->
                                </fieldset>
                                <p class="align-right">
                                        <?php   if(isset($group_id) && !empty($group_id)){?>
                                                <a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return group_validate('xForm');" ><span>Update</span></a>
                                                <input type="hidden" value="UPDATE ADMIN GROUP >>" id="edit" name="edit"/>
                                        <?php    }
                                        else{
                                        ?>
                                                <a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return group_validate('xForm');"><span>Add</span></a>
                                                <input type="hidden" value="CREATE NEW ADMIN GROUP >>" id="add" name="add" />
                                        <?php    }?>
                                        <!--<input type="image" src="images/bt-send-form.gif" />-->
                                </p>
                                <span class="clearFix">&nbsp;</span>
                </form>
        </div><!-- end of div.box-container -->
        </div><!-- end of div.box -->


<!--	<form  method="post" action="<? //echo $_SERVER['PHP_SELF'] ?>">
	<input type="hidden" name="group_id" value="<?php //echo $tools_admin->encryptId($group_id); ?>">
        <table border="0" width="60%" cellpadding="0" cellspacing="0" class="grid_detail">
            <tr>
                <td class="title" colspan="2"><b>Add / Update New Admin</b></td>
            </tr>
            <tr>
                <td class="title">Group Name:</td>
                <td class="feild">
                    <input type="text" name="group_name" id="group_name" value="<?php// echo $group_name; ?>" >
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center" valign="middle" >
                <?php// if(isset($_REQUEST['Task']) && ($_REQUEST['Task']=="Update" || $_REQUEST['Task']=="UpdateAdmin")){?>
                <?php//   if(isset($group_id) && !empty($group_id)){?>
		    <input type="submit" id="edit" name="edit" value="UPDATE ADMIN GROUP >>" class="buttonstyle" />
                <?php//    }
                //else{
                ?>
                    <input type="submit" value="CREATE NEW ADMIN GROUP >>" id="add" name="add" class="buttonstyle" />
                    <?php// } ?>
                </td>
            </tr>
        </table>

	</form>
-->
<?php include($site_root."includes/footer.php"); ?>
