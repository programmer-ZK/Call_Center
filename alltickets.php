<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php
 // is to mark ticket over due;	 
ClientInfo::markTicketOverdue();  
 //print_r($printme);

	$page_name = "alltickets.php";
	$page_title = "All Tickets";
	$page_level = "4";
	$page_group_id = "1";
	$page_menu_title = "All Tickets";
?>
<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
		 include_once('lib/nusoap.php');
        include_once("classes/tools.php");
        $tools = new tools();
		global $tools;
?>
<?php
		include_once("classes/admin.php");
			$admin = new admin();
?>
<?php include($site_root."includes/header.php"); ?>
<style>
#button {
    background:#FFF;
    position:relative;
    width:100px;
    height:26px;
    line-height:27px;
    display:block;
    border:1px solid #dadada;
    /*margin:15px 0 0 10px;*/
    text-align:center;
}
#two {
    background: none repeat scroll 0 0 #EEEEEE;
    border: 1px solid #DADADA;
    color: #333333;
    overflow:hidden;
    left: 0;
    line-height: 20px;
    position: absolute;
    top: 30px;
	z-index: 99;
}
.popupBox {
    visibility:hidden;
    opacity:0;
    -webkit-transition:visibility 0s linear 0.3s, opacity 0.3s linear;
    -moz-transition:visibility 0s linear 0.3s, opacity 0.3s linear;
    -o-transition:visibility 0s linear 0.3s, opacity 0.3s linear;
    transition:visibility 0s linear 0.3s, opacity 0.3s linear;
    -webkit-transition: all 0.4s ease;
    -moz-transition: all 0.4s ease;
    -o-transition:all 0.4s ease;
    transition: all 0.4s ease;
    -webkit-transition-delay: 0s;
    -moz-transition-delay: 0s;
    -o-transition-delay:0s;
    transition-delay: 0s;
}
.popupHoverElement:hover > .popupBox {
    visibility:visible;
    opacity:1;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
    -webkit-transition-delay: 0s;
    -moz-transition-delay: 0s;
    -o-transition-delay: 0s;
    transition-delay: 0s;
}
.pagination {
	display: inline-block;
	text-align: center;
	width: 100%;
	margin-bottom: 20px;
}
.pagination ul {
	display: inline-block;
	list-style: none;
}
.pagination ul li {
	display: inline-block;
	font-size: 14px;
	font-weight: bold;
	margin: 0 2px;
}
.pagination ul li a {
	color: #000;
	float: left;
	padding: 5px 10px;
	text-decoration: none;
	background: #fff;
	-webkit-transition: all 0.5s ease;
	-moz-transition: all 0.5s ease;
	-o-transition: all 0.5s ease;
	transition: all 0.5s ease;
}
.pagination ul li:hover a, .pagination ul li:focus a, .pagination ul li.active a {
	color: #a72c62;
}
#mid-col table> tbody> tr.red > td {
	background-color:#508DB8;
	color: white;
}

</style>
<?php 
if(isset($_REQUEST['fdate']))
{ $fdate = $_REQUEST['fdate']; $tdate = $_REQUEST['tdate']; $curren_status = $_REQUEST['status'];} 
if(isset($_REQUEST['frdate']))
{ $frdate 	= $_REQUEST['frdate'];$trdate 	= $_REQUEST['trdate']; }

?>

