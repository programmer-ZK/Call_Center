<?php
/*********************************************************************
    dispatcher.php

    Dispatcher for staff applications
    
**********************************************************************/
# Override staffLoginPage() defined in staff.inc.php to return an
# HTTP/Forbidden status rather than the actual login page.
# XXX: This should be moved to the AjaxController class
function staffLoginPage($msg='Unauthorized') {
    Http::response(403,'Must login: '.Format::htmlchars($msg));
    exit;
}

require('staff.inc.php');

//Clean house...don't let the world see your crap.
ini_set('display_errors', '0'); // Set by installer
ini_set('display_startup_errors', '0'); // Set by installer

//TODO: disable direct access via the browser? i,e All request must have REFER?
if(!defined('INCLUDE_DIR'))	Http::response(500, 'Server configuration error');

require_once INCLUDE_DIR.'/class.dispatcher.php';
$dispatcher = new Dispatcher();

Signal::send('apps.scp', $dispatcher);

# Call the respective function
print $dispatcher->resolve($ost->get_path_info());
