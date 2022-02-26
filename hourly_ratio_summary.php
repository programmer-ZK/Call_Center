
<?php 
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/

include_once("includes/config.php"); ?>
<?php
        $page_name = "hourly_ratio_summary.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Hourly Ratio Summary";
        $page_menu_title = "Hourly Ratio Summary";
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
<!--<meta http-equiv="refresh" content="2">-->

<html>
<head>
<script type="text/javascript">
function getHtml4Excel()
{

	document.getElementById("_fdate").value = document.getElementById("fdate").value;
	document.getElementById("_tdate").value = document.getElementById("tdate").value;

}
</script>
</head>
<body>

<?php
//print_r($_REQUEST);
$rs_agent_name ="";
if(isset($_REQUEST['fdate']))
{
	$fdate 				= $_REQUEST['fdate'];
	$tdate 				= $_REQUEST['tdate'];
//$rs_agent_name = $admin->out_bound_calls_report($search_keyword,$fdate,$tdate);			
}
	
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
		<h4 class="white">
		<div>
        <?php include($site_admin_root."includes/date_search_bar.php");?>
		<div style="">
    	<br>
    	<br>
		<!-- <a class="button" href="javascript:document.xForm.submit();" >
		 <span>Search</span>
		 </a>-->
		<!--<input type="hidden" value="Search >>" id="search_date" name="search_date" />	-->		
	<div>
	</div>
	</h4>
	</form>
	<br />
   <style>
table {
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
  </style>     
	<?php if(!empty($fdate) && !empty($tdate)){?>
<div id="agent_pd_report">
<?php //$rs_agent_name = $admin->hourly_ratio_summary($fdate,$tdate); //print_r($rs_agent_name);?>
	
	  <br />
		
<!-- ******************************  Agent On Call and Busy Times ************************** -->
		 <h4 class="white"><?php echo "HOURLY CALL RATIO SUMMARY FROM ".date('M-d-Y',strtotime($fdate)).' To '.date('M-d-Y',strtotime($tdate));?></h4>
		<div class="box-container"   > 
       	      	
	<table class="table-short" id="keywords">
      			<thead>
					
      				<tr>
						 <th class="col-head2">TIMING SLOT</th>
                         <th class="col-head2">RECIEVED</th>
                         <th class="col-head2">DIALED</th>
	        	    	 <th class="col-head2">CALL TOTAL</th>
                        
					</tr>
                    
      			</thead>
				
      			<tbody>
				<?php 
				  $total =0;
				  $in =0;
				  $out =0;
				  
				 for ($i=9; $i < 22; $i++) {
					 $start_h = $i.":00:00";
					 $endh =  $i.":59:00";
					 $rs = $admin->hourly_summarm_hbm($fdate,$tdate,$start_h,$endh);
					 $total += $rs->fields['calls_count'];
					 $in += $rs->fields['inbound'];
					 $out += $rs->fields['outbound'];
					 
					 ?>
      				<tr class="odd">
                    <td><?php echo ($rs->fields['time_slots'])? $rs->fields['time_slots']: $i.':00 -'.$i.':59'; ?></td>
                    <td><?php echo $rs->fields['inbound']; ?></td>
                    <td><?php echo $rs->fields['outbound']; ?></td>
                    <td><?php echo ($rs->fields['calls_count'])? $rs->fields['calls_count'] : "0"; ?></td>
					</tr>
				<?php	 
			     }
				?>
                </tbody>
                  <tfoot>
                <tr>
                  <th><b>TOTAL</b></th>
                  <th><b><?php echo $in; ?></b></th>
                  <th><b><?php echo $out; ?></b></th>
                  <th><b><?php echo $total; ?></b></th>
                </tr>
      			</tfoot>
      		</table>  	

      	</div>
	    <br />
	

<form name="xForm2" id="xForm2" action="/convex_crm/export_call_ratio_summary.php" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; margin-top:-5px;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; margin:15px 0 0 20px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
      <input type="hidden" id="_fdate" name="_fdate" />
      <input type="hidden" id="_tdate" name="_tdate" />
  	 
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
