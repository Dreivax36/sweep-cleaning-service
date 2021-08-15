<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\User;
use DB;

class UsersTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
            'admin'        => 'Lyka Casilao',
            'email'        => 'lykacasilao@gmail.com',
            'password'     => Hash::make('password'),
            'remember_token'=> str_random(10),
        ]);
    }
}
