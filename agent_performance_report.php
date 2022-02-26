<?php include_once("includes/config.php"); ?>

<?php
	$page_name = "agent_performance_report.php";
	$page_title = "Agent Performance Report";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Agent Performance Report";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php //include($site_root."includes/iheader.php"); ?>	
<html>
<head>
<script type="text/javascript">
function getHtml4Excel()
{
//var x;
//x=document.getElementsByTagName("html")[0].innerHTML;
//x=document.documentElement.innerHTML;
document.getElementById("gethtml1").value = document.getElementsByTagName("body")[0].innerHTML;
//alert(document.documentElement.innerHTML);
}
function getHtml4Pdf()
{
//var x;
//x=document.getElementsByTagName("html")[0].innerHTML;
//x=document.documentElement.innerHTML;
document.getElementById("gethtml2").value = document.getElementsByTagName("body")[0].innerHTML;
//alert(document.documentElement.innerHTML);
}
</script>
</head>
<body>
<?php

//include 'include/config.php';
include 'include/db_info.php';
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
/************************* Export to Excel ******************/
if(isset($_REQUEST['export']))
{
	
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	$stringData	= $_REQUEST['gethtml1'];
	//$stringData = str_replace("Â"," ",$stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData); 
	//$stringData = preg_replace('/<img class="graph" src="data:image/ (.*) \/>/isU', '', $stringData);
	//echo $stringData."asdasd";exit;
	/*$stringData = str_replace('<tag1>',null,$stringData);
	$stringData = str_replace('</tag1>',null,$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);*/

	$db_export_fix = $site_root."download/Agent_Performance_Report.xls";
	//echo $stringData; exit;
	shell_exec("echo '".$stringData."' > ".$db_export_fix);
		
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
/************************* Export to Pdf ******************/
if(isset($_REQUEST['export_pdf']))
{
	
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	$stringData	= $_REQUEST['gethtml2'];
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	//$stringData = preg_replace('/<img class="graph" src="data:image/ (.*)\/>/isU', '', $stringData);
	//echo $stringData;exit;
	ob_end_clean();
	$content = "<page>".$stringData."</page>"; 
	
    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('L','A4','en');
	$html2pdf->pdf->SetDisplayMode('fullwidth');
    $html2pdf->WriteHTML($content);// 2nd parameter is boolean value for debugging
    $html2pdf->Output('Agent_Performance_Report.pdf', 'D');
}

//$agent_id = '9027';
//$sdate = '2012-01-01';
//$edate = '2012-01-31';
$agent_id = $_REQUEST['search_keyword'];
$sdate = $_REQUEST['fdate'];
$edate = $_REQUEST['tdate'];
$group_count = 0;
$group_name = '';
//$arr_group_name = array('Standard Procedures','Understanding & Delivery','Call Handling','Quality');
$WeekSum = array(0,0,0,0);
$WeekSumTotal_h = 0; //For overall score
$WeekSumTotal_v = 0; //vertical summation and then total
$WeekSumAvg = array(0,0,0,0); //For overall score
$week_iterator = 0; //For overall score
$col = array(0,0,0,0);//For overall score
$WeekTotal = 0;
$MonthTotal = 0;
$QuestionTotal = 0;
$QuestionRow = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
$ScoredWeeks = 0;
$html = '';

//This is the agent information and summary
$rs_agent_name = "SELECT full_name FROM cc_admin where admin_id = '".$agent_id."' and status = '1' ";
$agent_name_result = mysql_query($rs_agent_name);
$agent_name = mysql_fetch_assoc($agent_name_result);

////echo $rs_agent_name;
////echo $agent_name['full_name'];
//
//	$query = "SELECT ROUND(SUM(scores)/COUNT(S.unique_id)) AS Score, full_name FROM cc_evaluation_scores S INNER JOIN cc_admin A ON S.evaluate_agent_id = A.admin_id INNER JOIN cc_cdr C ON S.unique_id = C.uniqueid";
//	$query .= " WHERE A.admin_id = '" .$agent_id. "' AND DATE(C.calldate) BETWEEN '".$sdate."' AND '".$edate."' GROUP BY full_name";
//
//	$info_result = mysql_query($query);
//	$num_rows = mysql_num_rows($info_result);



//////////////////////////////////////////////////////
$html .= "<table style='background-color:#E8E8DD; border-style:solid; border-color:#3A4043' cellspacing=0 cellpadding=0><tr style='background-color: #3A4043;font-size: 16px; color:#FFFFFF; font-family: Arial, Helvetica, sans-serif;font-weight:bold;text-align:center'><td colspan=2>Agent Performance Report</td></tr>";
	$html .= "<tr><td style='border-right:solid'>";
//	if($num_rows>0){
//		$inforow = mysql_fetch_assoc($info_result);
//		$html .= "<table>";
//		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Agent Name:</font></td>";
//		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$agent_name['full_name']."</b></font></td></tr>";
//		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Evaluation Period :</font></td>";
//		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$sdate." -- ".$edate."</b></font></td></tr>";
//		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Call Performance Score :</font></td>";
//		
//		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$inforow['Score']."%</b></font></td></tr>";
//		$html .= "</table>";
//	} else {
		$html .= "<table>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Agent Name:</font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$agent_name['full_name']."&nbsp;</b></font></td></tr>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Evaluation Period :</font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$sdate." -- ".$edate."</b></font></td></tr>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Call Performance Score :</font></td>";
		$html .= "<td align='left'><font size='2' face=' Arial, Helvetica, sans-serif'><b>call_perf_score</b></font></td></tr>";
		$html .= "</table>";
//	}
	$html .= "</td>";
	
	//Call summary column

//	$query = "SELECT SUM(IF(call_type='INBOUND' AND no_of_questions IS NULL,1,0)) AS UN_InBound, SUM(IF(call_type='OUTBOUND' AND no_of_questions IS NULL,1,0)) AS UN_OutBound, ";
//	$query .= "SUM(IF(call_type='INBOUND' AND no_of_questions IS NOT NULL,1,0)) AS InBound, SUM(IF(call_type='OUTBOUND' AND no_of_questions IS NOT NULL,1,0)) AS OutBound ";
//	$query .= "FROM cc_vu_evaluated_calls ";
//	$query .= "WHERE staff_id = '" .$agent_id. "' AND DATE(update_datetime) BETWEEN '".$sdate."' AND '".$edate."'";

	$query = "SELECT SUM(IF(call_type='INBOUND' AND no_of_questions IS NULL,1,0)) AS UN_InBound, SUM(IF(call_type='OUTBOUND' AND no_of_questions IS NULL,1,0)) AS UN_OutBound, ";
	$query .= "SUM(IF(call_type='INBOUND' AND no_of_questions IS NOT NULL,1,0)) AS InBound, SUM(IF(call_type='OUTBOUND' AND no_of_questions IS NOT NULL,1,0)) AS OutBound ";
	$query .= "FROM cc_vu_evaluated_calls ";
	$query .= "WHERE staff_id = '" .$agent_id. "' AND
	TIMEDIFF(staff_end_datetime,staff_start_datetime) <> '00:00:00'
	AND DATE(update_datetime) BETWEEN '".$sdate."' AND '".$edate."'";

	$call_result = mysql_query($query);
	$num_rows = mysql_num_rows($call_result);
	
	$html .= "<td>";	
	$html .= "<table>";
	$html .= "<tr bgcolor=#CCCCCC><td><font size='2' face=' Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
	$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'>Calls Taken</font></td>";
	$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'>Evaluated</font></td></tr>";
		
	if($num_rows>0){
		$callrow = mysql_fetch_assoc($call_result);
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Incoming</font></td>";
		$html .= "<td align=center><font size='2' face=' Arial, Helvetica, sans-serif'><b>".($callrow['UN_InBound'] + $callrow['InBound'] )."</b></font></td>";
		$html .= "<td align=center><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$callrow['InBound']."</b></font></td></tr>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Outgoing</font></td>";
		$html .= "<td align=center><font size='2' face=' Arial, Helvetica, sans-serif'><b>".($callrow['UN_OutBound'] + $callrow['OutBound'] )."</b></font></td>";
		$html .= "<td align=center><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$callrow['OutBound']."</b></font></td></tr>";
	} else {
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Incoming</font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>&nbsp;</b></font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>&nbsp;</b></font></td></tr>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Outgoing</font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>&nbsp;</b></font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>&nbsp;</b></font></td></tr>";
	}
	$html .= "</table>";	
	$html .= "</td>";
	
	$html .= "</td></tr>";
	$html .= "</table><br />";
//////////////////////////////////////////////////////

$html2 = "<br><table style='width:60%;background-color:#E8E8DD; border:solid #3A4043;font-family: Arial, Helvetica, sans-serif;font-size:12px' cellspacing='2' cellpadding='2'>
			<tr>
				<th width='20%'>
				<font size='2' face='Arial, Helvetica, sans-serif'>OVERALL SCORE</font>
				</th>
				<th width='10%'>&nbsp;</th><th width='10%'>&nbsp;</th><th width='10%'>&nbsp;</th><th width='10%'>&nbsp;</th>
			</tr>
			<tr>
				<th width='20%'>&nbsp;</th><th width='10%'>Week 1</th><th width='10%'>Week 2</th><th width='10%'>Week 3</th><th width='10%'>Week 4</th><th width='10%'>&nbsp;</th>
			</tr>";
			
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//We need to repeat the code starting from
//////////////////////////////////////////////////////////////////////////////////H E R E /////////////////////////////////////////////////////////////////
//master table
//four categroies of questions

$html .= '<table style="width:60%; border:solid #000000;"><tr>';

    for($iLoop=1;$iLoop<=4;$iLoop++)
    {
		$query = "SELECT group_id, group_name, question_code, question FROM cc_evaluation_questions Q, cc_evaluation_groups G WHERE  G.id = Q.group_id AND group_id = " .$iLoop. " Order by Q.id";
		
		$result = mysql_query($query);
		
		
		// Check result
		// This shows the actual query sent to MySQL, and the error. Useful for debugging.
		
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		} 
		
		//fetching question codes and group names
		$index=0;
		while ($row = mysql_fetch_assoc($result))
		 { 
		 	$question_code[$index] =  $row['question_code'];
			$group_name = $row['group_name'];
			$index++;	
		}

		$html .= "<td>";
		$html .= "<table style='background-color:#E8E8DD; border-style:solid; border-color:#3A4043;font-family: Arial, Helvetica, sans-serif;font-size:12px' cellspacing='2' cellpadding='2' width='100%' height='200px'>";
		$html .= "<tr style='background-color: #3A4043; font-size:12px; color:#FFFFFF'>";
		$html .= "<th width='30%' style='padding:5px 5px 5px 5px;'><font face='Arial, Helvetica, sans-serif'>".$group_name."</font></th>";
		$html .= "<th width='14%' style='padding:5px 5px 5px 5px;'><font face='Arial, Helvetica, sans-serif'>Average</font></th>";
		$html .= "</tr>";
		
		$html .= "<p>";
		  		
		$html .= "<tr><td>";
		
		//Internal Master Question table
		if ($result) $html .= "<table border=0><tr><td>&nbsp;</td></tr>";
		
		//printing questions codes
		$index2 = 0;
		while ($index2 < $index/*$row = mysql_fetch_assoc($result)*/)
		{ 
		
			$html .= "<tr><td><font size='2' face='Arial, Helvetica, sans-serif'>" .$question_code[$index2] /*$row['question_code'] */. "</font></td></tr>";
			$group_count = $group_count + 1;
			//$group_name = $row['group_name'];	
			//echo $group_name;
			$index2++;
		}
		 
		if (mysql_num_rows($result) < 6)
		{	
			$exp =  6 - mysql_num_rows($result);	
			//echo $exp;
			for ($p=1; $p <= $exp;$p++)
			{
				$html .= "<tr><td><font size='2' face='Arial, Helvetica, sans-serif'>&nbsp;</font></td></tr>";
			}
		}
		
		if ($result) $html .= "</table></td>";
		
		
			//Internal Week table
			// Fetch Week wise result
			for ($i=1; $i<=4; $i++)
			{
		
				$Week_query = "SELECT Question_code, ROUND(SUM(ePoints) / SUM(Maxpoints) * 100) AS Score, SUM(IF(points_type='yes',Qcount,0)) AS Yes, SUM(IF(points_type='no',Qcount,0)) AS 'No', SUM(IF(points_type='nimp',Qcount,0)) AS nimp, ";
				$Week_query = $Week_query . "SUM(IF(points_type='na',Qcount,0)) AS NA FROM cc_vu_evaluation WHERE evaluate_agent_id = '" . $agent_id . "' AND CallDate BETWEEN '".$sdate."' AND '".$edate."' ";
				$Week_query = $Week_query . "AND WEEK = " . $i . " AND qGroup = ".$iLoop. " GROUP BY question_code ORDER BY question_no";
		
				//echo $Week_query;
				$week_result = mysql_query($Week_query);
				$num_rows = mysql_num_rows($week_result);

				
				if($num_rows == 0){
					for($j=1;$j<=$group_count;$j++)
					{
						//$WeekSum[i] = 0;
						$WeekTotal = 0;
						$QuestionRow[$j-1] = (int)$QuestionRow[$j-1];
					}
				}
				else{
				    //variable for question reference looping
					$l = 0;
					$ScoredWeeks = $ScoredWeeks + 1;
					while ($week_row = mysql_fetch_assoc($week_result)) { 
					    $QuestionRow[$l] = (int)$QuestionRow[$l] + (int)$week_row['Score'];
						
						$WeekTotal = (int)$WeekTotal + (int)$week_row['Score'];
						//different categories count
						$yes_count += $week_row['Yes'];
						$no_count += $week_row['No'];
						$n_imp += $week_row['nimp'];
						$l = $l + 1;
					}
				}	
				//$WeekSum[$i-1] = round(((int)$WeekTotal)/$group_count);
				$WeekSum[$i-1] = round((((($yes_count * 3) + ($n_imp * 2) - ($no_count*1)) / (($yes_count + $n_imp + $no_count) * 3))) * 100);
				//$uper_sum = (($yes_count * 3) + ($n_imp * 2) - ($no_count*1));
				//$lowe_sum = (($yes_count + $n_imp + $no_count) * 3));
				
				$WeekTotal = 0;	
				$yes_count = 0;
				$n_imp = 0;
				$no_count = 0;
			}
			
			//here will come the summary for the question
			$html .= "<td align='center'><table border='0px'>";
			$html .= "<tr><td>&nbsp;</td></tr>";
			//echo $group_count;
			//echo $group_count;
			for($k=0;$k<$group_count;$k++)
			{
			
				$html .= "<tr>";
				$html .= "<td align='center' style='border:1px solid'><font size='2' face='Arial, Helvetica, sans-serif'>" . round($QuestionRow[$k]/$ScoredWeeks) . "% </font></td>";
				$html .= "</tr>";
			}
			if ($group_count < 6)
			{	
				$exp =  6 - $group_count;	
				//echo $exp;
				for ($p=1; $p <= $exp;$p++)
				{
					$html .= "<tr style='border:none'><td style='border:none'><font size='2' face='Arial, Helvetica, sans-serif'>&nbsp;</font></td></tr>";
				}
			}
			$html .= "</table></td>";
			//till here
		$html .= "</tr>";

		//here goes the summary for the group
		//we will create a seoerate table here
		
		for($k=0;$k<=3;$k++)
		{
			$MonthTotal = $MonthTotal + $WeekSum[$k];
		}
		//$uper_sum = 0;
		//$lowe_sum = 0;
		
		$html .= "</td></tr>";	
		$html .= "</table>";
		$html .= "</td>";
		if ($iLoop == 2)$html .= '</tr>';
		//Overall Score Tsble Start
		$html2 .= "<tr>";
		$html2 .= "<td>".$group_name."</td>";
	
	//Column wise summation
		for ($i=0;$i<4;$i++)
		{
			$html2 .= "<td align='center'>".$WeekSum[$i]." %</td>";
			$WeekSumTotal_h += $WeekSum[$i];
			
			if ($i == 3) 
			{
				$html2 .= "<td style='border-left:1px solid #3A4043;' align='left'>&nbsp;".($WeekSumTotal_h / 4)." %</td>";
			}
			if ($i == 0)
			{
				$col[$i] += $WeekSum[$i];
			}	
			if ($i == 1)
			{
				$col[$i] += $WeekSum[$i];
			}	
			if ($i == 2)
			{
				$col[$i] += $WeekSum[$i];
			}	
			if ($i == 3)
			{
				$col[$i] += $WeekSum[$i];
				
			}	
		}
		
		$html2 .= "</tr>";
		
		
		mysql_free_result($week_result);
		mysql_free_result($result);
		$group_count=0;
		$MonthTotal = 0;
		$QuestionRow = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
		$ScoredWeeks = 0;
		$WeekSumTotal_h =0;//for overall score
	}
	
	$html .= "</tr></table>";
		$html2 .= "<tr><td>&nbsp;</td>";
		for ($i=0; $i<4; $i++)
		{
			$html2 .= "<td style='border-top:1px solid #3A4043;' align='center'>";
			$html2 .= ($col[$i] / 4);
			$html2 .= " %</td>";
			$var_temp = ($col[$i] / 4);
			$WeekSumTotal_v += $var_temp;
			
		}
		$html2 .= "<td style='border-top:1px solid #3A4043;border-left:1px solid #3A4043;' align='left'>";
		$html2 .= (round($WeekSumTotal_v / 4))." %</td>";
		
		$html2 .= "</tr>";
		$html2 .= "</table>"; // Overall Score table End
		
