<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $areas = [
            [
                'name' => '北海道',
            ],
            [
                'name' => '青森',
            ],
            [
                'name' => '岩手',
            ],
            [
                'name' => '宮城',
            ],
            [
                'name' => '秋田',
            ],
            [
                'name' => '山形',
            ],
            [
                'name' => '福島',
            ],
            [
                'name' => '茨城',
            ],
            [
                'name' => '栃木',
            ],
            [
                'name' => '群馬',
            ],
            [
                'name' => '埼玉',
            ],
            [
                'name' => '千葉',
            ],
            [
                'name' => '東京',
            ],
            [
                'name' => '神奈川',
            ],
            [
                'name' => '新潟',
            ],
            [
                'name' => '富山',
            ],
            [
                'name' => '石川',
            ],
            [
                'name' => '福井',
            ],
            [
                'name' => '山梨',
            ],
            [
                'name' => '長野',
            ],
            [
                'name' => '岐阜',
            ],
            [
                'name' => '静岡',
            ],
            [
                'name' => '愛知',
            ],
            [
                'name' => '三重',
            ],
            [
                'name' => '滋賀',
            ],
            [
                'name' => '京都',
            ],
            [
                'name' => '大阪',
            ],
            [
                'name' => '兵庫',
            ],
            [
                'name' => '奈良',
            ],
            [
                'name' => '和歌山',
            ],
            [
                'name' => '鳥取',
            ],
            [
                'name' => '島根',
            ],
            [
                'name' => '岡山',
            ],
            [
                'name' => '広島',
            ],
            [
                'name' => '山口',
            ],
            [
                'name' => '徳島',
            ],
            [
                'name' => '香川',
            ],
            [
                'name' => '愛媛',
            ],
            [
                'name' => '高知',
            ],
            [
                'name' => '福岡',
            ],
            [
                'name' => '佐賀',
            ],
            [
                'name' => '長崎',
            ],
            [
                'name' => '熊本',
            ],
            [
                'name' => '大分',
            ],
            [
                'name' => '宮崎',
            ],
            [
                'name' => '鹿児島',
            ],
            [
                'name' => '沖縄',
            ],
        ];

        foreach ($areas as $area) {
            DB::table('areas')->insert([
                'name' => $area
            ]);
        }
    }
}
