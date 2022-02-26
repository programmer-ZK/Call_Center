
		<?php 
			include_once("classes/user_tools.php");		
			$user_tools = new user_tools(); 
			$rs = $user_tools->get_agent_calls($_SESSION[$db_prefix.'_UserId']);
		?>
		<div id="sys-messages-container"> 
			<h5>Last Calls [Agent: <?php echo ucwords( $_SESSION[$db_prefix.'_UserName']);?>]</h5>
			<ul>
				<?php if(!$rs->EOF){ ?>
				<?php $count = "0"; while($count < "3" ){ ?>
				<li class="<?php echo(($count%2==0)?"odd-messages":"even-messages");?>">
					<a id="sample-<?php echo $count + 1;?>" href="call_detail.php?<?php echo $rs->fields["unique_id"];?>"><?php echo $rs->fields["caller_id"];  ?></a>
				</li>
				<?php $count++; $rs->MoveNext(); } ?>
				<?php }else { ?>
					<li>
						<a id="zero_calls" href="#">No calls yet</a>
					</li>
				<?php } ?>
			</ul>
		</div>
