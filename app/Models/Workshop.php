<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Workshop extends Model
{
    public $guarded = [];

    public function workshopMoments(): HasMany
    {
        return $this->hasMany(WorkshopMoment::class);
    }

    public static  function  all($columns ="*")
    {
        $workshops = DB::table('workshops')->get();
        
        return json_encode($workshops);
    }
}