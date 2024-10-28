<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing admin users to avoid duplicates
        User::where('Role', 'Admin')->delete();

        User::create([
            'Username' => 'admin',
            'Email' => 'admin@asyv.org',
            'Password' => Hash::make('Admin@123'),
            'FirstName' => 'System',
            'LastName' => 'Administrator',
            'Role' => 'Admin',
            'IsTeacher' => false,
            'IsActive' => true
        ]);

        // Create additional admin users if needed
        $additionalAdmins = [
            [
                'Username' => 'supervisor',
                'Email' => 'supervisor@asyv.org',
                'Password' => Hash::make('Supervisor@123'),
                'FirstName' => 'EP',
                'LastName' => 'Supervisor',
                'Role' => 'Admin',
                'IsTeacher' => false,
                'IsActive' => true
            ],
            // Add more admin users as needed
        ];

        foreach ($additionalAdmins as $admin) {
            User::create($admin);
        }

        $this->command->info('Admin users created successfully!');
    }
}
