<?php //include_once("includes/config.php"); ?>
<?php
        $page_name = "queue_wait_stats.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = date("F",time())." Calls Stats";
        $page_menu_title = "Queue Wait Stats";
?>

<?php //include_once($site_root."includes/check.auth.php"); ?>

<?php
	/*include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();*/
?>	
<?php //include($site_root."includes/header.php"); ?>	
<?php	
	//$total_records_count = $admin->get_records_count($txtSearch);
	//include_once("includes/paging.php");
	$recStartFrom = 0;
	$field = empty($_REQUEST["field"])?"update_datetime":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];
//	$rs = $admin->get_queue_wait_stats(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate);
	//$rs = $admin->get_agents_monthly_stats($month);  
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
		             <!--   <td class="col-head2">Caller ID</td> -->
		                <td class="col-head2">Agent Name</td>
		                <td class="col-head2">Month Name</td>
						<td class="col-head2">Received Call(s)</td>
						<td class="col-head2">Inquiry</td>
						<td class="col-head2">Complaints</td>
						<td class="col-head2">Average Talk Time</td>
						<!--<td class="col-head2">Start Time</td>-->
						
					</tr>
	 			</thead>
			</table>
			<?php 
			if($rs){ ?>
			<div class="box-container-scroll" >  		
    		<table class="table-short">
				<?php /*$stringData .= "<tag2>Caller ID</tag2>, <tag2>Customer ID</tag2>, <tag2>Wait In Queue</tag2>, <tag2>Agent Name</tag2>, <tag2>Date</tag2>, <tag2>Time</tag2>, <tag2>Duration</tag2>\r\n"; */ ?>
				<?php
				 
				// print_r($work->fields);
				 $stringData .= "<tag2>Agent Name</tag2>, <tag2>Month Name</tag2>, <tag2>Received Call(s)</tag2>,<tag2>Inquiry</tag2>,<tag2>Complaints</tag2>,<tag2>Average Talk Time</tag2>\r\n";  ?>
			<?php //$str = "'Caller ID','Customer ID','Wait In Queue','Agent Name','Date','Time','Duration'\r\n"; ?>
      			<tbody>
				<?php while(!$rs->EOF){ ?>
					<?php
					$complaint = $admin->get_agents_monthly_stats_sub_query($month,$rs->fields["staff_id"],'Complaint');	
					$inquiry = $admin->get_agents_monthly_stats_sub_query($month,$rs->fields["staff_id"],'Inquiry');													
					?>
      				<tr class="odd">
                      <!--  <td class="col-first"><?php //echo $rs->fields["unique_id"]; ?> </td>-->
						 <!-- <td class="col-first"><?php // echo $rs->fields["caller_id"]; ?> </td> -->
						<td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["month_name"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["calls_count"]; ?> </td>
						<td class="col-first"><?php echo $inquiry->fields["workcode_wise"]? $inquiry->fields["workcode_wise"] : "-"; ?></td>
						<td class="col-first"><?php echo $complaint->fields["workcode_wise"]? $complaint->fields["workcode_wise"] : "-"; ?></td>
						<td class="col-first"><?php echo $rs->fields["avg_talk_time"]; ?> </td>
						<!--<td class="col-first"><?php //echo $rs->fields["staff_start_datetime"]; ?> </td>-->
						
					</tr>
				
				
				<?php 
				/*$stringData .= $rs->fields["caller_id"].", ".$rs->fields["customer_id"].", ".$rs->fields["duration"].", ".$rs->fields["agent_name"].", ".$rs->fields["DATE"].", ".$rs->fields["TIME"].", ".$rs->fields["t_duration"]."\r\n"; 
				
				$rs->MoveNext();	} */?>
				<?php 
				$stringData .= $rs->fields["full_name"].", ".$rs->fields["month_name"].", ".$rs->fields["calls_count"].", ".$inquiry->fields["workcode_wise"].", ".$complaint->fields["workcode_wise"].", ".$rs->fields["avg_talk_time"]."\r\n"; 
				
				$rs->MoveNext();	} ?>
      			</tbody>
      		</table>  	
			
			
      	</div>
			<?php
			}else{ ?>
			<div class="box-container-scroll" >  		
    		<table class="table-short">
				
      			<tbody>
				
      				<tr class="odd">
                      
						<td class="col-first">No Record Found </td>
						
						
					</tr>
				
				
				
      			</tbody>
      		</table>  	
			
			
      	</div>
			<?php
			}
			?>
        	
     </div> 
	</div>



<?php
/*if(isset($_REQUEST['export']))
{

            //$db_export_server = $site_root."download/Pin_Reset_Records_".$today.".csv";
                $db_export_fix = $site_root."download/Pin_Reset_Records.csv";

                //$heading = "Unique ID, Caller Id, Customer ID, Status, File ID, Date,  Time,  Agent Name\r\n";
                shell_exec("echo '".$str."' > ".$db_export_fix);
                //shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);

                 ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    header("Content-type: application/force-download");
    //header("Content-Type: text/csv");

        //echo $db_export; exit;
    header("Content-Disposition: attachment; filename=".basename($db_export_fix).";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($db_export_fix));
    readfile($db_export_fix);
    if(file_exists($db_export_fix) && !empty($file_name)){
     unlink($db_export_fix);
     }
     exit();

}*/

?>
<!--</div> -->
<!--</form>-->
<?php //include($site_admin_root."includes/footer.php"); ?>
