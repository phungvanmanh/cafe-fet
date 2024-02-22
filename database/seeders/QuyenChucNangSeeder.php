<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuyenChucNangSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('quyen_chuc_nangs')->delete();
        DB::table('quyen_chuc_nangs')->truncate();
        for ($i=1; $i < 41; $i++) {
            DB::table('quyen_chuc_nangs')->insert([
                [
                    'id_quyen'      => 1,
                    'id_chuc_nang'  => $i,
                ]
            ]);
        }
    }
}
