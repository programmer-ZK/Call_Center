<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "admin_page_privileges_update";
	$page_title = "Admin Page Privileges Update";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Admin Page Privileges Update";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php include("includes/header.php"); ?>
<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
?>
<script type="text/javascript" language="javascript1.2">
	function SetPrivilegesTask()
	{
		//alert("calling :)");
		document.xForm.submit();
	}

</script>
<?php
	$page_id 		= $tools_admin->decryptId($_REQUEST['page_id']);
	$page_group_id		= $_REQUEST['page_group_id'];
	$rsGroups 		= $admin->get_groups_details($group_id);
	$page_name		= $rsGroups->fields['page_name'];
	$page_id		= $_REQUEST['page_id'];
	$rights 		= $_REQUEST['rights'];
	
	if(isset($_REQUEST["update"]) && !empty($_REQUEST["update"])){
			$admin->delete_admin_privileges(0,$page_group_id,$page_id,0);
			$page_count = $_REQUEST['page_count'];
			$count = 0;
			while($count <> $page_count){
				$admin->insert_admin_privileges($page_id[$count],$page_group_id,$page_id,$rights[$count]);
				$count++;
			}
			$_SESSION[$db_prefix.'_GM'] = "[".$page_name."] admin page privileges updated successfully.";
			header ("Location: admin_page_privileges_update.php?page_id=".$tools_admin->encryptId($page_id));
			exit();
		}
?>
        <div class="box">
                <h4 class="white"><?php echo $page_title;?></h4>
        <div class="box-container">
                <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms" name="xForm">
		<input type="hidden" name="page_id" id="page_id" value="<?php echo $tools_admin->encryptId($page_id); ?>" />
                        <h3>Change / Update</h3>
                        <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
                                <fieldset>
                                        <legend>Fieldset Title</legend>
                                        <ol>
                                                <li class="even"><label class="field-title">Page  <em>*</em>:</label> <label><?php echo $tools_admin->getcombo("pages","page_group_id","page_id","page_name",$page_group_id,false,"","SetPrivilegesTask();"); //'GetPageListingByPageGroup' ?><span class="form-confirm-inline" style="display:none;">Confirm Message</span></label><span class="clearFix">&nbsp;</span></li>
		                        </ol><!-- end of form elements -->
                                </fieldset>
                                <p class="align-right">
                                	<a class="button" href="javascript:document.xForm.submit();" ><span>Update</span></a>
                                        <input type="hidden" value="UPDATE ADMIN >>" id="edit" name="edit"/>
                                </p>
                                <span class="clearFix">&nbsp;</span>
	
            <?php 	if(isset($page_group_id) && !empty($page_group_id)){
				$rs = $admin->get_page_groups_details($page_group_id);	 ?>
					
<div class="full-col-center" id="full-col-center" >
<div id="full-col" class="full-col">
<div class="box">
                <h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">
                <table class="table-long">
                        <thead>
                                <tr >
                    <input type="hidden" name="page_count" id="page_count" value="<?php echo $rs->RecordCount(); ?>" />
                    <tr >
                                <td colspan="12" class="paging"><?php echo($paging_block);?></td>
                                </tr>
                                <tr>
                                        <td class="col-head">
						<a href="<?php echo($page_name);?>.php?field=page_title&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Page Title </a>
					</td>
                                        <td class="col-head2">
						<a href="<?php echo($page_name);?>.php?field=page_name&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Page Name</a>
					</td>
                                        <td class="col-head2">
						Privillages
					</td>
                                </tr>
                        </thead>
			<tfoot>
      				<tr>
      					<td colspan="4">
      					<a class="button" href="#"><span>perform action</span></a></div></td>
      				</tr>

      			</tfoot>
                    <?php
                    	$count = 0 ;
                    	while(!$rs->EOF){ ?>
                        <tbody>
                                <tr>
					<input type="hidden" name="page_id[<?php echo $count; ?>]" id="page_id[<?php echo $count; ?>]" value="<?php echo $rs->fields["page_id"]; ?>" />
                            		<td class="col-first"><?php echo $rs->fields["page_title"]; ?> </td>
                            		<td class="col-first"><?php echo $rs->fields["page_name"]; ?> </td>
                            		<td width="150">
                            		<?php 
						$checked = $tools_admin->returnFieldVal("Allow", "wot_admin_privileges", "Page_ID=".$rs->fields["page_id"]." and Page_Group_ID=".$page_group_id." and Page_ID=".$page_id);
			 			if($checked=="1"){
							$allow="checked=\"checked\"";
							$deny="";
						}
						else{
							$deny="checked=\"checked\"";
							$allow="";
						}
					?>
                            			<input type="radio" name="rights[<?php echo $count; ?>]" id="rights[<?php echo $count; ?>]" value="1" <?php echo ($allow);?> />  Allow
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="radio" name="rights[<?php echo $count; ?>]" id="rights[<?php echo $count; ?>]" value="0" <?php echo ($deny);?>/>  Deny 
		 			</td>
                        	</tr>
                    <?php
			$count++;
                        $rs->MoveNext();
                    }
                    ?>
			</tbody>
                </table>
            <?php } ?>
	</form>            
<?php //include("includes/footer.php"); ?>
