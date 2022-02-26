<?php
	//include_once("../classes/tools_admin.php");
    //$tools_admin = new tools_admin();
		
	$caller_id =  "03332394271";
	//$rst = $tools_admin->get_caller_id($_SESSION[$db_prefix.'_UserId']);
?>

<?php
/*		$cmd = 'Agents';
		$socket = fsockopen("localhost","5038", $errno, $errstr, $timeout);
                fputs($socket, "Action: Login\r\n");
                fputs($socket, "UserName: admin\r\n");
                fputs($socket, "Secret: admin786\r\n");

                fputs($socket, "\r\n");

                fputs($socket, "Action: ".$cmd."\r\n\r\n");
                fputs($socket, "Action: Logoff\r\n\r\n");
                while (!feof($socket)) {
                        $wrets .= fread($socket, 8192);
                }
                fclose($socket);
                echo trim($wrets);exit;

		$output = substr($wrets,strpos($wrets, "Agent: ".$agent));
		$output = substr($output,0,strpos($output, "Event"));
	
		$output = substr($output,strpos($output, "TalkingTo: "),strlen($output));
		$output = substr($output,strpos($output, ": ") + 1,strlen($output));

		echo trim($output);
*/
?>
