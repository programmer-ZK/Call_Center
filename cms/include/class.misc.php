<?php
/*********************************************************************
    class.misc.php

    Misc collection of useful generic helper functions.

**********************************************************************/

class Misc {

	function randCode($len=8, $chars=false) {
        $chars = $chars ?: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890_=';

        // Determine the number of bits we need
        $char_count = strlen($chars);
        $bits_per_char = ceil(log($char_count, 2));
        $bytes = ceil(4 * $len / floor(32 / $bits_per_char));
        // Pad to 4 byte boundary
        $bytes += (4 - ($bytes % 4)) % 4;

        // Fetch some random data blocks
        $data = Crypto::random($bytes);

        $mask = (1 << $bits_per_char) - 1;
        $loops = (int) (32 / $bits_per_char);
        $output = '';
        $ints = unpack('V*', $data);
        foreach ($ints as $int) {
            for ($i = $loops; $i > 0; $i--) {
                $output .= $chars[($int & $mask) % $char_count];
                $int >>= $bits_per_char;
            }
        }
        return substr($output, 0, $len);
	}

    function __rand_seed($value=0) {
        // Form a 32-bit figure for the random seed with the lower 16-bits
        // the microseconds of the current time, and the upper 16-bits from
        // received value
        $seed = ((int) $value % 65535) << 16;
        $seed += (int) ((double) microtime() * 1000000) % 65535;
        mt_srand($seed);
    }

    /* Helper used to generate ticket IDs */
    function randNumber($len=6,$start=false,$end=false) {

        $start=(!$len && $start)?$start:str_pad(1,$len,"0",STR_PAD_RIGHT);
        $end=(!$len && $end)?$end:str_pad(9,$len,"9",STR_PAD_RIGHT);

        return mt_rand($start,$end);
    }

    /* misc date helpers...this will go away once we move to php 5 */
    function db2gmtime($var){
        global $cfg;
        if(!$var) return;

        $dbtime=is_int($var)?$var:strtotime($var);
        return $dbtime-($cfg->getDBTZoffset()*3600);
    }

    //Take user time or gmtime and return db (mysql) time.
    function dbtime($var=null){
         global $cfg;

        if(is_null($var) || !$var)
            $time=Misc::gmtime(); //gm time.
        else{ //user time to GM.
            $time=is_int($var)?$var:strtotime($var);
            $offset=$_SESSION['TZ_OFFSET']+($_SESSION['TZ_DST']?date('I',$time):0);
            $time=$time-($offset*3600);
        }
        //gm to db time
        return $time+($cfg->getDBTZoffset()*3600);
    }

    /*Helper get GM time based on timezone offset*/
    function gmtime() {
        return time()-date('Z');
    }

    /* Needed because of PHP 4 support */
    function micro_time() {
        list($usec, $sec) = explode(" ", microtime());

        return ((float)$usec + (float)$sec);
    }

    //Current page
    function currentURL() {

        $str = 'http';
        if ($_SERVER['HTTPS'] == 'on') {
            $str .='s';
        }
        $str .= '://';
        if (!isset($_SERVER['REQUEST_URI'])) { //IIS???
            $_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'],1 );
            if (isset($_SERVER['QUERY_STRING'])) {
                $_SERVER['REQUEST_URI'].='?'.$_SERVER['QUERY_STRING'];
            }
        }
        if ($_SERVER['SERVER_PORT']!=80) {
            $str .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
        } else {
            $str .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
        }

        return $str;
    }

    function timeDropdown($hr=null, $min =null,$name='time') {
        global $cfg;

        $hr =is_null($hr)?0:$hr;
        $min =is_null($min)?0:$min;

        //normalize;
        if($hr>=24)
            $hr=$hr%24;
        elseif($hr<0)
            $hr=0;

        if($min>=45)
            $min=45;
        elseif($min>=30)
            $min=30;
        elseif($min>=15)
            $min=15;
        else
            $min=0;

        ob_start();
        echo sprintf('<select name="%s" id="%s">',$name,$name);
        echo '<option value="" selected>'.__('Time').'</option>';
        $format = $cfg->getTimeFormat();
        for($i=23; $i>=0; $i--) {
            for($minute=45; $minute>=0; $minute-=15) {
                $sel=($hr==$i && $min==$minute)?'selected="selected"':'';
                $_minute=str_pad($minute, 2, '0',STR_PAD_LEFT);
                $_hour=str_pad($i, 2, '0',STR_PAD_LEFT);
                $disp = gmdate($format, $i*3600 + $minute*60);
                echo sprintf('<option value="%s:%s" %s>%s</option>',$_hour,$_minute,$sel,$disp);
            }
        }
        echo '</select>';
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    function realpath($path) {
        $rp = realpath($path);
        return $rp ? $rp : $path;
    }

}
?>
