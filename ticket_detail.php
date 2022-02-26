<?php 
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M'); ?>
<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php
// is to mark ticket over due;	 
ClientInfo::markTicketOverdue();  
 //print_r($printme);
   if(!$_REQUEST['id']){
     redirect('search_client.php');
     exit;
}   // these methods handle ticket events.
    // ClientInfo::updateEvent($_REQUEST['id']);
    $agent_id = $_SESSION[$db_prefix.'_UserId']; 
    ClientInfo::updateThread($_REQUEST['id'],$agent_id);
	//ClientInfo::updateTicketViewers($_REQUEST['id'],$_SESSION[$db_prefix.'_UserId']);
	$page_name = "ticket_detail.php";
	$page_title = "Ticket Detail";
	$page_level = "4";
	$page_group_id = "1";
	$page_menu_title = "Ticket Detail";
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
	function uploadfile(){
	  $valid_formats = array("doc", "docx", "xls","csv","ppt","xlsx", "pdf","png","jpg","zip","rar");
     $max_file_size = 2097152; //100 kb
     $path = "ticketfiles/"; // Upload directory
	// print_r($_FILES);
	// die;
     if(count($_FILES)>0){
		// Loop $_FILES to exeicute all files
		foreach ($_FILES['file']['name'] as $f => $name) {   
		    if($_FILES['file']['name'][$f] !="")  {  
			if ($_FILES['file']['error'][$f] == 4) {
				return "error";
				//continue; // Skip file if any error found
			}	       
			if ($_FILES['file']['error'][$f] == 0) {	           
				//if ($_FILES['file']['size'][$f] > $max_file_size) {
				//	return  "long";
					//continue; // Skip large files
				//}
				//else
				//if( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				//	return  "invalid";
					//continue; // Skip invalid file formats
			//	}
			//	else{ // No error found! Move uploaded files 
				    $num =  mt_rand(100000, 999999);
					$name = $num.$name;
					$name = str_replace(' ', '_',$name);
					if(move_uploaded_file($_FILES["file"]["tmp_name"][$f],$path.$name)){
						 $info = array('size'=>$_FILES['file']['size'][$f],'type'=>$_FILES["file"]["type"][$f],'name'=>$name);
						 $file_ids[] = ClientInfo::uploadFile($info);
						 //print_r($file_ids);
						 //die('in'); 
						// $message[] = "$name has been uplaoded.";
					     $count++; // Number of successfully uploaded file
					}
					
				// }
			}
		}
	  }
	}
    return $file_ids;
}		
?>
<?php include($site_root."includes/header.php"); ?>

<?php
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/
$errors = array();
$flag =true;
$reassign_display="none;";
$change_status_display ="none;";
$post_display="block;";
if($_REQUEST['change_status']){
	 $reassign_display="none;";
     $post_display="none;";
     $change_status_display="block;";
	if(trim($_REQUEST['status'])==""){
	  $errors['status_change_error'] = "Select Status First.";
	}else{
	  $agent_name = $_SESSION[$db_prefix.'_UserName']; 
	  $_POST['poster'] = $agent_name; 
	  $_POST['agent_id'] = $_SESSION[$db_prefix.'_UserId'];	
	   if($_REQUEST['status']!=$_REQUEST['current_status']){
			    $states =array(1=>'Open',2=>'Resolved',3=>'Closed',6=>'Partial Resolved',7=>'Irrelevant');
				$_POST['state'] = $states[$_REQUEST['status']];
				$_POST['body'] = "Status changed from ".$_REQUEST['status_old']." to ".$states[$_REQUEST['status']]." by ".$agent_name."<hr />".strtolower($states[$_REQUEST['status']]);
				if(ClientInfo::changeTicketStatus($_POST)){
				   $_REQUEST['msg'] ="Status changed successfully.";
				   $_REQUEST['change_status'] ="";
				   $resp = true;
				}
			 
		 } 
	 
	}
}

