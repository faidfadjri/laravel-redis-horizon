<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1000)->create();

        echo "Seeding 5.000 Transactions\n";
        Transaction::factory(5000)->create();

        echo "Seeding Additional 5.000 Transactions";
        Transaction::factory(5000)->create();
    }
}
