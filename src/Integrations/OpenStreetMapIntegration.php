<?php

namespace MyTour\Integrations;

class OpenStreetMapIntegration
{

    public function __construct()
    {
    }

    public function searchAddress(string $value): array
    {
        $client = new \GuzzleHttp\Client([
            'base_uri' => 'https://nominatim.openstreetmap.org',
            'headers' => [
                'User-Agent' => 'MyTourApp/1.0 (contact@mytour.app)',
                'Accept' => 'application/json',
            ],
            'timeout' => 5.0,
        ]);

        try {
            $response = $client->request('GET', '/search', [
                'query' => [
                    'format' => 'jsonv2',
                    'q' => $value,
                ],
            ]);

            $body = (string) $response->getBody();
            $data = json_decode($body, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                // invalid JSON
                return [];
            }

            return is_array($data) ? $data : [];
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            return ['message' => $e->getMessage()];
        }
    }
}