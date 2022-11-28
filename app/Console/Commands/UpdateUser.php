<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $iccs = DB::connection('mysql2')->table('iccs_be.users')->select('username','email','department','password','name','active')
        ->where('active',1)
        ->get();

        foreach($iccs as $data){            
            $user = DB::table('users')
            ->UpdateOrInsert(
            ['username' => $data->username],[
            'email' => $data->email,
            'department' => $data->department,
            'password' => $data->password,
            'name' => $data->name, 
            'active' => $data->active,
            'iccs' => 1,
                ]);
        }          
        
        return Command::SUCCESS;
    }
}