//////////////////////////////////////////////////////////////////////////////////T O H E R E /////////////////////////////////////////////////////////////
//in a loop
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$html = str_replace("call_perf_score", (round($WeekSumTotal_v / 4))."%", $html);
	$html = $html."".$html2;
	echo $html;
	
	/*$db_export_fix = $site_root."download/WeeklyReport.xls";

	//echo $db_export_fix;
	
	
	echo shell_exec("echo '".trim($html)."' > ".$db_export_fix); 
		
    ob_end_clean();
	header('Content-disposition: attachment; filename='.basename($db_export_fix));
	header('Content-type: text/csv');
	readfile($db_export_fix);*/
	
	//echo $html;

?>

<!--<textarea id="ta" name="ta">tyt</textarea>-->

<!--<button onClick="myFunction()">Get HTML</button>-->
</body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onSubmit="">

  <div style="float:right; padding-top:15px;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>
	  <input type="hidden" value="<?php echo $agent_id; ?>" id="search_keyword" name="search_keyword" />
	  <input type="hidden" value="<?php echo $edate; ?>" 	id="tdate" 	name="tdate" />
	  <input type="hidden" value="<?php echo $sdate; ?>" 	id="fdate" 	name="fdate" />
  </div>
  <!--<input type="submit" onClick="myFunction()" value="Export" />-->
</form>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2" onSubmit="">

  <div style="float:right; margin-right:10px;">
	<a onClick="getHtml4Pdf()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT PDF</span>
	</a>
	  <input type="hidden" value="export_pdf" id="export_pdf" name="export_pdf" />
  	  <input type="hidden" id="gethtml2" name="gethtml2"/>
	  <input type="hidden" value="<?php echo $agent_id; ?>" id="search_keyword" name="search_keyword" />
	  <input type="hidden" value="<?php echo $edate; ?>" 	id="tdate" 	name="tdate" />
	  <input type="hidden" value="<?php echo $sdate; ?>" 	id="fdate" 	name="fdate" />
  </div>
  <!--<input type="submit" onClick="myFunction()" value="Export" />-->
</form>
</html>
