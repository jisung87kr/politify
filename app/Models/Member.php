<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $guarded = [];

    public function party()
    {
        return $this->belongsTo(Party::class);
    }

    public function terms()
    {
        return $this->belongsToMany(Term::class, 'member_term')
            ->withPivot('district_id', 'party_id', 'start_date', 'end_date')
            ->using(MemberTerm::class);
    }
}
