<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkshopMoment extends Model
{
    public $guarded = [];

    public function workshop()
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }
    public function moment()
    {
        return $this->belongsTo(Moment::class, 'moment_id');
    }   
    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'wm_id');
    }
}
