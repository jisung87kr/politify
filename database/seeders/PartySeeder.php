<?php

namespace Database\Seeders;

use App\Models\Party;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parties = [
            ['party_code' => "101182", 'name' => '더불어민주당'],
            ['party_code' => "101210", 'name' => '국민의힘'],
            ['party_code' => "101218", 'name' => '조국혁신당'],
            ['party_code' => "101213", 'name' => '개혁신당'],
            ['party_code' => "101211", 'name' => '진보당'],
            ['party_code' => "101208", 'name' => '기본소득당'],
            ['party_code' => "101221", 'name' => '사회민주당'],
            ['party_code' => "101030", 'name' => '무소속'],
        ];
        foreach ($parties as $index => $party) {
            Party::create($party);
        }
    }
}
