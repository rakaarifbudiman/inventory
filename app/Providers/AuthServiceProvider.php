<?php

namespace App\Providers;

use App\Models\Sell;
use App\Models\Product;
use App\Models\Purchase;
use App\Policies\SellPolicy;
use App\Policies\ProductPolicy;
use App\Policies\PurchasePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        Product::class => ProductPolicy::class,
        Sell::class => SellPolicy::class,
        Purchase::class => PurchasePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
