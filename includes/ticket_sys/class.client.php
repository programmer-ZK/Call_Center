<?php 
class ClientInfo{
	
public static function closedBy($ticket_id){
$query="SELECT	poster FROM ts_ticket_thread WHERE ticket_id ='".$ticket_id." AND status =3' ORDER BY id  DESC LIMIT 1";
$result = select($query,'object');
	 return $result;					     
}	
public static function editClient($info_r){
      // print_r($info_r); die;
      // $r_num = ($info_r['register_num']!="") ? $info_r['register_num']:"";
       $cmid = ($info_r['cmid']!="") ? $info_r['cmid']:"";
       $uin = ($info_r['uin']!="") ? $info_r['uin']:"";
       $cnic = ($info_r['cnic']!="") ? $info_r['cnic']:$info_r['cnic'];
       $phone = $info_r['phone']; 
       $query = 'UPDATE '.USER_TABLE.' SET name="'.$info_r['full_name'].'",cmid="'.$cmid.'",uin="'.$uin.'",cnic="'.$cnic.'",phone="'.$phone.'",updated="'.date("Y-m-d H:i:s").'"  WHERE id='.$info_r['client_id'];
	     $user_updated = update($query);
	    if($user_updated){
		  $query = 'UPDATE '.USER_EMAIL_TABLE.' SET address="'.$info_r['email'].'" WHERE id='.$info_r['client_id'];
          $email_updated = update($query);
		  
		  $r['success']=true;
          return $r; 
		  
        }else{
           $r['success']=false;
           return $r;  
        }
        
         
 }
 public static function createClient($info_r){
       /* $mobile="";
        if(!empty($info_r['mobile'])){
         $mobile = $info_r['mobile'];
        }*/
       $r_num = ($info_r['register_num']!="") ? $info_r['register_num']:"";
       $cmid = ($info_r['cmid']!="") ? $info_r['cmid']:"";
       $uin = ($info_r['uin']!="") ? $info_r['uin']:"";
       $cnic = ($info_r['cnic']!="") ? $info_r['cnic']:$info_r['cnic'];
       //$mobile = ($info_r['mobile-ext']!="") ? $mobile.'X'.$info_r['mobile-ext']:$mobile;
       $phone = $info_r['phone']; 
       $query = 'INSERT INTO '.USER_TABLE.' (org_id,register_num,company_name,name,cmid,uin,cnic,phone,created,updated) VALUES (0,"'.$r_num.'","'.$info_r['company_name'].'","'.$info_r['full_name'].'","'.$cmid.'","'.$uin.'","'.$cnic.'","'.$phone.'","'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'")';
        $user_id = insert($query);
        if($user_id !='error'){
            $query = 'INSERT INTO '.USER_EMAIL_TABLE .' SET user_id='.$user_id.', address="'.$info_r['email'].'"';
            $lastID = insert($query);
            $query = 'UPDATE '.USER_TABLE.' SET default_email_id='.$lastID.' WHERE id='.$user_id;
            update($query);
            $query = 'INSERT INTO '.FORM_ENTRY_TABLE.' (form_id,object_id,object_type,sort,created,updated) VALUES (1,'.$user_id.',"U",1,"'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'")';
            $form_entry_id = insert($query);
          if($form_entry_id){
           $query ='INSERT INTO '.FORM_ANSWER_TABLE .' (entry_id,field_id,value) VALUES ("'.$form_entry_id.'",3,"'.$phone.'")';
           $form_answer_id = insert($query);
          }
         
         $r['added']=true;
          $r['id']= $user_id;
          return $r;
           
        }else{
           $r['added']=false;
           //$r['id']= $user_id;
           return $r;  
        }
        
         
 }
 public static function markTicketOverdue(){
 $query="SELECT ticket_id,duedate,created,team_id,dept_id FROM ts_ticket WHERE status_id =1  AND isoverdue =0 AND duedate < NOW()";
 $res = freeRun($query,'object');
 if(mysql_num_rows($res) > 0){
   while($data=mysql_fetch_object($res)){
    $ticket_q = 'UPDATE '.TICKET_TABLE .' SET isoverdue="1" ,updated="'.date("Y-m-d H:i:s").'"  WHERE ticket_id="'.$data->ticket_id.'"';
     update($ticket_q);
   $tq = 'INSERT INTO ts_ticket_thread SET ticket_id='.$data->ticket_id.',status="1",is_overdue="1",thread_type="R" , poster="SYSTEM",
	   title="Ticket Marked Overdue",body="Ticket flagged as overdue by the system.",format="html" , created="'.date("Y-m-d H:i:s").'", updated="'.date("Y-m-d H:i:s").'"';
    insert($tq);
   $eq = 'INSERT INTO ts_ticket_event SET ticket_id='.$data->ticket_id.',team_id='.$data->team_id.',dept_id='.$data->dept_id.',topic_id=10, state="overdue",timestamp="'.date("Y-m-d H:i:s").'"';
    insert($eq);
  // break;
   //print_r($data);
   }
 }
 
 //return $result;
 
 }
 
 
  public static function postReply($info_r){
   $ticket_id =  $info_r['ticket_id'];
    $query = 'UPDATE '.TICKET_TABLE .' SET isanswered="0",updated="'.date("Y-m-d H:i:s").'",lastmessage="'.date("Y-m-d H:i:s").'"  WHERE ticket_id="'.$ticket_id.'"';
     update($query);     
	 $data = getTData($ticket_id);
	 //print_r($data); die; 
	 $query = 'INSERT INTO ts_ticket_thread SET ticket_id='.$ticket_id.',status="'.$info_r['status'].'",is_overdue="'.$data->overdue.'",team_id="'.$data->team_id.'",due_date="'.$data->duedate.'",priority_id="'.$info_r['old_priority_id'].'",product="'.$data->product.'",nature="'.$data->nature.'",others="'.$data->others.'",thread_type="'.$info_r['thread_type'].'" , poster="'.$info_r['poster'].'",
	   title="'.$info_r['issue_summery'].'",body="'.$info_r['message'].'",format="html",cc_agent_id="'.$info_r['agent_id'].'",created="'.date("Y-m-d H:i:s").'", updated="'.date("Y-m-d H:i:s").'"';
     return  insert($query);
	   
 }
 public static function changeTicketStatus($info_r){
	// print_r($info_r);
	// die;
	//$actions = array('1'=>'A','2'=>'R',''=>'SA',''=>'SC',''=>'RA',''=>'E'); 
   $ticket_id =  $info_r['ticket_id'];
   if($info_r['status']==3){
      $query = 'UPDATE '.TICKET_TABLE .' SET isanswered="0", status_id="'.$info_r['status'].'",closed="'.date("Y-m-d H:i:s").'",updated="'.date("Y-m-d H:i:s").'",lastmessage="'.date("Y-m-d H:i:s").'"  WHERE ticket_id="'.$ticket_id.'"';
      $return = update($query);
   }else{
	   $query = 'UPDATE '.TICKET_TABLE .' SET status_id="'.$info_r['status'].'",updated="'.date("Y-m-d H:i:s").'",lastmessage="'.date("Y-m-d H:i:s").'"  WHERE ticket_id="'.$ticket_id.'"';
   $return = update($query);
   }
   
   if($return){
	    $data = getTData($ticket_id);
    // lastmessage lastresponse
	   $query = 'INSERT INTO ts_ticket_event SET ticket_id='.$ticket_id.',topic_id=10, state="'.$info_r['state'].'", cc_agent_id="'.$info_r['agent_id'].'"';
       $lastID = insert($query);
       $query = 'INSERT INTO ts_ticket_thread SET ticket_id='.$ticket_id.',status="'.$info_r['status'].'",is_overdue="'.$data->overdue.'",team_id="'.$data->team_id.'",due_date="'.$data->duedate.'",priority_id="'.$info_r['old_priority_id'].'",product="'.$data->product.'",nature="'.$data->nature.'",others="'.$data->others.'",thread_type="SC" , poster="'.$info_r['poster'].'",
	   title="Status Changed",body="'.$info_r['body'].'",format="html",cc_agent_id="'.$info_r['agent_id'].'",created="'.date("Y-m-d H:i:s").'", updated="'.date("Y-m-d H:i:s").'"';
       update($query);
	   }
   
   return $return;
 }
  public static function reassignTicket($info_r){
	//print_r($info_r); die;
   $ticket_id =  $info_r['ticket_id'];
   $query = 'UPDATE '.TICKET_TABLE .' SET team_id="'.$info_r['team_id'].'",isanswered="0",updated="'.date("Y-m-d H:i:s").'",lastmessage="'.date("Y-m-d H:i:s").'" WHERE ticket_id="'.$ticket_id.'"';
   $return = update($query);
   if($return){
	   $data = getTData($ticket_id);
	   $query = 'INSERT INTO ts_ticket_event SET ticket_id='.$ticket_id.',topic_id=10, state="'.$info_r['state'].'",cc_agent_id="'.$info_r['agent_id'].'"';
       $lastID = insert($query);
       $query = 'INSERT INTO ts_ticket_thread SET ticket_id='.$ticket_id.',status="'.$info_r['status'].'",is_overdue="'.$data->overdue.'",team_id="'.$data->team_id.'",due_date="'.$data->duedate.'",priority_id="'.$info_r['old_priority_id'].'",product="'.$data->product.'",nature="'.$data->nature.'",others="'.$data->others.'",thread_type="RA" , poster="'.$info_r['poster'].'",
	   title="Ticket Reassigned",body="'.$info_r['body'].'",format="html",cc_agent_id="'.$info_r['agent_id'].'",created="'.date("Y-m-d H:i:s").'", updated="'.date("Y-m-d H:i:s").'"';
       update($query);
	   }
   
   return $return;
 }
 
   
 public static function UpdateUser($info_r){

   $usr_id =  $info_r['id'];
   $query = 'UPDATE '.USER_TABLE .' SET org_id=0, name="'.$info_r['full_name'].'",updated="'.date("Y-m-d H:i:s").'" WHERE id="'.$usr_id.'"';
   $return = update($query);
   $query = 'INSERT INTO '.USER_EMAIL_TABLE .' SET user_id='.$usr_id.', address="'.$info_r['email'].'"';
   $lastID = insert($query);
   $query = 'UPDATE '.USER_TABLE.' SET default_email_id='.$lastID.' WHERE id='.$usr_id;
   update($query);
   return $usr_id;
 }

