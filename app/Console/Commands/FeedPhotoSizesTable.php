<?php

namespace App\Console\Commands;

use App\Size;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class FeedPhotoSizesTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed:sizes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date =  Carbon::now()->toDateTimeString();

        Size::create(array('name' => 'Small', 'size' => 'small', 'updated_at' => $date, 'created_at' => $date));
        Size::create(array('name' => 'Large', 'size' => 'large', 'updated_at' => $date, 'created_at' => $date));

    }
}
