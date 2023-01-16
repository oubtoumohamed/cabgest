<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{ 
    /**
    * Run the database seeds.
    *
    * @return void
    */
    
    public function run()
    {

        $data = [
            [
                'firstname' => 'SUPER',
                'lastename' => 'ADMIN',
                'username' => 'superadmin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'ADMIN',
            ],
            [
                'firstname' => 'ALAMI',
                'lastename' => 'Ahmed',
                'username' => 'alamiahmed',
                'email' => 'alami@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'EMPLOYE',
            ],
            [

                'firstname' => 'admin',
                'lastename' => 'admin',
                'username' => 'admin',
                'email'    => 'admin@travelportal.com',
                'password' => bcrypt('123456'),
                'role' => 'EMPLOYE',
            ],
            [

                'firstname' => 'agent',
                'lastename' => 'agent',
                'username' => 'agent',
                'email'    => 'agent@travelportal.com',
                'password' => bcrypt('123456'),
                'role' => 'EMPLOYE',
            ],
            [

                'firstname' => 'customer',
                'lastename' => 'customer',
                'username' => 'customer',
                'email'    => 'customer@travelportal.com',
                'password' => bcrypt('123456'),
                'role' => 'EMPLOYE',
            ],
            [

                'firstname' => 'first_agency',
                'lastename' => 'first_agency',
                'username' => 'first_agency',
                'email'    => 'first_agency@travelportal.com',
                'password' => bcrypt('123456'),
                'role' => 'EMPLOYE',
            ],
            [

                'firstname' => 'first_cooperate_customer',
                'lastename' => 'first_cooperate_customer',
                'username' => 'first_cooperate_customer',
                'email'    => 'first_cooperate_customer@travelportal.com',
                'password' => bcrypt('123456'),
                'role' => 'EMPLOYE',
            ],
        ];

        User::insert($data);
    }
}
