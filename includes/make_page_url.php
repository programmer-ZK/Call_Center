<?php
$url = $_SERVER['REQUEST_URI'];
list($page,$parameters1)	= split('\?',$url);
$page_url = $host.$page."?1=1";
$page_url = $page."?1=1";
if(isset($_REQUEST["pgno"])){
	$page_url.="&pgno=".$_REQUEST["pgno"];
}
if(isset($_REQUEST["fdate"]) && isset($_REQUEST["tdate"])){
	$page_url.= "&fdate=".$_REQUEST["fdate"]."&tdate=".$_REQUEST["tdate"];
}
if(isset($_REQUEST["txtSearch"])){
	$page_url.= "&txtSearch=".$_REQUEST["txtSearch"];
}
if(isset($_REQUEST["search_keyword"])){
	$page_url.= "&search_keyword=".$_REQUEST["search_keyword"];
}
if(isset($_REQUEST["keywords"])){
	$page_url.= "&keywords=".$_REQUEST["keywords"];
}
?>