 public static function searchUserByCMID($info_r){
         $query = 'SELECT id FROM '.USER_TABLE.' WHERE cmid="'.trim($info_r['search']).'" limit 1';
         $r = select($query);
         if(is_array($r) && count($r)>0){
          $r = $r;
          $r['exist']=true;
          return $r;
         }else{
           $r['exist']=false;
           return $r;
         }
 }
 public static function searchUserByUIN($info_r){
         $query = 'SELECT id FROM '.USER_TABLE.' WHERE uin="'.trim($info_r['search']).'" limit 1';
         $r = select($query);
         if(is_array($r) && count($r)>0){
          $r = $r;
          $r['exist']=true;
          return $r;
         }else{
           $r['exist']=false;
           return $r;
         }
 }
 public static function searchUserByCNIC($info_r){
         $query = 'SELECT id FROM '.USER_TABLE.' WHERE cnic="'.trim($info_r['search']).'" limit 1';
         $r = select($query);
         if(is_array($r) && count($r)>0){
          $r = $r;
          $r['exist']=true;
          return $r;
         }else{
           $r['exist']=false;
           return $r;
         }
 }

 public static function searchUserByTicketNumber($info_r){
         $query = 'SELECT user_id as id FROM '.TICKET_TABLE.' WHERE ticket_id="'.trim( (int)$info_r['search']).'" limit 1';
         $r = select($query);
         if(is_array($r) && count($r)>0){
          $r = $r;
          $r['exist']=true;
          return $r;
         }else{
           $r['exist']=false;
           return $r;
         }
 }
public static function searchClientByName($info_r){
         $query = 'SELECT * FROM '.USER_TABLE.' WHERE name LIKE "%'.trim($info_r['search']).'%" ';
		 $res = freeRun($query,'object'); 
         if(mysql_num_rows($res)> 0){
          $r['result'] = $res;
          $r['exist']=true;
          return $r;
         }else{
           $r['exist']=false;
           return $r;
         }
 }
 public static function searchUserByRegisterNumber($info_r){
         $query = 'SELECT id FROM '.USER_TABLE.' WHERE register_num="'.trim($info_r['search']).'" limit 1';
         $r = select($query);
         if(is_array($r) && count($r)>0){
          $r = $r;
          $r['exist']=true;
          return $r;
         }else{
           $r['exist']=false;
           return $r;
         }
 }
  public static function searchUserByContact($info_r){
        // $query = 'SELECT id FROM '.USER_TABLE.' WHERE register_num="'.trim($info_r['search']).'" limit 1';
		  $query = 'SELECT id FROM '.USER_TABLE.' WHERE phone="'.trim($info_r['search']).'" limit 1';
         $r = select($query);
         if(is_array($r) && count($r)>0){
          $r = $r;
          $r['exist']=true;
          return $r;
         }else{
           $r['exist']=false;
           return $r;
         }
 }
 public static function searchUserByPhone($info_r){
	 
    $phone = ($info_r['phone-ext']!="")? $info_r['phone'].'X'.$info_r['phone-ext']:$info_r['phone']; 
		$query_1 = 'SELECT entry.object_id as id,entry_values.value FROM '.FORM_ENTRY_TABLE.' as entry '.'inner join '.FORM_ANSWER_TABLE.' as entry_values on entry.id=entry_values.entry_id'.' WHERE entry_values.field_id=3 and entry_values.value="'.$phone.'" limit 1';   
		$query_2 = 'SELECT id FROM '.USER_TABLE.' WHERE phone="'.trim($phone).'" limit 1';
		$r1 = select($query_1);
		$r2 = select($query_2);
		$r = "";
    if(is_array($r1) && count($r1)>0){
    // die('here1');
     $r = $r1;
		 $r['exist']=true;
		 return $r;
    }elseif(is_array($r2) && count($r2)>0){
		 
		 $r = $r2;
		 $r['exist']=true; 
     return $r;
     //print_r($r);
     //die('here2'); 	
	    }else{

        $query1 = 'INSERT INTO '.USER_TABLE.' (org_id,phone,created,updated) VALUES (0,"'.$phone.'","'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'")';
        $user_id = insert($query1);
        if($user_id){
           $query2 = 'INSERT INTO  '.FORM_ENTRY_TABLE.' (form_id,object_id,object_type,sort,created,updated) VALUES (1,'.$user_id.',"U",1,"'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'")';
           $form_entry_id = insert($query2);
          if($form_entry_id){
           $query3 ='INSERT INTO '.FORM_ANSWER_TABLE .' (entry_id,field_id,value) VALUES ("'.$form_entry_id.'",3,"'.$phone.'")';
           $form_answer_id = insert($query3);
          }
        }
        
        $r['exist']=false;
		    $r['id']= $user_id;
        //print_r($r);
        //die('here3');
        return $r;  

        }
        
 } 
  public static function getUser($id){
	 $select = 'SELECT user.*, email.address as email, org.name as organization
          , account.id as account_id, account.status as account_status ';

     $select .= 'FROM '.USER_TABLE.' user '
      . 'LEFT JOIN '.USER_EMAIL_TABLE.' email ON (user.id = email.user_id) '
      . 'LEFT JOIN '.ORGANIZATION_TABLE.' org ON (user.org_id = org.id) '
      . 'LEFT JOIN '.USER_ACCOUNT_TABLE.' account ON (account.user_id = user.id) ';
      /*. 'LEFT JOIN '.FORM_ENTRY_TABLE.' entry ON (entry.object_id = user.id) '
      . 'LEFT JOIN '.FORM_ANSWER_TABLE.' entry_value ON (entry_value.entry_id = entry.id) AND entry_value.field_id=3 ';*/

    $select.='WHERE user.id='.$id;    
    $result = select($select,'object');
	 
	 return $result;
	 
	 
	 }
	
public static function getUserTickets($user){
	$select ='SELECT ticket.ticket_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id, ticket.user_id,initiator.full_name '
        .' ,dept.dept_name,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.duedate,ticket.created '
        .' ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date '
        .' ,CONCAT_WS(" ", staff.firstname, staff.lastname) as staff, team.name as team '
        .' ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(" ", staff.lastname, staff.firstname)) as assigned '
        .' ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(" / ", ptopic.topic, topic.topic)) as helptopic '
        .' ,cdata.priority as priority_id, cdata.subject, user.name, email.address as email';

$from =' FROM '.TICKET_TABLE.' as ticket '
      .' LEFT JOIN '.TICKET_STATUS_TABLE.' status ON status.id = ticket.status_id '
      .' LEFT JOIN '.USER_TABLE.' user ON user.id = ticket.user_id '
	  .' LEFT JOIN  cc_admin  initiator ON initiator.admin_id = ticket.who_created '
      .' LEFT JOIN '.USER_EMAIL_TABLE.' email ON user.id = email.user_id '
      .' LEFT JOIN '.USER_ACCOUNT_TABLE.' account ON (ticket.user_id=account.user_id) '
      .' LEFT JOIN '.DEPT_TABLE.' dept ON ticket.dept_id=dept.dept_id '
      .' LEFT JOIN '.STAFF_TABLE.' staff ON (ticket.staff_id=staff.staff_id) '
      .' LEFT JOIN '.TEAM_TABLE.' team ON (ticket.team_id=team.team_id) '
      .' LEFT JOIN '.TOPIC_TABLE.' topic ON (ticket.topic_id=topic.topic_id) '
      .' LEFT JOIN '.TOPIC_TABLE.' ptopic ON (ptopic.topic_id=topic.topic_pid) '
      .' LEFT JOIN '.TABLE_PREFIX.'ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id) '
      .' LEFT JOIN '.PRIORITY_TABLE.' pri ON (pri.priority_id = cdata.priority)';

if ($user)
    $where = 'WHERE ticket.user_id = '.db_input($user->id);
    $query ="$select $from $where GROUP BY ticket.ticket_id ORDER BY ticket.created DESC";
   
	$result = freeRun($query,'object');
	 return $result;
}	 

public static function getAllTickets($startpoint,$per_page,$fdate,$tdate,$status='1',$frdate,$trdate){

$select ='SELECT SQL_CALC_FOUND_ROWS ticket.ticket_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id, ticket.user_id ,initiator.full_name  '
        .' ,dept.dept_name,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.duedate,ticket.created '
        .' ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date '
        .' ,CONCAT_WS(" ", staff.firstname, staff.lastname) as staff, team.name as team '
        .' ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(" ", staff.lastname, staff.firstname)) as assigned '
        .' ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(" / ", ptopic.topic, topic.topic)) as helptopic '
        .' ,cdata.priority as priority_id, cdata.subject, user.name, email.address as email';

$from =' FROM '.TICKET_TABLE.' as ticket '
      .' LEFT JOIN '.TICKET_STATUS_TABLE.' status  ON status.id = ticket.status_id '
      .' LEFT JOIN '.USER_TABLE.' user ON user.id = ticket.user_id '
	   .' LEFT JOIN  cc_admin  initiator ON initiator.admin_id = ticket.who_created '
      .' LEFT JOIN '.USER_EMAIL_TABLE.' email ON user.id = email.user_id '
      .' LEFT JOIN '.USER_ACCOUNT_TABLE.' account ON (ticket.user_id=account.user_id) '
      .' LEFT JOIN '.DEPT_TABLE.' dept ON ticket.dept_id=dept.dept_id '
      .' LEFT JOIN '.STAFF_TABLE.' staff ON (ticket.staff_id=staff.staff_id) '
      .' LEFT JOIN '.TEAM_TABLE.' team ON (ticket.team_id=team.team_id) '
      .' LEFT JOIN '.TOPIC_TABLE.' topic ON (ticket.topic_id=topic.topic_id) '
      .' LEFT JOIN '.TOPIC_TABLE.' ptopic ON (ptopic.topic_id=topic.topic_pid) '
      .' LEFT JOIN '.TABLE_PREFIX.'ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id) '
      .' LEFT JOIN '.PRIORITY_TABLE.' pri ON (pri.priority_id = cdata.priority)'
	  .' LEFT JOIN '.TICKET_THREAD_TABLE.'  responder ON  ticket.ticket_id = responder.ticket_id';

//if ($agent_id){
   // $where = 'WHERE ticket.who_created = '.db_input($agent_id);
	if($fdate){
       $where .=" where DATE(ticket.created) BETWEEN '".$fdate."' AND '".$tdate."' AND ticket.status_id ='".$status."'";		
		}
	if($frdate){
       $where .=" AND (DATE(responder.created) BETWEEN '".$frdate."' AND '".$trdate."' 
	   AND (responder.thread_type <> 'A' OR  responder.thread_type <> 'E') AND responder.poster <> 'SYSTEM') ";		
		}		
     $query ="$select $from $where GROUP BY ticket.ticket_id ORDER BY ticket.created DESC LIMIT {$startpoint},{$per_page}";
     // }
	 //echo $query;
	$result = freeRun($query,'object');
	return $result;
	 
}		
public static function getAgentTickets($startpoint,$per_page,$agent_id,$fdate,$tdate,$status="1",$frdate,$trdate){

$select ='SELECT SQL_CALC_FOUND_ROWS ticket.ticket_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id, ticket.user_id,initiator.full_name '
        .' ,dept.dept_name,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.duedate,ticket.created '
        .' ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date '
        .' ,CONCAT_WS(" ", staff.firstname, staff.lastname) as staff, team.name as team '
        .' ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(" ", staff.lastname, staff.firstname)) as assigned '
        .' ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(" / ", ptopic.topic, topic.topic)) as helptopic '
        .' ,cdata.priority as priority_id, cdata.subject, user.name, email.address as email';

$from =' FROM '.TICKET_TABLE.' as ticket '
      .' LEFT JOIN '.TICKET_STATUS_TABLE.' status ON status.id = ticket.status_id '
      .' LEFT JOIN '.USER_TABLE.' user ON user.id = ticket.user_id '
	  .' LEFT JOIN  cc_admin  initiator ON initiator.admin_id = ticket.who_created '
      .' LEFT JOIN '.USER_EMAIL_TABLE.' email ON user.id = email.user_id '
      .' LEFT JOIN '.USER_ACCOUNT_TABLE.' account ON (ticket.user_id=account.user_id) '
      .' LEFT JOIN '.DEPT_TABLE.' dept ON ticket.dept_id=dept.dept_id '
      .' LEFT JOIN '.STAFF_TABLE.' staff ON (ticket.staff_id=staff.staff_id) '
      .' LEFT JOIN '.TEAM_TABLE.' team ON (ticket.team_id=team.team_id) '
      .' LEFT JOIN '.TOPIC_TABLE.' topic ON (ticket.topic_id=topic.topic_id) '
      .' LEFT JOIN '.TOPIC_TABLE.' ptopic ON (ptopic.topic_id=topic.topic_pid) '
      .' LEFT JOIN '.TABLE_PREFIX.'ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id) '
      .' LEFT JOIN '.PRIORITY_TABLE.' pri ON (pri.priority_id = cdata.priority)'
	  .' LEFT JOIN '.TICKET_THREAD_TABLE.'  responder ON  ticket.ticket_id = responder.ticket_id';
	    

if ($agent_id){
    $where = 'WHERE ticket.who_created = '.db_input($agent_id);
	if($fdate){
       $where .=" AND  DATE(ticket.created) BETWEEN '".$fdate."' AND  '".$tdate."' AND ticket.status_id ='".$status."'";		
		}
	if($frdate){
       $where .=" AND (DATE(responder.created) BETWEEN '".$frdate."' AND '".$trdate."' 
	   AND (responder.thread_type <> 'A' OR  responder.thread_type <> 'E') AND responder.poster <> 'SYSTEM') ";		
		}	
    $query ="$select $from $where GROUP BY ticket.ticket_id ORDER BY ticket.created DESC LIMIT {$startpoint},{$per_page}";
    }
	
	$result = freeRun($query,'object');
	 return $result;
	 
}	 	
public static function getTicketById($ticket_id){
	
	$select ='SELECT ticket.ticket_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id,ticket.user_id,ticket.product,ticket.nature,ticket.others,initiator.full_name  '
        .' ,dept.dept_name,status.id as status_id, status.name as  status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.duedate,ticket.created '
		.' ,ticket.reopened,ticket.closed,ticket.lastmessage,ticket.lastresponse '
        .' ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date '
        .' ,CONCAT_WS(" ", staff.firstname, staff.lastname) as staff, team.name as team '
        .' ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(" ", staff.lastname, staff.firstname)) as assigned '
        .' ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(" / ", ptopic.topic, topic.topic)) as helptopic '
        .' ,cdata.priority as priority_id, cdata.subject, user.name, email.address as email,
		(SELECT thread.created  from ts_ticket_thread as thread where thread.ticket_id = ticket.ticket_id GROUP BY thread.ticket_id
   ORDER BY thread.id DESC ) as last_response ';

$from =' FROM '.TICKET_TABLE.' as ticket '
      .' LEFT JOIN '.TICKET_STATUS_TABLE.' status
        ON status.id = ticket.status_id '
      .' LEFT JOIN '.USER_TABLE.' user ON user.id = ticket.user_id '
	  .' LEFT JOIN  cc_admin  initiator ON initiator.admin_id = ticket.who_created '
      .' LEFT JOIN '.USER_EMAIL_TABLE.' email ON user.id = email.user_id '
      .' LEFT JOIN '.USER_ACCOUNT_TABLE.' account ON (ticket.user_id=account.user_id) '
      .' LEFT JOIN '.DEPT_TABLE.' dept ON ticket.dept_id=dept.dept_id '
      .' LEFT JOIN '.STAFF_TABLE.' staff ON (ticket.staff_id=staff.staff_id) '
      .' LEFT JOIN '.TEAM_TABLE.' team ON (ticket.team_id=team.team_id) '
      .' LEFT JOIN '.TOPIC_TABLE.' topic ON (ticket.topic_id=topic.topic_id) '
      .' LEFT JOIN '.TOPIC_TABLE.' ptopic ON (ptopic.topic_id=topic.topic_pid) '
      .' LEFT JOIN '.TABLE_PREFIX.'ticket__cdata cdata ON (cdata.ticket_id = ticket.ticket_id) '
      .' LEFT JOIN '.PRIORITY_TABLE.' pri ON (pri.priority_id = cdata.priority)';

if ($ticket_id){
    $where = 'WHERE ticket.ticket_id = '.db_input($ticket_id);
	$query ="$select $from $where GROUP BY ticket.ticket_id ORDER BY ticket.created DESC";
    }
   	$result = freeRun($query,'object');
	 return $result;
	}	
	 	
