<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $audience_levels = ['HR', 'Public'];
        $departments = [
            'Shwetatar Co.,Ltd', 'Leadership', 'Digital Marketing', 'Finance & Accounting',
            'GM Office', 'Ground Sale', 'Online Sale', 'HR & Admin '
        ];
        $types = ['တိုင်ကြားစာ', 'အကြံပြုစာ'];

        $statuses = ['request', 'published', 'suspend', 'well-noted'];
    }
}
