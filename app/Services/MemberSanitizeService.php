<?php
namespace App\Services;
use App\Models\Committee;
use App\Models\District;
use App\Models\Member;
use App\Models\Party;
use App\Models\Term;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberSanitizeService{

    function insertTerms()
    {
        try {
            DB::beginTransaction();
            Member::all()->each(function($member){
                $arrayTerms = array_map(function($item){
                    return $item ? trim($item) : null;
                }, explode(',', $member->term_number));

                $arrayParties = array_map(function($item){
                    return $item ? trim($item) : null;
                }, explode('/', $member->party_name));

                $arrayDistricts = array_map(function($item){
                    return $item ? trim($item) : null;
                }, explode('/', $member->district_name));

                $arrayDistrictTypes = array_map(function($item){
                    return $item ? trim($item) : null;
                }, explode('/', $member->district_type));

                $arrayCommittee = array_map(function($item){
                    return $item ? trim($item) : null;
                }, explode(',', $member->committee_name));

                $arrayAffiliatedCommittee = array_map(function($item){
                    return $item ? trim($item) : null;
                }, explode(',', $member->affiliated_committee));

                foreach ($arrayTerms as $index => $arrayTerm) {
                    if(!$arrayTerm){
                        Log::error($member->id . '번 의원의 대수가 없습니다.');
                        continue;
                    }
                    $term = Term::firstOrCreate(['name' => $arrayTerm]);
                    $party = isset($arrayParties[$index]) ? Party::firstOrCreate(['name' => $arrayParties[$index]]) : null;
                    $district = isset($arrayDistricts[$index]) ? District::firstOrCreate(['name' => $arrayDistricts[$index]]) : null;

                    $member->terms()->syncWithoutDetaching(
                        [
                            $term->id => [
                                'party_id' => $party->id ?? null,
                                'district_id' => $district->id ?? null,
                                'district_type' => $arrayDistrictTypes[$index] ?? null,
                            ]
                        ]
                    );
                }

                foreach ($arrayCommittee as $index => $item) {
                    if($item){
                        $committee  = Committee::firstOrCreate(['name' => $item]);
                        $member->committees()->syncWithoutDetaching($committee->id);
                    }
                }

                foreach ($arrayAffiliatedCommittee as $index => $item) {
                    if($item){
                        $committee  = Committee::firstOrCreate(['name' => $item]);
                        $member->committees()->syncWithoutDetaching($committee->id);
                    }
                }
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }

    function insertCommittees()
    {

    }

    function setParties()
    {

    }

    function setTerms()
    {

    }


}
