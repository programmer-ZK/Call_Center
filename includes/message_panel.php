<script>
// 3 - MESSAGE BOX FADING SCRIPTS ------#

$(document).ready(function() {
	$(".close-yellow").click(function () {
		$("#message-yellow").fadeOut("slow");
	});
	$(".close-red").click(function () {
		$("#message-red").fadeOut("slow");
	});
	$(".close-blue").click(function () {
		$("#message-blue").fadeOut("slow");
	});
	$(".close-green").click(function () {
		$("#message-green").fadeOut("slow");
	});
});

// END ----------------------------- 3
</script>
<?php
	if(!empty($_SESSION[$db_prefix.'_YM'])){
		$message = '<div id="message-yellow">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                        <td class="yellow-left">'.$_SESSION[$db_prefix.'_YM'].'</td>
                                        <td class="yellow-right"><a class="close-yellow"><img src="images/icon_close_yellow.gif"   alt="" /></a></td>
                                </tr>
                                </table>
                                </div>';
		$message = $_SESSION[$db_prefix.'_YM'];
		unset($_SESSION[$db_prefix.'_YM']);
	}
	else if(!empty($_SESSION[$db_prefix.'_RM'])){
		$message = '<div id="message-red">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                        <td class="red-left">'.$_SESSION[$db_prefix.'_RM'].'</td>
                                        <td class="red-right"><a class="close-red"><img src="images/icon_close_red.gif"   alt="" /></a></td>
                                </tr>
                                </table>
                                </div>';
		
		unset($_SESSION[$db_prefix.'_RM']);
	}
        else if(!empty($_SESSION[$db_prefix.'_BM'])){
                $message = '    <div id="message-blue">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                        <td class="blue-left">'.$_SESSION[$db_prefix.'_BM'].'</td>
                                        <td class="blue-right"><a class="close-blue"><img src="images/icon_close_blue.gif"   alt="" /></a></td>
                                </tr>
                                </table>
                                </div>';
                unset($_SESSION[$db_prefix.'_BM']);
        }
        else if(!empty($_SESSION[$db_prefix.'_GM'])){
                $message = '	<div id="message-green">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                        <td class="green-left">'.$_SESSION[$db_prefix.'_GM'].'</td>
                                        <td class="green-right"><a class="close-green"><img src="images/icon_close_green.gif"   alt="" /></a></td>
                                </tr>
                                </table>
                                </div>';
                unset($_SESSION[$db_prefix.'_GM']);
        }
	echo $message;
?>

				<!--  start message
                                <div id="message-yellow">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                              		<td class="yellow-left"><?php echo $message; ?></td>
                                        <td class="yellow-right"><a class="close-yellow"><img src="images/icon_close_yellow.gif"   alt="" /></a></td>
                                </tr>
                                </table>
                                </div>

                                <div id="message-red">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                        <td class="red-left"><?php echo $message; ?></td>
                                        <td class="red-right"><a class="close-red"><img src="images/icon_close_red.gif"   alt="" /></a></td>
                                </tr>
                                </table>
                                </div>

                                <div id="message-blue">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                        <td class="blue-left"><?php echo $message; ?> </td>
                                        <td class="blue-right"><a class="close-blue"><img src="images/icon_close_blue.gif"   alt="" /></a></td>
                                </tr>
                                </table>
                                </div>

                                <div id="message-green">
                                <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                        <td class="green-left"><?php echo $message; ?></td>
                                        <td class="green-right"><a class="close-green"><img src="images/icon_close_green.gif"   alt="" /></a></td>
                                </tr>
                                </table>
                                </div>
                                end message -->

