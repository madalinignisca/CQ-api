<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;

class Photo extends Model
{
    use Notifiable;

    protected $guarded;

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public static function fetchALl()
    {
        return Cache::remember('saved_photos', 60*60, function () {
            return self::all();
        });
    }



}
