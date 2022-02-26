      		<table class="table-short">
      			<thead>
      				<tr>	
						<!--<th>&nbsp;</th>	-->
						<th >Cus ID</th>
						<th >Acc No</th>
						<th >Name</th>
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
                	while($count != count($rs4)){ ?>

      				<tr class="odd">
      					<!--<td class="col-chk"><input type="checkbox" /></td>-->
      					<td class="col-first"><?php echo $rs4[$count]["CustomerId"]; ?></td>
      					<td class="col-first"><?php echo $rs4[$count]["AccountNo"]; ?></td>
						<td class="col-first"><?php echo $rs4[$count]["Name"]; ?></td>
						<td class="col-first"><?php echo $rs4[$count]["Residence"]; ?> </td>
	                    <td class="col-first"><?php echo $rs4[$count]["Office"]; ?> </td>
						<td class="col-first"><?php echo $rs4[$count]["Mobile"]; ?> </td>
						
      					<td class="row-nav"><a href="human_verification.php?customer_id=<?php echo $tools_admin->encryptId($rs4[$count]["CustomerId"]); ?>&account_no=<?php echo $tools_admin->encryptId($rs4[$count]["AccountNo"]); ?>" class="table-edit-link">View</a> </td>
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
