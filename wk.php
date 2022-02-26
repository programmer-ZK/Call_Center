<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "bulk_sending.php";
	$page_title = "Bulk Sending";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Bulk Sending";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>


<?php
		include_once('lib/nusoap.php');

	   	include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();

?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">

	
	function msg_validate(){
	
		
			var fdate    = this.document.getElementById('fdate');
		
			var tdate    = this.document.getElementById('tdate');
			
		//var email    = this.document.getElementById('email');
		
		//var sms    = this.document.getElementById('sms');
	
		var flag = true;
			var err_msg = '';
	
	if(fdate.value == ''){
					err_msg+= 'Enter From Date\n';
					this.document.getElementById('fdate_error').style.display="";
			}
	
		 if(tdate.value == ''){
					err_msg+= 'Enter To Date\n';
					this.document.getElementById('tdate_error').style.display="";
			}
	
	
			if(err_msg == '' && IsEmpty(err_msg)){
					return true;
			}
			else{
					return false;
			}
	}
	
	</script>
	
	
	<? 
	
$fdate		=	$_REQUEST['fdate'];
$tdate		=	$_REQUEST['tdate'];	
$email		=	$_REQUEST['search_keyword'];
$sms		=	$_REQUEST['search_keyword2'];
$fdate_error	 			= "display:none;";
$tdate_error	    		= "display:none;";
$email_error	    		= "display:none;";		
$sms_error	    			= "display:none;";	
	if(isset($_POST['send']) ){
	// echo 'khan';exit;
		$flag = true;
		 if($fdate == ''){
				$fdate_error = "display:inline;";
				$flag = false;
		 }
		if($tdate == ''){
				$tdate_error = "display:inline;";
				$flag = false;
		 }
		
	     if($flag == true){//echo $_REQUEST['choose'];exit;
		 
		if ( $_REQUEST['choose']=='email'){
		 echo $email;exit;}
		 		 
		if ( $_REQUEST['choose']=='sms'){
		 echo $sms;exit;}
	
	}
	}
	?>
<div class="box">
	<h4 class="white"> <?php echo $page_title; ?> </h4>
	<div class="box-container">
	
	 <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm" enctype="multipart/form-data">
	
	
	<h3>UBL Funds Bulk SMS & EMAIL</h3>
				<hr/>
	<fieldset>
	<legend>Fieldset Title</legend>
	<ol>						
	
	 <li class="even" ><label class="field-title">From Date:</label> <label><input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo $_POST['fdate']; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown')"><span class="form-error-inline" id="fdate_error" title="Please Insert Start Date"  style="<?php echo($fdate_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	 
	 
	  <li class="even" ><label class="field-title">To Date:</label> <label><input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo $_POST['tdate']; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('tdate','yyyyMMdd', 'dropdown')"><span class="form-error-inline" id="tdate_error" title="Please Insert End Date"  style="<?php echo($tdate_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>
	  
		   <li class="even"><label class="field-title">Email:</label><label> <input type="radio" name="choose" checked="checked" value="email"><?php echo $tools_admin->getcombo("email_template","search_keyword","id","title","1",false,"","","",""); ?><span class="form-error-inline" id="email_error" title="Please Select Email"  style="<?php echo($email_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>		
			
			<li class="even"><label class="field-title">SMS:</label><label> <input  type="radio" name="choose" value="sms"><?php echo $tools_admin->getcombo("sms_template","search_keyword2","id","title","1",false,"","","",""); ?><span class="form-error-inline" id="sms_error" title="Please Select SMS"  style="<?php echo($sms_error); ?>"></span></label><span class="clearFix">&nbsp;</span></li>									
	

	 </ol><!-- end of form elements -->
	 </fieldset>
	 <p class="align-right">
			
	
<a class="button" href="javascript:document.xForm.submit();"  onClick="javascript:return msg_validate('xForm');"><span>Start Broadcast</span></a>
				<input type="hidden" name="send" id="send" >
								
	
	  </p>
	  <span class="clearFix">&nbsp;</span>
	  </form>
	</div>
</div>

<?php include($site_admin_root."includes/footer.php"); ?>

