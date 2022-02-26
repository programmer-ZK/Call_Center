<?php
/*********************************************************************
    ajax.kbase.php

    AJAX interface for knowledge base related...allowed methods.

**********************************************************************/
if(!defined('INCLUDE_DIR')) die('!');


class KbaseAjaxAPI extends AjaxController {

    function cannedResp($id, $format='text') {
        global $thisstaff, $cfg;

        include_once(INCLUDE_DIR.'class.canned.php');

        if(!$id || !($canned=Canned::lookup($id)) || !$canned->isEnabled())
            Http::response(404, 'No such premade reply');

        if (!$cfg->isHtmlThreadEnabled())
            $format .= '.plain';

        return $canned->getFormattedResponse($format);
    }

    function faq($id, $format='html') {
        //XXX: user ajax->getThisStaff() (nolint)
        global $thisstaff;
        include_once(INCLUDE_DIR.'class.faq.php');

        if(!($faq=FAQ::lookup($id)))
            return null;

        //TODO: $fag->getJSON() for json format. (nolint)
        $resp = sprintf(
                '<div style="width:650px;">
                 <strong>%s</strong><div class="thread-body">%s</div>
                 <div class="clear"></div>
                 <div class="faded">'.__('Last updated %s').'</div>
                 <hr>
                 <a href="faq.php?id=%d">'.__('View').'</a> | <a href="faq.php?id=%d">'.__('Attachments (%d)').'</a>',
                $faq->getQuestion(),
                $faq->getAnswerWithImages(),
                Format::db_daydatetime($faq->getUpdateDate()),
                $faq->getId(),
                $faq->getId(),
                $faq->getNumAttachments());
        if($thisstaff && $thisstaff->canManageFAQ()) {
            $resp.=sprintf(' | <a href="faq.php?id=%d&a=edit">'.__('Edit').'</a>',$faq->getId());

        }
        $resp.='</div>';

        return $resp;
    }
}
?>
