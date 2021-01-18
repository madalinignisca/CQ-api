<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessPhotoStoringInStorage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $image_name;
    private $image_url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image_url, $image_name)
    {
        $this->image_url = $image_url;
        $this->image_name = $image_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $content = file_get_contents($this->image_url);

        if ( !Storage::disk(env('PIXABAY_STORAGE_DRIVER'))->exists($this->image_name)) {
            Storage::disk(env('PIXABAY_STORAGE_DRIVER'))->put($this->image_name, $content);
        }
    }
}
