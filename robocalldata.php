<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'CC_outsource';


$datetime=`date "+%Y-%m-%d" --date="1 days ago"`;
$datetime=trim($datetime);


$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$datetime1='2017-01-01';
//$jresponse = `lynx -dump 'http://qtech-plus.com/sandbox/kababjees/webservice/feedback.php?apiKey=87ha7u2ho0a8j&user=99&startDate=$datetime&endDate=$datetime'`;
$jresponse = `lynx -dump 'http://192.168.8.10/kababjees/webservice/feedback.php?apiKey=87ha7u2ho0a8j&user=99&startDate=$datetime&endDate=$datetime'`;

//echo $jresponse;
$json= $jresponse;

#print_r(json_decode($json));
//var_dump(json_decode($json, true));
$array = json_decode($json,true);

//print_r($arr);
foreach ($array['data'] as $key => $jsons) { // This will search in the 2 jsons
     foreach($jsons as $key => $value) {

        if($key=="orderNumber"){
                $orderNumber=$value;
        }

        if($key=="items"){
                $items=$value;
                //print_r($value);
          foreach($items as $key1 => $jsons1) {
                foreach($jsons1 as $key2 => $value2) {
        //                   echo $key2 ."=". $value2 ." OrderNumber:$orderNumber ";
                }
        //      echo "\n";
                 $sql ="INSERT INTO ordersDetails (OrderNumber,category,item,quantity,price,comments,total)";
                        $sql .="VALUES ('$orderNumber','$jsons1[category]','$jsons1[item]','$jsons1[quantity]','$jsons1[price]','$jsons1[comments]','$jsons1[total]')";

                        if ($conn->query($sql) === TRUE) {
                           // echo "New record created successfully";
                        } else {
                        //    echo "Error: " . $sql . "<br>" . $conn->error;
                        }

          }
        //echo "data $jsons1[orderNumber] -- $jsons1[category] -- $jsons1[item] -- $jsons1[quantity] -- $jsons1[price] -- $jsons1[comments] -- $jsons1[total] --";


        }
        else{
         //echo $key ."=". $value ."\n"; // This will show jsut the value f each key like "var1" will print 9
                       // And then goes print 16,16,8 ...


        }
    }

        //print_r($jsons);
//  echo "data $jsons[orderNumber] -- $jsons[date] -- $jsons[orderType] -- $jsons[discount] -- $jsons[total] -- $jsons[customer] -- $jsons[telephone] -- $jsons[mobile] -- $jsons[address] -- ". "\n";

        $sql ="INSERT IGNORE INTO orders (orderNumber,date,orderType,discount,total,customer,telephone,mobile,address)";
        $sql .="VALUES ('$jsons[orderNumber]','$jsons[date]','$jsons[orderType]','$jsons[discount]','$jsons[total]','$jsons[customer]','$jsons[telephone]','$jsons[mobile]','$jsons[address]')";

        if ($conn->query($sql) === TRUE) {
           // echo "New record created successfully";
        } else {
        //    echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $sql5 ="INSERT IGNORE INTO outsource (order_code,caller_id)";
        $sql5 .="VALUES ('$jsons[orderNumber]','$jsons[mobile]')";

        if ($conn->query($sql5) === TRUE) {
           // echo "New record created successfully";
        } else {
        //    echo "Error: " . $sql . "<br>" . $conn->error;
        }

}

$conn->close();

?>
<?php
/*
    array(10) {
      ["orderNumber"]=>
      string(1) "7"
      ["date"]=>
      string(20) "21-Mar-2017 03:05 PM"
      ["orderType"]=>
      string(8) "DELIVERY"
      ["discount"]=>
      string(1) "0"
      ["total"]=>
      string(9) "Rs.428.00"
      ["customer"]=>
      string(6) "hassan"
      ["telephone"]=>
      string(0) ""
      ["mobile"]=>
      string(5) "12345"
      ["address"]=>
      string(0) ""
      ["items"]=>
      array(2) {
        [0]=>
        array(6) {
          ["category"]=>
          string(4) "SOUP"
          ["item"]=>
          string(17) "HOT AND SOUR SOUP"
          ["quantity"]=>
          string(1) "1"
          ["price"]=>
          string(3) "129"
          ["comments"]=>
          string(0) ""
          ["total"]=>
          string(9) "Rs.129.00"
        }
        [1]=>
        array(6) {
          ["category"]=>
          string(7) "BURGERS"
          ["item"]=>
          string(21) "CRISPY CHICKEN BURGER"
          ["quantity"]=>
          string(1) "1"
          ["price"]=>
          string(3) "299"
          ["comments"]=>
          string(0) ""
          ["total"]=>
          string(9) "Rs.299.00"
        }
      }
    }
  }
*/
?>

