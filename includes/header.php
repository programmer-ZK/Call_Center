<?php ob_start();  ?>
<?php include($site_root . "includes/make_page_url.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title; ?></title>
  <link rel="stylesheet" href="css/treeview.css">
  <link href="css/reset.css" rel="stylesheet" type="text/css" />
  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <link href="css/sample.css" rel="stylesheet" type="text/css" />
  <link href="css/screen.css" rel="stylesheet" type="text/css" />
  <link href="js/jquery.wysiwyg.css" rel="stylesheet" type="text/css" />
  <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox.css" />
  <link type="text/css" media="screen" rel="stylesheet" href="js/colorbox-custom.css" />
  <script src="js/datetimepicker_css.js"></script>

  <link rel="stylesheet" href="css\jquery.dataTables.min.css">
  <link rel="stylesheet" href="css\buttons.dataTables.min.css">



  <style type="text/css">
    .dt-buttons {
      float: right !important;
    }

    .dt-button {
      background: #b5824f !important;
      color: white !important;
      font-weight: bolder !important;
      height: auto !important;
      border-radius: 8px !important;
    }

    .dt-button span {
      padding: 10px !important;
    }

    .dataTables_filter {
      margin-bottom: 13px;
    }

    div.wysiwyg ul.panel li {
      padding: 0px !important;
    }

    /**textarea visual editor padding override**/
  </style>

  <style>
    .dropbtn {
      font-weight: bolder;
      background-color: #B68452;
      color: white;
      padding: 10px;
      font-size: 14px;
      border: none;
      cursor: pointer;
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      overflow: auto;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black !important;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }

    .dropdown a:hover {
      background-color: #ddd;
    }

    .show {
      display: block;
    }
  </style>

  <script src="js\jquery-3.5.1.js"></script>
  <script src="js\jquery.dataTables.min.js"></script>
  <script src="js\dataTables.buttons.min.js"></script>
  <script src="js\jszip.min.js"></script>
  <script src="js\pdfmake.min.js"></script>
  <script src="js\vfs_fonts.js"></script>
  <script src="js\buttons.print.min.js"></script>
  <script src="js\buttons.html5.min.js"></script>

  <script type="text/javascript" src="js/jquery.colorbox-min.js"></script>
  <script type="text/javascript" src="js/jquery.ui.js"></script>
  <script type="text/javascript" src="js/bg.pos.js"></script>
  <script type="text/javascript" src="js/rpie.js"></script>
  <script type="text/javascript" src="js/jquery.wysiwyg.js"></script>
  <script src="js/tabs.pack.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>

</head>

<script type="text/javascript">
  $(function() {
    $('#keywords').tablesorter();
  });
</script>

<?php
$u = $_SERVER['HTTP_USER_AGENT'];

$isIE7  = (bool)preg_match('/msie 7./i', $u);
$isIE8  = (bool)preg_match('/msie 8./i', $u);
$isIE9  = (bool)preg_match('/msie 9./i', $u);
$isIE10 = (bool)preg_match('/msie 10./i', $u);
if ($isIE8) { ?>
  <script type="text/javascript" src="js/jquery.corners_ie.js"></script>
  <script type="text/javascript" src="js/cleanity_ie.js"></script>

<?php
} else {

?>
  <script type="text/javascript" src="js/jquery.corners.min.js"></script>
  <script type="text/javascript" src="js/cleanity.js"></script>

<?php
}
?>
<?php $rs_agent_name = $admin->get_agent_name($_SESSION[$db_prefix . '_UserId']); ?>

</head>

<body>
  <!-- ***** Popup Window **************************************************** -->
  <div class="sample_popup" id="popup" style="display: none;">
    <?php include($site_root . "includes/popup.php"); ?>
  </div>
  <script language="javascript1.2" type="text/javascript">
    setInterval("get_agent_status()", 5000);
  </script>
  <script type="text/javascript" language="javascript1.2">
    function get_pin_status() {
      var rnd = Math.random();
      var url = "ajax_call.php?id=" + rnd + "&param_1=GetPinStatus";
      m2postRequest(url);

      var ispopupshow = document.getElementById("ispopupshow").value;
      if (ispopupshow == 1) {
        popup_show('popup', 'popup_drag', 'popup_exit', 'screen-bottom-right', -20, -20);
      }
    }

    function m2postRequest(strURL) {
      var xmlHttp;
      if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        var xmlHttp = new XMLHttpRequest();
      } else if (window.ActiveXObject) { // IE
        var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlHttp.open('POST', strURL, true);
      xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
          document.getElementById("popup").innerHTML = xmlHttp.responseText;
        }
      }
      xmlHttp.send(strURL);
    }



    function m3postRequest(strURL) {
      var xmlHttp;
      if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        var xmlHttp = new XMLHttpRequest();
      } else if (window.ActiveXObject) { // IE
        var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlHttp.open('POST', strURL, true);
      xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
          var query_str = xmlHttp.responseText;
          query_str = query_str.replace(/^\s+|\s+$/, '');
          if (query_str.length != 0) {
            popitup('call_hangup.php?' + query_str);
          }

        }
      }
      xmlHttp.send(strURL);
    }

    function change_status() {
      var rnd = Math.random();
      var status = document.getElementById("status_change").value;
      var url = "ajax_call.php?id=" + rnd + "&param_1=Change_Status&param_2=" + status;
      m4postRequest(url);
    }

    function m4postRequest(strURL) {
      var xmlHttp;
      if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        var xmlHttp = new XMLHttpRequest();
      } else if (window.ActiveXObject) { // IE
        var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlHttp.open('POST', strURL, true);
      xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xmlHttp.onreadystatechange = function() {
        if (xmlHttp.readyState == 4) {
          var query_str = xmlHttp.responseText;
          query_str = query_str.replace(/^\s+|\s+$/, '');

          if (query_str.length != 0) {
            alert('Status Changed successfully');
          } else {
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
          <h1><a href="index.php"><img src="<?php echo IMG_PATH; ?>i_logo.png" alt="RNI" style="width: 250px;" /></a></h1>
          <div id="userbox">Hello <strong><?php echo $_SESSION[$db_prefix . '_UserName']; ?></strong>

            <?php if ($rs_agent_name->fields["department"] != "Management") { ?>

              &nbsp;(
              <select id="status_change" name="status_change" style="text-transform: uppercase; border: 0 none; color:#000000;  font-size: 85%;" onchange="javascript: change_status();">
                <option <?php echo ($_SESSION[$db_prefix . '_UserStatus'] == 1) ? "selected=\"selected\"" : ""; ?> value="1" style="color:black;background: none repeat scroll 0 0 transparent; border: 0 nonecolor: #000000; ;  font-size: 100%;">Online</option>

                <option <?php echo ($_SESSION[$db_prefix . '_UserStatus'] == 2) ? "selected=\"selected\"" : ""; ?> value="2" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;   font-size: 100%;">Namaz Break</option>
                <option <?php echo ($_SESSION[$db_prefix . '_UserStatus'] == 3) ? "selected=\"selected\"" : ""; ?> value="3" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;  font-size: 100%;">Lunch Break</option>
                <option <?php echo ($_SESSION[$db_prefix . '_UserStatus'] == 4) ? "selected=\"selected\"" : ""; ?> value="4" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;  font-size: 100%;">Tea Break</option>
                <option <?php echo ($_SESSION[$db_prefix . '_UserStatus'] == 5) ? "selected=\"selected\"" : ""; ?> value="5" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;  font-size: 100%;">Auxiliary Time</option>
                <option <?php echo ($_SESSION[$db_prefix . '_UserStatus'] == 6) ? "selected=\"selected\"" : ""; ?> value="6" style="background: none repeat scroll 0 0 transparent; border: 0 none;color: #000000;  font-size: 100%;">After Call Work (ACW)</option>
                <option <?php echo ($_SESSION[$db_prefix . '_UserStatus'] == 7) ? "selected=\"selected\"" : ""; ?> value="7" style="background: none repeat scroll 0 0 transparent; border: 0 none; color: #000000; font-size: 100%;">Campaign</option>

              </select>

              )
            <?php } ?>


            &nbsp;<?php echo ($_SESSION[$db_prefix . '_UserName'] == 'Admin') ? "| <a href=\"admin_change_password.php\">Password</a>" : ""; ?> &nbsp;|&nbsp;<a class="lgout" href="logout.php"><span></span>Logout</a> <br />
            <small>Last Login: <?php echo $_SESSION[$db_prefix . '_LLoginTime'];  ?></small>
          </div>


          <span class="clearFix">&nbsp;</span>
        </div>


        <span class="clearFix">&nbsp;</span>
      </div>
    </div>
  </div>


  <div class="menu_wrapper">
    <div class="container">
      <div class="wht_bg">
        <ul id="menu">
          <li class="selected"><a href="index.php"><span class="icon_home"></span><span class="txt">Home</span></a></li>

          <?php
          if (
            $ADMIN_ID1 == $_SESSION[$db_prefix . '_UserId'] ||
            $ADMIN_ID2 == $_SESSION[$db_prefix . '_UserId'] ||
            $ADMIN_ID3 == $_SESSION[$db_prefix . '_UserId'] ||
            $ADMIN_ID4 == $_SESSION[$db_prefix . '_UserId'] ||
            $ADMIN_ID5 == $_SESSION[$db_prefix . '_UserId'] ||
            $ADMIN_ID6 == $_SESSION[$db_prefix . '_UserId']
          ) {
          ?>

            <?php
            if (
              $rs_agent_name->fields["department"] != "Management"
            ) {
            ?>

              <li>

                <div class="top-level dropdown">
                  <a class="top-level dropbtn" onclick="myFunction()"><span class="icon_admin_setting"></span>Admin Settings<span class="arw">&nbsp;</span></a>

                  <div id="myDropdown" class="dropdown-content">
                    <a href="quick_links_new.php">Add Quick Links</a>
                    <a href="quick_links_list.php">Quick Links List</a>
                    <a href="faqs_new.php">FAQs Add</a>
                    <a href="faqs_list.php">FAQs List</a>
                    <a href="workcodes_list.php">Workcodes List</a>
                  </div>
                </div>
              </li>


              <li>
                <div class="top-level dropdown">
                  <a class="top-level dropbtn" onclick="myFunction2()"><span class="icon_setting"></span>Settings<span class="arw">&nbsp;</span></a>
                  <div id="myDropdown2" class="dropdown-content">
                    <a href="agent_session_reset.php">Agent Session Reset</a>
                  </div>
                </div>
              </li>

            <?php  } ?>
          <?php  } ?>
        </ul>
      </div>
    </div>
  </div>



  <div class="container">

    <div class="cont_bx">

      <?php if ($pageName != 'call_center_crm_detailed_report.php' && $pageName != 'call_center_crm_report.php' && $pageName != 'monthly-stats.php' && $pageName != 'summary_report.php' && $pageName != 'inbound-calls.php') {
        include($site_root . "includes/right_menu.php");
      } ?>
    </div>

    <div id="content">

      <?php if ($rs_agent_name->fields["department"] != "QA" && $rs_agent_name->fields["department"] != "Management") { ?>
        <div id="agent_status_bar">
          <?php include($site_root . "includes/agent_status_bar.php"); ?>
        </div>
      <?php } ?>

      <?php
      $pageName = basename($_SERVER['PHP_SELF']);
      if ($pageName != 'call_center_crm_detailed_report.php' && $pageName != 'call_center_crm_report.php' && $pageName != 'monthly-stats.php' && $pageName != 'summary_report.php' && $pageName != 'inbound-calls.php') {
        include($site_root . "includes/left_menu.php");
      } else { ?>
        <style>
          div#mid-col {
            width: 100% !important;

          }

          div#mid-col .tbl_resp {
            width: 100% !important;
            overflow-x: auto;

          }

          div#mid-col .tbl_resp .table-short {
            width: 150% !important;
          }
        </style>
      <?php } ?>
      <div id="mid-col">
        <?php include($site_root . "includes/message_panel.php"); ?>
        <?php
        $static_time_array = array('00:00:00', '01:00:00', '02:00:00', '03:00:00', '04:00:00', '05:00:00', '06:00:00', '07:00:00', '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00', '23:00:00');
        $static_hours_array = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23');
        $static_minutes_array = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47', '48', '49', '50', '51', '52', '53', '54', '55', '56', '57', '58', '59');
        ?>

        <script>
          /* When the user clicks on the button, 
            toggle between hiding and showing the dropdown content */
          function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
          }

          function myFunction2() {
            document.getElementById("myDropdown2").classList.toggle("show");
          }

          // Close the dropdown if the user clicks outside of it
          window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
              var dropdowns = document.getElementsByClassName("dropdown-content");
              var i;
              for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                  openDropdown.classList.remove('show');
                }
              }
            }
          }
        </script>