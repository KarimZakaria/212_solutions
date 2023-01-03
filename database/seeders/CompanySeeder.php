<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'company 1',
            'adress' => 'new cairo',
            'logo' => '1.png'
        ]);

        Company::create([
            'name' => 'company 2',
            'adress' => 'Giza',
            'logo' => '2.png'
        ]);

        Company::create([
            'name' => 'company 3',
            'adress' => 'nasr city',
            'logo' => '3.png'
        ]);
    }
}
