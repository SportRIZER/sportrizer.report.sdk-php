<?php

declare(strict_types=1);

namespace SportRIZER\Report;

use chillerlan\SimpleCache\CacheException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

final class ApiClient
{

    private string $APIUrl;
    private string $APIToken;
    private string $APIFormat;
    private array $APIModels;

    /**
     * Sportysky Guzzle client
     *
     * @var Client
     */
    private Client $http;

    /**
     * ApiClient constructor.
     * @param string $apiUrl
     * @param string $token
     * @param HandlerStack|null $handlerStack
     * @param array $models
     * @param string $format
     * @param bool $cacheEnable
     * @param string|null $cacheFilePath
     * @throws CacheException
     */
    public function __construct(
        string $apiUrl,
        string $token,
        HandlerStack $handlerStack = null,
        array $models = [],
        string $format = 'json')
    {
        $this->APIUrl = $apiUrl;
        $this->APIToken = $token;
        $this->APIModels = $models;
        $this->APIFormat = $format;

        $this->http = new Client([
            'base_uri' => getenv('SRREPORT_APIURL') ?: $this->APIUrl,
            'headers' => [
                'Accept' => 'application/json'
            ],
            'handler' => $handlerStack
        ]);
    }

    /**
     * @param array $params
     * @return array
     */
    private function buildQuery(array $params = []): array
    {
        $defaultParams =
            [
                'f' => $this->APIFormat,
                'token' => $this->APIToken
            ];
        if (!empty($this->APIModels)) {
            $defaultParams['models'] = implode(',', $this->APIModels);
        }
        return array_merge($defaultParams, $params);
    }

    /**
     * @param float $latitude
     * @param float $longitude
     * @param array $models
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getForecastbyLatLng(float $latitude, float $longitude, array $models = []): ResponseInterface
    {
        $requestURL = '/api/weather/gps:'.$latitude.','.$longitude.'/';
        $params = $this->buildQuery();
        if (!empty($models)) {
            $params['models'] = $models;
        }
        return $this->http->request('GET',
            $requestURL,
            [
                RequestOptions::QUERY => $params
            ]);
    }

    /**
     * @param string $code
     * @param array $models
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getForecastByCode(string $code, array $models = [])
    {
        $requestURL = '/api/weather/iso2:'.$code.' /';

        $params = $this->buildQuery();
        if (!empty($models)) {
            $params['models'] = $models;
        }
        return $this->http->request('GET',
            $requestURL,
            [
                RequestOptions::QUERY => $params
            ]);
    }

    /**
     * @param float $NorthLatitude
     * @param float $WestLongitude
     * @param float $SouthLatitude
     * @param float $EstLongitude
     * @param int $limit
     * @param array $models
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function getForecastByBounds(
        float $NorthLatitude,
        float $WestLongitude,
        float $SouthLatitude,
        float $EstLongitude,
        int $limit = 100,
        array $models = [])
    {
        $requestURL = '/api/geo/places/';
        $params = $this->buildQuery();
        if (!empty($models)) {
            $params['models'] = $models;
        }
        $params['query'] = 'bounds:'.$NorthLatitude.','.$WestLongitude.','.$SouthLatitude.','.$EstLongitude;
        $params['limit'] = $limit;
        return $this->http->request('GET',
            $requestURL,
            [
                RequestOptions::QUERY => $params
            ]);
    }
}
