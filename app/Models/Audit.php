<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model{ 
  
	protected $guarded  = ['created_at', 'updated_at'];

  public function users(){
    return $this->belongsTo('App\Models\User', 'user_id')->withDefault();
  }
}
