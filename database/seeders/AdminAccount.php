<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Department;
use App\Models\Staff;
use App\Models\StaffInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $dep = Department::factory()->create();
        $newStaff = Staff::create(['name' => 'admin', 'department_id' => $dep->id, 'position' => 'headquater']);

        StaffInfo::factory()->create([
            'date_of_birth' => "1999-02-03",
            'gender' => 'male',
            'address' => 'codestar',
            'phone' => '0912345678',
            'staff_id' => $newStaff->id,
        ]);

        Account::create([
            'email' => 'admin@codestar.vn',
            'password' => Hash::make("12345678"),
            'staff_id' => $newStaff->id,
            'is_admin' => 1,
            'active' => 1
        ]);
    }
}
