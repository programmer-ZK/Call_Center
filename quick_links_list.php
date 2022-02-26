<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "quick_links_list";
	$page_title = "Quick Links";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Quick Links";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/quick_links.php");
	$quick_links = new quick_links();

	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
?>
<?php include($site_root."includes/header.php"); ?>
<?php 
	//include($site_admin_root."includes/custom_search_form.php");
	//include($site_admin_root."includes/search_form.php");
?>

<?php
	



if(isset($_REQUEST['search_date']))
{
	$keywords			= $_REQUEST['keywords'];
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	
			if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"]))
			{	
				//$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
				
			}	
		
}else
{
	$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
	$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];
	$keywords 		= empty($_REQUEST["keywords"])?"":$_REQUEST["keywords"];
	$search_keyword = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];
	
}
	
?>

<?php
	
	$count_type= "link";	

	$field = empty($_REQUEST["field"])?"title":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];
	
	//$total_records_count = $pin_reports->get_records_count(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
	$total_records_count = $quick_links->get_links_counts($recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
	include_once("includes/paging.php");
	
	
	
	$rs = $quick_links->get_links($recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
?>

<form  action="<?php echo($page_name);?>.php" method="post"  name="xForm" id="xForm">
<div class="box">
<?php $form_type = "links"; 
 include($site_admin_root."includes/search_form.php"); ?>
<?php  include($site_admin_root."includes/date_search_bar.php"); ?>
</div>
<br />

<!-- -------------------- -->
<!--<div class="full-col-center" id="full-col-center" >-->
<div id="mid-col" class="mid-col">
<div class="box">
                <h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container" style="overflow:auto; height:600px;">
                <table class="table-short">
                        <thead>
                                <tr >
                                <td colspan="12" class="paging"><?php echo($paging_block);?></td>
                                </tr>
                                <tr>
                                        <td class="col-head" ><a href=""></a></td>
					<td class="col-head2" ><a href="<?php echo($page_name);?>.php?field=title&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Title</a></td>
			                <td class="col-head2" ><a href="<?php echo($page_name);?>.php?field=url&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">URL</a></td>
			                <!--<td class="col-head" ><a href="<?php //echo($page_name);?>.php?field=staff_id&order=<?php //echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Staff Name</a></td>
					 <td class="col-head" ><a href="<?php //echo($page_name);?>.php?field=status&order=<?php //echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Status</a></td>-->
			                <td class="col-head2" ><a href="">Edit&nbsp;</td></a>
			                <td class="col-head2" ><a href="">Delete&nbsp;</td></a>
     
                                </tr>
                        </thead>

                        <tfoot>
                                <tr>
                                         <!--<td class="col-chk"><input type="checkbox" /></td>-->
                                       <!-- <td colspan="4"><div class="align-right">
										<select class="form-select"><option value="option1">Bulk Options</option>
                                        <option value="option2">Delete All</option></select>
                                        <a href="#" class="button"><span>perform action</span></a> </div></td>--> 
					<td colspan="5"><div class="align-right"><br /><a href="quick_links_new.php" name="add_list" id="add_list" class="button"><span>Add List</span></a> </div></td>
                                </tr>

                        </tfoot>
                        <tbody>
                                 <?php
                                        while(!$rs->EOF){ ?>

                                <tr class="odd">
                                <td class="col-chk"><input type="checkbox" /></td>
                               
				 <td class="col-first"><?php echo $rs->fields["title"]; ?> </td>
				 <td class="col-first"><?php echo $rs->fields["url"]; ?> </td>
				<!--<td class="col-first"><?php //echo $rs->fields["full_name"]; ?> </td>				 
	        	         <td class="col-first"><?php //echo(empty($rs->fields["status"])?"Inactive":"Active"); ?></td>-->
			         <td  class="row-nav">
		                <a href="quick_links_new.php?id=<?php echo $tools_admin->encryptId($rs->fields["id"]);?>" title="Update Link" class="table-edit-link"></a>
            			</td>
		            <td >
		            <?php if(!empty($rs->fields["status"])){ ?>
	                <a href="quick_links_delete.php?link_id=<?php echo $tools_admin->encryptId($rs->fields["id"]);?>" title="Delete Link" class="table-delete-link"></a>
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
<!--</div>-->
<!-- --------------------- -->

</form>
<?php include($site_root."includes/footer.php"); ?>
