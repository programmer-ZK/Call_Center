<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "report2.php";
	$page_title = "Agent Weeks Performance Trend";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Agent Weeks Performance Trend";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
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

	$db_export_fix = $site_root."download/Agent_Weeks_Performance_Trend.xls";
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
	$html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->WriteHTML($content);
    $html2pdf->Output('Agent_Weeks_Performance_Trend.pdf', 'D');
}

$agent_id = $_REQUEST['search_keyword'];
$sdate = $_REQUEST['fdate'];
$edate = $_REQUEST['tdate'];
$group_name = '';
$week_count = 0;
$cat_count = 0;
$cat_total = 0;
$question_total = 0;
$html='';

//This is the agent information and summary
$rs_agent_name = "SELECT full_name FROM cc_admin where admin_id = '".$agent_id."' and status = '1' ";
$agent_name_result = mysql_query($rs_agent_name);
$agent_name = mysql_fetch_assoc($agent_name_result);

//echo $rs_agent_name;
//echo $agent_name['full_name'];

	$query = "SELECT ROUND(SUM(scores)/COUNT(S.unique_id)) AS Score, full_name FROM cc_evaluation_scores S INNER JOIN cc_admin A ON S.evaluate_agent_id = A.admin_id INNER JOIN cc_cdr C ON S.unique_id = C.uniqueid";
	$query .= " WHERE A.admin_id = '" .$agent_id. "' AND DATE(C.calldate) BETWEEN '".$sdate."' AND '".$edate."' GROUP BY full_name";

	$info_result = mysql_query($query);
	$num_rows = mysql_num_rows($info_result);

	$html .= "<table style='background-color:#E8E8DD; border-style:solid; border-color:#3A4043' cellspacing=0 cellpadding=0><tr style='background-color: #3A4043;font-size: 16px; color:#FFFFFF; font-family: Arial, Helvetica, sans-serif;font-weight:bold;text-align:center'><td colspan=2>Agent Week Performance Trend</td></tr>";
	$html .= "<tr><td style='border-right:solid'>";
	if($num_rows>0){
		$inforow = mysql_fetch_assoc($info_result);
		$html .= "<table>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Agent Name:</font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$agent_name['full_name']."</b></font></td></tr>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Evaluation Period :</font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$sdate." -- ".$edate."</b></font></td></tr>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Call Performance Score :</font></td>";
		
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$inforow['Score']."%</b></font></td></tr>";
		$html .= "</table>";
	} else {
		$html .= "<table>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Agent Name:</font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$agent_name['full_name']."&nbsp;</b></font></td></tr>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Evaluation Period :</font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$sdate." -- ".$edate."</b></font></td></tr>";
		$html .= "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'>Call Performance Score :</font></td>";
		$html .= "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>&nbsp;-</b></font></td></tr>";
		$html .= "</table>";
	}
	$html .= "</td>";
	
	//Call summary column

	//$query = "SELECT SUM(IF(call_type='INBOUND' AND no_of_questions IS NULL,1,0)) AS UN_InBound, SUM(IF(call_type='OUTBOUND' AND no_of_questions IS NULL,1,0)) AS UN_OutBound, ";
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

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//We need to repeat the code starting from
//////////////////////////////////////////////////////////////////////////////////H E R E /////////////////////////////////////////////////////////////////
	
	//master table
	//four categroies of questions
	$html .= "<table style='background-color:#E8E8DD; border-style:solid; border-color:#3A4043' cellpadding=0 cellspacing=0 width='100%'><tr>";
    
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
		
		// Master Category table
		// For each category and question fetch 4 weeks record
		$html .=  "<td style='border-right:solid;padding-left:5px' width='25%' valign='top'>";
		
		//this piece of code will generate its own table
		while ($row = mysql_fetch_assoc($result)) 
		{ 
			if($group_name!=$row['group_name']) {
				if($group_name==''){
					$html .= "<table cellpadding=0 cellspacing=0 width='100%'><tr style='background-color: #3A4043;font-size: 18px; color:#FFFFFF;'><td><b><font size='2' face=' Arial, Helvetica, sans-serif'>".$row['group_name']."</b></font></td>";
					$html .= "<td><b><font size='2' face=' Arial, Helvetica, sans-serif'>".$row['group_name']."V</b></font></td></tr>";
				} 
				$group_name=$row['group_name'];
			}
			$html .=  "<tr><td colspan=2><font size='2' face=' Arial, Helvetica, sans-serif'>&nbsp;</font></td></tr>";
			$html .=  "<tr><td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$row['question_code']."</b></font></td>";
			$html .=  "<td><font size='2' face=' Arial, Helvetica, sans-serif'><b>".$row['question_code']."V</b></font></td></tr>";			
			
			
			//Internal question table
			// Fetch Week wise result
			$html .=  "<tr><td align='left' colspan=2><table cellspacing=0 cellpadding=0 width='100%'>";
		
			$question_query = "SELECT question_no, question_code, ROUND(SUM(ePoints) / SUM(Maxpoints) * 100) AS Score, WEEK As WeekNo ";
			$question_query .= "FROM cc_vu_evaluation ";
			$question_query .= "WHERE evaluate_agent_id = '".$agent_id."' ";
			$question_query .= " AND CallDate BETWEEN '".$sdate."' AND '".$edate."' ";
			$question_query .= " AND qGroup = ".$iLoop;
			$question_query .= " AND question_code = '" .$row['question_code']."' ";
			$question_query .= " GROUP BY WEEK ";
			$question_query .= " ORDER BY WEEK";
			
			$question_result = mysql_query($question_query);
			$num_rows = mysql_num_rows($question_result);
			
			
			//echo "A".$question_result['question_no'];
			if($num_rows == 0){
				for($j=1;$j<=4;$j++)
				{
					$html .=  "<tr>";
					$html .=  "<td align='center'><font size='2' face=' Arial, Helvetica, sans-serif'>Week ".$j."</font></td>";
					$html .=  "<td align='center'><font size='2' face=' Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
					$html .=  "</tr>";
				}
			}
			else
			{
				$weekrow = mysql_fetch_assoc($question_result);
				for($j=1;$j<=4;$j++)
				{
					$html .=  "<tr>";
					$html .=  "<td align='center'><font size='2' face=' Arial, Helvetica, sans-serif'>Week ".$j." </font></td>";
					//echo "J".$question_result['WeekNo'];
					
					if ($weekrow)
					{
						//if(($j==$weekrow['WeekNo']) && !(empty($weekrow['Score'])))
						if($j==$weekrow['WeekNo'])
						{
							$iCol = round((int)$weekrow['Score']/10,0);
							
							for($k=1;$k<=10;$k++)
							{
								if($k<=$iCol){
									$html .=  "<td align='left' bgcolor='#CCCCCC'>&nbsp;</td>";
								}else{
									$html .=  "<td>&nbsp;</td>";
								}
							}
							 //= $week_count + 1;
							
							//if there is some score then add else skip
							if (!(empty($weekrow['Score'])))
							{
								$question_total = $question_total + $weekrow['Score'];
								$cat_total = $cat_total + $weekrow['Score'];
								$week_count++;
								$cat_count++;
							}

							$html .=  "<td align='center'><font size='2' face=' Arial, Helvetica, sans-serif'>".$weekrow['Score']." </font></td>";
							$weekrow = mysql_fetch_assoc($question_result);
						} else {
							for($k=1;$k<=10;$k++)
							{
								$html .=  "<td>&nbsp;</td>";
							}
							$html .=  "<td align='center'><font size='2' face=' Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
						}
					}
					$html .=  "</tr>";
					
					//$WeekTotal = (int)$WeekTotal + (int)$week_row['Score'];
					//$l = $l + 1;
				}
			}
			$html = str_replace($row['question_code']."V", round($question_total/$week_count), $html);
			//echo $row['question_code'].$question_total . $week_count. "<br/>";
			$question_total=0;
			$week_count = 0;
			$html .=  "</table>";
		}
		//echo $cat_count . "-" . $cat_total . "</br>";
		$html = str_replace($group_name."V", round($cat_total/$cat_count), $html);
		$html .=  "</table>";
		$html .=  "</td>";
		$group_name='';
		$cat_count = 0;
		$cat_total = 0;
	}	
	
	$html .=  "</td></tr></table>";
	echo $html;
	/*$db_export_fix = $site_root."download/WeeklyReport2.xls";

	echo $db_export_fix;
	
	
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