<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RolesTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

       DB::table('roles')->insert([
           [
              'name' => 'Super-Admin',
              'label' => 'Super-Admin',
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now(),
            ],
           [
              'name' => 'Client',
              'label' => 'client',
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now(),
            ],
           [
              'name' => 'Artist',
              'label' => 'artist',
              'created_at' => \Carbon\Carbon::now(),
              'updated_at' => \Carbon\Carbon::now(),
            ],


        ]);

    }

}
