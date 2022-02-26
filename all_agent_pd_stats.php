<?php include_once("includes/config.php"); ?>

<?php

$page_name = "all_agent_pd_stats.php";

$page_level = "0";

$page_group_id = "0";

$page_title = "All Agent Productivity Stats";

$page_menu_title = "All Agent Productivity Stats";

?>



<?php include_once($site_root."includes/check.auth.php"); ?>



<?php

include_once("classes/all_agent.php");

$all_agent = new all_agent();



include_once("classes/tools_admin.php");

$tools_admin = new tools_admin();



include_once("classes/reports.php");

$reports = new reports();

?>        

<?php include($site_root."includes/header.php"); ?>            





<html>

<head>

<script type="text/javascript">

function getHtml4Excel()

{



document.getElementById("gethtml1").value = document.getElementById("all_agent_pd_stats").innerHTML;



}



</script>

</head>

<body>







<?php  



$recStartFrom = 0;

$field = empty($_REQUEST["field"])?"staff_updated_date":$_REQUEST["field"];

$order = empty($_REQUEST["order"])?"asc":$_REQUEST["order"];

$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);

?>



<?php 

/************************* Export to Excel ******************/

if(isset($_REQUEST['export']))

{



/*$stringData  = trim($_REQUEST['stringData']);*/

$stringData     = trim($_REQUEST['gethtml1']);

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

$db_export_fix = $site_root."download/Productivity_Report.xls";

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

																	

$stringData                             = trim($_REQUEST['stringData']);



$db_export_fix = $site_root."download/Productivity_Report.csv";



shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 

																	



ob_end_clean();



$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'Productivity_Records.pdf', 'D', 160, 16, 1);

exit();

}

///******************************************************************************/      

$stringData     = '';

?>



<div>

<form name="xForm" id="xForm" action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform"   onsubmit="">



<div id="mid-col" class="mid-col">

<div class="box">



<h4 class="white">



<div>

Date :

<label>

<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo $fdate; ?>" autocomplete = "off" readonly="readonly" onClick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown')">

</label>

<div style="float:right;">







<a class="button" href="javascript:document.xForm.submit();" >

<span>Search</span>

</a>

<input type="hidden" value="Search >>" id="search_date" name="search_date" />

											

											

<div>

</div>

</h4>



<br />

