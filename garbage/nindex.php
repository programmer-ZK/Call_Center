<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "index";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "index";
        $page_menu_title = "index";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
        include_once('lib/nusoap.php');
		

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
?>


<?php 	
	$rst = $tools_admin->get_caller_id($_SESSION[$db_prefix.'_UserId']); 
	
	$id 		= $rst->fields["id"];
	$unique_id 	= $rst->fields["unique_id"];
	$caller_id 	= $rst->fields["caller_id"];
	$status 	= $rst->fields["status"];
?>
<?php include($site_root."includes/header.php"); ?>
<?php 
		//echo $caller_id;
		//$caller_id = '02348876609';
		if(!empty($caller_id)){
			$method = 'GetContactDetail';
			$params = array('AccessKey' => $access_key,'CallerId' => $caller_id, 'Channel' => $channel);
			$rs1 = $soap_client->call_soap_method($method,$params); 
			//echo count($rs1); exit;
			//echo sizeof($rs1); exit;
			if(empty($rs1[0]["CustomerId"])){ include_once('customer_new.php');}
		}
		//print_r($rs1);
		//echo $tools_admin->is_multi($rs1); exit;
		//$rs1 = $tools_admin->is_multi2($rs1); 
		//print_r($rs1);
		//exit;

?>
      	<div class="box">
      		<h4 class="white"><?php echo($page_title); ?> <a href="#" class="heading-link"><?php echo empty($caller_id)?"No Calls":"User List" ?></a></h4>
        <div class="box-container">	<?php	if(!empty($caller_id)){     		?>
      		<table class="table-short">
      			<thead>
      				<tr>	
						<!--<th>&nbsp;</th>	-->
						<th >Customer ID</th>
						<th >Account No</th>
						<th >Residence</th>
						<th >Office</th>
						<th >Mobile</th>
					<th >Action</th>
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
        	        //echo count($rs1) ; exit;
					//echo $rs1[0]["NAME"]; echo "sadsdsdsd"; exit; 
                	while($count != count($rs1)){ ?>

      				<tr class="odd">
      					<!--<td class="col-chk"><input type="checkbox" /></td>-->
      					<td class="col-first"><?php  echo $rs1[$count]["CustomerId"]; ?></td>
      					<td class="col-first"><?php echo $rs1[$count]["AccountNo"]; ?></td>
						<td class="col-first"><?php echo $rs1[$count]["Residence"]; ?> </td>
	                    <td class="col-first"><?php echo $rs1[$count]["Office"]; ?> </td>
						<td class="col-first"><?php echo $rs1[$count]["Mobile"]; ?> </td>
      					<td class="row-nav"><a href="customer_detail.php?customer_id=<?php echo $tools_admin->encryptId($rs1[$count]["CustomerId"]); ?>&account_no=<?php echo $tools_admin->encryptId($rs1[$count]["AccountNo"]); ?>" class="table-edit-link">View</a> </td>
      				</tr>
			 <?php
                        $count++;
                }
                ?>
			<tr> 
				 <td colspan="12" class="paging"><?php echo($paging_block);?></td>
         	        </tr>

      			</tbody>
      		</table>  	<?php }?>
      	</div><!-- end of div.box-container -->
      	</div> <!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?>      
