<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "test_scores_list.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Test Scores List";
        $page_menu_title = "Test Scores List";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>

<?php
	include_once("classes/reports.php");
	$reports = new reports();
		
	include_once("classes/tools_admin.php");
    $tools_admin = new tools_admin();
	
	include_once("classes/cc_evaluation.php");
	$cc_evaluation = new cc_evaluation();
	/*require("../fpdf17/fpdf.php");
	require("/classes/pdfgen.php");*/
?>	

<?php include($site_root."includes/header.php"); ?><head>
<script type="text/javascript">

function confirmation(type){

	if(type == 'delete'){
		var status = confirm("Are you sure you want to delete?");
		
		if (status == true) {
		
			return true;
		}
		else{
			
			return false;
		}
	}
	
}

function getHtml4Excel()
{
//var x;
//x=document.getElementsByTagName("html")[0].innerHTML;
//x=document.documentElement.innerHTML;
document.getElementById("gethtml1").value = document.getElementById("tb_test_scores").innerHTML;
//alert(document.getElementById("tb_test_scores").innerHTML);
}
function getHtml4Pdf()
{
//var x;
//x=document.getElementsByTagName("html")[0].innerHTML;
//x=document.documentElement.innerHTML;
document.getElementById("gethtml2").value = document.getElementById("tb_test_scores").innerHTML;
//alert(document.documentElement.innerHTML);
}
function showComment(comment)
{
	if(comment || 0 !== comment.length)
	{
		alert("Comment: "+comment);
	}
	else
	{
		alert("No comments available!");
	}
}
</script>
</head>

<?php
	
