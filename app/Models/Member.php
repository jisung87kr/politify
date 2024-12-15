<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;

class Member extends Model
{
    protected $guarded = [];
    protected $appends = ['last_party', 'last_committee', 'last_district', 'last_district_type', 'last_term_number', 'assembly_url', 'bill_url', 'party_color', 'emails', 'last_end', 'thumb_url'];



    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function terms()
    {
        return $this->belongsToMany(Term::class, 'member_term')
            ->withPivot('district_id', 'party_id', 'district_id', 'district_type')->withTimestamps();
    }

    public function committees()
    {
        return $this->belongsToMany(Committee::class, 'member_committee')
            ->withTimestamps();
    }

    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'member_bill')->orderBy('committee_date', 'desc');
    }

    public function representativeBills()
    {
        return $this->belongsToMany(Bill::class, 'member_bill')
            ->withPivot('proposer_type')
            ->wherePivot('proposer_type', 'representative')
            ->orderBy('committee_date', 'desc');
    }

    public function lastParty(): Attribute
    {
        return Attribute::make(get: function(){
            $data = explode('/', $this->party_name);
            return array_pop($data);
        });
    }

    public function lastCommittee(): Attribute
    {
        return Attribute::make(get: function(){
            $data = explode(',', $this->committee_name);
            return array_pop($data);
        });
    }

    public function lastDistrict(): Attribute
    {
        return Attribute::make(get: function(){
            $data = explode('/', $this->district_name);
            return array_pop($data);
        });
    }

    public function lastDistrictType(): Attribute
    {
        return Attribute::make(get: function(){
            $data = explode(',', $this->district_type);
            return array_pop($data);
        });
    }

    public function lastTermNumber(): Attribute
    {
        return Attribute::make(get: function(){
            $data = explode(',', $this->term_number);
            return array_pop($data);
        });
    }

    public function nameId(): Attribute
    {
        return Attribute::make(get: function(){
            return str_replace(' ', '', $this->name_en);
        });
    }

    public function assemblyUrl(): Attribute
    {
        return Attribute::make(get: function(){
            $th = $this->getTermNumbers($this->lastTermNumber);
            $lastEnd = array_pop($th);
            $url = "https://www.assembly.go.kr/members/{$lastEnd}st/{$this->nameId}";
            return $url;
        });
    }

    public function lastEnd(): Attribute
    {
        return Attribute::make(get: function(){
            $th = $this->getTermNumbers($this->lastTermNumber);
            $lastEnd = array_pop($th);
            return $lastEnd;
        });
    }

    public function emails(): Attribute
    {
        return Attribute::make(get: function(){
            return explode(',', $this->email);
        });
    }

    public function phoneNumbers(): Attribute
    {
        return Attribute::make(
            get: function () {
                // 전화번호 문자열
                $phoneNumber = explode('/', $this->phone_number); // e.g., "02-784-2844~6"
                $phoneNumber = $phoneNumber[0];
                $phoneNumber = explode(',', $phoneNumber); // 공백 제거
                $phoneNumber = $phoneNumber[0];

                // 패턴으로 범위를 추출
                if (preg_match('/(\d{2,4}-\d{3,4}-)(\d+)\~(\d+)/', $phoneNumber, $matches)) {
                    $prefix = $matches[1];       // "02-784-"
                    $startNumber = (int)$matches[2]; // 시작 번호 (2844)
                    $endNumberSuffix = (int)$matches[3];   // 끝 번호의 마지막 자리 (6)

                    // 끝 번호 보정
                    $startNumberLength = strlen((string)$startNumber);
                    $endNumberLength = strlen((string)$endNumberSuffix);

                    // 끝 번호의 자릿수 맞추기
                    if ($endNumberLength < $startNumberLength) {
                        $endNumber = (int)(substr((string)$startNumber, 0, $startNumberLength - $endNumberLength) . $endNumberSuffix);
                    } else {
                        $endNumber = $endNumberSuffix;
                    }

                    // 범위 처리
                    $phoneNumbers = [];
                    for ($i = $startNumber; $i <= $endNumber; $i++) {
                        $phoneNumbers[] = "{$prefix}{$i}";
                    }

                    return $phoneNumbers;
                }

                // 범위가 없으면 기본 값 반환
                return [$phoneNumber];
            }
        );
    }

    public function partyColor(): Attribute
    {
        return Attribute::make(get: function(){
            switch ($this->last_party){
                case '더불어민주당':
                    $color = '#60a5fa';
                    break;
                case '국민의힘':
                    $color = '#fb7185';
                    break;
                default:
                    $color = '#94a3b8';
                    break;
            }

            return $color;
        });
    }

    public function getTermNumbers($termNumber)
    {
        $pattern = '/\d+/'; // 숫자만 매칭하는 정규식
        preg_match_all($pattern, $termNumber, $matches);
        $numbers = $matches[0];
        return $numbers;
    }

    public function billUrl() : Attribute
    {
        return Attribute::make(get: function(){
            $th = $this->getTermNumbers($this->lastTermNumber);
            $lastEnd = array_pop($th);
            $url = "https://www.assembly.go.kr/portal/assm/assmPrpl/prplMst.do?monaCd={$this->member_code}&st={$lastEnd}&viewType=CONTBODY&tabId=repbill";
            return $url;
        });
    }

    public function age(): Attribute
    {
        return Attribute::make(get: function(){
//            $birth = $this->birth_date;
//            $birthYear = substr($birth, 0, 4);
//            $now = date('Y');
//            $age = $now - $birthYear + 1;
//            return $age;

            // 만나이
            $birth = $this->birth_date;
            $birthDate = new \DateTime($birth); // 생년월일
            $today = new \DateTime(); // 현재 날짜
            $age = $today->diff($birthDate)->y; // 날짜 차이 계산 후 년도만 가져옴
            return $age;
        });
    }

    public function thumbUrl(): Attribute
    {
        return Attribute::make(get: function(){
            $url = str_replace('https://www.assembly.go.kr/static/portal/img/openassm/new/', 'https://www.assembly.go.kr/static/portal/img/openassm/new/thumb/', $this->photo_url);
            return $url;
        });
    }


    public function scopeFilter(Builder $query, $filters)
    {
        $query->when($filters['name'] ?? null, function ($query, $name) {
            $query->where('name_kr', 'like', '%' . $name . '%');
        });

        $query->when($filters['party_name'] ?? null, function ($query, $name) {
            $query->where('party_name', 'like', '%' . $name . '%');
        });
    }
}
