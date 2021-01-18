<?php

namespace App\Jobs;

use App\Photo;
use GuzzleHttp\Psr7\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Image;
class ProcessPhotoResizing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $image_name;
    private $image_extension;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image_name, $image_extension)
    {
        $this->image_name = $image_name;
        $this->image_extension = $image_extension;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Photo $photo)
    {
        $name = 'thump_'.$this->image_name;
        $resized_image = Image::make(Storage::disk(env('PIXABAY_STORAGE_DRIVER'))
            ->get($this->image_name))
            ->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($this->image_extension);

            Storage::disk(env('PIXABAY_STORAGE_DRIVER'))
                ->put($name, $resized_image->__toString());

    }
}
