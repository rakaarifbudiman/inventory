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