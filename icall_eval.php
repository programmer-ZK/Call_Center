<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "call_eval.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Call Evaluation";
        $page_menu_title = "Call Evaluation";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/reports.php");
	$reports = new reports();
		
	include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();
	
	include_once("classes/user_tools.php");		
	$user_tools = new user_tools();
			
	include_once("classes/cc_evaluation.php");
	$cc_evaluation = new cc_evaluation();
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
	$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
	$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];
	$keywords 		= empty($_REQUEST["keywords"])?"":$_REQUEST["keywords"];
	$search_keyword         = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];
}
?>
<?php

$count_type= "cdr";
$total_records_count = $reports->iget_records_count(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);

$field = empty($_REQUEST["field"])?"call_datetime":$_REQUEST["field"];
$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];

if(isset($_REQUEST['export'])){
    $stringData2 = trim($_REQUEST['stringData2']);
    $stringData2 = str_replace('<tag1>',null,$stringData2 );
    $stringData2 = str_replace('</tag1>',null,$stringData2 );
    $stringData2 = str_replace('<tag2>',null,$stringData2 );
    $stringData2 = str_replace('</tag2>',null,$stringData2 );
    $db_export_fix = $site_root."download/Call_Evaluation.csv";
    shell_exec("echo '".$stringData2."' > ".$db_export_fix);
    ob_end_clean();
    header('Content-disposition: attachment; filename='.basename($db_export_fix));
    header('Content-type: text/csv');
    readfile($db_export_fix);
    if(file_exists($db_export_fix) && !empty($file_name)){
        unlink($db_export_fix);
    }
    exit();
}
if(isset($_REQUEST['export_pdf'])){
	$stringData2	= trim($_REQUEST['stringData2']);
	$db_export_fix  = $site_root."download/Call_Evaluation.csv";
	shell_exec("echo '".$stringData2."' > ".$db_export_fix);
	ob_end_clean();
	$tools_admin->generatePDF($db_export_fix, 'L', 'mm', 'A3', 'Arial', 12, 'Call_Evaluation.pdf', 'D', 60, 10, 1);
	exit();
}
$stringData2	 = '';
$rs = $reports->iget_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords, 1, $today);
?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Call Evaluation</div>
<div>
    <form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
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
                <h4 class="white"><?php $stringData2 .= "<tag1>".$page_title."</tag1>\r\n"; echo($page_title); ?></h4>
                <table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
                    <thead>
                        <?php 
                        $stringData2 .= "<tag2>Caller ID</tag2>,<tag2>Duration</tag2>,<tag2>Agent Name</tag2>,<tag2>Call Type</tag2>,<tag2>Call ID</tag2>,<tag2>Evaluation Status</tag2>,<tag2>Work Code</tag2>\r\n";
                        ?>
                        <tr>
                            <td colspan="12" class="paging"><?php echo($paging_block);?></td>
                        </tr>
                        <tr>
                            <td class="col-head2" style="width:20%;"><a href="<?php echo($page_name);?>?field=caller_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Caller ID</a></td>
                            <td class="col-head2" style="width:12%;"><a href="<?php echo($page_name);?>?field=call_duration&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Duration</a></td>
                            <td class="col-head2" style="width:15%;"><a href="<?php echo($page_name);?>?field=full_name&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Agent<br>Name</a></td>
                            <td class="col-head2" style="width:10%;"><a href="<?php echo($page_name);?>?field=call_type&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Call<br>Type</a></td>
                            <td class="col-head2" style="width:18%;"><a href="<?php echo($page_name);?>?field=unique_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Call ID</a></td>
                            <td class="col-head2" style="width:10%;"><a href="<?php echo($page_name);?>?field=call_type&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Work<br>Code</a></td>
                            <td class="col-head2"><a href="<?php echo($page_name);?>?field=uniqueid&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Evaluation Status</a></td>
                        </tr>
                    </thead>
                </table>
                <div class="box-container" style="overflow:auto; height:600px;">
                    <table class="table-short">
                        <tbody>
                            <?php while(!$rs->EOF){ ?>
                            <tr class="odd">
                                <?php $stringData2 .= $rs->fields['caller_id'].",".$rs->fields['call_duration'].",".$rs->fields['full_name'].",".substr($rs->fields['call_type'],0,1).'-'.substr($rs->fields["call_status"],0,1).",".$rs->fields['unique_id'];?>
                                <td class="col-first"><a title="click here to download" target="_blank" href="recording/<?php echo date('Ymd',strtotime($rs->fields["call_date"])).'/'.$rs->fields["userfield"]; ?>.wav" ><?php echo $rs->fields["caller_id"]; ?> </a></td>
                                <td class="col-first"><?php echo $rs->fields["call_duration"]; ?> </td>
                                <td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>
                                <td class="col-first"><?php echo substr($rs->fields["call_type"],0,1); ?>-<?php echo substr($rs->fields["call_status"],0,1); ?> </td>
                                
                                <?php
                                    if ($cc_evaluation->is_score_exist($rs->fields["unique_id"]) == true){
                                        $stringData2 .= ",Evaluated";
                                        $call_eval_status = "Evaluated";
                                        $link_call_eval_status = "javascript:return popitup('call_scoring_report.php?unique_id=".$rs->fields["unique_id"]."&agent_name=".$rs->fields["full_name"]."&duration=".$rs->fields["call_duration"]."&call_type=".$rs->fields["call_type"]."&calldate=".$rs->fields["calldate"]."');";
                                        $link_call_id = "javascript:return popitup('calc_eval.php?unique_id=".$rs->fields["unique_id"]."&evaluate_agent_id=".$rs->fields["staff_id"]."&evaluated=true&duration=".$rs->fields["call_duration"]."&call_type=".$rs->fields["call_type"]."');";
                                    }
                                    else{
                                        $stringData2 .= ",Not Evaluated";
                                        $call_eval_status = "Not Evaluated";
                                        $link_call_id = "javascript:return popitup('calc_eval.php?unique_id=".$rs->fields["unique_id"]."&evaluate_agent_id=".$rs->fields["staff_id"]."&duration=".$rs->fields["call_duration"]."&call_type=".$rs->fields["call_type"]."&calldate=".$rs->fields["call_date"]."');";
                                    }
                                ?>
                                <td class="col-first"><a href="" onclick="<?php echo $link_call_id;?>" ><?php echo $rs->fields["unique_id"]; ?></a></td>
                                <?php
                                $rsw = $user_tools->get_call_workcodes($rs->fields['unique_id']);
                                $i = 1;
                                $workcodes = "";$workcodes2 = "";
                                while (!$rsw->EOF){
                                    $workcodes .= "\r\n".$i."- ".$rsw->fields['workcodes'];
                                    $workcodes2 .= $i."- ".$rsw->fields['workcodes']."  ";
                                    $i++;
                                    $rsw->MoveNext();
                                }
                                $stringData2 .= ",".$workcodes2."\r\n";
                                ?>
                                <td class="col-first"><a name="<?php echo $workcodes;?>" href="#" onclick="showWorkCode(this.name)" >View</a></td>
                                <td class="col-first">
                                <?php
                                        if ($call_eval_status == "Evaluated"){?>

                                                <a href="" onclick="<?php echo $link_call_eval_status;?>" ><?php echo $call_eval_status; ?></a>
                                <?php	}
                                        else{
                                                echo $call_eval_status;
                                        }
                                 ?>
                                </td>
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
    <?php
	$stringData2 = str_replace('"','\'',$stringData2 );
    ?>
  </div>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">
    <div style="float:right">
        <a class="button" href="javascript:document.xForm3.submit();" ><span>Export PDF</span></a>
        <input type="hidden" value="exportpdf" id="export_pdf" name="export_pdf" />
        <input type="hidden" value="<?php echo $stringData2; ?>" id="stringData2" name="stringData2" />
    </div>
</form>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2">
    <div style="float:right">
        <a class="button" href="javascript:document.xForm2.submit();" ><span>Export EXCEL</span></a>
        <input type="hidden" value="export >>" id="export" name="export" />
        <input type="hidden" value="<?php echo $stringData2; ?>" id="stringData2" name="stringData2" />
    </div>
</form>

<?php include($site_admin_root."includes/footer.php"); ?>
