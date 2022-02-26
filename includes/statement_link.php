


<?php  	
        include_once('lib/nusoap.php');

       include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
		
		
		include_once("classes/user_tools.php");		
		$user_tools = new user_tools(); 
?>

<?php
		
		$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
		$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
		
		if (isset($_REQUEST['show'])) {
		
		$fdate		 = 	$_REQUEST['fdate'];
		$tdate		 = 	$_REQUEST['tdate'];
		$select		 = 	$_REQUEST['select'];
		//$customer_id = $_REQUEST['customer_id'];
		if ($select == 'Transaction'){ $type= 2;}
		if ($select == 'Portfolio'){ $type= 3; }
		if ($select == 'Account'){ $type= 4; }
	//echo $customer_id;exit;
//echo 'waleed';exit;
//echo $fdate.$tdate.$select;
		$method = 'GetAccountStatement';
		$params = array('AccessKey' => 'AM',
		'fromDate' => $fdate,
		'toDate' => $tdate,
		'RegNo' => $customer_id,
		'fromPlanCode' => '000',
		'toPlanCode' => '999',
		'fromFundCode' => '000',
		'toFundCode' => '999',
		'fromUnitType' => '000',
		'toUnitType' => '999',
		'isProvision' => 'Y',
		'reportType' => $type
		 );//print_r ($params);exit;
		$rs2 = $soap_client->call_soap_method_2($method,$params);	
//print_r($rs2);exit;
		//$rs2 = "http://www.google.com";
?>
	<script type="text/javascript">
	window.open ('<? echo $rs2;?>','_blank',false);
  /*window.location = 'http://www.google.com';*/  
  </script>
	
	<? }	?>



<form name="xForm" id="xForm" action="customer_detail.php?customer_id=<?=$customer_id; ?>&account_no=<?=$account_no	; ?>&tab=statement_link" method="post" class="middle-forms cmxform" >
 <div class="box">
                <h4 class="white" style="margin-top: 70px;">
    From Date :
	 <label>
		<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo $fdate; ?>" autocomplete = "off" readonly="readonly" onClick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown')">
	</label>
	
	 To Date :
	 <label>
		<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo $tdate; ?>" autocomplete = "off" readonly="readonly" onClick="javascript:NewCssCal ('tdate','yyyyMMdd', 'dropdown')">
	</label><br/><br/>
Type : <select id="select" name="select">
  <option value="Transaction">Transaction</option>
  <option value="Portfolio">Portfolio</option>
  <option value="Account">Account</option>
</select>
	 <a class="button" href="javascript:document.xForm.submit();" >
		 <span>Search</span>
		 </a>
		<input type="hidden" value="Search" id="show" name="show" />
	
		
	</h4></div>
		</form>
