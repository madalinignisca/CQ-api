<?php

namespace App\Jobs;

use App\Photo;
use App\Size;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPhotoStoringInDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $image_name;
    private $cached_key_name;
    private $cache_expiration_date;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image_name, $cached_key_name)
    {
        $this->image_name = $image_name;
        $this->cached_key_name = $cached_key_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $date_now = Carbon::now()->toDateTimeString();
        $photo =  Photo::firstOrCreate([
            'name' =>  $this->cached_key_name,
            'path' => $this->image_name,
            'updated_at' => $date_now,
            'created_at' => $date_now,

        ]);

        $photo->sizes()->attach(Size::whereSize('large')->first());
    }
}
