<?php
/*********************************************************************
    h-users-view.php
**********************************************************************/
require 'client.inc.php';
require_once INCLUDE_DIR . 'class.client-h.php';
if ($_REQUEST['id'] && !($user=User::lookup($_REQUEST['id']))){
   echo $errors['err'] = sprintf(__('%s: Unknown or invalid'), _N('end user', 'end users', 1));
   die;
}
//echo "<pre>";
//print_r($user->ht['phone']);
//echo "</pre>";

/*$select = 'SELECT user.*, email.address as email, org.name as organization
          , account.id as account_id, account.status as account_status ';

$select .= 'FROM '.USER_TABLE.' user '
      . 'LEFT JOIN '.USER_EMAIL_TABLE.' email ON (user.id = email.user_id) '
      . 'LEFT JOIN '.ORGANIZATION_TABLE.' org ON (user.org_id = org.id) '
      . 'LEFT JOIN '.USER_ACCOUNT_TABLE.' account ON (account.user_id = user.id) ';

$select.='WHERE user.id='.$_REQUEST['id'];    
echo $select;
$result = db_query($select);
$data = db_fetch_array($result);  
print_r($data);*/
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html >
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="x-pjax-version" content="19292ad">
    <title>Staff Control Panel</title>
    <!--[if IE]>
    <style type="text/css">
        .tip_shadow { display:block !important; }
    </style>
    <![endif]-->
    <script type="text/javascript" src="/crm-merged/js/jquery-1.8.3.min.js?19292ad"></script>
    <script type="text/javascript" src="/crm-merged/js/jquery-ui-1.10.3.custom.min.js?19292ad"></script>
    <script type="text/javascript" src="./js/scp.js?19292ad"></script>
    <script type="text/javascript" src="/crm-merged/js/jquery.pjax.js?19292ad"></script>
    <script type="text/javascript" src="/crm-merged/js/filedrop.field.js?19292ad"></script>
    <script type="text/javascript" src="/crm-merged/js/jquery.multiselect.min.js?19292ad"></script>
    <script type="text/javascript" src="./js/tips.js?19292ad"></script>
    <script type="text/javascript" src="/crm-merged/js/redactor.min.js?19292ad"></script>
    <script type="text/javascript" src="/crm-merged/js/redactor-osticket.js?19292ad"></script>
    <script type="text/javascript" src="/crm-merged/js/redactor-fonts.js?19292ad"></script>
    <script type="text/javascript" src="./js/bootstrap-typeahead.js?19292ad"></script>
    <link rel="stylesheet" href="/crm-merged/css/thread.css?19292ad" media="all"/>
    <link rel="stylesheet" href="./css/scp.css?19292ad" media="all"/>
    <link rel="stylesheet" href="/crm-merged/css/redactor.css?19292ad" media="screen"/>
    <link rel="stylesheet" href="./css/typeahead.css?19292ad" media="screen"/>
    <link type="text/css" href="/crm-merged/css/ui-lightness/jquery-ui-1.10.3.custom.min.css?19292ad"
         rel="stylesheet" media="screen" />
     <link type="text/css" rel="stylesheet" href="/crm-merged/css/font-awesome.min.css?19292ad"/>
     <link type="text/css" rel="stylesheet" href="/crm-merged//css/bootstrap.css"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/crm-merged/css/font-awesome-ie7.min.css?19292ad"/>
    <![endif]-->
    <link type="text/css" rel="stylesheet" href="./css/dropdown.css?19292ad"/>
    <link type="text/css" rel="stylesheet" href="/crm-merged/css/loadingbar.css?19292ad"/>
    <link type="text/css" rel="stylesheet" href="/crm-merged/css/rtl.css?19292ad"/>
    <script type="text/javascript" src="./js/jquery.dropdown.js?19292ad"></script>

    
    <meta name="csrf_token" content="3e9e37a1fbfc1bca45bf1fd1e678a3a715a48246" />
