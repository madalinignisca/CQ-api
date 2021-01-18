<?php
namespace App\Http\Controllers;

use App\Jobs\ProcessPhotoResizing;
use App\Jobs\ProcessPhotoStoring;
use App\Jobs\ProcessPhotoStoringInDatabase;
use App\Jobs\ProcessPhotoStoringInStorage;
use App\Photo;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Boolean;

class PixabayController extends Controller {


    public static function photos(Request $request)
    {
        $params = [];

        if($request->expectsJson()) {
            $params = [
              'q' => $request->queryParams['q'] ?? '',
              'image_type' => $request->queryParams['image_type'] ?? '',
              'category' => $request->queryParams['category'] ?? '',
            ];
        }

       return response()->json(json_decode(\Pixabay::get($params)));
    }

    public function save(Request $request)
    {
       ProcessPhotoStoring::dispatch((int)$request->image_id);

    }

    public function savePhoto()
    {


        /**
         * 0. create storage for photos, and for photos with smaller sizes
         * 1. store photo in storage
         * 2. make smaller version of it
         * 3. save the photo in db
         */

    }

}
