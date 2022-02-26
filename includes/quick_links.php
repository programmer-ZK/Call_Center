<script src="jquery.js"></script>
<script>
	$(document).ready(function() {
		$("#flip13").click(function() {
			$("#panel13").slideToggle("slow");
			$("#flip13 h4 div + div").toggleClass('arrow_down');
		});
	});
</script>

<style type="text/css">
	#panel13,
	#flip13 {
		border-bottom: 1px dotted #d6d8d9;
	}

	#panel13 {

		display: none;
	}
</style>

<?php

include_once("classes/quick_links.php");
$quick_links = new quick_links();


$rs = $quick_links->get_links_active();


?>
<div class="box">
	<div id="flip13">
		<h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Quick Links</h4>
	</div>
	<div id="panel13">
		<!--<h4 class="light-blue rounded_by_jQuery_corners" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Quick Links</h4>-->
		<div class="box-container rounded_by_jQuery_corners" style="-moz-border-radius-bottomleft: 5px; -moz-border-radius-bottomright: 5px;">


			<ul class="list-links ui-accordion ui-widget ui-helper-reset" role="tablist">
				<?php while (!$rs->EOF) { ?>
					<li class="ui-accordion-li-fix">
						<a href="<?php echo $rs->fields["url"]; ?>" class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top" role="tab" aria-expanded="true" tabindex="0" target="_blank"><span class="ui-icon ui-icon-triangle-1-s"></span><?php echo $rs->fields["title"]; ?></a>
					</li>

				<?php $rs->MoveNext();
				} ?>
			</ul>
		</div>
	</div>
</div>