   <style>
   	ul li {

   		border-bottom: 1px solid #eeeddb;
   		background: rgb(181, 130, 79);
   		background: linear-gradient(180deg, rgba(181, 130, 79, 1) 0%, rgba(181, 130, 79, 0.6110819327731092) 100%);
   	}

   	ul li a {
   		padding: 8px 3px 6px 20px;
   		display: block;
   		color: #fff;
   		text-decoration: none;
   		font-weight: bold;
   	}
   </style>
   <?php if (true) { ?>
   	<div id="left-col">
   		<?php
				if (
					$ADMIN_ID1 == $_SESSION[$db_prefix . '_UserId'] || $ADMIN_ID2 == $_SESSION[$db_prefix . '_UserId']
					|| $ADMIN_ID3 == $_SESSION[$db_prefix . '_UserId'] || $ADMIN_ID4 == $_SESSION[$db_prefix . '_UserId']
					|| $ADMIN_ID5 == $_SESSION[$db_prefix . '_UserId'] || $ADMIN_ID6 == $_SESSION[$db_prefix . '_UserId']
				) {
					if ($ADMIN_ID2 == $_SESSION[$db_prefix . '_UserId']) {
						include_once('includes/side_menu_super.php');
					} else {
						include_once('includes/side_menu.php');
					}
				}
				?>
   		<script>
   			function reload() {
   				var path = window.location.pathname;
   				var page = path.split("/").pop();
   				if (page == "" || page == "index.php") {
   					document.getElementById('currentElement').src += '';
   					document.getElementById('mystats').src += '';
   					document.getElementById('available_agents').src += '';
   				}
   			}
   			setInterval(function() {
   				var path = window.location.pathname;
   				var page = path.split("/").pop();
   				if (page == "" || page == "index.php") {
   					if (document.readyState === "complete") {
   						reload();
   					}
   				}
   			}, 30000);

   			$(document).ready(function() {
   				$("#flip8").click(function() {
   					$("#panel8").slideToggle("slow");
   					$("#flip8 h4 div + div").toggleClass('arrow_down');
   				});

   				$("#flip9").click(function() {
   					$("#panel9").slideToggle("slow");
   					$("#flip9 h4 div + div").toggleClass('arrow_down');
   				});

   				$("#flip10").click(function() {
   					$("#panel10").slideToggle("slow");
   					$("#flip10 h4 div + div").toggleClass('arrow_down');
   				});
   			});
   		</script>
   		<style type="text/css">
   			#panel8,
   			#flip8 {
   				border-bottom: 1px dotted #d6d8d9;
   			}

   			#panel8 {
   				display: none;
   			}

   			#currentElement {
   				width: 223px;
   				overflow: hidden;
   				height: 475px;
   			}

   			#mystats {
   				width: 223px;
   				overflow: hidden;
   				height: 180px;
   			}

   			#available_agents {
   				width: 223px;
   				overflow: hidden;
   				height: 180px;
   			}

   			#available_agents {
   				width: 223px;
   				overflow: hidden;
   				height: 100px;
   			}

   			#panel9,
   			#flip9 {
   				border-bottom: 1px dotted #d6d8d9;
   			}

   			#panel9 {
   				display: none;
   			}

   			#panel10,
   			#flip10 {
   				border-bottom: 1px dotted #d6d8d9;
   			}

   			#panel10 {

   				display: none;
   			}
   		</style>

   		<?php $rs_agent_name = $admin->get_agent_name($_SESSION[$db_prefix . '_UserId']); ?>

   		<?php if ($rs_agent_name->fields["department"] == "QA") { ?>
   			<div class="box">
   				<div id="flip9">
   					<h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Call Records</h4>
   				</div>

   				<div id="panel9">
   					<ul>
   						<li class="ui-accordion-li-fix"><a href="icdr-stats.php">Call Records</a> </li>

   					</ul>
   				</div>
   			</div>

   		<?php goto exiit; //if department is QA then goto exiit:
				} ?>

   		<?php if ($rs_agent_name->fields["department"] == "Management") { ?>
   			<div class="box">
   				<div id="flip9">
   					<h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">
   						PBX Configuration</h4>
   				</div>

   				<div id="panel9">
   					<ul>
   						<li class="ui-accordion-li-fix"><a href="extentions.php">Extentions</a> </li>
   						<li class="ui-accordion-li-fix"><a href="ivr.php">IVR</a> </li>
   					</ul>
   				</div>
   			</div>

   		<?php goto exiit; //if department is QA then goto exiit:
				} ?>

   		<?php if ($ADMIN_ID2 != $_SESSION[$db_prefix . '_UserId']) { ?>
   			<div class="box">
   				<!-- gor staright cornerss use this class in h4 box-container rounded_by_jQuery_corners -->
   				<div id="flip8">
   					<h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Call Center Stats</h4>
   				</div>

   				<div id="panel8" style="height: 355px;">

   					<iframe id="currentElement" class="myframe" name="myframe" src="iframe-callstates.php"></iframe>
   				</div>
   			</div>

   			<div class="box">
   				<div id="flip9">
   					<h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">My Stats</h4>
   				</div>
   				<div id="panel9" style="height: 140px;">
   					<iframe id="mystats" class="myframe" name="myframe" src="iframe_my_stats.php?user_id=<?php echo $_SESSION[$db_prefix . '_UserId']; ?>&group=<?php echo $_SESSION[$db_prefix . '_UserGroupId']; ?>"></iframe>
   				</div>
   			</div>

   			<div class="box">
   				<div id="flip10">
   					<h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Available Agents</h4>
   				</div>
   				<div id="panel10">
   					<iframe id="available_agents" class="myframe" name="myframe" src="iframe_available_agents.php"></iframe>
   				</div>
   			</div>

   		<?php } ?>

   		<?php exiit: ?>

   	</div>

   <?php } else {
		} ?>