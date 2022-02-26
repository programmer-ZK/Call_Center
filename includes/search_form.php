<!--<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td>
	<?php 
	//	$txtSearch = $_REQUEST["txtSearch"]; 
	//	$word_count = $_REQUEST["word_count"];
	?>
	<form name="search" id="search" action="<?php //echo($page_name);?>.php<?php //echo $query_str?>" method="post"
    <?php //echo ($page_name=="keywords"?"":"onsubmit='javascript:return search_form(this)'"); ?> >
    	<table cellpadding="0" cellspacing="0" border="0" width="70%" class="search">
        <tr>
        <td >
			<input type="textbox" value="<?php //echo($txtSearch);?>" name="txtSearch" id="txtSearch" class="txtsearchbox" maxlength="255"/>
        </td>
        <td colspan="2">  
        	<input type="submit" value=" Search " name="submit" class="txtsearchbutton"/></td>
            </tr>
        </table>
	</form>
	</td>
	<td>
	 <form name="pageno" id="pageno" action="<?php //echo($page_name);?>.php"<?php //echo $query_str ?> method="post" >
		Goto Page No <input type="textbox" value="<?php //echo(empty($_REQUEST["pgno"])?"1":$_REQUEST["pgno"]);?>" name="pgno" id="pgno" size="10" /> <input type="submit" value=" Goto " name="submit" class="txtsearchbutton"/>
	</form> 
	 </td>
</tr>
</table>

