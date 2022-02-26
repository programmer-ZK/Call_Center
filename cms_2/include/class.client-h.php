<?php 
require_once INCLUDE_DIR . 'class.orm.php';
require_once INCLUDE_DIR . 'class.util.php';

class ClientInfo_h{
 
 public static function addUserH($info_r){

   //$phone= $info_r['phone-ext'].$info_r['phone'];
   $usr_id =  $info_r['id'];
   $return = db_query('UPDATE '.USER_TABLE
            .' SET org_id='.db_input(0)
            .', name='.db_input($info_r['full_name'])
            .', updated='.db_input(date("Y-m-d H:i:s"))
            .' WHERE id='.db_input($usr_id));  
   if($return)
   $return =  db_query('INSERT INTO '.USER_EMAIL_TABLE
            .' SET user_id='.db_input($usr_id)
            .', address='.db_input($info_r['email']));
   $lastID =  db_insert_id();
   db_query('UPDATE '.USER_TABLE.' SET default_email_id='.db_input($lastID)
                .' WHERE id='.db_input($usr_id));

   /*db_query('INSERT INTO '.USER_ACCOUNT_TABLE
            .' SET user_id='.db_input($usr_id)
            .', timezone_id='.db_input(21)
            .', registered=NOW()');*/

   return $usr_id;

 }

 public static function getUserH($info_r){
        
        $phone = ($info_r['phone-ext']!="")? $info_r['phone'].'X'.$info_r['phone-ext']:$info_r['phone'];
       /* echo 'SELECT entry.object_id as id,entry_values.value FROM '.FORM_ENTRY_TABLE.' as entry '
                .'inner join '.FORM_ANSWER_TABLE.' as entry_values on entry.id=entry_values.entry_id'
                .' WHERE entry_values.field_id=3 and entry_values.value='.db_input($phone)
                .' limit 1';*/         
        $search_1 = db_query('SELECT entry.object_id as id,entry_values.value FROM '.FORM_ENTRY_TABLE.' as entry '
                .'inner join '.FORM_ANSWER_TABLE.' as entry_values on entry.id=entry_values.entry_id'
                .' WHERE entry_values.field_id=3 and entry_values.value='.db_input($phone)
                .' limit 1');
        
        $search_2 = db_query('SELECT id FROM '.USER_TABLE
                .' WHERE phone='.db_input(trim($phone))
                .' limit 1');
        
        $r = db_fetch_array($search_1);
        $r2 = db_fetch_array($search_2);
        if(count($r)>0){
         $r['exist']=true;   
         return $r;
        }elseif(count($r2)>0){
          $r['exist']=true;   
           return $r;
        }else{
       /* echo 'INSERT INTO '.FORM_ENTRY_TABLE 
            .' SET form_id=1'
            .', object_id='.$usr_id
            .', object_type="U"'
            .', sort=1'
            .', created='.db_input(date("Y-m-d H:i:s"))
            .', updated='.db_input(date("Y-m-d H:i:s"))."'";
        echo 'INSERT INTO '.FORM_ANSWER_TABLE 
            .' SET entry_id='.$form_entry_id
            .', field_id=3'
            .', value='.db_input($phone)."'";

      die(mysql_error());
      die;      */
        db_query('INSERT INTO '.USER_TABLE
            .' SET org_id='.db_input(0)
            .', phone='.db_input($phone)
            .', created='.db_input(date("Y-m-d H:i:s"))
            .', updated='.db_input(date("Y-m-d H:i:s")));
        $usr_id =  db_insert_id();
        $r['id'] = $usr_id;
        if($usr_id){
        db_query('INSERT INTO '.FORM_ENTRY_TABLE 
            .' SET form_id=1'
            .', object_id='.$usr_id
            .', object_type="U"'
            .', sort=1'
            .', created='.db_input(date("Y-m-d H:i:s"))
            .', updated='.db_input(date("Y-m-d H:i:s")));
         }
         $form_entry_id =  db_insert_id();
        if($form_entry_id){
         db_query('INSERT INTO '.FORM_ANSWER_TABLE 
            .' SET entry_id='.$form_entry_id
            .', field_id=3'
            .', value='.db_input($phone));
         }
        $r['exist']=false; 
        return $r;  
        }
        


 } 

}

?>

