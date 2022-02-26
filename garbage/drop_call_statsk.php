<?php //include_once("includes/config.php"); ?>
<?php
        $page_name = "drop_call_stats.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Dropped Call Stats";
        $page_menu_title = "Drop Call Stats";
?>

<?php //include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
?>	
<?php //include($site_root."includes/header.php"); ?>	
<?php	
	//$total_records_count = $admin->get_records_count($txtSearch);
	//include_once("includes/paging.php");
	$recStartFrom = 0;
	$field = empty($_REQUEST["field"])?"update_datetime":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];
	$rs = $admin->get_drop_call_stats(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate);
	
?>

<!--<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">-->
<div id="mid-col" class="mid-col">
	<div class="box">
        <h4 class="white"><?php echo($page_title); ?></h4>
		
		    <table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
      			<thead>
					<tr>
	                	<td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		    </tr>
      				<tr>
	        	       <!-- <td class="col-head2">Call ID</td>-->
		                <td class="col-head2">Caller ID</td>
		                <!--<td class="col-head2">Customer ID</td>-->
		                <td class="col-head2">Call Time</td>
						<td class="col-head2">Wait In Queue</td>
						<!--<td class="col-head2">Start Time</td>-->
						<!--<td class="col-head2">Agent Name</td>-->						
						<!--<td class="col-head2">Date</td>-->
					</tr>
      			</thead>
			</table>
        	<div class="box-container-scroll">  		
      		<table class="table-short">
<!--      			<thead>
					<tr>
	                	<td colspan="12" class="paging"><?php// echo($paging_block);?></td>
        		    </tr>
      				<tr>
	        	       <!-- <td class="col-head2">Call ID</td>--/>
		                <td class="col-head2">Caller ID</td>
		                <!--<td class="col-head2">Customer ID</td>--/>
		                <td class="col-head2">Call Time</td>
						<td class="col-head2">Wait In Queue</td>
						<!--<td class="col-head2">Start Time</td>--/>
						<!--<td class="col-head2">Agent Name</td>--/>						
						<!--<td class="col-head2">Date</td>--/>
					</tr>
      			</thead>-->
      			<tbody>
				<?php $stringData .= "<tag2>Caller ID</tag2>, <tag2>Call Time</tag2>, <tag2>Wait in Queue</tag2>\r\n";  ?>
				<?php while(!$rs->EOF){ ?>
					<?php
						/*if($rs->fields["status"] == '1'){
							$str ="Waiting";
						}
						else if($rs->fields["status"] == '2'){
							$str ="Ringing";
						}
						else if($rs->fields["status"] == '3'){
							$str ="Talking";
						}
						else if($rs->fields["status"] == '201'){
							$str ="Pin Generation";
						}
						else if($rs->fields["status"] == '202'){
							$str ="Re-Enter Pin";
						}
						else if($rs->fields["status"] == '200'){
							$str ="Pin Generation Successfully";
						}							
						else if($rs->fields["status"] == '-200'){
							$str ="Pin Generation Failure";
						}
						else if($rs->fields["status"] == '301'){
							$str ="Pin Verfication";
						}
						else if($rs->fields["status"] == '300'){
							$str ="Pin Verfication Successfully";
						}
						else if($rs->fields["status"] == '-300'){
							$str ="Pin Verfication Failure";
						}
						else if($rs->fields["status"] == '-1'){
							$str ="Set Work Codes";
						}							
						else {
								$str ="Unkown";
						}					*/																
					?>
      				<tr class="odd">
                      <!--  <td class="col-first"><?php //echo $rs->fields["unique_id"]; ?> </td>-->
						<td class="col-first"><?php echo $rs->fields["caller_id"]; ?> </td>
						<!--<td class="col-first"><?php //echo $rs->fields["customer_id"]; ?> </td>-->
						<td class="col-first"><?php echo $rs->fields["time"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["duration"]; ?> </td>
						<!--<td class="col-first"><?php //echo $rs->fields["staff_start_datetime"]; ?> </td>-->
						<!--<td class="col-first"><?php //echo $rs->fields["staff_id"]; ?> </td>-->						
						<!--<td class="col-first">&nbsp;<?php //echo $rs->fields["date"]; ?> </td>-->
					</tr>
					
				<?php 
				$stringData .= $rs->fields["caller_id"].", ".$rs->fields["time"].", ".$rs->fields["duration"]."\r\n"; 
				
				$rs->MoveNext();	} ?>
      			</tbody>
      		</table>  	
			
      	</div>
     </div> 
	</div>
<!--</div> -->
<!--</form>-->
<?php //include($site_admin_root."includes/footer.php"); ?>
