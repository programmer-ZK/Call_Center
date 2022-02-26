<?php 
/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);*/

ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');
include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php
   if(!$_REQUEST['uid']){
     redirect('search_client.php');
     exit;
}
	$page_name = "create_ticket.php";
	$page_title = "Create Ticket";
	$page_level = "4";
	$page_group_id = "1";
	$page_menu_title = "Create Ticket";
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
	
     if(count($_FILES)>0){
		// Loop $_FILES to exeicute all files
		foreach ($_FILES['file']['name'] as $f => $name) { 
		    if($_FILES['file']['name'][$f] !="")  { 
			if ($_FILES['file']['error'][$f] == 4) {
				continue; // Skip file if any error found
			}	       
			if ($_FILES['file']['error'][$f] == 0) {	           
				//if ($_FILES['file']['size'][$f] > $max_file_size) {
					//return  "long";
					//continue; // Skip large files
				//}
				//else
					
				//if( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				//	return  "invalid";
					//continue; // Skip invalid file formats
				//}
				//else{ // No error found! Move uploaded files 
				    $num =  mt_rand(100000, 999999);
					$name = $num.$name;
					$name = str_replace(' ', '_', $name);
					if(move_uploaded_file($_FILES["file"]["tmp_name"][$f],$path.$name)){
						 $info = array('size'=>$_FILES['file']['size'][$f],'type'=>$_FILES["file"]["type"][$f],'name'=>$name);
						 $file_ids[] = ClientInfo::uploadFile($info); 
						// $message[] = "$name has been uplaoded.";
					     $count++; // Number of successfully uploaded file
					}
					
				//}
			}
		}
		
	 }
	}
    return $file_ids;
}			
			
	

?>
<!-- <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>-->

<?php include($site_root."includes/header.php"); ?>
<?php 
$id = $_REQUEST['uid'];
$user = ClientInfo::getUser($id);
$errors = array();
$success="";
$flag =true;
if($_POST){
//print_r($_POST);
//die;	
$count = 0;
   $file_ids = uploadfile();
   if($file_ids=="long"){
	   $file_error ="File is too long.";
	   $flag = false;
	  }elseif($file_ids=="invalid"){
		  $flag = false;
		  $file_error ="File type is not valid.";
	  }
//print_r($file_ids);
//die;	  
	  
  if($_POST['duedate']==""){
	  $_POST['duedate'] = date("Y-m-d H:i:s");
  }else{
	  $_POST['duedate'] = $_POST['duedate'];   //.' '.$_POST['time'].':00';
	  }
  if(!$_POST['team_id']){
      $errors['team_id'] =  'Team is required.';
  }elseif(!trim($_POST['issue_summery'])){
      $errors['issue_summery'] = 'Issue summery is required.';
  }elseif(!trim($_POST['message'])){
      $errors['message'] = 'Issue detail is required.';
  }else{
	  if($flag==true){  
	   switch($_POST['a']) {
            case 'open':
			if($_POST['priority_level']){
		       $p_desc = getPriorityById($_POST['priority_level']);
	           $_POST['priority_desc'] = $p_desc->priority_desc; 
		      }
			  $_POST['source'] = 'Phone';
			  $_POST['topicId'] = '10';
			  $lastt_id =  ClientInfo::getlastTicketId();
			  $length=7;
			  if(count($lastt_id)>0){
			   $new =  strlen($lastt_id['ticket_id']+1);
			   $length = ($length-$new);
			   $zeros = generatezero($length);
			   $next_number = $zeros.($lastt_id['ticket_id']+1);
			  }else{
			   $zeros = generatezero($length);
			   $next_number = $zeros.'1';
			  }
			  $_POST['number'] =  (string) $next_number;
	          //$_POST['number']=  mt_rand(100000, 999999);
			  $_POST['poster'] = $_SESSION[$db_prefix.'_UserName'];
			  //print_r($_SESSION[$db_prefix.'_UserId']);
              $agent_id = $_SESSION[$db_prefix.'_UserId'];
              $unique_id = $admin->get_call_unique_id($agent_id);
			  $getdept = getDepartIdByTeamId($_POST['team_id']);
			  $_POST['deptId'] = $getdept->dept_id;
			  //die('here');
			  if(!empty($unique_id->fields)){
				   $_POST['unique_id'] = $unique_id->fields['unique_id'];
				  }else{
				   $_POST['unique_id'] = "(NULL)";
				 }
				 $_POST['who_created'] = $agent_id;
	            $return = ClientInfo::createTicket($_POST);
			   if($return){
				   if($file_ids){
					   foreach($file_ids as $file_id){
						   echo 'file_id'. $file_id;
						    ClientInfo::ticket_attachment($return,$file_id);
						 }
					   }
				  
				   redirect('view_client.php?id='.$id.'&msg=Ticket has been created successfully');
				   //$success="Ticket has been created successfully.";
			   }
		  break;
	   }
	}  // flag 
	   
  	  /*if($id = ClientInfo::UpdateUser($_POST)){
       redirect('user-view.php?id='.$id);
    }*/
  }
}


