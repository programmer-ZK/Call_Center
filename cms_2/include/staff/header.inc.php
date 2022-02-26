<?php
header("Content-Type: text/html; charset=UTF-8");
if (!isset($_SERVER['HTTP_X_PJAX'])) { ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html <?php
if (($lang = Internationalization::getCurrentLanguage())
        && ($info = Internationalization::getLanguageInfo($lang))
        && (@$info['direction'] == 'rtl'))
    echo 'dir="rtl" class="rtl"';
?>>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="x-pjax-version" content="<?php echo GIT_VERSION; ?>">
    <title><?php echo ($ost && ($title=$ost->getPageTitle()))?$title:__('Staff Control Panel'); ?></title>
    <!--[if IE]>
    <style type="text/css">
        .tip_shadow { display:block !important; }
    </style>
    <![endif]-->
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-1.8.3.min.js?19292ad"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery-ui-1.10.3.custom.min.js?19292ad"></script>
    <script type="text/javascript" src="./js/scp.js?19292ad"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery.pjax.js?19292ad"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/filedrop.field.js?19292ad"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/jquery.multiselect.min.js?19292ad"></script>
    <script type="text/javascript" src="./js/tips.js?19292ad"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor.min.js?19292ad"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-osticket.js?19292ad"></script>
    <script type="text/javascript" src="<?php echo ROOT_PATH; ?>js/redactor-fonts.js?19292ad"></script>
    <script type="text/javascript" src="./js/bootstrap-typeahead.js?19292ad"></script>
    <link rel="stylesheet" href="<?php echo ROOT_PATH ?>css/thread.css?19292ad" media="all"/>
    <link rel="stylesheet" href="./css/scp.css?19292ad" media="all"/>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/redactor.css?19292ad" media="screen"/>
    <link rel="stylesheet" href="./css/typeahead.css?19292ad" media="screen"/>
    <link type="text/css" href="<?php echo ROOT_PATH; ?>css/ui-lightness/jquery-ui-1.10.3.custom.min.css?19292ad"
         rel="stylesheet" media="screen" />
     <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome.min.css?19292ad"/>
    <?php /*?> <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>/css/bootstrap.css"/><?php */?>
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/font-awesome-ie7.min.css?19292ad"/>
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="./css/dropdown.css?19292ad"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/loadingbar.css?19292ad"/>
    <link type="text/css" rel="stylesheet" href="<?php echo ROOT_PATH; ?>css/rtl.css?19292ad"/>
    <script type="text/javascript" src="./js/jquery.dropdown.js?19292ad"></script>
    
     <link href="../../css/reset.css" rel="stylesheet" type="text/css">
     <link href="../../css/style.css" rel="stylesheet" type="text/css">
     <link href="../../css/sample.css" rel="stylesheet" type="text/css">
     <link href="../../css/screen.css" rel="stylesheet" type="text/css">
     <!-- <link href="js/jquery.wysiwyg.css" rel="stylesheet" type="text/css">
     <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox.css">
     <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox-custom.css"> -->

    <?php
    if($ost && ($headers=$ost->getExtraHeaders())) {
        echo "\n\t".implode("\n\t", $headers)."\n";
    }
    ?>
</head>
<style>
#nav {
    /*background: #c5d9ec;
    padding-top: 4px;
    z-index: 200;
    border-top: 1px solid #ddd;
    border-bottom: 1px solid #c5d9ec;*/
    width: 98%;
    padding-top: 10px;
	  float: left;
	  background: #cecccc;
	  -webkit-box-shadow: 0px 3px 3px 1px rgba(0,0,0,0.7);
	  -moz-box-shadow: 0px 3px 3px 1px rgba(0,0,0,0.7);
	  box-shadow: 0px 3px 3px 1px rgba(0,0,0,0.7);
}
users.phpmedia="all"
#nav, #sub_nav {
    clear: both;
    margin: 0;
    padding: 0 20px;
    height: 26px;
    line-height: 26px;
    border-left: 1px solid #aaa;
    border-right: 1px solid #aaa;
    white-space: nowrap;
}
.wht_bg {
	display: inline-block;
	padding: 0 0px;
	width: 960px;
	background: #fff;
}
#nav li.active {
    background-color: #f7f7f7;
	
}

