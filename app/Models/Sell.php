<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\User;

class Sell extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
	protected $guarded  = ['created_at', 'updated_at','id'];

	public function employees(){
        return $this->belongsTo('App\Models\User', 'id_karyawan');
    }

    public function creators(){
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function products(){

        return $this->belongsTo('App\Models\Product', 'id_produk');
    }

    public function batches(){
        return $this->belongsTo('App\Models\Batch', 'id_batch');
    }
    
}
