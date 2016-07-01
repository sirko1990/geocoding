<?php

namespace Geocoding;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class Geocoder
{
    use CachingQueries;

    private $endpoint = 'https://maps.googleapis.com/maps/api/geocode/';

    /**
     * @var array $query The http url query params
     */
    private $query = [];

    const  RETURN_FORMAT = 'json';

    /**
     * @var Client client
     */
    private $client;

    public function __construct()
    {
        $this->query['key'] = config('geocoding.api_key');
        $this->client = new Client(['base_uri' => $this->endpoint]);
    }

    /**
     * Set Language parameter to query
     *
     * @param  string $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->query['language'] = $language;

        return $this;
    }

    /**
     * Get coordinates by address
     *
     * @param string $address
     * @return mixed
     */
    public function addressToСoordinates($address)
    {
        $this->query['address'] = $address;
        $res = $this->sendRequest('GET', self::RETURN_FORMAT);

        return $res;
    }

    /**
     * Get addresses by coordinates
     *
     * @param string $coordinates
     * @return mixed
     */
    public function coordinatesToAddress($coordinates)
    {
        $this->query['latlng'] = $coordinates;
        $res = $this->sendRequest('GET', self::RETURN_FORMAT);

        return $res;
    }

    /**
     * Send Api request
     *
     * @param string $method The http method
     * @param string $path   The path of http uri
     *
     * @return array
     * @throws GeocodingException
     */
    private function sendRequest($method, $path)
    {
        if($this->hasQueryCache($method, $path)){
            return $this->getQueryFromCache($method, $path);
        }

        try {
            $response = $this->client->request($method, $path, ['query' => $this->query]);
            $data = self::decodeHttpResponse($response);
            $this->setQuerytoCache($method, $path, $data);

        }catch(RequestException $e){
            if(!$e->hasResponse()){
                throw new GeocodingException($e->getMessage(), $e->getCode());
            }

            $response = $e->getResponse();
            $data = self::decodeHttpResponse($response, $e->getMessage());
        }

        return $data;
    }

    /**
     * @param ResponseInterface $response
     * @param string $errorMessage
     * @return mixed
     * @throws GeocodingException
     */
    public static function decodeHttpResponse(ResponseInterface $response, $errorMessage = '')
    {
        $code = (int) $response->getStatusCode();

        if($code <= 400){
            $body = (string) $response->getBody();

            return json_decode($body, true);
        }

        throw new GeocodingException($errorMessage , $code);
    }

}