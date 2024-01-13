<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class GuzzleHttpHelper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }


    //Post Request

    public function post($url, $data = [], $headers = [])
    {
        try {
            $response = $this->client->post($url, [
                'form_params' => $data,
                'headers' => $headers,
            ]);

            return [
                'status' => 'success',
                'data' => json_decode($response->getBody()->getContents()),
            ];

        } catch (BadResponseException $exception) {
            $statusCode = $exception->getResponse()->getStatusCode();
            $message = $exception->getResponse()->getBody()->getContents();

            return [
                'status' => 'failed',
                'error_code' => $statusCode,
                'data' => json_decode($message),
            ];
        }
    }


    //Get Request

    public function get($url, $params = [], $headers = [])
    {
        try {
            $response = $this->client->get($url, [
                'query' => $params,
                'headers' => $headers,
            ]);

            return [
                'status' => 'success',
                'data' => json_decode($response->getBody()->getContents()),
            ];

        } catch (BadResponseException $exception) {
            $statusCode = $exception->getResponse()->getStatusCode();
            $message = $exception->getResponse()->getBody()->getContents();

            return [
                'status' => 'failed',
                'error_code' => $statusCode,
                'data' => json_decode($message),
            ];
        }
    }
}
