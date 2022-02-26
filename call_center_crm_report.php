
<?php
 include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php
        $pageName = 'call_center_crm_report.php';
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Call Center Crm Report";
        $page_menu_title = "Call Center Crm Report";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
?>	
<?php include($site_root."includes/header.php"); ?>	
<html>
<head>
</style>

</head>
<body>
 <?php
    // Set timezone
    //date_default_timezone_set("UTC");
	 
 $printme = ClientInfo::markTicketOverdue();  
 //print_r($printme);
?>
<?php
$rs_agent_name ="";
if(isset($_REQUEST['search_date']))
{
	$search_keyword		= $_REQUEST["search_keyword"];
	$fdate 				= $_REQUEST['fdate'];
	$tdate 				= $_REQUEST['tdate'];
	$frdate 				= $_REQUEST['frdate'];
	$trdate 				= $_REQUEST['trdate'];
	$compalaint_id = $_REQUEST['compalaint_id'];	
	$product_id 		    = $_REQUEST['products'];
	$priority_id 		    = $_REQUEST['priority_level'];
	$status_id 		    = $_REQUEST['status'];
    $location = $_REQUEST['css_agent_location'];
    $natures = $_REQUEST['natures'];	
	$intime_over_due = $_REQUEST['intime_over_due'];
    $depart = $_REQUEST['depart'];
    $sec = $_REQUEST['sections'];	

	 // print_r($_REQUEST);
     //die;		
}
?>
<?php 
/************************* Export to Excel ******************/
///******************************************************************************/	

?>
<style>
#keywords {
      border-collapse: collapse;
      margin: 1em auto;
	  width: 200%;
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
		
  </style>
<div>
 
<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"   onsubmit="">

<div id="mid-col" class="mid-col">
	<div class="box">
	 <center><h4>Call Center Crm Report</h4></center>
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
	From Response Date :
	 <label>
		<input name="frdate" id="frdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['frdate'])? date('d-m-Y', strtotime($_REQUEST['frdate'])):"" ?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('frdate','ddMMyyyy', 'dropdown')">
	</label>
    To Response Date:
    <label>
		<input name="trdate" id="trdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['trdate'])? date('d-m-Y', strtotime($_REQUEST['trdate'])):"" ?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('trdate','ddMMyyyy', 'dropdown')">
	</label>
	<br>
	<br>
	<label class="field-title"><strong>Complaint ID:</strong>
	<input type="text" id="compalaint_id" name="compalaint_id" value="<?php echo @$_REQUEST['compalaint_id']; ?>" />
	</label>
	</label>
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
	<label class="field-title"><strong> Natures:</strong></label>
            <select name="natures" id="natures" data-prompt="Select">
              <option data="" value="">&mdash; Select Natures &mdash;</option>
			   <?php $pnatures = getProductNature($selected_nature); ?>
              <?php while($nature = mysql_fetch_object($pnatures)){ ?>
              <option data="<?php echo $nature->id;?>" value="<?php echo $nature->p_title;?>" <?php echo ($nature->p_title == $natures)? "selected" :""?>> <?php echo $nature->p_title;?></option>
               <?php } ?>
            </select>
	</label>
    <label>
     <?php $priorities = getPriority();?>
            <label class="field-title"><strong> Priority:</strong></label>
            <select name="priority_level" id="priority_level" data-prompt="Select">
              <option value="">&mdash; Select &mdash;</option>
              <?php while($priority = mysql_fetch_object($priorities)){?>
              <option value="<?php echo $priority->priority_id;?>" <?php echo (@$_REQUEST['priority_level']==$priority->priority_id)? "selected" :""?>> <?php echo $priority->priority_desc;?></option>
              <?php }?>
            </select>
    </label>
   <br/>
	<br/>
    <label>
    <label class="field-title"><strong>Status:</strong></label>
      <?php $statuses = getTicketStatus();?>
				
                <select name="status" id="status" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                         <?php while($status = mysql_fetch_object($statuses)){?>
                          <option value="<?php echo $status->id;?>" <?php echo ($status_id==$status->id)? "selected" :""?>>
						   <?php echo $status->name;?></option>
				<?php }?>
                           
           </select>
	 	
	</label> 
    </label>
	
	<label>
	 <label class="field-title"><strong>CSS Agent:</strong></label>
		<?php echo $tools_admin->getcombo("admin","search_keyword","admin_id","full_name",$search_keyword,false,"form-select","","Agent"," designation = 'Agents' "); ?>
		</label>
		
		<label class="field-title"><strong>Agent Location:</strong></label>
      <?php $locations = getCssAgentsLocation();?>
                <select name="css_agent_location" id="css_agent_location" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                         <?php while($location = mysql_fetch_object($locations)){?>
                          <option value="<?php echo $location->location_id;?>" <?php echo (@$_REQUEST['css_agent_location']== $location->location_id)? "selected" :""?>>
						   <?php echo $location->location_name;?></option>
				<?php }?>
                           
           </select>
	 	
	</label> 
    </label>
	<br/>
	<br/>
	<label class="field-title"><strong>In-time/Over-due:</strong></label>
                <select name="intime_over_due" id="intime_over_due" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                          <option value="0" <?php echo ($intime_over_due=="0")?"selected":""?>>In-Time</option>
						  <option value="1" <?php echo ($intime_over_due=="1")?"selected":""?>>Over-Due</option>
			               
           </select>
	 	
	</label> 
    </label>
	<label class="field-title"><strong>Department:</strong></label>
      <?php $departs = getTeam();?>
                <select name="depart" id="depart" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                         <?php while($depart = mysql_fetch_object($departs)){?>
                          <option value="<?php echo $depart->team_id;?>" <?php echo (@$_REQUEST['depart']== $depart->team_id)? "selected" :""?>>
						   <?php echo $depart->name;?></option>
				<?php }?>            
           </select>
	 	
	</label> 
    </label>
	<label class="field-title"><strong>Section:</strong></label>
      <?php $sections = getSection(); ?>
                <select name="sections" id="sections" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                         <?php while($section = mysql_fetch_object($sections)){?>
                          <option value="<?php echo $section->sec_id;?>" <?php echo (@$_REQUEST['sections']== $section->sec_id)? "selected" :""?>>
						   <?php echo $section->section;?></option>
				<?php }?>            
           </select>
	 	
	</label> 
    </label>
	
	<div style="">
    <br>
    <br>
		 <!-- <a class="button" href="javascript:document.xForm.submit();" >-->
         <a class="button" href="javascript:validateForm();" >
		 <span>Search</span>
		 </a>
		<input type="hidden" value="Search >>" id="search_date" name="search_date" />			
	<div>
	</div>
	</h4>
	</form>
	<br />

