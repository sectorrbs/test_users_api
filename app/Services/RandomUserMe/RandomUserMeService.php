<?php


namespace App\Services\RandomUserMe;

use App\Contracts\RandomUserContract;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class RandomUserMeService implements RandomUserContract
{
    protected string $api_url = 'https://randomuser.me/api';
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getRandomUsers(int $count_users_to_import)
    {
        try {
            $response = $this->client->get($this->api_url, [
                'query' => [
                    'results' => $count_users_to_import,
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            return $e;
        }
    }
}
