<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "search_agent.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Search Agent";
        $page_menu_title = "Search Agent";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/reports.php");
	$reports = new reports();
?>	
<?php include($site_root."includes/header.php"); ?>	

<script type="text/javascript" language="javascript1.2">
function validate_and_redirect(type) {

	var search_keyword = document.getElementById("search_keyword").value;
	
	if (search_keyword == 0 && type == 'add'){
	
		alert("Please select valid values!");
		return false;
	}
	else{
	
		return popitup('add_agent.php?agent_id='+search_keyword+'&operation=add');
	}

}

function popitup(url) {
	newwindow=window.open(url,'name','height=660,width=1024,scrollbars=1');
	if (window.focus) {newwindow.focus()}
	return false;
}

//function validate() {
//
//	var search_keyword = document.getElementById("search_keyword").value;
//	
//	if (search_keyword == 0){
//	
//		alert("Please select valid values!");
//		return false;
//	}
//	return true;
//}

//function submitform() {
//
//document.forms["xForm"].submit();
//}

</script>
   
<!--<meta http-equiv="refresh" content="2">-->
<?php

	
if(isset($_REQUEST['replace']) && !empty($_REQUEST['replace']))
{
	$search_keyword		= $_REQUEST['search_keyword'];

	
}else
{
	$search_keyword = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];
}

?>

<div>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">

<div id="mid-col" class="mid-col">
	<div class="box">
	 
	<h4 class="white">
	<table>
		<tr>
			<td style="padding-left:5px">
				<label>
				<?php echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name",$search_keyword,false,"form-select",$search_keyword,"Agent"," 1=1 and group_id = '2' and designation = 'Agents' "); ?>
				</label>
			</td>
			<td>&nbsp;&nbsp;</td>
			<td>
				<a class="button" href="" onclick="javascript: return validate_and_redirect('add');">
		 		<span>Add Agent</span>
		 		</a>
				<input type="hidden" value="Add >>" id="add" name="add" />
			</td>
		</tr>
	</table>
	
	</h4>
	</div>
</div>
	
</form>
</div>

<?php include($site_admin_root."includes/footer.php"); ?>