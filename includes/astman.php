<?php
	$socket = fsockopen("localhost","5038", $errno, $errstr, $timeout);
	fputs($socket, "Action: Login\r\n");
	fputs($socket, "UserName: admin\r\n");
	fputs($socket, "Secret: admin786\r\n");

	fputs($socket, "\r\n");

	fputs($socket, "Action: ".$cmd."\r\n\r\n");
	//fputs($socket, "Action: QueueStatus\r\n\r\n");
	fputs($socket, "Action: Logoff\r\n\r\n");
	while (!feof($socket)) {
		$wrets .= fread($socket, 8192);
	}
	fclose($socket);
	echo "<<< ASTERISK MANAGEREND >>>";
	echo "ASTERISK MANAGER OUTPUT:";
	echo nl2br($wrets);
	echo "ASTERISK MANAGEREND";
?>
