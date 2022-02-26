	<script src="jquery.js"></script>
<script> 
$(document).ready(function(){
  $("#flip11").click(function(){
    $("#panel11").slideToggle("slow");
  });
});
</script>
 
<style type="text/css"> 
#panel11,#flip11
{
border-bottom:1px dotted #d6d8d9;
}
#panel11
{

display:none;
}
</style>
	
	
	<?php 
		include_once("classes/tools_admin.php");		
		$tools_admin = new tools_admin(); 
		
		$available_lines = $tools_admin->get_o_channels('*', 'outbound', 'table2.status = 0'); 
		$bzi_lines = $tools_admin->get_o_channels('*', 'outbound', 'table2.status = 1');
		//$rec_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'TIMEDIFF(dequeue_datetime,enqueue_datetime) > \'00:00:00\' AND DATE(update_datetime) = DATE(NOW())   ORDER BY id DESC' );
		//$drop_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'TIMEDIFF(dequeue_datetime,enqueue_datetime) = \'00:00:00\' AND DATE(update_datetime) = DATE(NOW()) AND status = 0  ORDER BY id DESC' );
//		$total_inqueue_calls = $tools_admin->select('COUNT(*)', 'queue_stats', 'TIMEDIFF(dequeue_datetime,enqueue_datetime) <> \'00:00:00\' AND TIMEDIFF(dequeue_datetime,enqueue_datetime) > \'00:00:10\' AND DATE(update_datetime) = DATE(NOW()) ORDER BY id DESC' );
	//	$inqueue_calls = $tools_admin->select('sum()COUNT(*)', 'queue_stats', 'DATE(update_datetime)= DATE(NOW()) AND status = 1' );
		
	?>
	<div class="box">
		<!--<h4 class="light-grey">Outbound Lines Available</h4>-->
			<div id="flip11"><h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Outbound Lines Available</h4></div>
				<div id="panel11">
		
		
			  <div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
			  <ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
			   <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Available Lines: <?php echo $available_lines->RecordCount()." / 3"; ?>
			   <?php
			                while(!$available_lines->EOF){ ?>
							 <br />
							 <?php 
							 		if($available_lines->fields["channel"] == "DAHDI/6-1") $channels = "1";
									if($available_lines->fields["channel"] == "DAHDI/7-1") $channels = "2";
									if($available_lines->fields["channel"] == "DAHDI/8-1") $channels = "3";
							 echo $channels; ?>
							
				<?php
		                        $available_lines->MoveNext();
                			}
                		?>
				</a> </li>
				
				<li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Busy Lines: <?php echo $bzi_lines->RecordCount(); ?>
			   <?php
			                while(!$bzi_lines->EOF){ ?>
							 <br />
							 
							 	
							 <?php 
							 		if($bzi_lines->fields["channel"] == "DAHDI/6-1") $channels2 = "1";
									if($bzi_lines->fields["channel"] == "DAHDI/7-1") $channels2 = "2";
									if($bzi_lines->fields["channel"] == "DAHDI/8-1") $channels2 = "3";
							 echo $channels2." | ".$bzi_lines->fields["agent_name"]; ?>
							
				<?php
		                        $bzi_lines->MoveNext();
                			}
                		?>
				</a> </li>
						 
					<!--	  <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Received Calls: <?php //echo $rec_calls;?></a> </li>
					 <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Drop Calls: <?php //echo $drop_calls;?></a> </li>  
						  <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>Total InQueued: <?php //echo $total_inqueue_calls;?></a> </li> 
						  <li class="ui-accordion-li-fix"> <a href="" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span>InQueue: <?php //echo $inqueue_calls;?></a> </li> -->
						
						   
						  
				 </ul></div>
			</div>
	</div>
