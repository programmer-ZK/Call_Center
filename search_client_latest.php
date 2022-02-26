<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php

	$page_name = "search_client.php";
	$page_title = "Search Client";
	$page_level = "3";
	$page_group_id = "1";
	$page_menu_title = "Search Client";
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


<?php 
 
if(isset($_SESSION['cnic'])){
	unset($_SESSION['cnic']);
	}
if(isset($_SESSION['register_num'])){
	unset($_SESSION['register_num']);
	}
if(isset($_SESSION['cmid'])){
	unset($_SESSION['cmid']);
	}
if(isset($_SESSION['uin'])){
	unset($_SESSION['uin']);
	}	
	
$errors = array();
$success="";

if($_POST){

 
  if ($_POST['search']==""){
      $errors['search'] = 'Search Number is required.';
  }elseif($_POST['type']==""){
      $errors['type'] = 'Search type is required.';
  }/*elseif(!preg_match("/^[0-9]{1,20}$/",$_POST['search'])){
      $errors['search'] = 'Invalid search number.';
  }*/else{
	  if($_POST['type']=='cnic'){
		$res= ClientInfo::searchUserByCNIC($_POST);
		  if($res['exist']==true){
		      redirect('view_client.php?id='.$res['id']); 
		    }else{
				$_SESSION['cnic'] = $_POST['search'];
				redirect('create_client.php?msg=Client not found with this CNIC create new one.'); 
		      //$errors['type'] = 'Client not found with this CNIC.';
		   }
	   }elseif($_POST['type']=='cmid'){
		$res= ClientInfo::searchUserByCMID($_POST);
		  if($res['exist']==true){
		      redirect('view_client.php?id='.$res['id']); 
		    }else{
				$_SESSION['cmid'] = $_POST['search'];
				redirect('create_client.php?msg=Client not found with this CMID create new one.'); 
		      //$errors['type'] = 'Client not found with this CNIC.';
		   }
	   }elseif($_POST['type']=='uin'){
		$res= ClientInfo::searchUserByUIN($_POST);
		  if($res['exist']==true){
		      redirect('view_client.php?id='.$res['id']); 
		    }else{
				$_SESSION['uin'] = $_POST['search'];
				redirect('create_client.php?msg=Client not found with this UIN create new one.'); 
		      //$errors['type'] = 'Client not found with this CNIC.';
		   }
	   }elseif($_POST['type']=='ticket_number'){
	   $res= ClientInfo::searchUserByTicketNumber($_POST);
		   if($res['exist']==true){
				  redirect('view_client.php?id='.$res['id']); 
				}else{
				  $errors['type'] = 'Client not found with this ticket number.';
			   }
	   }elseif($_POST['type']=='client_name'){
	   $res= ClientInfo::searchClientByName($_POST);
	       if($res['exist']==true){
				  //redirect('view_client.php?id='.$res['id']); 
				}else{
				  $_SESSION['client_name'] = $_POST['search'];	
				  redirect('create_client.php?msg=Client not found with this name create new one.'); 	
			   }
	   
	  }else if($_POST['type']=='phone'){
		  //searchUserByContact($info_r);
		  $res= ClientInfo::searchUserByContact($_POST);
	      if($res['exist']==true){
				  redirect('view_client.php?id='.$res['id']); 
				}else{
				  $_SESSION['contact'] = $_POST['search'];	
				  redirect('create_client.php?msg=Client not found with this contact number create new one.'); 	
				  //$errors['error'] = 'Client not found with this registration number.';
			   }
		  
	  }
      //$res= ClientInfo::searchUserByPhone($_POST);
	  // print_r($res); 
	   //die;
      /*if($res['exist']==true){
       redirect('view_client.php?id='.$res['id']); 
      }else{
       redirect('create_client.php?id='.$res['id']);
      }*/
    }  
        
  }
 ?>

	<div class="box">
		<h4 class="white"><?php echo($page_title); ?> <span style="margin-left: 300px;">
        <a href="create_client.php" class="" role="" >
        <span>Create Client</span></a></span></h4></a>
        <?php //$data = mysql_fetch_object($res['result']); print_r($data);?>
        <div class="box-container">
        <table  class="table-short">
        <?php while($data = mysql_fetch_object($res['result'])){ ?>
          <tr>
             <td class="col-head2"><a style="color:blue;" href="view_client.php?id=<?php echo $data->id; ?>"><?php echo $data->name;?></a></td>
            <td class="col-head2"><?php echo preg_replace('~.*(\d{5})[^\d]*(\d{7})[^\d]*(\d{1}).*~', 
                '$1-$2-$3'." \n",$data->cnic);?></td>
            <td class="col-head2"><?php echo ($data->phone)?preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', 
                '($1) $2-$3'." \n",$data->phone) :$data->phone;?></td>
          </tr>
          <?php } ?>
        </table>
  </div>
        <div class="box-container">
        <span class="error"><font color="red">&nbsp;<?php echo @$errors['error']; ?></font></span>
			<form class="middle-forms cmxform" name="xForm" id="xForm" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" >
				<fieldset>
					<h3><?php //echo($page_title); ?></h3>
					<!--<input type="hidden" id="user_id" name="user_id" value="<?php //echo $_SESSION[$db_prefix.'_UserId'];?>"/>-->
					<ol>
                    	<li class="even">
							<label class="field-title">Enter Number:<font color="red"> <em>*</em></font>:</label>
							<input id="_search" type="text" pattern="[0-9]+" placeholder="Numbers Only" name="search" style="width: 275px;" value="<?php echo @$_POST['search'];?>"> <?php /*?>Ext:
                            <input type="text" name="phone-ext" value="<?php echo @$_POST['phone-ext'];?>" size="5"><?php */?>
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['search']; ?></font></span>

						</li>
                        <li class="even">
                            <label class="field-title">Search By<font color="red"> <em>*</em></font>:</label>
                            <label for="_cnic"> <input type="radio" id="_cnic" name="type" value="cnic"  <?php echo (@$_POST['type']=='cnic')?'checked':"";?>/>CNIC</label>
                            <label for="_phone"> <input type="radio" id="_phone" name="type" value="phone"  <?php echo (@$_POST['type']=='phone')?'checked':"";?>/>Contact</label>
                            <label for="_cmid"> <input type="radio" id="_cmid" name="type" value="cmid"  <?php echo (@$_POST['type']=='cmid')?'checked':"";?>/>CMID</label>
                            <label for="_uin"> <input type="radio" id="_uin" name="type" value="uin"  <?php echo (@$_POST['type']=='uin')?'checked':"";?>/>UIN</label>
							
                            <label for="_ticket_number"><input type="radio"  id="_ticket_number" name="type" value="ticket_number" <?php echo (@$_POST['type']=='ticket_number')?'checked':"";?> />Ticket Number</label>
                            <label for="_client_name"><input type="radio" id="_client_name" name="type" onchange="client_name();" value="client_name" <?php echo (@$_POST['type']=='client_name')?'checked':"";?>/>Client Name</label> 
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['type']; ?></font></span>
						</li>
					</ol>
					<p class="align-right">
						<a id="btn_submit" class="button" href="javascript:document.xForm.submit();" onclick="javascript:document.xForm.submit();"><span>Submit</span></a>
						<!--<input type="hidden" value="Submit" name="new_customer" id="new_customer" />-->
					</p>
				</fieldset>

			</form>
 		</div>
    </div>
   <script>
   $('document').ready(function(e) {
    $('input[type=radio]').change(function(){
		if($(this).attr('id')=="_client_name"){
			$('#_search').attr('pattern','[a-zA-Z]+');
			}else{
			$('#_search').attr('pattern','[0-9]+');
			}
		
		});
});
   
   </script> 
<?php include($site_root."includes/footer.php"); ?>

