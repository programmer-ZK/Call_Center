<?php ob_start();  ?>
<?php include($site_root."includes/make_page_url.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $page_title; ?></title>
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link href="css/sample.css" rel="stylesheet" type="text/css" />
        <link href="css/screen.css" rel="stylesheet" type="text/css" />
        <link href="js/jquery.wysiwyg.css" rel="stylesheet" type="text/css" />
        <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox.css" />
        <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox-custom.css" />
        <script src="js/datetimepicker_css.js"></script>
        <style type="text/css">
div.wysiwyg ul.panel li {
	padding: 0px !important;
} /**textarea visual editor padding override**/
</style>
        <!--[if IE 6]>
        <link rel="stylesheet" href="ie.css" type="text/css" />
        <![endif]-->
        <!--[if IE]>
                    <link type="text/css" media="screen" rel="stylesheet" href="css/colorbox-custom-ie.css" title="Cleanity" />
        <![endif]-->

        <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="js/jquery.colorbox-min.js"></script>
        <script type="text/javascript" src="js/jquery.ui.js"></script>
        <script type="text/javascript" src="js/jquery.corners.min.js"></script>
        <script type="text/javascript" src="js/bg.pos.js"></script>
        <script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
        <script src="js/tabs.pack.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/cleanity.js"></script>
        </head>

        <body>
<!-- ***** Popup Window **************************************************** -->
<div class="sample_popup" id="popup" style="display: none;">
          <?php include($site_root."includes/popup.php"); ?>
        </div>
<script language="javascript1.2" type="text/javascript">
	setInterval( "get_agent_status()", 5000 );
//	setInterval( "get_pin_status()", 5000 );
//	setInterval( "CheckHangup()", 5000 );  
</script> 
<script type="text/javascript" language="javascript1.2">
function get_pin_status(){
    var rnd = Math.random();
    var url="ajax_call.php?id="+rnd+"&param_1=GetPinStatus";
    m2postRequest(url);
	
	var ispopupshow =document.getElementById("ispopupshow").value;
	//alert(ispopupshow);
	if(ispopupshow == 1){
    	popup_show('popup', 'popup_drag', 'popup_exit', 'screen-bottom-right', -20, -20);
	}
	//popitup('user_hangup.php');
}
function m2postRequest(strURL){
        var xmlHttp;
          if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                 var xmlHttp = new XMLHttpRequest();
            }else if (window.ActiveXObject) { // IE
                var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlHttp.open('POST', strURL, true);
            xmlHttp.setRequestHeader
              ('Content-Type', 'application/x-www-form-urlencoded');
                xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
				document.getElementById("popup").innerHTML = xmlHttp.responseText ;
                //alert(xmlHttp.responseText);
              }
           }
         xmlHttp.send(strURL);
}
function CheckHangup(){
    //var rnd = Math.random();
    //var url="ajax_call.php?id="+rnd+"&param_1=CheckHangup";
    //m3postRequest(url);
}
function m3postRequest(strURL){
        var xmlHttp;
          if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                 var xmlHttp = new XMLHttpRequest();
            }else if (window.ActiveXObject) { // IE
                var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlHttp.open('POST', strURL, true);
            xmlHttp.setRequestHeader
              ('Content-Type', 'application/x-www-form-urlencoded');
                xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
			var query_str = xmlHttp.responseText;
			query_str= query_str.replace(/^\s+|\s+$/, '');
            //alert(query_str.length);
			if(query_str.length != 0){
			popitup('call_hangup.php?'+query_str);
			}
	
              }
           }
         xmlHttp.send(strURL);
}
function change_status(){
    var rnd = Math.random();
	var status  = document.getElementById("status_change").value;
    var url="ajax_call.php?id="+rnd+"&param_1=Change_Status&param_2="+status;
	//alert(url);
    m4postRequest(url);
}
function m4postRequest(strURL){
        var xmlHttp;
          if (window.XMLHttpRequest) { // Mozilla, Safari, ...
                 var xmlHttp = new XMLHttpRequest();
            }else if (window.ActiveXObject) { // IE
                var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlHttp.open('POST', strURL, true);
            xmlHttp.setRequestHeader
              ('Content-Type', 'application/x-www-form-urlencoded');
                xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
			var query_str = xmlHttp.responseText;
			query_str= query_str.replace(/^\s+|\s+$/, '');
            
			if(query_str.length != 0){
				alert('Status Changed successfully');
			}
			else{
				alert('Status Changed Failure! Please try lator.');
			}
	
              }
           }
         xmlHttp.send(strURL);
}
</script>

