<!--<div class="box">  -->    
		<h4 class="white">
	<div>
	From Date :
	 <label>
		<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo $fdate; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown',true,'24',true)">
		</label>
	
	
	<div style="float:right;">
	
	
	To Date :
	 <label>
		<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo $tdate; ?>" autocomplete = "off" readonly="readonly" onclick="javascript:NewCssCal ('tdate','yyyyMMdd', 'dropdown',true,'24',true)">
		 </label>
		
		 <a class="button" href="javascript:document.xForm.submit();" >
		 <span>Search</span>
		 </a>
		<input type="hidden" value="Search >>" id="search_date" name="search_date" />
						
						
	<div>
	</div>
	</h4>
	<!--</div>-->
