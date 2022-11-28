<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductConversion extends Model
{
    use HasFactory;

    public function from_units()
    {
        return $this->belongsTo('App\Models\Unit', 'from_unit');
    }

    public function to_units()
    {
        return $this->belongsTo('App\Models\Unit', 'to_unit');
    }

    public function products(){
        return $this->belongsTo('App\Models\Product', 'id_produk');
    }
}