?>

<div class="box">
  <?php if($success!=""){?>
  <div id="message-green">
    <table border="0" width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td class="green-left"><?php echo $success;?></td>
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
  <h4 class="white"><?php echo($page_title); ?> </h4>
  <form class="middle-forms cmxform" name="xForm" id="xForm" method="post"
             action="<?php  echo $_SERVER['PHP_SELF']."?uid=".$_REQUEST['uid']?>" enctype="multipart/form-data" >
    <input type="hidden" name="do" value="create">
    <input type="hidden" name="a"  value="open">
    <?php if(isset($_REQUEST['uid'])){?>
    <h4 class="white">Client Information </h4>
    <div class="box-container">
      <table  class="table-short" >
        <tbody>
          <tr>
            <td>Client Name:</td>
            <td><div id="user-info">
              <input type="hidden" name="uid" id="uid" value="<?php echo $_REQUEST['uid'];?>" />
              <?php echo $user->name;?></td>
          </tr>
          <tr>
            <td>Client Email:</td>
            <td><div id="user-info">
              <?php echo $user->email;?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <?php }else{ ?>
    <ol>
      <li class="odd">
        <?php $users = ClientInfo::getUsers(); ?>
        <label class="field-title">Client: <font color="red"> <em>*</em></font></label>
        <select name="uid">
          <option value="">&mdash; Select Client &mdash;</option>
          <?php while($usr = mysql_fetch_object($users)){ ?>
          <option value="<?php echo $usr->id;?>" <?php echo  (@$_POST['uid']==$usr->id)? "selected" :""?>> <?php echo $usr->name;?></option>
          <?php }?>
        </select>
      </li>
    </ol>
    <?php } ?>
    <h4 class="white">Ticket Information and Options </h4>
    <div class="box-container">
      <fieldset>
        <ol>
          <?php /*?><li class="even">
				<label class="field-title">Ticket Source:</label>
                <select name="source">
                    <option value="Phone" <?php (@$_POST['source']=="Phone")? "selected":"";?>>Phone</option>
                    <option value="Email" <?php (@$_POST['source']=="Email")? "selected":"";?>>Email</option>
                    <option value="Other" <?php (@$_POST['source']=="Other")? "selected":"";?>>Other</option>
                </select>
                <br>
                <span class="error"><font color="red">&nbsp;<?php echo @$errors['source']; ?></font></span>
			     </li><?php */?>
          <?php /*?> <li class="odd">
				<label class="field-title">Help Topic: <font color="red"> <em>*</em></font></label>
            <?php $topics = helptopic();?>
                <select name="topicId">
                <option value="">&mdash; Select Help Topic &mdash;</option>
                <?php while($topic = mysql_fetch_object($topics)){ ?>
                <option value="<?php echo $topic->topic_id;?>" <?php echo  (@$_POST['topicId']==$topic->topic_id)? "selected" :""?>><?php echo $topic->topic;?></option>
				<?php }?>       
                </select>
                <br>
                <span class="error"><font color="red">&nbsp;<?php echo @$errors['topicId']; ?></font></span>
            </li><?php */?>
          <?php /*?> <li class="even">
              <label class="field-title">Department:<font color="red"> <em>*</em></font></label>
             <?php $deptts = getDept();?>
                <select name="deptId">
                 
                  <option value="">&mdash; Select Department&mdash;</option>
                   <?php while($deptt = mysql_fetch_object($deptts)){?>
                <option value="<?php echo $deptt->dept_id;?>" <?php echo  (@$_POST['deptId']==$deptt->dept_id)? "selected" :""?>><?php echo $deptt->dept_name;?></option>
				<?php }?>
                    </select>
                <br>
                <span class="error"><font color="red">&nbsp;<?php echo @$errors['deptId']; ?></font></span>
            </li>
            <?php */?>
          <li class="even">
            <label class="field-title">Team/Group:<font color="red"> <em>*</em></font></label>
            <?php $teams = getTeam();?>
            <select name="team_id">
              <option value="">&mdash; Select Team&mdash;</option>
              <?php while($team = mysql_fetch_object($teams)){?>
              <option value="<?php echo $team->team_id;?>" <?php echo  (@$_POST['team_id']==$team->team_id)? "selected" :""?>><?php echo $team->name;?></option>
              <?php }?>
            </select>
            <br>
            <span class="error"><font color="red">&nbsp;<?php echo @$errors['team_id']; ?></font></span> </li>
          <li class="odd">
            <label class="field-title">Due Date:</label>
            <input style="width: 180px;" id="fdate" name="duedate" value="<?php echo @$_POST['duedate'];?>" size="12"  
                class="txtbox-short-date" autocomplete="off" readonly 
                onclick="javascript:NewCssCal ('fdate','yyyyMMdd', 'dropdown',true,24,true,'future')">
            &nbsp;&nbsp;
           <!-- <select name="time" id="time">
              <option value="" selected>Time</option>
              <option value="23:45" >11:45 PM</option>
              <option value="23:30" >11:30 PM</option>
              <option value="23:15" >11:15 PM</option>
              <option value="23:00" >11:00 PM</option>
              <option value="22:45" >10:45 PM</option>
              <option value="22:30" >10:30 PM</option>
              <option value="22:15" >10:15 PM</option>
              <option value="22:00" >10:00 PM</option>
              <option value="21:45" >09:45 PM</option>
              <option value="21:30" >09:30 PM</option>
              <option value="21:15" >09:15 PM</option>
              <option value="21:00" >09:00 PM</option>
              <option value="20:45" >08:45 PM</option>
              <option value="20:30" >08:30 PM</option>
              <option value="20:15" >08:15 PM</option>
              <option value="20:00" >08:00 PM</option>
              <option value="19:45" >07:45 PM</option>
              <option value="19:30" >07:30 PM</option>
              <option value="19:15" >07:15 PM</option>
              <option value="19:00" >07:00 PM</option>
              <option value="18:45" >06:45 PM</option>
              <option value="18:30" >06:30 PM</option>
              <option value="18:15" >06:15 PM</option>
              <option value="18:00" >06:00 PM</option>
              <option value="17:45" >05:45 PM</option>
              <option value="17:30" >05:30 PM</option>
              <option value="17:15" >05:15 PM</option>
              <option value="17:00" >05:00 PM</option>
              <option value="16:45" >04:45 PM</option>
              <option value="16:30" >04:30 PM</option>
              <option value="16:15" >04:15 PM</option>
              <option value="16:00" >04:00 PM</option>
              <option value="15:45" >03:45 PM</option>
              <option value="15:30" >03:30 PM</option>
              <option value="15:15" >03:15 PM</option>
              <option value="15:00" >03:00 PM</option>
              <option value="14:45" >02:45 PM</option>
              <option value="14:30" >02:30 PM</option>
              <option value="14:15" >02:15 PM</option>
              <option value="14:00" >02:00 PM</option>
              <option value="13:45" >01:45 PM</option>
              <option value="13:30" >01:30 PM</option>
              <option value="13:15" >01:15 PM</option>
              <option value="13:00" >01:00 PM</option>
              <option value="12:45" >12:45 PM</option>
              <option value="12:30" >12:30 PM</option>
              <option value="12:15" >12:15 PM</option>
              <option value="12:00" >12:00 PM</option>
              <option value="11:45" >11:45 AM</option>
              <option value="11:30" >11:30 AM</option>
              <option value="11:15" >11:15 AM</option>
              <option value="11:00" >11:00 AM</option>
              <option value="10:45" >10:45 AM</option>
              <option value="10:30" >10:30 AM</option>
              <option value="10:15" >10:15 AM</option>
              <option value="10:00" >10:00 AM</option>
              <option value="09:45" >09:45 AM</option>
              <option value="09:30" >09:30 AM</option>
              <option value="09:15" >09:15 AM</option>
              <option value="09:00" >09:00 AM</option>
              <option value="08:45" >08:45 AM</option>
              <option value="08:30" >08:30 AM</option>
              <option value="08:15" >08:15 AM</option>
              <option value="08:00" >08:00 AM</option>
              <option value="07:45" >07:45 AM</option>
              <option value="07:30" >07:30 AM</option>
              <option value="07:15" >07:15 AM</option>
              <option value="07:00" >07:00 AM</option>
              <option value="06:45" >06:45 AM</option>
              <option value="06:30" >06:30 AM</option>
              <option value="06:15" >06:15 AM</option>
              <option value="06:00" >06:00 AM</option>
              <option value="05:45" >05:45 AM</option>
              <option value="05:30" >05:30 AM</option>
              <option value="05:15" >05:15 AM</option>
              <option value="05:00" >05:00 AM</option>
              <option value="04:45" >04:45 AM</option>
              <option value="04:30" >04:30 AM</option>
              <option value="04:15" >04:15 AM</option>
              <option value="04:00" >04:00 AM</option>
              <option value="03:45" >03:45 AM</option>
              <option value="03:30" >03:30 AM</option>
              <option value="03:15" >03:15 AM</option>
              <option value="03:00" >03:00 AM</option>
              <option value="02:45" >02:45 AM</option>
              <option value="02:30" >02:30 AM</option>
              <option value="02:15" >02:15 AM</option>
              <option value="02:00" >02:00 AM</option>
              <option value="01:45" >01:45 AM</option>
              <option value="01:30" >01:30 AM</option>
              <option value="01:15" >01:15 AM</option>
              <option value="01:00" >01:00 AM</option>
              <option value="00:45" >12:45 AM</option>
              <option value="00:30" >12:30 AM</option>
              <option value="00:15" >12:15 AM</option>
              <option value="00:00" selected="selected">12:00 AM</option>
            </select>-->
            <?php /*?> <br>
                <span class="error"><font color="red">&nbsp;<?php echo @$errors['duedate']; ?></font></span><?php */?>
          </li>
        </ol>
      </fieldset>
    </div>
    <h4 class="white"><em><strong>Ticket Details</strong>:
      Please Describe Your Issue</em> </h4>
    <div class="box-container">
      <fieldset>
        <ol>
          <li class="even">
            <label class="field-title">Issue Summary:<font color="red"> <em>*</em></font></label>
            <input type="text" id="issue_summery" size="60" placeholder="" name="issue_summery"
            value="<?php echo @$_POST['issue_summery'];?>"/>
            <br>
            <span class="error"><font color="red">&nbsp;<?php echo @$errors['issue_summery']; ?></font></span> </li>
          <li class="odd">
            <label class="field-title"><strong>Issue Details:</strong><font color="red"> <em>*</em></font></label>
            <textarea style="width:100%;" name="message"
                placeholder="Details on the reason(s) for opening the ticket."cols="21" rows="8" style="width:80%;"><?php echo @$_POST['message'];?></textarea>
            <br>
            <span class="error"><font color="red">&nbsp;<?php echo @$errors['message']; ?></font></span> </li>
          <li class="even">
            <?php $priorities = getPriority();?>
            <label class="field-title"><strong> Priority Level:</strong></label>
            <select name="priority_level" id="priority_level" data-prompt="Select">
             <!-- <option value="">&mdash; Select &mdash;</option>-->
              <?php while($priority = mysql_fetch_object($priorities)){?>
              <option value="<?php echo $priority->priority_id;?>" <?php echo (@$_POST['priority_level']==$priority->priority_id)? "selected" :""?>> <?php echo $priority->priority_desc;?></option>
              <?php }?>
            </select>
          </li>
          
          <!--<li class="odd">
				<label class="field-title"><strong> Internal Note:</strong></label>
                <textarea class="richtext ifhtml draft draft-delete"
                 placeholder="Optional internal note (recommended on assignment)." 
                 name="note" cols="21" rows="6" style="width:100%;"><?php //echo @$_POST['note'];?></textarea>
			  </li>-->
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
             
            <?php /*?><div id='TextBoxesGroup'>
              <div id="TextBoxDiv1">
                <input type="file" name="file[]" size="25" required />
                <h2><a href="#" id="addScnt">Add Another Input Box</a></h2>
                <!--<input type="file" name="file[]" size="25" required />   -->
              </div>
            </div><?php */?>
            <!--<div id="load" style="text-align:center; display:none"> <img src="../images/loading.gif" style="height: 30px;"></div>
             <div id="result2"></div> </br>
             <input type='button' value='Add File'  onclick="myFunction();" id='addButton' style="padding: 5px 10px; background: #04752C; color: #FFFFFF; border: none; width:auto;">
             <input type='button' value='Remove File' id='removeButton' style="padding: 5px 10px; background: #04752C; color: #FFFFFF; border: none; width:auto;">
</div>
-->

          <li class="even">
            <?php $products = getProductNature('0'); ?>
            <label class="field-title"><strong> Products:</strong></label>
            <select name="products" id="products" data-prompt="Select">
              <option data="" value="">&mdash; Select Product &mdash;</option>
              <?php while($product = mysql_fetch_object($products)){ ?>
              <option data="<?php echo $product->id;?>" value="<?php echo $product->p_title;?>" <?php echo (@$_POST['products']==$product->p_title)? "selected" :""?>> <?php echo $product->p_title;?></option>
              <?php }?>
            </select>
          </li>
          <li class="even">
            <?php //$products = getProductNature('0'); ?>
            <label class="field-title"><strong> Natures:</strong></label>
            <select name="natures" id="natures" data-prompt="Select">
              <option data="" value="">&mdash; Select Natures &mdash;</option>
            </select>
          </li>
          </li>
          <?php /*?><li class="even">
            
            <div id="pgtitle"> </div>
            <div id="wrapper">
              <div class="tree"> 
                <!--<button id="all">Toggle All</button>-->
                <ul>
                 <?php $products = getProductNature('0'); ?>
                 <?php while($product = mysql_fetch_object($products)){ ?>
                  <li style="padding: 2px;"><a><input type="radio" data="<?php echo $product->p_value;?>" name="products"  value="<?php echo $product->p_title;?>" <?php echo (@$_POST['products']==$product->p_title)? "checked" :""?>/><?php echo $product->p_title;?></a>
         
                  <?php $natures = getProductNature($product->id); ?>
                    <ul>
                   <?php while($nature = mysql_fetch_object($natures)){ ?>
                      <li style="padding: 2px;"><a><input type="radio" data="<?php echo $nature->p_value;?>" name="natures"  value="<?php echo $nature->p_title;?>" <?php echo (@$_POST['natures']==$nature->p_title)? "checked" :""?>/><?php echo $nature->p_title;?></a>
							
                      </li>
                   <?php } ?> 
                    </ul>
                  </li>
                 <?php } ?>
                 </ul>
                  
              </div>
            </div>
          </li>
        </ol><?php */?>
        <p class="align-right"> <a id="btn_submit" class="button" href="javascript:document.xForm.submit();" 
                        onclick="javascript:document.xForm.submit();"><span>Submit</span></a> 
          <!--<input type="hidden" value="Submit" name="new_customer" id="new_customer" />--> 
        </p>
      </fieldset>
    </div>
  </form>
</div>
<!--<script src="http://code.jquery.com/jquery-1.7.2.min.js" type="text/javascript" > </script> -->
<script type="application/javascript">
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

	/*	$( document ).ready( function( ) {
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
				
				
		});*/
        


$(document).ready(function(e) {
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
 $('#natures').change(function(){
	 
	  var html = $('option:selected', this).attr('text');
	  //alert(html);
	  if(html=="Others"){
		 $('#_others').remove();	 
		$(this).parent().append('<input type="text" name="others" id="_others" placeholder="Enter Other Reason" />');	
	  }else{
		$('#_others').remove();	  
	  }
 });
 
    $('#products').change(function(){
		
		 //var products = $(this).attr('selectedIndex');
		 var products = $('option:selected', this).attr('data');
		// alert(products);
            $.ajax({
                type: "POST",
                data: {products: products},
                url: 'getproduct_nature.php',
                dataType: 'json',
                success: function(json) {
					//alert(json);
					//json = JSON.parse(json);
                    var $el = $("#natures");
                    $el.empty(); // remove old options
                    $el.append($("<option></option>")
                            .attr("value", '').text('Select Nature'));
                    $.each(json.natures, function(value, key) {
						//alert(key.value);
                        $el.append($("<option></option>")
                                .attr("value", key.value).text(key.value));
                    });													
                }
            });
		
		
    });
});

</script>
<?php include($site_root."includes/footer.php"); ?>
