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
		#CustomerId AccountNo BranchName BankName BankAccountNo BankAccountTitle BranchCode 
		$customer_id	= $tools_admin->decryptId($_REQUEST['customer_id']);
		$account_no		= $tools_admin->decryptId($_REQUEST['account_no']);
		
		$method = 'GetPinLogs';
		$params = array('AccessKey' => $access_key,'AccountNo' => $account_no,'CustomerId' => $customer_id,'Channel' => $channel);
		$rs2 = $soap_client->call_soap_method($method,$params);
		//print_r($rs2); exit;
?>

 <div class="box">
	<h4 class="white" style="margin-top: 70px;"><?php echo("Pin History"); ?></h4>
	<div class="box-container">
		<table class="table-short">
			<thead>
				<tr>
					<th >Action</th>
					<th >CallerId</th>
					<th >Date Time</th>
					<th >CalllogId</th>
					<th >Agent Name</th>
				</tr>
			</thead>
			<tfoot>
			</tfoot>
			<tbody>
				<?php
				$count = 0;
				while($count != count($rs2)){ 
				?>
				<tr class="odd">
						<td class="col-first"><?php  echo $rs2[$count]["Status"]; ?></td>
						<td class="col-first"><?php  echo $rs2[$count]["CallerId"]; ?> </td>
					<!-- change as on 21022013 OnDate1 to OnDate!-->	<td class="col-first"><?php  echo $rs2[$count]["OnDate"]; ?> </td>
						<?php 
						$rscdr = $user_tools->get_cdr_details($rs2[$count]["CallLogId"]);		
						$userfield = $rscdr->fields["userfield"];
						$staff_name  = $tools_admin->returnFieldVal('full_name', 'admin', 'admin_id='.$rscdr->fields["staff_id"]);									
						?>						
						<td class="col-first"><a title="click here to download" target="_blank" href="recording/<?php echo $userfield; ?>.wav" ><?php  echo $rs2[$count]["CallLogId"]; ?> </a> </td>
						<td class="col-first"><?php  echo $staff_name; ?> </td>
				</tr>
				<?php	$count++; 
				 }
				?>
				
		   </tbody>
		</table>
	</div>
</div>

