<?php
/*********************************************************************
    ajax.i18n.php

    Callbacks to get internaltionalized pieces for.

**********************************************************************/

if(!defined('INCLUDE_DIR')) die('!');

class i18nAjaxAPI extends AjaxController {
    function getLanguageFile($lang, $key) {
        global $cfg;

        $i18n = new Internationalization($lang);
        switch ($key) {
        case 'js':
            $data = $i18n->getTemplate('js/redactor.js')->getRawData();
            $data .= $i18n->getTemplate('js/jquery.ui.datepicker.js')->getRawData();
            // Strings from various javascript files
            $data .= $i18n->getTemplate('js/osticket-strings.js')->getRawData();
            header('Content-Type: text/javascript; charset=UTF-8');
            break;
        default:
            Http::response(404, 'No such i18n data');
        }

        Http::cacheable(md5($data), $cfg->lastModified());
        echo $data;
    }
}
?>
