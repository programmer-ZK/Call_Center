#!/usr/bin/php -q
<?php
/*********************************************************************
    pipe.php

**********************************************************************/
ini_set('memory_limit', '256M'); //The concern here is having enough mem for emails with attachments.
@chdir(dirname(__FILE__).'/'); //Change dir.
require('api.inc.php');

//Only local piping supported via pipe.php
if (!osTicket::is_cli())
    die(__('pipe.php only supports local piping - use http -> api/tickets.email'));

require_once(INCLUDE_DIR.'api.tickets.php');
PipeApiController::process();
?>
