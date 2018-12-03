<?php

namespace Aftership;

class Client
{
    /** @var string Aftership api key */
    protected $apiKey;

    /** @var string Aftership domain url */
    protected $url = 'https://aftership.com.ua/v1/';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Register new tracking into system
     *
     * @param $trackingNumber
     * @return mixed
     */
    public function registerTracking($trackingNumber)
    {
        return $this->makeRequest('tracking', [
            'tracking_number' => $trackingNumber,
            'provider_id' => 1,
        ], 'POST');
    }

    /**
     * Get parcel's current tracking status
     *
     * @param $trackingNumber
     * @return mixed
     */
    public function getTrackingStatus($trackingNumber)
    {
        return $this->makeRequest('status/' . $trackingNumber);
    }

    /**
     * Get tracking list of all customers parcels
     *
     * @param int $page
     * @return mixed
     */
    public function getTrackingList($page = 1)
    {
        return $this->makeRequest('trackings', [
            'page' => $page
        ]);
    }

    /**
     * Make guzzle request to the server
     *
     * @param $url
     * @param array $data
     * @param string $method
     * @return mixed
     */
    protected function makeRequest($url, $data = [], $method = 'GET')
    {
        $data = array_merge($data, ['api_token' => $this->apiKey]);
        $url = $this->url . $url;
        $client = new \GuzzleHttp\Client();
        $response = $client->request($method, $url, $data);

        return \json_decode($response->getBody());
    }
}
