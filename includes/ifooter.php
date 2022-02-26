      </div><!-- end of div#mid-col -->
      
      <span class="clearFix">&nbsp;</span>     
</div><!-- end of div#content -->
<div class="push"></div>
</div><!-- end of #container -->

<div id="footer-wrap" style="background:none;">
	<div id="footer">
<!--        <div id="footer-top">
        	<div class="align-left">
            <h4>Dashboard</h4>
            <p><a href="#">Dasboard Sub 1</a> | <a href="#">Dasboard Sub 2</a> | <a href="#">Dasboard Sub 3</a></p>
        	</div>
            <div class="align-right">
            <h2><a href="index.php"><?php echo $crm_name; ?></a></h2>
            </div>
            <span class="clearFix"></span>
        </div>-->
        
        <div id="footer-bottom">
        	<p>&copy; 2011 <?php echo $crm_name; ?>. Powered by <a href="http://www.convex.com">COnvex</a>, 
            <!--via <a href="http://themeforest.net">Themeforest</a>--></p>
        </div>
        
	</div>
</div>


</body>
</html>
<?php ob_flush();?>
<?php $db_conn->Close(); ?>
