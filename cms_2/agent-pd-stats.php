<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "agent-pd-stats.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Agent Productivity Stats";
        $page_menu_title = "Agent Productivity Stats";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
    //include ‘library/PHPExcel.php’;
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/reports.php");
	$reports = new reports();
	
	include_once("classes/all_agent.php");

$all_agent = new all_agent();	
?>	
<?php include($site_root."includes/header.php"); ?>	
<!--<meta http-equiv="refresh" content="2">-->

<html>
<head>
<script type="text/javascript">
function getHtml4Excel()
{
//var x;
//x=document.getElementsByTagName("html")[0].innerHTML;
//x=document.documentElement.innerHTML;
document.getElementById("gethtml1").value = document.getElementById("agent_pd_report").innerHTML;

//alert(document.getElementById("gethtml1").value);

}
//function getHtml4Pdf()
//{
////var x;
////x=document.getElementsByTagName("html")[0].innerHTML;
////x=document.documentElement.innerHTML;
//document.getElementById("gethtml2").value = document.getElementById("agent_pd_report").innerHTML;
////alert(document.documentElement.innerHTML);
//}
</script>
</head>
<body>

<?php
//$search_keyword="";
if(isset($_REQUEST['search_date']))
{
	//$keywords			= $_REQUEST['keywords'];
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	//$tdate		 		= $_REQUEST['tdate'];
	
//	echo $search_keyword	;exit;

	
			if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"]))
			{	
				//$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
				
			}	
		
}else
{
	$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
	//$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];
	//$keywords 		= empty($_REQUEST["keywords"])?"":$_REQUEST["keywords"];
	$search_keyword = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];
	
}
	
?>

<?php	

	$recStartFrom = 0;
	$field = empty($_REQUEST["field"])?"staff_updated_date":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"asc":$_REQUEST["order"];
	$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>

<?php 
/************************* Export to Excel ******************/
//if(isset($_REQUEST['export'])){}
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

$db_export_fix = $site_root."download/Productivity_Report.xlsx";

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
	//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
	$db_export_fix = $site_root."download/Productivity_Report.csv";
	//echo $stringData; exit;
	 
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
								
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'Productivity_Records.pdf', 'D', 160, 16, 1);
	exit();
}
///******************************************************************************/	
$stringData	 = '';
?>

<div>
<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELaF']; ?>" method="post" class="middle-forms cmxform"   onsubmit="">

<div id="mid-col" class="mid-col">
	<div class="box">
	 
	<h4 class="white">

	<div>
	Date :
	 <label>
		<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo  date('d-m-Y', strtotime($fdate)); ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">
	</label>
	<div style="float:right;">
	<div class="box">
<?php  include($site_admin_root."includes/date_hour_search_bar.php"); ?>

</div>
	<label>
		
		<!--$table,$combo_id="id",$value_feild="id",$text_feild="title",$combo_selected="",$disabled,$class="",$onchange="",$title="",$condtion=''-->      <?php //echo $search_keyword;?>
		<?php echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name",$search_keyword,false,"form-select","","Agent"," designation = 'Agents' "); ?>
		</label>
		 <a class="button" href="javascript:document.xForm.submit();" >
		 <span>Search</span>
		 </a>
		<input type="hidden" value="Search >>" id="search_date" name="search_date" />			
	<div>
	</div>
	</h4>
	
	<br />
	
