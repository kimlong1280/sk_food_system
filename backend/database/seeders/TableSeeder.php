<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['table_number' => '01', 'name' => 'Table 01 ', 'status' => 'active'],
            ['table_number' => '02', 'name' => 'Table 02 ', 'status' => 'active'],
            ['table_number' => '03', 'name' => 'Table 03 ', 'status' => 'active'],
            ['table_number' => '04', 'name' => 'Table 04 ', 'status' => 'active'],
            ['table_number' => '05', 'name' => 'Table 05 ', 'status' => 'active'],
            ['table_number' => '06', 'name' => 'Table 06 ', 'status' => 'active'],
            ['table_number' => '07', 'name' => 'Table 07 ', 'status' => 'active'],
            ['table_number' => '08', 'name' => 'Table 08 ', 'status' => 'active'],
        ];

        foreach ($tables as $table) {
            Table::updateOrCreate(
                ['table_number' => $table['table_number']],
                $table
            );
        }
    }
}
