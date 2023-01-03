<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;


class Purchase extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
	protected $guarded  = ['created_at', 'updated_at'];

	public function products(){
        return $this->belongsTo('App\Models\Product', 'id_produk')->withDefault();
    }

    public function employees(){
        return $this->belongsTo('App\Models\User', 'id_karyawan')->withDefault();
    }

    public function creators(){
        return $this->belongsTo('App\Models\User', 'created_by')->withDefault();
    }

    public function batches(){
        return $this->belongsTo('App\Models\Batch', 'id_batch')->withDefault();
    }

    /* protected static function booted()
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->wherebetween('created_at',['2022-01-01',now()]);
        });
    } */
}
