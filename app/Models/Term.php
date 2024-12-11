<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $guarded = [];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_term')
            ->withPivot('district_id', 'party_id', 'district_id', 'district_type')->withTimestamps();
    }

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
