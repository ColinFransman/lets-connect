<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bookings extends Model
{
    public $guarded = [
        'id'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, "student_id");
    }

    public function workshopMoments()
    {
        return $this->belongsTo(WorkshopMoment::class, "wm_id");
    }
}
