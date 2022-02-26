<!--<div class="box">  -->
<h4 class="white">
	<div>
		From Date :
		<label>
			<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo ($fdate) ? date('d-m-Y', strtotime($fdate)) : date('d-m-Y'); ?>" autocomplete="off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">
		</label>

		<!--yyyyMMdd -->
		<div style="float:right;">


			To Date :
			<label>
				<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo ($tdate) ? date('d-m-Y', strtotime($tdate)) : date('d-m-Y'); ?>" autocomplete="off" readonly="readonly" onclick="javascript:NewCssCal ('tdate','ddMMyyyy', 'dropdown')">
			</label>

			<a class="button" href="javascript:document.xForm.submit();">
				<span>Search</span>
			</a>
			<input type="hidden" value="Search >>" id="search_date" name="search_date" />


			<div>
			</div>
</h4>
<!--</div>-->