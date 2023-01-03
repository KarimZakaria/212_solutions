<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'name' => 'company 1',
            'email' => 'newEmp@gmail.com',
            'password' => Hash::make('123456'),
            'company_id' => '1',
            'image' => '1.png'
        ]);

        Employee::create([
            'name' => 'Emp 2',
            'email' => 'newEmp2@gmail.com',
            'password' => Hash::make('123456'),
            'company_id' => '3',
            'image' => '2.png'
        ]);

        Employee::create([
            'name' => 'Emp 3',
            'email' => 'newEmp3@gmail.com',
            'password' => Hash::make('123456'),
            'company_id' => '2',
            'image' => '3.png'
        ]);
    }
}
