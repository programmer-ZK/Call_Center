<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "faqs_list";
	$page_title = "FAQs List";
        $page_level = "2";
        $page_group_id = "1";
	$page_menu_title = "FAQs List";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>


<?php

	$t_type = "   FAQs";
	//echo "SMS";
?>


<?php
	include_once("classes/templates_faqs.php");
	$templates_faqs = new templates_faqs();
	
	//$total_records_coun = $admins->get_records_count($txtSearch);
	
	include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();
?>
<?php include($site_root."includes/header.php"); ?>
<?php

	include_once("includes/paging.php");
	$field = empty($_REQUEST["field"])?"update_datetime":$_REQUEST["field"];
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
	//if($template == "email")
	//{
       		$rs = $templates_faqs->get_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $template);
	//}
	//else
	//{
       	// 	$rs = $templates->get_records_sms(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
	//}

//	$rs = $admins->get_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>

<form name="listings" id="listings" action="admins.php" method="post" onsubmit="javascript:return Confirmation(this);" >

<!-- -------------------- -->

<div id="mid-col" class="mid-col">
<div class="box">
      		<h4 class="white"><?php echo($page_title)." ".$t_type; ?></h4>
        <div class="box-container">     		
      		<table class="table-short">
      			<thead>
				<tr >
	                        <td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
      				<tr>
					<td class="col-head" >Col</td>
      					<td class="col-head2" ><a href="<?php echo($page_name);?>.php?field=id&template=<?php echo $template; ?>&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">ID</a></td>
	        	                <td class="col-head2"><a href="<?php echo($page_name);?>.php?field=title&template=<?php echo $template; ?>&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Title</a></td>
        	        	<!--    <td >Password</td> -->
		                        <td class="col-head2"><a href="<?php echo($page_name);?>.php?field=subject&template=<?php echo $template; ?>&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Subject</a></td>
                		        <td class="col-head2"><a href="<?php echo($page_name);?>.php?field=body&template=<?php echo $template; ?>&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Body</a></td>		                        <td class="col-head2"><a href="<?php echo($page_name);?>.php?field=id&template=<?php echo $template; ?>&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Staff Name</a></td>
					<td class="col-head2"><a href="<?php echo($page_name);?>.php?field=id&template=<?php echo $template; ?>&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>">Status</a></td>
		                        <td class="col-head">Edit</td>
		                      <!--  <td class="col-head">Delete</td>-->

				</tr>
      			</thead>

      			<tfoot>
      				<tr>
      					<!--<td class="col-chk"><input type="checkbox" /></td> -->
      					<td colspan="5">
					<div class="align-right">
						<!-- <select class="form-select">
							<option value="option1">Bulk Options</option>
      							<option value="option2">Delete All</option>
						</select>
	      					<a href="#" class="button">
						<span>perform action</span>
						</a>-->
					</div>
					</td>
					<td colspan="5"><div class="align-right"><a href="faqs_new.php" name="add_template" id="add_template" class="button"><span>Add FAQs Template</span></a> </div></td>
							 <input type="hidden" value="ADD TEMPLATE " id="add" name="add"/>
      				</tr>

      			</tfoot>
      			<tbody>
				 <?php
			                while(!$rs->EOF){ ?>

      				<tr class="odd">
				<td class="col-chk"><input type="checkbox" /></td>
				<td class="col-first"><?php echo $rs->fields["id"]; ?></td>
                                <td class="col-first"><?php echo $rs->fields["category"]; ?> </td>
                        <!--    <td ><?php //echo $rs->fields["password"]; ?> </td> -->
                                <td class="col-first"><?php echo $rs->fields["question"]; ?> </td>
                                <td class="col-first"><?php echo $rs->fields["body"]; ?> </td>
                                <td class="col-first"><?php echo $rs->fields["staff_name"]; ?> </td>
                                <td class="col-first"><?php echo(empty($rs->fields["status"])?"Inactive":"Active"); ?> </td> 
                                <td class="row-nav"> <a href="faqs_new.php?template_id=<?php echo $tools_admin->encryptId($rs->fields["id"]); ?>" class="table-edit-link"></a></td>
                               <!-- <td class="row-nav">
                                         <?php //if(!empty($rs->fields["status"])){ ?>
                                         <a href="admin_delete.php?Admin_ID=<?php //echo $tools_admin->encryptId($rs->fields["admin_id"]);?>" class="table-delete-link" alt = "Delete"></a>
                                         <?php // } else {?> &nbsp;
                                         <?php // } ?>

                                </td>-->
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
<!-- --------------------- -->

</form>
<!--
<form name="btnpanel" id="btnpanel" action="http://localhost/jbconner/list.php" method="post" onsubmit="" >
	<input type="submit" value="Export" name="export" class="txtsearchbutton"/>
	 <input type="button" onclick="window.location='admin_new.php'"  value="ADD" id="add_admin" name="add_admin" class="txtsearchbutton"/>
</form>
-->
<?php include($site_admin_root."includes/footer.php"); ?>
