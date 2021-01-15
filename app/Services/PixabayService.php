<?php
namespace App\Http\Services;
use App\CachedRequest;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class PixabayService
{
   private $client;
   private $api_url = null;
   private $params;
   private $ttl = 86400;

   public function __construct()
   {
     $this->configClient();
     $this->params = ['key' => env('PIXABAY_API_KEY', null)];
   }

   function configClient()
   {
       if(!$this->client instanceof Client) {
          $this->client = new Client();
       }
       $this->api_url ?? $this->api_url = env('PIXABAY_API');
   }

   public function get(array $params = [])
   {
      $get_with_params = array_merge( $this->params, $params);
      $caching_key_name = $this->generateCachingKeyFromParams($get_with_params);

       try {
           $this->saveCachingKey($caching_key_name);

           return Cache::remember($caching_key_name, $this->ttl, function () use($get_with_params) {
               $response = $this->client->get($this->api_url, [
                   'query' => $get_with_params
               ]);
               return $response->getBody()->getContents();
           });

       } catch (\Exception $exception) {
           return $exception->getMessage();
       }
   }

   private function saveCachingKey(string $key)
   {
       $expires_at = Carbon::now()->addSeconds($this->ttl)->toDateTimeString();

       return CachedRequest::firstOrCreate( [ 'cached_key' => $key], [
           'cached_key' => $key,
           'expires_at' => $expires_at
       ]);
   }
   private function generateCachingKeyFromParams(array $params): string
   {
       return serialize($params);
   }
}

