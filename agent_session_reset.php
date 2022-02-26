<?php include_once("includes/config.php"); ?>
<?php
	$page_name = "agent_session_reset.php";
	$page_title = "Agent Session Reset";
	$page_level = "2";
	$page_group_id = "1";
	$page_menu_title = "Agent Session Reset";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>


<?php 	
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/admin.php");
	$admin = new admin();
	$admin_list = $admin->get_agents_list_all();
	
	include_once("classes/task_list.php");
	$task_list = new task_list();
?>
<?php include($site_root."includes/header.php"); ?>
<script type="text/javascript">
/*function list_validate(){
/*	alert('Hi');
	return false;
*-/
	//var id 		= this.document.getElementById('id');
	var title 			= this.document.getElementById('title');
	var description 	= this.document.getElementById('description');
	var deadline 		= this.document.getElementById('deadline');

	var flag 			= true;
	var err_msg 		= '';
	
	if(title.value == ''){
		err_msg+= 'Missing Title\n';
		this.document.getElementById('title_error').style.display="";
	}
	if(description.value == ''){
		err_msg+= 'Missing Description\n';
		this.document.getElementById('description_error').style.display="";
	}

	
	if(deadline.value == ''){
		err_msg+= 'Missing Deadline\n';
		this.document.getElementById('deadline_error').style.display="";
	}
	

	if(err_msg == '' && IsEmpty(err_msg)){
		return true;
	}
	else{
		//alert(err_msg);
		return false;
	}
}*/
</script>
<script type="text/javascript">
/*$.validator.setDefaults({
	submitHandler: function() { alert("submitted!");  /*$("#xForm").submit(); *-/ }
});

$().ready(function() {
	// validate the comment form when it is submitted
	$("#commentForm").validate();
	
	// validate signup form on keyup and submit
	$("#xForm").validate({
		rules: {
			title			: "required",
			description		: "required",
			deadline		: "required",
 
		},
		messages: {
			title			: "Please Enter Title",
			description		: "Please Enter Description",
			deadline		: "Please Enter Deadline",
   
		}
	});
});*/
</script>
<?php
	

if(isset($_REQUEST['email']) && isset($_REQUEST['agent_id']))
{
	$admin->usr_logout($_REQUEST['email'], $_REQUEST['agent_id']);
	$_SESSION[$db_prefix.'_GM'] = "Session for agent (".$_REQUEST['agent_name'].") was sucessfully reset.";
	header ("Location: agent_session_reset.php");
	exit();
}

?>

      	<div class="box">      
      		<h4 class="white">Agent Session Reset</h4>
        <div class="box-container">
      		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
                <table class="table-short">
                  	<thead>
						<tr>
							<td style="width:50px" class="col-head" ><h3>Agent Name</h3>&nbsp;</td>
							<td style=" padding-left:15px;" class="col-head" ><h3>Action</h3>&nbsp;</td>
						</tr>
                   	</thead>
					<tbody>
					<?php $i=0; while(!$admin_list->EOF){ ?>
					  <tr style="background-color:#f3f3f3; border-bottom:1px solid #B1B1B1;">
						<td style="width:50px" class="col-head" ><?php echo strtoupper($admin_list->fields['full_name']); ?></td>
						<td class="col-head" >
							
							<a class="button" href="agent_session_reset.php?email=<?php echo $admin_list->fields['email']; ?>&agent_id=<?php echo $admin_list->fields['admin_id']; ?>&agent_name=<?php echo $admin_list->fields['full_name']; ?>" class="table-edit-link"><span>Reset</span></a>
							</td>
					  </tr>
					 <?php $i++; $admin_list->MoveNext();} ?>
			  </tbody>
			</table>	
      		</form>
        </div><!-- end of div.box-container -->
      	</div><!-- end of div.box -->
<?php include($site_root."includes/footer.php"); ?> 