public static function getNewEvent($ticket_id){
   $select ='SELECT COUNT(new_event) FROM ts_ticket_event ';
   $from = ' WHERE ticket_id ="'.$ticket_id.'" AND new_event ="1" GROUP BY new_event';
   $query ="$select $from ";
   $result = freeRun($query,'object');
   return $result;
}

public static function updateTicketViewers($ticket_id,$ids){
 $query = 'select has_viewed from ts_ticket where ticket_id="'.$ticket_id.'"';
 $result = freeRun($query,'object');
 print_r($result);
 
 $query = 'UPDATE ts_ticket SET has_viewed="'.$ids.'" WHERE ticket_id="'.$ticket_id.'"';
  // $return = update($query);
}

public static function updateEvent($ticket_id){
 $query = 'UPDATE ts_ticket_event SET new_event="0" WHERE ticket_id="'.$ticket_id.'"';
   $return = update($query);
}
public static function countThread($ticket_id){
   $select =' SELECT COUNT(id) AS thread FROM ts_ticket_thread';
   $from = '  WHERE ticket_id ="'.$ticket_id.'" AND poster <> "SYSTEM"  AND thread_type <> "E" GROUP BY ticket_id ';
   $query = "$select $from ";
   //echo $query;
   $result = freeRun($query,'object');
   return $result;
}
public static function getNewThread($ticket_id){
   $select =' SELECT new_thread as thread,viewers FROM ts_ticket_thread ';
   $from = '  WHERE ticket_id ="'.$ticket_id.'" AND thread_type ="R" AND poster <> "SYSTEM" AND new_thread ="1" order by id desc limit 1';
   $query = "$select $from ";
   $result = freeRun($query,'object');
   return $result;
}
public static function updateThread($ticket_id,$agent_id){
  $select =' SELECT id,viewers FROM ts_ticket_thread ';
   $from = '  WHERE ticket_id ="'.$ticket_id.'" AND  new_thread ="1" order by id desc limit 1';
   $query = "$select $from ";
   $result = freeRun($query,'object');
   $newthread =  mysql_fetch_object($result);
   $viewers = $newthread->viewers;
   if (strstr($newthread->viewers,$agent_id) == false){
	   $viewers .= $agent_id.','; 	
	   $query = 'UPDATE ts_ticket_thread SET viewers="'.$viewers.'",updated="'.date("Y-m-d H:i:s").'" WHERE id="'.$newthread->id.'"';
	   $return = update($query);
	   if($return){
	   }
   }
	
}

