<?php
namespace App\Http\Controllers;

use App\Http\Resources\PhotoCollection;
use App\Http\Resources\Pixabay;
use App\Http\Resources\PixabayCollection;
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
use phpDocumentor\Reflection\Types\Collection;
use function Psy\debug;

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
        $decoded_response = collect(json_decode(\Pixabay::get($params)));


        $wrapped_response = collect($decoded_response['hits'])->map(function ($value, $key) {
           return new Pixabay($value);
        });


       return response()->json(
           [
               'data'=>$wrapped_response,
               'expires_at' => \Pixabay::expiresIn()
           ]
           );
    }

    public function save(Request $request)
    {
        try {
            ProcessPhotoStoring::dispatch((int)$request->image_id);
        } catch ( \Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'success' => false]);
        }
        return response()->json(['message' => 'Your request is processing.', 'success' => true]);
    }

    public function saved()
    {
        try {
           return new PhotoCollection(Photo::all());

        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'success' => false]);
        }
    }



}
