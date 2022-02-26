<?php
/*************************************************************************

**********************************************************************/
/*require('staff.inc.php');*/
//require_once('include/class.dynamic_forms.php');
//define('INCLUDE_DIR','include/');
require 'client.inc.php';
/*require_once(INCLUDE_DIR.'class.ticket.php');
require_once(INCLUDE_DIR.'class.dept.php');
require_once(INCLUDE_DIR.'class.filter.php');
require_once(INCLUDE_DIR.'class.canned.php');
require_once(INCLUDE_DIR.'class.json.php');
require_once(INCLUDE_DIR.'class.export.php');*/       // For paper sizes
require_once(INCLUDE_DIR.'class.dynamic_forms.php');
require_once INCLUDE_DIR . 'class.client-h.php';
//Lookup user if id is available.
if ($_REQUEST['uid']) {
    $user = User::lookup($_REQUEST['uid']);
}
/*elseif (!isset($_REQUEST['advsid']) && @$_REQUEST['a'] != 'search'
    && !isset($_REQUEST['status']) && isset($_SESSION['::Q'])
) {
    $_REQUEST['status'] = $_SESSION['::Q'];
}*/
// Configure form for file uploads
$response_form = new Form(array(
    'attachments' => new FileUploadField(array('id'=>'attach',
        'name'=>'attach:response',
        'configuration' => array('extensions'=>'')))
));
$note_form = new Form(array(
    'attachments' => new FileUploadField(array('id'=>'attach',
        'name'=>'attach:note',
        'configuration' => array('extensions'=>'')))
));

$page='';
if($_POST['a']) {
    switch($_POST['a']) {
            case 'open':
                $ticket=null;

                    $vars = $_POST;
                    $vars['uid'] = $user? $user->getId() : 0;
                    $vars['cannedattachments'] = $response_form->getField('attachments')->getClean();
                     if($vars['priority_level']){
                        $result = db_query('SELECT priority_desc FROM '.TICKET_PRIORITY_TABLE
                            .' WHERE priority_id='.db_input($vars['priority_level'])
                            .' limit 1');
                        $r = db_fetch_array($result); 
                      $vars['priority_desc'] = $r['priority_desc']; 
                    }     
                    echo "<pre>";
                    $vars['number']=  mt_rand(100000, 999999);
                    print_r($vars);
                    echo "<pre>";
                    die;
                    db_query('INSERT INTO '.TICKET_TABLE
                        .' SET number='.db_input($vars['number'])
                        .', user_id='.db_input($vars['uid'])
                        .', status_id='.db_input($vars['statusId'])
                        .', dept_id='.db_input($vars['deptId'])
                        .', sla_id='.db_input($vars['slaId'])
                        .', topic_id='.db_input($vars['topicId'])
                        .', ip_address='.$_SERVER['REMOTE_ADDR']
                        .', source='.db_input($vars['source'])
                        .', duedate='.db_input($vars['duedate'].''.$vars['time'])
                        .', lastmessage='.db_input($vars['number'])
                        .', created='.db_input(date("Y-m-d H:i:s"))
                        .', updated='.db_input(date("Y-m-d H:i:s")));
                    $ticket_id =  db_insert_id();
                    //ticket__cdata

                    if($ticket_id){

                    db_query('INSERT INTO ost__search'
                        .' SET object_type=T'
                        .', object_id='.$ticket_id
                        .', title='.db_input($vars['number']." ".$vars['issue_summery'])
                        .', content='.db_input($vars['issue_summery']));
                        if($vars['message']){
                        db_query('INSERT INTO '.TICKET_THREAD_TABLE
                        .' SET ticket_id='.$ticket_id
                        .', user_id='.db_input($vars['uid'])
                        .', thread_type=M'
                        .', poster=SYSTEM'
                        .', source='.db_input($vars['source'])
                        .', title=New Ticket'
                        .', body='.db_input($vars['message'])
                        .', format=html'
                        .', ip_address='.$_SERVER['REMOTE_ADDR']
                        .', created='.db_input(date("Y-m-d H:i:s")));
                        }
                        if($vars['note']){
                        db_query('INSERT INTO '.TICKET_THREAD_TABLE
                        .' SET ticket_id='.$ticket_id
                        .', thread_type=N'
                        .', poster=SYSTEM'
                        .', title=New Ticket'
                        .', body='.db_input($vars['note'])
                        .', format=html'
                        .', ip_address='.$_SERVER['REMOTE_ADDR']
                        .', created='.db_input(date("Y-m-d H:i:s")));
                       }
                        db_query('INSERT INTO ost_ticket__cdata'
                        .' SET ticket_id='.$ticket_id
                        .', subject='.db_input($vars['issue_summery'])
                        .', priority='.db_input($vars['priority_level']));

                        db_query('INSERT INTO '.FORM_ENTRY_TABLE 
                                .' SET form_id=2'
                                .', object_id='.$ticket_id
                                .', object_type=T'
                                .', sort=1'
                                .', created='.db_input(date("Y-m-d H:i:s"))
                                .', updated='.db_input(date("Y-m-d H:i:s")));
                             }

                             $form_entry_id =  db_insert_id();
                            if($form_entry_id){
                             db_query('INSERT INTO '.FORM_ENTRY_VALUES_TABLE 
                                .' SET entry_id='.$form_entry_id
                                .', field_id=20'
                                .', value='.db_input($vars['issue_summery']));

                             db_query('INSERT INTO '.FORM_ENTRY_VALUES_TABLE 
                                .' SET entry_id='.$form_entry_id
                                .', field_id=22'
                                .', value='.db_input($vars['priority_desc']));

                        }

                    


                   /* if(($ticket=Ticket::open($vars, $errors))) {
                       echo  $msg=__('Ticket created successfully');
                        $_REQUEST['a']=null;
                        if (!$ticket->checkStaffAccess($thisstaff) || $ticket->isClosed())
                            $ticket=null;
                        Draft::deleteForNamespace('ticket.staff%', $thisstaff->getId());
                        // Drop files from the response attachments widget
                        $response_form->setSource(array());
                        $response_form->getField('attachments')->reset();
                        unset($_SESSION[':form-data']);
                    } elseif(!$errors['err']) {
                       echo $errors['err']=__('Unable to create the ticket. Correct the error(s) and try again');
                    }*/
                //}
                break;
        } 
 
}