<div class="main_header">
          <div id="container">
    <div id="header">
              <div id="top">
        <h1><a href="index.php"><img src="<?php echo IMG_PATH; ?>logo.png" alt="RNI" /></a></h1>
        <div id="userbox">Hello <strong><?php echo $_SESSION[$db_prefix.'_UserName']; ?></strong> &nbsp;(
                  <select id="status_change" name="status_change" style="text-transform: uppercase; border: 0 none; color:#000000;  font-size: 85%;" onchange="javascript: change_status();" >
            <!--color: #CEAC0F;-->
            <option <?php echo ($_SESSION[$db_prefix.'_UserStatus'] ==1)?"selected=\"selected\"":"";?>  value="1" style="background: none repeat scroll 0 0 transparent; border: 0 nonecolor: #000000; ;  font-size: 100%;">Online</option>
            <option <?php echo ($_SESSION[$db_prefix.'_UserStatus'] ==2)?"selected=\"selected\"":"";?>  value="2" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;   font-size: 100%;">Namaz Break</option>
            <option <?php echo ($_SESSION[$db_prefix.'_UserStatus'] ==3)?"selected=\"selected\"":"";?>  value="3" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;  font-size: 100%;">Lunch Break</option>
            <option <?php echo ($_SESSION[$db_prefix.'_UserStatus'] ==4)?"selected=\"selected\"":"";?>  value="4" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;  font-size: 100%;">Tea Break</option>
            <option <?php echo ($_SESSION[$db_prefix.'_UserStatus'] ==5)?"selected=\"selected\"":"";?>  value="5" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;  font-size: 100%;">Break</option>
            <option <?php echo ($_SESSION[$db_prefix.'_UserStatus'] ==6)?"selected=\"selected\"":"";?>  value="6" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;  font-size: 100%;">Assignment</option>
            <option <?php echo ($_SESSION[$db_prefix.'_UserStatus'] ==7)?"selected=\"selected\"":"";?>  value="7" style="background: none repeat scroll 0 0 transparent; border: 0 none; color: #000000; font-size: 100%;">Campaign</option>
          </select>
                  ) 
                  <!--<ul id="menu-list" style="width:16%;">
        <li><a class="top-level" href="#" >Online <span>&nbsp;</span></a>
          <ul>
            <li><a href="#">Namaz Break</a></li>
            <li><a href="#">Lunch Break</a></li>
          </ul>
        </li>
	</ul>--> 
                  &nbsp;| &nbsp;<!--<a href="profile_search.php">Search</a>&nbsp;| &nbsp;--><a href="admin_change_password.php">Password</a> &nbsp;| &nbsp;<a class="lgout" href="logout.php"><span></span>Logout</a> <br />
                  <small>Last Login: <?php echo $_SESSION[$db_prefix.'_LLoginTime'];  ?></small></div>
        
        <!--      <div id="userbox">Hello <strong><?php //echo $_SESSION[$db_prefix.'_UserName']; ?></strong>&nbsp;(<a onmouseover="javascript:document.getElementById('status_change').style.display='';"  class="top-level" href="#">Online<span style="background: url(images/bg-toplevel.gif) no-repeat scroll 0 5px transparent; display: inline-block; height: 10px; right: 10px; width: 11px;">&nbsp;</span></a>)
	      <ul id="status_change" name="status_change" style="background:#5C6467;margin-left:77px; display:none;text-align: left; z-index:1;position:absolute;">
            <li><a href="#">Namaz Break</a></li>
            <li><a href="#">Lunch Break</a></li>
          </ul>
	   &nbsp;| &nbsp;<a href="profile_search.php">Search</a>&nbsp;| &nbsp;<a href="admin_change_password.php">Settings</a> &nbsp;| &nbsp;<a href="logout.php">Logout</a> <br />

      <small>Last Login: <?php //echo $_SESSION[$db_prefix.'_LLoginTime'];  ?></small></div>--> 
        <span class="clearFix">&nbsp;</span> </div>
              
              <!--	 <form action="profile_listing.php" method="post" class="" name="sForm" id="sForm" onsubmit="">
      <fieldset>
      <legend>Search</legend>
        <label id="searchbox">
			<input name="cnic" id="cnic" class="txtbox-short" value="<?php //echo $cnic; ?>" />
			
        </label>
        <input class="hidden" type="submit" name="Submit" value="Search" />
      </fieldset>
      </form>--> 
              <span class="clearFix">&nbsp;</span> </div>
    <!-- end of #header --> 
  </div>
        </div>
