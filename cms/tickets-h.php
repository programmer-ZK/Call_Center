<?php
/*************************************************************************
    tickets.php

**********************************************************************/

//require('staff.inc.php');
require 'client.inc.php';
require_once(INCLUDE_DIR.'class.ticket.php');
require_once(INCLUDE_DIR.'class.dept.php');
require_once(INCLUDE_DIR.'class.filter.php');
require_once(INCLUDE_DIR.'class.canned.php');
require_once(INCLUDE_DIR.'class.json.php');
require_once(INCLUDE_DIR.'class.dynamic_forms.php');
require_once(INCLUDE_DIR.'class.export.php');       // For paper sizes

$page='';

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
elseif (!isset($_REQUEST['advsid']) && @$_REQUEST['a'] != 'search'
    && !isset($_REQUEST['status']) && isset($_SESSION['::Q'])
) {
    $_REQUEST['status'] = $_SESSION['::Q'];
}
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

//At this stage we know the access status. we can process the post.
if($_POST && !$errors):

    if($ticket && $ticket->getId()) {
		
		}elseif($_POST['a']) {
        
        switch($_POST['a']) {
            case 'open':
                $ticket=null;
				 
                /*if(!$thisstaff || !$thisstaff->canCreateTickets()) {
					die('here1');
                     $errors['err'] = sprintf('%s %s',
                             sprintf(__('You do not have permission %s.'),
                                 __('to create tickets')),
                             __('Contact admin for such access'));*/
                //} else {
					
                    $vars = $_POST;
                    $vars['uid'] = $user? $user->getId() : 0;
                    $vars['cannedattachments'] = $response_form->getField('attachments')->getClean();
                   /* echo "<pre>";
                    print_r($vars);
                    echo "<pre>";
                    die;*/
                    /*if(($ticket=Ticket::open($vars, $errors))) {
                        $msg=__('Ticket created successfully');
                        $_REQUEST['a']=null;
                        if (!$ticket->checkStaffAccess($thisstaff) || $ticket->isClosed())
                            $ticket=null;
                        Draft::deleteForNamespace('ticket.staff%', $thisstaff->getId());
                        // Drop files from the response attachments widget
                        $response_form->setSource(array());
                        $response_form->getField('attachments')->reset();
                        unset($_SESSION[':form-data']);
                    } elseif(!$errors['err']) {
                        $errors['err']=__('Unable to create the ticket. Correct the error(s) and try again');
                    }*/
                //}
                break;
        }
    }
    /*if(!$errors)
        $thisstaff ->resetStats(); //We'll need to reflect any changes just made!*/
endif;

/*... Quick stats ...*/
//$stats= $thisstaff->getTicketsStats();

//Navigation
//$nav->setTabActive('tickets');
//$open_name = _P('queue-name',
    /* This is the name of the open ticket queue */
   // 'Open');?>