<?        if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])) { 



$keywords                               = $_REQUEST['keywords'];

$search_keyword                    = $_REQUEST['search_keyword'];

$fdate                                      = $_REQUEST['fdate'];

$tdate                                     = $_REQUEST['tdate'];





?>

<div id="all_agent_pd_stats">



<h4 class="white"><?php 

echo "All Agent Productivity Report <br> Date: ".$fdate;





?></h4>

<br />



<h4 class="white"><?php echo "Agent Times Summary";?></h4> 

<div class="box-container"  >                 

<?php 

$rs = $all_agent->all_agents();

{

?>



<table class="table-short">

		<thead>

								<tr>

		<td colspan="12" class="paging"><?php echo($paging_block);?></td>

</tr>

					<tr><td class="col-head2">Agent Name</td>

								<?php  while(!$rs->EOF){ ?>

		

<td class="col-head2"><?php echo $rs->fields['full_name']; 

											$rs->MoveNext();}      ?></td>

								</tr>
<? /*
################################################################################################################################

								<tr><td class="col-head2">LogIn Time</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

	$times=$all_agent->get_agent_work_times($names->fields['admin_id'],$_REQUEST['fdate']);      
				$recordcount=$times->RecordCount();

		if ($recordcount=='1'){

											

											while (!$times->EOF){ ?>

					

								<td class="col-first"><?php echo $times->fields["login_time"]; ?> </td>

					

					<?php  $times->MoveNext();} } else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

					

					

								<tr><td class="col-head2">Log Out Time</td>

								<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$times=$all_agent->get_agent_work_times($names->fields['admin_id'],$_REQUEST['fdate']);      $recordcount=$times->RecordCount();

								

											

											if ($recordcount=='1'){

											

											while (!$times->EOF){ ?>

					

								<td class="col-first"><?php echo $times->fields["logout_time"]; ?> </td>

					

					<?php  $times->MoveNext();} } else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

								

								

								</tr>

################################################################################################################################
*/?>
								<tr><td class="col-head2">Login Duration</td>

								<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$times=$all_agent->get_agent_work_times($names->fields['admin_id'],$_REQUEST['fdate']);      $recordcount=$times->RecordCount();

								

											if ($recordcount=='1'){

											

											while (!$times->EOF){ 

                                                                        $sum_worktime = "00:00:00";
                                                                      $sum_worktime_total=$all_agent->get_agent_work_times_sum($names->fields['admin_id'],$_REQUEST['fdate']);
									//print_r($sum_worktime_total);
                                                                      //echo $sum_worktime_total->fields["duration"];
                                                                      while(!$sum_worktime_total->EOF){
                                                                      $sum_worktime_total->fields["duration"];
                                                                      $sum_worktime = $tools_admin->sum_the_time($sum_worktime,$sum_worktime_total->fields["duration"]);
                                                                       $sum_worktime_total->MoveNext();
                                                                      }
									?>

					

							<?/*	<td class="col-first"><?php  echo $times->fields["duration"]."--".$sum_worktime; ?> </td> */?>
								<td class="col-first"><?php  echo $sum_worktime; ?> </td>

					

					<?php  $times->MoveNext();} } else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

								

								</tr>



											

								</tr>

								



</thead>

		

</table>          

<?php } ?>

</div>



<br />

<!-- ******************************  Agent Break Times SUM ************************** -->





<h4 class="white"><?php echo "Break Times Summary";?></h4>



<div class="box-container" >                          

<?php



{           $B = "00:00:00"; 

?>



<table class="table-short">

		<thead>

								<tr>

		<td colspan="12" class="paging"><?php echo($paging_block);?></td>

</tr>

					



		

		

					<tr><td class="col-head2">Namaz Break</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$break_times = $all_agent->get_agent_break_times_sum($names->fields['admin_id'],$_REQUEST['fdate'],2);   

											$recordcount=$break_times->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$break_times->EOF){ ?>

					

								<td class="col-first"><?php

								

								$B1=$tools_admin->sum_the_time($B,$break_times->fields["duration"]);

								echo $break_times->fields["duration"]; ?> </td>

					

					<?php  //$break_times->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

		

		

		

		<tr><td class="col-head2">Lunch Break</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$break_times = $all_agent->get_agent_break_times_sum($names->fields['admin_id'],$_REQUEST['fdate'],3);   

											$recordcount=$break_times->RecordCount();

											if ($recordcount=='1'){

											

								//         while (!$break_times->EOF){ ?>

					

								<td class="col-first"><?php 

								

								$B2=$tools_admin->sum_the_time($B,$break_times->fields["duration"]);

								echo $break_times->fields["duration"]; ?> </td>

					

					<?php  //$break_times->MoveNext();}

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

					

					<tr><td class="col-head2">Tea Break</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$break_times = $all_agent->get_agent_break_times_sum($names->fields['admin_id'],$_REQUEST['fdate'],4);   

											$recordcount=$break_times->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$break_times->EOF){ ?>

					

								<td class="col-first"><?php

								$B3=$tools_admin->sum_the_time($B,$break_times->fields["duration"]);

								

								echo $break_times->fields["duration"]; ?> </td>

					

					<?php  //$break_times->MoveNext();} 

					

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

		

		

		

		<tr><td class="col-head2">Break</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$break_times = $all_agent->get_agent_break_times_sum($names->fields['admin_id'],$_REQUEST['fdate'],5);   

											$recordcount=$break_times->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$break_times->EOF){ ?>

					

								<td class="col-first"><?php 

								

								$B4=$tools_admin->sum_the_time($B,$break_times->fields["duration"]);

								echo $break_times->fields["duration"]; ?> </td>

					

					<?php  //$break_times->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

		

		

</thead>

					

</table>          

<?php } ?>

</div>





<br />              

<!-- ****************************** InBound Call Stats ************************** -->

<h4 class="white"><?php echo "Inbound Call Stats"; 



?></h4>

<?php  



?>



<div class="box-container"   >            

<?php



{

?>



<table class="table-short">

		<thead>

								<tr>

		<td colspan="12" class="paging"><?php echo($paging_block);?></td>

</tr>

		

								

											

											<tr><td class="col-head2">No of Calls</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$inbound_call_stats = $all_agent->get_agent_on_call_busy_times($names->fields['admin_id'],$_REQUEST['fdate'],INBOUND);     

											$recordcount=$inbound_call_stats->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$inbound_call_stats->EOF){ ?>

					

								<td class="col-first"><?php echo $inbound_call_stats->fields["cnt"]; ?> </td>

					

					<?php // $inbound_call_stats->MoveNext();}

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

								<tr><td class="col-head2">Abandoned Calls</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){//echo 'waleed';exit;

											$inbound_abandoned_calls = $all_agent->get_agent_abandon_calls2($names->fields['admin_id'],$_REQUEST['fdate']);     

											$recordcount=$inbound_abandoned_calls->RecordCount();

											if ($recordcount=='1'){ 

											

											//while (!$inbound_abandoned_calls->EOF){ ?>

					

								<td class="col-first"><?php 

					

								

								

								echo  $inbound_abandoned_calls->fields["trec"]; ?> </td>

					

					<?php  //$inbound_abandoned_calls->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

					

					

								<tr><td class="col-head2">On Call Time</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$inbound_call_stats = $all_agent->get_agent_on_call_busy_times($names->fields['admin_id'],$_REQUEST['fdate'],INBOUND);     

											$recordcount=$inbound_call_stats->RecordCount();

											if ($recordcount=='1'){

											

								//         while (!$inbound_call_stats->EOF){ ?>

					

								<td class="col-first"><?php 

								

								$E=$tools_admin->sum_the_time($E,$inbound_call_stats->fields["call_duration"]);

								echo $inbound_call_stats->fields["call_duration"]; ?> </td>

					

					<?php // $inbound_call_stats->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

											<tr><td class="col-head2">Busy Time</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$inbound_call_stats = $all_agent->get_agent_on_call_busy_times($names->fields['admin_id'],$_REQUEST['fdate'],INBOUND);     

											$recordcount=$inbound_call_stats->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$inbound_call_stats->EOF){ ?>

					

								<td class="col-first"><?php 

								

											$F=$tools_admin->sum_the_time($E,$inbound_call_stats->fields["call_duration"]);

								echo $inbound_call_stats->fields["busy_duration"]; ?> </td>

					

					<?php // $inbound_call_stats->MoveNext();}

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

		

							<tr><td class="col-head2">On Hold Time</td>
					<?php 
			$names=	$all_agent->all_agents();
			while(!$names->EOF){
					$inbound_call_hold_time = $all_agent->get_agent_on_call_hold_times($names->fields['admin_id'],$_REQUEST['fdate'],INBOUND);	
				
					
			?>
			
				<td class="col-first"><?php 
				
				echo $inbound_call_hold_time->fields["holdtime"]; ?> </td>
		
			<?
		$names->MoveNext();}
			?>
			</tr>		



		</thead>

</table>          

<?php } ?>

</div>

<br />





<!-- ******************************  OutBound Call Stats ************************** -->

<h4 class="white"><?php echo "Outbound Call Stats"; 



?></h4>

<?php  



?>



<div class="box-container"   >            

<?php



{

?>



<table class="table-short">

		<thead>

								<tr>

		<td colspan="12" class="paging"><?php echo($paging_block);?></td>

</tr>

		

								

											

											<tr><td class="col-head2">No of Calls</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$inbound_call_stats = $all_agent->get_agent_on_call_busy_times($names->fields['admin_id'],$_REQUEST['fdate'],OUTBOUND);  

											$recordcount=$inbound_call_stats->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$inbound_call_stats->EOF){ ?>

					

								<td class="col-first"><?php echo $inbound_call_stats->fields["cnt"]; ?> </td>

					

					<?php  //$inbound_call_stats->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

								<tr><td class="col-head2">Abandoned Calls</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$outbound_abandoned_calls = $all_agent->get_agent_abandon_calls2($names->fields['admin_id'],$_REQUEST['fdate']);     

											$recordcount=$outbound_abandoned_calls->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$outbound_abandoned_calls->EOF){ ?>

					

								<td class="col-first"><?php echo $outbound_abandoned_calls->fields["trec"]; ?> </td>

					

					<?php  //$outbound_abandoned_calls->MoveNext();}

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

					

					

								<tr><td class="col-head2">On Call Time</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$inbound_call_stats = $all_agent->get_agent_on_call_busy_times($names->fields['admin_id'],$_REQUEST['fdate'],OUTBOUND);  

											$recordcount=$inbound_call_stats->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$inbound_call_stats->EOF){ ?>

					

								<td class="col-first"><?php 

								

														$E=$tools_admin->sum_the_time($E,$inbound_call_stats->fields["call_duration"]);

								echo $inbound_call_stats->fields["call_duration"]; ?> </td>

					

					<?php  //$inbound_call_stats->MoveNext();}

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

											<tr><td class="col-head2">Busy Time</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$inbound_call_stats = $all_agent->get_agent_on_call_busy_times($names->fields['admin_id'],$_REQUEST['fdate'],OUTBOUND);  

											$recordcount=$inbound_call_stats->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$inbound_call_stats->EOF){ ?>

					

								<td class="col-first"><?php 

								

														$F=$tools_admin->sum_the_time($E,$inbound_call_stats->fields["call_duration"]);

								echo $inbound_call_stats->fields["busy_duration"]; ?> </td>

					

					<?php  //$inbound_call_stats->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

			<tr><td class="col-head2">On Hold Time</td>
					<?php 
			$names=	$all_agent->all_agents();
			while(!$names->EOF){
					$inbound_call_hold_time = $all_agent->get_agent_on_call_hold_times($names->fields['admin_id'],$_REQUEST['fdate'],OUTBOUND);	
				
					
			?>
			
				<td class="col-first"><?php 
				
				echo $inbound_call_hold_time->fields["holdtime"]; ?> </td>
		
			<?
		$names->MoveNext();}
			?>
			</tr>

								



		</thead>

</table>          

<?php } ?>

</div>

<br />              



		

		

											

		<!--campaign -->

		

<h4 class="white"><?php echo "Campaign Call Status"; 



?></h4>

<?php  



?>



<div class="box-container"   >            

<?php



{

?>



<table class="table-short">

		<thead>

								<tr>

<td colspan="12" class="paging"><?php echo($paging_block);?></td>
</tr>

		

<tr><td class="col-head2">No of Calls</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$inbound_call_stats = $all_agent->get_agent_on_call_busy_times($names->fields['admin_id'],$_REQUEST['fdate'],CAMPAIGN);   

											$recordcount=$inbound_call_stats->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$inbound_call_stats->EOF){ ?>

					

								<td class="col-first"><?php echo $inbound_call_stats->fields["cnt"]; ?> </td>

					

					<?php  //$inbound_call_stats->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

								<tr><td class="col-head2">Abandoned Calls</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$outbound_abandoned_calls = $all_agent->get_agent_campaign_abandon_calls($names->fields['admin_id'],$_REQUEST['fdate']); 


											

										?>
<td class="col-first"><?php echo  empty($outbound_abandoned_calls->fields["trec"])?'0':$outbound_abandoned_calls->fields["trec"];
?> </td>

				

					<?

					 $names->MoveNext();}

					?>

					</tr>

					

					

					

					

								<tr><td class="col-head2">On Call Time</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$inbound_call_stats = $all_agent->get_agent_on_call_busy_times($names->fields['admin_id'],$_REQUEST['fdate'],CAMPAIGN);   

											$recordcount=$inbound_call_stats->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$inbound_call_stats->EOF){ ?>

					

								<td class="col-first"><?php 

								

														$E=$tools_admin->sum_the_time($E,$inbound_call_stats->fields["call_duration"]);

								echo $inbound_call_stats->fields["call_duration"]; ?> </td>

					

					<?php  //$inbound_call_stats->MoveNext();}

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

											<tr><td class="col-head2">Busy Time</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$inbound_call_stats = $all_agent->get_agent_on_call_busy_times($names->fields['admin_id'],$_REQUEST['fdate'],CAMPAIGN);   

											$recordcount=$inbound_call_stats->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$inbound_call_stats->EOF){ ?>

					

								<td class="col-first"><?php 

								
$F=$tools_admin->sum_the_time($E,$inbound_call_stats->fields["call_duration"]);

								echo $inbound_call_stats->fields["busy_duration"]; ?> </td>

					

					<?php  //$inbound_call_stats->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					<tr><td class="col-head2">On Hold Time</td>
					<?php 
			$names=	$all_agent->all_agents();
			while(!$names->EOF){
					$inbound_call_hold_time = $all_agent->get_agent_on_call_hold_times($names->fields['admin_id'],$_REQUEST['fdate'],CAMPAIGN);	
				
					
			?>
			
				<td class="col-first"><?php 
				
				echo $inbound_call_hold_time->fields["holdtime"]; ?> </td>
		
			<?
		$names->MoveNext();}
			?>
			</tr>





		</thead>

</table>          

<?php } ?>

</div>

<br />              

		

		

<!--ASSIGNMENT TIME SUM -->                     

		

<h4 class="white"><?php echo "Assignment Times"; 



?></h4>

<?php  



?>



<div class="box-container"   >            

<?php



{

?>



<table class="table-short">

		<thead>

								<tr>

		<td colspan="12" class="paging"><?php echo($paging_block);?></td>

</tr>

		

								

											

											<tr><td class="col-head2">Assignment Time Sum</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$sum_assignment_times = $reports->get_sum_agent_assignment_times($names->fields['admin_id'],$_REQUEST['fdate']);    

								 ?>

					

								<td class="col-first"><?php echo empty($sum_assignment_times->fields["duration"])?'00:00:00':$sum_assignment_times->fields["duration"]; ?> </td>

					


					


					<?

				 $names->MoveNext();}

					?>

					</tr>

					



		</thead>

</table>          

<?php } ?>

</div>

<br />              



								

		

		

		

		

		

		

		

		

		

		

		

		

		

		

		

		

		

		

		

		

		

		

<!-- ******************************  WORK TIME************************** -->          





<?php

//         $G=$tools_admin->sum_the_time($D,$E);

//         $G=$tools_admin->sum_the_time($G,$F);

//         $H=$tools_admin->sub_the_time($C,$G);                                                                 

?>

<h4 class="white">Work Timing Distribution</h4>

<div class="box-container"> 

<?php 



{

?>

<table >           



<tr><td class="col-head2">Workable Time (A):</td>

								<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$times=$all_agent->get_agent_work_times($names->fields['admin_id'],$_REQUEST['fdate']);      $recordcount=$times->RecordCount();

								

											if ($recordcount=='1'){

											

											while (!$times->EOF){ 


                                                                        $sum_worktime = "00:00:00";
                                                                      $sum_worktime_total=$all_agent->get_agent_work_times_sum($names->fields['admin_id'],$_REQUEST['fdate']);
                                                                        //print_r($sum_worktime_total);
                                                                      //echo $sum_worktime_total->fields["duration"];
                                                                      while(!$sum_worktime_total->EOF){
                                                                      $sum_worktime_total->fields["duration"];
                                                                      $sum_worktime = $tools_admin->sum_the_time($sum_worktime,$sum_worktime_total->fields["duration"]);
                                                                       $sum_worktime_total->MoveNext();
                                                                      }


											?>

					

						<?/*		<td class="col-first"><?php $A=$times->fields["duration"]; echo $times->fields["duration"]; ?> </td>*/?>								<td class="col-first"><?php $A=$sum_worktime; echo $sum_worktime ?> </td>

					

					<?php  $times->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

								

								</tr>

								<tr><td class="col-head2">Break Time(B):</td>

								<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$break_times = $all_agent->get_agent_break_times_sum_2($names->fields['admin_id'],$_REQUEST['fdate']);      

											$recordcount=$break_times->RecordCount();

								

											if ($recordcount=='1'){

											

											//while (!$break_times->EOF){ ?>

					

								<td class="col-first"><?php echo $break_times->fields["duration"]; ?> </td>

					

					<?php  //$break_times->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

								

								</tr>

								

					

								<tr><td class="col-head2">Assignment Time (D):</td>

								<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$assignemnt_times_sum = $all_agent->get_assignment_times_sum($names->fields['admin_id'],$_REQUEST['fdate']);   

											$recordcount=$assignemnt_times_sum->RecordCount();

								

											if ($recordcount=='1'){

											

						//					while (!$assignemnt_times_sum->EOF){ ?>

					

								<td class="col-first"><?php echo $assignemnt_times_sum->fields["duration"]; ?> </td>

					

					<?php // $assignemnt_times_sum->MoveNext();}

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

								

								</tr>    

								

								



								<tr><td class="col-head2">On Call Time (E):</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$oncalltime_sum = $all_agent->get_agent_on_call_busy_times_sum($names->fields['admin_id'],$_REQUEST['fdate']);  

											$recordcount=$oncalltime_sum->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$oncalltime_sum->EOF){ ?>

					

								<td class="col-first"><?php 

								

								echo $oncalltime_sum->fields["call_duration"]; ?> </td>

					

					<?php // $oncalltime_sum->MoveNext();} 

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

					

					

											<tr><td class="col-head2">Busy Time (F):</td>

											<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$onbusytime_sum = $all_agent->get_agent_on_call_busy_times_sum($names->fields['admin_id'],$_REQUEST['fdate']);  

											$recordcount=$onbusytime_sum->RecordCount();

											if ($recordcount=='1'){

											

											//while (!$onbusytime_sum->EOF){ ?>

					

								<td class="col-first"><?php 

								

								echo $onbusytime_sum->fields["busy_duration"]; ?> </td>

					

					<?php // $onbusytime_sum->MoveNext();}

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

					</tr>

								

								

														<tr><td class="col-head2">Work Time Utilized (G):</td>

								<?php 

					$names=         $all_agent->all_agents();

					while(!$names->EOF){

											$work_time_utilized = $all_agent->get_work_time_utilized($names->fields['admin_id'],$_REQUEST['fdate']);      

											$recordcount=$work_time_utilized->RecordCount();

								


											if ($recordcount=='1'){
							//$G=0;


                                                                                        $assignemnt_times_sum = $all_agent->get_assignment_times_sum($names->fields['admin_id'],$_REQUEST['fdate']);

                                                                                        $oncalltime_sum = $all_agent->get_agent_on_call_busy_times_sum($names->fields['admin_id'],$_REQUEST['fdate']);
                                                                                        $onbusytime_sum = $all_agent->get_agent_on_call_busy_times_sum($names->fields['admin_id'],$_REQUEST['fdate']);
							$G=$tools_admin->sum_the_time($onbusytime_sum->fields["busy_duration"],$assignemnt_times_sum->fields["duration"]);
                                                        $G=$tools_admin->sum_the_time($G,$oncalltime_sum->fields["call_duration"]);	
											

											//while (!$work_time_utilized->EOF){ ?>
					
		
						<?/*	<td class="col-first"><?php echo $work_time_utilized->fields["call_duration"]."--".$G; ?> </td>*/?>
							<td class="col-first"><?php echo $G; ?> </td>

					

					<?php  //$work_time_utilized->MoveNext();}

					} else { ?>

					

					<td class="col-first"><?php echo "0"; ?> </td>

					<?

					} $names->MoveNext();}

					?>

								

								</tr>    

								

								

												
								





</table>





<?php } ?>

</div>              <br />

<!-- ******************************  Agent Break Times ************************** -->

<?php  $rs_b_t = $reports->get_agent_break_times($search_keyword,$fdate) ?>



<h4 class="white"><?php echo "Break Times"; 

//$stringData .= "\r\n\r\n";

$stringData .= "<tag1>Break Times</tag1>\r\n";

?></h4>



<table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">

		<thead>

								<tr>

		<td colspan="12" class="paging"><?php echo($paging_block);?></td>

</tr>

					<tr>

								  <td class="col-head2">Agent</td>

	<td class="col-head2">CRM Status</td>

			<td class="col-head2">Start Time</td>

											<td class="col-head2">End Time</td>

											<td class="col-head2">Time Difference</td>                                                                        

											

								</tr>

		</thead>

</table>

<div class="box-container" style="overflow-y: auto; height: 350px;"  >                    

<?php



{

?>



<table class="table-short">



					<?php $stringData .= "<tag2>CRM Status</tag2>, <tag2>Start Time</tag2>, <tag2>End Time</tag2>, <tag2>Time Difference</tag2>\r\n";  ?>

		<tbody>

					<?php while(!$rs_b_t->EOF){ ?>

					<?php

														if($rs_b_t->fields["crm_status"] == 1){

																	$str ="Online";

														}

														else if($rs_b_t->fields["crm_status"] == 2){

																	$str ="Namaz Break";

														}

														else if($rs_b_t->fields["crm_status"] == 3){

																	$str ="Lunch Break";

														}

														else if($rs_b_t->fields["crm_status"] == 4){

																	$str ="Tea Break";

														}

														else if($rs_b_t->fields["crm_status"] == 5){

																	$str ="Break";

														}

														else if($rs_b_t->fields["crm_status"] == 0){

																				$str ="Offline";

																				

														}

														else if($rs_b_t->fields["crm_status"] == 7){

											$str ="Campaign";



							}



														else {

																				$str ="Unkown";

														}                                                                                                                                                                                                                                                           

											?>

					<tr class="odd">

								

								

								<td class="col-first"><?php 

																	//echo($rs_b_t->fields["staff_id"]);

																	

																	$name=$reports->get_agents_name($rs_b_t->fields["staff_id"]);

																	while (!$name->EOF){

																	echo $name->fields['full_name'];$name->MoveNext();}

																	

																	?> </td>

<td class="col-first"><?php echo $str; ?> </td>

											<td class="col-first"><?php echo($rs_b_t->fields["start_time"]); ?> </td>

											<td class="col-first"><?php echo($rs_b_t->fields["end_time"]); ?> </td>                                       

											<td class="col-first"><?php echo $rs_b_t->fields["duration"]; ?> </td>



								</tr>

					<?php 

					$stringData .= $str.", ".$rs_b_t->fields["start_time"].", ".$rs_b_t->fields["end_time"].", ".$rs_b_t->fields["duration"]."\r\n";

					$rs_b_t->MoveNext();            } ?>

		</tbody>

</table>          

<?php } ?>

</div>

<br />

<!-- ******************************  Agent Assignment Times ************************** -->

<?php  $rs_a_t = $reports->get_agent_assignment_times($search_keyword,$fdate) ?>



<h4 class="white"><?php echo "Assignment Times"; 

//$stringData .= "\r\n\r\n";

$stringData .= "<tag1>Assignment Times</tag1>\r\n";

?></h4>



<table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">

		<thead>

								<tr>

		<td colspan="12" class="paging"><?php echo($paging_block);?></td>

</tr>

					<tr>     <td class="col-head2">Agent</td>

								<td class="col-head2">Assignments</td>

								  <td class="col-head2">Start Time</td>

								<td class="col-head2">End Time</td>

								<td class="col-head2">Duration</td>

								</tr>

		</thead>

</table>



<div class="box-container" style="overflow-y: auto; height: 200px;"  >                    

<?php



{

?>



<table class="table-short">



					<?php $stringData .= "<tag2>Assignments</tag2>, <tag2>Start Time</tag2>, <tag2>End Time</tag2>, <tag2>Duration</tag2>\r\n";  ?>

		<tbody>

					<?php $D="00:00:00"; while(!$rs_a_t->EOF){ ?>

					<tr class="odd">

											<td class="col-first"><?php //echo $rs_a_t->fields["staff_id"];

											

											

																	$name=$reports->get_agents_name($rs_a_t->fields["staff_id"]);

																	while (!$name->EOF){

																	echo $name->fields['full_name'];$name->MoveNext();}

											

											?> </td>

<td class="col-first"><?php echo $rs_a_t->fields["assignment"]; ?> </td>

											<td class="col-first"><?php echo $rs_a_t->fields["start_time"]; ?> </td>

											<td class="col-first"><?php echo $rs_a_t->fields["end_time"]; ?> </td>                                                

											<td class="col-first"><?php $D=$tools_admin->sum_the_time($D,$rs_a_t->fields["duration"]); echo $rs_a_t->fields["duration"]; ?> </td>         

											

								</tr>

					<?php 

					$stringData .= $rs_a_t->fields["assignment"].", ".$rs_a_t->fields["start_time"].", ".$rs_a_t->fields["end_time"].", ".$rs_a_t->fields["duration"]."\r\n";

					$rs_a_t->MoveNext();            } ?>

		</tbody>

</table>                      </div>



<?php }?>        



<!-- *********************************************************************************** -->









</form>







<form name="xForm2" id="xForm2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">



<div style="float:right; margin-top:-5px;">

<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; margin:15px 0 0 20px; color:#fff; font-weight:bold;

font-size:9pt;" >

<span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>

</a>

<input type="hidden" value="export" id="export" name="export" />

<input type="hidden" id="gethtml1" name="gethtml1"/>

</div>

</form>
<? }?>
</div> 



</div>







</div>

</div>  <? $user_agent = $_SERVER['HTTP_USER_AGENT']; 



if (preg_match('/MSIE/i', $user_agent)) { ?>



</div><? 



} ?>

<?php include($site_admin_root."includes/footer.php"); ?>

</body>

</html>


