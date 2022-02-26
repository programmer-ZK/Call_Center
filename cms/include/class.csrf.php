<?php
/*********************************************************************
    class.csrf.php

**********************************************************************/

Class CSRF {

    var $name;
    var $timeout;

    var $csrf;

    function CSRF($name='__CSRFToken__', $timeout=0) {

        $this->name = $name;
        $this->timeout = $timeout;
        $this->csrf = &$_SESSION['csrf'];
    }

    function reset() {
        $this->csrf = array();
    }

    function isExpired() {
       return ($this->timeout && (time()-$this->csrf['time'])>$this->timeout);
    }

    function getTokenName() {
        return $this->name;
    }

    function rotate() {
        $this->csrf['token'] = sha1(session_id().Crypto::random(16).SECRET_SALT);
        $this->csrf['time'] = time();
    }

    function getToken() {

        if (!$this->csrf['token'] || $this->isExpired()) {
            $this->rotate();
        } else {
            //Reset the timer
            $this->csrf['time'] = time();
        }

        return $this->csrf['token'];
    }

    function validateToken($token) {
        return ($token && trim($token)==$this->getToken() && !$this->isExpired());
    }

    function getFormInput($name='') {
        if(!$name) $name = $this->name;

        return sprintf('<input type="hidden" name="%s" value="%s" />', $name, $this->getToken());
    }
}

/* global function to add hidden token input with to forms */
function csrf_token() {
    global $ost;

    if($ost && $ost->getCSRF())
        echo $ost->getCSRFFormInput();
}
?>
