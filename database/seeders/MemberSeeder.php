<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Services\OpenApiAssemblyService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
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
        $result = $this->openApiAssemblyService->getAllMembers();
        foreach ($result as $index => $item) {
            $members = $item->ALLNAMEMBER[1]->row;
            collect($members)->each(function ($member) {
                Member::updateOrCreate(
                    [
                        'member_code' => $member->NAAS_CD, // 조건 (unique key 역할)
                    ],
                    [
                        'name_kr' => $member->NAAS_NM,
                        'name_ch' => $member->NAAS_CH_NM,
                        'name_en' => $member->NAAS_EN_NM,
                        'birth_type' => $member->BIRDY_DIV_CD,
                        'birth_date' => date('Y-m-d', strtotime($member->BIRDY_DT)),
                        'position' => $member->DTY_NM,
                        'party_name' => $member->PLPT_NM,
                        'district_name' => $member->ELECD_NM,
                        'district_type' => $member->ELECD_DIV_NM,
                        'committee_name' => $member->CMIT_NM,
                        'affiliated_committee' => $member->BLNG_CMIT_NM,
                        'reelection_status' => $member->RLCT_DIV_NM,
                        'term_number' => $member->GTELT_ERACO,
                        'gender' => $member->NTR_DIV,
                        'phone_number' => $member->NAAS_TEL_NO,
                        'email' => $member->NAAS_EMAIL_ADDR,
                        'homepage_url' => $member->NAAS_HP_URL,
                        'aides' => $member->AIDE_NM,
                        'chief_secretaries' => $member->CHF_SCRT_NM,
                        'secretaries' => $member->SCRT_NM,
                        'brief_history' => $member->BRF_HST,
                        'office_room' => $member->OFFM_RNUM_NO,
                        'photo_url' => $member->NAAS_PIC,
                    ]
                );
            });
        }
    }
}
