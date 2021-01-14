<?php
namespace App\Http\Services;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class PixabayService
{
   private $client;
   private $api_url = null;
   private $params;

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
       $this->api_url ?? $this->api_url = env('PIXABAY_API', null);
   }

   public function get(array $params = [])
   {
       $response = $this->client->get($this->api_url, [
           'query' => array_merge( $this->params, $params)
       ]);

       return $response->getBody();
   }
}

