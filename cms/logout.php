<?php
/*********************************************************************
    logout.php

    Log out staff
    Destroy the session and redirect to login.php

    
    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require('staff.inc.php');

//Check token: Make sure the user actually clicked on the link to logout.
if(!$_GET['auth'] || !$ost->validateLinkToken($_GET['auth']))
    @header('Location: index.php');

	$thisstaff->logOut();
	$sql='UPDATE '.STAFF_TABLE.' SET is_logged_in=0';
	$sql.=' WHERE staff_id='.db_input($thisstaff->getId());
	 db_query($sql);
    
    $sql='UPDATE ts_login_activity  SET logout_datetime=NOW() ,status="1", update_datetime=NOW()';
	$sql.=' WHERE staff_id='.db_input($thisstaff->getId());
	db_query($sql);

//Clear any ticket locks the staff has.
TicketLock::removeStaffLocks($thisstaff->getId());

//Destroy session on logout.
// TODO: Stop doing this starting with 1.9 - separate session data per
// app/panel.
session_unset();
session_destroy();

osTicketSession::destroyCookie();

@header('Location: login.php');
require('login.php');
?>
