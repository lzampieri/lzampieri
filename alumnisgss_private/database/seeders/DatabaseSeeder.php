<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create a admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'user_verified_at' => date("Y-m-d H:i:s")
        ]);

        // Create a slave user
        $slave = User::create([
            'name' => 'Slave',
            'email' => 'slave@slave.com',
            'password' => Hash::make('password'),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'user_verified_at' => date("Y-m-d H:i:s")
        ]);

        // Create permissions
        Permission::create(['name' => 'edit sections']);
        Permission::create(['name' => 'edit users']);

        // Assign permission to admin
        $admin->givePermissionTo('edit sections');
        $admin->givePermissionTo('edit users');

        // Create example section
        Section::create([
            'shortname' => 'section1',
            'title' => 'Sezione 1',
            'content' => 'Contenuto sezione 1'
        ]);
    }
}