<div id="agent_pd_report">
	<? if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])) {  ?>
	<h4 class="white"><?php 
	$rs_agent_name = $admin->get_agent_name($search_keyword);
	//print_r($search_keyword);
	echo "Agent Productivity Report  <br> Agent Name - ".$rs_agent_name->fields["full_name"]." <br> Department- ".$rs_agent_name->fields["department"]." <br> Date: ".$fdate; 
	$stringData .= "<tag1>Agent Productivity Report</tag1>\r\n";
	$stringData .= "<tag3>Agent Name - ".$rs_agent_name->fields["full_name"]."</tag3>\r\n<tag3>Date: ".$fdate."</tag3>\r\n";
	?></h4>
	<br />
	<h4 class="white"><?php 
	
	echo "Working Times"; 
	$stringData .= "<tag1>Work Times</tag1>\r\n";
	?></h4>
   <?php $fdate = date('Y-m-d', strtotime($fdate));  $rs_w_t = $reports->get_agent_work_times($search_keyword,$fdate);$trec = $rs_w_t->fields["trec"]; ?>
   		  
        <div class="box-container"  >  		
      	<?php 
	//if($search_keyword == '' || $search_keyword == 0 || $search_keyword == '0' || $trec == 0){}
	//else{
	{
	?>
		<table class="table-short">
      			<thead>
					<tr>
	                	<td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		    </tr>
      				<tr>
					   <td class="col-head2">Agent Name</td>
	        	        <td class="col-head2">Online Time</td>
		                <td class="col-head2">Offline Time</td>
						<td class="col-head2">Time Duration</td>
						
					</tr>
      			</thead>
				<?php $stringData .= "<tag2>Login Time</tag2>, <tag2>Log Out Time</tag2>, <tag2>Time Duration</tag2>\r\n";  ?>
      			<tbody>
				<?php 
				$sum_worktime = "00:00:00"; 
				//print_r($rs_w_t->fields);
				while(!$rs_w_t->EOF){ ?>
      				<tr class="odd">
					  <td class="col-first"><?php 
					  
					  $name=$reports->get_agents_name($rs_w_t->fields["staff_id"]);		
	                   while (!$name->EOF){
								echo $name->fields['full_name']; $name->MoveNext();}
					  
					 $login_time =  ($rs_w_t->fields["max_logout_time"] == $rs_w_t->fields["login_time"])?'<span style="color:red">Logged In</span>' : date("h:i:s A",strtotime($rs_w_t->fields["logout_time"]))
					 // echo $rs_w_t->fields["login_time"];?> </td>
                        <td class="col-first"><?php echo date("h:i:s A",strtotime($rs_w_t->fields["login_time"]));?> </td>
						<td class="col-first"><?php echo $login_time; ?> </td>
						<td class="col-first"><?php $A=$rs_w_t->fields["duration"]; 
						//$sum_worktime +=  ($rs_w_t->fields["duration"]);
						
					$sum_worktime =	$tools_admin->sum_the_time($sum_worktime,$rs_w_t->fields["duration"]);
						
						echo ($rs_w_t->fields["duration"]); ?> </td>				
						
					</tr>
				<?php 
				$stringData .= date("h:i:s A",strtotime($rs_w_t->fields["login_time"])).", ".$login_time.", ".$rs_w_t->fields["duration"]."\r\n";
				 $rs_w_t->MoveNext(); 	} ?>
      			</tbody>
      		</table>  	
<?php } ?>
      	</div>
		
		<br />
<!-- ******************************  Agent Break Times SUM ************************** -->
 <?php  $rs_bs_t = $reports->get_agent_break_times_sum($search_keyword,$fdate) ?>

		 <h4 class="white"><?php echo "Break Times Summary";?></h4>
		 <?php //$stringData .= "\r\n\r\n";
		 $stringData .= "<tag1>Break Times Summary</tag1>\r\n";
		 ?>
		<div class="box-container" >  		
<?php
//if($search_keyword == '' || $search_keyword == 0 || $search_keyword == '0' || $trec == 0){}
//else{
{
?>
      	
	<table class="table-short">
      			<thead>
					<tr>
	                	<td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		    </tr>
      				<tr>
	        	        <td class="col-head2">CRM Status</td>
						<td class="col-head2">Time Difference</td>						
						
					</tr>
      			</thead>
				<?php $stringData .= "<tag2>CRM Status</tag2>, <tag2>Time Difference Summary</tag2>\r\n";  ?>
      			<tbody>
				<?php 
					$B = "00:00:00"; 
					$i = 0;
					$arr_names 	= array("Namaz Break","Lunch Break","Tea Break","Auxiliary Break","Campaign");
					$arr_values = array('2','3','4','5','7');
					$duration	= array();
				?>
				<?php
				while($i < 4 /*!$rs_bs_t->EOF*/){ 
					if($arr_values[$i] == $rs_bs_t->fields["crm_status"]){
						
						$B=$tools_admin->sum_the_time($B,$rs_bs_t->fields["duration"]);
						$duration[$i] = $rs_bs_t->fields["duration"];
						$rs_bs_t->MoveNext();
					}
					else{
						$duration[$i] = "-";
					}														
				?>
				<?php 
					$i++;
				} 
				?>
				<?php for($i=0; $i<4; $i++){?>
					<tr class="odd">
                        <td class="col-first">
						<?php 
							echo $arr_names[$i];
							$stringData .= $crm_status[$i].", ".$duration[$i]." \r\n";
						?> 
						</td>			
						<td class="col-first"><?php echo $duration[$i]; ?></td>
					</tr>
				<?php }?>
      			</tbody>
      		</table>  	
<?php }?>
      	</div>
	
		
		<br />		
<!-- ******************************  Agent On Call and Busy Times ************************** -->

<?php  $rs_c_b_t = $reports->get_agent_on_call_busy_times($search_keyword,$fdate);

		//$abandoned_call = $reports->get_agent_abandon_calls2($search_keyword,$fdate,$staff_id); ?>
		 <h4 class="white"><?php echo "On Call & Busy Times"; 
		 //$stringData .= "\r\n\r\n";
		 $stringData .= "<tag1>On Call & Busy Times</tag1>\r\n";
		 ?></h4>
		<div class="box-container"   >  	
<?php
//if($search_keyword == '' || $search_keyword == 0 || $search_keyword == '0' || $trec == 0){}
//else{
{
?>
      	
	<table class="table-short">
      			<thead>
					<tr>
	                	<td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		    </tr>
      				<tr>
					 <td class="col-head2">Agent Name</td>
	        	        <td class="col-head2">Call Type</td>
						<td class="col-head2">No of Calls</td>
						<td class="col-head2">Abandoned Calls</td>
		                <td class="col-head2">On Call Time</td>
						<td class="col-head2">Busy Time</td>
					</tr>
      			</thead>
				<?php $stringData .= "<tag2>Call Type</tag2>, <tag2>No of Calls</tag2>, <tag2>Abandoned Calls</tag2>, <tag2>On Call Time</tag2>, <tag2>Busy Time</tag2>\r\n";  ?>
      			<tbody>
				<?php $E="00:00:00"; $F="00:00:00"; while(!$rs_c_b_t->EOF){ ?>
      				<tr class="odd">
					
					<td class="col-first"><?php 
					
						$name=$reports->get_agents_name($rs_c_b_t->fields["staff_id"]);
								while (!$name->EOF){
								echo $name->fields['full_name'];$name->MoveNext();}
					
					
					 ?> </td>
					
                      	<td class="col-first"><?php echo str_replace("OUTBOUND","OUTGOING",$rs_c_b_t->fields["call_type"]); ?> </td>
						<td class="col-first"><?php echo $rs_c_b_t->fields["cnt"];?> </td>
						<td class="col-first"><?php 
						
						//echo $rs_c_b_t->fields["staff_id"];
					
					$staff_id = $rs_c_b_t->fields["staff_id"];	
								$abandoned_call = $reports->get_agent_abandon_calls2($search_keyword,$fdate,$staff_id);
						$agent_abandoned_calls = $rs_c_b_t->fields["call_type"]=="INBOUND"?$abandoned_call:""; echo $agent_abandoned_calls;?> </td>
						<td class="col-first"><?php $E=$tools_admin->sum_the_time($E,$rs_c_b_t->fields["call_duration"]); echo($rs_c_b_t->fields["call_duration"]); ?> </td>
						<td class="col-first"><?php $F=$tools_admin->sum_the_time($F,$rs_c_b_t->fields["busy_duration"]); echo($rs_c_b_t->fields["busy_duration"]); ?> </td>				

					</tr>
				<?php				
				$stringData .= str_replace("OUTBOUND","OUTGOING",$rs_c_b_t->fields["call_type"]).",".$rs_c_b_t->fields["cnt"].", ".$agent_abandoned_calls.", ".$rs_c_b_t->fields["call_duration"].", ".$rs_c_b_t->fields["busy_duration"]."\r\n";
				$rs_c_b_t->MoveNext();
				} 
				?>
      			</tbody>
      		</table>  	
<?php } ?>
      	</div>
		<br />
		<?php

/*
			//$sum_worktime
			$C=$tools_admin->sub_the_time($sum_worktime,$B);
			//$C=$tools_admin->sub_the_time($A,$B);
			//echo "farhan".$C."--".$A."--".$B;
			$G=$tools_admin->sum_the_time($D,$E);
			$G=$tools_admin->sum_the_time($G,$F);
			$H=$tools_admin->sub_the_time($C,$G);						
		?>
	  <h4 class="white">Work Timing Distribution</h4>
<div class="box-container"> 
<?php 
//if($search_keyword == '' || $search_keyword == 0 || $search_keyword == '0' || $trec == 0){}
//else{
{
?>
<table > 	
	
		<tr class="odd"><td>Work Time (A): </td><td><b><?php //echo $A;
		echo $sum_worktime;
		
	
		
		 ?> </b></td></tr>
		<tr class="odd"><td>Break Time(B):</td><td><b><?php echo $B;?></b></td></tr>
		<tr class="odd"><td>Effective Work Time Available (C):&nbsp;</td><td><b><?php echo $C;?></b></td></tr>
				<tr class="odd"><td>Assignment Time (D):</td><td><b><?php echo $D;?></b></td></tr>
				<tr class="odd"><td>On Call Time (E):</td><td><b><?php echo $E;?></b></td></tr>
				<tr class="odd"><td>Busy Time (F):</td><td><b><?php echo $F;?></b></td></tr>		
		<tr class="odd"><td>Work Time Utilized (G):</td><td>	<b><?php echo $G;?></b>	</td></tr>		
		<tr class="odd"><td>Free Time (H):</td><td><b><?php echo $H;?></b></td></tr>
		
	</table>

	<?php
		//$stringData .= "\r\n\r\n";
		$stringData .= "<tag1>Work Timing Distribution</tag1>\r\n";
		$stringData .= "Work Time (A):, ".$sum_worktime."\r\n";
		$stringData .= "Break Time(B):, ".$B."\r\n";
		$stringData .= "Effective Work Time Available (C):, ".$C."\r\n";
		$stringData .= "Assignment Time (D):, ".$D."\r\n";
		$stringData .= "On Call Time (E):, ".$E."\r\n";
		$stringData .= "Busy Time (F):, ".$F."\r\n";
		$stringData .= "Work Time Utilized (G):, ".$G."\r\n";
		$stringData .= "Free Time (H):, ".$H."\r\n";
	?>
<?php } ?>
</div>	
*/?>
	<br />
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
//if($search_keyword == '' || $search_keyword == 0 || $search_keyword == '0' || $trec == 0){}
//else{
{
?>
      
		<table class="table-short">
<!--      			<thead>
					<tr>
	                	<td colspan="12" class="paging"><?php// echo($paging_block);?></td>
        		    </tr>
      				<tr>
	        	        <td class="col-head2">CRM Status</td>
		                <td class="col-head2">Start Time</td>
						<td class="col-head2">End Time</td>
						<td class="col-head2">Time Difference</td>						
						
					</tr>
      			</thead>-->
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
								$str ="Auxiliary Break";
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
						<td class="col-first"><?php echo date("h:i:s A",strtotime($rs_b_t->fields["start_time"])); ?> </td>
						<td class="col-first"><?php echo date("h:i:s A",strtotime($rs_b_t->fields["end_time"])); ?> </td>				
						<td class="col-first"><?php echo $rs_b_t->fields["duration"]; ?> </td>

					</tr>
				<?php 
				$stringData .= $str.", ".date("h:i:s A",strtotime($rs_b_t->fields["start_time"])).", ".date("h:i s A",strtotime($rs_b_t->fields["end_time"])).", ".$rs_b_t->fields["duration"]."\r\n";
				$rs_b_t->MoveNext();	} ?>
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
      				<tr>	<td class="col-head2">Agent</td>
	        	      			<td class="col-head2">Assignments</td>
				              <td class="col-head2">Start Time</td>
					<td class="col-head2">End Time</td>
					<td class="col-head2">Duration</td>
					</tr>
      			</thead>
		</table>
		 
		<div class="box-container" style="overflow-y: auto; height: 200px;"  >  		
<?php
//if($search_keyword == '' || $search_keyword == 0 || $search_keyword == '0' || $trec == 0){}
//else{
{
?>
      	
	<table class="table-short">
<!--      			<thead>
					<tr>
	                	<td colspan="12" class="paging"><?php// echo($paging_block);?></td>
        		    </tr>
      				<tr>
	        	      			<td class="col-head2">Assignments</td>
				              <td class="col-head2">Start Time</td>
					<td class="col-head2">End Time</td>
					<td class="col-head2">Duration</td>
					</tr>
      			</thead>-->
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
						<td class="col-first"><?php echo date("h:i:s A",strtotime($rs_a_t->fields["start_time"])); ?> </td>
						<td class="col-first"><?php echo date("h:i:s A",strtotime($rs_a_t->fields["end_time"])); ?> </td>				
						<td class="col-first"><?php $D=$tools_admin->sum_the_time($D,$rs_a_t->fields["duration"]); echo $rs_a_t->fields["duration"]; ?> </td>	
						
					</tr>
				<?php 
				$stringData .= $rs_a_t->fields["assignment"].", ".date("h:i:s A",strtotime($rs_a_t->fields["start_time"])).", ".date("h:i:s A",strtotime($rs_a_t->fields["end_time"])).", ".$rs_a_t->fields["duration"]."\r\n";
				$rs_a_t->MoveNext();	} ?>
      			</tbody>
      		</table>  	
<?php } ?>
      	</div>
		
