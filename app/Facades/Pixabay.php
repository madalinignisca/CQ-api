<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Services\PixabayService;

class Pixabay extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PixabayService::class;
    }
}
