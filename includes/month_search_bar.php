<!--<div class="box">  -->   
<style>
.ui-datepicker-calendar {
    display: none;
    }

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<script>
$(function() { 

var today = new Date();
var dd = today.getDate();
var mm = today.getMonth(); //January is 0!
var yyyy = today.getFullYear();
// console.log(today);
$( "#month" ).datepicker({
		maxDate: new Date(yyyy, mm,dd),
		changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
       /* dateFormat: 'MM yy',*/
        onClose: function(dateText, inst) { 
            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			month = parseInt(month)+1;
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, month, 1));
			$('#month').val(month+'/'+year);
        }
	});
});
</script>





 

<h4 class="white">
	<table>
		<tr>
			<td style="padding-right:5px">
				Select Month:
			</td>
			<td>
	 			<label>
				<input name="month" type="text" id="month" class="txtbox-short-date" value="<?php echo $month;?>" >
				</label>
			</td>		
			<td>
				<a class="button" href="javascript:document.xForm.submit();" >
				
		 		<span>Search</span>
		 		</a>
				<input type="hidden" value="Search >>" id="search_date" name="search_date" />
			</td>
				
		</tr>
		
	</table>
	
	</h4>
	<!--</div>-->
