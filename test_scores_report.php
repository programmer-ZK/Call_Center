<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "test_scores_report.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Test Scores Report";
        $page_menu_title = "Test Scores Report";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
	
	include_once("classes/admin.php");
    $admin = new admin();
	
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
	
	include_once("classes/cc_evaluation.php");
	$cc_evaluation = new cc_evaluation();
	/*require("../fpdf17/fpdf.php");
	require("/classes/pdfgen.php");*/
?>	

<html>
<head>
<!--<link href="css/style.css" rel="stylesheet" type="text/css" />-->
<script type="text/javascript">
function getHtml4Excel()
{
//var x;
//x=document.getElementsByTagName("html")[0].innerHTML;
//x=document.documentElement.innerHTML;
document.getElementById("gethtml1").value = document.getElementById("tscore_report").innerHTML;
//alert(document.getElementById("gethtml1").value);
}
function getHtml4Pdf()
{
//var x;
//x=document.getElementsByTagName("html")[0].innerHTML;
//x=document.documentElement.innerHTML;
document.getElementById("gethtml2").value = document.getElementById("tscore_report").innerHTML;
//alert(document.documentElement.innerHTML);
}
function showComment(comment)
{
	if(comment || 0 !== comment.length)
	{
		alert("Comment: "+comment);
	}
	else
	{
		alert("No comments available!");
	}
}
/*function reloadPage()
{
alert("asdasd");
window.location.reload();
}*/

</script>
</head>
<body>  

<?php
    
