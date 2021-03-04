<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'idceo'=>1,    
                'name'=>'Agnus',   
                'email'=>'email@email.com',      
                'password'=>bcrypt('123456'),  
                'nivel'=>'CEO'
            ],
            [
                'idceo'=>2,    
                'name'=>'Carlos',           
                'email'=>'alexblacee@gmail.com', 
                'password'=>bcrypt('12345678'),
                'nivel'=>'CEO'
            ],
        ]);
    }
}
