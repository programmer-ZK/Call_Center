<style>
.ui-datepicker-calendar {
    display: none;
    }

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http:////code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<script>
$(function() { 

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth(); //January is 0!
var yyyy = today.getFullYear();
// console.log(today);
$( "#month" ).datepicker({
					   changeMonth: true,
					   changeYear: true,
					   showButtonPanel: true,
					   dateFormat: 'MM yy',
					   /*minDate: 2, */
					   maxDate: new Date(yyyy, mm,dd)

						});
});
</script>
<input name="month" type="text" id="month" class="txtbox-short-date" value="" >