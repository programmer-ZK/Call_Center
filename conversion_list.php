<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "conversion_list";
	$page_title = "Conversion List";
        $page_level = "1";
        $page_group_id = "1";
	$page_menu_title = "Conversion List";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admins = new admin();
	
	$total_records_count = $admins->get_records_count($txtSearch);
	
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
?>
<?php include($site_root."includes/header.php"); ?>
<?php

	include_once("includes/paging.php");
	$field = empty($_REQUEST["field"])?"staff_updated_date":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"asc":$_REQUEST["order"];
	
	if(isset( $_REQUEST["export"])){
		$utility->get_export_file(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
		ob_end_clean();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-type: application/force-download");
		$db_export = $site_root."MatchedEmails.csv";
		header("Content-Disposition: attachment; filename=".basename($db_export).";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".filesize($db_export));
		readfile($db_export);
		if(file_exists($db_export) && !empty($file_name)){
			unlink($db_export);
		}
		exit();
	}
	$rs = $admins->get_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>

<form name="listings" id="listings" action="admins.php" method="post" onsubmit="javascript:return Confirmation(this);" >

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
					<td class="col-head" >Col1</td>
      					<td class="col-head2" ><a href="<?php echo($page_name);?>.php?field=admin_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Admin ID</a></td>
	        	                <td class="col-head2"><a href="<?php echo($page_name);?>.php?field=admin_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Full Name</a></td>
        	        	<!--    <td >Password</td> -->
		                        <td class="col-head2"><a href="<?php echo($page_name);?>.php?field=admin_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Email</a></td>
                		        <td class="col-head2"><a href="<?php echo($page_name);?>.php?field=admin_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Designation</a></td>
		                        <td class="col-head2"><a href="<?php echo($page_name);?>.php?field=admin_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Department</a></td>
		                        <td class="col-head2"><a href="<?php echo($page_name);?>.php?field=admin_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Group Name</a></td>
		                        <td class="col-head2">Status</td>
		                        <td class="col-head2">Staff ID</td>
		                        <td class="col-head2">Staff Update Date</td>
		                        <td class="col-head">Edit</td>
		                        <td class="col-head">Delete</td>

				</tr>
      			</thead>

      			<tfoot>
      				<tr>
      					<td class="col-chk"><input type="checkbox" /></td>
      					<td colspan="4"><div class="align-right"><select class="form-select"><option value="option1">Bulk Options</option>
      					<option value="option2">Delete All</option></select>
      					<a href="#" class="button"><span>perform action</span></a></div></td>
      				</tr>

      			</tfoot>
      			<tbody>
				 <?php
			                while(!$rs->EOF){ ?>

      				<tr class="odd">
				<td class="col-chk"><input type="checkbox" /></td>
				<td class="col-first"><?php echo $rs->fields["admin_id"]; ?></td>
                                <td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>
                        <!--    <td ><?php //echo $rs->fields["password"]; ?> </td> -->
                                <td class="col-second"><?php echo $rs->fields["email"]; ?> </td>
                                <td class="col-first"><?php echo $rs->fields["designation"]; ?> </td>
                                <td class="col-first"><?php echo $rs->fields["department"]; ?> </td>
                                <td class="col-first"><?php echo $rs->fields["group_name"]; ?> </td>
                                <td class="col-first"><?php echo(empty($rs->fields["status"])?"Inactive":"Active"); ?> </td>
                                <td class="col-first"><?php echo $rs->fields["staff_id"]; ?> </td>
                                <td class="col-first"><?php echo $rs->fields["staff_updated_date"]; ?> </td>
                                <td class="row-nav"> <a href="admin_new.php?admin_id=<?php echo $tools_admin->encryptId($rs->fields["admin_id"]); ?>" class="table-edit-link"></a></td>
                                <td class="row-nav">
                                         <?php if(!empty($rs->fields["status"])){ ?>
                                         <a href="admin_delete.php?admin_id=<?php echo $tools_admin->encryptId($rs->fields["admin_id"]);?>" class="table-delete-link" alt = "Delete"></a>
                                         <?php } else {?> &nbsp;
                                         <?php } ?>

                                </td>
				 <?php
		                        $rs->MoveNext();
                			}
                		?>


      				</tr>
      			</tbody>
      		</table>  	
      	</div><!-- end of div.box-container -->
      	</div> <!-- end of div.box -->
</div><!-- end of div#mid-col -->
</div> <!-- full-col-center end -->
<!-- --------------------- -->

</form>
<!--
<form name="btnpanel" id="btnpanel" action="http://localhost/jbconner/list.php" method="post" onsubmit="" >
	<input type="submit" value="Export" name="export" class="txtsearchbutton"/>
	 <input type="button" onclick="window.location='admin_new.php'"  value="ADD" id="add_admin" name="add_admin" class="txtsearchbutton"/>
</form>
-->
<?php include($site_admin_root."includes/footer.php"); ?>
