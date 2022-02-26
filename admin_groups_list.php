<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "admin_groups_list";
	$page_title = "Admin Groups";
	$page_level = "1";
	$page_group_id = "1";
	$page_menu_title = "Admin Groups";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admin = new admin();

	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
?>
<?php include($site_root."includes/header.php"); ?>

<?php

	$field = empty($_REQUEST["field"])?"full_name":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];
	$rs = $admin->get_groups_details(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>

<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
<!-- -------------------- -->
<div id="mid-col" class="mid-col">
<div class="box">
                <h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">
                <table class="table-short">
                        <thead>
                                <tr >
                                <td colspan="12" class="paging"><?php echo($paging_block);?></td>
                                </tr>
                                <tr>
                                        <td class="col-head" ><a href="#">Col 1</a></td>
					<td class="col-head" ><a href="<?php echo($page_name);?>.php?field=group_name&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Group Name</a></td>
			                <td class="col-head" ><a href="<?php echo($page_name);?>.php?field=status&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Status</a></td>
			                <td class="col-head" ><a href="<?php echo($page_name);?>.php?field=full_name&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Staff Name</a></td>
			                <td class="col-head" ><a href="#">Edit&nbsp;</td></a>
			                <td class="col-head" ><a href="#">Delete&nbsp;</td></a>
			                <td class="col-head" ><a href="#">Change Privillages&nbsp;</td></a>
     
                                </tr>
                        </thead>

                        <tfoot>
                                <tr>
                                        <td class="col-chk"><input type="checkbox" /></td>
                                        <td colspan="5"><div class="align-right"><select class="form-select"><option value="option1">Bulk Options</option>
                                        <option value="option2">Delete All</option></select>
                                        <a href="#" class="button"><span>perform action</span></a> </div></td>
					<td colspan="5"><div class="align-right"><a href="admin_groups_new.php" name="admin_group" id="admin_group" class="button"><span>Add Group</span></a> </div></td>
                                </tr>

                        </tfoot>
                        <tbody>
                                 <?php
                                        while(!$rs->EOF){ ?>

                                <tr class="odd">
                                <td class="col-chk"><input type="checkbox" /></td>
                               
				  <td class="col-first"><?php echo $rs->fields["group_name"]; ?> </td>
	        	          <td class="col-first"><?php echo(empty($rs->fields["status"])?"Inactive":"Active"); ?></td>
                        	  <td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>
			         <td  class="row-nav">
		                <a href="admin_groups_new.php?group_id=<?php echo $tools_admin->encryptId($rs->fields["id"]);?>" title="Update Record" class="table-edit-link"></a>
            			</td>
		            <td >
		            <?php if(!empty($rs->fields["status"])){ ?>
	                <a href="admin_groups_delete.php?group_id=<?php echo $tools_admin->encryptId($rs->fields["id"]);?>" title="Delete Record" class="table-delete-link"></a>
                	        <?php } else {?> &nbsp;
                	<?php } ?>
            		</td>
            		<td  class="col-head2">
                	<a href="admin_groups_privileges_update.php?Task=Update&group_id=<?php echo $tools_admin->encryptId($rs->fields["id"]);?>" title="Change Privileges"><img alt="Change Privileges" src="images/hammer_screwdriver.png" border="0" />
                	</a>
            		</td>
				
					</tr>
				 <?php
                                        $rs->MoveNext();
                                        }
                                ?>

				  <tr >
			                <td colspan="13" class="paging"><?php echo($paging_block);?></td>
                                </tr>
                        </tbody>
                </table>
	


        </div><!-- end of div.box-container -->
        </div> <!-- end of div.box -->
</div><!-- end of div#mid-col -->
<!-- --------------------- -->

</form>
<?php include($site_root."includes/footer.php"); ?>