/*//die('here');
$ticket = $user = null; //clean start.
//LOCKDOWN...See if the id provided is actually valid and if the user has access.
if($_REQUEST['id']) {
    if(!($ticket=Ticket::lookup($_REQUEST['id'])))
         $errors['err']=sprintf(__('%s: Unknown or invalid ID.'), __('ticket'));
    elseif(!$ticket->checkStaffAccess($thisstaff)) {
        $errors['err']=__('Access denied. Contact admin if you believe this is in error');
        $ticket=null; //Clear ticket obj.
    }
}

//Lookup user if id is available.
if ($_REQUEST['uid']) {
    $user = User::lookup($_REQUEST['uid']);
}
//print_r($user);

$info=array();
$info=Format::htmlchars(($errors && $_POST)?$_POST:$info);
//print_r($info);
if (!$info['topicId'])
    $info['topicId'] = $cfg->getDefaultTopicId();

$form = null;
if ($info['topicId'] && ($topic=Topic::lookup($info['topicId']))) {
    $form = $topic->getForm();
    if ($_POST && $form) {
        $form = $form->instanciate();
        $form->isValid();
    }
}
*/
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

    
    <meta name="csrf_token" content="3cd65e9c39b90a1a82cc149e551b4db57921323f" />
    <script type="text/javascript" src="js/ticket.js?19292ad"></script>
    <meta name="tip-namespace" content="tickets.queue" />
