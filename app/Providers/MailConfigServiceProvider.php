<?php

namespace App\Providers;

use Config;
use App\Models\MailSetting;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $emailServices = MailSetting::where('active',1)->where('driver','rdms')->first();

        if ($emailServices) {
            $config = array(
                'driver'     => 'smtp',
                'host'       => $emailServices->host,
                'port'       => $emailServices->port,
                'username'   => $emailServices->username,
                'password'   => $emailServices->password,
                'encryption' => null,
                'from'       => array('address' => $emailServices->from_address, 'name' => $emailServices->from_name),
                'sendmail'   => '/usr/sbin/sendmail -bs',
                'pretend'    => false,
            );

            Config::set('mail', $config);
        }
        
    }
}
