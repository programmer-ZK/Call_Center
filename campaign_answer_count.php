	<?php include_once("includes/config.php"); ?>
		<?php session_start();
			$page_name = "campaign_answers.php";
			$page_title = "Campaign Answers";
			$page_level = "2";
			$page_group_id = "1";
			$page_menu_title = "Campaign Answers ";
		?>
		<?php include_once($site_root."includes/check.auth.php"); ?>
		<?php 	
			include_once("classes/tools_admin.php");
			$tools_admin = new tools_admin();
			include_once("classes/templates.php");
			$templates = new templates();
			include_once("classes/campaign.php");
			$campaign = new campaign();
			include_once("classes/agent.php");
			$agent = new agent();
		?>
	
<?php

	
	include_once("classes/reports.php");
	$reports = new reports();
?>	
<?php include($site_root."includes/header.php"); ?><head>


<script type="text/javascript">
function getHtml4Excel()
{
document.getElementById("gethtml1").value = document.getElementById("agent_pd_report2").innerHTML;
}

</script>

</head>


<?php

$campaign_id	=	$_REQUEST['select'];

$campaignid				=$campaign->id_get2($campaign_id);
//$query=$agent->campaign_questions_second($campaign_id);
$query=$agent->campaign_questions_second($campaign_id);

	

?>

<?
if(isset($_REQUEST['export']))
{
	$stringData	= trim($_REQUEST['gethtml1']);
	$stringData = preg_replace('/Â/','',$stringData);
	$stringData = preg_replace('/<form name="xForm" (.*)>/isU', '', $stringData);
	$stringData = preg_replace('/<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<form name="xForm2" (.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<form name="xForm3" (.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData); 
	
	$stringData = str_replace('<tag1>',null,$stringData);//'<div style="border:2px solid #000000;background-color:#F2F2F2; margin-top:10px;margin-bottom:10px;">'
	$stringData = str_replace('</tag1>',null,$stringData);//'</div>'
	//$stringData = str_replace(' ','<br>',$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);
	$stringData = str_replace('<tag3>',null,$stringData);
	$stringData = str_replace('</tag3>',null,$stringData);
	
	//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
	$db_export_fix = $site_root."download/campaign_answers_count.xls";
	//echo $stringData; exit;
	shell_exec("echo '<html><body>".$stringData."</html></body>' > ".$db_export_fix);
		
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

if(isset($_REQUEST['export_pdf']))
{
								
	$stringData			= trim($_REQUEST['stringData']);
	$db_export_fix = $site_root."download/campaign_answers_count.csv";
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
	ob_end_clean();
	$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'campaign_answers.pdf', 'D', 160, 16, 1);
	exit();
}
?>


<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Campaign Answers Report</div>
	
   
<div>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
<div class="box">
<h4 class="white">
	 	<?php 	
	echo "View By Campaign:";
		?>
		<td><?php 
echo "<select name='select' id='select'>";
while(!$campaignid->EOF){
    echo "<option value='".$campaignid->fields['campaign_id']."'>".$campaignid->fields["campaign_name"]."</option>";
	$campaignid->MoveNext();
	}
echo "</select>";?>
<a class="button" href="javascript:document.xForm.submit();" onClick="javascript:return msg_validate('xForm');" ><span>Show</span></a>
				<input type="hidden" value="Show" id="show" name="show"/>
				
</td>
</h4>

</div>

<?php


if (isset($_POST['show']))
{
$id			=	$_REQUEST['select'];
$result=$campaign->campaign_name($id);

?>
<div id="agent_pd_report2">
<div id="mid-col" class="mid-col" >
	<div class="box"  >
<div style="width:500px;">
<br/><br/>
	<h4 class="white" >
	
	 	<?php 	
	echo "Campaign Answers Report Count";
	
		?>
		
	 <br/><br/>	<?php //$campaignid				=$campaign->id_get2($campaign_id);	
	echo "Campaign Name:".$result->fields["campaign_name"];
	
		?>
	</h4>
</div>
	
	
	<div class="box-container" style="width:478px; overflow:hidden;"  >  	

				<table class="table-short">
					<thead >
					
					
						<tr>
							  <td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
      			<td class="col-head">Question</td>
					<td class="col-first">Answer</td>
					<td class="col-first">Count</td>
	
			
      		<?  while (!$query->EOF){
?>	
<tr><td height="50px" class="col-first"><?php echo  $query->fields["question"];?></td>
<td height="50px" class="col-first"><?php echo  $query->fields["answer"];?></td>
<td height="50px" class="col-first"><?php echo  $query->fields["tRec"];?></td>
<? $query->MoveNext(); } ?>
	 	
									

			
					</tbody></thead>
				</table>

		
	
	</div>
	
	
	
	</div>
	</div></div>
	
				
   	
   
</div>



</form>

<form name="xForm2" id="xForm2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="  float:right; ">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();"class="button" >
	 <span>Export EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>

</form><? 
} ?>	
  </div>



</div>

<?php include($site_admin_root."includes/footer.php"); ?>

