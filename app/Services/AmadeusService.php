<?php



namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AmadeusService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.amadeus.base_url'),
            'timeout' => 10.0,
            'verify' => false, // Désactiver la vérification SSL en dev
        ]);
    }

    public function getAccessToken()
    {
        $response = $this->client->post('/v1/security/oauth2/token', [
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => config('services.amadeus.key'),
                'client_secret' => config('services.amadeus.secret'),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true)['access_token'] ?? null;
    }

    public function searchCities($query)
    {
        $token = $this->getAccessToken();
    
        if (!$token) {
            return ['error' => 'Unable to fetch access token'];
        }
    
        try {
            $response = $this->client->get('/v1/reference-data/locations', [
                'headers' => [
                    'Authorization' => "Bearer {$token}",
                ],
                'query' => [
                    'keyword' => $query,
                    'subType' => 'CITY', // Recherche uniquement des villes
                ],
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
    

    public function searchFlights($origin, $destination, $departureDate)
{
    $token = $this->getAccessToken();

    if (!$token) {
        return ['error' => 'Unable to fetch access token'];
    }

    try {
        $response = $this->client->get('/v2/shopping/flight-offers', [
            'headers' => [
                'Authorization' => "Bearer {$token}",
            ],
            'query' => [
                'originLocationCode' => $origin,
                'destinationLocationCode' => $destination,
                'departureDate' => $departureDate,
                'adults' => 1, // Vous pouvez personnaliser selon les besoins
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}
public function getCityFromIata($iataCode)
{
    // Utiliser le cache si le résultat est déjà disponible
    return Cache::remember("city_name_{$iataCode}", 3600, function () use ($iataCode) {
        $token = $this->getAccessToken();

        if (!$token) {
            return $iataCode;
        }

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10, // Timeout de 10 secondes
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('https://test.api.amadeus.com/v1/reference-data/locations', [
                'keyword' => $iataCode,
                'subType' => 'AIRPORT',
            ]);

            if ($response->ok() && !empty($response['data'])) {
                return $response['data'][0]['address']['cityName'] ?? $iataCode;
            }

        } catch (\Exception $e) {
            return $iataCode; // Retourner le code si l'API échoue
        }

        return $iataCode;
    });
}

public function getAirlineName($airlineCode)
{
    // Utiliser le cache pour éviter les appels multiples
    return Cache::remember("airline_name_{$airlineCode}", 3600, function () use ($airlineCode) {
        $token = $this->getAccessToken();

        if (!$token) {
            return $airlineCode; // Retourne le code si le token échoue
        }

        try {
            $response = Http::withOptions([
                'verify' => false,
                'timeout' => 10, // Timeout pour la requête
            ])->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])->get('https://test.api.amadeus.com/v1/reference-data/airlines', [
                'airlineCodes' => $airlineCode,
            ]);

            if ($response->ok() && !empty($response['data'])) {
                return $response['data'][0]['businessName'] ?? $airlineCode; // Retourne le nom de la compagnie
            }

        } catch (\Exception $e) {
            return $airlineCode; // Retourne le code si l'API échoue
        }

        return $airlineCode;
    });
}

}
//         ]);