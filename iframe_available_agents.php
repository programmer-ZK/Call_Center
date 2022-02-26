<link href="css/style.css" rel="stylesheet" type="text/css" />
 
<style type="text/css"> 
#panel10,#flip10
{
border-bottom:1px dotted #d6d8d9;
}
#panel10
{

display:none;
}
div.box-container {
	padding: 0px;
}
ul.list-links, div#to-do-list ul {
	padding: 0px;
}
body, html {
	background: none;
	height: auto;
}
</style>


	<?php 
	error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		 include_once('includes/ticket_sys/config.php');
				
		$rs_admin = get_available_user_list();
		//print_r($rs_admin);
		

	?>
	
		<!--<h4 class="light-grey">Available Agents</h4>-->
			  <div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">
				<ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
				 <?php
			                while($rows = mysql_fetch_object($rs_admin)){ ?>
						  <li class="ui-accordion-li-fix"> <a href="#" style="background:none;" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" ><span class="ui-icon ui-icon-triangle-1-s"></span><?php echo $rows->full_name." --- ".$rows->agent_exten; ?></a> </li>
						  <?php
		                        //$rs_admin->MoveNext();
                			}
                		?>
						 
				 </ul></div>
			
