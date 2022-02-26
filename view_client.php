<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php
   if(!$_REQUEST['id']){
     redirect('search_client.php');
     exit;
}
ClientInfo::markTicketOverdue();  
	$page_name = "view_client.php";
	$page_title = "View Client";
	$page_level = "4";
	$page_group_id = "1";
	$page_menu_title = "View Client";
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
   /* margin:15px 0 0 10px;*/
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
    -webkit-transition-delay: 1s;
    -moz-transition-delay: 1s;
    -o-transition-delay:1s;
    transition-delay: 1s;
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
</style>
<div class="box">  
 <?php if(isset($_REQUEST['msg'])){?>
      <div id="message-green">
          <table border="0" width="100%" cellpadding="0" cellspacing="0">
          <tr>
          <td class="green-left"><?php echo $_REQUEST['msg'];?></td>
          <td class="green-right"><a class="close-green"><img src="images/icon_close_green.gif" alt="" /></a></td>
          </tr>
          </table>
      </div>
      <?php } ?>
		<h4 class="white"><?php echo($page_title); ?> </h4>
       
        <?php 
    $id = $_REQUEST['id'];  
    $user = ClientInfo::getUser($id);
	 ?>
<?php if($user){ ?>
 <div class="box-container">
        <table  class="table-short">
          <tr>
            <td colspan="3"><h4 class="white"><?php echo $user->name;?> </h4></td>
          </tr>
          <?php if($user->company_name){?>
          <tr>
            <td class="col-head2">Company Name :</td>
            <td class="col-head2"><?php echo $user->company_name;?></td>
          </tr>
           <?php } ?>
          <tr>
            <td class="col-head2">Name:</td>
            <td class="col-head2"><a style="color:blue;" href="edit_client.php?id=<?php echo $id; ?>"><?php echo $user->name;?></a></td>
          </tr>
          <tr>
            <td class="col-head2">Email:</td>
            <td class="col-head2"><?php echo $user->email; ?></td>
          </tr>
             <?php if($user->cnic){?>
           <tr>
            <td class="col-head2">CNIC:</td>
            <td class="col-head2"><?php echo preg_replace('~.*(\d{5})[^\d]*(\d{7})[^\d]*(\d{1}).*~', 
                '$1-$2-$3'." \n",$user->cnic);?></td>
          </tr>
             <?php } ?>
            <?php if($user->phone){?>  
          <tr>
            <td class="col-head2">Contact Number:</td>
            <td class="col-head2"><?php echo ($user->phone)?preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', 
                '($1) $2-$3'." \n",$user->phone) :$user->phone;?></td>
          </tr>
          <?php } ?>
        </table>
  </div>
    <h4 class="white">User Tickets</h4> 
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
$tickets = ClientInfo::getUserTickets($user);
if(mysql_num_rows($tickets) > 0){?>
<?php  while($ticket = mysql_fetch_object($tickets)){
	      // print_r($ticket);
		  // die;
		   ?>
             <tr>
                <td>
                <div id="button" class="popupHoverElement">
                  <h3><a title="Preview Ticket" target="_blank" href="ticket_detail.php?id=<?php echo $ticket->ticket_id;?>">#<?php echo $ticket->number;?></a></h3>
                    <div id="two" class="popupBox">
                    <div class="tip_content">
                    <a href="#" class="tip_close"><i class="icon-remove-circle"></i></a>
                    <div style="width:600px; padding: 2px 2px 0 5px;" id="t447218">
                     <h2>Ticket #<?php echo $ticket->number;?>: <?php echo $ticket->subject;?></h2><br>
                     <div id="msg_warning">&nbsp;<span class="Icon overdueTicket"> <?php echo ($ticket->isoverdue=="1")?" Marked overdue!":""?></span></div>
                     <?php $countThread = ClientInfo::countThread($ticket->ticket_id);
							$countThread = mysql_fetch_object($countThread);//$threads = ClientInfo::getTicketThread($ticket->ticket_id); ?>
                    <?php if($countThread->thread <=1){?>
					<a id="preview_tab" target="_blank" href="edit_ticket.php?id=<?php echo $ticket->ticket_id;?>&uid=<?php echo $ticket->user_id;?>" class="active"><i class="icon-list-alt"></i>Edit Ticket</a></li>
					<?php }  ?> 
                     
                     <div class="tab_content" id="preview">
                   <table border="0" cellspacing="" cellpadding="1" width="100%" class="ticket_info">
                   <tbody>
                   <tr>
                    <th width="100">Ticket State:</th>
                    <td><span><?php echo $ticket->status;?></span></td>
                  </tr>
                   <tr>
                        <th>Created:</th>
                        <td><?php echo dateTime($ticket->created);?></td>
                   </tr>
                   <tr>
                        <th>Due Date:</th>
                        <td><?php echo dateTime($ticket->duedate);?></td>
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
             <!-- <tr>
               <th width="100">Team:</th>
              <td><?php //echo $ticket->team;?></td>
             </tr>-->
             <?php /*?><tr>
            <th>Help Topic:</th>
            <td><?php echo $ticket->helptopic;?></td>
            </tr><?php */?>
            </tbody></table></div>
            </div></div>
            </div> </div>
                </td>
                <td><?php echo dateTime($ticket->created);?></td>
                <td><?php echo $ticket->subject;?></td>
                <td><?php echo $ticket->team;?></td>
                <td><?php echo $ticket->full_name;?></td>
                <td><?php echo $ticket->status;?></td>
             </tr>
<?php } ?>	
<?php } ?>
   
    <tr>
    <td colspan="6"><a title="New Ticket" href="create_ticket.php?a=open&uid=<?php echo $user->id;?>">Create New Ticket</a></td> 
    </tr>
    </tbody>
    </table>
    </div> 
<?php }else{ ?>
       <h4 class="white"> <span class="error"><font color="red">Client not found.</font></span></h4>

<?php } ?>
    </div>
<?php include($site_root."includes/footer.php"); ?>

 