<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Size extends Model
{
    use Notifiable;

    protected $guarded;

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }


}
