<script src="jquery.js"></script>
<script> 
$(document).ready(function(){
  $("#flip10").click(function(){
    $("#panel10").slideToggle("slow");
	$("#flip10 h4 div + div").toggleClass('arrow_down');
  });
});
</script>
 
<style type="text/css"> 
#panel10,#flip10
{
border-bottom:1px dotted #d6d8d9;
}
#panel10
{

display:none;
}
</style>


	<?php 
		include_once("classes/admin.php");		
		$admin = new admin(); 
		
		/*$total_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW())'); //($_SESSION[$db_prefix.'_UserId']);
		$rec_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) AND status = 0' );
		$inqueue_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) AND status = 2' );*/
		
		$rs_admin = $admin->get_available_user_list();

	?>
	<div class="box">
		<div id="flip10"><h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Available Agents</h4></div>
				<div id="panel10">
		<!--<h4 class="light-grey">Available Agents</h4>-->
			  <div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
				<ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
				 <?php
			                while(!$rs_admin->EOF){ ?>
						  <li class="ui-accordion-li-fix"> <a href="#" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span><?php echo $rs_admin->fields["full_name"]." --- ".$rs_admin->fields["agent_exten"]; ?></a> </li>
						  <?php
		                        $rs_admin->MoveNext();
                			}
                		?>
						 
				 </ul></div>
			</div>
	</div>