public static function getTicketThread($ticket_id){
	$select ='SELECT ticket.*';
$from =' FROM '.TICKET_THREAD_TABLE.' as ticket ';
if ($ticket_id){
    $where = ' WHERE ticket.ticket_id = '.db_input($ticket_id);
	$where .= ' AND ticket.poster <> "SYSTEM" ';
 	$query ="$select $from $where ORDER BY ticket.created DESC";
    }
	//echo  $query;
   	$result = freeRun($query,'object');
	 return $result;
	}
public static function getattchment($thread_id,$ticket_id){
    $query ='SELECT tta.file_id,tf.name,tf.key,tf.signature FROM ts_ticket_attachment AS tta 
         LEFT JOIN ts_file AS tf ON tf.id = tta.file_id
         WHERE tta.ref_id ="'.$ticket_id.'"  AND tta.ticket_id = "'.$thread_id.'"';
	 $result = freeRun($query,'object');
	 return $result;
}
public static function getlastTicketId(){
	$query ='SELECT ticket_id FROM '.TICKET_TABLE .' ORDER BY ticket_id DESC LIMIT 1;';
	return $r = select($query);

}
			
 public static function createTicket($vars){
	//print_r($vars);
	//die;
	$depart= ($vars['deptId'])?$vars['deptId']:"0";
    $query = 'INSERT INTO '.TICKET_TABLE .' SET number="'.$vars['number'].'",user_id='.$vars['uid'].', status_id="1", topic_id='.$vars['topicId'].', dept_id='.$depart.',team_id='.$vars['team_id'].',product="'.$vars['products'].'",nature="'.$vars['natures'].'",others="'.$vars['others'].'", ip_address="'.$_SERVER['REMOTE_ADDR'].'", source="'.$vars['source'].'", duedate="'.$vars['duedate'].' '.$vars['time'].'", lastmessage="'.date("Y-m-d H:i:s").'", lastresponse="'.date("Y-m-d H:i:s").'", created="'.date("Y-m-d H:i:s").'", updated="'.date("Y-m-d H:i:s").'", unique_id="'.$vars['unique_id'].'", who_created="'.$vars['who_created'].'"';
	//die;
	 $ticket_id = insert($query);
	if($ticket_id){
		$query='INSERT INTO ts__search'.' SET object_type="T"'.', object_id='.$ticket_id.', title="'.$vars['number']." ".$vars['issue_summery'].'", content="'.$vars['issue_summery'].'"';
	  insert($query);	
  if($vars['message']){
	 $query = 'INSERT INTO '.TICKET_THREAD_TABLE.' SET ticket_id='.$ticket_id.',status="1",team_id='.$vars['team_id'].',due_date="'.$vars['duedate'].'",priority_id="'.$vars['priority_level'].'",product="'.$vars['products'].'",nature="'.$vars['natures'].'",others="'.$vars['others'].'",user_id='.$vars['uid'].', thread_type="A"'.',poster="'.$vars['poster'].'", source="'.$vars['source'].'", title="'.$vars['issue_summery'].'", body="'.$vars['message'].'", format="html"'.',cc_agent_id="'.$vars['who_created'].'", ip_address="'.$_SERVER['REMOTE_ADDR'].'", created="'.date("Y-m-d H:i:s").'",updated="'.date("Y-m-d H:i:s").'"';
	$thread_id =  insert($query);	
	}
	/*if($vars['note']){
    $query = 'INSERT INTO '.TICKET_THREAD_TABLE.' SET ticket_id='.$ticket_id.', thread_type="N"'.',poster="'.$vars['poster'].'", title="New Ticket"'.', body="'.$vars['note'].'", format="html"'.', ip_address="'.$_SERVER['REMOTE_ADDR'].'", created="'.date("Y-m-d H:i:s").'"';
	  insert($query);	
    }*/
    $query = 'INSERT INTO ts_ticket__cdata'.' SET ticket_id='.$ticket_id.', subject="'.$vars['issue_summery'].'", priority="'.$vars['priority_level'].'"';
	  insert($query);	
    $query = 'INSERT INTO '.FORM_ENTRY_TABLE .' SET form_id=2' .', object_id='.$ticket_id.', object_type="T"'.', sort=1'.', created="'.date("Y-m-d H:i:s").'", updated="'.date("Y-m-d H:i:s").'"';
    $form_entry_id = insert($query);	
   if($form_entry_id){
	   $query = 'INSERT INTO '.FORM_ANSWER_TABLE .' SET entry_id='.$form_entry_id.', field_id=20'.', value="'.$vars['issue_summery'].'"';
     insert($query);	
     $query = 'INSERT INTO '.FORM_ANSWER_TABLE .' SET entry_id='.$form_entry_id.', field_id=22'.', value="'.$vars['priority_desc'].'"';
     insert($query);
	}
}
return array('ticket_id'=>$ticket_id,'ref_id'=>$thread_id);	
	/*print_r($vars);
	  die('here');*/ 
	 }

