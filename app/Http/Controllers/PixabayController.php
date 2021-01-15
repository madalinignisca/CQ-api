<?php
namespace App\Http\Controllers;

use App\Photo;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Cache;
use phpDocumentor\Reflection\Types\Boolean;

class PixabayController extends Controller {


    public static function photos(Bool $isSaved = false)
    {
        $params = [
            'q'=> 'maria',
            'image_type' => 'photo',
            'pretty'=>'true'
        ];

         $pixabay_photos = \Pixabay::get($params);

          return response()->json(json_decode($pixabay_photos));
//
         // if is saved is true, then we need to retreave photos from db table photos

        // check if the photos exist in cache,
        // if so then retrive them from cache
        // if no get them from API


    }

    public function photo(Photo $photo)
    {

    }


    public function savePhoto(Photo $photo )
    {
        /**
         * 0. create storage for photos, and for photos with smaller sizes
         * 1. store photo in storage
         * 2. make smaller version of it
         * 3. save the photo in db
         */

    }

}