<!-- *********************************************************************************** -->
	

                <br />
                <?php

                        //$sum_worktime
                        $C=$tools_admin->sub_the_time($sum_worktime,$B);
                        //$C=$tools_admin->sub_the_time($A,$B);
                        //echo "farhan".$C."--".$A."--".$B;
                        $G=$tools_admin->sum_the_time($D,$E);
                        $G=$tools_admin->sum_the_time($G,$F);
                        $H=$tools_admin->sub_the_time(str_replace('-','',$C),$G);
                        //echo $C;
                		//echo "<br/>";
                	   //echo $G;
                ?>
          <h4 class="white">Work Timing Distribution</h4>
<div class="box-container">
<?php
//if($search_keyword == '' || $search_keyword == 0 || $search_keyword == '0' || $trec == 0){}
//else{
{
?>
<table >

                <tr class="odd"><td>Work Time (A): </td><td><b><?php //echo $A;
                echo $sum_worktime;



                 ?> </b></td></tr>
                <tr class="odd"><td>Break Time(B):</td><td><b><?php echo $B;?></b></td></tr>
                <tr class="odd"><td>Effective Work Time Available (C):&nbsp;</td><td><b><?php echo $C;?></b></td></tr>
                                <tr class="odd"><td>Assignment Time (D):</td><td><b><?php echo $D;?></b></td></tr>
                                <tr class="odd"><td>On Call Time (E):</td><td><b><?php echo $E;?></b></td></tr>
                                <tr class="odd"><td>Busy Time (F):</td><td><b><?php echo $F;?></b></td></tr>
                <tr class="odd"><td>Work Time Utilized (G):</td><td>    <b><?php echo $G;?></b> </td></tr>
                <tr class="odd"><td>Free Time (H):</td><td><b><?php echo str_replace('-','',$H);?></b></td></tr>
				
				</tr>
                <tr class="odd"><td>Hold Time (I):</td><td><b><?php 
	$hold_time = $all_agent->get_agent_on_call_hold_times2(	$search_keyword,$_REQUEST['fdate'],'');	
	
	if ($hold_time->fields["holdtime"] == ''){echo "00:00:00";} else {echo $hold_time->fields["holdtime"]; $I = $hold_time->fields["holdtime"];   } ?></b></td></tr>
				
				

        </table>

        <?php
                //$stringData .= "\r\n\r\n";
                $stringData .= "<tag1>Work Timing Distribution</tag1>\r\n";
                $stringData .= "Work Time (A):, ".$sum_worktime."\r\n";
                $stringData .= "Break Time(B):, ".$B."\r\n";
                $stringData .= "Effective Work Time Available (C):, ".$C."\r\n";
                $stringData .= "Assignment Time (D):, ".$D."\r\n";
                $stringData .= "On Call Time (E):, ".$E."\r\n";
                $stringData .= "Busy Time (F):, ".$F."\r\n";
                $stringData .= "Work Time Utilized (G):, ".$G."\r\n";
                $stringData .= "Free Time (H):, ".$H."\r\n";
				  $stringData .= "Hold Time (I):, ".$I."\r\n";
				
				
        ?> 
<?php }  ?>
</div>          <br />
      <!--</div> 
	</div>-->
	
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



<!--<form action="<?php //echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">

	<div style="float:right; margin-right:-15px;"">
		 <a class="button" href="javascript:document.xForm3.submit();" >
		 <span>Export PDF</span>
		 </a>
		<input type="hidden" value="exportpdf" id="export_pdf" name="export_pdf" />
		
		<input type="hidden" value="<?php //echo $stringData; ?>" id="stringData"		name="stringData" />
	</div>
</form>--><? } ?></div></div>

</div>
</div>
<?php  include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