<div class="box">  
<h4 class="white"><?php echo($page_title); ?> </h4>
 <form name="xForm" id="xForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="middle-forms cmxform"   onsubmit="">
	<h4 class="white">
	Date :
	 <label>
		<input name="fdate" id="fdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['fdate'])? date('d-m-Y', strtotime($_REQUEST['fdate'])):$fdate = date('d-m-Y'); ?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('fdate','ddMMyyyy', 'dropdown')">
	</label>  
     To Date :
	 <label>
		<input name="tdate" id="tdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['tdate'])? date('d-m-Y', strtotime($_REQUEST['tdate'])):$tdate = date('d-m-Y'); ?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('tdate','ddMMyyyy', 'dropdown')">
	</label>        
       <label class="field-title"><strong> Ticket Status:</strong></label>
      <?php $statuses = getTicketStatus();?>
                <select name="status" id="t_status" data-prompt="Select">
                        
                         <?php while($status = mysql_fetch_object($statuses)){?>
                          <option value="<?php echo $status->id;?>" <?php echo ($curren_status==$status->id)? "selected" :""?>>
						   <?php echo $status->name;?></option>
				<?php }?>       
           </select>
	</label>  
    <br>
    <br> 
    From Response Date :
	 <label>
		<input name="frdate" id="frdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['frdate'])? date('d-m-Y', strtotime($_REQUEST['frdate'])):""; ?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('frdate','ddMMyyyy', 'dropdown')">
	</label>  
     To Response Date :
	 <label>
		<input name="trdate" id="trdate" class="txtbox-short-date" value="<?php echo ($_REQUEST['trdate'])? date('d-m-Y', strtotime($_REQUEST['trdate'])):"";?>" autocomplete = "off" readonly onClick="javascript:NewCssCal ('trdate','ddMMyyyy', 'dropdown')">
	</label>       
		 <a class="button" href="javascript:document.xForm.submit();" >
		 <span>Search</span>
		 </a>
		<input type="hidden" value="Search >>" id="search_date" name="search_date" />			
	
	</h4>
	</form>
	<br />
   <!-- <h4 class="white">User Tickets</h4> -->
   <div class="box-container">      
  <table class="table-short">
  <thead>
  <tr>
    <th>Ticket</th>
    <th>Date</th>
    <th>Subject</th>
    <th>Team/Group</th>
    <th>Initiator</th>
    <th>Status</th>
  </tr>
  </thead>
  <tbody>
<?php 
//print_r($_SESSION);
$agent_id = $_SESSION[$db_prefix.'_UserId'];
$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if(isset($_REQUEST['fdate']) && isset($_REQUEST['tdate'])){
	$fdate = $_REQUEST['fdate']; $tdate = $_REQUEST['tdate']; $curren_status = $_REQUEST['status'];
}
if(!empty($_REQUEST['frdate']) && !empty($_REQUEST['trdate'])){
	$frdate = $_REQUEST['frdate']; $trdate = $_REQUEST['trdate'];
	$frdate = date('Y-m-d', strtotime($frdate));
    $trdate = date('Y-m-d', strtotime($trdate));
	
}
$fdate = date('Y-m-d', strtotime($fdate));
$tdate = date('Y-m-d', strtotime($tdate));		
if ($page <= 0) $page = 1;
	$per_page = 50; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
 $curren_status = ($curren_status)?$curren_status:"1";	 
