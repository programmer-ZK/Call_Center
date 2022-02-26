<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "mystats_report.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "My Stats Report";
        $page_menu_title = "My Stats Report";
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

</head>
<body>


<div>

	<br />
	<?php if(!empty($_REQUEST['type'])){?>
<div id="agent_pd_report">
<?php 
$type = $_REQUEST['type'];
$agent_id = $_SESSION[$db_prefix.'_UserId'];
if($_REQUEST['type']=='recieved'){
	$rs_agent_name = $admin->getCurrentAgentCalls($agent_id,'INBOUND');
}elseif($_REQUEST['type']=='dialed'){
	$rs_agent_name = $admin->getCurrentAgentCalls($agent_id,'OUTBOUND');
}elseif($_REQUEST['type']=='abandoned'){
	$rs_agent_name = $admin->getCurrentAgentAbandonedCalls($agent_id);
}

// print_r($rs_agent_name->fields);
?>
	  <br />
		
<!-- ******************************  Agent On Call and Busy Times ************************** -->
<h4 class="white">MY CALL STATS</h4>
		<div class="box-container"> 
    <?php if($_REQUEST['type']=='recieved'){ ?>    	      	
	<table class="table-short">
      			<thead>
      			  <tr>
					 <td class="col-head2">Caller Id </td>
	        	     <td class="col-head2">Date Time</td>
                     <td class="col-head2">Workcodes</td>
                      <td class="col-head2">Client Name</td>
                       <td class="col-head2">Ticket</td>
					</tr>
      			</thead>
      			<tbody>
				<?php  while(!$rs_agent_name->EOF){ ?>
      				<tr class="odd">
                    <td><?php echo $rs_agent_name->fields['caller_id']; ?></td>
                    <td><?php echo date('d-m-Y h:i:s',strtotime($rs_agent_name->fields['update_datetime']));?></td>
                     <td><?php echo $rs_agent_name->fields['workcodes'];?></td>
                     
                      <?php if($rs_agent_name->fields['client_id']){?>
                      <td><a  style="color: blue;" href="view_client.php?id=<?php echo $rs_agent_name->fields['client_id']; ?>" target="_blank"><?php echo $rs_agent_name->fields['client_name']; ?></a></td>
                        <?php } else{?>
                       <td>N/A</td>
                       <?php } ?>
                      
                       <?php if($rs_agent_name->fields['ticket_id']){?>
                       <td><a style="color: blue;" href="ticket_detail.php?id=<?php echo $rs_agent_name->fields['ticket_id']; ?>" target="_blank"><?php echo $rs_agent_name->fields['number']; ?></a></td>
                       <?php } else{?>
                       <td>N/A</td>
                       <?php } ?>
					</tr>
				<?php				
                $rs_agent_name->MoveNext();
                } 
                ?>
      			</tbody>
      		</table>  	
         <?php }elseif ($_REQUEST['type']=='dialed'){?>
         <table class="table-short">
      			<thead>
      			  <tr>
					 <td class="col-head2" style="width: 200px;">Caller Id </td>
	        	     <td class="col-head2">Date Time</td>
					 <td class="col-head2">Workcodes</td>
					</tr>
      			</thead>
      			<tbody>
				<?php  while(!$rs_agent_name->EOF){ ?>
      				<tr class="odd">
                    <td><?php echo $rs_agent_name->fields['caller_id']; ?></td>
                    <td><?php echo date('d-m-Y h:i:s',strtotime($rs_agent_name->fields['update_datetime']));?></td>
					<td><?php echo $rs_agent_name->fields['workcodes'];?></td>
					</tr>
				<?php				
                $rs_agent_name->MoveNext();
                } 
                ?>
      			</tbody>
      		</table>  	
		  <?php }elseif ($_REQUEST['type']=='abandoned'){?>
         <table class="table-short">
      			<thead>
      			  <tr>
					 <td class="col-head2" style="width: 200px;">Caller Id </td>
	        	     <td class="col-head2">Date Time</td>
					 <!--<td class="col-head2">Workcodes</td>-->
					</tr>
      			</thead>
      			<tbody>
				<?php  while(!$rs_agent_name->EOF){ ?>
      				<tr class="odd">
                    <td><?php echo $rs_agent_name->fields['caller_id']; ?></td>
                    <td><?php echo date('d-m-Y h:i:s',strtotime($rs_agent_name->fields['update_datetime']));?></td>
					<!--<td><?php echo $rs_agent_name->fields['workcodes'];?></td>-->
					</tr>
				<?php				
                $rs_agent_name->MoveNext();
                } 
                ?>
      			</tbody>
      		</table>  	
         
         <?php } ?>
      	</div>
	    <br />

</div>

<?php } ?>
</div>

</div>
</div>
<?php  include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
