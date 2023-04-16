<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    protected $locality;
    protected $id;

//    protected $fillable = [
//        'name'
//    ];

    protected $table = 'locations';
    public $timestamps = false;



    public static function isLocality()
    {
        if (session('locality')) {
            return Locality::where('id', session('locality'))->value('locality');
        }
        return null;
    }



}