$tickets = ClientInfo::getAllTickets($startpoint,$per_page,$fdate,$tdate,$curren_status,$frdate,$trdate);
$found_rows = $admin->found_rows();
if(mysql_num_rows($tickets) > 0){?>
<?php  while($ticket = mysql_fetch_object($tickets)){
	$newthread = ClientInfo:: getNewThread($ticket->ticket_id);
	$newthread =  mysql_fetch_object($newthread);
	$countThread = ClientInfo::countThread($ticket->ticket_id);
	$countThread = mysql_fetch_object($countThread);
    //print_r($countThread->thread);	die;   ?>
             <tr <?php if (isset($newthread->thread) && strstr($newthread->viewers,$agent_id) == false){ echo "class='red'"; }?>>
                <td>
                <div id="button" class="popupHoverElement">
                  <h3><a title="Preview Ticket" target="_blank" href="ticket_detail.php?id=<?php echo $ticket->ticket_id;?>">#<?php echo $ticket->number;?></a></h3>
                    <div id="two" class="popupBox">
                    <div class="tip_content">
                    <a href="#" class="tip_close"><i class="icon-remove-circle"></i></a>
                    <div style="width:600px; padding: 2px 2px 0 5px;" id="t447218">
                     <h2>Ticket #<?php echo $ticket->number;?>: <?php echo $ticket->subject;?></h2><br>
                     <div id="msg_warning">&nbsp;<span class="Icon overdueTicket"> <?php echo ($ticket->isoverdue=="1")?" Marked overdue!":""?></span></div>
                     <?php  //$threads = ClientInfo::getTicketThread($ticket->ticket_id); $rows= mysql_num_rows($threads); ?>
  <?php if($countThread->thread <=1){?>
  <a id="preview_tab" target="_blank" href="edit_ticket.php?id=<?php echo $ticket->ticket_id;?>&uid=<?php echo $ticket->user_id;?>" class="active"><i class="icon-list-alt"></i>Edit Ticket</a></li>
  <?php }  ?>  
					 <!--<ul class="tabs">
                     <li><a id="preview_tab" href="#preview" class="active"><i class="icon-list-alt"></i>&nbsp;Ticket Summary</a></li>
                     </ul>-->
                     <div class="tab_content" id="preview">
                   <table border="0" cellspacing="" cellpadding="1" width="100%" class="ticket_info">
                   <tbody>
                   <tr>
                    <th width="100">Ticket State:</th>
                    <td><span><?php echo $ticket->status;?></span></td>
                  </tr>
                   <tr>
                        <th>Created:</th>
                        <td><?php echo date('d-m-Y h:i:s A', strtotime($ticket->created));?></td>
                   </tr>
                   <tr>
                        <th>Due Date:</th>
                        <td><?php echo date('d-m-Y h:i:s A', strtotime($ticket->duedate));?></td>
                   </tr>
                  </tbody></table>
                 <hr>
               <table border="0" cellspacing="" cellpadding="1" width="100%" class="ticket_info">
               <tbody>
               <tr>
                <th width="100">Assigned To:</th>
                <td> <span class="faded"><?php echo (isset($ticket->assigned))? $ticket->assigned :"—Unassigned—";?></span></td>
              </tr>
             <!-- <tr>
              <th>From:</th>
              <td><?php //echo $user->email;?></span></td>
              </tr>-->
              <tr>
               <th width="100">Team:</th>
              <td><?php echo $ticket->team;?></td>
             </tr>
             
            </tbody></table></div>
            </div></div>
            </div> </div>
                </td>
                <td><?php echo date('d-m-Y h:i:s A', strtotime($ticket->created));?></td>
                <td><?php echo $ticket->subject;?></td>
                <td><?php echo $ticket->team;?></td>
                <td><?php echo $ticket->full_name;?></td>
                <td><?php echo $ticket->status;?></td>
             </tr>
<?php } ?>	
<?php }else{ ?>
<tr>
    <td colspan="6"><h4 class="white"> <span class="error"><font color="red">Ticekts not found.</font></span></h4></td>
</tr>
<?php } ?>
<tr>
    <td colspan="6">
     <div class="pagination"><ul>
        <?php //print_r($found_rows->fields);?>
       <?php echo paginationAll($per_page=50,$page,$found_rows->fields,$fdate,$tdate,$curren_status,'alltickets.php?fdate='.$fdate.'&tdate='.$tdate.'&status='.$curren_status.'&frdate='.$frdate.'&trdate='.$trdate.'&');
	       
	   ?>
      </ul>
    </td>
  </tr>
  <tr>
    <td colspan="6">
    <form name="xForm2" id="xForm2" action="/convex_crm/export_ticket_summary.php" method="post" class="middle-forms cmxform"  onSubmit="">

  <div style="float:right; margin-top:-5px;">
	<a onClick="getHtml4Excel()"  href="javascript:document.xForm2.submit();" style="display:inline-block; background:url(images/bg-buttons-left.gif) no-repeat; text-decoration:none; height:21px; padding:0 0 0 15px; margin:15px 0 0 20px; color:#fff; font-weight:bold;
font-size:9pt;" >
		 <span style="display:block; background:url(images/bg-buttons-right.gif) no-repeat right; padding:0 15px 0 0; line-height:21px;">EXPORT EXCEL</span>
	</a>
	  <input type="hidden" value="export" id="export" name="export" />
      <input type="hidden" id="f_date" name="fdate" />
      <input type="hidden" id="t_date" name="tdate" />
      <input type="hidden" id="fr_date" name="frdate" />
      <input type="hidden" id="tr_date" name="trdate" />
      <input type="hidden" id="_status" name="status" />
      <input type="hidden" id="is_agent" name="is_agent"  value="0"/>
  </div>
</form>
    </td>
</tr>
    </tbody>
    </table>
    </div> 
    
    </div>
 <script type="text/javascript">
function getHtml4Excel()
{
document.getElementById("f_date").value = document.getElementById("fdate").value;
document.getElementById("t_date").value = document.getElementById("tdate").value;

document.getElementById("fr_date").value = document.getElementById("frdate").value;
document.getElementById("tr_date").value = document.getElementById("trdate").value;
  var e = document.getElementById("t_status");
    var strSearch = e.options[e.selectedIndex].value;
    document.getElementById("_status").value = strSearch;
}
</script>   
<?php include($site_root."includes/footer.php"); ?>

 