<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPhotoStoring implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $image_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image_id)
    {
        $this->image_id = $image_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = \Pixabay::get(['id' => (int)$this->image_id]);
        $cached_key_name = \Pixabay::getCachingKeyName();

        $photo_data = json_decode($response)->hits;
        $image_url = $photo_data[0]->largeImageURL;
        $image_name = basename($image_url);
        $extension = pathinfo($image_url)['extension'];

        ProcessPhotoStoringInStorage::withChain([
            new ProcessPhotoStoringInDatabase($image_name, $cached_key_name),
            new ProcessPhotoResizing($image_name, $extension)
        ])->dispatch($image_url, $image_name);
    }
}