</head>
<body>
<div id="container">
       
    <div id="pjax-container" class="">
    
    <div id="content">
        <table width="940" cellpadding="2" cellspacing="0" border="0">
    <tr>
        <td width="50%" class="has_bottom_border">
             <h2><a href="h-users-view.php?id=<?php echo $user->getId(); ?>"
             title="Reload"><i class="icon-refresh"></i> <?php echo  $user->getName(); ?></a></h2>
        </td>
       
    </tr>
</table>

<table class="ticket_info" cellspacing="0" cellpadding="0" width="940" border="0">
    <tr>
        <td width="50%">
            <table border="0" cellspacing="" cellpadding="4" width="100%">
                <tr>
                    <th width="150">Name:</th>
                    <td><b></i>&nbsp;<?php echo  $user->getName(); ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>
                        <span id="user-4-email"><?php echo $user->getEmail();?></span>
                    </td>
                </tr>
                <tr>
                    <th>Phone:</th>
                    <td>
                        <span id="user-4-phone">
                          <?php echo $user->ht['phone'];?>
                        </span>
                    </td>
                </tr>
                <tr>
                <td>
                 
                </td>
                </tr>
            </table>
        </td>
        <td width="50%" style="vertical-align:top">
            <table border="0" cellspacing="" cellpadding="4" width="100%">
                <tr>
                    <th width="150">Status:</th>
                    <td> <span id="user-4-status"><?php echo $user->getAccountStatus(); ?></span></td>
                </tr>
                <tr>
                    <th>Created:</th>
                    <td><?php echo Format::db_datetime($user->getCreateDate()); ?></td>
                </tr>
                <tr>
                    <th>Updated:</th>
                    <td><?php echo Format::db_datetime($user->getUpdateDate()); ?></td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>
<br>
<div class="clear"></div>
<ul class="tabs">
    <li><a class="active" id="tickets_tab" href="#tickets"><i
    class="icon-list-alt"></i>&nbsp;User Tickets</a></li>
    <!-- <li><a id="notes_tab" href="#notes"><i
    class="icon-pushpin"></i>&nbsp;Notes</a></li> -->
</ul>
<div id="tickets" class="tab_content">
<?php
include 'include/staff/templates/h-tickets.tmpl.php';
?>
</div>

<script type="text/javascript">
$(function() {
    $(document).on('click', 'a.user-action', function(e) {
        e.preventDefault();
        var url = 'ajax.php/'+$(this).attr('href').substr(1);
        $.dialog(url, [201, 204], function (xhr) {
            if (xhr.status == 204)
                window.location.href = 'users.php';
            else
                window.location.href = window.location.href;
            return false;
         }, {
            onshow: function() { $('#user-search').focus(); }
         });
        return false;
    });
});
</script>
</div>
</div>
    <div id="footer">
        Copyright &copy; 2006-2015&nbsp;&nbsp;All Rights Reserved.
    </div>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="autocron.php" alt="" width="1" height="1" border="0" />
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>
</div>
<div id="overlay"></div>
<div id="loading">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1>Loading ...</h1>
</div>
<div class="dialog draggable" style="display:none;width:650px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        Loading ...</h1>
    </div>
    <div class="body"></div>
</div>
<div style="display:none;" class="dialog" id="alert">
    <h3><i class="icon-warning-sign"></i> <span id="title"></span></h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr/>
    <div id="body" style="min-height: 20px;"></div>
    <hr style="margin-top:3em"/>
    <p class="full-width">
        <span class="buttons pull-right">
            <input type="button" value="OK" class="close">
        </span>
     </p>
    <div class="clear"></div>
</div>

<script type="text/javascript">
if ($.support.pjax) {
  $(document).on('click', 'a', function(event) {
    if (!$(this).hasClass('no-pjax')
        && !$(this).closest('.no-pjax').length
        && $(this).attr('href')[0] != '#')
      $.pjax.click(event, {container: $('#pjax-container'), timeout: 2000});
  })
}
</script>
</body>
</html>

