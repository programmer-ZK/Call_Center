<?php include_once("includes/config.php"); ?>
<?php  session_start();
        $page_name = "iworkcode.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Work Code Report";
        $page_menu_title = "Work Code Report";
?>



<?php include_once($site_root."includes/check.auth.php"); ?>

<?php 
	include_once("classes/reports.php");
	$reports = new reports();
		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
    $admin = new admin();
	
	include_once("classes/user_tools.php");		
	$user_tools = new user_tools();
	
	include_once("classes/work_codes_new.php");
	$work_codes = new work_codes();
?>	
<?php include($site_root."includes/header.php"); ?>	

  
<script type="text/javascript">
$(function(){
  $('.parent').on('click',function(){
      $('.child').attr('checked',this.checked);
  });
});

</script>


<script type="text/javascript">
					$('input:radio').change(
    function(e){
        if ($(this).is(':checked')){
            $(show).show();
        }
    });
 </script>

<script type="text/javascript">
 function container_visible(id){
	 $("#navcontainer"+id).slideToggle("slow");	
	}
</script>	
<script type="text/javascript" language="javascript1.2">


 

function showWorkCode(wc)
{
	if(wc || 0 !== wc.length)
	{
		alert(wc);
		
	}
	else
	{
		alert("No work code available!");
		
	}
	return false;
}
</script>

<?php
	
$today =date("YmdHms");
	
	
if(isset($_REQUEST['search_date']))
{ //print_r ($_REQUEST['cb']);exit;
	$newsearch			= $_REQUEST['cb'];
session_start(); 
$_SESSION['views'] =$newsearch	; 
	$newsearch			= $_REQUEST['cb'];
	$keywords			= $_REQUEST['keywords'];
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	//echo $fdate.'-'.$tdate;
	$level1		 		= $_REQUEST['level1'];
	$level2		 		= $_REQUEST['level2'];
	$level3	 			= $_REQUEST['level3'];
	$level4		 		= $_REQUEST['level4'];	
	$level5	 			= $_REQUEST['level5'];
	//echo $cb;exit;
	//print_r ($_REQUEST);exit;
	
	$rs = $reports->get_workcode_details_newxx($field, $order, $fdate, $tdate, $search_keyword, $keywords, false, $today,$newsearch);
	
	//$rs = $reports->get_workcode_details_new2($field, $order, $fdate, $tdate, $search_keyword, $keywords, false, $today,$level1,$level2,$level3,$level4,$level5);
		
}else
{  
	$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
	$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];
	$keywords 		= empty($_REQUEST["keywords"])?"":$_REQUEST["keywords"];
	$search_keyword = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];
	$level1		 		= $_REQUEST['level1'];
	$level2		 		= $_REQUEST['level2'];
	$level3	 			= $_REQUEST['level3'];
	$level4		 		= $_REQUEST['level4'];	
	$level5	 			= $_REQUEST['level5'];
}
	
?>
<?php

	$field = empty($_REQUEST["field"])?"staff_updated_date":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];
	//echo "keyword =>".$keywords."<br>search keyword =>".$search_keyword."<br>fdate =>".$fdate."<br>tdate =>".$tdate."<br>Field => ".$field."<br>$order => ".$order;
	//echo date("YmdHms"); exit;
	

