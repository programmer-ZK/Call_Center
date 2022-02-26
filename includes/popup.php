<script type="text/javascript" src="js/popup-window.js"></script>
<!--<input type="button" value="Bottom-Right" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'screen-bottom-right', -20, -20);" />-->

	<div class="menu_form_header" id="popup_drag">
		<img class="menu_form_exit" id="popup_exit" src="images/form_exit.png" alt="" />&nbsp;&nbsp;&nbsp;Pin Status
	</div>
	<div class="menu_form_body">
		<form action="sample.php">
		<table>
		  <tr><th>Caller ID:</th><td><?php echo $caller_id; ?></td></tr>
		  <tr><th>Status:</th><td><?php echo $status_str; ?></td></tr>
		  <tr><th>         </th><td><input type="hidden" id="ispopupshow" name="ispopupshow" value="<?php echo $status_str; ?>" /></td></tr>
		</table>
		</form>
	</div>

