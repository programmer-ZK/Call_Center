<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "profile_listing.php";
	$page_title = "Profile Listing";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Profile Listing";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
	
	include_once('lib/nusoap.php');
	
	include_once("classes/soap_client.php");
	$sOap_client = new soap_client();	
	
?>
<?php include($site_root."includes/header.php"); ?>

<?php
	$account_no 			= $_REQUEST['account_no'];
	$customer_id			= $_REQUEST['customer_id'];
	$name 					= $_REQUEST['name'];
	$email 					= $_REQUEST['email'];
	$zakat_status 			= $_REQUEST['zakat_status'];
	$cnic 	  				= $_REQUEST['cnic']; 
	$passport_no 	  		= $_REQUEST['passport_no']; 
	$ntn 					= $_REQUEST['ntn'];
	$caller_id 				= $_REQUEST['caller_id'];
	$father_name			= $_REQUEST['father_name'];

	$account_no_error 	= "display:none;";
	$customer_id_error 	= "display:none;";
	$email_error 		= "display:none;";
	$name_error 		= "display:none;";
	$zakat_status_error = "display:none;";
	$cnic_error 		= "display:none;";
	$passport_no_error 	= "display:none;";
	$ntn_error 			= "display:none;";

if(isset($_REQUEST['search'])){
			$method = 'GetProfileListing';
			$params = array('AccessKey' => $access_key,'Channel' => $channel,'AccountNo' => $account_no, 'CustomerId'=>$customer_id, 'Email'=>$email,'Name'=>$name,'ZakatStatus'=>$zakat_status,'Cnic'=>$cnic,'PassportNo'=>$passport_no,'Ntn'=>$ntn,'CallerId'=>$caller_id,'FatherName'=>$father_name);
			//print_r($params);
			$rs1 = $sOap_client->call_soap_method($method,$params);
			//print_r($rs1); exit;
		}
?>

 <div class="box">
                <h4 class="white" ><?php echo($page_title); ?> <a href="profile_search.php" class="heading-link">Search Again</a></h4>
        <div class="box-container">
      		<table class="table-short">
      			<thead>
      				<tr>	
						<!--<th>&nbsp;</th>	-->
						<th >CustomerId</th>
						<th >AccountNumber</th>
						<th >Name</th>
						<th >FHName</th>
						<th></th>
      				</tr>
      			</thead>
      			<tfoot><!--
      				<tr>
      					<td class="col-chk"><input type="checkbox" /></td>
      					<td colspan="4"><div class="align-right"><select class="form-select"><option value="option1">Bulk Options</option>
      					<option value="option2">Delete All</option></select>
      					<a href="#" class="button"><span>perform action</span></a></div></td>
      				</tr> -->
      			</tfoot>
      			<tbody>
			<?php
	                $count = 0;
                	while($count != count($rs1)){ ?>

      				<tr class="odd">
      					<td class="col-first"><?php  echo $rs1[$count]["CustomerId"]; ?></td>
      					<td class="col-first"><?php echo $rs1[$count]["AccountNumber"]; ?></td>
						<td class="col-first"><?php echo $rs1[$count]["Name"]; ?> </td>
	                    <td class="col-first"><?php echo $rs1[$count]["FHName"]; ?> </td>
						<td class="col-first"><?php echo $rs1[$count]["Mobile"]; ?> </td>
						<td class="row-nav"><a href="human_verification.php?customer_id=<?php echo $tools_admin->encryptId($rs1[$count]["CustomerId"]); ?>&account_no=<?php echo $tools_admin->encryptId($rs1[$count]["AccountNumber"]); ?>" class="table-edit-link">View</a> </td>
      				</tr>
			 <?php
                        $count++;
                }
                ?>
<!--			<tr> 
				 <td colspan="12" class="paging"><?php echo($paging_block);?></td>
         	        </tr>-->

      			</tbody>
      		</table>
        </div>
        </div> 
<?php include($site_root."includes/footer.php"); ?> 
