<?php

namespace App\Models;

use App\Models\ProductConversion;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;    
	protected $guarded  = ['created_at', 'updated_at'];

	public function categories()
    {
        return $this->belongsTo('App\Models\Category', 'id_kategori')->withDefault();
    }   

    public function units()
    {
        return $this->belongsTo('App\Models\Unit', 'id_unit')->withDefault();
    }

    public function conversions()
    {
        return $this->hasMany('App\Models\ProductConversion','id_produk')->withDefault();
    }
}
