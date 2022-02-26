<?php
// Set these variables
#$total_records_count		// Provided by COUNT ALL Function
#$page_records_limit		// Limit Set by Config File
#$global_page_count_limit_for_admin		// Limit Set by Config File
//echo $page_url;exit;

$current_page_no = empty($_REQUEST["pgno"])?1:$_REQUEST["pgno"];
if($total_records_count>$page_records_limit){
	$totalNoOfPages = ceil($total_records_count / $page_records_limit);
}else{
	$totalNoOfPages = 1;
}
if($current_page_no<2){
	$recStartFrom = 0;
}else{
	$recStartFrom = ($current_page_no-1)*$page_records_limit;
}
if($totalNoOfPages>1){
$paging_block.='<div class="paging_block">';
if($current_page_no>1){
	$paging_block.='<a href="'.$page_url.'&pgno='.($current_page_no-1).'&campaign_id='.$campaign_id.'">&laquo; Back</a>';
	//$paging_block.='<a href="'.$page_url.'&field=caller_id&order='.($_REQUEST["order"]=="asc")?"desc":"asc".'&fdate='.$fdate.'&tdate='.$tdate.'&keywords='.$keywords.'&search_keyword='.$search_keyword.'&pgno='.($current_page_no-1).'">&laquo; Back</a>';
	//
}
$startPage = $current_page_no-$global_page_count_limit_for_admin;
if($startPage<=0){
	$startPage=1;
}else{
	$startPage=$current_page_no;
}
for($pLoop=$startPage;$pLoop<=(($startPage-1)+$global_page_count_limit_for_admin);$pLoop++){
	if($pLoop<=$totalNoOfPages){
		if($pLoop!=$current_page_no){
			$paging_block.='<a href="'.$page_url.'&pgno='.$pLoop.'&campaign_id='.$campaign_id.'">'.$pLoop.'</a>';
			//$paging_block.='<a href="'.$page_url.'&pgno='.$pLoop.'&field=caller_id&order='.($_REQUEST["order"]=="asc")?"desc":"asc".'&fdate='.$fdate.'&tdate='.$tdate.'&keywords='.$keywords.'&search_keyword='.$search_keyword.'">'.$pLoop.'</a>';
			//$paging_block.='<a href="'.$page_url.'&field=caller_id&order='.($_REQUEST["order"]=="asc")?"desc":"asc".'&fdate='.$fdate.'&tdate='.$tdate.'&keywords='.$keywords.'&search_keyword='.$search_keyword.'&pgno='.$pLoop.'">'.$pLoop.'</a>';
		}else{
			$paging_block.='&nbsp;<b>'.$pLoop.'</b>&nbsp;';
		}

	}
}
if($current_page_no<$totalNoOfPages){
	$paging_block.='<a href="'.$page_url.'&pgno='.($current_page_no+1).'&campaign_id='.$campaign_id.'">Next &raquo;</a>';
	//$paging_block.='<a href="'.$page_url.'&pgno='.($current_page_no+1).'&field=caller_id&order='.($_REQUEST["order"]=="asc")?"desc":"asc".'&fdate='.$fdate.'&tdate='.$tdate.'&keywords='.$keywords.'&search_keyword='.$search_keyword.'">Next &raquo;</a>'
	//$paging_block.='<a href="'.$page_url.'&field=caller_id&order='.($_REQUEST["order"]=="asc")?"desc":"asc".'&fdate='.$fdate.'&tdate='.$tdate.'&keywords='.$keywords.'&search_keyword='.$search_keyword.'&pgno='.($current_page_no+1).'">Next &raquo;</a>';
}
$paging_block.='&nbsp;&nbsp;'.$current_page_no.' of '.$totalNoOfPages.' Pages</div>';
}
?>
