<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php
        $page_name = "in-bound-calls.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Inbound Calls Report";
        $page_menu_title = "Inbound Calls Report";
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
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
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

 var e = document.getElementById("products");
    var strSearch = e.options[e.selectedIndex].value;
    document.getElementById("t_product").value = strSearch;
	
var e = document.getElementById("status");
    var strSearch = e.options[e.selectedIndex].value;
    document.getElementById("t_status").value = strSearch;
	
var e = document.getElementById("workcodes");
    var strSearch = e.options[e.selectedIndex].value;
    document.getElementById("wc_codes").value = strSearch;
	
var e = document.getElementById("natures");
    var strSearch = e.options[e.selectedIndex].value;
    document.getElementById("p_natures").value = strSearch;	
	
document.getElementById("cmp_id").value = document.getElementById("compalaint_id").value;
}

</script>
</head>
<body>

<?php
//print_r($_SESSION);
$rs_agent_name ="";
if(isset($_REQUEST['search_date']) || isset($_REQUEST["search_keyword"]))
{
	$search_keyword		= $_REQUEST["search_keyword"];
	$fdate 				= $_REQUEST['fdate'];
	$tdate 				= $_REQUEST['tdate'];
	$product_id 		    = $_REQUEST['products'];
	$natures = $_REQUEST['natures'];
    $compalaint_id = $_REQUEST['compalaint_id'];	
	$workcodes = $_REQUEST['workcodes'];
	$status_id 		    = $_REQUEST['status'];	
	
//$rs_agent_name = $admin->out_bound_calls_report($search_keyword,$fdate,$tdate);			
}
	
?>
<?php 
/************************* Export to Excel ******************/
///******************************************************************************/	
//$stringData	 = '';
?>
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
  </style>  
<div>
<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"   onsubmit="">

