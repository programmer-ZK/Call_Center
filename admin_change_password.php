<?php include_once("includes/config.php"); ?>
<?php
$page_name = "admin_change_password.php";
$page_title = "Change Password";
$page_level = "0";
$page_group_id = "0";
$page_menu_title = "Change Password";
?>
<?php include_once($site_root . "includes/check.auth.php"); ?>

<?php
include_once("classes/tools_admin.php");
$tools_admin = new tools_admin();

include_once("classes/admin.php");
$admin = new admin();
?>
<?php include($site_root . "includes/header.php"); ?>
<script type="text/javascript">
	function change_pass_validate() {
		var selectOption = document.getElementById("Select_Agent");
		var Agent_id = selectOption.options[selectOption.selectedIndex].value;
		var nPassword = this.document.getElementById('nPassword');
		var cnPassword = this.document.getElementById('cnPassword');
		var flag = true;
		var err_msg = '';

		if (Select_Agent == '') {
			err_msg += 'Select an Agent\n';
			this.document.getElementById('cPassword_error').style.display = "inline";
		}
		if (nPassword.value == '') {
			err_msg += 'Enter New Passowrd\n';
			this.document.getElementById('nPassword_error').style.display = "inline";
		}
		if (cnPassword.value == '') {
			err_msg += 'Confirm Passowrd\n';
			this.document.getElementById('cnPassword_error').style.display = "inline";
		}
		if (err_msg == '') {
			return true;
		} else {
			return false;
		}
	}
</script>

<?php
$nPassword		=  $_REQUEST['nPassword'];
$cnPassword		=  $_REQUEST['cnPassword'];

$nPassword_error = "display:none;";
$cnPassword_error = "display:none;";

if (isset($_REQUEST["cpwd"]) && !empty($_REQUEST["cpwd"])) {

	$nPassword = $_REQUEST["nPassword"];
	$cnPassword = $_REQUEST["cnPassword"];
	$Select_Agent = $_REQUEST["Select_Agent"];

	$flag = true;
	if ($nPassword == '') {
		$nPassword_error = "display:inline;"; //$tools->isEmpty('Caller ID');
		$flag = false;
	}
	if ($cnPassword == '') {
		$nPassword_error = "display:inline;"; //$tools->isEmpty('Caller ID');
		$flag = false;
	}
	if ($flag == true) {
		if ($nPassword == $cnPassword) {
			$admin->admin_change_password($Select_Agent, $nPassword);
			$_SESSION[$db_prefix . '_GM'] = "password changed successfully.";
			header("Location: admin_change_password.php");
			exit();
		} else {
			$_SESSION[$db_prefix . '_RM'] = "Confirmation Password not Matched.";
			header("Location: admin_change_password.php");
			exit();
		}
	}
}

?>
<div class="box">
	<h4 class="white">Admin Settings</h4>
	<div class="box-container">

		<form action="" method="post" class="middle-forms" name="xForm">

			<h3>Change Password</h3>
			<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
			<fieldset>
				<legend>Fieldset Title</legend>
				<ol>
					<li class="even"><label class="field-title">Select Agent <em>*</em>:</label>
						<label>
							<?php echo $tools_admin->getcombo_new("admin", "Select_Agent", "admin_id", "full_name", $search_keyword, false, "form-select", "", "Agent", " designation = 'Agents' "); ?>
						</label>
						<span class="clearFix">&nbsp;</span>
					</li>

					<li><label class="field-title">New Password <em>*</em>:</label>
						<label>
							<input type="password" name="nPassword" id="nPassword" class="txtbox-short" value="<?php echo $nPassword; ?>">
							<span class="form-error-inline" id="nPassword_error" style="<?php echo $nPassword_error; ?>" title="Please Insert New Password."></span></label><span class="clearFix">&nbsp;</span>
					</li>

					<li class="even"><label class="field-title">Confirm Password <em>*</em>:</label> <label>
							<input type="password" name="cnPassword" id="cnPassword" class="txtbox-short" value="<?php echo $cnPassword; ?>">
							<span class="form-error-inline" id="cnPassword_error" style="<?php echo $cnPassword_error; ?>" title="Please Insert New Password."></span></label><span class="clearFix">&nbsp;</span>
					</li>

				</ol>
			</fieldset>
			<p class="align-right">
				<?php  // if(isset($group_id) && !empty($group_id)){
				?>
				<a class="button" href="javascript:document.xForm.submit();" onclick="change_pass_validate('xForm');"><span>Change Password</span></a>
				<input type="hidden" value="CHANGE PASSWORD" id="cpwd" name="cpwd" />
				<?php   // }
				//else{
				?>
				<!--     <a class="button" href="javascript:document.xForm.submit();"><span>Add</span></a>
                                               <input type="hidden" value="CREATE NEW ADMIN GROUP >>" id="add" name="add" /> -->
				<?php //    }
				?>
				<!--<input type="image" src="images/bt-send-form.gif" />-->
			</p>
			<span class="clearFix">&nbsp;</span>
		</form>
	</div>
</div>

<?php include($site_root . "includes/footer.php"); ?>