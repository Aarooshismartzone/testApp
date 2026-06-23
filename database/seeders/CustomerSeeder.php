<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'شركة الخليج',
            'email' => 'info@gulf.com',
            'phone' => '+96511111111'
        ]);

        Customer::create([
            'name' => 'شركة الكويت',
            'email' => 'info@kuwait.com',
            'phone' => '+96522222222'
        ]);

        Customer::create([
            'name' => 'شركة المستقبل',
            'email' => 'info@future.com',
            'phone' => '+96533333333'
        ]);
    }
}
