<?php
/*********************************************************************
    faq.php

    FAQs Clients' interface..

**********************************************************************/
require('kb.inc.php');
require_once(INCLUDE_DIR.'class.faq.php');

$faq=$category=null;
if($_REQUEST['id'] && !($faq=FAQ::lookup($_REQUEST['id'])))
   $errors['err']=sprintf(__('%s: Unknown or invalid'), __('FAQ article'));

if(!$faq && $_REQUEST['cid'] && !($category=Category::lookup($_REQUEST['cid'])))
    $errors['err']=sprintf(__('%s: Unknown or invalid'), __('FAQ category'));


$inc='knowledgebase.inc.php'; //FAQs landing page.
if($faq && $faq->isPublished()) {
    $inc='faq.inc.php';
} elseif($category && $category->isPublic() && $_REQUEST['a']!='search') {
    $inc='faq-category.inc.php';
}
require_once(CLIENTINC_DIR.'header.inc.php');
require_once(CLIENTINC_DIR.$inc);
require_once(CLIENTINC_DIR.'footer.inc.php');
?>
