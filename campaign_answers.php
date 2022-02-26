	<?php include_once("includes/config.php"); ?>
		<?php session_start();
			$page_name = "campaign_answers.php";
			$page_title = "Campaign Answers";
			$page_level = "2";
			$page_group_id = "1";
			$page_menu_title = "Campaign Answers ";
		?>
		<?php include_once($site_root."includes/check.auth.php"); ?>
		<?php 	
			include_once("classes/tools_admin.php");
			$tools_admin = new tools_admin();
			include_once("classes/templates.php");
			$templates = new templates();
			include_once("classes/campaign.php");
			$campaign = new campaign();
			include_once("classes/agent.php");
			$agent = new agent();
		?>
	
<?php

	
	include_once("classes/reports.php");
	$reports = new reports();
?>	
<?php include($site_root."includes/header.php"); ?><head>


<script type="text/javascript">
function getHtml4Excel()
{
document.getElementById("gethtml1").value = document.getElementById("agent_pd_report2").innerHTML;
}
	//var loop=1;
       function showCustomer(str,str2,str4,str5){
	 //  alert (str5);
	//  alert (str);
	 //  alert (str2);
	 //   alert (str4);
//alert(document.getElementById("txtarea"+str4).id);
            if (str=="")
              { 
             document.getElementById("txtarea"+str4).innerHTML="";
              return;
              }//loop++;
			//  alert ( document.getElementById("txtarea"+loop).id);loop++;
			 //str=   document.getElementById("campaign_id").value;
			  str3=   document.getElementById("campaign_id").value;
			 
			 //alert (str2);
            if (window.XMLHttpRequest)
              {// code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
             document.getElementById("txtarea"+str4).innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","getuser.php?q="+str+"&x="+str2+"&y="+str3+"&z="+str5,true);
            xmlhttp.send();
	 
      } 


</script>

</head>

<div id="cid">
<?php

$campaign_id			=	$_REQUEST['select'];
$campaignid				=	$campaign->id_get2($campaign_id);



?>
</div>
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
	
	$stringData = str_replace('<tag1>',null,$stringData);//'<div style="border:2px solid #000000;background-color:#F2F2F2; margin-top:10px;margin-bottom:10px;">'
	$stringData = str_replace('</tag1>',null,$stringData);//'</div>'
	//$stringData = str_replace(' ','<br>',$stringData);
	$stringData = str_replace('<tag2>',null,$stringData);
	$stringData = str_replace('</tag2>',null,$stringData);
	$stringData = str_replace('<tag3>',null,$stringData);
	$stringData = str_replace('</tag3>',null,$stringData);
	
	//$stringData = preg_replace('/[^a-zA-Z0-9]/s', '', $stringData);
	$db_export_fix = $site_root."download/campaign_answers_customer_wise.xls";
	//echo $stringData; exit;
	shell_exec("echo '<html><body>".$stringData."</html></body>' > ".$db_export_fix);
		
	ob_end_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private",false);
    //header("Content-type: application/force-download");
    //header("Content-Type: text/csv");
	header("Content-Type: application/ms-excel");
    
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
								
	$stringData			= trim($_REQUEST['stringData']);
	$db_export_fix = $site_root."download/campaign_answers_customer_wise.csv";
	shell_exec("echo '".trim($stringData)."' > ".$db_export_fix); 
	ob_end_clean();
	$tools_admin->generatePDF($db_export_fix, 'L', 'pt', 'A3', 'Arial', 12, 'campaign_answers.pdf', 'D', 160, 16, 1);
	exit();
}
?>


<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Campaign Answers Report</div>
	
   
<div>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
<div class="box">
<h4 class="white">
	 	<?php 	
	echo "View By Campaign:";
		?>
		<td><?php  $id			=	$_REQUEST['select'];
echo "<select name='select' id='select'>";
while(!$campaignid->EOF){
    echo "<option value='".$campaignid->fields['campaign_id']."'>".$campaignid->fields["campaign_name"]."</option>";
	$campaignid->MoveNext();
	}