if($_REQUEST['post_reply']){
    $file_ids = uploadfile();
   if($file_ids=="long"){
     $file_error ="File is too long.";
	   $flag = false;
	  }elseif($file_ids=="invalid"){
		  $flag = false;
	    $file_error ="File type is not valid.";
	  }elseif($file_ids=="error"){
		  $flag = false;
	   $file_error ="Error in file.";
	  }		
	//echo 'y'.$file_error;
	//echo 'x'.$flag;
	//print_r($file);
	//die('fsdfsfsdfsd');
	if(trim($_REQUEST['issue_summery'])==""){
	  $errors['issue_summery'] = "Summary is required.";
	}elseif(trim($_REQUEST['message'])==""){
	  $errors['message'] = "Detail is required.";
	}else if($flag==true){
	  $agent_name = $_SESSION[$db_prefix.'_UserName']; 
	  $_POST['poster'] = $agent_name;   
	  if($_REQUEST['status']!=$_REQUEST['current_status']){
		 $_POST['thread_type'] = "N";  
	  }else{
		$_POST['thread_type'] = "R";
	  }
	  
	  $_POST['agent_id'] = $_SESSION[$db_prefix.'_UserId'];	
	  if($return = ClientInfo::postReply($_POST)){
		  // file upload
		 $return =  array('ticket_id'=>$_POST['ticket_id'],'ref_id'=>$return);	
		   if($return){
				   if($file_ids){
					   foreach($file_ids as $file_id){
						   //echo 'file_id'. $file_id;
						    ClientInfo::ticket_attachment($return,$file_id);
						 }
					   }
					   
				  // redirect('view_client.php?id='.$id.'&msg=Ticket has been created successfully');
				   //$success="Ticket has been created successfully.";
			   }
		  // file upload ends
		   //die('fdfdfdfs');	
		  $_REQUEST['msg'] ="Reply posted successfully."; 
		  $_REQUEST['post_reply'] ="";
		  $resp = true;
		 if($_REQUEST['status']!=$_REQUEST['current_status']){
			    $states =array(1=>'Open',2=>'Resolved',3=>'Closed',6=>'Partial Resolved',7=>'Irrelevant');
				$_POST['state'] = $states[$_REQUEST['status']];
				//$agent_name = $_SESSION[$db_prefix.'_UserName']; 
				$_POST['poster'] = $agent_name;  
				$_POST['body'] = "Status changed from ".$_REQUEST['status_old']." to ".$states[$_REQUEST['status']]." by ".$agent_name."<hr />".strtolower($states[$_REQUEST['status']]);
				if(ClientInfo::changeTicketStatus($_POST)){
				   $_REQUEST['msg'] ="Reply posted successfully.";
				   $_REQUEST['post_reply'] ="";
				   $resp = true;
				}
			 
		 } 
		  
	  }
	  // print_r($_REQUEST);
	  // die('here');	
	}
	
	
	/*$states =array(1=>'Open',2=>'Resolved',3=>'Closed');
	$_POST['state'] = $states[$_REQUEST['status']];
	$agent_name = $_SESSION[$db_prefix.'_UserName']; 
	$_POST['poster'] = $agent_name;  
	$_POST['body'] = "Status changed from ".$_REQUEST['status_old']." to ".$states[$_REQUEST['status']]." by ".$agent_name."<hr />".strtolower($states[$_REQUEST['status']]);
	if(ClientInfo::changeTicketStatus($_POST)){
	   $_REQUEST['msg'] ="Status changed successfully.";
	}*/
}
// reassign tickets