if(isset($_REQUEST['export']))
{	
	//print_r ($_SESSION['views']);exit;
$rs = $reports->get_workcode_details_newxx($field, $order, $fdate, $tdate, $search_keyword, $keywords, true, $today,$_SESSION['views']);				
	//$rs = $reports->get_workcode_details_new2($field, $order, $fdate, $tdate, $search_keyword, $keywords, true, $today,$level1,$level2,$level3,$level4,$level5);
	
	//$db_export = $site_root."download/Call_Records_".$today.".csv";
	$db_export_server = $site_root."download/Workcode_report_".$today.".csv";
	$db_export_fix = $site_root."download/Workcode_report.csv";
	
	$heading = "Work Code Report\r\n\r\n";
	$heading .= "Tracking ID, Caller ID, CM ID, Call Type, Work Code, Date Time, Agent Name, Detail\r\n";
	shell_exec("echo '".$heading."' > ".$db_export_fix);
	shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	//unlink($db_export_server);
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
{$rs = $reports->get_workcode_details_newxx($field, $order, $fdate, $tdate, $search_keyword, $keywords, true, $today,$_SESSION['views']);	
	//$rs = $reports->get_workcode_details_new2($field, $order, $fdate, $tdate, $search_keyword, $keywords, true, $today,$level1,$level2,$level3,$level4,$level5);
	
	//$db_export = $site_root."download/Call_Records_".$today.".csv";
	$db_export_server = $site_root."download/Workcode_report_".$today.".csv";
	$db_export_fix = $site_root."download/Workcode_report.csv";
	
	$heading = "<tag1>Work Code Report</tag1>\r\n";
	$heading .= "<tag2>Tracking ID</tag2>, <tag2>Caller ID</tag2>, <tag2>CM ID</tag2>, <tag2>Call Type</tag2>, <tag2>Work Code</tag2>, <tag2>Date Time</tag2>, <tag2>Agent Name</tag2>, <tag2>Detail</tag2>";
	shell_exec("echo '".$heading."' > ".$db_export_fix);
	shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	$tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 12, 'Call_Record.pdf', 'D', 40, 10, 1);
	exit();
}
	
?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">WorkCode Report</div>
<div>

<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
<div class="box">

<?php
  $form_type = "workcode_report";
// $form_type = "workcode_report";
// include($site_admin_root."includes/search_form.php"); 
  include($site_admin_root."includes/date_search_bar.php");
  	
  
  
  ?>
	<h4 class="white rounded_by_jQuery_corners">
<div id="show">
					<?php  
						$html ='';
						echo $work_codes->xrecursive_make_tree(0,'root'); 
					?>		<br/>
							
				</div>	</h4>
		<input type="hidden" value="submitwc" id="submitwc" name="submitwc" />
		<?  $cb = $_POST['cb']; ?>

		
		
		
</form>	

<br />
<div id="mid-col" class="mid-col">
	<div class="box">
        <h4 class="white"><?php echo($page_title); ?></h4>
			<? //echo $cb[1];exit;?>
			<table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
				<thead>
					<tr>
	                	<td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		    </tr>
      				<tr>

	        	        <td class="col-head" style="width:17%;"><a href="<?php echo($page_name);?>?field=unique_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Tracking ID</a></td>

						<td class="col-head" style="width:10%;"><a href="<?php echo($page_name);?>?field=caller_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Caller ID</a></td>
						
		                <td class="col-head2" style="width:8%;"><a href="<?php echo($page_name);?>?field=customer_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">CM ID</a></td>
						
						<td class="col-head2" style="width:6%;"><a href="<?php echo($page_name);?>?field=call_type&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Call<br>Type</a></td>
						
		                <td class="col-head2" style="width:6%;"><a href="<?php echo($page_name);?>?field=workcodes&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Work<br>Code</a></td>
						 <td class="col-head2" style="width:6%;"><a href="<?php echo($page_name);?>?field=agent_name&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Agent<br>Name</a></td>
						 
						 <td class="col-head2" style="width:10%;" ><a href="<?php echo($page_name);?>?field=staff_updated_date&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Date Time</a></td>
						 
						 <td class="col-head2" style="width:11%;"  ><a href="<?php echo($page_name);?>?field=detail&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Detail</a></td>
						 
					</tr>
      			</thead>
			</table>
		
        <div class="box-container" style="overflow:auto; height:600px;">  		
      		<table class="table-short">
      			<tbody>
				<?php while(!$rs->EOF){ ?>
      				<tr class="odd">
						<td class="col-first"><?php echo trim($rs->fields["unique_id"]); ?> </td>
						<td class="col-first"><?php echo trim(substr($rs->fields["caller_id"],0,11)); ?> </td>
						<td class="col-first" style="width:11%;"><?php echo trim($rs->fields["customer_id"]); ?> </td>
						<td class="col-first" style="width:7%;text-align:center;"><?php echo trim(substr($rs->fields["call_type"],0,1)); ?> </td>
						<td class="col-first"><a name="<?php echo trim($rs->fields['workcodes']);?>" href="#" onclick="javascript: return showWorkCode(this.name)" >View</a></td>	
						<td class="col-first"><?php echo trim($rs->fields["agent_name"]); ?> </td>	
						<td class="col-first"><?php echo trim($rs->fields["staff_updated_date"]); ?> </td>							<td class="col-first"><?php echo $rs->fields["detail"]; ?> </td>	
						<?php // $rsw = $user_tools->get_call_workcodes($rs->fields['uniqueid']);?> 
						<!--<td class="col-first"><a name="<?php //echo $rsw->fields['workcodes'];?>" href="#" onclick="showWorkCode(this.name)" >View</a></td>-->
						<!--<td class="col-first"><a href="call_detail.php?unique_id=<?php //echo $rs->fields["uniqueid"];?>" ><?php //echo $rs->fields["uniqueid"]; ?></a></td>-->
					</tr>
				<?php $rs->MoveNext();	} ?>
      			</tbody>
      		</table>  	
      	</div>
		
      </div> 
	</div>
