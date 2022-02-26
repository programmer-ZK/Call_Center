

<?php include_once("includes/config.php"); ?>

<?php

 
  //   $dbhost  = "10.4.29.249:3306";
  //   $dbuser  = "root";
   //  $dbpass  = "";
   //  $dbname  = "m3techcc";
   
   
    $dbhost  = $db_server;
    $dbuser  = $db_user ;
    $dbpass  = $db_pass ;
    $dbname  = $db_name;
   
    $dbtable = "cc_campaign_detail";

 $campaign_id=$_GET['campaign_id'];
 
// This one makes the beginning of the xls file
function xlsBOF() {
    echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
    return;
}
 
// This one makes the end of the xls file
function xlsEOF() {
    echo pack("ss", 0x0A, 0x00);
    return;
}
 
// this will write text in the cell you specify
function xlsWriteLabel($Row, $Col, $Value ) {
    $L = strlen($Value);
    echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
    echo $Value;
    return;
}
 
 
 
// make the connection an DB query
$dbc = mysql_connect( $dbhost , $dbuser , $dbpass ) or die( mysql_error() );
mysql_select_db( $dbname );
$q = "SELECT name,cnic,caller_id,caller_id2,caller_id3,city,ic,source,attempts FROM ".$dbtable." where campaign_id='".$campaign_id."'";
$qr = mysql_query( $q ) or die( mysql_error() );
 
 
// Ok now we are going to send some headers so that this 
// thing that we are going make comes out of browser
// as an xls file.
// 
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
 
//this line is important its makes the file name
header("Content-Disposition: attachment;filename=caller_list.xls");
 
header("Content-Transfer-Encoding: binary ");
 
// start the file
xlsBOF();
 
// these will be used for keeping things in order.
$col = 0;
$row = 0;
 
// This tells us that we are on the first row
$first = true;
 
while( $qrow = mysql_fetch_assoc( $qr ) )
{
    // Ok we are on the first row
    // lets make some headers of sorts
    if( $first )
    {
        foreach( $qrow as $k => $v )
        {
            // take the key and make label
            // make it uppper case and replace _ with ' '
            xlsWriteLabel( $row, $col, strtoupper( ereg_replace( "_" , " " , $k ) ) );
            $col++;
        }
 
        // prepare for the first real data row
        $col = 0;
        $row++;
        $first = false;
    }
 
    // go through the data
    foreach( $qrow as $k => $v )
    {
        // write it out
        xlsWriteLabel( $row, $col, $v );
        $col++;
    }
    // reset col and goto next row
    $col = 0;
    $row++;
}
 
xlsEOF();
exit();
?>