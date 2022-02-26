	<?php
	include_once("classes/admin.php");
	$admin = new admin();

	/*$total_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW())'); //($_SESSION[$db_prefix.'_UserId']);
		$rec_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) AND status = 0' );
		$inqueue_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) AND status = 2' );*/
	$unique_id		= $_SESSION['unique_id'];
	$rs_selection = $admin->get_iver_selection($unique_id);

	?>
	<!--JD inline 22 dec 2014-->
	<div style="display:none;" class="box">
		<h4 class="light-grey">Client IVR Selection</h4>
		<div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
			<ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
				<?php
				//    while(!$rs_selection->EOF){ 
				?>
				<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0"><span class="ui-icon ui-icon-triangle-1-s"></span><?php
																																																																																																																											//echo "hiii"; exit;
																																																																																																																											$selection = $rs_selection->fields["ivr_selection"];
																																																																																																																											if ($selection == "") {
																																																																																																																												$selection = "No Call";
																																																																																																																											} else if ($selection == "0") {
																																																																																																																												$selection = "Customer Care";
																																																																																																																												if ($status <> "-1") {
																																																																																																																											?><div id="timer" name="timer" style="color:#FF0000;float:right;"></div><?php }
																																																																																																																											} else if ($selection == "1") {
																																																																																																																												$selection = "Investment Solutions";
																																																																																																																												if ($status <> "-1") {
																																											?><div id="timer" name="timer" style="color:#FF0000;float:right;"></div><?php  }
																																																																																																																											} else if ($selection == "2") {
																																																																																																																												$selection = "Investment Account";
																																																																																																																												if ($status <> "-1") {
																																											?><div id="timer" name="timer" style="color:#FF0000;float:right;"></div><?php  }
																																																																																																																											} else if ($selection == "3") {
																																																																																																																												$selection = "Transaction Detail";
																																																																																																																												if ($status <> "-1") {
																																											?><div id="timer" name="timer" style="color:#FF0000;float:right;"></div><?php  }
																																																																																																																											}
																																																																																																																											echo $selection; ?></a> </li>
				<!--						  <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span><div id="timer" name="timer" style="color:#FF0000;float:right;"></li>-->
				<?php
				//      $rs_admin->MoveNext();
				//}
				?>


				<script>
					var milisec = 0
					var seconds = <?php echo $seconds; ?>
					var minutes = <?php echo $minutes; ?>

					function display() {
						if (milisec >= 9) {
							milisec = 0
							seconds += 1
						}
						if (seconds >= 59) {
							milisec = 0
							seconds = 0
							minutes += 1
						} else
							milisec += 1
						//document.counter.timer.value=minutes+":"+seconds+"."+milisec  
						document.getElementById('timer').innerHTML = minutes + ":" + seconds + "." + milisec
						setTimeout("display()", 100)
					}
					display()
				</script>
			</ul>
		</div>
	</div>