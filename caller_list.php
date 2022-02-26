
<?php include_once("includes/config.php"); ?>
<?php
		$page_name = "Caller List";
		$page_title = "Caller List";
		$page_level = "1";
		$page_group_id = "1";
		$page_menu_title = "Caller List";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admins = new admin();		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
	include_once("classes/campaign.php");
			  $campaign = new campaign();
?>	
<?php include($site_root."includes/header.php"); ?>
	<script type="text/javascript">
function getHtml4Excel()
{
document.getElementById("gethtml1").value = document.getElementById("call_list").innerHTML;
}

</script>
<?php   $campaign_id 				= $_REQUEST['campaign_id'];


		$id						= $_REQUEST['id'];
//$_POST[$campaign_id];
	
	
	$total_records_count = $campaign->get_count_numbers($campaign_id,$recStartFrom, $page_records_limit, $field, $order, $name, $cnic, $caller_id,$caller_id2, $caller_id3, $city,$source,$other);
	//echo $total_records_count;exit;
	include_once("includes/paging.php");
	
			$rs = $campaign->get_numbers($campaign_id,$recStartFrom, $page_records_limit, $field, $order,  $name, $cnic, $caller_id,$caller_id2, $caller_id3, $city,$source,$other);
				
					//echo $campaign_id;exit;
					
					$name		 					= $_POST['name'];
					$cnic 							= $_POST['cnic'];
					$caller_id						= $_POST['caller_id'];
					$caller_id2						= $_POST['caller_id2'];
					$caller_id3						= $_POST['caller_id3'];
					$city							= $_POST['city'];
					$ic								= $_POST['ic'];
					$source							= $_POST['source'];
					$other							= $_POST['other'];
					$attempts							= $_POST['attempts'];
					
			

	?>
	
	
<?
if(isset($_REQUEST['export']))
{
	$stringData	= trim($_REQUEST['gethtml1']);
	$stringData = preg_replace('/Â/','',$stringData);
	$stringData = preg_replace('/<form name="xForm" (.*)>/isU', '', $stringData);
	$stringData = preg_replace('/<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<form name="xForm2" (.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<form name="xForm3" (.*)<\/form>/isU', '', $stringData);
	$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);
	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
	$stringData = preg_replace('/EXPORT PDF/', '', $stringData); 
	
	$stringData = str_replace('<tag1>',null,$stringData);
	$stringData = str_replace('</tag1>',null,$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);
	$stringData = str_replace('<tag3>',null,$stringData);
	$stringData = str_replace('</tag3>',null,$stringData);
	
	
	$db_export_fix = $site_root."download/caller_list.xls";

	shell_exec("echo '<html><body>".$stringData."</html></body>' > ".$db_export_fix);
		
	ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
	header("Content-Type: application/ms-excel");
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
								
	$stringData			= trim($_REQUEST['stringData']);
	$db_export_fix = $site_root."download/Campaign_Report.csv";
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
	ob_end_clean();
	$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'campaign_answers.pdf', 'D', 160, 16, 1);
	exit();
}
?>
	<div id="call_list">
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
	



<!-- -------------------- -->

<div class="full-col-center" id="full-col-center" >
<div id="full-col" class="full-col">
<div class="box">
      		<h4 class="white"><?php echo($page_title); ?></h4>
        <div class="box-container">
                <table class="table-long">
      			<thead>
				<tr >
				<input type="hidden" id="campaign_id" name="campaign_id" value="<?php echo $tools_admin->encryptId($campaign_id); ?>"/>
				<input type="hidden" name="id" id="id"   value="<?php echo $rs->fields["id"]; ?>" >
	                        <td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
      				<tr>
						<td class="col-head" style="width:100px;">Name</td>
							
					<td class="col-head" style="width:100px;">ID/CNIC</td>
									
						<td class="col-head" style="width:100px;">Contact#1</td>  
					
						<td class="col-head" style="width:100px;">Contact#2</td>
						                     				
					<td class="col-head" style="width:100px;">Contact#3</td> 
										
						<td class="col-head" style="width:100px;">City</td>    	
								
						<td class="col-head" style="width:100px;">IC</td>
						
						<td class="col-head" style="width:100px;">Source</td>
						<td class="col-head" style="width:100px;">Number of Attempts</td>

					<!--	<td class="col-head">Other</td>-->
						
				<!--		<td class="col-head2">Edit</td>-->
	

				</tr>
      			</thead>

      			<tfoot>
      				<tr>
      					
	
	</td>
	<div class="align-right"><br/>
	
      				</tr>

      			</tfoot>
      			<tbody>
				 <?php
			    
					 
								while(!$rs->EOF){ ?>
	
					<tr class="odd">
					
					
				
					<td class="col-first"><input  readonly="readonly" name="name[]" id="name[]"  maxlength="15"  size="12"  style="border:none" value="<?php echo $rs->fields["name"]; ?>" > </td>
					
					
					<td class="col-first"><input readonly="readonly" name="cnic[]" id="cnic[]"  maxlength="15" size="12"  style="border:none" value="<?php echo $rs->fields["cnic"]; ?>" ></td>
					
					<td class="col-first"><input readonly="readonly"  name="caller_id[]" id="caller_id[]" style="border:none" maxlength="15" size="12"  value="<?php echo $rs->fields["caller_id"]; ?>" > </td>
					<td class="col-first"><input readonly="readonly" name="caller_id2[]" id="caller_id2[]" size="12" style="border:none"  maxlength="15"   value="<?php echo $rs->fields["caller_id2"]; ?>" > </td>
					<td class="col-first"><input readonly="readonly" name="caller_id3[]" id="caller_id3[]"  size="12"  style="border:none" maxlength="15" value="<?php echo $rs->fields["caller_id3"]; ?>" > </td>
					<td class="col-first"><input readonly="readonly" name="city[]" id="city[]"  maxlength="15"  size="12"  style="border:none" value="<?php echo $rs->fields["city"]; ?>" > </td>
					<td class="col-first"><input name="ic[]" style="border:none" size="12"  id="ic[]"   maxlength="5" value="<?php echo $rs->fields["ic"]; ?>" > </td>
					<td class="col-first"><input  style="border:none" readonly="readonly" name="source[]" size="12"  id="source[]"  maxlength="15"  value="<?php echo $rs->fields["source"]; ?>" > </td>
					<td class="col-first"><input style="border:none" readonly="readonly" name="attempts[]" size="12"  id="attempts[]"  maxlength="15"  value="<?php echo $rs->fields["attempts"]; ?>" > </td>
					
					
				

									  
					 <?php
									$rs->MoveNext();
								}
							?>

			</tr>
			
      			</tbody></thead>
      		</table>  	
      	</div><!-- end of div.box-container -->
      	</div> <!-- end of div.box -->
</div><!-- end of div#mid-col -->
      	
</div> <!-- full-col-center end -->
</form></div>
<!-- --------------------- --><br/>

<form name="xForm2" id="xForm2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">

 <div style="float:left"><a  style="float:right" class="button" href=""  onclick="history.go(-1);return false;" ><span>Back</span></a>
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();"class="button" >
	 <span>Export EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>

</form></div>

	<?php include($site_admin_root."includes/footer.php"); ?>