<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for($i = 0; $i< 10; $i++)
        {
            User::create([
                'first_name' => 'user_' . str_random(),
                'last_name' => 'user_' . str_random(),
                'email' => 'user_' . str_random() . '@gmail.com',
                'password' => 'user_' . str_random(),
            ]);
        }
    }

}
