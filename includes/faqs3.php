<script type="text/javascript">
$(document).ready(function(){
	//hide the all of the element with class msg_body
	$(".msg_body_F3").hide();
	//toggle the componenet with class msg_body
	$(".msg_head_F3").click(function(){
		$(this).next(".msg_body_F3").slideToggle('fast');

		var contentPanelId = jQuery(this).attr("id");
		var sentence = document.getElementById('txtquery3').value;
		if (sentence.indexOf(contentPanelId)==-1)
		{
			if(document.getElementById('txtquery3').value == '')
			{
				 document.getElementById('txtquery3').value+= contentPanelId ;
			}
			else
			{
				document.getElementById('txtquery3').value+= ',' + contentPanelId ;
			}
		}
		//alert("contentPanelId: "+ contentPanelId + "sentence: " + sentence);

	});
});
</script>
<style type="text/css">
p {
	padding: 0 0 1em;
}
.msg_list {
	margin: 0px;
	padding: 3px 0px 0px;
	/*width: 383px;*/
}
.msg_head_F3 {
	padding: 5px 10px;
	cursor: pointer;
	position: relative;
	background-color:#F2F2F2;
	margin:1px;
	color: black;
}
.msg_body_F3 {
	padding: 5px 10px 15px;
	/*background-color:#F4F4F8;*/
	color: black;
}
</style>
<?php
	include_once($site_root."classes/templates_faqs.php");
	$templates_faqs = new templates_faqs();
	$query = " and category= 'FAQ 3' ";
	$rs = $templates_faqs->get_records(addslashes($txtSearch), $recStartFrom, $page_records_limit, $field, $order, $query);
?>

<h1>FAQs</h1>
<div class="msg_list">
 <?php
 	$count = 1;
     while(!$rs->EOF){ ?>
		<p class="msg_head_F3" id="F3-Q<? echo $count; ?>">
		<b>Q<? echo $count; ?>.</b>&nbsp; <?php echo $rs->fields["question"]; ?>
		</p>
		<div class="msg_body_F3">
			<?php echo $rs->fields["body"]; ?>
		</div>
 <?php
		  $rs->MoveNext();
		  $count++;
         }
?>
	
		


</div>
