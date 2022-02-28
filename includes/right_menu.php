	<?php if ($page_level != "1") { ?>


		<div id="right-col">
			<?php include_once('includes/ivr_selection.php'); ?>
			<?php $rs_agent_name = $admin->get_agent_name($_SESSION[$db_prefix . '_UserId']); ?>

			<?php if ($rs_agent_name->fields["department"] != "QA" && $rs_agent_name->fields["department"] != "Management") { ?>

				<?php include_once('includes/user_info_summary.php'); ?>
				<?php if ($ADMIN_ID2 != $_SESSION[$db_prefix . '_UserId']) { ?>
					<?php include_once('includes/agent_menu.php'); ?>
				<?php } ?>
				<?php include_once('includes/user_menu.php'); ?>

				<?php include_once("includes/user_calls_list.php");	?>

			<?php } ?>

		</div>



	<?php } else {
	} ?>