if($_REQUEST['re_assign']){
   $reassign_display="block;";
   $post_display="none;";
   $change_status_display="none;";
     $file_ids = uploadfile();
   if($file_ids=="long"){
     $file_error ="File is too long.";
	   $flag = false;
	  }elseif($file_ids=="invalid"){
		  $flag = false;
	    $file_error ="File type is not valid.";
	  }elseif($file_ids=="error"){
		  $flag = false;
	   $file_error ="Error in file.";
	  }
   
   	if(trim($_REQUEST['team_id'])==""){
	  $errors['team_id'] = "Team is required.";
	}elseif(trim($_REQUEST['issue_summery'])==""){
	  $errors['issue_summery'] = "Summary is required.";
	}elseif(trim($_REQUEST['message'])==""){
	  $errors['message'] = "Detail is required.";
	}elseif($flag==true){
	  $agent_name = $_SESSION[$db_prefix.'_UserName']; 
	   $_POST['poster'] = $agent_name;   
	  //$_POST['poster'] = $agent_name; 
	  $_POST['agent_id'] = $_SESSION[$db_prefix.'_UserId'];
	  $_POST['body'] = "Status reassigned ".$_REQUEST['old_team']." to ".$_REQUEST['new_team']." by ".$agent_name."<hr />".strtolower($_REQUEST['new_team']);
	   	
	   if(ClientInfo::reassignTicket($_POST)){
           // if($_REQUEST['status']!=$_REQUEST['current_status']){
		     $_POST['thread_type'] = "N";
	        //}else{
		   // $_POST['poster'] = $agent_name;   
	       // } 		   
		    if($return = ClientInfo::postReply($_POST)){
		  // file upload
		     $return =  array('ticket_id'=>$_POST['ticket_id'],'ref_id'=>$return);	
		    if($return){
				   if($file_ids){
					   foreach($file_ids as $file_id){
						   //echo 'file_id'. $file_id;
						    ClientInfo::ticket_attachment($return,$file_id);
						 }
				   } 
			 }
		  // file upload ends
		   //die('fdfdfdfs');	
		  $_REQUEST['msg'] ="Ticket Reassigned successfully."; 
		  $_REQUEST['re_assign']="";
		  $reassing = true;
		 if($_REQUEST['status']!=$_REQUEST['current_status']){
			    $states =array(1=>'Open',2=>'Resolved',3=>'Closed',6=>'Partial Resolved',7=>'Irrelevant');
				$_POST['state'] = $states[$_REQUEST['status']];
				//$agent_name = $_SESSION[$db_prefix.'_UserName']; 
				$_POST['poster'] = $agent_name;  
				$_POST['body'] = "Status changed from ".$_REQUEST['status_old']." to ".$states[$_REQUEST['status']]." by ".$agent_name."<hr />".strtolower($states[$_REQUEST['status']]);
				if(ClientInfo::changeTicketStatus($_POST)){
				   $_REQUEST['msg'] ="Ticket Reassigned successfully.";
				   $_REQUEST['re_assign']="";
				   $reassing = true;
				}
			 
		      } 
		  
	      }
		      
	   }
	  
	  // print_r($_REQUEST);
	  // die('here');	
	}	
  // print_r($_REQUEST);	
  // die;
}
//$_REQUEST['msg'] ="Status changed successfully.";
?>
<style>
#button {
    background:#FFF;
    position:relative;
    width:100px;
    height:30px;
    line-height:27px;
    display:block;
    border:1px solid #dadada;
    margin:15px 0 0 10px;
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
     <?php if($file_error!=""){?>
      <div id="message-red">
          <table border="0" width="100%" cellpadding="0" cellspacing="0">
          <tr>
          <td class="red-left"><?php echo $file_error ; ?></td>
          <td class="red-right"><a class="close-red"><img src="images/icon_close_red.gif" alt="" /></a></td>
          </tr>
          </table>
      </div>
      <?php } ?>
      
		
       
        <?php 
    $id = $_REQUEST['id'];  
    ?>
  <?php 
