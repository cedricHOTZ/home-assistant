<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeAssistantService
{
    private HttpClientInterface $client;
    private string $haUrl;
    private string $haToken;

    public function __construct(HttpClientInterface $client, string $haUrl, string $haToken)
    {
        $this->client = $client;
        $this->haUrl = rtrim($haUrl, '/');
        $this->haToken = $haToken;
    }

    // Récupérer l'état d'une entité (volet, lumière, capteur...)
    public function getEntityState(string $entityId): ?array
    {
        $response = $this->client->request('GET', "{$this->haUrl}/api/states/{$entityId}", [
            'headers' => [
                'Authorization' => "Bearer {$this->haToken}",
                'Content-Type' => 'application/json',
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            return null;
        }

        return $response->toArray();
    }

    // Ouvrir un volet
    public function openCover(string $entityId): bool
    {
        $response = $this->client->request('POST', "{$this->haUrl}/api/services/cover/open_cover", [
            'headers' => [
                'Authorization' => "Bearer {$this->haToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'entity_id' => $entityId
            ],
        ]);

        return $response->getStatusCode() === 200;
    }

    // Fermer un volet
    public function closeCover(string $entityId): bool
    {
        $response = $this->client->request('POST', "{$this->haUrl}/api/services/cover/close_cover", [
            'headers' => [
                'Authorization' => "Bearer {$this->haToken}",
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'entity_id' => $entityId
            ],
        ]);

        return $response->getStatusCode() === 200;
    }
}
