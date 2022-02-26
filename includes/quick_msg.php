
<script src="jquery.js"></script>
<script> 
$(document).ready(function(){
  $("#flip12").click(function(){
    $("#panel12").slideToggle("slow");
  });
});
</script>
 
<style type="text/css"> 
#panel12,#flip12
{
border-bottom:1px dotted #d6d8d9;
}
#panel12
{

display:none;
}
</style>

<script language="javascript1.2" type="text/javascript">
	setInterval( "get_quick_msgs()", 10000 );  
</script>
<script type="text/javascript" language="javascript1.2">
function get_quick_msgs(){
	var rnd = Math.random();
    var url="ajax_call.php?id="+rnd+"&param_1=GetQuickMsgs&param_2=Ajax";
    npostRequest(url);
}
function npostRequest(strURL){
        var xmlHttp;
          if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                 var xmlHttp = new XMLHttpRequest();
            }else if (window.ActiveXObject) { // IE
                var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlHttp.open('POST', strURL, true);
            xmlHttp.setRequestHeader
              ('Content-Type', 'application/x-www-form-urlencoded');
                xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
				document.getElementById("sys-messages-container").innerHTML = xmlHttp.responseText ;
                //alert(xmlHttp.responseText);
              }
           }
         xmlHttp.send(strURL);
}
</script>

<?php
  include_once("classes/quick_msgs.php");
  $quick_msgs = new quick_msgs();
?>

<div class="box" id="quick_msgs" name="quick_msgs">
	<div id="flip12"><h4 class="light-grey" style="-moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px;">Quick Messages</h4></div>
				<div id="panel12">
	<!--<h4 class="light-blue">Quick Messages</h4>-->
	<div class="box-container">
<?php
	include_once("includes/quick_msg_list.php");
	include_once("includes/quick_msg_form.php");	
?>		
	</div>
</div></div>