<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "customer_feedback_report.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Customer Feedback Report";
        $page_menu_title = "Customer Feedback Report";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/reports.php");
	$reports = new reports();
		
	include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();
	
	include_once("classes/user_tools.php");		
	$user_tools = new user_tools();
?>	
<?php include($site_root."includes/header.php"); ?>	

<script type="text/javascript" language="javascript1.2">

function showWorkCode(wc){
	if(wc || 0 !== wc.length){
		alert(wc);
	}
	else{
		alert("No work code available!");
	}
}
</script>
<script type="text/javascript">
function getHtml4Excel()
{
document.getElementById("gethtml1").value = document.getElementById("customer_feedback_re").innerHTML;
}

</script>
<?php
$staff_id		=	$_REQUEST['search_keyword'];
//ranking$result 		= 	$reports->call_ranking($staff_id);
$time 			=	$result->fields['update_datetime'];//print_r($res2);

	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];


$rank		=	$_REQUEST['search_keyword2'];

//echo $rank;
$today =date("YmdHms");


if(isset($_REQUEST['search_date'])){




	$rank		=	$_REQUEST['search_keyword2'];


	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	
	
        if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])){
		
		
		$count_type= "cdr";	
$total_records_count = $reports->wget_records_count(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords,$unique_id,$time,$staff_id,$rank);
//echo $total_records_count;exit;
//print_r($total_records_count);exit;
$field = empty($_REQUEST["field"])?"call_datetime":$_REQUEST["field"];
$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];


$rs = $reports->wget_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords, 1, $today,$unique_id,$time,$staff_id,$rank);

		
		
		
		
		
		
		
		
		
             
        }	
}
else{
	$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
	$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];

}
?><?php 
/************************* Export to Excel ******************/

if(isset($_REQUEST['export']))
{	//	echo 'waleed';exit;			


	//$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
	//$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];

	$rs = $reports->feedback_export($field, $order, $fdate, $tdate, $search_keyword, $keywords, true, $today,$rank,$staff_id);
	
	//$db_export = $site_root."download/CustomerFeedback_Report_".$today.".csv";
	$db_export_server = $site_root."download/CustomerFeedback_Report_".$today.".csv";
	$db_export_fix = $site_root."download/CustomerFeedback_Report.csv";
	
	$heading = "Customer Feedback Report\r\n\r\n";
	$heading .= "Caller ID, Agent Name , Rank , Call ID , Workcode\r\n";
	shell_exec("echo '".$heading."' > ".$db_export_fix);
	shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	unlink($db_export_server);	
	ob_end_clean();
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	header("Content-type: application/force-download");
	//unlink($db_export_server);


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
	$rs = $reports->feedback_export($field, $order, $fdate, $tdate, $search_keyword, $keywords, true, $today,$rank,$staff_id);
	
	//$db_export = $site_root."download/CustomerFeedback_Report_".$today.".csv";
	$db_export_server = $site_root."download/CustomerFeedback_Report.csv";
	$db_export_fix = $site_root."download/CustomerFeedback_Report_".$today.".csv";
	//$heading .= "Caller ID, Agent Name , Rank , call ID , Workcode\r\n";
	$heading = "<tag1>Customer Feedback Report</tag1>\r\n";
	$heading .= "<tag2>Caller ID</tag2>, <tag2>Agent Name</tag2>, <tag2>Rank</tag2>, <tag2>Call ID</tag2>, <tag2>Work Code</tag2>";
	shell_exec("echo '".$heading."' > ".$db_export_fix);
	shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
		unlink($db_export_server);
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	$tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 12, 'Call_Record.pdf', 'D', 40, 10, 1);
	exit();
}
///******************************************************************************/	
$stringData	 = '';
?>
<?php


//echo $unique_id.$time;exit;




?>
<div id="CustomerFeedbackreport">
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Customer Feedback Report</div>

	
    <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
        <div class="box">
            <?php
                $form_type = "icdr";
            //    include($site_admin_root."includes/search_form.php");
                include($site_admin_root."includes/date_search_bar.php");
            ?><h4 class="white"><tr><td style="padding-left:20px">
			
	<?php //if (!isset($_REQUEST['search_date']) ){ ?>
				<?php  echo "Filter By Agent:";
				echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name","",false,"form-select",$search_keyword,"Agent"," designation = 'Agents' "); ?>
				<br/><br/><br/><?php echo "Filter By Ranks:";
				echo $tools_admin->getcombo2("call_ranking","search_keyword2","rank","rank","",false,"form-select",$search_keyword2,"rank",""); ?>
				</td></tr></h4><? //} ?>
			
	
        
        </div> 	<div id="customer_feedback_re">	
        <div id="mid-col" class="mid-col">
            <div class="box">
			<div style="padding-left:150px" ><?php // while (!$ranking->EOF){?><tr class="odd"><td> <?php //echo $ranking->fields['rank']." Count:".$ranking->fields['feed_back']."\n";?></td><br/></tr><?php  //$ranking->MoveNext();}?></div>
                <h4 class="white"><?php echo($page_title); ?></h4>
                <table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
                
				    <thead>
                        <tr>
                            <td colspan="12" class="paging"><?php echo($paging_block);?></td>
                        </tr>
                      <tr>
						
					
                            <td class="col-head2" >Caller ID</td>
							<td class="col-head2" >AgentName</td>
							<td class="col-head2">Rank</td>
							<td class="col-head2" >Call ID</td>
							<td class="col-head2" >Work Code</td>
               
                        </tr>
                    </thead>
                </table>
                <div class="box-container" style="overflow:auto; height:600px;">
                    <table class="table-short">
                        <tbody>
                            <?php
							while(!$rs->EOF){
							?>
                            <tr class="odd">
                                <td class="col-first"><?php echo $rs->fields["caller_id"]; ?> </td>
								 <td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>
                             
                              <td class="col-first"><?php echo $rs->fields["rank"]; ?> </td>
							   <td class="col-first"><?php echo $rs->fields["unique_id"]; ?> </td>  
                               <?php
                                $rsw = $user_tools->get_call_workcodes($rs->fields['unique_id']);
                                $i = 1;
                                $workcodes = "";
                                while (!$rsw->EOF){
                                    $workcodes .= "\r\n".$i."- ".$rsw->fields['workcodes'];
                                    $i++;
                                    $rsw->MoveNext();
                                }
                                ?>
                                <td class="col-first"><a name="<?php echo $workcodes;?>" href="#" onclick="showWorkCode(this.name)" >View</a></td> 
                                
                            </tr>
                            <?php
                          //  $ranking->MoveNext();
						  $rs->MoveNext();
                            } ?>
							
						</div>	
                        </tbody>
                    </table>
			</div>
                </div>	
				
            </div> 
      
    </form>	</div>





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
		<input type="hidden" value="<?=$rank; ?>" id="rank" name="rank" />
		<input type="hidden" value="<?=$staff_id; ?>" id="staff_id" name="staff_id" />
		</div>
</form>






</div>
  
























<?php include($site_admin_root."includes/footer.php"); ?>
