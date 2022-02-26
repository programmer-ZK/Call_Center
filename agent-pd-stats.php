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
<style>
input[type="search"],
.dt-buttons,
.dataTables_length ,.dataTables_paginate {
margin-top: 10px;
}
</style>

<html>
<head>
<script type="text/javascript">
function getHtml4Excel()
	{
	document.getElementById("gethtml1").value = document.getElementById("agent_pd_report").innerHTML;
	}
</script>
</head>
<body>

<?php
if(isset($_REQUEST['search_date']))
{
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];


}else
{
	$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
	$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];
	$search_keyword = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];

}

?>

<?php	
	$recStartFrom = 0;
	$field = empty($_REQUEST["field"])?"staff_updated_date":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"asc":$_REQUEST["order"];
	$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
?>
<div>

<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELaF']; ?>" method="post" class="middle-forms cmxform"   onsubmit="">

<div id="mid-col" class="mid-col">
<div class="box">

<h4 class="white">

<div>

From :
<label>
<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo  date('d-m-Y', strtotime($fdate)); ?>" autocomplete="off" readonly onClick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">

</label>
Date :
<label>
<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['tdate']) ? date('d-m-Y', strtotime($_REQUEST['tdate'])) : $tdate = date('d-m-Y'); ?>" autocomplete="off" readonly onClick="javascript:NewCssCal ('tdate','ddMMyyyy', 'dropdown')">

</label>
<label>

<?php echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name",$search_keyword,false,"form-select","","Agent"," designation = 'Agents' "); ?>
</label>
<a class="button" href="javascript:document.xForm.submit();" >
<span>Search</span>
</a>
<input type="hidden" value="Search >>" id="search_date" name="search_date" />		
<div>
<div class="box">


</div>

<div>
</div>
</h4>

<br />



<div id="agent_pd_report">
<? if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"])) {  ?>
<h4 class="white"><?php 
$rs_agent_name = $admin->get_agent_name($search_keyword);
echo "Agent Productivity Report  <br> Agent Name - ".$rs_agent_name->fields["full_name"]." <br> Department- ".$rs_agent_name->fields["department"]." <br> Date: ".$fdate."-".$tdate; 
$stringData .= "<tag1>Agent Productivity Report</tag1>\r\n";
$stringData .= "<tag3>Agent Name - ".$rs_agent_name->fields["full_name"]."</tag3>\r\n<tag3>Date: ".$fdate."-".$tdate."</tag3>\r\n";

?></h4>
<br />




<br />
<h4 class="white"><?php 

echo "Working Times"; 
$stringData .= "<tag1>Work Times</tag1>\r\n";
?></h4>
<?php 
$fdate = date('Y-m-d', strtotime($fdate));
$tdate = date('Y-m-d', strtotime($tdate));
$rs_w_t = $reports->get_agent_work_times($search_keyword,$fdate,$tdate);
$trec = $rs_w_t->fields["trec"]; ?>

<div class="box-container"   >  		

<table class="table-short" id="tbl1">
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
$c1;
$sum_worktime = "00:00:00"; 
while(!$rs_w_t->EOF){ ?>
<tr class="odd">
<td class="col-first">
<?php 
$name=$reports->get_agents_name($rs_w_t->fields["staff_id"]);		
while (!$name->EOF){
echo $name->fields['full_name']; $name->MoveNext();
}

$login_time =  ($rs_w_t->fields["max_logout_time"] == $rs_w_t->fields["login_time"])?'<span style="color:red">Logged In</span>' : date("Y-m-d H:i:s",strtotime($rs_w_t->fields["logout_time"]))?> </td>
<td class="col-first"><?php echo date("Y-m-d H:i:s",strtotime($rs_w_t->fields["login_time"]));?> </td>
<td class="col-first"><?php echo $login_time; ?> </td>
<td class="col-first"><?php $A=$rs_w_t->fields["duration"]; 
//$sum_worktime +=  ($rs_w_t->fields["duration"]);

$sum_worktime =	$tools_admin->sum_the_time($sum_worktime,$rs_w_t->fields["duration"]);

echo ($rs_w_t->fields["duration"]); ?> </td>				

</tr>
<?php 
$stringData .= date("Y-m-d h:i:s A",strtotime($rs_w_t->fields["login_time"])).", ".$login_time.", ".$rs_w_t->fields["duration"]."\r\n";
$rs_w_t->MoveNext();
$c1++; 	} ?>
</tbody>
</table>  	


