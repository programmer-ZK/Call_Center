<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "index";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "index";
        $page_menu_title = "index";
?>

<?php //include_once($site_root."includes/check.auth.php"); ?>
<?php
        include_once('lib/nusoap.php');

        include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

        include_once("classes/soap_client.php");
        $soap_client = new soap_client();
        $rs1 = $soap_client->get_contact_details('02348876609');
        //print_r($rs1); echo $rs1["NAME"]; exit;
?>
<?php include($site_root."includes/header.php"); ?>
      	<div class="box">
      		<h4 class="white"><?php echo($page_title); ?> <a href="#" class="heading-link">Users List</a></h4>
        <div class="box-container">     		
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
      		</table>  	
      	</div><!-- end of div.box-container -->
      	</div> <!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?>      