<?php /*?>  if($cfg->showAnsweredTickets()) {
    $nav->addSubMenu(array('desc'=>$open_name.' ('.number_format($stats['open']+$stats['answered']).')',
                            'title'=>__('Open Tickets'),
                            'href'=>'tickets.php?status=open',
                            'iconclass'=>'Ticket'),
                        (!$_REQUEST['status'] || $_REQUEST['status']=='open'));
} else {

    if ($stats) {

        $nav->addSubMenu(array('desc'=>$open_name.' ('.number_format($stats['open']).')',
                               'title'=>__('Open Tickets'),
                               'href'=>'tickets.php?status=open',
                               'iconclass'=>'Ticket'),
                            (!$_REQUEST['status'] || $_REQUEST['status']=='open'));
    }

    if($stats['answered']) {
        $nav->addSubMenu(array('desc'=>__('Answered').' ('.number_format($stats['answered']).')',
                               'title'=>__('Answered Tickets'),
                               'href'=>'tickets.php?status=answered',
                               'iconclass'=>'answeredTickets'),
                            ($_REQUEST['status']=='answered'));
    }
}

if($stats['assigned']) {

    $nav->addSubMenu(array('desc'=>__('My Tickets').' ('.number_format($stats['assigned']).')',
                           'title'=>__('Assigned Tickets'),
                           'href'=>'tickets.php?status=assigned',
                           'iconclass'=>'assignedTickets'),
                        ($_REQUEST['status']=='assigned'));
}

if($stats['overdue']) {
    $nav->addSubMenu(array('desc'=>__('Overdue').' ('.number_format($stats['overdue']).')',
                           'title'=>__('Stale Tickets'),
                           'href'=>'tickets.php?status=overdue',
                           'iconclass'=>'overdueTickets'),
                        ($_REQUEST['status']=='overdue'));

    if(!$sysnotice && $stats['overdue']>10)
        $sysnotice=sprintf(__('%d overdue tickets!'),$stats['overdue']);
}

if($thisstaff->showAssignedOnly() && $stats['closed']) {
    $nav->addSubMenu(array('desc'=>__('My Closed Tickets').' ('.number_format($stats['closed']).')',
                           'title'=>__('My Closed Tickets'),
                           'href'=>'tickets.php?status=closed',
                           'iconclass'=>'closedTickets'),
                        ($_REQUEST['status']=='closed'));
} else {

    $nav->addSubMenu(array('desc' => __('Closed').' ('.number_format($stats['closed']).')',
                           'title'=>__('Closed Tickets'),
                           'href'=>'tickets.php?status=closed',
                           'iconclass'=>'closedTickets'),
                        ($_REQUEST['status']=='closed'));
}

if($thisstaff->canCreateTickets()) {
    $nav->addSubMenu(array('desc'=>__('New Ticket'),
                           'title'=> __('Open a New Ticket'),
                           'href'=>'tickets.php?a=open',
                           'iconclass'=>'newTicket',
                           'id' => 'new-ticket'),
                        ($_REQUEST['a']=='open'));
}


$ost->addExtraHeader('<script type="text/javascript" src="js/ticket.js?19292ad"></script>');
$ost->addExtraHeader('<meta name="tip-namespace" content="tickets.queue" />',
    "$('#content').data('tipNamespace', 'tickets.queue');");

$inc = 'tickets.inc.php';
if($ticket) {
    $ost->setPageTitle(sprintf(__('Ticket #%s'),$ticket->getNumber()));
    $nav->setActiveSubMenu(-1);
    $inc = 'ticket-view.inc.php';
    if($_REQUEST['a']=='edit' && $thisstaff->canEditTickets()) {
        $inc = 'ticket-edit.inc.php';
        if (!$forms) $forms=DynamicFormEntry::forTicket($ticket->getId());
        // Auto add new fields to the entries
        foreach ($forms as $f) $f->addMissingFields();
    } elseif($_REQUEST['a'] == 'print' && !$ticket->pdfExport($_REQUEST['psize'], $_REQUEST['notes']))
        $errors['err'] = __('Internal error: Unable to export the ticket to PDF for print.');
} else {
	$inc = 'tickets.inc.php';
    if($_REQUEST['a']=='open' && $thisstaff->canCreateTickets())
        $inc = 'ticket-open.inc.php';
    elseif($_REQUEST['a'] == 'export') {
        $ts = strftime('%Y%m%d');
        if (!($token=$_REQUEST['h']))
            $errors['err'] = __('Query token required');
        elseif (!($query=$_SESSION['search_'.$token]))
            $errors['err'] = __('Query token not found');
        elseif (!Export::saveTickets($query, "tickets-$ts.csv", 'csv'))
            $errors['err'] = __('Internal error: Unable to dump query results');
    }

    //Clear active submenu on search with no status
    if($_REQUEST['a']=='search' && !$_REQUEST['status'])
        $nav->setActiveSubMenu(-1);

    //set refresh rate if the user has it configured
    if(!$_POST && !$_REQUEST['a'] && ($min=$thisstaff->getRefreshRate())) {
        $js = "clearTimeout(window.ticket_refresh);
               window.ticket_refresh = setTimeout($.refreshTicketView,"
            .($min*60000).");";
        $ost->addExtraHeader('<script type="text/javascript">'.$js.'</script>',
            $js);
    }
}<?php */?>
<?php
//echo STAFFINC_DIR.$inc;
//require_once(STAFFINC_DIR.'header.inc.php');
$inc ="tickets-open.php";
//echo STAFFINC_DIR;
//die;
require_once('include/staff/'.$inc);
//print $response_form->getMedia();
///require_once(STAFFINC_DIR.'footer.inc.php');
