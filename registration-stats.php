<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "registration-stats.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Registration Stats";
        $page_menu_title = "Registration Stats";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
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
        include_once('lib/nusoap.php');

        include_once("classes/admin.php");
        $admin = new admin();

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();

		include_once("classes/user_tools.php");		
		$user_tools = new user_tools(); 
?>

<?php

if(isset($_REQUEST['export']))
{
	$stringDataHeader  = $_REQUEST['stringDataHeader'];
	$stringData			= $_REQUEST['stringData'];
	$stringData = str_replace('<tag1>',NULL,$stringData);
	$stringData = str_replace('</tag1>',NULL,$stringData);
	$stringData = str_replace('<tag2>',NULL,$stringData);
	$stringData = str_replace('</tag2>',NULL,$stringData);
	$stringData = str_replace('<tag3>',NULL,$stringData);
	$stringData = str_replace('</tag3>',NULL,$stringData);
	
	//$db_export_server = $site_root."download/Pin_Reset_Records_".$today.".csv";
	$db_export_fix = $site_root."download/Registration_Stats.csv";
	
	//$heading = "Unique ID, Caller Id, Customer ID, Status, File ID, Date,  Time,  Agent Name\r\n";
	shell_exec("echo '".$stringDataHeader."' > ".$db_export_fix);
	shell_exec("echo '".$stringData."' >> ".$db_export_fix);
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
	
}

if(isset($_REQUEST['export_pdf']))
{
	$stringDataHeader  = $_REQUEST['stringDataHeader'];
	$stringData			= $_REQUEST['stringData'];
	
	    //$db_export_server = $site_root."download/Pin_Reset_Records_".$today.".csv";
		$db_export_fix = $site_root."download/Registration_Stats.csv";
		
		//$heading = "Unique ID, Caller Id, Customer ID, Status, File ID, Date,  Time,  Agent Name\r\n";
		shell_exec("echo '".$stringDataHeader."' > ".$db_export_fix);
		shell_exec("echo '".$stringData."' >> ".$db_export_fix);
		//shell_exec("cat '".$db_export_server."' >> ".$db_export_fix);
		
	///////////////////------HK------///////////////////
	//echo $db_export_fix; exit();
	ob_end_clean();
	//generatePDF($inputFile, $pageOrient, $unit, $pageSize, $font, $fontSize, $outputFileName, $dest, $cellWidth, $cellHeight, $cellBorder)
	$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'Registration_Stats.pdf', 'D', 160, 16, 1);
	exit();
	
}
		
		//$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
		//$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
		
		if($search_keyword == "Pending" || $search_keyword == "Executed" || $search_keyword == "Processing" || $search_keyword == "Rejected"){
			$status = $search_keyword;
			$customer_id	= '';
			//$account_no		= '';
			$channel_type = '';
		}
		else if($search_keyword == "physical" || $search_keyword == "ivr"){
			$status 		= '';
			$customer_id	= '';
			//$account_no		= '';
			$channel_type 	= $search_keyword;
		}
		else if($search_keyword == "customer"){
			$status 		= '';
			$customer_id	= $_REQUEST['keywords'];
			//$account_no		= $_REQUEST['keywords'];
			$channel_type 	= '';
		}
		$fdate = $_REQUEST['fdate'];
		$tdate	= $_REQUEST['tdate'];
		
		$method = 'GetContactRegisteredInfo';
		$params = array('AccessKey' => $access_key,'AccountNo' => '','CustomerId' => $customer_id,'Channel' => $channel,'Status' => $status,'FromDate' => $fdate,'ToDate' => $tdate,'ChannelType' => $channel_type); 
		
		//print_r($params); //exit;
		
		$rs1 = $soap_client->call_soap_method($method,$params);
		//print_r($rs1); exit;

?>

<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Registration Report</div>
<div>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
	<div class="box">
	<?php 
		$stringData = '';
		$form_type = "registration"; 
		include($site_admin_root."includes/search_form.php"); 
		include($site_admin_root."includes/date_search_bar.php"); 
	?>
	</div>

