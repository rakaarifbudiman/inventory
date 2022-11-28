<?php

namespace App\Policies;

use App\Models\Sell;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class SellPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Sell $sell)
    {            
        return $user->akses == 'admin' && Str::containsAll($user->role, [$sell->products->categories->nama_kategori]);       
    }
}
