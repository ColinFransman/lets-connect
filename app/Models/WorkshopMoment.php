<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class WorkshopMoment extends Model
{
    public $guarded = [
        'id'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Bookings::class);
    }

    public function workshops(): HasOne
    {
        return $this->hasOne(Workshop::class);
    }

    public function moments(): HasOne
    {
        return $this->hasOne(Moment::class);
    }
}
