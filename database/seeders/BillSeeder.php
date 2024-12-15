<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Member;
use App\Models\Term;
use App\Services\OpenApiAssemblyService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
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
        $ageRange = range(10, 22);
        foreach ($ageRange as $key => $age) {
            $pdAge = str_pad($age, 2, '0', STR_PAD_LEFT);
            $bills = $this->openApiAssemblyService->getAllBills($age);
            $termCode = "1000".$pdAge;
            $term = Term::where('term_code', $termCode)->first();
            foreach ($bills as $page => $bill) {
                foreach ($bill->nzmimeepazxkubdpn[1]->row as $index => $item) {
                    $billData = Bill::updateOrCreate(
                        [
                            'bill_code' => $item->BILL_ID,
                        ],
                        [
                            'bill_number' => $item->BILL_NO ?? null,
                            'bill_name' => $item->BILL_NAME ?? null,
                            'committee_name' => $item->COMMITTEE ?? null,
                            'proposed_date' => $item->PROPOSE_DT ? str_replace(' ', '', $item->PROPOSE_DT) : null,
                            'process_result' => $item->PROC_RESULT ?? null,
                            'assembly_age' => $item->AGE ?? null,
                            'term_id' => $term->id,
                            'detail_link' => $item->DETAIL_LINK ?? null,
                            'main_proposer' => $item->PROPOSER ?? null,
                            'member_list_link' => $item->MEMBER_LIST ?? null,
                            'law_processed_date' => $item->LAW_PROC_DT ? str_replace(' ', '', $item->LAW_PROC_DT) : null,
                            'law_presented_date' => $item->LAW_PRESENT_DT ? str_replace(' ', '', $item->LAW_PRESENT_DT) : null,
                            'law_submitted_date' => $item->LAW_SUBMIT_DT ? str_replace(' ', '', $item->LAW_SUBMIT_DT) : null,
                            'committee_result_code' => $item->CMT_PROC_RESULT_CD ?? null,
                            'committee_processed_date' => $item->CMT_PROC_DT ? str_replace(' ', '', $item->CMT_PROC_DT) : null,
                            'committee_presented_date' => $item->CMT_PRESENT_DT ? str_replace(' ', '', $item->CMT_PRESENT_DT) : null,
                            'committee_date' => $item->COMMITTEE_DT ? str_replace(' ', '', $item->COMMITTEE_DT) : null,
                            'processed_date' => $item->PROC_DT ? str_replace(' ', '', $item->PROC_DT) : null,
                            'committee_id' => $item->COMMITTEE_ID ?? null,
                            'public_proposers' => $item->PUBL_PROPOSER ?? null,
                            'law_result_code' => $item->LAW_PROC_RESULT_CD ?? null,
                            'representative_proposer' => $item->RST_PROPOSER ?? null,
                        ]
                    );

                    $termMember = Member::whereIn('name_kr', $billData->representative_members)
                        ->whereHas('terms', function ($query) use ($term) {
                            return $query->where('term_id', $term->id);
                        })->get();

                    foreach ($termMember as $member) {
                        $billData->members()->syncWithoutDetaching([
                            $member->id => ['proposer_type' => 'representative']
                        ]);
                    }

                    $termMember = Member::whereIn('name_kr', $billData->public_members)
                        ->whereHas('terms', function ($query) use ($term) {
                            return $query->where('term_id', $term->id);
                        })->get();

                    foreach ($termMember as $member) {
                        $billData->members()->syncWithoutDetaching([
                            $member->id => ['proposer_type' => 'public']
                        ]);
                    }
                }
            }
        }
    }
}
