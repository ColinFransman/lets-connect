<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Workshop;

class WorkshopMoment extends Model
{
    public $guarded = [
        'id'
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Bookings::class, 'wm_id');
    }

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, "workshop_id");
    }

    public function moment()
    {
        return $this->belongsTo(Moment::class, "moment_id");
    }
}
