<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Purchase;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
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

    public function edit(User $user, Purchase $purchase)
    {            
        return $user->akses == 'admin' && Str::containsAll($user->role, [$purchase->products->categories->nama_kategori]);       
    }
}
