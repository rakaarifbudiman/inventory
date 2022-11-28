<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Batch extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
	protected $guarded  = ['created_at', 'updated_at'];    

    public function products(){

        return $this->belongsTo('App\Models\Product', 'id_produk');
    }
}