</div>

<br />
<!-- ******************************  Agent Break Times SUM ************************** -->
<?php  $rs_bs_t = $reports->get_agent_break_times_sum($search_keyword,$fdate, $tdate) ?>

<h4 class="white"><?php echo "Break Times Summary";?></h4>
<?php //$stringData .= "\r\n\r\n";
$stringData .= "<tag1>Break Times Summary</tag1>\r\n";
?>
<div class="box-container" >  		

<table class="table-short" id="tbl2">
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
$c2;
$B = "00:00:00"; 
$_SESSION['bt'] = "00:00:00"; 
$i = 0;
$arr_names 	= array("Namaz Break","Lunch Break","Tea Break","Auxiliary Break","Campaign");
$arr_values = array('2','3','4','5','7');
$duration	= array();
?>
<?php
	while($i < 4 /*!$rs_bs_t->EOF*/){ 
		if($arr_values[$i] == $rs_bs_t->fields["crm_status"]) {
			$B=$tools_admin->sum_the_time($B,$rs_bs_t->fields["duration"]);
					$_SESSION['bt'] =$tools_admin->sum_the_time($_SESSION['bt'],$rs_bs_t->fields["duration"]);
			$duration[$i] = $rs_bs_t->fields["duration"];
			$rs_bs_t->MoveNext();
			$c2++;
		} else {
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
</div>


<br />		
<!-- ******************************  Agent On Call and Busy Times ************************** -->

<?php  $rs_c_b_t = $reports->get_agent_on_call_busy_times_new_live($search_keyword,$fdate,$tdate);
?>
<h4 class="white"><?php echo "Answered Calls"; 
$stringData .= "<tag1>Answered Calls</tag1>\r\n";
?></h4>
<div class="box-container"   >  	


<table class="table-short" id="tbl3">
<thead>
<tr>
<td colspan="12" class="paging"><?php echo($paging_block);?></td>
</tr>
<tr>
<td class="col-head2">Agent Name</td>
<td class="col-head2">Call Type</td>
<td class="col-head2">No of Calls</td>
<!--<td class="col-head2">Drop Calls</td>-->
<td class="col-head2">On Call Time</td>
<td class="col-head2">Busy Time</td>
</tr>
</thead>
<?php $stringData .= "<tag2>Call Type</tag2>, <tag2>No of Calls</tag2>, <tag2>On Call Time</tag2>, <tag2>Busy Time</tag2>\r\n";  ?>
<tbody>
<?php
$E="00:00:00";
$F="00:00:00";
while(!$rs_c_b_t->EOF){ ?>
<tr class="odd">

<td class="col-first"><?php 
$c3;
$name=$reports->get_agents_name($rs_c_b_t->fields["staff_id"]);
while (!$name->EOF){
echo $name->fields['full_name'];$name->MoveNext();}


?> </td>

<td class="col-first"><?php echo str_replace("OUTBOUND","OUTGOING",$rs_c_b_t->fields["call_type"]); ?> </td>
<td class="col-first"><?php echo $rs_c_b_t->fields["cnt"];?> </td>
<!--<td class="col-first"><?php 

//echo $rs_c_b_t->fields["staff_id"];

$staff_id = $rs_c_b_t->fields["staff_id"];	
$abandoned_call = $reports->get_agent_drop_calls2($search_keyword,$fdate,$staff_id);
$agent_abandoned_calls = $rs_c_b_t->fields["call_type"]=="INBOUND"?$abandoned_call:"";
 echo $agent_abandoned_calls;
 ?> </td>-->
<td class="col-first"><?php $E=$tools_admin->sum_the_time($E,$rs_c_b_t->fields["call_duration"]); echo($rs_c_b_t->fields["call_duration"]); ?> </td>
<td class="col-first"><?php $F=$tools_admin->sum_the_time($F,$rs_c_b_t->fields["busy_duration"]); echo($rs_c_b_t->fields["busy_duration"]); ?> </td>				

</tr>
<?php				
$stringData .= str_replace("OUTBOUND","OUTGOING",$rs_c_b_t->fields["call_type"]).",".$rs_c_b_t->fields["cnt"].", ".$rs_c_b_t->fields["call_duration"].", ".$rs_c_b_t->fields["busy_duration"]."\r\n";
$rs_c_b_t->MoveNext();
$c3++;
} 
?>
</tbody>
</table>  	
</div>
<br />
<?php

?>
<br />


<!-- ******************************  Agent On Call and Busy Times ************************** -->



<?php  $rs_c_b_t = $reports->get_agent_on_call_busy_times_new_live2($search_keyword,$fdate,$tdate);

?>

<h4 class="white"><?php echo "Drop Calls"; 

$stringData .= "<tag1>Drop Calls</tag1>\r\n";

?></h4>

<div class="box-container"   >  	





<table class="table-short" id="tbl4">

<thead>

<tr>

<td colspan="12" class="paging"><?php echo($paging_block);?></td>

</tr>

<tr>

<td class="col-head2">Agent Name</td>

<td class="col-head2">Call Type</td>

<td class="col-head2">No of Drop Calls</td>

<!--<td class="col-head2">Drop Calls</td>-->

</tr>

</thead>

<?php $stringData .= "<tag2>Call Type</tag2>, <tag2>No of Drop Calls</tag2>\r\n";  ?>

<tbody>

<?php
$c4;  while(!$rs_c_b_t->EOF){ ?>

<tr class="odd">



<td class="col-first"><?php 



$name=$reports->get_agents_name($rs_c_b_t->fields["staff_id"]);

while (!$name->EOF){

echo $name->fields['full_name'];$name->MoveNext();
$c4++;}


?> </td>



<td class="col-first"><?php echo str_replace("OUTBOUND","OUTGOING",$rs_c_b_t->fields["call_type"]); ?> </td>

<td class="col-first"><?php echo $rs_c_b_t->fields["cnt"];?> </td>

</tr>

<?php				

$stringData .= str_replace("OUTBOUND","OUTGOING",$rs_c_b_t->fields["call_type"]).",".$rs_c_b_t->fields["cnt"]."\r\n";

$rs_c_b_t->MoveNext();

} 

?>

</tbody>

</table>  	

</div>

<br />

<?php



?>

<br />


<!-- ******************************  Agent Break Times ************************** -->
<?php  $rs_b_t = $reports->get_agent_break_times_new_live($search_keyword,$fdate,$tdate) ?>

<h4 class="white"><?php echo "Break Times"; 
//$stringData .= "\r\n\r\n";
$stringData .= "<tag1>Break Times</tag1>\r\n";
?></h4>
<div class="" >
<table class="table-short" id="tbl5" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
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
<tbody>
<?php
$c5; while(!$rs_b_t->EOF){ ?>
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
echo $name->fields['full_name'];$name->MoveNext();
$c5++;}

?> </td>
<td class="col-first"><?php echo $str; ?> </td>
<td class="col-first"><?php echo date("Y-m-d h:i:s",strtotime($rs_b_t->fields["start_time"])); ?> </td>
<td class="col-first"><?php echo date("Y-m-d h:i:s",strtotime($rs_b_t->fields["end_time"])); ?> </td>				
<td class="col-first"><?php echo $rs_b_t->fields["duration"]; ?> </td>

</tr>
<?php 
$stringData .= $str.", ".date("Y-m-d h:i:s A",strtotime($rs_b_t->fields["start_time"])).", ".date("Y-m-d h:i s A",strtotime($rs_b_t->fields["end_time"])).", ".$rs_b_t->fields["duration"]."\r\n";
$rs_b_t->MoveNext();	} ?>
</tbody>
</table>
</div>

<br />
<!-- ******************************  Agent Assignment Times ************************** -->
<?php  $rs_a_t = $reports->get_agent_assignment_times_new_live($search_keyword,$fdate,$tdate) ?>

<h4 class="white"><?php echo "ACW Times"; 
$stringData .= "<tag1>ACW Times</tag1>\r\n";
?></h4>

<table class="table-short" id="tbl6" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
<thead>
<tr>
<td colspan="12" class="paging">
<?php echo($paging_block);?></td>
</tr>
<tr>	<td class="col-head2">Agent</td>
<td class="col-head2">ACW</td>
<td class="col-head2">Start Time</td>
<td class="col-head2">End Time</td>
<td class="col-head2">Duration</td>
</tr>
</thead>
<tbody>
<?php $D="00:00:00"; 
$c6;while(!$rs_a_t->EOF){ ?>
<tr class="odd">
<td class="col-first"><?php 


$name=$reports->get_agents_name($rs_a_t->fields["staff_id"]);
while (!$name->EOF){
echo $name->fields['full_name'];$name->MoveNext();}

?> </td>
<td class="col-first"><?php echo $rs_a_t->fields["assignment"]; ?> </td>
<td class="col-first"><?php echo date("Y-m-d h:i:s",strtotime($rs_a_t->fields["start_time"])); ?> </td>
<td class="col-first"><?php echo date("Y-m-d h:i:s",strtotime($rs_a_t->fields["end_time"])); ?> </td>				
<td class="col-first"><?php $D=$tools_admin->sum_the_time($D,$rs_a_t->fields["duration"]); echo $rs_a_t->fields["duration"]; ?> </td>	

</tr>
<?php 
$stringData .= $rs_a_t->fields["assignment"].", ".date("Y-m-d h:i:s A",strtotime($rs_a_t->fields["start_time"])).", ".date("Y-m-d h:i:s A",strtotime($rs_a_t->fields["end_time"])).", ".$rs_a_t->fields["duration"]."\r\n";
$rs_a_t->MoveNext();
$c6++;	} ?>
</tbody>
</table>

<br>
<!-- *********************************************************************************** -->

<?php  $rs_a_t_nh = $reports->get_agent_hold_times_new_live($search_keyword,$fdate,$tdate) 

?>

<h4 class="white"><?php echo "Hold Times";
$stringData .= "<tag1>Hold Times</tag1>\r\n";
?></h4>

<table class="table-short" id="tbl8" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
<thead>
<tr>
														<td colspan="12" class="paging">
																		<?php echo($paging_block);?></td>
</tr>
<tr>    <td class="col-head2">Agent</td>
		<td class="col-head2">Caller ID</td>
	<td class="col-head2">Hold Time</td>
</tr>
</thead>
		<tbody>
<?php
$c6;while(!$rs_a_t_nh->EOF){ ?>
<tr class="odd">
<td class="col-first"><?php


										$name=$reports->get_agents_name($rs_a_t_nh->fields["staff_id"]);
										while (!$name->EOF){
										echo $name->fields['full_name'];$name->MoveNext();}   

			?> </td>   
<td class="col-first"><?php echo $rs_a_t_nh->fields["caller_id"]; ?> </td>
		<td class="col-first"><?php
$dunique=$rs_a_t_nh->fields["unique_id"];
$rs_a_t_nh_time = $reports->get_agent_hold_times_new_live_times($dunique);
echo $rs_a_t_nh_time->fields["hold_time"]; 
?> </td>
</tr>
<?php
$stringData .= $rs_a_t_nh->fields["caller_id"].", ".date("Y-m-d h:i:s A",strtotime($rs_a_t_nh->fields["hold_time"]))."\r\n";
$rs_a_t_nh->MoveNext();
$c6++;  } ?>
</tbody>
</table>



<!-- *********************************************************************************** -->


<br />
<?php

$C=$tools_admin->sub_the_time_new_live($sum_worktime,$B);
//$C=$tools_admin->sum_the_time($C,$D);
$G=$tools_admin->sum_the_time_new_live($D,$E);
$H=$tools_admin->sub_the_time_new_live(str_replace('-','',$C),$G);
$I_new=$reports->get_agent_hold_times_new_live_agents($search_keyword,$fdate,$tdate);
$I=$I_new->fields["hold_time"]
?>
<h4 class="white">Work Timing Distribution</h4>
<div class="box-container">

<table id="tbl7" >

<tbody>
<tr class="odd">
<td>Work Time (A): </td>
<td><b><?php echo $sum_worktime;?> </b></td>


<tr class="odd"><td>Break Time(B):</td><td><b><?php echo $B;?></b></td></tr>

<tr class="odd"><td>Effective Work Time Available (C):&nbsp;</td><td><b><?php echo $C;?></b></td></tr>

<tr class="odd"><td>ACW Time (D):</td><td><b><?php echo $D;?></b></td></tr>
<tr class="odd"><td>On Call Time (E):</td><td><b><?php echo $E;?></b></td></tr>
<tr class="odd"><td>Busy Time (F):</td><td><b><?php echo $F;?></b></td></tr>

<tr class="odd"><td>Work Time Utilized (G):</td><td><b><?php echo $G;?></b> </td></tr>
<tr class="odd"><td>Free Time (H):</td><td><b><?php echo str_replace('-','',$H);?></b></td></tr>
<tr class="odd"><td>Hold Time (I):</td><td><b><?php echo str_replace('-','',$I);?></b></td></tr>


</tbody>


</table>

 
</div>          <br />

</form>


</div>
<form action="agent_pd_stats_xl_report.php" method="post" class="middle-forms cmxform" 
name="xForm2" id="xForm2">
<div style="float:right;">
<a class="button" href="javascript:document.xForm2.submit();"><span>Export EXCEL</span></a>
<input type="hidden" value="export_xl" id="export_xl" name="export_xl" />
<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword" name="search_keyword" />
<input type="hidden" value="<?php echo $tdate; ?>" id="tdate" name="tdate" />
<input type="hidden" value="<?php echo $fdate; ?>" id="fdate" name="fdate" />
</div>
</form>
<form action="agent_pd_stats_Pdf_report.php" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">
<div style="float:right;">
<a href="javascript:document.xForm3.submit();" class="button" ><span>Export PDF</span> </a>
<input type="hidden" value="export_pdf" id="export_pdf" name="export_pdf" />
<input type="hidden" value="<?php echo $search_keyword; ?>" id="search_keyword" name="search_keyword" />
<input type="hidden" value="<?php echo $tdate; ?>" id="tdate" name="tdate" />
<input type="hidden" value="<?php echo $fdate; ?>" id="fdate" name="fdate" />
</div>
</form>
</div>

</div>
</div>
<script>
$(document).ready(function() {
$('#tbl1').DataTable({
"order": [
[1, "desc"]
],
"language": {
"emptyTable": "No data available",
"lengthMenu": "Show _MENU_ records",
"info": "Showing _START_ to _END_ of _TOTAL_ records",
"infoFiltered": "(filtered from _MAX_ total records)",
"infoEmpty": "No records available",
},
dom: 'lfrtpi',

});
});

$(document).ready(function() {
$('#tbl2').DataTable({
"language": {
"emptyTable": "No data available",
"lengthMenu": "Show _MENU_ records",
"info": "Showing _START_ to _END_ of _TOTAL_ records",
"infoFiltered": "(filtered from _MAX_ total records)",
"infoEmpty": "No records available",
},
dom: 'lfrtpi',

});
});

$(document).ready(function() {
$('#tbl3').DataTable({
"language": {
"emptyTable": "No data available",
"lengthMenu": "Show _MENU_ records",
"info": "Showing _START_ to _END_ of _TOTAL_ records",
"infoFiltered": "(filtered from _MAX_ total records)",
"infoEmpty": "No records available",
},
dom: 'lfrtpi',

});
});

$(document).ready(function() {
$('#tbl4').DataTable({
"language": {
"emptyTable": "No data available",
"lengthMenu": "Show _MENU_ records",
"info": "Showing _START_ to _END_ of _TOTAL_ records",
"infoFiltered": "(filtered from _MAX_ total records)",
"infoEmpty": "No records available",
},
dom: 'lfrtpi',

});
});

$(document).ready(function() {
$('#tbl5').DataTable({
"order": [
[2, "desc"]
],
"language": {
"emptyTable": "No data available",
"lengthMenu": "Show _MENU_ records",
"info": "Showing _START_ to _END_ of _TOTAL_ records",
"infoFiltered": "(filtered from _MAX_ total records)",
"infoEmpty": "No records available",
},
dom: 'lfrtpi',

});
});

$(document).ready(function() {	
$('#tbl6').DataTable({
"order": [
[2, "desc"]
],
"language": {
"emptyTable": "No data available",
"lengthMenu": "Show _MENU_ records",
"info": "Showing _START_ to _END_ of _TOTAL_ records",
"infoFiltered": "(filtered from _MAX_ total records)",
"infoEmpty": "No records available",
},
dom: 'lfrtpi',

});
});

$(document).ready(function() {
$('#tbl8').DataTable({

"language": {
"emptyTable": "No data available",
"lengthMenu": "Show _MENU_ records",
"info": "Showing _START_ to _END_ of _TOTAL_ records",
"infoFiltered": "(filtered from _MAX_ total records)",
"infoEmpty": "No records available",
},
dom: 'lfrtpi',

});
});


</script>
<?php  include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
