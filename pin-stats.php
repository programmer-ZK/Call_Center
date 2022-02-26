<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "pin-stats.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "PIN Stats";
        $page_menu_title = "PIN Stats";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/pin_reports.php");
	$pin_reports = new pin_reports();
		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
?>	
<?php include($site_root."includes/header.php"); ?>	


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
	//include_once("includes/search_form.php");
		
	//$total_records_count = $pin_reports->get_records_count(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
	$today =date("YmdHms");
	$isexport = 0;
	$count_type= "pin";	
	//$recStartFrom = 0;
	$field = empty($_REQUEST["field"])?"update_datetime":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];
	//echo "Field => ".$field." $order => ".$order;
	
if(isset($_REQUEST['export']))
{
								
    if($search_keyword == "pin_generate")
	{
		$total_records_count = $pin_reports->get_counts_generate(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		$rs = $pin_reports->get_records_generate(addslashes($txtSearch), $recStartFrom=0, $total_records_count/*$page_records_limit*/, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
		//$db_export = $site_root."download/Pin_Generated_Records_".$today.".csv";
		
		$db_export_server = $site_root."download/Pin_Generated_Records_".$today.".csv";
		$db_export_fix = $site_root."download/Pin_Generated_Records.csv";
		
		$heading = "Pin Generated\r\n\r\n";$heading .= "Note: 1=Success | 2 or 3=Failed\r\n\r\n";
		$heading .= "Unique ID, Caller Id, Customer ID, Status, Date,  Time,  Agent Name\r\n";
		shell_exec("echo '".$heading."' > ".$db_export_fix);
		shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	}
	if($search_keyword == "pin_change")
	{
		$total_records_count = $pin_reports->get_counts_change(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		$rs = $pin_reports->get_records_change(addslashes($txtSearch), $recStartFrom=0, $total_records_count/*$page_records_limit*/, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
		//$db_export = $site_root."download/Pin_Change_Records_".$today.".csv";
		
		$db_export_server = $site_root."download/Pin_Change_Records_".$today.".csv";
		$db_export_fix = $site_root."download/Pin_Change_Records.csv";
		
		$heading = "Pin Changed\r\n\r\n";$heading .= "Note: 1=Success | 2 or 3=Failed\r\n\r\n";
		
		$heading .= "Unique ID, Caller Id, Customer ID, Status, Date,  Time,  Agent Name\r\n";
		shell_exec("echo '".$heading."' > ".$db_export_fix);
		shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	}
	if($search_keyword == "pin_verified")
	{
		$total_records_count = $pin_reports->get_counts_verified(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		$rs = $pin_reports->get_records_verified(addslashes($txtSearch), $recStartFrom=0, $total_records_count/*$page_records_limit*/, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
		//$db_export = $site_root."download/Pin_Verification_Records_".$today.".csv";
		
		$db_export_server = $site_root."download/Pin_Verification_Records_".$today.".csv";
		$db_export_fix = $site_root."download/Pin_Verification_Records.csv";
		
		$heading = "Pin Verified\r\n\r\n";$heading .= "Note: 1=Success | 2 or 3=Failed\r\n\r\n";
		$heading .= "Unique ID, Caller Id, Customer ID, Status, Date,  Time,  Agent Name\r\n";
		shell_exec("echo '".$heading."' > ".$db_export_fix);
		shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	}
	if($search_keyword == "pin_reset")
	{
		$total_records_count = $pin_reports->get_counts_reset(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		$rs = $pin_reports->get_records_reset(addslashes($txtSearch), $recStartFrom=0, $total_records_count/*$page_records_limit*/, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
		//$db_export = $site_root."download/Pin_Reset_Records_".$today.".csv";
		
		$db_export_server = $site_root."download/Pin_Reset_Records_".$today.".csv";
		$db_export_fix = $site_root."download/Pin_Reset_Records.csv";
		
		$heading = "Pin Reset\r\n\r\n";$heading .= "Note: 1=Success | 2 or 3=Failed\r\n\r\n";
		$heading .= "Unique ID, Caller Id, Customer ID, Status, Date,  Time,  Agent Name\r\n";
		shell_exec("echo '".$heading."' > ".$db_export_fix);
		shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	}
    ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-type: application/force-download");
    //header("Content-Type: text/csv");
    
	//echo $db_export; exit;
    header("Content-Disposition: attachment; filename=".basename($db_export_fix).";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($db_export_fix));
    readfile($db_export_fix);
    if(file_exists($db_export_fix) && !empty($file_name)){
     unlink($db_export_fix);
     }
     exit();
}
	
if(isset($_REQUEST['export_pdf']))
{
								
    if($search_keyword == "pin_generate")
	{
		$total_records_count = $pin_reports->get_counts_generate(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		$rs = $pin_reports->get_records_generate(addslashes($txtSearch), $recStartFrom=0, $total_records_count/*$page_records_limit*/, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
		//$db_export = $site_root."download/Pin_Generated_Records_".$today.".csv";
		
		$db_export_server = $site_root."download/Pin_Generated_Records_".$today.".csv";
		$db_export_fix = $site_root."download/Pin_Generated_Records.csv";
		
		$heading = "<tag1>Pin Generated</tag1>\r\n";$heading .= "<tag5>Note: 1=Success | 2 or 3=Failed</tag5>\r\n";
		$heading .= "<tag2>Unique ID</tag2>, <tag2>Caller Id</tag2>, <tag2>Customer ID</tag2>, <tag2>Status</tag2>, <tag2>Date</tag2>,  <tag2>Time</tag2>,  <tag2>Agent Name</tag2>";
		shell_exec("echo '".$heading."' > ".$db_export_fix);
		shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	}
	if($search_keyword == "pin_change")
	{
		$total_records_count = $pin_reports->get_counts_change(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		$rs = $pin_reports->get_records_change(addslashes($txtSearch), $recStartFrom=0, $total_records_count/*$page_records_limit*/, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
		//$db_export = $site_root."download/Pin_Change_Records_".$today.".csv";
		
		$db_export_server = $site_root."download/Pin_Change_Records_".$today.".csv";
		$db_export_fix = $site_root."download/Pin_Change_Records.csv";
		
		$heading = "<tag1>Pin Changed</tag1>\r\n";$heading .= "<tag5>Note: 1=Success | 2 or 3=Failed</tag5>\r\n";
		$heading .= "<tag2>Unique ID</tag2>, <tag2>Caller Id</tag2>, <tag2>Customer ID</tag2>, <tag2>Status</tag2>, <tag2>Date</tag2>,  <tag2>Time</tag2>,  <tag2>Agent Name</tag2>";
		shell_exec("echo '".$heading."' > ".$db_export_fix);
		shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	}
	if($search_keyword == "pin_verified")
	{
		$total_records_count = $pin_reports->get_counts_verified(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		$rs = $pin_reports->get_records_verified(addslashes($txtSearch), $recStartFrom=0, $total_records_count/*$page_records_limit*/, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
		//$db_export = $site_root."download/Pin_Verification_Records_".$today.".csv";
		
		$db_export_server = $site_root."download/Pin_Verification_Records_".$today.".csv";
		$db_export_fix = $site_root."download/Pin_Verification_Records.csv";
		
		$heading = "<tag1>Pin Verified</tag1>\r\n";$heading .= "<tag5>Note: 1=Success | 2 or 3=Failed</tag5>\r\n";
		$heading .= "<tag2>Unique ID</tag2>, <tag2>Caller Id</tag2>, <tag2>Customer ID</tag2>, <tag2>Status</tag2>, <tag2>Date</tag2>,  <tag2>Time</tag2>,  <tag2>Agent Name</tag2>";
		shell_exec("echo '".$heading."' > ".$db_export_fix);
		shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	}
	if($search_keyword == "pin_reset")
	{
		//echo $isexport; exit;
		$total_records_count = $pin_reports->get_counts_reset(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);	
		$rs = $pin_reports->get_records_reset(addslashes($txtSearch), $recStartFrom=0, $total_records_count/*$page_records_limit*/, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
		//$db_export = $site_root."download/Pin_Reset_Records_".$today.".csv";
		
		$db_export_server = $site_root."download/Pin_Reset_Records_".$today.".csv";
		$db_export_fix = $site_root."download/Pin_Reset_Records.csv";
		
		$heading = "<tag1>Pin Reset</tag1>\r\n";$heading .= "<tag5>Note: 1=Success | 2 or 3=Failed</tag5>\r\n";
		$heading .= "<tag2>Unique ID</tag2>, <tag2>Caller Id</tag2>, <tag2>Customer ID</tag2>, <tag2>Status</tag2>, <tag2>Date</tag2>,  <tag2>Time</tag2>,  <tag2>Agent Name</tag2>";
		shell_exec("echo '".$heading."' > ".$db_export_fix);
		shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	}
								
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	$tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 10, 'Pin_Stats.pdf', 'D', 40, 10, 1);
	exit();
}	
	$isexport = 1;
	if($search_keyword == "pin_generate")
	{
		$total_records_count = $pin_reports->get_counts_generate(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		
		include_once("includes/paging.php");
		
		$rs = $pin_reports->get_records_generate(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
	}
	if($search_keyword == "pin_change")
	{
		$total_records_count = $pin_reports->get_counts_change(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		
		include_once("includes/paging.php");
		
		$rs = $pin_reports->get_records_change(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
	}
	if($search_keyword == "pin_verified")
	{
		$total_records_count = $pin_reports->get_counts_verified(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		
		include_once("includes/paging.php");
		
		$rs = $pin_reports->get_records_verified(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
	}
	if($search_keyword == "pin_reset")
	{
		$total_records_count = $pin_reports->get_counts_reset(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		
		include_once("includes/paging.php");
		
		$rs = $pin_reports->get_records_reset(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords, $isexport, $today);
	}
		
	//	include_once("includes/paging.php");
	//$rs = $pin_reports->get_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
?>


<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">PIN Report</div>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
<div class="box">
<?php $form_type = "pin"; 
 include($site_admin_root."includes/search_form.php"); ?>
<?php  include($site_admin_root."includes/date_search_bar.php"); ?>
</div>
<br />
<div id="mid-col" class="mid-col" >
	<div class="box">
        <h4 class="white"><?php echo($page_title); ?></h4>
		
		     <table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
      			<thead>
					<tr>
	                	<td colspan="12" class="paging"></td>
        		    </tr>
      				<tr>
					<td class="col-head2" style="width:24%;">Tracking ID</td>
	        	        <td class="col-head2" style="width:15%;">Caller ID</td>
						 <td class="col-head2" style="width:8%;">Status</td>
						 <td class="col-head2" style="width:15%;">CustID</td>
		                <td class="col-head2" style="width:12%;">Date</td>
						<td class="col-head2" style="width:10%;">Time</td>
		               <!-- <td class="col-head2"><a href="<?php //echo($page_name);?>?field=Duration&order=<?php //echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php //echo $fdate; ?>&tdate=<?php //echo $tdate; ?>&keywords=<?php //echo $keywords; ?>&search_keyword=<?php //echo $search_keyword; ?>">Duration</a></td>-->
						 <td class="col-head2">Agent Name</td>
						 <!--<td class="col-head2"><a href="<?php //echo($page_name);?>?field=call_type&order=<?php //echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php //echo $fdate; ?>&tdate=<?php //echo $tdate; ?>&keywords=<?php //echo $keywords; ?>&search_keyword=<?php //echo $search_keyword; ?>">Call Type</a></td>
						<td class="col-head2"><a href="<?php //echo($page_name);?>?field=uniqueid&order=<?php //echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php //echo $fdate; ?>&tdate=<?php //echo $tdate; ?>&keywords=<?php //echo $keywords; ?>&search_keyword=<?php //echo $search_keyword; ?>">Call ID</a></td>-->
						
						<!--<td class="col-head2">Audio File</td>-->
					</tr>
      			</thead>
			</table>
		
        <div class="box-container" style="overflow:auto; height:600px;">  		
      		<table class="table-short">
      			<tbody>
				<?php while(!$rs->EOF){ ?>
      				<tr class="odd">
					<td class="col-first"><a title="click here to download" target="_blank" href="recording/<?php echo date('Ymd',strtotime($rs->fields["date"])).'/'.$rs->fields["userfield"]; ?>.wav" ><?php echo $rs->fields["unique_id"]; ?></a> </td>
                        <td class="col-first"><?php echo $rs->fields["caller_id"]; ?> </td>					<?php if($rs->fields["status"] == "1"){ $pin_status = "SUCCESS"; }
							else if($rs->fields["status"] == "2"){$pin_status = "FAILED";}
							else if($rs->fields["status"] == "3"){$pin_status = "FAILED";}
						 ?>
						<td class="col-first"><?php echo substr($pin_status,0,1); ?> </td>
						
						<td class="col-first"><?php echo $rs->fields["customer_id"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["date"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["time"]; ?> </td>
						<!--<td class="col-first"><?php //echo $rs->fields["Duration"]; ?> </td>-->
						<td class="col-first"><?php echo $rs->fields["agent_name"]; ?> </td>
						<!--<td class="col-first"><?php //echo substr($rs->fields["call_type"],0,1); ?> </td>					
						<td class="col-first"><a href="call_detail.php?unique_id=<?php //echo $rs->fields["uniqueid"];?>" ><?php //echo $rs->fields["uniqueid"]; ?></a></td>-->
						<!--<td class="col-first"><a title="click here to download" target="_blank" href="recording/<?php //echo $rs->fields["userfield"]; ?>.wav" > Audio <?php //echo $rs->fields["userfield"]; ?></a></td>-->
					</tr>
				<?php $rs->MoveNext();	} ?>
      			</tbody>
      		</table>  	
      	</div>
			<p><?php echo($paging_block);?></p>
      </div> 
	</div>

</form>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2">
<div style="float:right;padding-top:5px;">
		 <a class="button" href="javascript:document.xForm2.submit();" >
		 <span>Export Excel</span>
		 </a>
		<input type="hidden" value="export >>" id="export" name="export" />
		
		<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword"		name="search_keyword" />
		<input type="hidden" value="<?php echo $keywords; ?>"	 	id="keywords" 			name="keywords" />
		<input type="hidden" value="<?php echo $tdate; ?>" 			id="tdate" 				name="tdate" />
		<input type="hidden" value="<?php echo $fdate; ?>" 			id="fdate" 				name="fdate" />
		<input type="hidden" value="<?php echo $order; ?>" 			id="order"				name="order" />
		<input type="hidden" value="<?php echo $field; ?>" 			id="field" 				name="field" />
		</div>
</form>

<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">
<div style="float:right;padding-top:5px;">
		 <a class="button" href="javascript:document.xForm3.submit();" >
		 <span>Export PDF</span>
		 </a>
		<input type="hidden" value="export >>" id="export_pdf" name="export_pdf" />
		
		<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword"		name="search_keyword" />
		<input type="hidden" value="<?php echo $keywords; ?>"	 	id="keywords" 			name="keywords" />
		<input type="hidden" value="<?php echo $tdate; ?>" 			id="tdate" 				name="tdate" />
		<input type="hidden" value="<?php echo $fdate; ?>" 			id="fdate" 				name="fdate" />
		<input type="hidden" value="<?php echo $order; ?>" 			id="order"				name="order" />
		<input type="hidden" value="<?php echo $field; ?>" 			id="field" 				name="field" />
		</div>
</form>

</div>
<?php include($site_admin_root."includes/footer.php"); ?>