<?php

if(!empty($_REQUEST['fdate'])){
   $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
	$per_page = 50; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page; 
	$search_keyword		= $_REQUEST["search_keyword"];
	$fdate 				= $_REQUEST['fdate'];
	$tdate 				= $_REQUEST['tdate'];
	$frdate 			= $_REQUEST['frdate'];
	$trdate 			= $_REQUEST['trdate'];
    $compalaint_id = $_REQUEST['compalaint_id'];		
	$product_id 		= $_REQUEST['products'];
	$priority_id 		= $_REQUEST['priority_level'];
	$status_id 		    = $_REQUEST['status'];
	$location = $_REQUEST['css_agent_location'];
    $natures = $_REQUEST['natures'];
   $intime_over_due = $_REQUEST['intime_over_due'];	
   $depart = $_REQUEST['depart'];	
   $sec = $_REQUEST['sections'];	
   if($frdate && $trdate){
	   $frdate = date('Y-m-d', strtotime($frdate));
	   $trdate = date('Y-m-d', strtotime($trdate));
	  }
    
    $fdate  = date('Y-m-d', strtotime($fdate));
    $tdate  = date('Y-m-d', strtotime($tdate));	
	
  $rs_agent_name = $admin->callcenter_crm_report($startpoint,$per_page,$fdate,$tdate,$product_id,$priority_id,$status_id,$search_keyword,$location,$natures,$intime_over_due,$depart,$sec,$frdate,$trdate,$compalaint_id);
  $found_rows = $admin->found_rows();  
 $actions =array('A'=>'Assign','E'=>'Edit','R'=>'Reply','SA'=>'Self Assigned','SC'=>'Status Changed','RA'=>'Re Assigned');
 ?>
<div id="agent_pd_report">
<br />		
<!-- ******************************  Agent On Call and Busy Times ************************** -->
	<h4 class="white" style="text-align:center;">
	<?php echo "From: ".date('d-m-Y',strtotime($fdate)).' To '.date('d-m-Y',strtotime($tdate));?></h4>
		<div class="box-container tbl_resp"   > 
     <?php $lrdt = "";?>       	
	<table id="keywords" >
      			<thead>
                    <tr>
					 <th colspan="3"><center>Ticket</center></th>
                     <th colspan="3"><center></center></th>
                     <th colspan="3"><center>CSS Agent</center></th>
                     <th colspan="3"><center>Responder</center></th>
                     <th colspan="7"><span></span></th>
					</tr> 
      				<tr>
					 <th><span>Number</span></th>
	        	     <th><span>Date/Time</span></th>
					 <th><span>Age</span></th>
                     <th><span>Time Assigned</span></th>
                     <th><span>Product </span></th>
                     <th><span>Nature</span></th>
                     <th><span>CSS Agent Replier</span></th>
					 <th><span>CSS Agent Creator</span></th>
                     <th><span>Location</span></th>
                     <th><span>Name</span> </th>
                     <th><span>Depart</span></th>
					  <th><span>Section</span></th>
                     <th><span>Response Date/Time</span> </th>
                     <th><span>Response Time</span> </th>
                     <th><span>Action</span> </th>
                     <th><span>Status</span> </th>
                     <th><span>Priority</span> </th>
                     <th><span>In-Time/Over-due</span> </th>
					</tr>
      			</thead>
      			<tbody>
				 <?php  while(!$rs_agent_name->EOF){ ?>
					   <tr>
                       <td><?php echo $rs_agent_name->fields['number'];?></td>
                       <td><?php echo $rs_agent_name->fields['date_time'];?></td>
                       <td><?php if($rs_agent_name->fields['status_id']==3 ){
						          echo $admin->dateDiff($rs_agent_name->fields['created'],$rs_agent_name->fields['close_date']);
								 }else{
							      echo $admin->dateDiff($rs_agent_name->fields['created'],date('Y-m-d H:i:s'));
								//echo date('Y-m-d H:i:s');									  
							   }?></td>
                       <td><?php echo $rs_agent_name->fields['time_assigned'];?></td>
                       <td><?php echo $rs_agent_name->fields['product'];?></td>
                       <td><?php if($rs_agent_name->fields['nature']=="Others" || $rs_agent_name->fields['nature']==""){ 
					           echo $rs_agent_name->fields['nature'].':'.$rs_agent_name->fields['others'];
					   }else{
						    echo $rs_agent_name->fields['nature'];
						   }?></td>
					  <?php  $deptt ="";   if($rs_agent_name->fields['dept_name']){
						     $deptt = explode(" ",$rs_agent_name->fields['dept_name']);  }else{
						     $deptt = explode(" ",$rs_agent_name->fields['tdepart_name']);
							 
							 }?>	   
                        <td><?php echo $rs_agent_name->fields['full_name'];?></td>
					   <td><?php echo $rs_agent_name->fields['creater'];?></td>
                       <td><?php echo $rs_agent_name->fields['location'];?></td>
                       <td><?php echo ($rs_agent_name->fields['dept_name'])? $rs_agent_name->fields['firstname']:"--";?></td>
					   <td><?php  echo ($deptt[0])? $deptt[0]:"";?></td>
                  <!-- <td> <?php // echo ($rs_agent_name->fields['dept_name'])? $rs_agent_name->fields['dept_name']:$rs_agent_name->fields['tdepart_name'];?></td>-->
					   <td><?php  echo ($deptt[1])? $deptt[1]:"--"; //echo ($rs_agent_name->fields['section'])? $rs_agent_name->fields['section']:"--";?></td>
                      <td><?php if($rs_agent_name->fields['created']!= $rs_agent_name->fields['response_time'] ){ echo $rs_agent_name->fields['response_datetime']; }else{ echo "--";}?></td>
                      
                        <td><?php 
						
					  if($rs_agent_name->fields['last_agent_response']){
						 echo $admin->dateDiff($rs_agent_name->fields['last_agent_response'],$rs_agent_name->fields['response_time']); 
					  }else{
						echo $admin->dateDiff($rs_agent_name->fields['created'],$rs_agent_name->fields['response_time']); 
					  }  // else{ echo "--";}
						 //if($rs_agent_name->fields['dept_name']){
						  /* echo  ($rs_agent_name->fields['last_agent_response'])? $admin->dateDiff($rs_agent_name->fields['last_agent_response'],$rs_agent_name->fields['response_time']):($rs_agent_name->fields['action_type']!="E")?$admin->dateDiff($rs_agent_name->fields['created'],$rs_agent_name->fields['response_time']):"-- "; */
					        
					     // }else{
						    // echo  "--";
					      //}?></td>
                       <td><?php echo ($rs_agent_name->fields['action_type'])? $actions[$rs_agent_name->fields['action_type']] : "Assign";?></td>
                       <td><?php echo $rs_agent_name->fields['name'];?></td>
                       <td><?php echo $rs_agent_name->fields['priority_desc'];?></td> 
                       <td><?php echo ($rs_agent_name->fields['isoverdue'])?"Over Due":"In-Time";?></td> 
                       </tr>
					   
				 <?php $rs_agent_name->MoveNext(); ?>
				 <?php 
				  //$lrdt = ($rs_agent_name->fields['dept_name'])?$rs_agent_name->fields['response_time']:"";
				 } ?>
                 </tbody>
                 <tfoot>
				 <tr>
                <td colspan="18">
                <?php
			  /*$sql.="SELECT  COUNT(ticket.number)   FROM ts_ticket AS ticket";
			  $sql.=" LEFT JOIN ts_ticket_thread AS responder  ON responder.id = (SELECT MAX(thread.id)  FROM ts_ticket_thread AS thread WHERE thread.ticket_id = ticket.ticket_id 
		  AND thread.poster <> 'SYSTEM' ORDER BY thread.id DESC LIMIT 1 )"; 
			  //$sql.=" INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ticket.who_created ";
			  $sql.="INNER JOIN cc_admin AS css_agent ON css_agent.admin_id = ( CASE  WHEN responder.cc_agent_id IS NULL THEN ticket.who_created ELSE responder.cc_agent_id END) ";
			   if($search_keyword){
			    $sql.=" AND ticket.who_created = '".$search_keyword."'";
		       }
			     if($location){
			    $sql.=" AND css_agent.location = '".$location."' ";
		      }
			 // $sql.=" LEFT JOIN ts_ticket_thread AS responder  ON responder.id = (SELECT thread.id  FROM ts_ticket_thread AS thread WHERE thread.ticket_id = ticket.ticket_id  AND thread.staff_id <> 0 
	   //ORDER BY thread.id DESC LIMIT 1 ) AND responder.staff_id <> 0 ";
	         //  $sql.=" LEFT JOIN ts_ticket_thread AS responder ON responder.ticket_id = ticket.ticket_id ";
			   if($sec){
			    $sql.="INNNER JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";
				  $sql.=" AND staff.section ='".$sec."'";
			  }else{
				$sql.="LEFT JOIN ts_staff AS staff ON staff.staff_id = responder.staff_id  ";  
			  }
			  $sql.=" LEFT JOIN ts_department AS depart ON depart.dept_id = staff.dept_id  ";
			  $sql.=" LEFT JOIN ts_ticket_status AS tstatus ON tstatus.id=ticket.status_id ";
			  $sql.=" LEFT JOIN ts_ticket__cdata AS tcdata ON tcdata.ticket_id = ticket.ticket_id ";
			  /*
			  $sql.=" INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
			   if($priority_id){
				  $sql.=" AND tcdata.priority ='".$priority_id."'";
			   }  
			   if($priority){
			    $sql.="INNER JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
			  $sql.=" AND tcdata.priority ='".$priority."'";
			   }else{
					$sql.="LEFT JOIN ts_ticket_priority AS tpriority ON tpriority.priority_id = tcdata.priority  ";
			   }  
			  $sql.=" WHERE DATE(ticket.created) BETWEEN '".$fdate."' AND '".$tdate."'"; 
			  if($complaint_id){
			  $sql.=" AND ticket.ticket_id='".$complaint_id."'"; 
		     }
		      if($frdate && $trdate){
			  $sql.=" AND DATE(ticket.lastresponse) BETWEEN '".$frdate."' AND '".$frdate."'"; 
		     }
			 if($depart){
			  $sql.=" AND ticket.team_id='".$depart."' ";
		      } 
			 if($intime_over_due){
			  $sql.=" AND ticket.isoverdue='".$intime_over_due."' ";
		      }
			  if($product_id){
				  $sql.=" AND ticket.product='".$product_id."' ";
			  }  
			  if($natures){
			  $sql.=" AND ticket.nature='".$natures."' ";
		  }	
			  if($status_id){
				  $sql.=" AND ticket.status_id='".$status_id."'";
			  } 	
			  $sql.=" GROUP BY ticket.ticket_id ";  
			   //echo $sql;
			   //$location = $_REQUEST['css_agent_location'];*/	
			   $intime_over_due = $_REQUEST['intime_over_due'];		
				?>
					<center><div class="pagination"><ul>
				   <?php echo $admin->pagination($found_rows->fields,$per_page=50,$page,
				   'call_center_crm_report.php?fdate='.$fdate.'&tdate='.$tdate.'&products='.$product_id
				   .'&priority_level='.$priority_id.'&status='.$status_id.'&search_keyword='
				   .$search_keyword.'&css_agent_location='.$location.'&natures='.$natures.'&intime_over_due='.$intime_over_due.'&depart='.$depart.'&sections='.$sec.'&frdate='.$frdate.'&trdate='.$trdate.'&complaint_id='.$complaint_id.'&');
					   
				   ?>
				  </ul>
				  </div></center>
                </td>
                </tr>
				 </tfoot>
             </table>    
      	</div>
	    <br />
     
	 


<form name="xForm2" id="xForm2" action="/convex_crm/export_call_center_crm_summary.php" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; margin-top:-5px;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; margin:15px 0 0 20px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
      <input type="hidden" id="f_date" name="fdate" />
      <input type="hidden" id="t_date" name="tdate" />
	  
	  <input type="hidden" id="fr_date" name="frdate" />
      <input type="hidden" id="tr_date" name="trdate" />
	  <input type="hidden" id="cmp_id" name="cmp_id" />
      <input type="hidden" id="t_product" name="tproduct" />
      <input type="hidden" id="t_priority" name="tpriority" />
      <input type="hidden" id="t_status" name="tstatus" />
	  
	   <input type="hidden" id="agent_id" name="agent_id" value="<?php echo $search_keyword; ?>" />
	   <input type="hidden" id="location" name="location" value="<?php echo $location; ?>" />
	   <input type="hidden" id="e_natures" name="e_natures" value="<?php echo $natures; ?>"  />
	   <input type="hidden" id="intime" name="intime" value="<?php echo $intime_over_due; ?>" />
	   <input type="hidden" id="depart_id" name="depart_id" value="<?php echo $depart; ?>" />
	   <input type="hidden" id="sec" name="sec" value="<?php echo $sec; ?>" />
	   
      <input type="hidden" name="start" value="<?php echo $startpoint;?>" />
	  <input type="hidden" name="end" value="<?php echo $per_page;?>" />
	  
    
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

function validateForm()
{
//var x=document.forms["escalations"]["SupportGroup"].value;
   frdate = document.getElementById('frdate').value; // trdate
   //alert(frdate);
   if (frdate!=""){
	  trdate = document.getElementById('trdate').value;
	  if(trdate=="" ){
		  alert("Please Select To response date also");
		
		}else{
		document.xForm.submit();
		} 
   }else{
        document.xForm.submit();
   }
     	//alert(selects);
        return false;
}

function getHtml4Excel()
{
	document.getElementById("f_date").value = document.getElementById("fdate").value;
    document.getElementById("t_date").value = document.getElementById("tdate").value;
	
	document.getElementById("fr_date").value = document.getElementById("frdate").value;
    document.getElementById("tr_date").value = document.getElementById("trdate").value;
    
	document.getElementById("cmp_id").value = document.getElementById("compalaint_id").value;
    
	var e = document.getElementById("products");
    var strSearch = e.options[e.selectedIndex].value;
    document.getElementById("t_product").value = strSearch;
	var e = document.getElementById("priority_level");
    var strSearch = e.options[e.selectedIndex].value;
    document.getElementById("t_priority").value = strSearch;
	var e = document.getElementById("status");
    var strSearch = e.options[e.selectedIndex].value;
    document.getElementById("t_status").value = strSearch;
}

</script>
<?php  include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
