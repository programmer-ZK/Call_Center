		<?php $rs = $quick_msgs->get_quick_msgs();?>
		<div id="sys-messages-container">
			<h5>Latest Messages</h5>
			<ul>
				<?php $count = "0"; while($count < "3"){ ?>
				<li class="<?php echo(($count%2==0)?"odd-messages":"even-messages");?>">
					<a id="sample-<?php echo $count + 1;?>" href=""><?php echo $rs->fields["title"];  ?></a>
					<a href="" class="sysmessage-delete"><img src="images/icon-messages.gif" alt=" " /></a>
					<div class="hidden">
						<div id="sample-modal-<?php echo $count + 1;?>">
							<h2 style="font-size:160%; font-weight:bold; margin:10px 0;"><?php echo $rs->fields["title"];  ?></h2>
							<p><?php echo $rs->fields["message"];  ?></p>
						</div>
					</div>
				</li>
<!--  <li class="odd-messages"><a href="#"><?php echo $rs->fields["title"];   ?></a>
<a href="#" class="sysmessage-delete"><img src="images/icon-delete-message.gif" alt=" " /></a></li> 
<li class="odd-messages"><a href="#"><?php echo $rs->fields["title"];   ?></a>
<a href="#" class="sysmessage-delete"><img src="images/icon-delete-message.gif" alt=" " /></a></li> -->
				<?php $count++; $rs->MoveNext(); } ?>
			</ul>
		</div>
