<?php include_once("includes/config.php");  ?>
<?php   //fdsfdsfs   
$page_name = "workcodes_list.php";
$page_title = "Workcodes List";
$page_level = "2";
$page_group_id = "1";
$page_menu_title = "Workcodes List";
?>
<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();

include_once("classes/work_codes_new.php");
$work_codes = new work_codes();

?>
<?php include($site_root . "includes/header.php"); ?>
<script type="text/javascript">
	function container_visible(id) {
		$("#navcontainer" + id).slideToggle("slow");



	}

	function togglecheckboxes(cn) {

		var cbarray = document.getElementsByName(cn);
		for (var i = 0; i < cbarray.length; i++) {
			//alert (cbarray[i]);
			cbarray[i].checked = false
		}
	}

	function checkedAll(ch4) {

		var w = document.getElementsByTagName('ch4');
		//alert(w[0]);
		for (var i = 0; i < w.length; i++) {
			alert(w[i]);
			w[i].checked = false;
		}
	}

	function updateTextArea() {
		var allVals = [];
		$('#show :checked').each(function() {
			allVals.push($(this).val());
		});
		$('#t').val(allVals)
	}

	$(function() {
		$('#show input').click(updateTextArea);
		updateTextArea();
	});
</script>
<?php

$cb = $_POST['cb'];

if (isset($_REQUEST['submitwc'])) {
	if (empty($cb)) {
		echo "You didn't select any workcodes.";
	} else {
		$selected_radio = $_POST['radio'];
		$unique_id = $_REQUEST["unique_id"];
		$caller_id = $_REQUEST["caller_id"];
		$agent_id = $_SESSION[$db_prefix . '_UserId'];
		$value_desc = $_REQUEST["value_desc"];
		$N = count($cb);
		$flag = true;
		$outgoing_wc = "No Answer,Busy,Not Connected,Powered Off,Connected,Not Answering";
		$outgoing_wc2 = "Connected";
		for ($i = 0; $i < $N; $i++) {
			$workcodes = $cb[$i];
			echo $workcodes;
			$work_codes->insert_work_codes($unique_id, $caller_id, $workcodes, $agent_id, $value_desc, $selected_radio);
			$que_str =  "unique_id=" . $unique_id . "&caller_id=" . $caller_id;
			/*By Farhan Start*/
			if (preg_match("/" . $workcodes . "/", $outgoing_wc)) {
				$sql_que = "update " . $db_prefix . "_queue_stats set call_status='" . strtoupper($workcodes) . "' where caller_id='" . $caller_id . "' ";
				$sql_que .= "and unique_id='" . $unique_id . "'";
				$tools_admin->exec_query($sql_que);
				//$sql_que = "update ".$db_prefix."_campaign_detail set status='1' where caller_id='".$caller_id."' ";
				//    $sql_que .= "and unique_id='".$unique_id."'";
				// $tools_admin->exec_query($sql_que);
				if (!preg_match("/" . $workcodes . "/", $outgoing_wc2)) {
					$sql_que = "update " . $db_prefix . "_campaign_detail set status='1' where caller_id='" . $caller_id . "' ";
					$sql_que .= "and unique_id='" . $unique_id . "'";
					$tools_admin->exec_query($sql_que);
				}
				$flag = false;
			}
		}
		$tools_admin->exec_query("update cc_admin set is_busy='0' where admin_id='" . $_SESSION[$db_prefix . '_UserId'] . "'and status='1'");
		$_SESSION[$db_prefix . '_GM'] = "Call Ended Successfully.";


		include_once("classes/user_pin.php");
		$user_pin = new user_pin();
		$user_pin->update_user_status($unique_id, $caller_id, '-1', 0, $_SESSION[$db_prefix . '_UserId']);
	}
}
?>
<div class="mid-col-center" id="mid-col-center">
	<div id="mid-col" class="mid-col">

		<div class="box">

			<h4 class="white"><?php echo "Set Work Codes"; ?></h4>
			<div class="box-container">
				<form action="<? echo $_SERVER['PHP_SELF'] ?>" method="post" class="middle-forms cmxform" name="xForm" id="xForm">
					<input type="hidden" id="caller_id" name="caller_id" value="<?php echo $_REQUEST["caller_id"]; ?>" />
					<input type="hidden" id="unique_id" name="unique_id" value="<?php echo $_REQUEST["unique_id"]; ?>" />
					<div style="padding:10px; overflow-y: auto; height:450px; ">

						<script>
							$('input:radio').change(
								function(e) {
									if ($(this).is(':checked')) {
										$(show).show();
									}
								});
						</script>



						<div id="show" style="display:block">
							<?php
							$html = ''; //$is_child=0; $func_count=0;
							//echo "fsdfsdfsdf";
							echo $work_codes->xrecursive_make_tree_new(0, 'root');
							?> </div>

					</div>
					<div style="padding:10px;">
						<a class="button" href="javascript:document.xForm.submit();" onclick="javascript:return admin_validate('xForm');"><span>Submit</span></a>
						<input type="hidden" value="submitwc" id="submitwc" name="submitwc" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<?php include($site_root . "includes/footer.php"); ?>