<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "test_scores_search.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Test Scores Search";
        $page_menu_title = "Test Scores Search";
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
function getvalues() {

	var fdate = document.getElementById("fdate").value;
	var tdate = document.getElementById("tdate").value;
	var search_keyword = document.getElementById("search_keyword").value;
	var test_code = document.getElementById("test_code").value;
	
	if (fdate == null || tdate == null){
	
		alert("Please select valid values!");
		return false;
	}
	else{
	
		return popitup('test_scores_report.php?fdate='+fdate+'&tdate='+tdate+'&test_code='+test_code+'&search_keyword='+search_keyword);
	}

}

function popitup(url) {
	newwindow=window.open(url,'name','height=660,width=1024,scrollbars=1');
	if (window.focus) {newwindow.focus()}
	return false;
}
</script>
   
<!--<meta http-equiv="refresh" content="2">-->
<?php

	
if(isset($_REQUEST['search_date']))
{
	//$keywords			= $_REQUEST['keywords'];
	$search_keyword		= $_REQUEST['search_keyword'];
	$test_code			= $_REQUEST['test_code'];
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
	//$keywords 		= empty($_REQUEST["keywords"])?"":$_REQUEST["keywords"];
	$search_keyword = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];
	$test_code = empty($_REQUEST["test_code"])?"":$_REQUEST["test_code"];
}

?>
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Test Scores Search</div>
<div>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">

<div id="mid-col" class="mid-col">
	<div class="box">
	 
	<h4 class="white">
	<table>
		<tr>
			<td style="padding-right:5px">
				From Date :
			</td>
			<td>
	 			<label>
				<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo $fdate; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown')">
				</label>
			</td>
			<td style="padding-left:20px">
				<label>
				<?php echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name","",false,"form-select",$search_keyword,"Agent"," 1=1 and group_id = '2' and designation = 'Agents' "); ?>
				</label>
			</td>
			
		</tr>
		<tr>
			<td style="padding-top:10px">
				To Date :
			</td>
			<td>
	 			<label>
				<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo $tdate; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('tdate','yyyyMMdd', 'dropdown')">
				</label>
			</td>
			<td style="padding-left:20px">
				<label>
				<?php echo $tools_admin->getcombo("evaluation_test_scores","test_code","test_code","test_name","",false,"form-select",$test_code,"Test Name"," 1=1 and status = 1 GROUP BY test_name ORDER BY test_name"); ?>
				</label>
			</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td style="padding-top:10px;float:right; margin-right:-10px;">
				<a class="button" href="" onClick="javascript:return getvalues();" >
		 		<span>Search</span>
		 		</a>
				<input type="hidden" value="Search >>" id="search_date" name="search_date" />
			</td>
		</tr>
	</table>
	
	</h4>
	</div>
</div>
	
</form>
</div>

<?php include($site_admin_root."includes/footer.php"); ?>