<div class="box"> -->     
		<h4 class="white">
	<div>
	Keywords :&nbsp;<input name="keywords" id="keywords" class="txtbox-short" value="<?php echo $keywords; ?>" >
	 <?php if($form_type == "pin")
		{ ?>
		<label>
		
		<select id="search_keyword" name="search_keyword"  onchange="" >
	  <option <?php echo ($search_keyword == "pin_generate")?"selected=\"selected\"":"";?>  value="pin_generate" >PIN GENERATED</option>
	  <!--<option <?php //echo ($search_keyword == "customer_id")?"selected=\"selected\"":"";?>  value="customer_id" >Customer ID</option>-->	
	  <option <?php echo ($search_keyword == "pin_change")?"selected=\"selected\"":"";?>  value="pin_change" >PIN CHANGED</option>
	  <option <?php echo ($search_keyword == "pin_verified")?"selected=\"selected\"":"";?>  value="pin_verified" >PIN VERIFIED</option>
	  <option <?php echo ($search_keyword == "pin_reset")?"selected=\"selected\"":"";?>  value="pin_reset" >PIN RESET</option>
	 <!-- <option <?php //echo ($search_keyword == "ans_call")?"selected=\"selected\"":"";?>  value="ans_call" >Answered Calls</option>
	  <option <?php //echo ($search_keyword == "drop_call")?"selected=\"selected\"":"";?>  value="drop_call" >Drop Calls</option>
	  <option <?php //echo ($search_keyword == "in_bound")?"selected=\"selected\"":"";?>  value="in_bound" >Inbound Calls</option>
	  <option <?php //echo ($search_keyword == "out_bound")?"selected=\"selected\"":"";?>  value="out_bound" >Outbound Calls</option>-->
	  </select>
		</label>
        	<?php }else if($form_type == "icdr"){ ?>
                    <label>
                        <select id="search_keyword" name="search_keyword"  onchange="" >
                            <option <?php echo ($search_keyword == "caller_id")?"selected=\"selected\"":"";?>  value="caller_id" >Caller ID</option>
                            <option <?php echo ($search_keyword == "full_name")?"selected=\"selected\"":"";?>  value="full_name" >Agent Name</option>
                            <!--<option <?php echo ($search_keyword == "unique_id")?"selected=\"selected\"":"";?>  value="unique_id" >Call Tracking ID</option>
                            <option <?php echo ($search_keyword == "OFFTIME")?"selected=\"selected\"":"";?>  value="OFFTIME" >Off Time Calls</option>
							<option <?php echo ($search_keyword == "SHIFT")?"selected=\"selected\"":"";?>  value="SHIFT" >Shift Calls</option>-->
                            <option <?php echo ($search_keyword == "ANSWERED")?"selected=\"selected\"":"";?>  value="ANSWERED" >Answered Calls</option>
                            <option <?php echo ($search_keyword == "DROP")?"selected=\"selected\"":"";?>  value="DROP" >Drop Calls</option>
                            <option <?php echo ($search_keyword == "INBOUND")?"selected=\"selected\"":"";?>  value="INBOUND" >Inbound Calls</option>
                            <option <?php echo ($search_keyword == "OUTBOUND")?"selected=\"selected\"":"";?>  value="OUTBOUND" >Outbound Calls</option>
							<option <?php echo ($search_keyword == "DIALED")?"selected=\"selected\"":"";?>  value="DIALED" >Dialed Unsuccessfull Calls</option>
                        

  <!--<option <?php //echo ($search_keyword == "IVR")?"selected=\"selected\"":""; ?>  value="IVR" >IVR Calls</option>-->
                        
</select>
                    </label>
	<?php }else if($form_type == "iaband"){ ?>
                    <label>
                        <select id="search_keyword" name="search_keyword"  onchange="" >
                            <option <?php echo ($search_keyword == "caller_id")?"selected=\"selected\"":"";?>  value="caller_id" >Caller ID</option>
                            <option <?php echo ($search_keyword == "unique_id")?"selected=\"selected\"":"";?>  value="unique_id" >Call Tracking ID</option>
                        </select>
                    </label>
	<?php }else if($form_type == "cdr"){ ?>
                    <label>
                        <select id="search_keyword" name="search_keyword"  onchange="" >
                            <option <?php echo ($search_keyword == "caller_id")?"selected=\"selected\"":"";?>  value="caller_id" >Caller ID</option>
                            <option <?php echo ($search_keyword == "agent_name")?"selected=\"selected\"":"";?>  value="agent_name" >Agent Name</option>
                            <option <?php echo ($search_keyword == "call-track_id")?"selected=\"selected\"":"";?>  value="call-track_id" >Call Tracking ID</option>
                            <option <?php echo ($search_keyword == "off_time")?"selected=\"selected\"":"";?>  value="off_time" >Off Time Calls</option>
                            <option <?php echo ($search_keyword == "ans_call")?"selected=\"selected\"":"";?>  value="ans_call" >Answered Calls</option>
                            <option <?php echo ($search_keyword == "drop_call")?"selected=\"selected\"":"";?>  value="drop_call" >Drop Calls</option>
                            <option <?php echo ($search_keyword == "in_bound")?"selected=\"selected\"":"";?>  value="in_bound" >Inbound Calls</option>
                            <option <?php echo ($search_keyword == "out_bound")?"selected=\"selected\"":"";?>  value="out_bound" >Outbound Calls</option>
                        </select>
                    </label>
	<?php } 
	else if ($form_type == "transaction")
	{ ?>
		<label>
		
		<select id="search_keyword" name="search_keyword"  onchange="" >
	  <option <?php echo ($search_keyword == "conversion")?"selected=\"selected\"":"";?>  value="conversion" >CONVERSION</option>
	  <!--<option <?php //echo ($search_keyword == "customer_id")?"selected=\"selected\"":"";?>  value="customer_id" >Customer ID</option>-->	
	  <option <?php echo ($search_keyword == "redemption")?"selected=\"selected\"":"";?>  value="redemption" >REDEMPTION</option>
	 
	  </select>
		</label>
	<?php } 
	else if ($form_type == "registration")
	{ ?>
		<label>
		
<!--	<select id="search_keyword" name="search_keyword"  onchange="" >
	  <option <?php echo ($search_keyword == "ivr")?"selected=\"selected\"":"";?>  value="ivr" >IVR REGISTRATION</option>
	  <option <?php echo ($search_keyword == "sms")?"selected=\"selected\"":"";?>  value="sms" >SMS REGISTRATION</option>
	</select>-->
	<select id="search_keyword" name="search_keyword"  onchange="" >
		<option <?php echo ($search_keyword == "Pending")?"selected=\"selected\"":"";?>  value="Pending" >Pending</option>
		<option <?php echo ($search_keyword == "Executed")?"selected=\"selected\"":"";?>  value="Executed" >Executed</option>
		<option <?php echo ($search_keyword == "Processing")?"selected=\"selected\"":"";?>  value="Processing" >Processing</option>
		<option <?php echo ($search_keyword == "Rejected")?"selected=\"selected\"":"";?>  value="Rejected" >Rejected</option>
		<option <?php echo ($search_keyword == "customer")?"selected=\"selected\"":"";?>  value="customer" >Customer</option>	  		<option <?php echo ($search_keyword == "physical")?"selected=\"selected\"":"";?>  value="physical" >Physical</option>
		<option <?php echo ($search_keyword == "ivr")?"selected=\"selected\"":"";?>  value="ivr" >IVR</option>
	</select>
		</label>
	<?php } 
	else if ($form_type == "links")
	{ ?>
		<label>
		
		<select id="search_keyword" name="search_keyword"  onchange="" >
	  <option <?php echo ($search_keyword == "title")?"selected=\"selected\"":"";?>  value="title" >Title</option>
	  <!--<option <?php //echo ($search_keyword == "customer_id")?"selected=\"selected\"":"";?>  value="customer_id" >Customer ID</option>-->	
	  <option <?php echo ($search_keyword == "url")?"selected=\"selected\"":"";?>  value="url" >URL</option>
	 
	  </select>
		</label>
	
	<?php }else if($form_type == "workcode_report"){ ?>
		<label>	
		<select id="search_keyword" name="search_keyword"  onchange="" >
		  <option <?php echo ($search_keyword == "call-track_id")?"selected=\"selected\"":"";?>  value="call-track_id" >Unique Call ID</option>
		  <option <?php echo ($search_keyword == "caller_id")?"selected=\"selected\"":"";?>  value="caller_id" >Caller ID</option>
		  <option <?php echo ($search_keyword == "agent_name")?"selected=\"selected\"":"";?>  value="agent_name" >Agent Name</option>
		  <!--<option <?php echo ($search_keyword == "workcode")?"selected=\"selected\"":"";?>  value="workcode" >Work Code</option>-->
	  </select>
		</label>
		<!--<a href="" onclick="javascript: popitup('workcode_selection_for_search.php');" id="topLink" title="Click here" style="font-size:9px;color:#FFFFFF;">Select workcodes</a>-->
	<?php } 
	?>
	
	
	
	</div>
	</h4>
	<!--</div>-->
