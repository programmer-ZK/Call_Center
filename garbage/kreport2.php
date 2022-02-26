<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "report2.php";
	$page_title = "Agent Weeks Performance Trend";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Agent Weeks Performance Trend";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php

//include 'include/config.php';
include 'include/db_info.php';


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
	$query = "SELECT ROUND(SUM(scores)/COUNT(S.unique_id)) AS Score, full_name FROM cc_evaluation_scores S INNER JOIN cc_admin A ON S.evaluate_agent_id = A.admin_id INNER JOIN cc_cdr C ON S.unique_id = C.uniqueid";
	$query .= " WHERE A.admin_id = '" .$agent_id. "' AND DATE(C.calldate) BETWEEN '".$sdate."' AND '".$edate."' GROUP BY full_name";

	$info_result = mysql_query($query);
	$num_rows = mysql_num_rows($info_result);

	echo "<table style='background-color:#E8E8DD; border-style:solid; border-color:#3A4043' cellspacing=0 cellpadding=0><tr style='background-color: #3A4043;font-size: 16px; color:#FFFFFF; font-family:Verdana, Arial, Helvetica, sans-serif;font-weight:bold;text-align:center'><td colspan=2>Agent Week Performance Trend</td></tr>";
	echo "<tr><td style='border-right:solid'>";
	if($num_rows>0){
		$inforow = mysql_fetch_assoc($info_result);
		echo "<table>";
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Agent Name:</font></td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>".$inforow['full_name']."</b></td></tr>";
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Evaluation Period :</font></td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>".$sdate." -- ".$edate."</b></td></tr>";
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Call Performance Score :</font></td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>".$inforow['Score']."%</b></td></tr>";
		echo "</table>";
	} else {
		echo "<table>";
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Agent Name:</font></td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>&nbsp;</b></td></tr>";
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Evaluation Period :</font></td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>&nbsp;</b></td></tr>";
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Call Performance Score :</font></td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>&nbsp;</b></td></tr>";
		echo "</table>";
	}
	echo "</td>";
	
	//Call summary column

	$query = "SELECT SUM(IF(call_type='INBOUND' AND no_of_questions IS NULL,1,0)) AS UN_InBound, SUM(IF(call_type='OUTBOUND' AND no_of_questions IS NULL,1,0)) AS UN_OutBound, ";
	$query .= "SUM(IF(call_type='INBOUND' AND no_of_questions IS NOT NULL,1,0)) AS InBound, SUM(IF(call_type='OUTBOUND' AND no_of_questions IS NOT NULL,1,0)) AS OutBound ";
	$query .= "FROM cc_vu_evaluated_calls ";
	$query .= "WHERE staff_id = '" .$agent_id. "' AND DATE(update_datetime) BETWEEN '".$sdate."' AND '".$edate."'";

	$call_result = mysql_query($query);
	$num_rows = mysql_num_rows($call_result);
	
	echo "<td>";	
	echo "<table>";
	echo "<tr bgcolor=#CCCCCC><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
	echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Calls Taken</td>";
	echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Evaluated</font></td></tr>";
	
	if($num_rows>0){
		$callrow = mysql_fetch_assoc($call_result);
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Incoming</font></td>";
		echo "<td align=center><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>".((int)$callrow['UN_InBound'] + (int)$callrow['InBound'])."</b></td>";
		echo "<td align=center><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>".$callrow['InBound']."</b></font></td></tr>";
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Outgoing</td>";
		echo "<td align=center><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>".((int)$callrow['UN_OutBound'] + (int)$callrow['OutBound'])."</b></font></td>";
		echo "<td align=center><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>".$callrow['OutBound']."</b></font></td></tr>";
	} else {
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Incoming</font></td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>&nbsp;</b></td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>&nbsp;</b></font></td></tr>";
		echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Outgoing</td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>&nbsp;</b></font></td>";
		echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>&nbsp;</b></font></td></tr>";
	}
	echo "</table>";	
	echo "</td>";
	
	echo "</td></tr>";
	echo "</table><br />";
	

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
					$html .= "<table cellpadding=0 cellspacing=0 width='100%'><tr style='background-color: #3A4043;font-size: 18px; color:#FFFFFF;'><td><b><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>".$row['group_name']."</b></font></td>";
					$html .= "<td><b><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>".$row['group_name']."V</b></font></td></tr>";
				} 
				$group_name=$row['group_name'];
			}
			$html .=  "<tr><td colspan=2><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td></tr>";
			$html .=  "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>".$row['question_code']."</b></font></td>";
			$html .=  "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>".$row['question_code']."V</b></font></td></tr>";			
			//Internal question table
			// Fetch Week wise result

			
			$html .=  "<tr><td align='left' colspan=2><table cellspacing=0 cellpadding=0 width='100%'>";
		
			$question_query = "SELECT question_no, question_code, ROUND(SUM(ePoints) / SUM(Maxpoints) * 100) AS Score, WEEK As WeekNo ";
			$question_query .= "FROM cc_vu_evaluation ";
			$question_query .= "WHERE evaluate_agent_id = '".$agent_id."' ";
			$question_query .= " AND CallDate BETWEEN '".$sdate."' AND '".$edate."' ";
			$question_query .= " AND qGroup = ".$iLoop;
			$question_query .= " AND question_code = '" .$row['question_code']."' ";
			$question_query .= " ORDER BY WEEK";

			$question_result = mysql_query($question_query);
			$num_rows = mysql_num_rows($question_result);
			
			
			//echo "A".$question_result['question_no'];
			if($num_rows == 0){
				for($j=1;$j<=4;$j++)
				{
					$html .=  "<tr>";
					$html .=  "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week ".$j."</font></td>";
					$html .=  "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
					$html .=  "</tr>";
				}
			}
			else
			{
				$weekrow = mysql_fetch_assoc($question_result);
				for($j=1;$j<=4;$j++)
				{
					$html .=  "<tr>";
					$html .=  "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week ".$j." </font></td>";
					//echo "J".$question_result['WeekNo'];
					
					if ($weekrow)
					{
						if($j==$weekrow['WeekNo'])
						{
							$iCol = round((int)$weekrow['Score']/10,0);
							
							for($k=1;$k<=10;$k++)
							{
								if($k<=$iCol){
									$html .=  "<td bgcolor='#CCCCCC'>&nbsp;</td>";
								}else{
									$html .=  "<td>&nbsp;</td>";
								}
							}
							$html .=  "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>".$weekrow['Score']." </font></td>";
							$cat_count++; //= $week_count + 1;
							
							$question_total = $question_total + $weekrow['Score'];
							$cat_total = $cat_total + $weekrow['Score'];
							$week_count++;
							$weekrow = mysql_fetch_assoc($question_result);
						} else {
							for($k=1;$k<=10;$k++)
							{
								$html .=  "<td>&nbsp;</td>";
							}
							$html .=  "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
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
?>
