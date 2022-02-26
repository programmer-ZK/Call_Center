<?php 

class ClientInfo{

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
       $query = 'INSERT INTO '.USER_TABLE.' (org_id,register_num,name,cmid,uin,cnic,phone,created,updated) VALUES (0,"'.$r_num.'","'.$info_r['full_name'].'","'.$cmid.'","'.$uin.'","'.$cnic.'","'.$phone.'","'.date("Y-m-d H:i:s").'","'.date("Y-m-d H:i:s").'")';
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
         $query = 'SELECT user_id as id FROM '.TICKET_TABLE.' WHERE number="'.trim($info_r['search']).'" limit 1';
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
	 
public static function getUserTickets($user,$org=false){
	$select ='SELECT ticket.ticket_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id, ticket.user_id '
        .' ,dept.dept_name,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.duedate,ticket.created '
        .' ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date '
        .' ,CONCAT_WS(" ", staff.firstname, staff.lastname) as staff, team.name as team '
        .' ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(" ", staff.lastname, staff.firstname)) as assigned '
        .' ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(" / ", ptopic.topic, topic.topic)) as helptopic '
        .' ,cdata.priority as priority_id, cdata.subject, user.name, email.address as email';

$from =' FROM '.TICKET_TABLE.' as ticket '
      .' LEFT JOIN '.TICKET_STATUS_TABLE.' status
        ON status.id = ticket.status_id '
      .' LEFT JOIN '.USER_TABLE.' user ON user.id = ticket.user_id '
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
elseif ($org)
    $where = 'WHERE user.org_id = '.db_input($org->getId());
    $query ="$select $from $where ORDER BY ticket.created DESC";
   
	$result = freeRun($query,'object');
	 return $result;
	}	 
public static function getTicketById($ticket_id){
	$select ='SELECT ticket.ticket_id,ticket.`number`,ticket.dept_id,ticket.staff_id,ticket.team_id, ticket.user_id '
        .' ,dept.dept_name,status.name as status,ticket.source,ticket.isoverdue,ticket.isanswered,ticket.duedate,ticket.created '
		.' ,ticket.reopened,ticket.closed,ticket.lastmessage,ticket.lastresponse '
        .' ,CAST(GREATEST(IFNULL(ticket.lastmessage, 0), IFNULL(ticket.reopened, 0), ticket.created) as datetime) as effective_date '
        .' ,CONCAT_WS(" ", staff.firstname, staff.lastname) as staff, team.name as team '
        .' ,IF(staff.staff_id IS NULL,team.name,CONCAT_WS(" ", staff.lastname, staff.firstname)) as assigned '
        .' ,IF(ptopic.topic_pid IS NULL, topic.topic, CONCAT_WS(" / ", ptopic.topic, topic.topic)) as helptopic '
        .' ,cdata.priority as priority_id, cdata.subject, user.name, email.address as email';

$from =' FROM '.TICKET_TABLE.' as ticket '
      .' LEFT JOIN '.TICKET_STATUS_TABLE.' status
        ON status.id = ticket.status_id '
      .' LEFT JOIN '.USER_TABLE.' user ON user.id = ticket.user_id '
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
	$query ="$select $from $where ORDER BY ticket.created DESC";
    }
   	$result = freeRun($query,'object');
	 return $result;
	}	 	
public static function getTicketThread($ticket_id){
	$select ='SELECT * ';
$from =' FROM '.TICKET_THREAD_TABLE.' as ticket ';
if ($ticket_id){
    $where = 'WHERE ticket.ticket_id = '.db_input($ticket_id);
	$query ="$select $from $where ORDER BY ticket.created DESC";
    }
   	$result = freeRun($query,'object');
	 return $result;
	}	
	//.',team_id='.$vars['team_id'].', 	
	//.', dept_id='.$vars['deptId'].'	
 public static function createTicket($vars){
   $query = 'INSERT INTO '.TICKET_TABLE .' SET number='.$vars['number'].',user_id='.$vars['uid'].', status_id="1", topic_id='.$vars['topicId'].',team_id='.$vars['team_id'].' , ip_address="'.$_SERVER['REMOTE_ADDR'].'", source="'.$vars['source'].'", duedate="'.$vars['duedate'].' '.$vars['time'].'", lastmessage="'.date("Y-m-d H:i:s").'", created="'.date("Y-m-d H:i:s").'", updated="'.date("Y-m-d H:i:s").'", unique_id="'.$vars['unique_id'].'", who_created="'.$vars['who_created'].'"';
	 $ticket_id = insert($query);
	if($ticket_id){
		$query='INSERT INTO ts__search'.' SET object_type="T"'.', object_id='.$ticket_id.', title="'.$vars['number']." ".$vars['issue_summery'].'", content="'.$vars['issue_summery'].'"';
	  insert($query);	
  if($vars['message']){
	 $query = 'INSERT INTO '.TICKET_THREAD_TABLE.' SET ticket_id='.$ticket_id.', user_id='.$vars['uid'].', thread_type="M"'.',poster="'.$vars['poster'].'", source="'.$vars['source'].'", title="New Ticket"'.', body="'.$vars['message'].'", format="html"'.', ip_address="'.$_SERVER['REMOTE_ADDR'].'", created="'.date("Y-m-d H:i:s").'"';
	 insert($query);	
	}
	if($vars['note']){
    $query = 'INSERT INTO '.TICKET_THREAD_TABLE.' SET ticket_id='.$ticket_id.', thread_type="N"'.',poster="'.$vars['poster'].'", title="New Ticket"'.', body="'.$vars['note'].'", format="html"'.', ip_address="'.$_SERVER['REMOTE_ADDR'].'", created="'.date("Y-m-d H:i:s").'"';
	  insert($query);	
    }
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
return $ticket_id;	
	/*print_r($vars);
	die('here');*/
	 
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

