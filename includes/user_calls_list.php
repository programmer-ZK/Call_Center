
		<?php 
			include_once("classes/user_tools.php");		
			$user_tools = new user_tools(); 
			$rs = $user_tools->get_user_calls($caller_id);
		?>
        <!--JD inline 22 dec 2014-->
<div class="box" style="display:none;">
		<h4 class="light-blue rounded_by_jQuery_corners" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Client Call Stats <?php echo !empty($caller_id)?"[".$caller_id."]":"";?></h4>
		<div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
                      

			<ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
					<?php
					if(!empty($caller_id))
					{
					 	if(!$rs->EOF){ 
							while(!$rs->EOF)
							{ ?>
						<li class="ui-accordion-li-fix"> <a href="call_detail.php?unique_id=<?php echo $rs->fields["unique_id"];?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span><?php echo $rs->fields["update_datetime"]." | ".$rs->fields["agent_name"]; ?></a></li>
				<?php 		$rs->MoveNext();
						 	} ?>
				<?php 	}else { ?>
					<li>
						<a id="zero_calls" href="#">No calls yet</a>
					</li>
				<?php 	} 
				}
					else
					{
					?>
					<li>
						<a id="zero_calls" href="#">No calls yet</a>
					</li>
				<?php 
					}
				?>
			</ul>
			</div>
		</div>
