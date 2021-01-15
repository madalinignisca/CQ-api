<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CachedRequest extends Model
{
    use Notifiable;
    protected $guarded;

    public static function boot()
    {
        parent::boot();

        $expired_items = CachedRequest::cursor()->filter(function ($cachedRequest) {
            return Carbon::now()->greaterThanOrEqualTo($cachedRequest->expires_at);
        });

        collect($expired_items)->map(function ($item) {
            $item->delete();
        });

    }

}
