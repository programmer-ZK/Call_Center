</div>
</div>

<?php if (!isset($_SERVER['HTTP_X_PJAX'])) { ?>
    <!--<div id="footer">
        Copyright &copy; 2006-<?php //echo date('Y'); ?>&nbsp;<?php //echo (string) $ost->company ?: ''; ?>&nbsp;All Rights Reserved.
    </div>-->
<?php
if(is_object($thisstaff) && $thisstaff->isStaff()) { ?>
    <div>
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
        <img src="autocron.php" alt="" width="1" height="1" border="0" />
        <!-- Do not remove <img src="autocron.php" alt="" width="1" height="1" border="0" /> or your auto cron will cease to function -->
    </div>
<?php
} ?>
</div>
<style>
div#footer-wrap {
	/*background: url(images/footer_bg.jpg) left top no-repeat;*/
	background:#0c3779;
	height: 87px;
	background-size:100%;
	/*position: absolute;*/
	width: 100%;
	bottom: 0px;
	color:#ccc;
}
div#footer {
	width: 1300px;
	margin: 0 auto;
}
.right-foot a{
	color:#ccc;
	}
div#footer-top {
	color: #f2f2f2;
}
div#footer-top h4 {
	color: #fff;
	text-transform: uppercase;
	margin: 5px 0;
	font-size: 120%;
	font-weight: bold;
}
div#footer-top a {
	color: #adc3d3;
	font-weight: bold;
	font-size: 0.9em;
	text-decoration: none;
}
div#footer-top a:hover {
	color: #fff;
}
div#footer-top h2 {
	font-size: 160%;
	text-transform: uppercase;
	padding-top: 10px;
	padding-right: 10px;
	font-weight: bold;
}
div#footer-top h2 a {
	color: #a1a5a6;
}
div#footer-top h2 a:hover {
	color: #c7cdcf;
}
div#footer-bottom {
	margin-top: 25px;
	float: left;
	margin-right: 120px;
}
div#footer-bottom p {
	color: #fff;
	font-size: 14px;
	float: left;
	margin-top: 10px;
	line-height: 10px;
}
div#footer-bottom p a {
	color: #ccc;
	text-decoration: none;
	float:left;
	margin-top: -10px;
	margin-left: 10px;
}
div#footer-bottom p a + a {
	margin-top:1px;
}
div#footer-bottom p span {
	float:left;
}
div#footer-bottom p a img {
	float:left;
}
#form-container {
	display: inline-block;
	width: 392px;
	margin: 50px 0 0;
}
.login_logo {
	display: inline-block;
}

</style>
<div id="footer-wrap">
  <div id="footer"> 
   
    <div id="footer-bottom">
      <p><span>Design &amp; Developed by</span>  <a target="_blank" href="http://www.convexinteractive.com/"><img src="../images/footer_logo-2.png" alt="Convex Interactive" /></a>  
      <!--<a target="_blank" href="mailto:info@convexinteractive.com">info@convexinteractive.com</a>-->
        <!--via <a href="http://themeforest.net">Themeforest</a>--></p>
    </div>
    <!--<div class="footerright">
   <div class="right-foot"><p>Karachi Office: Suite 803, 8th Floor, Ibrahim Trade Tower, Shahrah-e-Faisal, Karachi, Pakistan. Ph: +92-21-34327748 – 9</p> </div>
      </div>
   <div class="footerright">
        <div class="right-foot"><p>Islamabad Office: Suite 803, 8th Floor, Ibrahim Trade Tower, Shahrah-e-Faisal, Karachi, Pakistan. Ph: +92-21-34327748 – 9</p>
     <span><img src="../images/mini-web.png" alt="website"><a target="_blank" href="http://www.convexinteractive.com/">www.convexinteractive.com</a></span> <span><img src="../images/mini-fb.png" alt="website"><a target="_blank" href="">/convexinteractive</a></span> <span><img src="../images/mini-tw.png" alt="website"><a target="_blank" href="">/convex_int</a></span> <span><img src="../images/mini-li.png" alt="website"><a target="_blank" href="">/company/convexinteractive</a></span> </div>
      </div>   -->
      
  </div>
</div>
<?php /*?><div id="footer-wrap">
	<div id="footer">
        <div id="footer-bottom">
        <p><span>Design &amp; Developed by</span>  <a target="_blank" href="http://www.convexinteractive.com/"><img src="../images/footer_logo-2.png" alt="Convex Interactive" /></a>  
          <a target="_blank" href="mailto:info@convexinteractive.com">info@convexinteractive.com</a>
        </p>
    </div>
	</div>
</div><?php */?>
<div id="overlay"></div>
<div id="loading">
    <i class="icon-spinner icon-spin icon-3x pull-left icon-light"></i>
    <h1><?php echo __('Loading ...');?></h1>
</div>
<div class="dialog draggable" style="display:none;width:650px;" id="popup">
    <div id="popup-loading">
        <h1 style="margin-bottom: 20px;"><i class="icon-spinner icon-spin icon-large"></i>
        <?php echo __('Loading ...');?></h1>
    </div>
    <div class="body"></div>
</div>
<div style="display:none;" class="dialog" id="alert">
    <h3><i class="icon-warning-sign"></i> <span id="title"></span></h3>
    <a class="close" href=""><i class="icon-remove-circle"></i></a>
    <hr/>
    <div id="body" style="min-height: 20px;"></div>
    <hr style="margin-top:3em"/>
    <p class="full-width">
        <span class="buttons pull-right">
            <input type="button" value="<?php echo __('OK');?>" class="close">
        </span>
     </p>
    <div class="clear"></div>
</div>

<script type="text/javascript">
if ($.support.pjax) {
  $(document).on('click', 'a', function(event) {
    if (!$(this).hasClass('no-pjax')
        && !$(this).closest('.no-pjax').length
        && $(this).attr('href')[0] != '#')
      $.pjax.click(event, {container: $('#pjax-container'), timeout: 2000});
  })
}
</script>
<?php
if ($thisstaff && $thisstaff->getLanguage() != 'en_US') { ?>
    <script type="text/javascript" src="ajax.php/i18n/<?php
        echo $thisstaff->getLanguage(); ?>/js"></script>
<?php } ?>
</body>
</html>
<?php } # endif X_PJAX ?>
