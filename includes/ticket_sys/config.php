<?php
/*********************************************************************
    config.php
**********************************************************************/
date_default_timezone_set('Asia/Karachi');
$prefix='ts_';
define('USER_TABLE',$prefix.'user');
define('FORM_ENTRY_TABLE',$prefix.'form_entry');
define('FORM_ANSWER_TABLE',$prefix.'form_entry_values');
define('USER_EMAIL_TABLE',$prefix.'user_email');
define('ORGANIZATION_TABLE', $prefix.'organization');
define('USER_ACCOUNT_TABLE',$prefix.'user_account');
define('TICKET_TABLE',$prefix.'ticket');
define('TICKET_STATUS_TABLE', $prefix.'ticket_status');
define('DEPT_TABLE',$prefix.'department');
define('STAFF_TABLE',$prefix.'staff');
define('FAQ_TOPIC_TABLE',$prefix.'faq_topic');
define('TOPIC_TABLE',$prefix.'help_topic');
define('TABLE_PREFIX',$prefix);
define('TICKET_PRIORITY_TABLE',$prefix.'ticket_priority');
define('PRIORITY_TABLE',TICKET_PRIORITY_TABLE);
define('TICKET_THREAD_TABLE',$prefix.'ticket_thread');
define('TEAM_TABLE',$prefix.'team');

define('DBTYPE','mysql');
define('DBHOST','localhost');
define('DBNAME','CC_outsource');
define('DBUSER','root');
define('DBPASS','root12'); // Crm123

function dbConnect()    {
    $connectionString = mysql_connect(DBHOST,DBUSER,DBPASS)or die('connection error');
    mysql_select_db(DBNAME,$connectionString) or die('database select error.');
    return $connectionString;
}
$con = dbConnect();

function select($query,$type="array")  {
    $dataSet = mysql_query($query);
    if($dataSet != FALSE) {
	   if($type=='array'){
		    return mysql_fetch_array($dataSet);
		   }else{
			return mysql_fetch_object($dataSet);   
			   } 
    }else{
       return mysql_error(); // TODO: better error handling
    }
    
}
function dateTime($dt){
	 return  date('d-m-Y h:i:s a',strtotime($dt));
	}
function freeRun($query)    {
    return mysql_query($query);
  }
  
function db_input($var, $quote=true) {

    if(is_array($var))
        return array_map('db_input', $var, array_fill(0, count($var), $quote));
    elseif($var && preg_match("/^(?:\d+\.\d+|[1-9]\d*)$/S", $var))
        return $var;

    return db_real_escape($var, $quote);
}

function update($query){
 return mysql_query($query);
}
function insert($query){
  if(mysql_query($query)){
   return mysql_insert_id();
  }else{
    return 'error';
  }

}
// this function is for call_centerstats
function get_available_user_list(){
		$sql = " SELECT * ";
		$sql.= " from cc_admin ";
		$sql.= " WHERE is_phone_login=1 and is_crm_login = 1 and is_busy=0 and group_id=1";
//		echo($sql);
//		exit();
		 return freeRun($sql);
	}
function  selectMe($fields, $tbl, $where){
		$sql = "select $fields as field from cc_$tbl where 1=1 ";
		if(!empty($where)){
			$sql.= "and $where ";
		}
		 $ob = select($sql,'object');
		 return $ob->field;
		//echo("<br>".$sql); 
		//return $rs->fields["$fields"];
	}

function getTicketStatus(){
	$select = 'SELECT tstatus.id,tstatus.name from '.TICKET_STATUS_TABLE.' as tstatus where id IN (1,2,3) order by id asc limit 5';
	return freeRun($select);
	 
	}
	
function getCssAgentsLocation(){
	$select = 'SELECT distinct location as location_id,location as location_name from cc_admin ';
	return freeRun($select);
	 
	}	
	
	
function helptopic(){
	$select = 'SELECT topics.topic_id,topics.topic from '.TOPIC_TABLE.' as topics';
	return freeRun($select);
	 
	}
function getDept(){
	$select = 'SELECT deptt.dept_id,deptt.dept_name from '.DEPT_TABLE.' as deptt';
	return freeRun($select);
	 
	}	
function getSection(){
	$select = ' SELECT DISTINCT staff.section AS sec_id, staff.section FROM ts_staff AS staff ';
	return freeRun($select);
	 
	}		
function getPriority(){
	$select = 'SELECT prior.priority_id,prior.priority_desc from '.TICKET_PRIORITY_TABLE.' as prior';
	return freeRun($select);
	 
	}		
 function getTeam(){
	$select = 'SELECT team.team_id,team.name from '.TEAM_TABLE.' as team';
	return freeRun($select);
	 
	}	
function redirect($url){
  header('Location:'.$url);
}
function getPriorityById($id){
	$select = 'SELECT prior.priority_desc from '.TICKET_PRIORITY_TABLE.' as prior where prior.priority_id='.$id;
	return select($select,'object');
}
function getProductNature($pid){
	$select = "SELECT * FROM cc_products WHERE parent_id = '".$pid."' AND  status='1'";
	return freeRun($select);
}
function DeleteFile($ticket_id,$file_id){
    $select = "DELETE FROM ts_file WHERE id = '".$file_id."'";
	$first = freeRun($select);
    $select = "DELETE FROM ts_ticket_attachment WHERE ticket_id ='".$ticket_id."' AND file_id='".$file_id."' ";
	$second =  freeRun($select);
	if($first &&  $second){
		return true;
	}else{
		return false;
	}
	
}

