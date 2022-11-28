<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
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
    public function create(User $user, Product $product)
    {
        return $user->akses === 'admin';
    }

    public function edit(User $user, Product $product)
    {            
        return $user->akses == 'admin' && Str::containsAll($user->role, [$product->categories->nama_kategori]);       
    }
}
