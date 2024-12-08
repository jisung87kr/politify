<?php

namespace Database\Seeders;

use App\Models\Region;
use App\Services\OpenApiAssemblyService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    private $openApiAssemblyService;

    public function __construct(OpenApiAssemblyService $openApiAssemblyService)
    {
        $this->openApiAssemblyService = $openApiAssemblyService;
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regions = [
            ['region_code' => '021001', 'name'=> '서울'],
            ['region_code' => '021002', 'name'=> '부산'],
            ['region_code' => '021003', 'name'=> '대구'],
            ['region_code' => '021004', 'name'=> '인천'],
            ['region_code' => '021005', 'name'=> '광주'],
            ['region_code' => '021006', 'name'=> '대전'],
            ['region_code' => '021007', 'name'=> '울산'],
            ['region_code' => '021008', 'name'=> '경기'],
            ['region_code' => '021009', 'name'=> '강원'],
            ['region_code' => '021010', 'name'=> '충북'],
            ['region_code' => '021011', 'name'=> '충남'],
            ['region_code' => '021012', 'name'=> '전북'],
            ['region_code' => '021013', 'name'=> '전남'],
            ['region_code' => '021014', 'name'=> '경북'],
            ['region_code' => '021015', 'name'=> '경남'],
            ['region_code' => '021016', 'name'=> '제주'],
            ['region_code' => '021168', 'name'=> '세종'],
        ];

        foreach ($regions as $index => $region) {
            $region = Region::create($region);
            $districts = $this->openApiAssemblyService->crawlDistricts($region);
            foreach ($districts->thxCode as $index => $item) {
                $region->districts()->create([
                    'district_code' => $item->comCd,
                    'name' => $item->comNm
                ]);
            }
        }
    }
}
