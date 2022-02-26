<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php
   if(!$_REQUEST['id']){
     redirect('search_client.php');
     exit;
   }
    $id = $_REQUEST['id'];
    $user = ClientInfo::getUser($id);
	$page_name = "edit_client.php";
	$page_title = "Edit Client";
	$page_level = "4";
	$page_group_id = "1";
	$page_menu_title = "Edit Client";
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
$errors = array();
$cmic_display ="none;";
$uin_display ="none;";
//print_r($_SESSION);
if(!empty($_SESSION['cmid'])){
	$cmic_display ="block;";
	}
if(!empty($_SESSION['uin'])){
	$uin_display ="block;";
	}	
$success="";
if($_POST){
	//print_r($_POST);
  $flage =true;
  if(!$_POST['full_name']){
	  $flage =false;
      $errors['full_name'] = 'Full name required.';
  }
  
  if ($_POST['email']==""){
	  $flage =false;
      $errors['email'] = 'Email is required.';
  }else if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
	    $flage =false;
	    $errors['email'] = 'Email is not valid.';
  }/*else if(ClientInfo::uniqueEmail($_POST['email'])){
	  $flage =false;
	  $errors['email'] = 'Email already exist.';
  }*/
  
  if(!empty($_POST['i_type']) && $_POST['i_type']=="CMID"){
	      $cmic_display ="block;";
           if($_POST['cmid']==""){
			    $flage =false;
               $errors['cmid'] = 'CMID is required.';
           }elseif(!preg_match("/^[0-9]{1,20}$/",$_POST['cmid'])){
			    $flage =false;
               $errors['cmid'] = 'Invalid CMID number.';
           }/*else if(ClientInfo::uniqueCMID($_POST['cmid'])){
			    $flage =false;
	           $errors['cmid'] = 'CMID already exist.';
           } */ 
  }
  if(!empty($_POST['i_type']) && $_POST['i_type']=="UIN"){
	    $uin_display ="block;";
           if(!$_POST['uin']){
			    $flage =false;
               $errors['uin'] = 'UIN is required.';
           }elseif(!preg_match("/^[0-9]{1,20}$/",$_POST['uin'])){
			    $flage =false;
               $errors['uin'] = 'Invalid UIN number.';
           }/*else if(ClientInfo::uniqueUIN($_POST['cmid'])){
			    $flage =false;
	           $errors['uin'] = 'UIN already exist.';
           } */ 
  }
  if(empty($_POST['i_type'])){
	  $flage =false;
	  $errors['i_type'] = 'Identity Type is required.';
	  }
  if(!empty($_POST['is_cnic'])){
	     
           if(!$_POST['cnic']){
			    $flage =false;
               $errors['cnic'] = 'CNIC number is required.';
           }elseif(!preg_match("/^[0-9]{13}$/",$_POST['cnic'])){
			    $flage =false;
               $errors['cnic'] = 'Invalid CNIC number.';
           }/*else if(ClientInfo::uniqueCNIC($_POST['cnic'])){
			    $flage =false;
	           $errors['cnic'] = 'CNIC number already exist.';
           } */ 
  }
  if(!empty($_POST['is_reg_num'])){
	  if(!$_POST['register_num']){
		   $flage =false;
		  $errors['register_num'] = 'Registration number is required.'; 
	  }elseif( !preg_match("/^[0-9]{1,6}$/",$_POST['register_num'])){ 
	      $flage =false;
          $errors['register_num'] = 'Invalid registration number.';
      }/*else if(ClientInfo::uniqueRegisterNum($_POST['register_num'])){
		   $flage =false;
	      $errors['register_num'] = 'Registration number already exist.';
      } */
  
  }
  
  if(!$_POST['phone']){
	   $flage =false;
      $errors['phone'] = 'Contact number is required.';
  }elseif(!preg_match("/^[0-9]{11}$/",$_POST['phone'])){
	   $flage =false;
       $errors['phone'] = 'Invalid Contact number.';
  }
   
  if($flage==true){
  	  if($res = ClientInfo::editClient($_POST)){
		  if($res['success']==true){
					redirect('view_client.php?id='.$_POST['client_id'].'&msg=Client info has been updated successfully.'); 
				 }else{
				  $errors['msg'] = 'Client not updated something went wrong.';
			     }
       }

  }
  
}

 ?>

	<div class="box">
		<h4 class="white"><?php echo($page_title); ?> </h4>
        <div class="box-container">
        <?php if(isset($_REQUEST['msg']) || isset($errors['msg'])){?>
      <div id="message-red">
          <table border="0" width="100%" cellpadding="0" cellspacing="0">
          <tr>
          <td class="red-left"><?php echo isset($_REQUEST['msg'])? $_REQUEST['msg'] : @$errors['msg']; ?></td>
          <td class="red-right"><a class="close-red"><img src="images/icon_close_red.gif" alt="" /></a></td>
          </tr>
          </table>
      </div>
        
        <?php } ?>
            <form class="middle-forms cmxform" name="xForm" id="xForm" method="post" action="" >
					<fieldset>
                     <ol>
                  <input type="hidden" id="_client_id" name="client_id" value="<?php echo $_REQUEST['id'];?>">

                        <li class="even">
							<label class="field-title">Full Name:<font color="red"> <em>*</em></font></label>
							<input type="text" id="_full_name" size="40" maxlength="64" placeholder="Full Name" name="full_name" value="<?php echo (@$_POST['full_name']) ? @$_POST['full_name']: $user->name; ?>">

                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['full_name']; ?></font></span>

						</li>
                        <li class="even">
							<label class="field-title">Email Address<font color="red"> <em>*</em></font>:</label>
							<input type="text" id="_email" size="40" maxlength="64" placeholder="name@domain.com" name="email" value="<?php echo (@$_POST['email'])?@$_POST['email']:$user->email;?>">

                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['email']; ?></font></span>

						</li>
                          <li class="even">
							<label class="field-title">CNIC Number:<font color="red"> <em>*</em></font></label>
							<input type="text" id="_cnic" size="40" maxlength="64" placeholder="4310196424576" name="cnic" value="<?php echo isset($_POST['cnic'])? $_POST['cnic']:$user->cnic;?>">
                             <input type="hidden" name="is_cnic" value="yes" />
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['cnic']; ?></font></span>
						</li> 
                       <li class="even">
                        <label class="field-title">Identity Type:<font color="red"> <em>*</em></font></label>
                        <select name="i_type" id="_i_type">
                            <option value="">&mdash; Select Identity Type &mdash;</option>
                            <option value="CMID" <?php echo (@$_POST['i_type']=="CMID" || $user->cmid!="")? "selected":"";?>>CMID</option>
                            <option value="UIN"  <?php echo (@$_POST['i_type']=="UIN"  || $user->uin!="")? "selected":"";?>>UIN</option>
                        </select>
                        <br>
                        <span class="error"><font color="red">&nbsp;<?php echo @$errors['i_type']; ?></font></span>
                        </li>
                         <?php if($user->cmid!=""){ $cmic_display ="block;";} ?>
                         <?php if($user->uin!=""){  $uin_display ="block;";} ?>
                         <li class="even" id="cmid" style="display:<?php echo $cmic_display;?>">
							<label class="field-title">CMID:<font color="red"> <em>*</em></font></label>
							<input id="_cmid" type="text" name="cmid" placeholder="max 20 digits" value="<?php echo isset($_POST['cmid'])? $_POST['cmid']:$user->cmid;?>">
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['cmid']; ?></font></span>

						</li>
                         <li  class="even" id="uin" style="display:<?php echo $uin_display;?>">
							<label class="field-title">UIN:<font color="red"> <em>*</em></font></label>
							<input id="_uin" type="text" name="uin"  placeholder="max 20 digits" value="<?php echo isset($_POST['uin'])? $_POST['uin']:$user->uin;?>">
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['uin']; ?></font></span>
						</li>
                          <li class="even">
							<label class="field-title">Contact Number:<font color="red"> <em>*</em></font></label>
							<input id="_phone" type="text" name="phone" placeholder="3322743942" value="<?php echo isset($_POST['phone'])? $_POST['phone']:$user->phone;?>">
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['phone']; ?></font></span>
						</li>
					</ol>
					<p class="align-right">
					<a id="btn_submit" class="button" href="javascript:document.xForm.submit();" 
                    onclick="javascript:document.xForm.submit();"><span>Submit</span></a>
					</p>
				</fieldset>

			</form>
 		</div>
    </div>
<?php include($site_root."includes/footer.php"); ?>
<script type="text/javascript">
	$(document).ready(function(e) {
		$("#_i_type").change(function(eve){
		 val = $(this).val();
		 if(val=='CMID'){
			 $("#uin").hide();
			 $("#cmid").show();
		 }
		 if(val=='UIN'){
			 $("#uin").show();
			 $("#cmid").hide();
		 }
		 if(val==''){
			 $("#uin").hide();
			 $("#cmid").hide();
		 }
		 	
		});
	});
</script>

 