$current_status_id = "";
$current_team_id = "";
$ticket_id = "";
$status_old = ""; 
$old_team = ""; 
$tickets = ClientInfo::getTicketById($id);
if(mysql_num_rows($tickets) > 0){ ?>
<?php  while($ticket = mysql_fetch_object($tickets)){
	   // echo "<pre>"; print_r($ticket); echo "</pre>";
	   // die;
		 $isoverdue = $ticket->isoverdue;
		 $current_status_id = $ticket->status_id;
		 $ticket_id = $ticket->ticket_id;
		 $status_old = $ticket->status;
		 $current_team_id = $ticket->team_id;
		 $old_team = $ticket->assigned;
         $old_team_id=$ticket->team_id;
         $old_due_date = $ticket->duedate;
         $old_priority_id = $ticket->priority_id;
		 //echo date("H:i:s");
		 ?>
            <h4 class="white">Ticket#<?php echo $ticket->number;?></h4> 
            <div class="box-container"> 
           <table class="table-short">
          <tbody>
          <tr>
             <td>Status: <?php echo $ticket->status;?></td>
             <td>Client: <?php echo $ticket->name;?></td>
          </tr>
          <tr>   
             <?php $p_desc = getPriorityById($ticket->priority_id);?>
             <td>Priority: <?php echo $p_desc->priority_desc;?></td>
             <td>Email: <?php echo $ticket->email;?></td>
          </tr>
          <tr>   
             <td>Product: <?php echo $ticket->product;?></td>
             <td>Nature: <?php echo ($ticket->nature=="Others")? $ticket->nature.' :'.$ticket->others : $ticket->nature;?></td>
          </tr>
          <tr>   
             <td>Created: <?php  echo date('d-m-Y h:i:s A', strtotime($ticket->created));?></td> 
             <td>Initiator: <?php echo $ticket->full_name;?></td>
          </tr>
          <tr>   
             <td>Due Date: <?php echo date('d-m-Y h:i:s A', strtotime($ticket->duedate));?></td>
             <td>Assigned To: <?php echo $ticket->assigned;?></td>    
          </tr>
          <tr>   
             <td>Last Message: <?php echo date('d-m-Y h:i:s A', strtotime($ticket->lastmessage));?></td>
             <td>Last Response: <?php echo date('d-m-Y h:i:s A', strtotime($ticket->lastresponse));?></td>
              
          </tr>
          <?php if($ticket->status_id==3){?>
          <tr>  
              <td>Close Date: <?php echo date('d-m-Y h:i:s A', strtotime($ticket->lastmessage));?></td>   
              <?php $closedBy = ClientInfo::closedBy( $ticket->ticket_id); ?>
              <td>Close By: <?php echo $closedBy->poster ;?></td>   
          </tr>
          <?php } ?>
          </tbody>
          </table>
           </div>
           <h4 class="white"><?php echo 'Issue: '.$ticket->subject;?></h4>  
            
<?php } ?>	

 <div class="box-container"> 
<?php 
$threads = ClientInfo::getTicketThread($id);
 while($thread = mysql_fetch_object($threads)){?>
  <h4 class="white">Thread: <?php echo date('d-m-Y h:i:s A', strtotime($thread->created)); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $thread->poster; ?></h4> 
         <table class="table-short">
          <tbody>
          <tr>
           <td><b>Summary: </b><?php echo $thread->title; ?>
          </tr>
          <tr>
             <td><b>Detail: </b><?php echo $thread->body; ?></td> </tr>
             
              <?php $attachments = ClientInfo::getattchment($id,$thread->id); $file =1 ?>
			  <?php if(mysql_num_rows($attachments)){ ?>
			    <tr><td><b>Files:</b> 
              <?php while($attached = mysql_fetch_object($attachments)){  ?>
               <?php if($attached->key==""){ ?>
            	 &nbsp;&nbsp; <a  style="color:blue;" href="ticketfiles/<?php echo $attached->name;?>" target="_blank"><?php echo $attached->name;?></a>
                 <?php }else{ ?>
                 &nbsp;&nbsp; <a style="color:blue;" href="cms/file.php?key=<?php echo $attached->key;?>&expires=''&signature=<?php echo $attached->signature;?>" target="_blank"><?php echo $attached->name;?></a>
                 <?php } ?>
              <?php  $file++; } ?>   
                </td></tr>
			  <?php } ?>
             
         
          
	     
          </tbody>
          </table>
      
<?php 	} ?>
      <h4 class="white"><a href="javascript:;" onclick="clickme();">Post reply</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;"  onclick="clickme2();">Reassign</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;"  onclick="clickme3();">Change Status</a></h4> 
      
      
      
     <div id="post-reply" style="display:<?php echo $post_display;?>">
   
     <span class="error"><font color="red">&nbsp;<?php echo @$errors['status']; ?></font></span>
     <form name="xForm" id="xForm" action="" method="post" class="middle-forms cmxform"   onsubmit="" enctype="multipart/form-data">
	 <input type="hidden" name="action" value="post_reply">
	   <fieldset>
     <ol>
         <li class="even">
    <label class="field-title">Summary:<font color="red"> <em>*</em></font></label>
                <input type="text" id="issue_summery" size="40" maxlength="50" placeholder="" name="issue_summery"
            value="<?php if(!$resp && $_REQUEST['action']=="post_reply"){echo @$_POST['issue_summery'];}?>"/>
            <span class="error"><font color="red">&nbsp;<?php echo @$errors['issue_summery']; ?></font></span>
                <br>
    </li>
    <li class="odd">            
    <label class="field-title"><strong>Details:</strong><font color="red"> <em>*</em></font></label>
                <textarea style="width:100%;" name="message"
                placeholder="Details on the reason(s) for opening the ticket."cols="21" rows="8" 
            style="width:80%;"><?php if(!$resp && $_REQUEST['action']=="post_reply" ){ echo @$_POST['message'];} ?></textarea>
             <span class="error"><font color="red">&nbsp;<?php echo @$errors['message']; ?></font></span>
              <br>
    </li>
     <li class="odd">        
            <div id="p_scents">
             <p>
              <label for="p_scnts">
               <input type="file" name="file[]" size="25" id="p_scnt" />
               <h2><a href="#" id="addScnt" ><button class="button">Add Another</button></a></h2>
              <!--<input type="text" id="p_scnt" size="20" name="p_scnt" value="" placeholder="Input Value" />-->
              </label>
            </p>
            <br/>
            </div>
          
     </li>
      <li class="even">         
      <label class="field-title"><strong> Ticket Status:</strong></label>
      <?php $statuses = getTicketStatus();?>
				
                <select name="status" id="status" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                         <?php while($status = mysql_fetch_object($statuses)){
						 if($status->id!=6 ){
						 ?>
                          <option value="<?php echo $status->id;?>" <?php echo ($current_status_id==$status->id)? "selected" :""?>>
						   <?php echo $status->name;?></option>
						   
				<?php 
				}
				}?>
                           
           </select>
	 	
	</label> 
    </li>
     <li class="odd">        
    <input type="hidden" name="post_reply" value="1" />
    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id;?>" />
    <input type="hidden" name="status_old" value="<?php echo $status_old; ?>" />
    <input type="hidden" name="current_status" value="<?php echo $current_status_id; ?>" />
	<input type="hidden" name="isoverdue" value="<?php echo $isoverdue; ?>" />
    
    <input type="hidden" name="team_id"  value="<?php echo $old_team_id; ?>">
    <input type="hidden" name="old_due_date"  value="<?php echo $old_due_date;?>">
    <input type="hidden" name="old_priority_id"  value="<?php echo $old_priority_id; ?>">
	
		 <a class="button" href="javascript:document.xForm.submit();" >
		 <span>Post Reply</span>
		 </a>
     </li>
     </ol>
      </fieldset>
	</form>
     </div>
     
     <div id="reassign" style="display:<?php echo $reassign_display;?>">
          <span class="error"><font color="red">&nbsp;<?php echo @$errors['status']; ?></font></span>
     <form name="reassign" id="reassign" action="" method="post" class="middle-forms cmxform"   onsubmit="" enctype="multipart/form-data">
	 <input type="hidden" name="action" value="reassign">
	   <fieldset>
     <ol>
      <li class="even">
              <label class="field-title">Team/Group:<font color="red"> <em>*</em></font></label>
             <?php $teams = getTeam();?>
                <select name="team_id" id="team_id" onchange="trackme();">
                 
                  <option value="">&mdash; Select Team&mdash;</option>
                   <?php while($team = mysql_fetch_object($teams)){?>
                 <option value="<?php echo $team->team_id;?>" <?php echo  ($current_team_id == $team->team_id)? "selected" :""?>><?php echo $team->name;?></option>
				<?php }?>
                    </select>
                <br>
                <span class="error"><font color="red">&nbsp;<?php echo @$errors['team_id']; ?></font></span>
            </li>
            
         <li class="even">
    <label class="field-title">Summary:<font color="red"> <em>*</em></font></label>
                <input type="text" id="issue_summery" size="40" maxlength="50" placeholder="" name="issue_summery"
            value="<?php  if(!$reassing && $_REQUEST['action']=="reassign"){ echo @$_POST['issue_summery']; }?>"/>
            <span class="error"><font color="red">&nbsp;<?php echo @$errors['issue_summery']; ?></font></span>
                <br>
    </li>
    <li class="odd">            
    <label class="field-title"><strong>Details:</strong><font color="red"> <em>*</em></font></label>
                <textarea style="width:100%;" name="message"
                placeholder="Details on the reason(s) for opening the ticket."cols="21" rows="8" 
            style="width:80%;"><?php if(!$reassing && $_REQUEST['action']=="reassign"){ echo @$_POST['message']; }?></textarea>
             <span class="error"><font color="red">&nbsp;<?php echo @$errors['message']; ?></font></span>
              <br>
    </li>
     <li class="odd">        
             
             <div id="t_scents">
             <p>
              <label for="t_scnts">
               <input type="file" name="file[]" size="25" id="t_scnt" />
               <h2><a href="#" id="TaddScnt" ><button class="button">Add Another</button></a></h2>
              <!--<input type="text" id="p_scnt" size="20" name="p_scnt" value="" placeholder="Input Value" />-->
              </label>
            </p>
            <br/>
            </div>
          
     </li>
      <li class="even">         
       <label class="field-title"><strong> Ticket Status:</strong></label>
      <?php $statuses = getTicketStatus();?>
                <select name="status" id="status" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                         <?php while($status = mysql_fetch_object($statuses)){
						 if($status->id!=6){
						 ?>
                          <option value="<?php echo $status->id;?>" <?php echo ($current_status_id==$status->id)? "selected" :""?>>
						   <?php echo $status->name;?></option>
						   
				<?php 
				}
				}?>
                           
           </select>
	 	
	</label> 
    </li>
     <li class="odd">        
    <input type="hidden" name="re_assign" value="1" />
    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id;?>" />
    <input type="hidden" name="status_old" value="<?php echo $status_old; ?>" />
    <input type="hidden" name="current_status" value="<?php echo $current_status_id; ?>" />
    <input type="hidden" name="old_team" value="<?php echo $old_team; ?>" />
	<input type="hidden" name="isoverdue" value="<?php echo $isoverdue; ?>" />
    <input type="hidden" id="new_team" name="new_team" value="" />
    <input type="hidden" name="old_due_date"  value="<?php echo $old_due_date;?>">
    <input type="hidden" name="old_priority_id"  value="<?php echo $old_priority_id; ?>">
		 <a class="button" href="javascript:document.reassign.submit();" >
		 <span>Reassign</span>
		 </a>
     </li>
     </ol>
      </fieldset>
	</form>
     </div>
     
     <div id="change-status" style="display:<?php echo $change_status_display;?>">
          <span class="error"><font color="red">&nbsp;<?php echo @$errors['status']; ?></font></span>
     <form name="change_status" id="change_status" action="" method="post" class="middle-forms cmxform"   onsubmit="" enctype="multipart/form-data">
	 <input type="hidden" name="action" value="change_status">
	   <fieldset>
     <ol>
      <li class="even">         
       <label class="field-title"><strong> Ticket Status:</strong></label>
      <?php $statuses = getTicketStatus();?>
                <select name="status" id="status" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                         <?php while($status = mysql_fetch_object($statuses)){
						 if($status->id!=6){
						 ?>
                          <option value="<?php echo $status->id;?>" <?php echo ($current_status_id==$status->id)? "selected" :""?>>
						   <?php echo $status->name;?></option>
						   
				<?php 
				}
				}?>
                           
           </select>
	 	
	</label> 
    </li>
     <li class="odd">        
   <input type="hidden" name="change_status" value="1" />
    <input type="hidden" name="ticket_id" value="<?php echo $ticket_id;?>" />
    <input type="hidden" name="status_old" value="<?php echo $status_old; ?>" />
    <input type="hidden" name="current_status" value="<?php echo $current_status_id; ?>" />
	<input type="hidden" name="isoverdue" value="<?php echo $isoverdue; ?>" />
    <input type="hidden" name="team_id"  value="<?php echo $old_team_id; ?>">
    <input type="hidden" name="old_due_date"  value="<?php echo $old_due_date;?>">
    <input type="hidden" name="old_priority_id"  value="<?php echo $old_priority_id; ?>">
		 <a class="button" href="javascript:document.change_status.submit();" >
		 <span>Change Status</span>
		 </a>
     </li>
     </ol>
      </fieldset>
	</form>
     </div>
  
</div>

<?php } ?>
    </div>
