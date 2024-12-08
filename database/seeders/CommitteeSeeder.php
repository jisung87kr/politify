<?php

namespace Database\Seeders;

use App\Models\Committee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommitteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $committees = [
            ['committee_code' => '9700005', 'name' => '국회운영위원회'],
            ['committee_code' => '9700006', 'name' => '법제사법위원회'],
            ['committee_code' => '9700008', 'name' => '정무위원회'],
            ['committee_code' => '9700300', 'name' => '기획재정위원회'],
            ['committee_code' => '9700512', 'name' => '교육위원회'],
            ['committee_code' => '9700479', 'name' => '과학기술정보방송통신위원회'],
            ['committee_code' => '9700409', 'name' => '외교통일위원회'],
            ['committee_code' => '9700019', 'name' => '국방위원회'],
            ['committee_code' => '9700480', 'name' => '행정안전위원회'],
            ['committee_code' => '9700513', 'name' => '문화체육관광위원회'],
            ['committee_code' => '9700408', 'name' => '농림축산식품해양수산위원회'],
            ['committee_code' => '9700481', 'name' => '산업통상자원중소벤처기업위원회'],
            ['committee_code' => '9700341', 'name' => '보건복지위원회'],
            ['committee_code' => '9700038', 'name' => '환경노동위원회'],
            ['committee_code' => '9700407', 'name' => '국토교통위원회'],
            ['committee_code' => '9700047', 'name' => '정보위원회'],
            ['committee_code' => '9700342', 'name' => '여성가족위원회'],
            ['committee_code' => '9700049', 'name' => '예산결산특별위원회'],
        ];

        foreach ($committees as $index => $committee) {
            Committee::create($committee);
        }
    }
}
