<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Unit extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
	    
	protected $guarded  = ['created_at', 'updated_at'];
}
