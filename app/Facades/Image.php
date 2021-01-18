<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Http\Services\ResizeImageService;

class Image extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ResizeImageService::class;
    }
}