<div id="mid-col" class="mid-col">
	<div class="box">
        <h4 class="white" ><?php echo("Contact Detail"); ?></h4>
		
		    <table class="table-short" style="background-color:#FFFFFF; margin-left:0px;width:auto;">
      			<thead>
      				<tr>
						<td class="col-head2" style="width:20%;">&nbsp;&nbsp;&nbsp;ID</td>
						<td class="col-head2">Customer ID </td>
						<td class="col-head2">Channel</td>
						<td class="col-head2">Modified On</td>
						<td class="col-head2">Status</td>
						<td class="col-head2">CallLogId</td>
						<?php $stringDataHeader = "<tag1>Registration Stats</tag1>\r\n"; $stringDataHeader .= "<tag2>ID</tag2>, <tag2>Customer ID</tag2>, <tag2>Channel</tag2>, <tag2>Modified On</tag2>, <tag2>Status</tag2>, <tag2>CallLogId</tag2>";  ?>
 						<td class="col-head2"></td>						
      				</tr>
      			</thead>
			</table>
		
        <div class="box-container" style="overflow:auto; height:600px;">
      		<table class="table-short">
      			<tfoot><!--
      				<tr>
      					<td class="col-chk"><input type="checkbox" /></td>
      					<td colspan="4"><div class="align-right"><select class="form-select"><option value="option1">Bulk Options</option><option value="option2">Delete All</option></select>
      					<a href="#" class="button"><span>perform action</span></a></div></td>
      				</tr> -->
      			</tfoot>
      			<tbody>
			<?php
	                //$count = 0;
					//print count($rs1)."yahya";exit;
					
					$total_records_count = count($rs1);
					include_once("includes/paging.php");
					
					$count = $recStartFrom;
					
					//echo "total counts: ".$total_records_count." Start: ".$recStartFrom." Limit: ".($recStartFrom + $page_records_limit);
					
                	while($count < ($recStartFrom + $page_records_limit) && $count != $total_records_count){ 
					
						if(ucwords($rs1[$count]["IsResidenceRegister"]) == "YES")
						{
							$checked_str_r ="checked=\"checked\"";		
						}
						else
						{
							$checked_str_r ="checked=\"checked\"";			
						}
						if(ucwords($rs1[$count]["IsOfficeRegister"]) == "YES")
						{
							$checked_str_o ="checked=\"checked\"";		
						}
						else
						{
							$checked_str_o ="";					
						}	
						if(ucwords($rs1[$count]["IsMobileTransRegister"]) == "YES")
						{
							$checked_str_m ="checked=\"checked\"";		
						}
						else
						{
							$checked_str_m ="";					
						}
						
						if(ucwords($rs1[$count]["IsMobileSmsRegister"]) == "YES")
						{
							$checked_str_sms ="checked=\"checked\"";	
						}
						else
						{
							$checked_str_sms ="";			
						}
					
					?>

      				<tr class="odd">
      					<!--<td class="col-chk"><input type="checkbox" /></td>-->
      					<td class="col-first">
							<?php
							$fields     = "staff_id";
							$tbl        = "ivr_registration"; 
							$where      =  "trans_id = '".$rs1[$count]['Id']."'";
							$agent_id   = $tools_admin->select($fields, $tbl, $where);
							$agent_name = $admin->get_admin_by_id($agent_id);
							?>
							<?php  echo $rs1[$count]["Id"]."<br>".$agent_name->fields['full_name']; ?>
						</td>
						<td class="col-first">
							<?php  echo $rs1[$count]["CustomerId"]; ?>
						</td>
      					<td class="col-first">
							<?php echo $rs1[$count]["Channel"]; ?>
						</td>
      					<td class="col-first">
							<?php echo $rs1[$count]["ModifiedOn"]; ?>
						</td>
						<td class="col-first">
							<?php echo substr($rs1[$count]["Status"],0,3); ?>
						</td>
						<td class="col-first">
							<?php echo $rs1[$count]["CallLogId"]; ?>
						</td>																		
<!--						<td class="col-first">
							<input type="radio" name="residence" id="residence" value="<?php //echo $rs1[$count]["Residence"]; ?>" <?php //echo $checked_str_r; ?> disabled="disabled"/>
							<?php //echo $rs1[$count]["Residence"]; ?> 
						</td>
	                    <td class="col-first">
							<input type="radio" name="office" id="office" value="<?php //echo $rs1[$count]["Office"]; ?>" <?php //echo $checked_str_o; ?> disabled="disabled"/>
							<?php //echo $rs1[$count]["Office"]; ?> 
						</td>
						<td class="col-first">
							<input type="radio" name="mobile" id="mobile" value="<?php //echo $rs1[$count]["Mobile"]; ?>"  <?php //echo $checked_str_m; ?> disabled="disabled"/>
							<?php //echo $rs1[$count]["Mobile"]; ?> 
							<br />
							<input type="radio" name="mobile_sms" id="mobile_sms" value="<?php //echo $rs1[$count]["Mobile"]."_sms"; ?>"  <?php //echo $checked_str_sms; ?> disabled="disabled"/>
							SMS
						</td>
-->
						<!--<td class="row-nav"><a href="registeration_detail.php?customer_id=<?php //echo $rs1[$count]["CustomerId"]; ?>&account_no=<?php //echo $rs1[$count]["AccountNo"]."&tid=".$rs1[$count]["Id"]; ?>" class="table-edit-link">View</a> </td>-->

      				</tr>
			 <?php
			 			 //$stringData .= "\"".$rs1[$count]["Id"]."\",\"".$rs1[$count]["Channel"]."\",\"".$rs1[$count]["ModifiedOn"]."\",\"".$rs1[$count]["Status"]."\",\"".$rs1[$count]["CallLogId"]."\"\r\n";
						 
						$stringData .= $rs1[$count]["Id"]."-".$agent_name->fields['full_name'].", ".$rs1[$count]["CustomerId"].", ".$rs1[$count]["Channel"].", ".$rs1[$count]["ModifiedOn"].", ".$rs1[$count]["Status"].", ".$rs1[$count]["CallLogId"]."\r\n";
						 
                        $count++;
                }
				$stringData .= trim($stringData);
                ?>
				
				<tr> 
				<?php 
						if($rs1[0]["IsMobileSmsRegister"] == "Y")
						{ ?>
							 <td colspan="12" class="paging"><b>Number Registered for SMS Services :<?php echo $rs1[0]["Mobile"]; ?> </b></td>	
						<?php }
						else
						{
											
						}
				?>
				
         	        </tr>
