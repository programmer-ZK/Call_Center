<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "task_list";
	$page_title = "Task List";
	$page_level = "1";
	$page_group_id = "1";
	$page_menu_title = "Task List";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/task_list.php");
	$task_list = new task_list();

	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
?>
<?php 
	//include($site_admin_root."includes/custom_search_form.php");
//	include($site_admin_root."includes/search_form.php");
?>
<?php include($site_root."includes/header.php"); ?>
<?php

	$field = empty($_REQUEST["field"])?"title":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];
	$from = $_REQUEST['from'];
	if($from == "admin")
	{
		$rs = $task_list->get_tasks('admin');
	}
	elseif ($from == "todo")
	{
		$rs = $task_list->get_tasks('todo');
	}
	elseif($from == "complete")
	{
		$rs = $task_list->get_tasks('complete');
	}
?>

<form name="listings" id="listings" action="<?php echo($page_name);?>.php" method="post" >
<!-- -------------------- -->
<div class="full-col-center" id="full-col-center" >
<div id="full-col" class="full-col">
<div class="box">
                <h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">
                <table class="table-long">
                        <thead>
                                <tr >
                                <td colspan="12" class="paging"><?php echo($paging_block);?></td>
                                </tr>
                                <tr>
                                        <td class="col-head" ><a href="#">Col 1</a></td>
										<td class="col-head" ><a href="<?php echo($page_name);?>.php?field=staff_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Staff Name</a></td>
										<td class="col-head" ><a href="<?php echo($page_name);?>.php?field=title&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Title</a></td>
			              				<td class="col-head" ><a href="<?php echo($page_name);?>.php?field=description&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Description</a></td>
										<td class="col-head" ><a href="<?php echo($page_name);?>.php?field=deadline&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Deadline</a></td>
						                <td class="col-head" ><a href="<?php echo($page_name);?>.php?field=staff_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Assign By</a></td>
										<td class="col-head" ><a href="<?php echo($page_name);?>.php?field=status&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Status</a></td>
			                <td class="col-head" ><a href="#">Edit&nbsp;</td></a>
			                <td class="col-head" ><a href="#">Delete&nbsp;</td></a>
     
                                </tr>
                        </thead>

                        <tfoot>
                                <tr>
                                         <td class="col-chk"><input type="checkbox" /></td>
                                        <td colspan="4"><div class="align-right"><select class="form-select"><option value="option1">Bulk Options</option>
                                        <option value="option2">Delete All</option></select>
                                        <a href="#" class="button"><span>perform action</span></a> </div></td> 
					<td colspan="4"><div class="align-right"><a href="task_list_new.php" name="add_list" id="add_list" class="button"><span>Add List</span></a> </div></td>
                                </tr>

                        </tfoot>
                        <tbody>
                                 <?php
                                        while(!$rs->EOF){ ?>

                                <tr class="odd">
                                <td class="col-chk"><input type="checkbox" /></td>
                                <td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>	
								<td class="col-first"><?php echo $rs->fields["title"]; ?> </td>
								<td class="col-first"><?php echo $rs->fields["description"]; ?> </td>
								<td class="col-first"><?php echo $rs->fields["deadline"]; ?> </td>
								<td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>				 
			        	        <td class="col-first"><?php echo(empty($rs->fields["status"])?"Inactive":"Active"); ?></td>
			         <td  class="row-nav">
		                <a href="task_list_new.php?id=<?php echo $tools_admin->encryptId($rs->fields["id"]);?>" title="Update Link" class="table-edit-link"></a>
            			</td>
		            <td >
		            <?php if(!empty($rs->fields["status"])){ ?>
	                <a href="task_list_new.php?id=<?php echo $tools_admin->encryptId($rs->fields["id"]);?>" title="Delete Link" class="table-delete-link"></a>
                	        <?php } else {?> &nbsp;
                	<?php } ?>
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
</div>
<!-- --------------------- -->

</form>
<?php include($site_root."includes/footer.php"); ?>
