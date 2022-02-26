<?php
	if(isset($_REQUEST['send_msg'])){
			$flag = true;
			if($_REQUEST['message_title'] == ''){
					$message_title_error = "Please Enter Title";//$tools->isEmpty('Caller ID');
					$flag = false;
			 }
			if($_REQUEST['txt_content'] == ''){
					$txt_content_error = "Please Enter Message";//$tools->isEmpty('Caller ID');
					$flag = false;
			 }
			if($flag == true){
					$quick_msgs->send_msg($_REQUEST['message_title'], $_REQUEST['txt_content']);
			}
	}
?>
		<div id="quick-send-message-container">
			<h5>Quick Send</h5>
			<form id="send_message_form" name="send_message_form" method="post" action="<? echo $_SERVER['PHP_SELF'] ?>">
				<fieldset>
					<legend>Quick Send Message</legend>
						<p>
							<label>Message Title:</label>
							<input name="message_title" id="message_title" type="text" maxlength="50"/>
						</p>
						<p>
							<label>Content:</label>
							<textarea name="txt_content" cols="10" rows="5" id="txt_content" ></textarea>
						</p>
						<div class="inner-nav">
							<div class="align-right">
								<a class="button" href="javascript:document.send_message_form.submit();"><span>send</span></a>
							</div>
							<span class="clearFix">&nbsp;</span>
						</div>
						<input  name="send_msg" type="hidden" value="Send Message" id="send_msg" />
				</fieldset>
			</form>
		</div>
