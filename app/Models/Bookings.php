<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    public $guarded = [];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function workshopMoment()
    {
        return $this->belongsTo(workshopMoment::class, 'wm_id');
    }


}
