<?php include_once("includes/config.php"); ?>

<?php
	$page_name = "report1.php";
	$page_title = "Agent Performance Weekly Report";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Agent Performance Weekly Report";
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
	//echo $stringData."asdasd";exit;
	/*$stringData = str_replace('<tag1>',null,$stringData);
	$stringData = str_replace('</tag1>',null,$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);*/

	$db_export_fix = $site_root."download/Agent_Performance_Weekly_Report.xls";
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
	//echo $stringData;exit;
	ob_end_clean();
	$content = "<page>".$stringData."</page>"; 
	
    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('L','A4','en');
	$html2pdf->pdf->SetDisplayMode('fullwidth');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Agent_Performance_Weekly_Report.pdf', 'D');
}

//$agent_id = '9027';
//$sdate = '2012-01-01';
//$edate = '2012-01-31';
$agent_id = $_REQUEST['search_keyword'];
$sdate = $_REQUEST['fdate'];
$edate = $_REQUEST['tdate'];
$group_count = 0;
$group_name = '';
$WeekSum = array(0,0,0,0);
$WeekTotal = 0;
$MonthTotal = 0;
$QuestionTotal = 0;
$QuestionRow = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
$ScoredWeeks = 0;
$html = '';
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//We need to repeat the code starting from
//////////////////////////////////////////////////////////////////////////////////H E R E /////////////////////////////////////////////////////////////////
//master table
//four categroies of questions
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
		

		$html .= "<table style='background-color:#E8E8DD; border-style:solid; border-color:#3A4043' cellspacing='2' cellpadding='2' width='100%'>";
		$html .= "<tr style='background-color: #3A4043;font-size: 1px; color:#FFFFFF'>";
//		$html .= "<th width='30%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></th>";
//		$html .= "<th width='14%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week 1</font></th>";
//		$html .= "<th width='14%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week 2</font></th>";
//		$html .= "<th width='14%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week 3</font></th>";
//		$html .= "<th width='14%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week 4</font></th>";
	$html .= "<th width='14%'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Average</font></th>";
	$html .= "</tr>";
		
//		$html .= "<p>";
		  		
		$html .= "<tr><td style='border-bottom:solid;border-color:#3A4043'>";
		
		//Internal Master Question table
		if ($result) //$html .= "<table border=0><tr><td>&nbsp;</td></tr>";
		
		while ($row = mysql_fetch_assoc($result)) { 
//			$html .= "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $row['question_code'] . "</font></td></tr>";
			$group_count = $group_count + 1;
			$group_name = $row['group_name'];
		}
		
		if ($result) //$html .= "</table></td>";
		
		
			//Internal Week table
			// Fetch Week wise result
			for ($i=1; $i<=4; $i++)
			{
				//$html .= "<td  style='border-bottom:solid;border-color:#3A4043' align='center'><table border='1px'>";
				//echo "<tr><td>Week " . $i . "</td></tr>";
		
				$Week_query = "SELECT Question_code, ROUND(SUM(ePoints) / SUM(Maxpoints) * 100) AS Score, SUM(IF(points_type='yes',Qcount,0)) AS Yes, SUM(IF(points_type='no',Qcount,0)) AS 'No', SUM(IF(points_type='nimp',Qcount,0)) AS nimp, ";
				$Week_query = $Week_query . "SUM(IF(points_type='na',Qcount,0)) AS NA FROM cc_vu_evaluation WHERE evaluate_agent_id = '" . $agent_id . "' AND CallDate BETWEEN '".$sdate."' AND '".$edate."' ";
				$Week_query = $Week_query . "AND WEEK = " . $i . " AND qGroup = ".$iLoop. " GROUP BY question_code ORDER BY question_no";
		
				//echo $Week_query;
				$week_result = mysql_query($Week_query);
				$num_rows = mysql_num_rows($week_result);
				
//				$html .= "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Yes</font></td>";
//				$html .= "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>No</font></td>";
//				$html .= "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>N.Imp</font></td>";
//				$html .= "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>NA</font></td>";
//				$html .= "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Score</font></td></tr>";
				
				if($num_rows == 0){
					for($j=1;$j<=$group_count;$j++)
					{
//						$html .= "<tr>";
//						$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
//						$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
//						$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
//						$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
//						$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
//						$html .= "</tr>";
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
					$html .= "<tr>";
//						$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['Yes'] . " </font></td>";
//						$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['No']  . " </font></td>";
//						$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['nimp']  . " </font></td>";
//						$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['NA']  . " </font></td>";
						$html .= "<td bgcolor='#CCCCCC' align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['Score'] . "% </font></td>";
					$html .= "</tr>";
						
						$WeekTotal = (int)$WeekTotal + (int)$week_row['Score'];
						//different categories count
						$yes_count += $week_row['Yes'];
						$no_count += $week_row['No'];
						$n_imp += $week_row['nimp'];
						$l = $l + 1;
					}
				}		
				$html .= "</table></td>";
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
//			$html .= "<td  style='border-bottom:solid;border-color:#3A4043' align='center'><table border='1px'>";
//			$html .= "<tr><td>&nbsp;</td></tr>";
			for($k=0;$k<$group_count;$k++)
			{
//				$html .= "<tr>";
//				$html .= "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . round($QuestionRow[$k]/$ScoredWeeks) . "% </font></td>";
//				$html .= "</tr>";
			}
//			$html .= "</table></td>";
			//till here
//		$html .= "</tr>";

		//here goes the summary for the group
		//we will create a seoerate table here
//		$html .= "<tr><td>";
		
//		$html .= "<table width='100%'>";
//		$html .= "<tr><td colspan='3'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>" .$group_name . "</b></td></tr>";
		//echo "<tr><td>&nbsp;</td>";
		
		for($k=0;$k<=3;$k++)
		{
//			$html .= "<tr><td>&nbsp;</td><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week ".($k+1)."</font></td><td align='left'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>";
//			$html .= $WeekSum[$k];
			//." ---- ".$uper_sum." ---- ".$lowe_sum;
			
//			$html .= "</font></td></tr>";
			$MonthTotal = $MonthTotal + $WeekSum[$k];
		}
		//$uper_sum = 0;
		//$lowe_sum = 0;
		$html .= "<table><tr><td>&nbsp;</td><td>&nbsp;</td><td><b><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>".round($MonthTotal/$ScoredWeeks)."</b></font></td></tr></table>";
//		$html .= "</table>";
//		
//		$html .= "</td></tr>";
		
		
//		$html .= "</table>";
		mysql_free_result($week_result);
		mysql_free_result($result);
		$group_count=0;
		$MonthTotal = 0;
		$QuestionRow = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
		$ScoredWeeks = 0;
	}
//////////////////////////////////////////////////////////////////////////////////T O H E R E /////////////////////////////////////////////////////////////
//in a loop
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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