</div> 


<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2">

<div style="float:right">
		 <a class="button" href="javascript:document.xForm2.submit();" >
		 <span>Export EXCEL</span>
		 </a>
		<input type="hidden" value="export >>" id="export" name="export" />
		
		<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword"		name="search_keyword" />
		<input type="hidden" value="<?php echo $keywords; ?>"	 	id="keywords" 			name="keywords" />
		<input type="hidden" value="<?php echo $tdate; ?>" 			id="tdate" 				name="tdate" />
		<input type="hidden" value="<?php echo $fdate; ?>" 			id="fdate" 				name="fdate" />
		<input type="hidden" value="<?php echo $order; ?>" 			id="order"				name="order" />
		<input type="hidden" value="<?php echo $field; ?>" 			id="field" 				name="field" />
		<input type="hidden" value="<?php echo $level1; ?>" 		id="level1" 			name="level1" />
		<input type="hidden" value="<?php echo $level2; ?>" 		id="level2" 			name="level2" />
		<input type="hidden" value="<?php echo $level3; ?>" 		id="level3" 			name="level3" />
		<input type="hidden" value="<?php echo $level4; ?>" 		id="level4" 			name="level4" />
		<input type="hidden" value="<?php echo $level5; ?>" 		id="level5" 			name="level5" />
			<input type="hidden" value="<?php echo $cb; ?>" 		id="cb[]" 			name="cb[]" />

		</div>
</form>
<!--<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">

<div style="float:right">
		 <a class="button" href="javascript:document.xForm3.submit();" >
		 <span>Export PDF</span>
		 </a>
		<input type="hidden" value="exportpdf" id="export_pdf" name="export_pdf" />
		
		<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword"		name="search_keyword" />
		<input type="hidden" value="<?php echo $keywords; ?>"	 	id="keywords" 			name="keywords" />
		<input type="hidden" value="<?php echo $tdate; ?>" 			id="tdate" 				name="tdate" />
		<input type="hidden" value="<?php echo $fdate; ?>" 			id="fdate" 				name="fdate" />
		<input type="hidden" value="<?php echo $order; ?>" 			id="order"				name="order" />
		<input type="hidden" value="<?php echo $field; ?>" 			id="field" 				name="field" />
		<input type="hidden" value="<?php echo $level1; ?>" 		id="level1" 			name="level1" />
		<input type="hidden" value="<?php echo $level2; ?>" 		id="level2" 			name="level2" />
		<input type="hidden" value="<?php echo $level3; ?>" 		id="level3" 			name="level3" />
		<input type="hidden" value="<?php echo $level4; ?>" 		id="level4" 			name="level4" />
		<input type="hidden" value="<?php echo $level5; ?>" 		id="level5" 			name="level5" />
<input type="hidden" value="<?php echo $cb; ?>" 		id="cb[]" 			name="cb[]" />

		</div>
</form>-->
</div>

<?php include($site_admin_root."includes/footer.php"); ?>
