        </div>
    </div>
    <div id="footer">
        <p>Copyright &copy; <?php echo date('Y'); ?> <?php echo (string) $ost->company ?: ''; ?> - All rights reserved.</p>
        <a id="poweredBy" href="http://convexinteractive.com" target="_blank"><?php echo __('Helpdesk software - powered by CRM'); ?></a>
    </div>
<div id="overlay"></div>
<div id="loading">
    <h4><?php echo __('Please Wait!');?></h4>
    <p><?php echo __('Please wait... it will take a second!');?></p>
</div>
<?php
if (($lang = Internationalization::getCurrentLanguage()) && $lang != 'en_US') { ?>
    <script type="text/javascript" src="ajax.php/i18n/<?php
        echo $lang; ?>/js"></script>
<?php } ?>
</body>
</html>
