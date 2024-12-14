<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    protected $guarded = [];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_term', 'party_id', 'member_id')
            ->withPivot('term_number')
            ->withTimestamps();
    }
}
