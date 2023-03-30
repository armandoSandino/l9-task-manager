<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CollaboratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('collaborators')->insert([
            'name' => 'Jordan Sanchez',
            'lastName' => 'Lopez',
            'address' => 'Leon, Nicaragua',
            'email'=>'jordan.s.l@tistesoft.com.ni',
            'phone' => '34568809',
            'location' => 'Leon',
            'country' => 'Nicaragua',
            'ruc' => '1234567890'
        ]);
        
        Db::table('collaborators')->insert([
            'name' => 'Martin',
            'lastName' => 'Solorzano',
            'address' => 'Leon, Nicaragua',
            'email'=>'martin.s@tistesoft.com.ni',
            'phone' => '34568808',
            'location' => 'Leon',
            'country' => 'Nicaragua',
            'ruc' => '1234567899'
        ]);
    }
}
