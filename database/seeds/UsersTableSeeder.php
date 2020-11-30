<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'type' => 'admin',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Tecnico Test',
            'email' => 'technical@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret1234'),
            'type' => 'technical',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('role_user')->insert([
            'user_id' => 2,
            'role_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'name' => 'Perito Test',
            'email' => 'perito@test.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret1234'),
            'type' => 'proficient',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('role_user')->insert([
            'user_id' => 3,
            'role_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('clients')->insert([
            'name' => 'Cliente Test',
            'email' => 'cliente@test.com',
            "document" => '1234',
            "address" => 'test address',
            "city" => 'test city',
            "postal_code" => 'test postal code',
            "state" => 'test state',
            "country" => 'country',
            "phone" => '582738837269',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
