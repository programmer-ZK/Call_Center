<?php
/*********************************************************************
    kb.inc.php

    File included on every knowledgebase file.

**********************************************************************/
require_once('../client.inc.php');
require_once(INCLUDE_DIR.'class.faq.php');
/* Bail out if knowledgebase is disabled or if we have no public-published FAQs. */
if(!$cfg || !$cfg->isKnowledgebaseEnabled() || !FAQ::countPublishedFAQs()) {
    header('Location: ../');
    exit;
}

$nav = new UserNav($thisclient, 'kb');
?>
