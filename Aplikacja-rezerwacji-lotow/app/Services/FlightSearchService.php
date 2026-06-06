<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;

class FlightSearchService
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.serpapi.url', 'https://serpapi.com/search.json');
        $this->apiKey = config('services.serpapi.key');
    }

    /**
     * Main search method
     */
    public function search(array $params): array
    {
        try {
            $response = Http::timeout(10)
                ->retry(3, 200) // 3 próby, 200ms odstępu
                ->get($this->baseUrl, [
                    'engine' => 'google_flights',
                    'api_key' => $this->apiKey,

                    'departure_id' => $params['from'],
                    'arrival_id' => $params['to'],
                    'outbound_date' => $params['date'],
                    'return_date' => $params['return_date'] ?? null,

                    'currency' => 'PLN',
                    'hl' => 'pl',
                    'gl' => 'pl',
                ]);

            if ($response->failed()) {
                $this->logError($response);
                return $this->emptyResponse();
            }

            $data = $response->json();

            return $this->normalize($data);

        } catch (RequestException $e) {
            Log::error('SerpAPI request failed', [
                'message' => $e->getMessage(),
            ]);

            return $this->emptyResponse();
        }
    }

    /**
     * Normalize API response (clean output for controller)
     */
    private function normalize(array $data): array
    {
        return [
            'best_flights' => $data['best_flights'] ?? [],
            'other_flights' => $data['other_flights'] ?? [],
            'price_insights' => $data['price_insights'] ?? null,
            'airports' => $data['airports'] ?? [],
        ];
    }

    /**
     * Safe fallback response (never break app)
     */
    private function emptyResponse(): array
    {
        return [
            'best_flights' => [],
            'other_flights' => [],
            'price_insights' => null,
            'airports' => [],
            'error' => true,
        ];
    }

    /**
     * Logging helper
     */
    private function logError($response): void
    {
        Log::warning('SerpAPI failed response', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
    }
}