echo "</select>";?>
<a class="button" href="javascript:document.xForm.submit();" onClick="javascript:return msg_validate('xForm');" ><span>Show</span></a>

				
			
				
				<input type="hidden" value="Show" id="show" name="show"/>
				
</td>
</h4>

</div>

<?php

if ((isset($_POST['show']))||(isset($_GET['campaign_id'])))
{
$id			=	$_REQUEST['select'];// echo $id;
$result=$campaign->campaign_name($id);
//echo 'waleed'.'-'.$id;exit;
?>




<div id="mid-col"  class="mid-col">

	<div class="box"  >
<div style="width:500px;">
<br/><br/>
	<h4 class="white" >
	
	 	<?php 	
	echo "Campaign Answers Report";
		?>
		
	 <br/><br/>	<?php 	
	echo "Campaign Name:".$result->fields['campaign_name'];
		
		?>
	</h4>
</div>
	
	
	<div class="box-container" style="width:480px;"  >  	

				
			
			<?php 
			$counter=1;
			if (isset($_GET['campaign_id'])){
			$paging = $_GET['pgno'];// echo $paging.'asd';exit;
$counter = (($paging-1) * 25 )+1;
			$campaign_id			=	$_GET['campaign_id'];
			
			}
			
			
			 
$total_records_count = $agent->count_customer_info($campaign_id,$recStartFrom, $page_records_limit, $field, $order);
	//echo $total_records_count.'asda';exit;
	include("includes/paging.php");//echo $recStartFrom.$page_records_limit;exit;
		$info = $agent->customer_info($campaign_id,$recStartFrom,$page_records_limit);
	?>
	<table class="table-short">
					<thead >
					
					
					<tr>
					<td colspan="12" class="paging"><?php echo($paging_block);?></td>
        		        </tr>
      			
					<td class="col-head">S.No</td>
					<td class="col-first">Customer Name / Number</td>
					<td class="col-first">Question</td>
					<td class="col-first">Answer</td>	
			
			
			
      		</thead>
			<tbody><?
			//$info = $agent->customer_info($campaign_id); 
			while (!$info->EOF){ $name=$info->fields['name']; ?>
	<tr>
		
	<td class="col-first"><?php echo $counter;?></td>
	 			
		
		<td class="col-first"><?php  if ( $name != '') {echo $info->fields['name'] ;} else {echo $info->fields['caller_id'] ;}  		?></td>
		
		
		
		<td class="col-first">
		
		
		
		<form action="">
		<?php $campaign_answers_data	=	$agent->campaign_answers_data($campaign_id); ?>
<input type="hidden" name="campaign_id" id="campaign_id" value="<?php echo $campaign_id;?>" />

<input type="hidden" name="name" id="name" value="<?php echo $info->fields['name'];?>" />
<input type="hidden" name="caller_id" id="caller_id" value="<?php echo $info->fields['caller_id'];?>" />
<select  name='select2' id='select2'onchange="javascript:showCustomer(this.value,'<?php echo  $info->fields['name']; ?>','<?php echo  $counter; ?>','<?php echo $info->fields['caller_id'];?>');" >
 <? echo "<option value='Default' default='default'>Please Select</option>";
 while(!$campaign_answers_data->EOF){
 echo "<option value='".$campaign_answers_data->fields['question']."'>".$campaign_answers_data->fields["question"]."</option>";
	$campaign_answers_data->MoveNext();
	}
echo "</select>";?>

</form>
		
		</td>
		
		<td class="col-first">
		
		
<p id="txtarea<?=$counter;?>" name="txtarea<?=$counter;?>" readonly="readonly" style="resize:none;"></td>
		
		
		
		
		
					</tr>	<?php 	$counter++;   $info->MoveNext();} ?>
				</tbody>
				</table>

		
	</div>

	

	</div></div></div>
	
	<!--<form name="xForm2" id="xForm2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="  float:right; ">
	<a onClick="getHtml4Excel()"  href="exporting_cam_answers.php?campaign_id=<?=$campaign_id   ;?>"class="button" >
	 <span>Export EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>

</form> -->
<? 
} ?>	

</form>
</div>





<?php include($site_admin_root."includes/footer.php"); ?>

