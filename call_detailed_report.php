
<?php include_once("includes/config.php"); ?>
<?php
        $pageName = 'call_detialed_report.php';
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Call Detailed Report";
        $page_menu_title = "Call Detailed Report";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	//include_once("classes/reports.php");
	//$reports = new reports();
	
	//include_once("classes/all_agent.php");

   //$all_agent = new all_agent();
   //phpinfo();	
?>	
<?php include($site_root."includes/header.php"); ?>	
<!--<meta http-equiv="refresh" content="2">-->

<html>
<head>

</style>

<script type="text/javascript">
function getHtml4Excel()
{
	document.getElementById("f_date").value = document.getElementById("fdate").value;
    document.getElementById("t_date").value = document.getElementById("tdate").value;
    var e = document.getElementById("search_keyword");
    var strSearch = e.options[e.selectedIndex].value;
    document.getElementById("_search").value = strSearch;
}

</script>
</head>
<body>

<?php
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
//print_r($_SESSION);
$rs_agent_name ="";
if(isset($_REQUEST['search_date']))
{
	$search_keyword		= $_REQUEST["search_keyword"];
	$fdate 				= $_REQUEST['fdate'];
	$tdate 				= $_REQUEST['tdate'];
	//$tdate 				= $_REQUEST['tdate'];
//$rs_agent_name = $admin->out_bound_calls_report($search_keyword,$fdate,$tdate);			
}//else
//{
//	$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
//	//$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];	
//	$search_keyword = empty($_REQUEST["search_keyword"])? $_SESSION['cc_UserId'] : $_REQUEST["search_keyword"];
//		
//}
	
?>
<?php 
/************************* Export to Excel ******************/
///******************************************************************************/	
//$stringData	 = '';
?>

<div>

<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"   onsubmit="">

<div id="mid-col" class="mid-col">
	<div class="box">
	 <center><h4>Call Detailed Report</h4></center>
	<h4 class="white">

	<div>
	From Date :
	 <label>
		<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['fdate'])? date('d-m-Y', strtotime($_REQUEST['fdate'])):$fdate = date('d-m-Y'); ?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">
	</label>
    To Date:
    <label>
		<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['tdate'])? date('d-m-Y', strtotime($_REQUEST['tdate'])):$tdate = date('d-m-Y'); ?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('tdate','ddMMyyyy', 'dropdown')">
	</label>
	<div style="">
    <br>
    <br>
	<label>  
		<?php echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name",$search_keyword,false,"form-select","","Agent"," designation = 'Agents' "); ?>
		</label>
		 <a class="button" href="javascript:document.xForm.submit();" >
		 <span>Search</span>
		 </a>
		<input type="hidden" value="Search >>" id="search_date" name="search_date" />			
	<div>
	</div>
	</h4>
	</form>
	<br />
<style>
#keywords {
      border-collapse: collapse;
      margin: 1em auto;
    }
    th, td {
      padding: 5px 10px;
      border: 1px solid #999;
      font-size: 12px;
    }
    th {
      background-color: #eee;
    }
    th[data-sort]{
      cursor:pointer;
    }

    /* just some random additional styles for a more real-world situation */
    #msg {
      color: #0a0;
      text-align: center;
    }
    td.name {
      font-weight: bold;
    }
    td.email {
      color: #666;
      text-decoration: underline;
    }
    /* zebra-striping seems to really slow down Opera sometimes */
    tr:nth-child(even) > td {
      background-color: #f9f9f7;
    }
    tr:nth-child(odd) > td {
      background-color: #ffffff;
    }
    .disabled {
      opacity: 0.5;
    }
.pagination {
	display: inline-block;
	text-align: center;
	width: 100%;
	margin-bottom: 20px;
}
.pagination ul {
	display: inline-block;
	list-style: none;
}
.pagination ul li {
	display: inline-block;
	font-size: 14px;
	font-weight: bold;
	margin: 0 2px;
}
.pagination ul li a {
	color: #000;
	float: left;
	padding: 5px 10px;
	text-decoration: none;
	background: #fff;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}
.pagination ul li:hover a, .pagination ul li:focus a, .pagination ul li.active a {
	color: #a72c62;
}
#mid-col table> tbody> tr.red > td {
	background-color:red;
	color: white;
}	
  </style>
<?php

