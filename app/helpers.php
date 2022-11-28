<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;




function email_notif($to,$cc,$subject,$body){

    DB::table('tbliccsemail')->insert([                
        'iccsTo' => $to,
        'iccsCC' => $cc,
        'iccsSubject' => $subject,
        'iccsBody' => $body,
    ]);
}

function auditparts($change_by,$activity,$recordid,$table,$field,$before,$after){      
    DB::table('rdms_be.audit_parts')->insert([  
        'created_at'=>now(),
        'change_by'=>$change_by,
        'activity'=>$activity,
        'recordid' => $recordid,
        'sourcetable' => $table,
        'sourcefield' => $field,
        'beforevalue' => $before,
        'aftervalue' => $after,
    ]);    
                
}

function getoldvalues($connection,$table,$data){
    $fields = array_diff(Schema::Connection($connection)->getColumnListing($table),['updated_at']);    
    //get old value 
    foreach($fields as $field){
        $old[$field]= $data->$field;
    }     
    return ['fields'=>$fields,'old'=>$old,'table'=>$table];
}

function randomPassword($len = 8) {

    //enforce min length 8
    if($len < 8)
        $len = 8;

    //define character libraries - remove ambiguous characters like iIl|1 0oO
    $sets = array();
    $sets[] = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
    $sets[] = 'abcdefghjkmnpqrstuvwxyz';
    $sets[] = '23456789';
    //$sets[]  = '!@#$%^&*?';

    $password = '';
    
    //append a character from each set - gets first 4 characters
    foreach ($sets as $set) {
        $password .= $set[array_rand(str_split($set))];
    }

    //use all characters to fill up to $len
    while(strlen($password) < $len) {
        //get a random set
        $randomSet = $sets[array_rand($sets)];
        
        //add a random char from the random set
        $password .= $randomSet[array_rand(str_split($randomSet))]; 
    }
    
    //shuffle the password string before returning!
    return str_shuffle($password);
}