public static function updateTicket($vars){
  	//echo "<pre>"; print_r($vars); 
	 $duedate = strtotime($vars['duedate']);
	 $now = strtotime(date('Y-m-d H:i:s'));
	 $overdue = 1;
	if($duedate > $now ){ 
	 $overdue = 0;
	}
	//echo "</pre>";
	//die;
    $query = 'UPDATE '.TICKET_TABLE .' SET dept_id='.$vars['deptId'].',team_id='.$vars['team_id'].',product="'.$vars['products'].'",nature="'.$vars['natures'].'",others="'.$vars['others'].'", isoverdue="'.$overdue.'",isanswered="0",duedate="'.$vars['duedate'].' '.$vars['time'].'",lastresponse="'.date("Y-m-d H:i:s").'", updated="'.date("Y-m-d H:i:s").'"  where ticket_id="'.$vars['ticket_id'].'"';
    $ticket_id = update($query);
	//die;
  if($vars['message']){
	  
	 $query = 'INSERT INTO '.TICKET_THREAD_TABLE.' SET ticket_id='.$vars['ticket_id'].',status="1",is_overdue="'.$overdue.'",team_id='.$vars['team_id'].',due_date="'.$vars['duedate'].'",priority_id="'.$vars['priority_level'].'",product="'.$vars['products'].'",nature="'.$vars['natures'].'",others="'.$vars['others'].'",thread_type="E"'.',poster="'.$vars['poster'].'", source="'.$vars['source'].'", title="Ticket Updated:'.$vars['old_summary'].'", body="'.$vars['message'].'", format="html"'.',cc_agent_id="'.$vars['agent_id'].'", ip_address="'.$_SERVER['REMOTE_ADDR'].'", created="'.date("Y-m-d H:i:s").'",updated="'.date("Y-m-d H:i:s").'"';
	 $thread_id =  insert($query);
	 // $query = 'UPDATE '.TICKET_THREAD_TABLE.' SET thread_type="E"'.',poster="'.$vars['poster'].'", source="'.$vars['source'].'", title="Ticket Updated"'.', body="'.$vars['message'].'", format="html", updated="'.date("Y-m-d H:i:s").'"   where id="'.$vars['thread_id'].'"';
	  // $thread_id =  update($query);
     	   
	}
     $query = 'UPDATE ts_ticket__cdata  SET subject="'.$vars['issue_summery'].'", priority="'.$vars['priority_level'].'" where ticket_id="'.$vars['ticket_id'].'"';
	// $query = 'UPDATE ts_ticket__cdata  SET  priority="'.$vars['priority_level'].'" where ticket_id="'.$vars['ticket_id'].'"';
	 update($query);	
	return array('ticket_id'=>$vars['ticket_id'],'ref_id'=>$thread_id);    
  //return array('ticket_id'=>$vars['ticket_id'],'ref_id'=>$vars['thread_id']);	
	/*print_r($vars);*/
 }
	 	