</head>
<body>
<div id="container"><div id="pjax-container" class="">
    <div id="content">
        <form action="tickets-open.php?a=open" method="post" id="save"  enctype="multipart/form-data">
 <?php csrf_token(); ?>
 <input type="hidden" name="do" value="create">
 <input type="hidden" name="a" value="open">
 <h2><?php echo __('Open a New Ticket');?></h2>
 <table class="form_table fixed" width="940" border="0" cellspacing="0" cellpadding="2">
    <thead>
    <!-- This looks empty - but beware, with fixed table layout, the user
         agent will usually only consult the cells in the first row to
         construct the column widths of the entire toable. Therefore, the
         first row needs to have two cells -->
        <tr><td></td><td></td></tr>
        <tr>
            <th colspan="2">
                <h4><?php echo __('New Ticket');?></h4>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="2">
                <em><strong><?php echo __('User Information'); ?></strong>: </em>
            </th>
        </tr>
        <?php
        if ($user) { ?>
        <tr><td><?php echo __('User'); ?>:</td><td>
            <div id="user-info">
                <input type="hidden" name="uid" id="uid" value="<?php echo $user->getId(); ?>" />
            <a href="#" onclick="javascript:
                $.userLookup('ajax.php/users/<?php echo $user->getId(); ?>/edit',
                        function (user) {
                            $('#user-name').text(user.name);
                            $('#user-email').text(user.email);
                        });
                return false;
                "><i class="icon-user"></i>
                <span id="user-name"><?php echo Format::htmlchars($user->getName()); ?></span>
                &lt;<span id="user-email"><?php echo $user->getEmail(); ?></span>&gt;
                </a>
                <a class="action-button" style="overflow:inherit" href="#"
                    onclick="javascript:
                        $.userLookup('ajax.php/users/select/'+$('input#uid').val(),
                            function(user) {
                                $('input#uid').val(user.id);
                                $('#user-name').text(user.name);
                                $('#user-email').text('<'+user.email+'>');
                        });
                        return false;
                    "><i class="icon-edit"></i> <?php echo __('Change'); ?></a>
            </div>
        </td></tr>
        <?php
        } else { //Fallback: Just ask for email and name
            ?>
        <tr>
            <td width="160" class="required"> <?php echo __('Email Address'); ?>: </td>
            <td>
                <span style="display:inline-block;">
                    <input type="text" size=45 name="email" id="user-email"
                        autocomplete="off" autocorrect="off" value="<?php echo $info['email']; ?>" /> </span>
                <font class="error">* <?php echo $errors['email']; ?></font>
            </td>
        </tr>
        <tr>
            <td width="160" class="required"> <?php echo __('Full Name'); ?>: </td>
            <td>
                <span style="display:inline-block;">
                    <input type="text" size=45 name="name" id="user-name" value="<?php echo $info['name']; ?>" /> </span>
                <font class="error">* <?php echo $errors['name']; ?></font>
            </td>
        </tr>
        <?php
        } ?>

        <?php
        if($cfg->notifyONNewStaffTicket()) {  ?>
        <tr>
            <td width="160"><?php echo __('Ticket Notice'); ?>:</td>
            <td>
            <input type="checkbox" name="alertuser" <?php echo (!$errors || $info['alertuser'])? 'checked="checked"': ''; ?>><?php
                echo __('Send alert to user.'); ?>
            </td>
        </tr>
        <?php
        } ?>
    </tbody>

     <tbody>
        <tr>
            <th colspan="2">
                <em><strong><?php echo __('Ticket Information and Options');?></strong>:</em>
            </th>
        </tr>
        <tr>
            <td width="160" class="required">
                <?php echo __('Ticket Source');?>:
            </td>
            <td>
                <select name="source">
                    <option value="Phone" selected="selected"><?php echo __('Phone'); ?></option>
                    <option value="Email" <?php echo ($info['source']=='Email')?'selected="selected"':''; ?>><?php echo __('Email'); ?></option>
                    <option value="Other" <?php echo ($info['source']=='Other')?'selected="selected"':''; ?>><?php echo __('Other'); ?></option>
                </select>
                &nbsp;<font class="error"><b>*</b>&nbsp;<?php echo $errors['source']; ?></font>
            </td>
        </tr>
      

        <tr>
            <td width="160" class="required">
                <?php echo __('Help Topic'); ?>:
            </td>
            <td>
                <select name="topicId" onchange="javascript:
                        var data = $(':input[name]', '#dynamic-form').serialize();
                        $.ajax(
                          'ajax.php/form/help-topic/' + this.value,
                          {
                            data: data,
                            dataType: 'json',
                            success: function(json) {
                              $('#dynamic-form').empty().append(json.html);
                              $(document.head).append(json.media);
                            }
                          });">
                    <?php
                    if ($topics=Topic::getHelpTopics()) {
                        if (count($topics) == 1)
                            $selected = 'selected="selected"';
                        else { ?>
                        <option value="" selected >&mdash; <?php echo __('Select Help Topic'); ?> &mdash;</option>
<?php                   }
                        foreach($topics as $id =>$name) {
                            echo sprintf('<option value="%d" %s %s>%s</option>',
                                $id, ($info['topicId']==$id)?'selected="selected"':'',
                                $selected, $name);
                        }
                        if (count($topics) == 1 && !$form) {
                            if (($T = Topic::lookup($id)))
                                $form =  $T->getForm();
                        }
                    }
                    ?>
                </select>
                &nbsp;<font class="error"><b>*</b>&nbsp;<?php echo $errors['topicId']; ?></font>
            </td>
        </tr>
           

        <tr>
            <td width="160">
                <?php echo __('Department'); ?>:
            </td>
            <td>
                <select name="deptId">
                    <option value="" selected >&mdash; <?php echo __('Select Department'); ?>&mdash;</option>
                    <?php
                    if($depts=Dept::getDepartments()) {
                        foreach($depts as $id =>$name) {
                            echo sprintf('<option value="%d" %s>%s</option>',
                                    $id, ($info['deptId']==$id)?'selected="selected"':'',$name);
                        }
                    }
                    ?>
                </select>
                &nbsp;<font class="error"><?php echo $errors['deptId']; ?></font>
            </td>
        </tr>


        <tr>
            <td width="160">
                <?php echo __('SLA Plan');?>:
            </td>
            <td>
                <select name="slaId">
                    <option value="0" selected="selected" >&mdash; <?php echo __('System Default');?> &mdash;</option>
                    <?php
                    if($slas=SLA::getSLAs()) {
                        foreach($slas as $id =>$name) {
                            echo sprintf('<option value="%d" %s>%s</option>',
                                    $id, ($info['slaId']==$id)?'selected="selected"':'',$name);
                        }
                    }
                    ?>
                </select>
                &nbsp;<font class="error">&nbsp;<?php echo $errors['slaId']; ?></font>
            </td>
         </tr>

          <tr>
            <td width="160">
                <?php echo __('Due Date');?>:
            </td>
            <td>
                <input class="dp" id="duedate" name="duedate" value="<?php echo Format::htmlchars($info['duedate']); ?>" size="12" autocomplete=OFF>
                &nbsp;&nbsp;
                <?php
                $min=$hr=null;
                if($info['time'])
                    list($hr, $min)=explode(':', $info['time']);

                echo Misc::timeDropdown($hr, $min, 'time');
                ?>
                &nbsp;<font class="error">&nbsp;<?php echo $errors['duedate']; ?> &nbsp; <?php echo $errors['time']; ?></font>
                <em></em>
            </td>
        </tr>
        <?php
        //if($thisstaff->canAssignTickets()) { ?>
        <!-- <tr>
            <td width="160"><?php echo __('Assign To');?>:</td>
            <td>
                <select id="assignId" name="assignId">
                    <option value="0" selected="selected">&mdash; <?php echo __('Select an Agent OR a Team');?> &mdash;</option>
                    <?php
                    if(($users=Staff::getAvailableStaffMembers())) {
                        echo '<OPTGROUP label="'.sprintf(__('Agents (%d)'), count($users)).'">';
                        foreach($users as $id => $name) {
                            $k="s$id";
                            echo sprintf('<option value="%s" %s>%s</option>',
                                        $k,(($info['assignId']==$k)?'selected="selected"':''),$name);
                        }
                        echo '</OPTGROUP>';
                    }

                    if(($teams=Team::getActiveTeams())) {
                        echo '<OPTGROUP label="'.sprintf(__('Teams (%d)'), count($teams)).'">';
                        foreach($teams as $id => $name) {
                            $k="t$id";
                            echo sprintf('<option value="%s" %s>%s</option>',
                                        $k,(($info['assignId']==$k)?'selected="selected"':''),$name);
                        }
                        echo '</OPTGROUP>';
                    }
                    ?>
                </select>&nbsp;<span class='error'>&nbsp;<?php echo $errors['assignId']; ?></span>
            </td>
        </tr> -->
        <?php //} ?>
        </tbody>
        <tbody id="dynamic-form">
        <?php
           /* if ($form) {
                print $form->getForm()->getMedia();
                include('include/staff/templates/dynamic-form.tmpl.php');
            }*/
        ?>
        </tbody>
         <tbody> <?php
        /*$tform = TicketForm::getInstance();
        //if ($_POST && !$tform->errors())
           //$tform->isValidForStaff();
        $tform->render(false);*/
        ?>
       <!--  <tr> 
            <td class="multi-line " style="min-width:120px;" >
                Priority Level:</td>
                <td><div style="position:relative">        
                <select name="ac853102e8d9c58f[]"
                       id="_ac853102e8d9c58f"  data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                            <option value="1" >Low</option>
                            <option value="2" >Normal</option>
                            <option value="3" >High</option>
                            <option value="4" >Emergency</option>
                    </select>
            </div></td>
        </tr>
         <tr>
                <td width="100">Ticket Status:</td>
                <td>
                    <select name="statusId">
                    <option value="1" selected="selected">Open</option><option value="2" >Resolved</option><option value="3" >Closed</option>                    </select>
                </td>
            </tr> -->
        </tbody>
       
         <tbody id="dynamic-form">
                </tbody>
        <tbody>     <tr><td style="width:150px;"></td><td></td></tr>
    <tr><th colspan="2">
        <em><strong>Ticket Details</strong>:
        Please Describe Your Issue</em>
    </th></tr>
            <tr>                <td class="multi-line required" style="min-width:120px;" >
                Issue Summary:</td>
                <td><div style="position:relative">        <span style="display:inline-block">
        <input type="text" id="issue_summery" size="40" maxlength="50" placeholder="" name="issue_summery"
            value=""/>
        </span>
                                    <font class="error">*</font>
                        </div></td>
        </tr>
            <tr>                <td colspan="2">
                <div style="margin-bottom:0.5em;margin-top:0.5em"><strong>Issue Details</strong>:</div>
        <textarea style="width:100%;" name="message"
            placeholder="Details on the reason(s) for opening the ticket."
                            data-draft-namespace="ticket.staff"
                        class="richtext draft draft-delete ifhtml"
            cols="21" rows="8" style="width:80%;"></textarea>
   <!--  <div id="7df100a2029eb5a3971d55" class="filedrop"><div class="files"></div>
            <div class="dropzone"><i class="icon-upload"></i>
            Drop files here or <a href="#" class="manual"> choose them </a>        <input type="file" multiple="multiple"
            id="file-7df100a2029eb5a3971d55" style="display:none;"
            accept=""/>
        </div></div>
        <script type="text/javascript">
        $(function(){$('#7df100a2029eb5a3971d55 .dropzone').filedropbox({
          url: 'ajax.php/form/upload/attach',
          link: $('#7df100a2029eb5a3971d55').find('a.manual'),
          paramname: 'upload[]',
          fallback_id: 'file-7df100a2029eb5a3971d55',
          allowedfileextensions: [],
          allowedfiletypes: [],
          maxfiles: 20,
          maxfilesize: 1,
          name: 'attach:21[]',
          files: []        });});
        </script>
        <link rel="stylesheet" type="text/css" href="/crm-merged/css/filedrop.css"/>                            <font class="error">*</font>
                        </div> --></td>
        </tr>
            <tr> 
            <td class="multi-line " style="min-width:120px;" >
                Priority Level:</td>
                <td><div style="position:relative">        
                <select name="priority_level" id="priority_level" data-prompt="Select">
                        <option value="">&mdash; Select &mdash;</option>
                            <option value="1" >Low</option>
                            <option value="2" >Normal</option>
                            <option value="3" >High</option>
                            <option value="4" >Emergency</option>
                    </select>
                                </div></td>
        </tr>
           <!--  <link rel="stylesheet" type="text/css" href="/crm-merged/css/jquery.multiselect.css"/>     -->    
            </tbody>
        <tbody> 
               <!--  <tr>
            <th colspan="2">
                <em><strong>Response</strong>: Optional response to the above issue.</em>
            </th>
        </tr>
        <tr>
            <td colspan=2>
                            <div style="margin-top:0.3em;margin-bottom:0.5em">
                    Canned Response:&nbsp;
                    <select id="cannedResp" name="cannedResp">
                        <option value="0" selected="selected">&mdash; Select a canned response &mdash;</option>
                        <option value="2">Sample (with variables)</option><option value="1">What is osTicket (sample)?</option>                    </select>
                    &nbsp;&nbsp;&nbsp;
                    <label><input type='checkbox' value='1' name="append" id="append" checked="checked">Append</label>
                </div>
                            <textarea class="richtext ifhtml draft draft-delete"
                    data-draft-namespace="ticket.staff.response"
                    data-signature=""
                    data-signature-field="signature" data-dept-field="deptId"
                    placeholder="Initial response for the ticket"
                    name="response" id="response" cols="21" rows="8"
                    style="width:80%;"></textarea>
                    <div class="attachments">
