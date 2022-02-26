<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "icdr-stats.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "CDR Stats";
        $page_menu_title = "CDR Stats";
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

<?php	
$today =date("YmdHms");
if(isset($_REQUEST['search_date'])){
	$keywords			= $_REQUEST['keywords'];
	$search_keyword                 = $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	
        if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])){
                //$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
        }	
}
else{
	$fdate 			= empty($_REQUEST["fdate"])?date('d-m-Y'):$_REQUEST["fdate"];
	$tdate 			= empty($_REQUEST["tdate"])?date('d-m-Y'):$_REQUEST["tdate"];
	$keywords 		= empty($_REQUEST["keywords"])?"":$_REQUEST["keywords"];
	$search_keyword         = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];
}
 $fdate = date('Y-m-d', strtotime($fdate));
 $tdate = date('Y-m-d', strtotime($tdate));

?>
<?php

$count_type= "cdr";	
$total_records_count = $reports->iget_records_count(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);

$field = empty($_REQUEST["field"])?"call_datetime":$_REQUEST["field"];
$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];

if(isset($_REQUEST['export'])){

    $rs = $reports->iget_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords, 0, $today);
	//die;
    $db_export_server = $site_root."download/Call_Records.csv";
    $db_export_fix = $site_root."download/Call_Records_".$today.".csv";

    $heading = "CDR STATS\r\n\r\n";
    $heading .= "Caller ID, Call Status, Call Type, Tracking ID , Date, Time, Duration, Agent Name, Agent ID, Rec Filename\r\n";
    shell_exec("echo '".$heading."' > ".$db_export_fix);
    shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
	unlink($db_export_server);


    ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-type: application/force-download");

    header("Content-Disposition: attachment; filename=".basename($db_export_fix).";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($db_export_fix));
    readfile($db_export_fix);
    if(file_exists($db_export_fix) && !empty($file_name)){
        unlink($db_export_fix);
    }
    exit();
}
if(isset($_REQUEST['export_pdf'])){
    $rs = $reports->iget_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords, 0, $today);
  
    //$db_export = $site_root."download/Call_Records_".$today.".csv";
    $db_export_server = $site_root."download/Call_Records.csv";
    $db_export_fix = $site_root."download/Call_Records_".$today.".csv";

    $heading = "<tag1>CDR STATS</tag1>\r\n";
    $heading .= "<tag2>Caller ID</tag2>, <tag2>Call Status</tag2>, <tag2>Call Type</tag2>, <tag2>Tracking ID</tag2>, <tag2>Date</tag2>, <tag2>Time</tag2>, <tag2>Duration</tag2>, <tag2>Agent Name</tag2>, <tag2>Agent ID</tag2>, <tag2>Rec Filename</tag2>";
    shell_exec("echo '".$heading."' > ".$db_export_fix);
    shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);

    ///////////////////------HK------///////////////////
    //echo $db_export_fix; exit();
    ob_end_clean();
    //generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
    $tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 12, 'Call_Records.pdf', 'D', 40, 10, 1);
	unlink($db_export_server);
    exit();
}