public static function uploadFile($info){
    $query = 'INSERT INTO ts_file SET ft="T",bk="D", type="'.$info['type'].'", size="'.$info['size'].'", 
		   name="'.$info['name'].'",created="'.date("Y-m-d H:i:s").'"';
   return  $file_id = insert($query);
  
  
}

public static function  ticket_attachment($ids,$file_id){
	if($ids){
	$query = 'INSERT INTO ts_ticket_attachment SET ticket_id="'.$ids['ticket_id'].'",file_id="'.$file_id.'",ref_id="'.$ids['ref_id'].'", created="'.date("Y-m-d H:i:s").'"';  
    return insert($query);
  }

}	 
	 
public static function uniqueEmail($email){
	$query = 'SELECT address FROM '.USER_EMAIL_TABLE.' WHERE address="'.trim($email).'" limit 1';
	$r = select($query);
	if(is_array($r) && count($r)>0){
		  return true;
    }else{
      return false;
    }
	}
  public static function uniqueCMID($cmid){
  $query = 'SELECT cmid FROM '.USER_TABLE.' WHERE cmid="'.trim($cmid).'" limit 1';
  $r = select($query);
  if(is_array($r) && count($r)>0){
      return true;
    }else{
      return false;
    }
  }
  public static function uniqueUIN($uin){
  $query = 'SELECT uid FROM '.USER_TABLE.' WHERE uin="'.trim($uin).'" limit 1';
  $r = select($query);
  if(is_array($r) && count($r)>0){
      return true;
    }else{
      return false;
    }
  }
  public static function uniqueCNIC($cnic){
  $query = 'SELECT cnic FROM '.USER_TABLE.' WHERE cnic="'.trim($cnic).'" limit 1';
  $r = select($query);
  if(is_array($r) && count($r)>0){
      return true;
    }else{
      return false;
    }
  }
  public static function uniqueRegisterNum($register_num){
  $query = 'SELECT register_num FROM '.USER_TABLE.' WHERE register_num="'.trim($register_num).'" limit 1';
  $r = select($query);
  if(is_array($r) && count($r)>0){
      return true;
    }else{
      return false;
    }
  }
 public static function  getUsers(){
  $select = 'SELECT user.id,user.name from '.USER_TABLE.' as user';
  return freeRun($select);
   
  }    	 

}

?>

