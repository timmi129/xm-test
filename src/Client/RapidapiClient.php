<?php

declare(strict_types=1);

namespace App\Client;

use App\DTO\HistoryPricesList;
use App\Repository\HistoryRepositoryInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RapidapiClient implements HistoryRepositoryInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly string $host,
        private readonly string $key,
        private DenormalizerInterface $denormalizer
    ) {
    }

    public function getHistoryData(string $companySymbol): HistoryPricesList
    {
        return $this->sendRequest(
            'GET',
            '/stock/v3/get-historical-data?symbol=' . $companySymbol,
            [],
            HistoryPricesList::class
        );
    }

    private function sendRequest(string $method, string $url, array $options, string $objectResult): object
    {
        $options['headers']['X-RapidAPI-Host'] = $this->host;
        $options['headers']['X-RapidAPI-Key'] = $this->key;

        $response = $this->client->request(
            $method,
            'https://' . $this->host . $url,
            $options
        );

        return $this->denormalizer->denormalize(
            json_decode($response->getContent()),
            $objectResult,
            null,
            [
                ObjectNormalizer::DISABLE_TYPE_ENFORCEMENT => true, ]
        );
    }
}
