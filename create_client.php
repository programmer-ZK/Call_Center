<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php
   /*if(!$_REQUEST['id']){
     redirect('search_client.php');
     exit;
}*/
	$page_name = "create_client.php";
	$page_title = "Create Client";
	$page_level = "4";
	$page_group_id = "1";
	$page_menu_title = "Create Client";
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
  if(!trim($_POST['full_name'])){
	  $flage =false;
      $errors['full_name'] = 'Full name required.';
  }
  
 /* if ($_POST['email']==""){
	  $flage =false;
      $errors['email'] = 'Email is required.';
  }else if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
	    $flage =false;
	    $errors['email'] = 'Email is not valid.';
  }else if(ClientInfo::uniqueEmail($_POST['email'])){
	  $flage =false;
	  $errors['email'] = 'Email already exist.';
  }*/
  if (trim($_POST['email'])!=""){
	  if(!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
			$flage =false;
			$errors['email'] = 'Email is not valid.';
	  }
	 // if(ClientInfo::uniqueEmail($_POST['email'])){
	 // $flage =false;
	 // $errors['email'] = 'Email already exist.';
     // }
 }
  if(!empty($_POST['i_type']) && $_POST['i_type']=="CMID"){
	      $cmic_display ="block;";
          /* if($_POST['cmid']==""){
			    $flage =false;
               $errors['cmid'] = 'CMID is required.';
           }elseif(!preg_match("/^[0-9]{1,20}$/",$_POST['cmid'])){
			    $flage =false;
               $errors['cmid'] = 'Invalid CMID number.';
           }else if(ClientInfo::uniqueCMID($_POST['cmid'])){
			    $flage =false;
	           $errors['cmid'] = 'CMID already exist.';
           }  */
		  if(trim($_POST['cmid'])!=""){
		  if(!preg_match("/^[0-9]{1,20}$/",$_POST['cmid'])){
			    $flage =false;
               $errors['cmid'] = 'Invalid CMID number.';
           }
		  if(ClientInfo::uniqueCMID($_POST['cmid'])){
			    $flage =false;
	           $errors['cmid'] = 'CMID already exist.';
           } 
			 
           } 
		   
		   
		   
  }
  
  if(!empty($_POST['i_type']) && $_POST['i_type']=="UIN"){
	    $uin_display ="block;";
          /* if(!$_POST['uin']){
			    $flage =false;
               $errors['uin'] = 'UIN is required.';
           }elseif(!preg_match("/^[0-9]{1,20}$/",$_POST['uin'])){
			    $flage =false;
               $errors['uin'] = 'Invalid UIN number.';
           }else if(ClientInfo::uniqueUIN($_POST['cmid'])){
			    $flage =false;
	           $errors['uin'] = 'UIN already exist.';
           }  */
		  if(trim($_POST['uin'])!=""){
		    if(!preg_match("/^[0-9]{1,20}$/",$_POST['uin'])){
			    $flage =false;
               $errors['uin'] = 'Invalid UIN number.';
           }
		   if(ClientInfo::uniqueUIN($_POST['cmid'])){
			    $flage =false;
	           $errors['uin'] = 'UIN already exist.';
           } 
			   
           } 
		   
  }
  
  /*if(empty($_POST['i_type'])){
	  $flage =false;
	  $errors['i_type'] = 'Identity Type is required.';
	  }*/
   	  
  if(trim($_POST['cnic'])!=""){
  
          /* if(!$_POST['cnic']){
			    $flage =false;
               $errors['cnic'] = 'CNIC number is required.';
           }else*/
		   if(!preg_match("/^[0-9]{13}$/",$_POST['cnic'])){
			    $flage =false;
               $errors['cnic'] = 'Invalid CNIC number.';
           }else if(ClientInfo::uniqueCNIC($_POST['cnic'])){
			    $flage =false;
	           $errors['cnic'] = 'CNIC number already exist.';
           }  
  }
 /* if(!empty($_POST['is_reg_num'])){
	  if(!$_POST['register_num']){
		   $flage =false;
		  $errors['register_num'] = 'Registration number is required.'; 
	  }elseif( !preg_match("/^[0-9]{1,6}$/",$_POST['register_num'])){ 
	      $flage =false;
          $errors['register_num'] = 'Invalid registration number.';
      }else if(ClientInfo::uniqueRegisterNum($_POST['register_num'])){
		   $flage =false;
	      $errors['register_num'] = 'Registration number already exist.';
      } 
  
  }*/
  
  if(!trim($_POST['phone'])){
	   $flage =false;
      $errors['phone'] = 'Contact number is required.';
  }elseif(!preg_match("/[0-9]/",$_POST['phone'])){
	   $flage =false;
      $errors['phone'] = 'Invalid Contact number.';
  }
  /*if($_POST['phone']!=""){
  
  if(!preg_match("/^[0-9]{11}$/",$_POST['phone'])){
	   $flage =false;
      $errors['phone'] = 'Invalid Contact number.';
  }
  
  }*/
  
 /* if(!empty($_POST['mobile'])){
           if(!preg_match("/^[0-9]{10}$/",$_POST['mobile'])){
			    $flage =false;
               $errors['mobile'] = 'Invalid mobile number.';
           } 
  }*/
  
  if($flage==true){
  	  if($res = ClientInfo::createClient($_POST)){
		  if($res['added']==true){
			      unset($_SESSION['contact']);
				 
				  redirect('view_client.php?id='.$res['id'].'&msg=Client has been added successfully.'); 
				  
				 }else{
				  $errors['msg'] = 'Client not added something went wrong.';
			     }
       
       }

  }
  
}
//$_REQUEST['msg']="Client not added something went wrong";
 ?>

	<div class="box">
		<h4 class="white"><?php echo($page_title); ?> 
		<span style="margin-left: 300px;">
		<a href="search_client.php" class="" role="" >
        <span>Search Client</span></a></span>
		</h4>
		
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
  
        <?php /*?><center><span class="error"><font color="red">&nbsp;<b><?php echo isset($_REQUEST['msg'])? $_REQUEST['msg'] : @$errors['msg']; ?><b/></font></span></center><?php */?>
        <?php } ?>
        
			<?php /*?><form class="middle-forms cmxform" name="xForm" id="xForm" method="post" action="<?php  echo $_SERVER['PHP_SELF']."?id=".$_REQUEST['id']?>" ><?php */?>
            <form class="middle-forms cmxform" name="xForm" id="xForm" method="post" action="<?php  echo $_SERVER['PHP_SELF'];?>" >
            <?php /*?><input type="hidden" name="id" value="<?php echo $_REQUEST['id']; ?>" /><?php */?>
				<fieldset>
					<h3><?php //echo($page_title); ?></h3>
					<!--<input type="hidden" id="user_id" name="user_id" value="<?php //echo $_SESSION[$db_prefix.'_UserId'];?>"/>-->
					<ol>
					    <li class="even">
							<label class="field-title">Company Name:<font color="red"></font></label>
							<input type="text" id="_company_name" size="40" maxlength="200" placeholder="Company Name" name="company_name" value="<?php echo @$_POST['company_name'];?>">
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['company_name']; ?></font></span>

						</li> 
                    	
                        <li class="even">
							<label class="field-title">Contact Person Full Name:<font color="red"> <em>*</em></font></label>
							<input type="text" id="_full_name" size="40" maxlength="64" placeholder="Contact Person Full Name" name="full_name" value="<?php echo @$_POST['full_name'];?>">

                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['full_name']; ?></font></span>

						</li>
                        <li class="even">
							<label class="field-title">Email Address<!--<font color="red"> <em>*</em></font>-->:</label>
							<input type="text" id="_email" size="40" maxlength="64" placeholder="name@domain.com" name="email" value="<?php echo @$_POST['email'];?>">

                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['email']; ?></font></span>

						</li>
                        <?php if( $_SESSION['cnic']){?>
                        <li class="even">
							<label class="field-title">CNIC Number:<!--<font color="red"> <em>*</em></font>-->:</label>
							<input type="text" id="_cnic" size="40" maxlength="64" placeholder="4310196424576" name="cnic" value="<?php echo isset($_POST['cnic'])? $_POST['cnic']:@$_SESSION['cnic'];?>">
                            <input type="hidden" name="is_cnic" value="yes" />
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['cnic']; ?></font></span>

						</li>
                        <?php }elseif( $_SESSION['register_num']){?>
                        <li class="even">
							<label class="field-title">Registration Number:<!--<font color="red"> <em>*</em></font>--></label>
							<input id="_register_num" type="text" name="register_num" maxlength="64" style="" value="<?php echo isset($_POST['register_num'])? $_POST['register_num']:@$_SESSION['register_num'];?>">
                             <input type="hidden" name="is_reg_num" value="yes" />
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['register_num']; ?></font></span>

						</li>
                         <?php }else{ ?>
                          <li class="even">
							<label class="field-title">CNIC Number:<!--<font color="red"> <em>*</em></font>--></label>
							<input type="text" id="_cnic" size="40" maxlength="64" placeholder="4310196424576" name="cnic" value="<?php echo isset($_POST['cnic'])? $_POST['cnic']:@$_SESSION['cnic'];?>">
                             <input type="hidden" name="is_cnic" value="yes" />
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['cnic']; ?></font></span>

						</li>
                         <?php } ?>
                       
                        <?php /*?><li class="even">
							<label class="field-title">Mobile Number:</label>
							<input id="_mobile" type="text" name="mobile" style="" value="<?php echo @$_POST['mobile'];?>">
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['mobile']; ?></font></span>

						</li><?php */?>
                        
                       <li class="even">
                        <label class="field-title">Identity Type:<!--<font color="red"> <em>*</em></font>--></label>
                        <select name="i_type" id="_i_type">
                            <option value="">&mdash; Select Identity Type &mdash;</option>
                            <option value="CMID" <?php echo (@$_POST['i_type']=="CMID" || @$_SESSION['cmid']!="" )? "selected":"";?>>CMID</option>
                            <option value="UIN" <?php echo (@$_POST['i_type']=="UIN" || @$_SESSION['uin']!="")? "selected":"";?>>UIN</option>
                        </select>
                        <br>
                        <span class="error"><font color="red">&nbsp;<?php echo @$errors['i_type']; ?></font></span>
                        </li>
                         <li class="even" id="cmid" style="display:<?php echo $cmic_display;?>">
							<label class="field-title">CMID:<!--<font color="red"> <em>*</em></font>--></label>
							<input id="_cmid" type="text" name="cmid" style="" maxlength="20" placeholder="max 20 digits" value="<?php echo isset($_POST['cmid'])? $_POST['cmid']:@$_SESSION['cmid'];?>">
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['cmid']; ?></font></span>

						</li>
                         <li  class="even" id="uin" style="display:<?php echo $uin_display;?>">
							<label class="field-title">UIN:<!--<font color="red"> <em>*</em></font>--></label>
							<input id="_uin" type="text" name="uin" style="" maxlength="20" placeholder="max 20 digits" value="<?php echo isset($_POST['uin'])? $_POST['uin']:@$_SESSION['uin'];?>">
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['uin']; ?></font></span>

						</li>
                          <li class="even">
							<label class="field-title">Contact Number:<font color="red"> <em>*</em></font></label>
							<input id="_phone" type="text" name="phone" style="" placeholder="" value="<?php echo isset($_POST['phone'])? $_POST['phone']:@$_SESSION['contact'];?>"><?php /*?>&nbsp;&nbsp;Ext:
                            <input type="text" name="phone-ext" value="<?php echo @$_POST['phone-ext'];?>" size="5"><?php */?>
                            <br>
                            <span class="error"><font color="red">&nbsp;<?php echo @$errors['phone']; ?></font></span>

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

 