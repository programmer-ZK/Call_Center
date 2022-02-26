<?php

class ast_manager
{

	function ast_manager()
	{
		
	}
		function reload_asterisk()
		{
			 $socket = fsockopen("127.0.0.1","5038", $errno, $errstr, $timeout); 
			 fputs($socket, "Action: Login\r\n"); 
			 fputs($socket, "UserName: admin\r\n"); 
			 fputs($socket, "Secret: admin786\r\n\r\n"); 
		
			 fputs($socket, "Action: Command\r\n"); 
			 fputs($socket, "Command: reload\r\n\r\n"); 
			 $wrets=fgets($socket,128); 

		}
        function exec_command()
        {
                $socket = fsockopen("127.0.0.1","5038", $errno, $errstr, 10);
                fputs($socket, "Action: Login\r\n");
                fputs($socket, "UserName: admin\r\n");
                fputs($socket, "Secret: admin786\r\n\r\n");
                fputs($socket, "Action: Agents\r\n\r\n");
                fputs($socket, "Action: Logoff\r\n\r\n");
                while (!feof($socket))
                {
                        $output.= fgets($socket, 8192);
                        $output .= '<br>';
                }
                fclose($socket);
		return $output;
        }	
	function get_agent_status()
	{
		$output = $this->exec_command();

		$output = substr($output,strpos($output, "Event: Agents"));	
                $output = substr($output,0,strpos($output, "Event: AgentsComplete"));

		$chunks = preg_split("/<br>[\s,]+<br>/", $output);
		print_r ($chunks);
		echo "<br><br>";
		$j = 0;
		for ($i=0;$i<count($chunks);$i++) 
		{
    			$rows = preg_split("/<br>/", $chunks[$i]);
			print_r ($rows);
			echo "<br><br>";
			//foreach ($rows[$i] as &$value) 
			//{
                        //	$rows[$i][$j] = preg_split(":", $value);
			//	$j++;
			//}
		}
		print_r ($rows);
                //echo trim($rows);
	}
}
?>

