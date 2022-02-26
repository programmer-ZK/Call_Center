<?php
/*********************************************************************
    http.php

**********************************************************************/
// Use sessions — it's important for SSO authentication, which uses
// /api/auth/ext
define('DISABLE_SESSION', false);

require 'api.inc.php';

# Include the main api urls
require_once INCLUDE_DIR."class.dispatcher.php";

$dispatcher = patterns('',
        url_post("^/tickets\.(?P<format>xml|json|email)$", array('api.tickets.php:TicketApiController','create')),
        url('^/tasks/', patterns('',
                url_post("^cron$", array('api.cron.php:CronApiController', 'execute'))
         ))
        );

Signal::send('api', $dispatcher);

# Call the respective function
print $dispatcher->resolve($ost->get_path_info());
?>
