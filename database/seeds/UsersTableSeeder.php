<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
      $data = [
          'name'  => 'admin',
          'fname' => 'Admin',
          'lname' => 'User',
          'email' => 'admin@wamglam.com',
          'password'  => Hash::make('12345678'),
          'mobile_no' => '98166422',
          'type'      => '3'

      ];
      $user = \App\User::create($data);
      $user->assignRole('Super-Admin');
    }

}
