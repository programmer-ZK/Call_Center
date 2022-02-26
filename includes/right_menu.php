	<?php if ($page_level != "1") { ?>


		<div id="right-col">
			<?php include_once('includes/ivr_selection.php'); ?>
			<?php $rs_agent_name = $admin->get_agent_name($_SESSION[$db_prefix . '_UserId']); ?>
			<!--
				<div class="box-container">
					<div id="date-container">
						<img src="images/sunny.png" alt="Sunny" /> 
						<span class="hour"><?php // echo date("H:i:s");
																?></span>
						<span class="date"><?php //echo date("D,");
																?> <?php //echo date("F j, Y");
																		?></span>
						<span class="clearFix">&nbsp;</span>
					</div>
					<div id="calendar-container">
						<h5>Calendar</h5>
						<div id="calendar"></div>
						<div class="inner-nav">
							<div class="align-left"><a href="#"><span>+ add event</span></a></div>
							<div class="align-right"><a href="#"><span>? list events</span></a></div>
							<span class="clearFix">&nbsp;</span> </div>
						</div>
					</div>
				</div>
			-->
			<?php if ($rs_agent_name->fields["department"] != "QA") { ?>

				<?php include_once('includes/user_info_summary.php'); ?>
				<?php if ($ADMIN_ID2 != $_SESSION[$db_prefix . '_UserId']) { ?>
					<?php include_once('includes/agent_menu.php'); ?>
				<?php } ?>
				<?php include_once('includes/user_menu.php'); ?>

				<?php include_once("includes/user_calls_list.php");	?>
				<?php /*?>JD<?php include_once("includes/work_code_menu.php");	?>	<?php */ ?>

			<?php } ?>

		</div>



	<?php } else {
	} ?>