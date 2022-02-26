<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "list";
	$page_title = "List";
	$page_menu_title = "List";
?>

<?php include($site_root."includes/header.php"); ?>

<?php
	include_once("classes/utility.php");
	$utility = new utility();
	
	$total_records_count = $utility->get_records_count($txtSearch);
	
	include_once("includes/paging.php");
	$field = empty($_REQUEST["field"])?"name":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"asc":$_REQUEST["order"];
	
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
	
	$rs = $utility->get_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>
<form name="listings" id="listings" action="http://localhost/jbconner/list.php" method="post" onsubmit="javascript:return Confirmation(this);" >
	<table cellspacing="0" cellpadding="0" class="grid" width="70%">
		<tr >
			<td colspan="2" class="paging"><?php echo($paging_block);?></td>
		</tr>
		<tr >
			<th width="20%">Name</th>
			<th width="60%">Email</th>
		</tr>
		<?php
		while(!$rs->EOF){ ?>
			<tr>
				<td width="395"><?php echo $rs->fields["name"]; ?> </td>
				<td width="395"><?php echo $rs->fields["email"]; ?> </td>
			</tr>
		<?php
			$rs->MoveNext();
		}
		?>
		<tr>
			<td colspan="2" class="paging"><?php echo($paging_block);?></td>
		</tr>
	</table>
</form>
<form name="btnpanel" id="btnpanel" action="http://localhost/jbconner/list.php" method="post" onsubmit="" >
	<input type="submit" value="Export" name="export" class="txtsearchbutton"/>
</form>
<?php include($site_admin_root."includes/footer.php"); ?>
