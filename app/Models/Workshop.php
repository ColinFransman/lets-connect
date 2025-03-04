<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Workshop extends Model
{
    public $guarded = [];

    public static  function  all($columns ="*")
    {
        $workshops = DB::table('workshops')->get();
        
        return json_encode($workshops);
    }
}