if(!empty($_REQUEST['fdate'])){
  $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
	$per_page = 50; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page; 
	$search_keyword		= $_REQUEST["search_keyword"];
	$fdate 				= $_REQUEST['fdate'];
	$tdate 				= $_REQUEST['tdate'];
	
	$fdate = date('Y-m-d', strtotime($fdate));
    $tdate = date('Y-m-d', strtotime($tdate));			
   $rs_agent_name = $admin->get_agent_detailed_report($search_keyword,$fdate,$tdate,$startpoint,$per_page);
 ?>
 
<div id="agent_pd_report">
   
	  <br />
		
<!-- ******************************  Agent On Call and Busy Times ************************** -->
	<h4 class="white" style="text-align:center;"><?php echo "From: ".date('d-m-Y',strtotime($fdate)).' To '.date('d-m-Y',strtotime($tdate));?></h4>
		<div class="box-container tbl_resp"   > 
         <?php //print_r($rs_agent_name->fields);?>     	
	<table id="keywords" >
      			<thead>
                    <tr>
					 <th colspan="2"><span></span></th>
                     <th colspan="2"><span>INBOUND CALL</span></th>
                     <th colspan="2"><span>OUTBOUND CALL</span></th>
                     <th colspan="9"><span></span></th>
					</tr>
      				<tr>
					 <th><span>DATE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></th>
					 <th><span>AGENT</span></th>
	        	     <th><span>NO</span></th>
				     <th >DURATION</th>
					 <th><span>NO</span></th>
		             <th >DURATION</th>
                     <th><span>ABANDONED</span></th>
                     <th><span>DROP </span></th>
                     <th><span>BREAK </span></th>
                     <th><span>ASSIGNMENT</span></th>
                     <th><span>LOGIN TIME</span></th>
                     <th><span>BUSY TIME</span></th>
                     <th><span>TIME DURATION</span> </th>
                     <th><span>LOGOUT TIME</span></th>
                     <th><span>DEPART</span> </th>
					</tr>
      			</thead>
                
				<?php 
				$query_string = "?fdate=".$fdate."&tdate=".$tdate."&search_keyword=".$search_keyword;
				$total = array('inbound_call_no'=>'','inbound_call_duration'=>'','outbound_call_no'=>'','outbound_call_duration'=>'',
               'abandon_calls'=>'','droped_calls'=>'','break_time'=>'','assignment_time'=>'','busy_duration'=>'','login_duration'=>'');
				 ?>
      			<tbody>
				<?php  while(!$rs_agent_name->EOF){ 
				//print_r($rs_agent_name->fields);
				$logout_time ='';
				$logout_time = $rs_agent_name->fields['logout_datetime']; 
				if($rs_agent_name->fields['login_datetime'] == $rs_agent_name->fields['logout_datetime']){
				    $rs_agent_name->fields['logout_datetime'] = $rs_agent_name->fields['update_datetime'].' 20:59:00';
					}
				$rs_in_bound = $admin->get_agent_in_detailed($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['login_datetime'],$rs_agent_name->fields['logout_datetime']);
				$rs_out_bound = $admin->get_agent_ob_detailed($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['login_datetime'],$rs_agent_name->fields['logout_datetime']);
				$rs_login = $admin->get_agent_login_detailed($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['login_datetime'],$logout_time);
				$rs_break_assign = $admin->get_agent_break_assign_detailed($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['login_datetime'],$rs_agent_name->fields['logout_datetime']);
				$rs_drop_name = $admin->get_agent_drop_detailed($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['login_datetime'],$rs_agent_name->fields['logout_datetime']);
				$rs_abandoned = $admin->get_agent_abandoned_detialed($rs_agent_name->fields['staff_id'],$rs_agent_name->fields['login_datetime'],$rs_agent_name->fields['logout_datetime']);
				//print_r($rs_out_bound->fields);
			    $total['outbound_call_no'] += $rs_out_bound->fields['outbound_call_no'];
				$bd = $tools_admin->sum_the_time($rs_in_bound->fields['inbound_busy_duration'],$rs_out_bound->fields['outbound_busy_duration']);
				
			//	if($bd){
				/*$str_time = $bd;	
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;*/
				$total['busy_duration'] += $tools_admin->sum_the_time($bd,'00:00:00');
				// }
				if(!empty($rs_out_bound->fields['outbound_call_duration'])){
	            $str_time2 = $rs_out_bound->fields['outbound_call_duration'];
    			sscanf($str_time2, "%d:%d:%d", $hours, $minutes, $seconds);
    			$time_seconds2 = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
				$total['outbound_call_duration'] += $time_seconds2 ; 	
				}
			    
				$total['inbound_call_no'] += $rs_in_bound->fields['inbound_call_no'];
				
				if(!empty($rs_in_bound->fields['inbound_call_duration'])){
				$str_time = $rs_in_bound->fields['inbound_call_duration'];
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
				$total['inbound_call_duration'] += $time_seconds ; 
				}
				
				$total['abandon_calls'] += $rs_abandoned->fields['abandon_calls'] ; 
	            $total['droped_calls'] += $rs_drop_name->fields['droped_calls'] ; 
				
				if(!empty($rs_break_assign->fields['break_time'])){
				$str_time =($rs_break_assign->fields['break_time'])?$rs_break_assign->fields['break_time']:'00:00:00';
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
				$total['break_time'] += $time_seconds ; 
				}
				if(!empty($rs_break_assign->fields['assignment_time'])){
				$str_time = $rs_break_assign->fields['assignment_time'];
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
				$total['assignment_time'] += $time_seconds ; 
				}
				/*$time = $rs_in_bound->fields['inbound_busy_duration'];
				$time2 = $rs_out_bound->fields['outbound_busy_duration'];
				$secs = strtotime($time2)-strtotime("00:00:00");
				$result = date("H:i:s",strtotime($time)+$secs);*/
				//echo $rs_in_bound->fields['inbound_busy_duration'];
				//echo $rs_out_bound->fields['outbound_busy_duration'];
				//die;
				$bd = $tools_admin->sum_the_time($rs_in_bound->fields['inbound_busy_duration'],$rs_out_bound->fields['outbound_busy_duration']);
				$str_time = $bd;
				sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
				$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
				$total['busy_duration'] += $time_seconds ; 
				
				?>
      				<tr class="odd">
					<td><?php echo date('d-m-Y',strtotime($rs_agent_name->fields['update_datetime'])); ?></td>
                    <td><?php echo $rs_drop_name->fields['full_name']; ?></td>
                    <td><a style="color:blue;" href="javascript:;" onClick="window.open('inbound-calls.php<?php echo $query_string;?>','_blank','width=1000, height=1000,scrollbar=yes');"><?php echo $rs_in_bound->fields['inbound_call_no']; ?></a></td>
                    <td><?php echo $rs_in_bound->fields['inbound_call_duration']; ?></td>
                    <td><a style="color:blue;" target="_blank"  href="out-bound-calls.php<?php echo $query_string;?>"><?php echo $rs_out_bound->fields['outbound_call_no']; ?></a></td>
                    <td><?php echo $rs_out_bound->fields['outbound_call_duration']; ?></td>
                    <td><a style="color:blue;" target="_blank" href="abandoned-calls.php<?php echo $query_string;?>"><?php echo $rs_abandoned->fields['abandon_calls']; ?></a></td>
                    <td><a style="color:blue;" target="_blank"  href="dropped-calls.php<?php echo $query_string;?>"><?php echo $rs_drop_name->fields['droped_calls']; ?></a></td> 
                    <td><?php echo $rs_break_assign->fields['break_time']; ?></td> 
                    <td><?php echo $rs_break_assign->fields['assignment_time']; ?></td>
                    <td><?php echo $rs_login->fields['login_time']; ?></td> 
                    <td><?php echo $bd; ?></td> 
                    <td><?php //echo $rs_login->fields['login_duration']; ?>
                    <?php if($rs_agent_name->fields['update_datetime']==date('Y-m-d') && $rs_drop_name->fields['is_crm_login']==1){
						   	 echo '00:00:00'; 
							}else{
						     echo $rs_login->fields['login_duration']; 
							 if(!empty($rs_login->fields['login_duration'])){
								$str_time = $rs_login->fields['login_duration'];
								sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
								$time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
								$total['login_duration'] += $time_seconds ; 
							}
						 } ?>
                    </td> 
                    <td><?php if($rs_agent_name->fields['update_datetime']== date('Y-m-d') && $rs_drop_name->fields['is_crm_login']==1){echo '<span style="color:red">Logged In</span>'; }else{ echo $rs_login->fields['logout_time']; } ?></td>  
               
                    <td><?php echo $rs_drop_name->fields['department']; ?></td>
                    
                     
					</tr>
                   
				<?php				
				$rs_agent_name->MoveNext();
				//$agent_summary_log_activity->MoveNext();
				} 
				?>
                 </tbody>
             <tfoot>
                 <tr>
				 
                <th colspan="2">Grand Total</b></th>
                <th><?php echo $total['inbound_call_no'];?></th>
                <th><?php echo ($total['inbound_call_duration'])?date("H:i:s", strtotime("00:0:00 +".$total['inbound_call_duration']." seconds")):'00:00:00';?></th>
                <th><?php echo $total['outbound_call_no'];?></th>
                <th><?php echo ($total['outbound_call_duration']) ? date("H:i:s", strtotime("00:0:00 +".$total['outbound_call_duration']." seconds")):'00:00:00';?></th>
                <th><?php echo $total['abandon_calls'];?></th>
                <th><?php echo $total['droped_calls'];?></th>
                <th><?php echo ($total['break_time'])? date("H:i:s", strtotime("00:0:00 +".$total['break_time']." seconds")):'00:00:00';?></th>
                <th><?php echo ($total['assignment_time'])? date("H:i:s", strtotime("00:0:00 +".$total['assignment_time']." seconds")):'00:00:00';?></th>
                <th>--<?php /*echo ($total['busy_duration'])? date("H:i:s", strtotime("00:0:00 +".$total['busy_duration']." seconds")):'00:00:00';*/?></th>
                 <th><?php
				 
				  echo ($total['busy_duration'])? date("H:i:s", strtotime("00:0:00 +".$total['busy_duration']." seconds")):'00:00:00';?></th>
                
                <th><?php echo ($total['login_duration'])?date("H:i:s", strtotime("00:0:00 +".$total['login_duration']." seconds")):'00:00:00';?></th>
                <th>--</th>
                <th>--</th>
              
                </tr>
                <tr>
                <td colspan="15">
                     <?php 
	$sql ="SELECT SUM(staff_id) FROM cc_login_activity AS login_activety";
  $sql.=" WHERE 1=1 AND DATE(login_activety.login_datetime)  BETWEEN '".$fdate."' AND '".$tdate."'";
	if($search_keyword){
      $sql.=" AND login_activety.staff_id='".$search_keyword."'"; 
       } 
     $sql.=" GROUP BY DATE(login_datetime),staff_id ";				 
  /*$sql ="SELECT COUNT(DISTINCT stats.staff_id) as `num` FROM cc_queue_stats AS stats";
  $sql.=" WHERE DATE(stats.update_datetime)  BETWEEN '".$fdate."' AND '".$tdate."'";
  $sql.=" AND (stats.staff_id IS NOT NULL) AND (stats.staff_id <> '0')";
	if($search_keyword){
      $sql.=" AND stats.staff_id='".$search_keyword."'"; 
     }*/
#echo $sql; 
#  $sql.=" GROUP BY stats.staff_id,DATE(stats.update_datetime) ";
//$sql.=" GROUP BY stats.staff_id ";
 //echo $sql; 
    ?>
        <center> <div class="pagination"><ul>
       <?php echo $admin->pagination($sql,$per_page=50,$page,'call_detailed_report.php?fdate='.$fdate.'&tdate='.$tdate.'&search_keyword='.$search_keyword.'&');
	       
	   ?>
      </ul>
      </div>
      </center>
                </td>
                </tr>
            </tfoot>
             </table>    
                 
               <!-- <table style="width:100%">-->
                
               
      			
      		
            <!--</table>  	-->

      	</div>
       
	    <br />
     
	 


<form name="xForm2" id="xForm2" action="/convex_crm/export_detailed_report.php" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; margin-top:-5px;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; margin:15px 0 0 20px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
      <input type="hidden" id="f_date" name="fdate" />
       <input type="hidden" id="t_date" name="tdate" />
      <input type="hidden" id="_search" name="search" />
	  <input type="hidden" name="start" value="<?php echo $startpoint;?>" />
	  <input type="hidden" name="end" value="<?php echo $per_page;?>" />
  </div>
</form>
</div>
<?php } ?>

</div>

</div>
</div>

<?php  include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
