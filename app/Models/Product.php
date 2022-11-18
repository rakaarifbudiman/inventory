<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;    
	protected $guarded  = ['created_at', 'updated_at'];

	public function categories()
    {
        return $this->belongsTo('App\Models\Category', 'id_kategori');
    }   

    public function units()
    {
        return $this->belongsTo('App\Models\Unit', 'id_unit');
    }
}