$rs = $reports->iget_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords, 1, $today);
?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Call Records</div>
<div>
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
        <div class="box">
            <?php
                $form_type = "icdr";
                include($site_admin_root."includes/search_form.php");
                include($site_admin_root."includes/date_search_bar.php");
            ?>
        </div>
        <br />
        <div id="mid-col" class="mid-col">
            <div class="box">
                <h4 class="white"><?php echo($page_title); ?></h4>
                <table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
                    <thead>
                        <tr>
                            <td colspan="12" class="paging"><?php echo($paging_block);?></td>
                        </tr>
                        <tr>
                            <td class="col-head2" style="width:20%;"><a href="<?php echo($page_name);?>?field=caller_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Caller ID</a></td>
                            <td class="col-head2" style="width:14%;"><a href="<?php echo($page_name);?>?field=call_date&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Date</a></td>
                            <td class="col-head2" style="width:12%;"><a href="<?php echo($page_name);?>?field=call_time&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Time</a></td>
                            <td class="col-head2" style="width:15%;"><a href="<?php echo($page_name);?>?field=call_duration&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Duration</a></td>
                            <td class="col-head2" style="width:18%;"><a href="<?php echo($page_name);?>?field=full_name&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Agent Name</a></td><!--JD inline 22 dec 2014-->
                            <!--<td class="col-head2" style="width:6%;"><a href="<?php /*?><?php echo($page_name);?>?field=call_type&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?><?php */?>">Call<br>Type</a></td>-->
                            <!--<td class="col-head2" style="width:10%;"><a href="<?php /*?><?php echo($page_name);?>?field=call_type&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?><?php */?>">Work<br>Code</a></td>-->
                            <td class="col-head2"><a href="<?php echo($page_name);?>?field=unique_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Call ID</a></td>
                        </tr>
                    </thead>
                </table>
                <div class="box-container" style="overflow:auto; height:600px;">
                    <table class="table-short">
                        <tbody>
                            <?php while(!$rs->EOF){  //date('Ymd',strtotime($rs->fields["call_date"])); ?>
                            <tr class="odd">
							<?php $split = explode('-',$rs->fields["call_date"]); ?>
                                <td class="col-first"><a title="click here to download" target="_blank" href="recording/<?php echo $split[0].$split[1].$split[2].'/'.$rs->fields["userfield"]; ?>.wav" ><?php echo $rs->fields["caller_id"]; ?> </a></td>
                                <td class="col-first"><?php echo date('d-m-Y',strtotime($rs->fields["call_date"])) //$rs->fields["call_date"]; //;?> </td>
                                <td class="col-first"><?php echo $rs->fields["call_time"]; //date("g:i s", strtotime($rs->fields["call_time"])); ?> </td>
                                <td class="col-first"><?php echo $rs->fields["call_duration"]; ?> </td>
                                <td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>
                                 <!--JD inline 22 dec 2014-->
                                <!--<td class="col-first"><?php /*?><?php echo substr($rs->fields["call_type"],0,1); ?>-<?php echo substr($rs->fields["call_status"],0,1); ?><?php */?> </td>-->
                                <?php /*?><?php
                                $rsw = $user_tools->get_call_workcodes($rs->fields['unique_id']);
                                $i = 1;
                                $workcodes = "";
                                while (!$rsw->EOF){
                                    $workcodes .= "\r\n".$i."- ".$rsw->fields['workcodes'];
                                    $i++;
                                    $rsw->MoveNext();
                                }
                                ?><?php */?>
                                <!--<td class="col-first"><a name="<?php /*?><?php echo $workcodes;?><?php */?>" href="#" onclick="showWorkCode(this.name)" >View</a></td>-->
                                <td class="col-first"><a href="call_detail.php?unique_id=<?php echo $rs->fields["unique_id"];?>&id=<?php echo $rs->fields["id"];?>" ><?php echo $rs->fields["unique_id"]; ?></a></td>
                            </tr>
                            <?php
                            $rs->MoveNext();
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
    </form>
  </div>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2">
    <div style="float:right;">
        <a class="button" href="javascript:document.xForm2.submit();" ><span>Export EXCEL</span></a>
        <input type="hidden" value="export >>" id="export" name="export" />
        <input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword" name="search_keyword" />
        <input type="hidden" value="<?php echo $keywords; ?>" id="keywords" name="keywords" />
        <input type="hidden" value="<?php echo $tdate; ?>" id="tdate" name="tdate" />
        <input type="hidden" value="<?php echo $fdate; ?>" id="fdate" name="fdate" />
        <input type="hidden" value="<?php echo $order; ?>" id="order" name="order" />
        <input type="hidden" value="<?php echo $field; ?>" id="field" name="field" />
    </div>
</form>
<form action="<?php  echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">
    <div style="float:right;">
        <a class="button" href="javascript:document.xForm3.submit();" ><span>Export PDF</span> </a>
        <input type="hidden" value="exportpdf" id="export_pdf" name="export_pdf" />
        <input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword"	name="search_keyword" />
        <input type="hidden" value="<?php echo $keywords; ?>" id="keywords" name="keywords" />
        <input type="hidden" value="<?php echo $tdate; ?>" id="tdate" name="tdate" />
        <input type="hidden" value="<?php echo $fdate; ?>" id="fdate" name="fdate" />
        <input type="hidden" value="<?php echo $order; ?>" id="order" name="order" />
        <input type="hidden" value="<?php echo $field; ?>" id="field" name="field" />
    </div>
</form>

<?php include($site_admin_root."includes/footer.php"); ?>