<script>

$(function() {
        var scntDiv = $('#t_scents');
        var i = $('#t_scents p').size() + 1;
        $('#TaddScnt').live('click', function() {
                $('<p><label for="t_scnts"><input type="file" name="file[]" size="25" id="t_scnt" /></label> <a href="#" id="temScnt"><button class="button">Remove</button></a></p></br>').appendTo(scntDiv);
                i++;
                return false;
        });
        $('#temScnt').live('click', function() { 
                if( i > 2 ) {
                 $(this).parents('p').remove();
                 i--;
                }
                return false;
        });
});

$(function() {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents p').size() + 1;
        $('#addScnt').live('click', function() {
                $('<p><label for="p_scnts"><input type="file" name="file[]" size="25" id="p_scnt" /></label> <a href="#" id="remScnt"><button class="button">Remove</button></a></p></br>').appendTo(scntDiv);
                i++;
                return false;
        });
        $('#remScnt').live('click', function() { 
                if( i > 2 ) {
                 $(this).parents('p').remove();
                 i--;
                }
                return false;
        });
});

		$( document ).ready( function( ) {
			    $( '.tree li' ).each( function() {
						$( this ).toggleClass( 'active' );
						$( this ).children( 'ul' ).slideToggle( 'fast' );
					});
				$( '.tree li' ).each( function() {
						if( $( this ).children( 'ul' ).length > 0 ) {
								$( this ).addClass( 'parent' );     
						}
				});
				
				$( '.tree li.parent > a' ).click( function( ) {
					     
						$( this ).parent().toggleClass( 'active' );
						$( this ).parent().children( 'ul' ).slideToggle( 'fast' );
				});
				
				$( '#all' ).click( function() {
					
					$( '.tree li' ).each( function() {
						$( this ).toggleClass( 'active' );
						$( this ).children( 'ul' ).slideToggle( 'fast' );
					});
				});
				
				$( '.tree li' ).each( function() {
						$( this ).toggleClass( 'active' );
						$( this ).children( 'ul' ).slideToggle( 'fast' );
				});
			
			$('input:radio[name=natures]').change(function(){
				if($(this).attr('data')=='2'){
				 $('#_others').remove();	
				 $(this).parent().append('<input type="text" name="others" id="_others" placeholder="Enter Other Reason" />');	
				}
				});
			$('input:radio[name=products]').change(function(){
				if($(this).attr('data')=='2'){
				 $('#_others').remove();	
				 $(this).parent().append('<input type="text" name="others" id="_others" placeholder="Enter Other Reason" />');	
				}
				});			
				
				
		});


function trackme(){
	var e = document.getElementById("team_id");
    var strUser = e.options[e.selectedIndex].text;
	document.getElementById('new_team').value=strUser;
	//alert(strUser);
	
}
function clickme(){
	//alert(id);
	document.getElementById('post-reply').style.display="block";
	document.getElementById('reassign').style.display="none";
	document.getElementById('change-status').style.display="none";

}
function clickme2(){
	//alert(id);
	document.getElementById('reassign').style.display="block";
	document.getElementById('post-reply').style.display="none";
	document.getElementById('change-status').style.display="none";

}
function clickme3(){
	//alert(id);
	document.getElementById('change-status').style.display="block";
	document.getElementById('reassign').style.display="none";
	document.getElementById('post-reply').style.display="none";
	
}
</script>    
    
<?php include($site_root."includes/footer.php"); ?>

 