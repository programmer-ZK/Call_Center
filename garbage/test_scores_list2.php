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

<?php include($site_root."includes/header.php"); ?>	

<?php
	
	if ($_REQUEST['operation'] == "delete")
	{
		$admin_id = $tools_admin->decryptId($_REQUEST['admin_id']);
		$agent_id = $_REQUEST['combo_agent_id'];
		$test_name = $_REQUEST['t_name'];
		$test_date = $_REQUEST['t_date'];
		$test_score = $_REQUEST['t_score'];
		$id = $_REQUEST['id'];
		$del_bit = 1;
		$cc_evaluation->update_evaluation_test_scores($id, $agent_id, $test_name, $test_date, $test_score, $admin_id, $del_bit);
		//exit;
		$_SESSION[$db_prefix.'_GM'] = "Test score successfully deleted.";
		header('Location:test_scores_list.php');
	}

	$startRec = 0;
	$totalRec = 80;
	$rs = $cc_evaluation->get_evaluation_test_scores("", $startRec, $totalRec, "test_date","asc");
	//echo $rs->fields["test_name"];exit;
?>

	<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">

<div id="mid-col" class="mid-col">
	<div class="box">
        <h4 class="white"><?php echo($page_title); ?><a class="heading-link" href="test_scores.php?operation=add"><span>Add New</span></a></h4>
        <div class="box-container" style="overflow:auto; height:600px;">  		
      		<table class="table-short">
      			<thead>
					<tr>
						<td class="col-head2">Agent Name</td>
						<td class="col-head2">Test Name</td>
						<td class="col-head2">Test Score</td>
						<td class="col-head2">Test Date</td>
	                	<!--<td colspan="12" class="paging"><?php // echo($paging_block);?></td>-->
        		    </tr>
      			</thead>
      			<tbody>
				<?php while(!$rs->EOF){ ?>
      				<tr class="odd">
						<td class="col-first"><?php echo strtoupper($rs->fields["full_name"]); ?> </td>
						<td class="col-first"><?php echo $rs->fields["test_name"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["test_score"]; ?> </td>
						<td class="col-first"><?php echo $rs->fields["test_date"]; ?> </td>
						<td><a class="table-edit-link" href="test_scores.php?operation=edit&combo_agent_id=<?php echo $rs->fields["agent_id"]; ?>&t_name=<?php echo $rs->fields["test_name"]; ?>&t_date=<?php echo $rs->fields["test_date"]; ?>&t_score=<?php echo $rs->fields["test_score"]; ?>&id=<?php echo $rs->fields["id"]; ?>"></a></td>	
						<td><a class="table-delete-link" href="test_scores_list.php?operation=delete&combo_agent_id=<?php echo $rs->fields["agent_id"]; ?>&t_name=<?php echo $rs->fields["test_name"]; ?>&t_date=<?php echo $rs->fields["test_date"]; ?>&t_score=<?php echo $rs->fields["test_score"]; ?>&id=<?php echo $rs->fields["id"]; ?>&admin_id=<?php echo $tools_admin->encryptId($_SESSION[$db_prefix.'_UserId']); ?>"></a></td>							
						<!--<td class="col-first"><a href="" onclick="javascript:return popitup('calc_eval.php?unique_id=<?php //echo $rs->fields["uniqueid"];?>&agent_id=<?php// echo $_SESSION[$db_prefix.'_UserId']; ?>');" ><?php //echo $rs->fields["uniqueid"]; ?></a></td>-->
					</tr>
				<?php $rs->MoveNext();} ?>   
      			</tbody>
      		</table>  	

      	</div>
			<p class="align-right">
				<a class="button" href="test_scores.php?operation=add"><span>Add New</span></a>	
			</p>
      </div> 
	</div>
</form>
	
	
	
	
	

<?php include($site_root."includes/footer.php"); ?> 
