<?php include_once("includes/config.php"); ?>
<?php include_once("includes/ticket_sys/config.php"); ?>
<?php 
$arr = array();
if($_REQUEST['products']){
 $products = getProductNature($_REQUEST['products']); 
  while($product = mysql_fetch_object($products)){
	  $data['key'] = $product->p_title;
	  $data['value'] = $product->p_title;
	  $arr['natures'][] = $data;
	}
 echo json_encode($arr);	
}
//

?>