<!--					<tr> 
				 <td colspan="12" class="paging"><b>Registered for Tele Transact Services "<input type="radio" name="dumy" id="dumy" value="dumy"  checked="checked" disabled="disabled"/>"</b></td>
         	        </tr>
					<tr> 
				 <td colspan="12" class="paging"><?php echo($paging_block);?></td>
         	        </tr>-->

      			</tbody>
      		</table>
        </div>
		<p><?php echo($paging_block);?></p>
	</div> 
</div>
</form>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2">

<div style="float:right;padding-top:5px;">
		 <a class="button" href="javascript:document.xForm2.submit();" >
		 <span>Export Excel</span>
		 </a>
		<input type="hidden" value="export >>" id="export" name="export" />
		
		<input type="hidden" value="<?php echo $stringData; ?>" id="stringData"		name="stringData" />
		<input type="hidden" value="<?php echo $stringDataHeader; ?>" id="stringDataHeader"		name="stringDataHeader" />
		</div>
</form>

<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm3" id="xForm3">

<div style="float:right;padding-top:5px;">
		 <a class="button" href="javascript:document.xForm3.submit();" >
		 <span>Export PDF</span>
		 </a>
		<input type="hidden" value="export >>" id="export_pdf" name="export_pdf" />
		
		<input type="hidden" value="<?php echo $stringData; ?>" id="stringData"		name="stringData" />
		<input type="hidden" value="<?php echo $stringDataHeader; ?>" id="stringDataHeader"		name="stringDataHeader" />
		</div>
</form>
</div>
<?php include($site_admin_root."includes/footer.php"); ?>
