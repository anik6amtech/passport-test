<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define user types and their corresponding data
        $userTypes = [
            'admin' => [
                'name' => 'System Administrator',
                'phone' => '+1234567890',
            ],
            'customer' => [
                'name' => 'John Customer',
                'phone' => '+1234567891',
            ],
            'deliveryman' => [
                'name' => 'Mike Delivery',
                'phone' => '+1234567892',
            ],
            'supplier' => [
                'name' => 'Sarah Supplier',
                'phone' => '+1234567893',
            ],
        ];

        // Create users for each type
        foreach ($userTypes as $userType => $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userType . '@gmail.com',
                'phone' => $userData['phone'],
                'user_type' => $userType,
                'password' => '12345678', // Will be automatically hashed by the model mutator
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'is_active' => true,
            ]);
        }

        $this->command->info('Users seeded successfully!');
        $this->command->info('Login credentials:');
        $this->command->info('Admin: admin@gmail.com / 12345678');
        $this->command->info('Customer: customer@gmail.com / 12345678');
        $this->command->info('Deliveryman: deliveryman@gmail.com / 12345678');
        $this->command->info('Supplier: supplier@gmail.com / 12345678');
    }
}
