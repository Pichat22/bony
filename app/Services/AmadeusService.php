<?php
namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
class AmadeusService
{protected $client;
    public function __construct(){
 $this->client=new Client([
    'base_uri'=>config('services.amadeus.base.url'),
    'timeout'=>10.0,
    'verify'=>false
 ]);

    }
    public function getAccessToken(){
        $response = $this->client->post('/v1/security/oauth2/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => config('services.amadeus.key'),
                'client_secret' => config('services.amadeus.secret'),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['access_token'] ?? null;
    }
    
}
