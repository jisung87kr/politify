<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $guarded = [];

    public function child()
    {
        return $this->hasMany(Region::class, 'parent_id', 'id');
    }

    public function districts()
    {
        return $this->hasMany(District::class, 'region_id', 'id');
    }
}