</style>
<body>
 <!--hbm-->
     <div class="main_header">
       <div id="container">
          <div id="">
              <div id="top">
              <div id="userbox">
               <!--<p id="info" class="pull-right no-pjax">--><?php echo sprintf(__('Hello, %s.'), '<strong>'.$thisstaff->getFirstName().'</strong>'); ?>
           <?php
            if($thisstaff->isAdmin() && !defined('ADMINPAGE')) { ?>
            | <a href="admin.php" class="no-pjax"><?php echo __('Admin Panel'); ?></a>
            <?php }else{ ?>
            | <a href="index.php" class="no-pjax"><?php echo __('Agent Panel'); ?></a>
            <?php } ?>
            | <a href="profile.php"><?php echo __('My Preferences'); ?></a>
            | <a href="logout.php?auth=<?php echo $ost->getLinkToken(); ?>" class="no-pjax lgout"><span></span><?php echo __('Log Out'); ?></a>
          <small> <?php echo sprintf(__('Last Login: %s.'),$thisstaff->getLastLogin()); ?></small>
          </div>
                 <h1><a href="index.php" class="no-pjax" id="logo">
                 <span class="valign-helper"></span>
                 <img src="logo.php" alt="<?php echo __('Customer Support System'); ?>"/>
                 </a></h1>       
              
        <span class="clearFix">&nbsp;</span> </div>
        <span class="clearFix">&nbsp;</span> </div>
    <!-- end of #header --> 
      </div>
        </div>
        
     <!--hbm-->

<div id="container">
    <?php
    if($ost->getError())
        echo sprintf('<div id="error_bar">%s</div>', $ost->getError());
    elseif($ost->getWarning())
        echo sprintf('<div id="warning_bar">%s</div>', $ost->getWarning());
    elseif($ost->getNotice())
        echo sprintf('<div id="notice_bar">%s</div>', $ost->getNotice());
    ?>
    <?php /*?><div id="header">
        <p id="info" class="pull-right no-pjax"><?php echo sprintf(__('Welcome, %s.'), '<strong>'.$thisstaff->getFirstName().'</strong>'); ?>
           <?php
            if($thisstaff->isAdmin() && !defined('ADMINPAGE')) { ?>
            | <a href="admin.php" class="no-pjax"><?php echo __('Admin Panel'); ?></a>
            <?php }else{ ?>
            | <a href="index.php" class="no-pjax"><?php echo __('Agent Panel'); ?></a>
            <?php } ?>
            | <a href="profile.php"><?php echo __('My Preferences'); ?></a>
            | <a href="logout.php?auth=<?php echo $ost->getLinkToken(); ?>" class="no-pjax"><?php echo __('Log Out'); ?></a>
        </p>
        <a href="index.php" class="no-pjax" id="logo">
            <span class="valign-helper"></span>
            <img src="logo.php" alt="<?php echo __('Customer Support System'); ?>"/>
        </a>
    </div><?php */?>
    <div id="pjax-container" class="<?php if ($_POST) echo 'no-pjax'; ?>">
<?php } else {
    header('X-PJAX-Version: ' . GIT_VERSION);
    if ($pjax = $ost->getExtraPjax()) { ?>
    <script type="text/javascript">
    <?php foreach (array_filter($pjax) as $s) echo $s.";"; ?>
    </script>
    <?php }
    foreach ($ost->getExtraHeaders() as $h) {
        if (strpos($h, '<script ') !== false)
            echo $h;
    } ?>
    <title><?php echo ($ost && ($title=$ost->getPageTitle()))?$title:__('Staff Control Panel'); ?></title><?php

} # endif X_PJAX ?>
  <!--hbm-->
  <div class="menu_wrapper">
          <div class="container">
    <div class="wht_bg">
    <ul id="nav">
  <?php include STAFFINC_DIR . "templates/navigation.tmpl.php"; ?>
    </ul>
    <ul id="sub_nav">
   <?php include STAFFINC_DIR . "templates/sub-navigation.tmpl.php"; ?>
    </ul>
         <?php /*?> <ul id="menu">
             <li class="selected"><a href="index.php"><span class="icon_home"></span><span class="txt">Home</span></a></li>
      
             <li><a class="top-level" href=""><span class="icon_admin_setting"></span><span class="txt">Admin Settings </span><span class="arw">&nbsp;</span></a>
             <ul>
                <li><a href="quick_links_new.php">Add Quick Links</a></li>
            	<li><a href="quick_links_list.php">Quick Links List</a></li>
            	<li><a href="faqs_new.php">FAQs Add</a></li>
            	<li><a href="faqs_list.php">FAQs List</a></li>
            	<li><a href="workcodes_list.php">Workcodes List</a></li>
             </ul>
          </li>
          <li><a class="top-level" href=""><span class="icon_setting"></span><span class="txt">Settings </span><span class="arw">&nbsp;</span></a>
           
        </li>
      </ul><?php */?>
        </div>
    </div>
</div>
  
  <!--hbm-->
    <?php /*?><ul id="nav">
  <?php include STAFFINC_DIR . "templates/navigation.tmpl.php"; ?>
    </ul>
    <ul id="sub_nav">
   <?php include STAFFINC_DIR . "templates/sub-navigation.tmpl.php"; ?>
    </ul><?php */?>
    
    <div id="content">
        <?php if($errors['err']) { ?>
            <div id="msg_error"><?php echo $errors['err']; ?></div>
        <?php }elseif($msg) { ?>
            <div id="msg_notice"><?php echo $msg; ?></div>
        <?php }elseif($warn) { ?>
            <div id="msg_warning"><?php echo $warn; ?></div>
        <?php }
     ?>