<div id="8f372aa2cc2ce0c8cf0d3a" class="filedrop"><div class="files"></div>
            <div class="dropzone"><i class="icon-upload"></i>
            Drop files here or <a href="#" class="manual"> choose them </a>        <input type="file" multiple="multiple"
            id="file-8f372aa2cc2ce0c8cf0d3a" style="display:none;"
            accept=""/>
        </div></div>
        <script type="text/javascript">
        $(function(){$('#8f372aa2cc2ce0c8cf0d3a .dropzone').filedropbox({
          url: 'ajax.php/form/upload/attach',
          link: $('#8f372aa2cc2ce0c8cf0d3a').find('a.manual'),
          paramname: 'upload[]',
          fallback_id: 'file-8f372aa2cc2ce0c8cf0d3a',
          allowedfileextensions: [],
          allowedfiletypes: [],
          maxfiles: 20,
          maxfilesize: 1,
          name: 'attach:response[]',
          files: []        });});
        </script>
                    </div>

                <table border="0" cellspacing="0" cellpadding="2" width="100%">
            <tr>
                <td width="100">Ticket Status:</td>
                <td>
                    <select name="statusId">
                    <option value="1" selected="selected">Open</option><option value="2" >Resolved</option><option value="3" >Closed</option>                    </select>
                </td>
            </tr>
             <tr>
                <td width="100">Signature:</td>
                <td>
                                        <label><input type="radio" name="signature" value="none" checked="checked"> None</label>
                                        <label><input type="radio" name="signature" value="dept"
                        > Department Signature (if set)</label>
                </td>
             </tr>
            </table>
            </td>
        </tr> -->
          <tr>
                <td width="100">Ticket Status:</td>
                <td>
                    <select name="statusId">
                    <option value="1" selected="selected">Open</option><option value="2" >Resolved</option><option value="3" >Closed</option>                    </select>
                </td>
            </tr>
                <tr>
            <th colspan="2">
                <em><strong><?php echo __('Internal Note');?></strong>
                <font class="error">&nbsp;<?php echo $errors['note']; ?></font></em>
            </th>
        </tr>

        <tr>
            <td colspan=2>
                <textarea class="richtext ifhtml draft draft-delete"
                    placeholder="<?php echo __('Optional internal note (recommended on assignment)'); ?>"
                    data-draft-namespace="ticket.staff.note" name="note"
                    cols="21" rows="6" style="width:80%;"
                    ><?php echo $info['note']; ?></textarea>
            </td>
        </tr>
    </tbody>
</table>
<p style="text-align:center;">
    <input type="submit" name="submit" value="<?php echo _P('action-button', 'Open');?>">
    <input type="reset"  name="reset"  value="<?php echo __('Reset');?>">
    <input type="button" name="cancel" value="<?php echo __('Cancel');?>" onclick="javascript:
        $('.richtext').each(function() {
            var redactor = $(this).data('redactor');
            if (redactor && redactor.opts.draftDelete)
                redactor.deleteDraft();
        });
        window.location.href='tickets-h.php';
    ">
</p>
</form>
<script type="text/javascript">
$(function() {
    $('input#user-email').typeahead({
        source: function (typeahead, query) {
            $.ajax({
                url: "ajax.php/users?q="+query,
                dataType: 'json',
                success: function (data) {
                    typeahead.process(data);
                }
            });
        },
        onselect: function (obj) {
            $('#uid').val(obj.id);
            $('#user-name').val(obj.name);
            $('#user-email').val(obj.email);
        },
        property: "/bin/true"
    });

   });
</script>

        <link rel="stylesheet" type="text/css" href="/crm-merged/css/filedrop.css"/></div>
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
