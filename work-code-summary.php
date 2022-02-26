<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "work-code-summary.php";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "Work Code Summary";
        $page_menu_title = "Work Code Summary";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
	include_once("classes/admin.php");
	$admin = new admin();
		
	include_once("classes/tools_admin.php");
	$tools_admin = new tools_admin();
	
	include_once("classes/reports.php");
	$reports = new reports();
	
	include_once("classes/all_agent.php");

$all_agent = new all_agent();	
?>	
<?php include($site_root."includes/header.php"); ?>	
<!--<meta http-equiv="refresh" content="2">-->
<html>
<head>
<script type="text/javascript">
function getHtml4Excel()
{
	document.getElementById("f_date").value = document.getElementById("fdate").value;
	document.getElementById("t_date").value = document.getElementById("tdate").value;
	var e = document.getElementById("_workcode");
    var strSearch = e.options[e.selectedIndex].value;
	document.getElementById("workcode").value = strSearch;
}
</script>
</head>
<body>

<?php
//print_r($_SESSION);
$rs_agent_name ="";
if(isset($_REQUEST['fdate']))
{
	
	$workcode 		    = $_REQUEST['workcode'];
	$fdate 				= $_REQUEST['fdate'];
	$tdate 				= $_REQUEST['tdate'];
//$rs_agent_name = $admin->out_bound_calls_report($search_keyword,$fdate,$tdate);			
}
	
?>
<?php 
/************************* Export to Excel ******************/
///******************************************************************************/	
//$stringData	 = '';
?>

<div>
<form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"   onsubmit="">

<div id="mid-col" class="mid-col">
	<div class="box">
	 
	<h4 class="white">

	<div>
	From Date :
	 <label>
		<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo $fdate; ?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown')">
	</label>
    To Date :
	 <label>
		<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo $tdate; ?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('tdate','yyyyMMdd', 'dropdown')">
	</label>
    
     <br>
     <br>
	 <label> WorkCodes :</label>
		<select name="workcode" id="_workcode">
        <option value="">Select Workcode</option>
        <?php $work_code = $admin->getworkcodes();
		while(!$work_code->EOF){ ?>
          <option value="<?php echo $work_code->fields['wc_title']  ?>" <?php echo  ($workcode==$work_code->fields['wc_title'])?'selected':'';?>><?php echo $work_code->fields['title_value']; ?></option>
			<?php 
			   $work_code->MoveNext();
			}
		?>
        
        </select>
	
	
	<div style="">
    <br>
    
		 <a class="button" href="javascript:document.xForm.submit();" >
		 <span>Search</span>
		 </a>
		<input type="hidden" value="Search >>" id="search_date" name="search_date" />			
	<div>
	</div>
	</h4>
	</form>
	<br />
  <style>
table {
      border-collapse: collapse;
      margin: 1em auto;
    }
    th, td {
      padding: 5px 10px;
      border: 1px solid #999;
      font-size: 12px;
    }
    th {
      background-color: #eee;
    }
    th[data-sort]{
      cursor:pointer;
    }

    /* just some random additional styles for a more real-world situation */
    #msg {
      color: #0a0;
      text-align: center;
    }
    td.name {
      font-weight: bold;
    }
    td.email {
      color: #666;
      text-decoration: underline;
    }
    /* zebra-striping seems to really slow down Opera sometimes */
    tr:nth-child(even) > td {
      background-color: #f9f9f7;
    }
    tr:nth-child(odd) > td {
      background-color: #ffffff;
    }
    .disabled {
      opacity: 0.5;
    }
  </style>      
	<?php if(!empty($fdate) && !empty($fdate)){?>
<div id="agent_pd_report">
<?php $rs_agent_name = $admin->work_code_summary($fdate,$tdate,$workcode);?>
	  <br />
		
<!-- ******************************  Agent On Call and Busy Times ************************** -->
		 <h4 class="white"><?php echo "Work Code Summary    From: ".date('M-d-Y',strtotime($fdate))." To ".date('M-d-Y',strtotime($tdate)); ?></h4>
		<div class="box-container"   > 
         
        	      	
	<table class="table-short" id="keywords">
      			<thead>
					
      				<tr>
					 	<th class="col-head2" style="width: 1000px;">WORKCODES</th>
	        	        <th class="col-head2">INBOUND</th>
						<th class="col-head2">OUTBOUND</th>
						<th class="col-head2">TOTAL</th>
		                
					</tr>
      			</thead>
				<?php  
				  $inbound =0;
				  $outbound =0;
				  $gtotal = 0;
				 ?>
      			<tbody>
				<?php  while(!$rs_agent_name->EOF){ 
				$stringData .= $rs_agent_name->fields['workcodes'].",".$rs_agent_name->fields['inbound'].",".$rs_agent_name->fields['outbound'].",".$rs_agent_name->fields['inbound']."\r\n";
				?>
      				<tr class="odd">
                    <td><?php echo $rs_agent_name->fields['workcodes']; ?></td>
                    <td><?php echo $rs_agent_name->fields['inbound'];  $inbound += $rs_agent_name->fields['inbound']; ?></td>
                    <td><?php echo $rs_agent_name->fields['outbound']; $outbound+= $rs_agent_name->fields['outbound']; ?></td>
                    <td><?php echo ($rs_agent_name->fields['inbound']+$rs_agent_name->fields['outbound']);  $gtotal+= ($rs_agent_name->fields['inbound']+$rs_agent_name->fields['outbound']); ?></td>
                    
					</tr>
				<?php				
				$rs_agent_name->MoveNext();
				} 
				?>
                <?php $stringData .= " Grand Total: ,".$inbound.",".$outbound.",".$gtotal."\r\n";?>
               </tbody>
               <tfoot>
                <tr class="odd">
                    <th>Grand Total</th>
                    <th><?php echo $inbound; ?></th>
                    <th><?php echo $outbound; ?></th>
                    <th><?php echo $gtotal; ?></th>
                    
					</tr>
      			</tfoot>
                
      		</table>  	

      	</div>
	    <br />
	
<form name="xForm2" id="xForm2" action="/convex_crm/export_work_codes_call.php" method="post" class="middle-forms cmxform"  onSubmit="">
  <div style="float:right; margin-top:-5px;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; margin:15px 0 0 20px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
      <input type="hidden" id="f_date" name="fdate" />
      <input type="hidden" id="t_date" name="tdate" />
      <input type="hidden" id="workcode" name="_workcode" />
  </div>
</form>
</div>

<?php } ?>
</div>

</div>
</div>
<?php  include($site_admin_root."includes/footer.php"); ?>
</body>
</html>