/************************* Export to Excel ******************/
if(isset($_REQUEST['export']))
{
	
/*	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];*/
	$stringData	= $_REQUEST['gethtml1'];
	$stringData = preg_replace('/Â/','',$stringData);
	$stringData = preg_replace('/<form(.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData); 
	//echo $stringData."asdasd";exit;
	/*$stringData = str_replace('<tag1>',null,$stringData);
	$stringData = str_replace('</tag1>',null,$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);*/

	$db_export_fix = $site_root."download/test_scores_report.xls";
	//echo $stringData; exit;
	shell_exec("echo '".$stringData."' > ".$db_export_fix);
		
	ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    //header("Content-type: application/force-download");
    //header("Content-Type: text/csv");
	header("Content-Type: application/ms-excel");
    
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
/************************* Export to Pdf ******************/
if(isset($_REQUEST['export_pdf']))
{
	
/*	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];*/
	$stringData	= $_REQUEST['gethtml2'];
	$stringData = preg_replace('/Â/','',$stringData);
	$stringData = preg_replace('/<form(.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	//echo $stringData;exit;
	ob_end_clean();
	$content = "<page>".$stringData."</page>"; 
	
    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('L','A4','en');
	$html2pdf->pdf->SetDisplayMode('fullwidth');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('test_scores_report.pdf', 'D');
}
	
	$startRec = 0;
	$totalRec = 0;
	$test_code = $_REQUEST['test_code'];
	$fdate = $_REQUEST['fdate'];
	$tdate = $_REQUEST['tdate'];
	$agent_id = $_REQUEST['search_keyword'];
	

	
	//----- Test scores report-----//
	$rs1 = $cc_evaluation->get_evaluation_test_scores($test_code, $startRec, $totalRec, "test_date", "asc", $fdate, $tdate, $agent_id);
	
	$rs2 = $cc_evaluation->get_distinct_testnames($test_code, $startRec, $totalRec, "test_date", "desc", $fdate, $tdate);
	
	$rs3 = $cc_evaluation->get_test_agents($agent_id, /*$test_code,*/ "test_date", "asc", $fdate, $tdate);
	
	if (!empty($agent_id) && $agent_id != 0){
	
		$rs4 = $admin->get_agent_name($agent_id);
	}
	//---------------------------//
?>	
<div id="tscore_report">
<div style="width:290; margin-top:20px;margin-left:20px;font-family:Arial, Helvetica, sans-serif">
<h3>Test Scores Report</h3>
<table style=' border-style:solid; width:290; background-color:#E8E8DD;' >
<tbody>
<tr><td style='padding-top:10'><h3 style='color:#000000;font-size:12px;'  >From Date:&nbsp;<?= $fdate?></h3><h3 style='color:#000000;font-size:12px;' >To Date:&nbsp;<?= $tdate?></h3><h3 style='color:#000000;font-size:12px;' >Agent Name:&nbsp;<?php $var1 = (!empty($agent_id) && $agent_id != 0)?strtoupper($rs4->fields['full_name']):"---"; echo $var1;?></h3><h3 style='color:#000000;font-size:12px;' >Test Code:&nbsp;<?php $var2 = $test_code=='0'?"---":strtoupper($test_code); echo $var2;?></h3></td></tr>
</tbody>
</table>
</div>

<br>

<div id="test_scores_report" name="test_scores_report" style="width:auto; height:auto; margin-top:20px;margin-left:20px;font-family:Arial, Helvetica, sans-serif">
<table id="tscore_report" style="background-color:#F3F3F3; border:2px solid #000000; width:100%; border-collapse:collapse;">
	<thead>
		<tr style="background-color:#5B6366;">
		<td style="border:1px solid #3A4043; color:#FFFFFF; text-align:center;">TEST CODE</td>
		<td style="border:1px solid #3A4043; color:#FFFFFF; text-align:center;">TEST NAME</td>
		<?php $count_agents = 0; $i = 0; while(!$rs3->EOF){?>
			<td style="border:1px solid #3A4043; color:#FFFFFF; padding:5px 10px 5px 10px; text-align:center;"><?php $agents[$i] = $rs3->fields["agent_id"];  echo strtoupper($rs3->fields["full_name"]); ?></td>
		<?php $rs3->MoveNext(); $count_agents = $i; $i++; } ?>
		</tr> 
	</thead>
	<tbody>
		<?php
		while(!$rs2->EOF)
		{
			echo '<tr><td style="background-color:#5B6366; border:1px solid #3A4043; color:#FFFFFF; padding:5px 10px 5px 10px;">'. strtoupper($rs2->fields["distinct_tcode"]) .'</td><td style="background-color:#5B6366; border:1px solid #3A4043; color:#FFFFFF; padding:5px 10px 5px 10px;">'. strtoupper($rs2->fields["distinct_tname"]) .'</td>';
			
			$j = 0; $count_scores = 0;
			
			while(/*!$rs1->EOF*/ $j <= $count_agents)
			{ 
			//echo $j."- ".$agents[$j].", ";
				if ($agents[$j] == $rs1->fields["agent_id"])
				{
					//echo $rs2->fields["distinct_tname"];
					//echo $rs1->fields["test_score"];
				 	if($rs2->fields["distinct_tname"] == $rs1->fields["test_name"] )
				 	{
						echo '<td style="border:1px solid #3A4043; padding:5px 10px 5px 10px;text-align:center;"><a name="'.$rs1->fields['comment'].'"  onClick="showComment(this.name)" href="#">'.$rs1->fields["test_score"].'</a></td>';
						$rs1->MoveNext(); 
					
					}
				}
				else
				{
					echo '<td style="border:1px solid #3A4043; text-align:center;">&nbsp;</td>';
				}
				if ($count_agents == $count_scores){
					
					echo '</tr>';
					//$j=-1;
					break;
				}
				
				$j++;
				$count_scores = $j;	
			}
		
			//echo "</tr>";
			$rs2->MoveNext();
		}
		?>  
	</tbody>
</table>  
</div>
</div>	
</body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm1" id="xForm1" onSubmit="">

  <div style="float:left;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm1.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; margin:15px 0 0 20px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>
  </div>
</form>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2" onSubmit="">

  <div style="float:left; margin-left:10px;">
	<a onClick="getHtml4Pdf()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT PDF</span>
	</a>
	  <input type="hidden" value="export_pdf" id="export_pdf" name="export_pdf" />
  	  <input type="hidden" id="gethtml2" name="gethtml2"/>
  </div>
</form>



