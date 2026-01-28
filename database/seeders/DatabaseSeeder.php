<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Rolleri oluştur
        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'slug' => 'super-admin',
            'description' => 'Tam yetkili yönetici',
        ]);

        $admin = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'description' => 'Yönetici',
        ]);

        $user = Role::create([
            'name' => 'Kullanıcı',
            'slug' => 'user',
            'description' => 'Standart kullanıcı',
        ]);

        // Test kullanıcısı oluştur
        $testUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // SuperAdmin rolü ata
        $testUser->roles()->attach($superAdmin->id);
    }
}