<div class="menu_wrapper">
          <div class="container">
    <div class="wht_bg">
              <ul id="menu">
        <li class="selected"><a href="index.php"><span class="icon_home"></span><span class="txt">Home</span></a></li>
        <!-- <li><a class="top-level" href="#">Users <span>&nbsp;</span></a>
          <ul>
            <li><a href="#">Add User</a></li>
            <li><a href="#">Edit Users</a></li>
          </ul>
        </li>
        <li><a href="#">Pages</a></li>
        <li><a href="#">Modules</a></li>-->
        <?php  
	// if($ADMIN_ID == $_SESSION[$db_prefix.'_UserId'])
	  if($ADMIN_ID1 == $_SESSION[$db_prefix.'_UserId'] || $ADMIN_ID2 == $_SESSION[$db_prefix.'_UserId'] 
	 || $ADMIN_ID3 == $_SESSION[$db_prefix.'_UserId'] || $ADMIN_ID4 == $_SESSION[$db_prefix.'_UserId']
	 || $ADMIN_ID5 == $_SESSION[$db_prefix.'_UserId'] || $ADMIN_ID6 == $_SESSION[$db_prefix.'_UserId'])
	 
	 {
	 	 //include_once('includes/side_menu.php');  
	?>
        <li><a class="top-level" href=""><span class="icon_admin_setting"></span><span class="txt">Admin Settings </span><span class="arw">&nbsp;</span></a>
                  <ul>
            <li><a href="quick_links_new.php">Add Quick Links</a></li>
            <li><a href="quick_links_list.php">Quick Links List</a></li>
            <li><a href="faqs_new.php">FAQs Add</a></li>
            <li><a href="faqs_list.php">FAQs List</a></li>
            <li><a href="workcodes_list.php">Workcodes List</a></li>
             <!-- JD<li><a href="set_eval_params.php">Setting Eval Parameters</a></li>-->
          </ul>
                </li>
        <?php  }
	 ?>
        <li><a class="top-level" href=""><span class="icon_setting"></span><span class="txt">Settings </span><span class="arw">&nbsp;</span></a>
                  <ul>
            <?php //echo "adminid: ".$ADMIN_ID1."----Sessionid: ".$_SESSION[$db_prefix.'_UserId'];exit; 
//			if($ADMIN_ID1 == $_SESSION[$db_prefix.'_UserId']) {?>
	        <?php
        // if($ADMIN_ID == $_SESSION[$db_prefix.'_UserId'])
          if($ADMIN_ID1 == $_SESSION[$db_prefix.'_UserId'] || $ADMIN_ID2 == $_SESSION[$db_prefix.'_UserId']
         || $ADMIN_ID3 == $_SESSION[$db_prefix.'_UserId'] || $ADMIN_ID4 == $_SESSION[$db_prefix.'_UserId']
         || $ADMIN_ID5 == $_SESSION[$db_prefix.'_UserId'] || $ADMIN_ID6 == $_SESSION[$db_prefix.'_UserId'])

         {
                 //include_once('includes/side_menu.php');
        ?>

            <li><a href="agent_session_reset.php">Agent Session Reset</a></li>
            <?php } ?>
          </ul>
                </li>
      </ul>
            </div>
  </div>
        </div>
<div class="container">
<div id="content">
<!--	<iframe src ="<?php //echo ($site_root."includes/agent_status_bar.php");?>" height = "500px" width = "600px" frameborder = "1" scrolling = "no">
</iframe>-->
<div id="agent_status_bar">
          <?php  include($site_root."includes/agent_status_bar.php"); ?>
        </div>
<?php 
 $pageName = basename($_SERVER['PHP_SELF']); 
if($pageName != 'monthly-stats.php'){ include($site_root."includes/left_menu.php"); }?>
<div id="mid-col">
<?php  include($site_root."includes/message_panel.php"); ?>
<?php 
$static_time_array = array('00:00:00','01:00:00','02:00:00','03:00:00','04:00:00','05:00:00','06:00:00','07:00:00','08:00:00','09:00:00','10:00:00','11:00:00','12:00:00','13:00:00','14:00:00','15:00:00','16:00:00','17:00:00','18:00:00','19:00:00','20:00:00','21:00:00','22:00:00','23:00:00');
$static_hours_array = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23');
$static_minutes_array = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59');
?>
