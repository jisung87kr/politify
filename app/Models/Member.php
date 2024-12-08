<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