//	/************************* Export to Excel ******************/
//if(isset($_REQUEST['export']))
//{
//	
//	//$search_keyword		= $_REQUEST['search_keyword'];
//	//$fdate 				= $_REQUEST['fdate'];
//	//$tdate		 		= $_REQUEST['tdate'];
//	$stringData	= $_REQUEST['gethtml1'];
//	$stringData = preg_replace('/Â/','',$stringData);
//	$stringData = preg_replace('/<form(.*)<\/form>/isU', '', $stringData);
//	$stringData = preg_replace('/<a(.*)<\/a>/', '', $stringData);
//	$stringData = preg_replace('/<a(.*)<\/a>/', '', $stringData);
//	//$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);
//	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
//	$stringData = preg_replace('/EXPORT PDF/', '', $stringData); 
//	//echo $stringData."asdasd";exit;
//	/*$stringData = str_replace('<tag1>',null,$stringData);
//	$stringData = str_replace('</tag1>',null,$stringData);
//	$stringData = str_replace('<tag2>',null,$stringData);
//	$stringData = str_replace('</tag2>',null,$stringData);*/
//
//	$db_export_fix = $site_root."download/test_scores_list.xls";
//	//echo $stringData;echo $db_export_fix; exit;
//	shell_exec("echo '".$stringData."' > ".$db_export_fix);
//		
//	ob_end_clean();
//    header("Pragma: public");
//    header("Expires: 0");
//    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//    header("Cache-Control: private",false);
//    //header("Content-type: application/force-download");
//    //header("Content-Type: text/csv");
//	header("Content-Type: application/ms-excel");
//    
//	//echo $db_export; exit;
//    header("Content-Disposition: attachment; filename=".basename($db_export_fix).";" );
//    header("Content-Transfer-Encoding: binary");
//    header("Content-Length: ".filesize($db_export_fix));
//    readfile($db_export_fix);
//    if(file_exists($db_export_fix) && !empty($file_name)){
//    unlink($db_export_fix);
//    }
//    exit();
//}
///************************* Export to Pdf ******************/
//if(isset($_REQUEST['export_pdf']))
//{
//	
//		$data	= $_REQUEST['gethtml2'];
//		$data = trim($data);
//		$data = preg_replace('/Â/','',$data);
//		$data = preg_replace('/<form(.*)<\/form>/isU', '', $data);
//		$stringData = preg_replace('/<a(.*)<\/a>/', '', $stringData);
//		$stringData = preg_replace('/<a(.*)<\/a>/', '', $stringData);
//		//$data = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $data);
//		$data = preg_replace('/EXPORT PDF/', '', $data);
//		$data = preg_replace('/EXPORT EXCEL/', '', $data);
//		ob_end_clean();
////function mPDF($mode='',$format='A4',$default_font_size=0,$default_font='',$mgl=15,$mgr=15,$mgt=16,$mgb=16,$mgh=9,$mgf=9, $orientation='P')
//		$mpdf=new mPDF('','A4','','','','','','','','','L'); 
//
//		//$mpdf->SetDisplayMode('fullpage');
//		
//		$mpdf->WriteHTML($data);
//		$mpdf->Output('Agent_Performance_Weekly_Report.pdf.pdf','D');
////		return "File exported succesfully";
//		exit();
//	
//	//$search_keyword		= $_REQUEST['search_keyword'];
//	//$fdate 				= $_REQUEST['fdate'];
//	//$tdate		 		= $_REQUEST['tdate'];
//	$stringData	= $_REQUEST['gethtml2'];
//	$stringData = preg_replace('/Â/','',$stringData);
//	$stringData = preg_replace('/<form(.*)<\/form>/isU', '', $stringData);
//	$stringData = preg_replace('/<a(.*)<\/a>/', '', $stringData);
//	$stringData = preg_replace('/<a(.*)<\/a>/', '', $stringData);
//	//$stringData = preg_replace('/<span id="paging_block"(.*)<\/span>/isU', '', $stringData);
//	$stringData = preg_replace('/EXPORT EXCEL/', '', $stringData);
//	$stringData = preg_replace('/EXPORT PDF/', '', $stringData); 
//	$stringData = preg_replace('/EXPORT DOC/', '', $stringData); 
//	//echo $stringData."asdasd";exit;
//	/*$stringData = str_replace('<tag1>',null,$stringData);
//	$stringData = str_replace('</tag1>',null,$stringData);
//	$stringData = str_replace('<tag2>',null,$stringData);
//	$stringData = str_replace('</tag2>',null,$stringData);*/
//
//	$db_export_fix = $site_root."download/test_scores_list.doc";
//	//echo $stringData; exit;
//	shell_exec("echo '".$stringData."' > ".$db_export_fix);
//	
//	ob_end_clean();
//    header("Pragma: public");
//    header("Expires: 0");
//    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
//    header("Cache-Control: private",false);
//    //header("Content-type: application/force-download");
//    header("Content-Type: application/ms-word");
//    
//	//echo $db_export; exit;
//    header("Content-Disposition: attachment; filename=".basename($db_export_fix).";" );
//    header("Content-Transfer-Encoding: binary");
//    header("Content-Length: ".filesize($db_export_fix));
//
//    readfile($db_export_fix);
//    if(file_exists($db_export_fix) && !empty($file_name)){
//    unlink($db_export_fix);
//    }
//    exit();
//}
	
	if ($_REQUEST['operation'] == "delete")
	{
		$admin_id = $tools_admin->decryptId($_REQUEST['admin_id']);
		$agent_id = $_REQUEST['combo_agent_id'];
		$test_code = $_REQUEST['t_code'];
		$test_name = $_REQUEST['t_name'];
		$test_date = $_REQUEST['t_date'];
		$test_score = $_REQUEST['t_score'];
		$test_comment = $_REQUEST['t_comment'];
		$id = $_REQUEST['id'];
		$del_bit = 1;
		$cc_evaluation->update_evaluation_test_scores($id, $agent_id, strtoupper($test_code), $test_name, $test_date, $test_score, $admin_id, $del_bit, $test_comment);
		//exit;
		$_SESSION[$db_prefix.'_GM'] = "Test score successfully deleted.";
		header('Location:test_scores_list.php');
	}

	$startRec = 0;
	$totalRec = 0;
	$test_name = "";
	$fdate = "";
	$tdate = "";
	$agent_id = "";
	//----- Test scores listing
	$rs = $cc_evaluation->get_evaluation_test_scores($test_name, $startRec, $totalRec, "test_date", "asc", $fdate, $tdate, $agent_id);
	//echo $rs->fields["test_name"];exit;
?>

		
<div style="font-family:Arial, Helvetica, sans-serif; color:#1D8895; font-size:22px; font-weight:bold; text-align:center; ">Test Scores List</div>
<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">

