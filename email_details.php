<?php  include_once("includes/config.php"); ?>


<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/admin.php");
	$admins = new admin();		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
include_once("classes/tools.php");
	$tools = new tools();
	include_once("classes/email.php");
	$email = new email();
	include_once("classes/reports.php");
	$reports = new reports();
//echo "waleed";		
?>	

<?php 
if(isset($_REQUEST['export']))
{
	
	/*$stringData	= trim($_REQUEST['stringData']);*/
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
	$db_export_fix = $site_root."download/Email.xls";
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









 $email_id=$_REQUEST['email_id']; $show = $email->email_show($email_id);
	?>
<script type="text/javascript">
function getHtml4Excel()
{
document.getElementById("gethtml1").value = document.getElementById("email_report").innerHTML;
}

</script>
<style type="text/css">
table.example3 {background-color:transparent;width:60%;}
table.example3 th, table.example3 td {text-align:left;border:2px solid black;padding:10px;}
table.example3 th {background-color:AntiqueWhite;}
table.example3 td:first-child {width:20%;}
</style><div id="email_report">

<table class="example3">
<tr>
<th colspan="2">EMAIL DETAILS VIEW</th>
</tr>
<tr>
<td width="10%">To:<? echo $show->fields["to_address"]; ?></td></tr><tr>
<td>Cc:<?php echo $show->fields["cc"];  ?> </td></tr>

<tr>
<td>Bcc:<?php echo $show->fields["bcc"];  ?></td></tr>
<tr>
<td>Subject:<?php echo $show->fields["subject_of_email"];  ?></td></tr>
<tr>
<td>Body:<textarea rows="10" cols="50" readonly="readonly" style="resize:none;"><?php echo $show->fields["body"]; ?></textarea></td></tr>
<tr>
<td>Attachment:<?php $result =  $show->fields["filename"]; if ($result != '' ){echo $result;} else echo "No Attachment"; ?></td></tr>
</tr>
</table>
</div>
<!--  <form name="xForm2" id="xForm2" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; ">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();" >
	 <span>Export EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>
  </div>
</form>-->