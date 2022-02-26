<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "report1.php";
	$page_title = "Agent Performance Weekly Report";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Agent Performance Weekly Report";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php

//include 'include/config.php';
include 'include/db_info.php';


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
		?>

		<table style="background-color:#E8E8DD; border-style:solid; border-color:#3A4043" cellspacing="2" cellpadding="2" width="100%">
		<tr style="background-color: #3A4043;font-size: 1px; color:#FFFFFF">
		<th width="30%"><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></th>
		<th width="14%"><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week 1</font></th>
		<th width="14%"><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week 2</font></th>
		<th width="14%"><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week 3</font></th>
		<th width="14%"><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week 4</font></th>
		<th width="14%"><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Average</font></th>
		</tr>
		
		<p>
		  <?php
		
		echo "<tr><td style='border-bottom:solid;border-color:#3A4043'>";
		
		//Internal Master Question table
		if ($result) echo "<table border=0><tr><td>&nbsp;</td></tr>";
		
		while ($row = mysql_fetch_assoc($result)) { 
			echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $row['question_code'] . "</font></td></tr>";
			$group_count = $group_count + 1;
			$group_name = $row['group_name'];
		}
		
		if ($result) echo "</table></td>";
		
		
			//Internal Week table
			// Fetch Week wise result
			for ($i=1; $i<=4; $i++)
			{
				echo "<td  style='border-bottom:solid;border-color:#3A4043' align='center'><table border='1px'>";
				//echo "<tr><td>Week " . $i . "</td></tr>";
		
				$Week_query = "SELECT Question_code, ROUND(SUM(ePoints) / SUM(Maxpoints) * 100) AS Score, SUM(IF(points_type='yes',Qcount,0)) AS Yes, SUM(IF(points_type='no',Qcount,0)) AS 'No', SUM(IF(points_type='nimp',Qcount,0)) AS nimp, ";
				$Week_query = $Week_query . "SUM(IF(points_type='na',Qcount,0)) AS NA FROM cc_vu_evaluation WHERE evaluate_agent_id = '" . $agent_id . "' AND CallDate BETWEEN '".$sdate."' AND '".$edate."' ";
				$Week_query = $Week_query . "AND WEEK = " . $i . " AND qGroup = ".$iLoop. " GROUP BY question_code ORDER BY question_no";
		
				//echo $Week_query;
				$week_result = mysql_query($Week_query);
				$num_rows = mysql_num_rows($week_result);
				
				echo "<tr><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Yes</font></td>";
				echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>No</font></td>";
				echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>N.Imp</font></td>";
				echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>NA</font></td>";
				echo "<td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Score</font></td></tr>";
				
				if($num_rows == 0){
					for($j=1;$j<=$group_count;$j++)
					{
						echo "<tr>";
						echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
						echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
						echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
						echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
						echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>&nbsp;</font></td>";
						echo "</tr>";
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
						echo "<tr>";
						echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['Yes'] . " </font></td>";
						echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['No']  . " </font></td>";
						echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['nimp']  . " </font></td>";
						echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['NA']  . " </font></td>";
						echo "<td bgcolor='#CCCCCC' align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . $week_row['Score'] . "% </font></td>";
						echo "</tr>";
						
						$WeekTotal = (int)$WeekTotal + (int)$week_row['Score'];
						$l = $l + 1;
					}
				}		
				echo "</table></td>";
				$WeekSum[$i-1] = round(((int)$WeekTotal)/$group_count);
			}
			
			//here will come the summary for the question
			echo "<td  style='border-bottom:solid;border-color:#3A4043' align='center'><table border='1px'>";
			echo "<tr><td>&nbsp;</td></tr>";
			for($k=0;$k<$group_count;$k++)
			{
				echo "<tr>";
				echo "<td align='center'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>" . round($QuestionRow[$k]/$ScoredWeeks) . "% </font></td>";
				echo "</tr>";
			}
			echo "</table></td>";
			//till here
		echo "</tr>";

		//here goes the summary for the group
		//we will create a seoerate table here
		echo "<tr><td>";
		
		echo "<table width='100%'>";
		echo "<tr><td colspan='3'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><b>" .$group_name . "</b></td></tr>";
		//echo "<tr><td>&nbsp;</td>";
		
		for($k=0;$k<=3;$k++)
		{
			echo "<tr><td>&nbsp;</td><td><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>Week ".($k+1)."</font></td><td align='left'><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>";
			echo $WeekSum[$k];
			echo "</font></td></tr>";
			$MonthTotal = $MonthTotal + $WeekSum[$k];
		}
		echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td><b><font size='2' face='Verdana, Arial, Helvetica, sans-serif'>".round($MonthTotal/$ScoredWeeks)."</b></font></td></tr>";
		echo "</table>";
		
		echo "</td></tr>";
		
		
		echo "</table>";
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


?>