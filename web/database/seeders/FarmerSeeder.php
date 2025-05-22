<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FarmerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $farmers = [
            [
                'name' => 'John Smith',
                'email' => 'john.smith@example.com',
                'address' => '123 Farm Road, Rural County',
                'number' => '555-0101',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@example.com',
                'address' => '456 Harvest Lane, Farmville',
                'number' => '555-0102',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Robert Johnson',
                'email' => 'robert.johnson@example.com',
                'address' => '789 Crop Circle, Agritown',
                'number' => '555-0103',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah.williams@example.com',
                'address' => '321 Orchard Street, Farmland',
                'number' => '555-0104',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@example.com',
                'address' => '654 Barn Road, Countryside',
                'number' => '555-0105',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Lisa Davis',
                'email' => 'lisa.davis@example.com',
                'address' => '987 Field Avenue, Ruralville',
                'number' => '555-0106',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'James Wilson',
                'email' => 'james.wilson@example.com',
                'address' => '147 Farmhouse Lane, Agritown',
                'number' => '555-0107',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Patricia Moore',
                'email' => 'patricia.moore@example.com',
                'address' => '258 Harvest Drive, Farmville',
                'number' => '555-0108',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'David Taylor',
                'email' => 'david.taylor@example.com',
                'address' => '369 Crop Street, Farmland',
                'number' => '555-0109',
                'password' => Hash::make('password123'),
            ],
            [
                'name' => 'Jennifer Anderson',
                'email' => 'jennifer.anderson@example.com',
                'address' => '741 Orchard Road, Countryside',
                'number' => '555-0110',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($farmers as $farmer) {
            \App\Models\Farmer::create($farmer);
        }
    }
}