<div id="mid-col" class="mid-col">
	<div class="box">
        <h4 class="white"><?php echo($page_title); ?><a style="float:right;background-color:#5B6366;border:2px solid #FFFFFF;padding-right:10px;padding-top:2px;padding-bottom:2px;font-weight:bold;" class="heading-link" href="test_scores.php?operation=add"><span>Add New</span></a></h4>
        <div class="box-container" style="overflow:auto; height:600px;">  		
      		<div id="tb_test_scores" name="tb_test_scores">
			<table class="table-short">
      			<thead>
					<tr>
						<td class="col-head2">Agent Name</td>
						<td class="col-head2">Test Code</td>
						<td class="col-head2">Test Score(%)</td>
						<td class="col-head2">Test Date</td>
						<td class="col-head2">Comment</td>
	                	<!--<td colspan="12" class="paging"><?php // echo($paging_block);?></td>-->
        		    </tr>
      			</thead>
      			<tbody>
				<?php while(!$rs->EOF){ ?>
      				<tr class="odd">
						<td class="col-first"><?php echo strtoupper($rs->fields["full_name"]); ?> </td>
						<td class="col-first" title="<?php echo $rs->fields["test_name"]; ?>"><?php echo strtoupper($rs->fields["test_code"]); ?> </td>
						<td class="col-first"><?php echo $rs->fields["test_score"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["test_date"]; ?> </td>
						<td class="col-first"><a name="<?php echo $rs->fields['comment'];?>"  onClick="showComment(this.name)" href="#">View</a></td>
						<td><a class="table-edit-link" href="test_scores.php?operation=edit&combo_agent_id=<?php echo $rs->fields["agent_id"]; ?>&t_code=<?php echo $rs->fields["test_code"]; ?>&t_name=<?php echo $rs->fields["test_name"]; ?>&t_date=<?php echo $rs->fields["test_date"]; ?>&t_score=<?php echo $rs->fields["test_score"]; ?>&id=<?php echo $rs->fields["id"]; ?>&t_comment=<?php  echo $rs->fields["comment"]; ?>"></a></td>	
						<td><a onclick='javascript: return confirmation("delete")' class="table-delete-link" href="test_scores_list.php?operation=delete&combo_agent_id=<?php echo $rs->fields["agent_id"]; ?>&t_code=<?php echo $rs->fields["test_code"]; ?>&t_name=<?php echo $rs->fields["test_name"]; ?>&t_date=<?php echo $rs->fields["test_date"]; ?>&t_score=<?php echo $rs->fields["test_score"]; ?>&id=<?php echo $rs->fields["id"]; ?>&admin_id=<?php echo $tools_admin->encryptId($_SESSION[$db_prefix.'_UserId']); ?>&t_comment=<?php echo $rs->fields["comment"]; ?>"></a></td>							
						<!--<td class="col-first"><a href="" onclick="javascript:return popitup('calc_eval.php?unique_id=<?php //echo $rs->fields["uniqueid"];?>&agent_id=<?php// echo $_SESSION[$db_prefix.'_UserId']; ?>');" ><?php //echo $rs->fields["uniqueid"]; ?></a></td>-->
					</tr>
				<?php $rs->MoveNext();} ?>   
      			</tbody>
      		</table>  
			</div>	

      	</div>
			<p class="align-right">
				<a class="button" href="test_scores.php?operation=add"><span>Add New</span></a>	
			</p>
      </div> 
	</div>
</form>

<!--<form action="<?php //echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm1" id="xForm1" onSubmit="">

  <div style="float:left;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm1.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
  	  <input type="hidden" id="gethtml1" name="gethtml1"/>
  </div>
</form>

<form action="<?php //echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform" name="xForm2" id="xForm2" onSubmit="">

  <div style="float:left; margin-left:10px;">
	<a onClick="getHtml4Pdf()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT PDF</span>
	</a>
	  <input type="hidden" value="export_pdf" id="export_pdf" name="export_pdf" />
  	  <input type="hidden" id="gethtml2" name="gethtml2"/>
  </div>
</form>	-->
	
	
	
	

<?php include($site_root."includes/footer.php"); ?> 
