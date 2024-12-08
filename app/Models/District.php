<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $guarded = [];

    public function members()
    {
        return $this->hasManyThrough(Member::class, MemberTerm::class);
    }
}