function getWorkcodes($pid){
	$select = "SELECT * FROM cc_workcodes_new WHERE parent_id = '".$pid."' AND  status='1'";
	return freeRun($select);
}

 function getDepartIdByTeamId($team_id){
	 
	$select = 'SELECT staff.dept_id, staff.username FROM ts_team_member AS team  INNER JOIN ts_staff as staff ON team.staff_id = staff.staff_id  WHERE team.team_id = '.$team_id.' limit 1';
	 return select($select,'object');;
	}

function  generatezero($length){
	
    $number = '';
    for ($i = 0; $i < $length; $i++){
        $number .='0';
    }
    return $number;

	}	

function pagination($per_page=10,$page=1,$rows,$agent_id,$fdate,$tdate,$status,$url='?'){   
    //global $conDB; 
   // $query = "SELECT COUNT(*) as `num` FROM ts_ticket where  DATE(created) BETWEEN '".$fdate."' AND '".$tdate."' AND status_id='".$status."' AND who_created='".$agent_id."' ";
   // $row = mysql_fetch_array(mysql_query($query));
    $total = $rows[0];
    $adjacents = "2"; 
      
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";
      
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
      
    $prev = $page - 1;                          
    $next = $page + 1;
      
    $lastpage = ceil($total/$per_page);
      
    $lpm1 = $lastpage - 1; // //last page minus 1
      
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<ul>";
            //if ($page < $counter - 1) {
                //$pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
           // }  
            if ($page > 1) $pagination.= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";
              
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
            }
          
        } elseif($lastpage > 5 + ($adjacents * 2)){
              
            if($page < 1 + ($adjacents * 2)) {
                  
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li  class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";  
                      
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";      
                  
            } else {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a  href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
            }
        }
          
            if ($page < $counter - 1) {
                //$pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
				$pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
				
               // $pagination.= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }
          
        $pagination.= "</ul>";        
    }
      
    return $pagination;
}	
function getTData($tid){
	 $query="SELECT * FROM ts_ticket WHERE ticket_id='".$tid."' limit 1 ";
    $res = freeRun($query,'object');
    if(mysql_num_rows($res) > 0){
     $data= mysql_fetch_object($res);
	 return $data;
    }
 }
function paginationAll($per_page=10,$page=1,$rows,$fdate,$tdate,$status,$url='?'){   
    //global $conDB; 
   //$query = "SELECT COUNT(*) as `num` FROM ts_ticket where  DATE(created) BETWEEN '".$fdate."' AND '".$tdate."' AND status_id='".$status."'";
   // $row = mysql_fetch_array(mysql_query($query));
   $total = $rows[0];
    $adjacents = "2"; 
      
    $prevlabel = "&lsaquo; Prev";
    $nextlabel = "Next &rsaquo;";
    $lastlabel = "Last &rsaquo;&rsaquo;";
      
    $page = ($page == 0 ? 1 : $page);  
    $start = ($page - 1) * $per_page;                               
      
    $prev = $page - 1;                          
    $next = $page + 1;
      
    $lastpage = ceil($total/$per_page);
      
    $lpm1 = $lastpage - 1; // //last page minus 1
      
    $pagination = "";
    if($lastpage > 1){   
        $pagination .= "<ul>";
            //if ($page < $counter - 1) {
                //$pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
           // }
              
            if ($page > 1) $pagination.= "<li><a href='{$url}page={$prev}'>{$prevlabel}</a></li>";
              
        if ($lastpage < 7 + ($adjacents * 2)){   
            for ($counter = 1; $counter <= $lastpage; $counter++){
                if ($counter == $page)
                    $pagination.= "<li class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
                else
                    $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
            }
          
        } elseif($lastpage > 5 + ($adjacents * 2)){
              
            if($page < 1 + ($adjacents * 2)) {
                  
                for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                    if ($counter == $page)
                        $pagination.= "<li  class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>...</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";  
                      
            } elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>...</li>";
                for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
                $pagination.= "<li class='dot'>..</li>";
                $pagination.= "<li><a href='{$url}page={$lpm1}'>{$lpm1}</a></li>";
                $pagination.= "<li><a href='{$url}page={$lastpage}'>{$lastpage}</a></li>";      
                  
            } else {
                  
                $pagination.= "<li><a href='{$url}page=1'>1</a></li>";
                $pagination.= "<li><a href='{$url}page=2'>2</a></li>";
                $pagination.= "<li class='dot'>..</li>";
                for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                    if ($counter == $page)
                        $pagination.= "<li class='active'><a href='{$url}page={$counter}'>{$counter}</a></li>";
                    else
                        $pagination.= "<li><a  href='{$url}page={$counter}'>{$counter}</a></li>";                    
                }
            }
        }
          
            if ($page < $counter - 1) {
                //$pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
				$pagination.= "<li><a href='{$url}page={$next}'>{$nextlabel}</a></li>";
				
               // $pagination.= "<li><a href='{$url}page=$lastpage'>{$lastlabel}</a></li>";
            }
          
        $pagination.= "</ul>";        
    }
      
    return $pagination;
}	
include_once 'class.client.php';


?>
