<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "user_faqs";
        $page_level = "0";
        $page_group_id = "0";
        $page_title = "FAQs";
        $page_menu_title = "FAQs";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
<?php
        include_once('lib/nusoap.php');
		
      include_once("classes/tools_admin.php");
        $tools_admin = new tools_admin();

     /*     include_once("classes/soap_client.php");
        $soap_client = new soap_client();
		
		include_once("classes/human_verify.php");
        $human_verify = new human_verify();	
		
		include_once("classes/user_pin.php");
        $user_pin = new user_pin();	*/
?>
<?php include($site_root."includes/header.php"); ?>

<?php 
			
		//echo $caller_id;
		//$caller_id = '02135622755';
		//$caller_id = '293021165';
		//if(!empty($caller_id))
		//{
			//$method = 'GetContactDetail';
			//$params = array('AccessKey' => $access_key,'CallerId' => $caller_id, 'Channel' => $channel);
			//print_r($params);
			//$rs4 = $soap_client->call_soap_method($method,$params);
			//print_r ($rs4); exit;	
			
			//$customer_id	= $rs4[0]["CustomerId"]; //AccountNo
			//$account_no		= $rs4[0]["AccountNo"];
			//$rs_verify 		= $human_verify->check_human_verify($unique_id);
			
			
		//}
?>
<div class="box">
	<h4 class="white"><?php echo($page_title); ?> <!--<a href="#" class="heading-link"><?php //if(empty($caller_id)) echo "No Calls"; elseif(empty($rs4[0]["CustomerId"])) echo "UnRegister No."; else echo "Users List"; ?></a>--></h4>
	<div class="box-container">	
	 <div class="box" id="mid-tab">
        <ul class="tab-menu">
                  <li><a href="#faq-1">FAQ-1</a></li>
                  <li><a href="#faq-2">FAQ-2</a></li>
                  <li><a href="#faq-3">FAQ-3</a></li>
                  <li><a href="#faq-4">FAQ-4</a></li>

		</ul>
			<div class="box-container" id="faq-1"><?php  include($site_root."includes/faqs1.php"); ?></div>
			<div class="box-container" id="faq-2"><?php  include($site_root."includes/faqs2.php"); ?></div>			
			<div class="box-container" id="faq-3"><?php  include($site_root."includes/faqs3.php"); ?></div>
			<div class="box-container" id="faq-4"><?php  include($site_root."includes/faqs4.php"); ?></div>
</div>
	
	</div>
</div> 
<?php include($site_root."includes/footer.php"); ?>      
