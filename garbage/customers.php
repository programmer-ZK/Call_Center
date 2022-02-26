<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "customers";
	$page_title = "Customers";
	$page_menu_title = "Customers";
		$page_level = "1";
	$page_group_id = "1";
	$page_menu_title = "Customers";
?>
<?php if($_SESSION['admin_login'] <> "true"){ header ("Location: login.php");}?>
<?php
	include_once("classes/task_list.php");
	$task_list = new task_list();

	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
?>
<?php include($site_root."includes/header.php"); ?>

<?php
	include_once("classes/customers.php");
	$customers = new customers();
	
	$total_records_count = $customers->get_records_count($txtSearch);
	
	include_once("includes/paging.php");
	$field = empty($_REQUEST["field"])?"id":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];
	
	if(isset( $_REQUEST["export"])){
		$utility->get_export_file(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
		ob_end_clean();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-type: application/force-download");
		//header("Content-Type: text/csv");
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
	
	$rs = $customers->get_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>
<form name="listings" id="listings" action="customer_edit.php" method="post" onsubmit="javascript:return Confirmation(this);" >
	
	<div class="full-col-center" id="full-col-center" >
<div id="full-col" class="full-col">
<div class="box">
                <h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">
	<table  class=="table-long" >
		<tr >
			<td colspan="2" class="paging"><?php echo($paging_block);?></td>
		</tr>
		<tr >
			<!--<th width="10%">ID</th>-->
			<th class="col-head" width="10%">Caller ID</th>
			<th class="col-head" width="10%">First Name</th>
			<th class="col-head" width="10%">Last Name</th>
			<!--<th width="10%">Father Name</th>
			<th  width="10%">Mother Name</th>-->
			<th class="col-head" width="10%">CNIC</th>
			<th class="col-head" width="10%">Email</th>
			<th class="col-head" width="10%">Company</th>
			<th class="col-head" width="10%">City</th>
			<th class="col-head" width="10%">Edit</th>
		</tr>
		<?php
		while(!$rs->EOF){ ?>
			<tr>
				<!--<td ><?php echo $rs->fields["id"]; ?> </td>-->
				<td class="col-first" ><?php echo $rs->fields["caller_id"]; ?> </td>
				<td class="col-first"><?php echo $rs->fields["first_name"]; ?> </td>
				<td class="col-first"><?php echo $rs->fields["last_name"]; ?> </td>
				<!--<td ><?php echo $rs->fields["father_name"]; ?> </td>-->
				<!--<td ><?php echo $rs->fields["mother_name"]; ?> </td>-->
				<td class="col-first"><?php echo $rs->fields["cnic"]; ?> </td>
				<td class="col-first"><?php echo $rs->fields["email"]; ?> </td>
				<td class="col-first"><?php echo $rs->fields["company_name"]; ?> </td>
				<td class="col-first" ><?php echo $rs->fields["city"]; ?> </td>
				<!--<td > <input type="button" onclick="window.location='customer_edit.php?rec_id=<?php echo $rs->fields["id"]; ?>'"  value="Edit" id="edit_customer" name="edit_customer" class="txtsearchbutton"/></td>-->
				<td  class="col-first"> <a href="customer_edit.php?rec_id=<?php echo $rs->fields["id"]; ?>" style="color:blue;"> Edit </a></td>
			</tr>
		<?php
			$rs->MoveNext();
		}
		?>
		<tr>
			<td colspan="10" class="paging"><?php echo($paging_block);?></td>
		</tr>
	</table>
	   </div><!-- end of div.box-container -->
        </div> <!-- end of div.box -->
</div><!-- end of div#mid-col -->
</div>
</form>
<form name="btnpanel" id="btnpanel" action="http://localhost/jbconner/list.php" method="post" onsubmit="" >
	<!--<input type="submit" value="Export" name="export" class="txtsearchbutton"/>-->
	 <!--<input type="button" onclick="window.location='customer_new.php'"  value="ADD" id="add_customer" name="add_customer" class="txtsearchbutton"/>-->
</form>
<?php include($site_admin_root."includes/footer.php"); ?>
