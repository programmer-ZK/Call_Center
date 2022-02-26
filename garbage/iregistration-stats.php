<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "registration-stats.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Registration Stats";
        $page_menu_title = "Registration Stats";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/registration_reports.php");
	$registration_reports = new registration_reports();
		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
?>	
<?php include($site_root."includes/header.php"); ?>	


<?php
	



if(isset($_REQUEST['search_date']))
{
	$keywords			= $_REQUEST['keywords'];
	$search_keyword		= $_REQUEST['search_keyword'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate		 		= $_REQUEST['tdate'];
	
			if(isset($_REQUEST["search_date"]) && !empty($_REQUEST["search_date"]))
			{	
				//$rs = $admin->get_agent_list(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
				
			}	
		
}else
{
	$fdate 			= empty($_REQUEST["fdate"])?date('Y-m-d'):$_REQUEST["fdate"];
	$tdate 			= empty($_REQUEST["tdate"])?date('Y-m-d'):$_REQUEST["tdate"];
	$keywords 		= empty($_REQUEST["keywords"])?"":$_REQUEST["keywords"];
	$search_keyword = empty($_REQUEST["search_keyword"])?"":$_REQUEST["search_keyword"];
	
}
	
?>
<?php
	//include_once("includes/search_form.php");
		
	//$total_records_count = $pin_reports->get_records_count(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
	
	$count_type= "registration";	
	//$recStartFrom = 0;
	$field = empty($_REQUEST["field"])?"update_datetime":$_REQUEST["field"];
	$order = empty($_REQUEST["order"])?"desc":$_REQUEST["order"];
	//echo "Field => ".$field." $order => ".$order;
	if($search_keyword == "ivr")
	{
		$total_records_count = $registration_reports->get_records_ivr_counts(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		$rs = $registration_reports->get_records_ivr(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
	}
	if($search_keyword == "sms")
	{
		$total_records_count = $registration_reports->get_records_sms_counts(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
		$rs = $registration_reports->get_records_sms(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
	}
	
		include_once("includes/paging.php");
	//$rs = $pin_reports->get_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $fdate, $tdate, $search_keyword, $keywords);
?>


<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
<div class="box">
<?php $form_type = "registration"; 
 include($site_admin_root."includes/search_form.php"); ?>
<?php  include($site_admin_root."includes/date_search_bar.php"); ?>
</div>
<br />
<div id="mid-col" class="mid-col">
	<div class="box">
        <h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container" style="overflow:auto; height:600px;">  		
      		<table class="table-short">
      			<thead>
					<tr>
	                	<td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		    </tr>
      				<tr>
					<td class="col-head2"><a href="<?php echo($page_name);?>?field=unique_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Tracking ID</a></td>
	        	        <td class="col-head2"><a href="<?php echo($page_name);?>?field=caller_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Caller ID</a></td>
						 <td class="col-head2"><a href="<?php echo($page_name);?>?field=customer_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Customer ID</a></td>
						 <td class="col-head2"><a href="<?php echo($page_name);?>?field=trans_id&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Trans. ID</a></td>
		                <td class="col-head2"><a href="<?php echo($page_name);?>?field=date&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Date</a></td>
						<td class="col-head2"><a href="<?php echo($page_name);?>?field=time&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Time</a></td>
		               <!-- <td class="col-head2"><a href="<?php //echo($page_name);?>?field=Duration&order=<?php //echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php //echo $fdate; ?>&tdate=<?php //echo $tdate; ?>&keywords=<?php //echo $keywords; ?>&search_keyword=<?php //echo $search_keyword; ?>">Duration</a></td>-->
						 <td class="col-head2"><a href="<?php echo($page_name);?>?field=agent_name&order=<?php echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php echo $fdate; ?>&tdate=<?php echo $tdate; ?>&keywords=<?php echo $keywords; ?>&search_keyword=<?php echo $search_keyword; ?>">Agent Name</a></td>
						 <!--<td class="col-head2"><a href="<?php //echo($page_name);?>?field=call_type&order=<?php //echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php //echo $fdate; ?>&tdate=<?php //echo $tdate; ?>&keywords=<?php //echo $keywords; ?>&search_keyword=<?php //echo $search_keyword; ?>">Call Type</a></td>
						<td class="col-head2"><a href="<?php //echo($page_name);?>?field=uniqueid&order=<?php //echo(($_REQUEST["order"]=="asc")?"desc":"asc");?>&fdate=<?php //echo $fdate; ?>&tdate=<?php //echo $tdate; ?>&keywords=<?php //echo $keywords; ?>&search_keyword=<?php //echo $search_keyword; ?>">Call ID</a></td>-->
						
						<!--<td class="col-head2">Audio File</td>-->
					</tr>
      			</thead>
      			<tbody>
				<?php while(!$rs->EOF){ ?>
      				<tr class="odd">
                        <td class="col-first"><a title="click here to download" target="_blank" href="recording/<?php echo $rs->fields["userfield"]; ?>.wav" ><?php echo $rs->fields["unique_id"]; ?> </a></td>					<?php //if($rs->fields["status"] == "1"){ $pin_status = "SUCCESS"; }
							//else if($rs->fields["status"] == "2"){$pin_status = "FAILED";}
							//else if($rs->fields["status"] == "3"){$pin_status = "FAILED";}
						 ?>
						<td class="col-first"><?php echo $rs->fields["caller_id"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["customer_id"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["trans_id"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["date"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["time"]; ?> </td>
						<!--<td class="col-first"><?php //echo $rs->fields["Duration"]; ?> </td>-->
						<td class="col-first"><?php echo $rs->fields["agent_name"]; ?> </td>
						<!--<td class="col-first"><?php //echo substr($rs->fields["call_type"],0,1); ?> </td>					
						<td class="col-first"><a href="call_detail.php?unique_id=<?php //echo $rs->fields["uniqueid"];?>" ><?php //echo $rs->fields["uniqueid"]; ?></a></td>-->
						<!--<td class="col-first"><a title="click here to download" target="_blank" href="recording/<?php //echo $rs->fields["userfield"]; ?>.wav" > Audio <?php //echo $rs->fields["userfield"]; ?></a></td>-->
					</tr>
				<?php $rs->MoveNext();	} ?>
      			</tbody>
      		</table>  	
      	</div>
      </div> 
	</div>
</div> 
</form>

<?php include($site_admin_root."includes/footer.php"); ?>
