<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "ticket_status_wise_pie_chart.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Ticket Status Wise Pie Chart";
        $page_menu_title = "Ticket Status Wise Pie Chart";
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
//print_r($_SESSION);
$$rs_agent_name ="";
if(isset($_REQUEST['search_date']))
{
	//$search_keyword		= $_REQUEST["search_keyword"];
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
          
		<?php //echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name",$search_keyword,false,"form-select","","Agent"," designation = 'Agents' "); ?>
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
#ticket_status_wise_pie_chart {     				 
 width: 100%;
 height: 100%;
 height: 500px;
 margin: 0;
 padding: 0;
 }		
/*#ticket_status_wise_pie_chart {
                       width: 100%;
                       height: 100%;
					   min-height:400px;
                       margin: 0;
                       padding: 0;
                       }		
*/  </style>   
	<?php //if(!empty($_REQUEST['fdate']) && !empty($_REQUEST['tdate'])){
		/*$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
	$per_page = 50; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page; 
	$search_keyword		= $_REQUEST["search_keyword"];
	$fdate 				= $_REQUEST['fdate'];
	$tdate 				= $_REQUEST['tdate'];
			*/
	//if(!empty($_REQUEST['fdate']) && !empty($_REQUEST['tdate'])){		
	$fdate = date('Y-m-d', strtotime($fdate));
    $tdate = date('Y-m-d', strtotime($tdate));	
	//}
	?>
<div id="agent_pd_report">
<?php $rs_agent_name = $admin->ticket_status_wise_pie_chart($fdate,$tdate);
$ticket_status_wise_pie_chart="";
     //  $found_rows = $admin->found_rows();
	//  print_r($rs_agent_name->fields);
?>
	<h4 class="white" style="text-align:center;">
	<?php echo "From: ".date('d-m-Y',strtotime($fdate)).' To '.date('d-m-Y',strtotime($tdate));?></h4>
	  <br />
		
<!-- ******************************  Agent On Call and Busy Times ************************** -->
		<div class="box-container"   > 
        <?php //print_r($rs_agent_name->fields);?> 	
        	
	<table class="table-short" id="keywords">
      			<thead>
      				<!--<tr>
	        	     <th colspan="3"><center><h4>Ticket Status Wise Pie Chart</h4></center></th>
					</tr>-->
      			</thead>
      			<tbody>
                <tr>
                <td>
                 <?php //print_r($rs_agent_name->fields); ?>
                <?php while(!$rs_agent_name->EOF){  ?>
                <?php  $ticket_status_wise_pie_chart .= "['".trim($rs_agent_name->fields['name'])."',".($rs_agent_name->fields['rec'])."]," ?>  
                <?php 
				$rs_agent_name->MoveNext();
				}   ?>
                  <div id="ticket_status_wise_pie_chart"></div>    
                </td>
                </tr>
                 </tr>
               
                 <!-- <tr>
                	<td>
                     <a id="a-ticket-print" class="button" href="#"><span>Print</span></a>
                	</td>
                </tr> -->   
      			</tbody>
      			</table>  	

      	</div>
	    <br />
</div>

<?php //} ?>
</div>

</div>
</div>
<?php  include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
<script type="text/javascript" src="js/printjs.js"></script>
<script>
$(document).ready(function(){
	//alert('ready');
	$('#a-ticket-print').click(function(){
	//	alert('click');
		$('.hideme').hide();
	$('#ticket_status_wise_pie_chart').show().printElement();	
	$('.hideme').show();
	});
	
	
});
</script>
<script type="text/javascript" src="js/anychart-bundle.min.js"></script>
<script type="text/javascript">
anychart.onDocumentReady(function() {
// create pie chart with passed data
  chart = anychart.pie([<?php echo $ticket_status_wise_pie_chart;?>]);
  // set container id for the chart
  chart.container('ticket_status_wise_pie_chart');
  // set chart title text settings
  chart.title('Ticket Status Wise Pie Chart');
  // set chart labels position to outside
  chart.labels().position('outside');
  // initiate chart drawing
   chart.draw();
 /* // create pie chart with passed data
  chart = anychart.pie([<?php //echo $ticket_status_wise_pie_chart; ?> ]);
  // set container id for the chart
  chart.container('ticket_status_wise_pie_chart');
  // set chart title text settings
  chart.title('Ticket Status Wise Pie Chart');
  // set chart labels position to outside
  chart.labels().position('outside');
  // create empty area in pie chart
  chart.innerRadius('50%');

  // initiate chart drawing
  chart.draw();*/
});

</script>