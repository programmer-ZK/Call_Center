<?php
/*********************************************************************
    api.inc.php

**********************************************************************/
file_exists('../main.inc.php') or die('System Error');

// Disable sessions for the API. API should be considered stateless and
// shouldn't chew up database records to store sessions
if (!defined('DISABLE_SESSION'))
    define('DISABLE_SESSION', true);

require_once('main.inc.php');
require_once(INCLUDE_DIR.'class.http.php');
require_once(INCLUDE_DIR.'class.api.php');

?>
