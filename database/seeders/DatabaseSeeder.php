<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AudienceLevel;
use App\Models\Department;
use App\Models\NotificationType;
use App\Models\Role;
use App\Models\Status;
use App\Models\Type;
use App\Models\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Pi',
            'email' => 'pos@nexgen.com',
        ]);



        $audience_levels = ['HR', 'Public'];
        $departments = [
            'Shwetatar Co.,Ltd', 'Leadership', 'Digital Marketing', 'Finance & Accounting',
            'GM Office', 'Ground Sale', 'Online Sale', 'HR & Admin '
        ];
        $types = ['တိုင်ကြားစာ', 'အကြံပြုစာ'];

        $statuses = ['request', 'well-noted', 'published', 'suspend',];

        $roles = ['Admin', 'HR', 'Leadership', 'Staff', 'Guest',];

        $noti_types = ['Create Post', 'Update Post', 'Delete Post', 'Love', 'Vote'];

        foreach ($noti_types as $noti) {
            NotificationType::factory()->create([
                'name' => $noti
            ]);
        }
        foreach ($audience_levels as $level) {
            AudienceLevel::factory()->create([
                'name' => $level
            ]);
        }
        foreach ($departments as $dep) {
            Department::factory()->create([
                'name' => $dep
            ]);
        }
        foreach ($types as $type) {
            Type::factory()->create([
                'name' => $type
            ]);
        }
        foreach ($statuses as $status) {
            Status::factory()->create([
                'name' => $status
            ]);
        }
        foreach ($roles as $role) {
            Role::factory()->create([
                'name' => $role
            ]);
        }

        UserRole::factory()->create([
            'user_id' => 1,
            'role_id' => 1,
        ]);
    }
}