<div id="mid-col" class="mid-col">
	<div class="box">
	  <center><h4>Inbound Calls Report</h4></center>
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
	<label class="field-title"><strong>Complaint ID:</strong>
	<input type="text" id="compalaint_id" name="compalaint_id" value="<?php echo @$_REQUEST['compalaint_id']; ?>" />
	</label>
	</label>
	 <label>
	<label class="field-title"><strong> WorkCodes:</strong></label>
            <select name="workcodes" id="workcodes" data-prompt="Select">
              <option data="" value="">&mdash; Select WorkCodes &mdash;</option>
			   <?php $workcodess = getWorkcodes(0); ?>
              <?php while($workcode = mysql_fetch_object($workcodess)){ ?>
              <option data="<?php echo $workcode->id;?>" value="<?php echo $workcode->wc_title;?>" <?php echo ($workcode->wc_title == $workcodes)? "selected" :""?>> <?php echo $workcode->wc_title;?></option>
               <?php } ?>
            </select>
	</label>
	<br> <br>
	  <label>
     <?php  $selected_nature = ""; $products = getProductNature('0'); ?>
            <label class="field-title"><strong> Products:</strong></label>
            <select name="products" id="products" data-prompt="Select">
              <option data="" value="">&mdash; Select Product &mdash;</option>
              <?php while($product = mysql_fetch_object($products)){ ?>
              <option data="<?php echo $product->id; ?>" value="<?php echo $product->p_title;?>" <?php echo (@$_REQUEST['products']==$product->p_title)? "selected" :""?>> <?php echo $product->p_title;?></option>
              <?php 
			  if($product->p_title == $_REQUEST['products']){
				  $selected_nature = $product->id;
			   }
			  }  
			  ?>
            </select>
    </label>
	
    <label>
	<label class="field-title"><strong> Complaint Type:<?php //echo $selected_nature;?></strong></label>
            <select name="natures" id="natures" data-prompt="Select">
              <option data="" value="">&mdash; Select Natures &mdash;</option>
			   <?php $pnatures = getProductNature($selected_nature); ?>
              <?php while($nature = mysql_fetch_object($pnatures)){ ?>
              <option data="<?php echo $nature->id;?>" value="<?php echo $nature->p_title;?>" <?php echo ($nature->p_title == $natures)? "selected" :""?>> <?php echo $nature->p_title;?></option>
               <?php } ?>
            </select>
	</label>
	
      <label class="field-title"><strong>Complaint Status:</strong></label>
      <?php $statuses = getTicketStatus();?>
                <select name="status" id="status" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                         <?php while($status = mysql_fetch_object($statuses)){?>
						 <?php if($status->id !='6'){?>
                          <option value="<?php echo $status->id;?>" <?php echo ($status_id==$status->id)? "selected" :""?>>
						   <?php echo $status->name;?></option>
						 <?php } ?>
				<?php }?>
                           
           </select>
	 	
	</label> 
	
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
	<?php if(!empty($_REQUEST['fdate']) && !empty($_REQUEST['tdate'])){
		$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
		if ($page <= 0) $page = 1;
		$per_page = 50; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page; 
		$search_keyword		= $_REQUEST["search_keyword"];
		$fdate 				= $_REQUEST['fdate'];
		$tdate 				= $_REQUEST['tdate'];
		$product_id 		    = $_REQUEST['products'];
		$natures = $_REQUEST['natures'];
		$compalaint_id = $_REQUEST['compalaint_id'];	
		$workcodes = $_REQUEST['workcodes'];
		$status_id 		    = $_REQUEST['status'];	
		
	$fdate = date('Y-m-d', strtotime($fdate));
    $tdate = date('Y-m-d', strtotime($tdate));			
	?>
<div id="agent_pd_report">
<?php $rs_agent_name = $admin->inbound_call_report($startpoint,$per_page,$search_keyword,$fdate,$tdate,$compalaint_id,$workcodes,$product_id,$natures,$status_id);
       $found_rows = $admin->found_rows();
 ?>
	  <br />
		
<!-- ******************************  Agent On Call and Busy Times ************************** -->
		 <h4 class="white" style="text-align:center;"><?php echo "From ".date('d-m-Y',strtotime($fdate)).' To '.date('d-m-Y',strtotime($tdate));?></h4>
		<div class="box-container tbl_resp"> 
        <?php //print_r($rs_agent_name->fields);?> 	      	
	<table id="keywords">
      			<thead>
					<tr>
	                 <th colspan="4"></th>
                      <th colspan="4"><center>INBOUND CALLS</center></th>	
                      <th colspan="7"><center>COMPLAINTS</center></th>	
        		    </tr>
      				<tr>
                        <th class="col-head2">S.NO</th>
                         <th class="col-head2">AGENT NAME</th>
					   <th class="col-head2">CALL DATE &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
	        	        <th class="col-head2">TIME</th>
						<th class="col-head2">DURATION</th>
						<th class="col-head2">CALLER ID</th>
		                <th class="col-head2">IN QUEUE</th>
                        <th class="col-head2">WORKCODES</th>						
                        <th class="col-head2">CALLER REFERNCE ID</th>
                        <th class="col-head2">CRM ID</th>
						<th class="col-head2">PRODUCT</th>
                        <th class="col-head2">TYPE</th>
                       <!-- <th class="col-head2">SUBJECT</th> -->
                        <th class="col-head2">TO DEPART</th> 
                        <th class="col-head2">STATUS</th>
						<th class="col-head2">Remarks</th>						
                        
					</tr>
      			</thead>
				<tbody>
				<?php $i= $startpoint+1; while(!$rs_agent_name->EOF){ ?>
      				<tr class="odd">
                    <td><?php echo $i++; ?></td>
                     <td><?php echo $rs_agent_name->fields['full_name']; ?></td>
                    <td><?php echo date('d-m-Y',strtotime($rs_agent_name->fields['call_date'])); ?></td>
                    <td><?php echo date('h:i:s A', strtotime($rs_agent_name->fields['call_date'].' '.$rs_agent_name->fields['TIME'])); ?></td>
                    <td><?php echo $rs_agent_name->fields['inbound_call_duration']; ?></td>
                    <td><?php echo $rs_agent_name->fields['caller_id']; ?></td>
                    <td><?php echo str_replace('-','',$rs_agent_name->fields['wait_in_queue']); ?></td>
                    <td><?php echo $rs_agent_name->fields['workcodes']; ?></td>
                    <td><?php echo $rs_agent_name->fields['call_id']; if($rs_agent_name->fields['call_status']=="TRANSFER") {echo "<br><span style='color:green;'>(TRANSFER)</span>";} ?></td>
                    <td><?php echo $rs_agent_name->fields['number']; ?></td>
					<td><?php echo $rs_agent_name->fields['product']; ?></td>
                     <td>
					 <?php if($rs_agent_name->fields['nature']=="Others" || $rs_agent_name->fields['nature']==""){ 
					           echo $rs_agent_name->fields['nature']." ".$rs_agent_name->fields['others'];
					   }else{
							  echo $rs_agent_name->fields['nature'];
						   }?>
					 </td>
                    <!-- <td><?php //echo $rs_agent_name->fields['subject']; ?></td>-->
                     <td><?php echo $rs_agent_name->fields['dept_name']; ?></td>
                     <td><?php echo $rs_agent_name->fields['name']; ?></td>
					 <td><?php echo $rs_agent_name->fields['remarks']; ?></td>
                     
					</tr>
				<?php				
				$rs_agent_name->MoveNext();
				} 
				?>
      			</tbody>
                <tfoot>
                <tr>
                <td colspan="15"><center>
                 <?php 
               /* $sql .="SELECT count(stats.id) as num FROM cc_admin AS admin";
                $sql .=" INNER JOIN cc_queue_stats AS stats ON admin.admin_id = stats.staff_id 
    	         AND DATE(stats.update_datetime) BETWEEN '".$fdate."' AND  '".$tdate."' 
                 AND stats.call_type = 'INBOUND' AND (stats.call_status = 'ANSWERED' OR stats.call_status = 'TRANSFER') ";
				 
				 if($workcodes){
					$sql .=" INNER JOIN cc_vu_workcodes  AS t1 ON stats.unique_id = t1.unique_id  AND stats.staff_id = t1.staff_id";
					$sql .= " AND t1.workcodes LIKE '%".$workcodes."%' ";  
				 }else{
					 $sql .=" LEFT JOIN cc_vu_workcodes  AS t1 ON stats.unique_id = t1.unique_id  AND stats.staff_id = t1.staff_id";
				 } 
				
               ///$sql .=" LEFT JOIN ts_ticket AS ticket ON stats.unique_id = ticket.unique_id";   
			   if($compalaint_id || $product_id || $natures || $status_id ){
					$sql .=" INNER JOIN ts_ticket AS ticket ON stats.unique_id = ticket.unique_id";
				}else{
					$sql .=" LEFT JOIN ts_ticket AS ticket ON stats.unique_id = ticket.unique_id";
				}
			   if($compalaint_id){
					$sql .=" AND ticket.ticket_id='".trim( (int)$compalaint_id)."' ";    
				}	
			 if($product_id){
				 $sql .=" AND ticket.product='".$product_id."' ";    
			 }
			  if($natures){
			 $sql .=" AND ticket.nature='".$natures."' ";    
		 }
			  if($status_id){
				 $sql .=" AND ticket.status_id='".$status_id."' ";    
			 }
			$sql .=" LEFT JOIN ts_user AS users ON ticket.user_id = users.id ";   
			$sql .=" LEFT JOIN ts_ticket__cdata AS ticket_data ON ticket.ticket_id = ticket_data.ticket_id "; 
			//$sql .=" LEFT JOIN ts_department AS depart ON ticket.dept_id=depart.dept_id  "; 
		    $sql .=" LEFT JOIN ts_team AS teams  ON teams.team_id = ticket.team_id  "; 
			$sql .=" LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id= ticket.status_id  ";
			
			if($search_keyword){
			$sql .=" WHERE admin.admin_id = '".$search_keyword."'";
			}
			 $sql .=" GROUP BY TIME(stats.call_datetime) ";
			 //echo $sql;*/
		   ?>
                   <div class="pagination"><ul>
                   <?php echo $admin->pagination($found_rows->fields,$per_page=50,$page,'inbound-calls.php?fdate='.$fdate.'&tdate='.$tdate.'&search_keyword='.$search_keyword.'&compalaint_id='.$compalaint_id.'&$workcodes='.$workcodes.'&products='.$product_id.'&nature='.$natures.'&status='.$status_id.'&');?>
      </ul>
      </div></center>

                </td>
                </tr>
                </tfoot>
      		</table>  	

      	</div>
	    <br />
	


<form name="xForm2" id="xForm2" action="/convex_crm/export_inbound_call.php" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; margin-top:-5px;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; margin:15px 0 0 20px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
      <input type="hidden" id="f_date" name="fdate" />
       <input type="hidden" id="t_date" name="tdate" />
        <input type="hidden" id="_search" name="search" />
        <input type="hidden" id="t_product" name="tproduct" />
		<input type="hidden" id="cmp_id" name="cmp_id" />
		<input type="hidden" id="wc_codes" name="wc_codes" />
		<input type="hidden" id="p_natures" name="p_natures" />
       <input type="hidden" id="start" name="start" value="<?php echo $startpoint; ?>" />
       <input type="hidden" id="end" name="end" value="<?php echo $per_page;?>" />
       <input type="hidden" id="t_status" name="tstatus" />
  	 <!-- <input type="hidden" id="gethtml1" name="gethtml1"/>-->
  </div>
</form>
</div>

<?php } ?>
</div>

</div>
</div>
<script type="text/javascript">
$(document).ready(function(e) {
	
    $('#products').change(function(){
		
		 //var products = $(this).attr('selectedIndex');
		 var products = $('option:selected', this).attr('data');
		// alert(products);
            $.ajax({
                type: "POST",
                data: {products: products},
                url: 'getproduct_nature.php',
                dataType: 'json',
                success: function(json) {
					//alert(json);
					//json = JSON.parse(json);
                    var $el = $("#natures");
                    $el.empty(); // remove old options
                    $el.append($("<option></option>")
                            .attr("value", '').text('Select Nature'));
                    $.each(json.natures, function(value, key) {
						//alert(key.value);
                        $el.append($("<option></option>")
                                .attr("value", key.value).text(key.value));
                    });													
                }
            });
		
		
    });
});
</script>
<?php  include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
