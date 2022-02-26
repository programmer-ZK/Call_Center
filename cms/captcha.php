<?php
/*********************************************************************
    captcha.php

    Simply returns captcha image.
    
    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
require_once('main.inc.php');
require(INCLUDE_DIR.'class.captcha.php');
$captcha = new Captcha(5,12,ROOT_DIR.'images/captcha/');
echo $captcha->getImage();
?>
