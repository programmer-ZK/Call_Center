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
	
	include_once("classes/admin.php");
	$admin = new admin();
	
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
	$stringData = preg_replace('/<img class="graph" src="data:image/ (.*) \/>/isU', '', $stringData);
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
	$stringData = preg_replace('/<img class="graph" src="data:image/ (.*)\/>/isU', '', $stringData);
	//echo $stringData;exit;
	ob_end_clean();
	$content = "<page>".$stringData."</page>"; 
	
    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
    $html2pdf = new HTML2PDF('L','A4','en');
	$html2pdf->pdf->SetDisplayMode('fullwidth');
    $html2pdf->WriteHTML($content,true);
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
$WeekSumTotal_h = 0; //For overall score
$WeekSumAvg = array(0,0,0,0); //For overall score
$week_iterator = 0; //For overall score
$col = array(0,0,0,0);//For overall score
$WeekTotal = 0;
$MonthTotal = 0;
$QuestionTotal = 0;
$QuestionRow = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
$ScoredWeeks = 0;
$html = '';

if (!empty($agent_id) && $agent_id != 0){

	$rs4 = $admin->get_agent_name($agent_id);
}

$var1 = (!empty($agent_id) && $agent_id != 0)?strtoupper($rs4->fields["full_name"]):"---";

$html .= '<div style="width:350; margin-top:20px;margin-left:20px;font-family:Arial, Helvetica, sans-serif">
<h3 style="color:#000000;font-size:16px;" >Agent Performance Report Graphs</h3>
<table style=" border-style:solid; width:290; background-color:#E8E8DD;" >
<tbody>
<tr><td style="padding-top:10"><h3 style="color:#000000;font-size:12px;"  >From Date:&nbsp;'.$sdate.'</h3><h3 style="color:#000000;font-size:12px;" >To Date:&nbsp;'.$edate.'</h3><h3 style="color:#000000;font-size:12px;" >Agent Name:&nbsp;'.$var1.'</h3></td></tr>
</tbody>
</table>
</div>';
			
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//We need to repeat the code starting from
//////////////////////////////////////////////////////////////////////////////////H E R E /////////////////////////////////////////////////////////////////
//master table
//four categroies of questions

$html .= '<div style="width:auto; margin-top:20px;margin-left:20px;font-family:Arial, Helvetica, sans-serif">
<table style="border: 1px solid #000000;">
<tr>';

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
		
		while ($row = mysql_fetch_assoc($result)) { 

			$group_count = $group_count + 1;
			$group_name = $row['group_name'];
		}
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

//			for($k=0;$k<$group_count;$k++)
//			{
//
//			}
		
		for($k=0;$k<=3;$k++)
		{

			$MonthTotal = $MonthTotal + $WeekSum[$k];
		}

		$tools_admin->generateGraph($group_name, $WeekSum);
		
		$imgfile = "graphs/".$group_name.".png";
		$handle = fopen($imgfile, "r");
		$imgbinary = fread($handle, filesize($imgfile));
		
		$html .= '<td><img style="margin:20px 20px 20px 50px" class="graph" src="data:image/png;base64,' . base64_encode($imgbinary) . '" /></td>';
		
		if ($iLoop == 2)
		{
			$html .= '</tr>';
		}
	
		for ($i=0;$i<4;$i++)
		{
			$WeekSumTotal_h += $WeekSum[$i];
			
//			if ($i == 3) 
//			{
//			}
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

		mysql_free_result($week_result);
		mysql_free_result($result);
		$group_count=0;
		$MonthTotal = 0;
		$QuestionRow = array(0,0,0,0,0,0,0,0,0,0,0,0,0);
		$ScoredWeeks = 0;
		$WeekSumTotal_h =0;//for overall score
	}

//		for ($i=0; $i<4; $i++)
//		{
//			
//		}

$html .= '</tr>
</table>';
	
	echo $html;


?>

</body>

<!--<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onSubmit="">

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
</form>-->
</html>