<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1) Insert / update data pada tabel 'criterias'
        $criterias = [
            [
                'name'       => 'HP',
                'type'       => 'benefit',
                'input_type' => 'number',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Attack',
                'type'       => 'benefit',
                'input_type' => 'number',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => 'Skill Cost',
                'type'       => 'cost',
                'input_type' => 'options',
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Upsert agar aman jika seed dijalankan berulang (unik per name)
        DB::table('criterias')->upsert(
            $criterias,
            ['name'],
            ['type', 'input_type', 'is_active', 'updated_at']
        );

        // Ambil ID untuk 'Skill Cost'
        $skillCostId = DB::table('criterias')->where('name', 'Skill Cost')->value('id');

        // Pastikan ID ditemukan sebelum melanjutkan
        if (!$skillCostId) {
            return;
        }

        // 2) Insert / update data pada tabel 'criteria_options' untuk 'Skill Cost'
        $options = [
            [
                'criteria_id' => $skillCostId,
                'option_text' => 'No Skill Cost',
                'option_value'=> 0.00,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'criteria_id' => $skillCostId,
                'option_text' => 'Mana',
                'option_value'=> 4.00,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'criteria_id' => $skillCostId,
                'option_text' => 'Energy',
                'option_value'=> 7.00,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        // Kombinasikan kunci unik per (criteria_id, option_text)
        DB::table('criteria_options')->upsert(
            $options,
            ['criteria_id', 'option_text'],
            ['option_value', 'updated_at']
        );
    }
}
