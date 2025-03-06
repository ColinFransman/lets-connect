<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bookings extends Model
{
    public $guarded = [
        'id'
    ];

    public function users(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function workshopMoments(): HasOne
    {
        return $this->hasOne(WorkshopMoment::class);
    }
}
