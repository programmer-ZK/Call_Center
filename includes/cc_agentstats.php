<?php

    include_once("classes/user_tools.php");
    $user_tools = new user_tools();	
	
	$rs = $user_tools->agent_stats(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order);
	//print_r($rs); exit;
?>

<form name="listings" id="listings" action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="" class="middle-forms cmxform">
<div class="box">
	<h4 class="white"><?php echo($page_title); ?></h4>
	<div class="box-container">     		
		<table class="table-short">
			<thead>
				<tr>
					<td class="col-head2">Agent ID</td>
					<td class="col-head2">Name</td>
					<td class="col-head2">Email</td>
					<td class="col-head2">Agent Exten</td>
					<td class="col-head2">CRM Login</td>
					<td class="col-head2">Phone Login</td>
					<td class="col-head2">Busy</td>
					<td class="col-head2">Status</td>
				</tr>
			</thead>
			<tbody>
			 <?php while(!$rs->EOF){ ?>
				<tr class="odd">
					<td class="col-first"><?php echo $rs->fields["admin_id"]; ?></td>
					<td class="col-first"><?php echo $rs->fields["full_name"]; ?> </td>
					<td class="col-first"><?php echo $rs->fields["email"]; ?> </td>
					<td class="col-first"><?php echo $rs->fields["agent_exten"]; ?> </td>
					<td class="col-first"><?php echo(empty($rs->fields["is_crm_login"])?"No":"Yes"); ?> </td>
					<td class="col-first"><?php echo(empty($rs->fields["is_phone_login"])?"No":"Yes"); ?> </td>
					<td class="col-first"><?php echo(empty($rs->fields["is_busy"])?"No":"Yes"); ?> </td>
					<!--<td class="col-first"><?php //echo(empty($rs->fields["status"])?"N/A":"Avaliable"); ?> </td>-->
					<td class="col-first"><?php echo $rs->fields["status"]; ?> </td>
			 <?php $rs->MoveNext(); } ?>
				</tr>
			</tbody>
		</table>  	
	</div>
</div> 
</form>
