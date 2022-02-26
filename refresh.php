<?php include_once("includes/config.php"); ?>
<?php
        $page_name = "refresh.php";
        $page_level = "2";
        $page_group_id = "1";
        $page_title = "Refresh";
        $page_menu_title = "Refresh";
?>

<?php include_once($site_root."includes/check.auth.php"); ?>
<?php

        include_once("classes/admin.php");
        $admin = new admin();

	if(isset($_REQUEST['refresh'])){
		//shell_exec("service asterisk restart");
		$admin->cc_refresh($_SESSION[$db_prefix.'_UserId']);
        $_SESSION[$db_prefix.'_GM'] = "Call Center restart successfully.";
        header ("Location: index.php");
        exit();
	}
		
?>

<?php include($site_root."includes/header.php"); ?>
      	<div class="box">
		<h4 class="white"><?php echo($page_title); ?></h4>
        	<div class="box-container">
			<form action="" method="post" class="middle-forms cmxform" name="xForm" id="xForm" onsubmit="">
				<a class="button" href="javascript:document.xForm.submit();"  ><span>Refresh</span></a>
                        	<input type="hidden" value="REFRESH" id="refresh" name="refresh"/>
			</form>
		</div>
      	</div> 
<?php include($site_root."includes/footer.php"); ?>      
