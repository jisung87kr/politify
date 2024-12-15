<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $guarded = [];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_bill');
    }

    public function representativeMembers(): Attribute
    {
        return Attribute::make(get: function () {
            $list = explode(',', $this->representative_proposer);
            $list = array_map(function ($name) {
                return trim($name);
            }, $list);
            return $list;
        });
    }

    public function publicMembers(): Attribute
    {
        return Attribute::make(get: function () {
            $list = explode(',', $this->public_proposers);
            $list = array_map(function ($name) {
                return trim($name);
            }, $list);
            return $list;
        });
    }
}
