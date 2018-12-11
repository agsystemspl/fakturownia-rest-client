<?php

namespace AGSystems\Fakturownia\REST;

use GuzzleHttp\Psr7\Response;

class Client
{
    const ACCESS_MODE = 'JSON';

    protected $accessToken;
    protected $apiUrl;
    protected $query = [];

    public function __construct($accessToken, $apiUrl)
    {
        $this->accessToken = $accessToken;
        $this->apiUrl = $apiUrl;
    }

    public function __get($name)
    {
        $this->query[] = $name;
        return $this;
    }

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'get':
            case 'post':
            case 'put':
            case 'delete':
            case 'file':
                $uri = implode('/', array_filter($this->query));
                $this->query = [];
                $uri .= '.' . strtolower(static::ACCESS_MODE);
                return $this->request($name, $uri, array_shift($arguments));
        }

        $this->query[] = $name;
        $this->query = array_merge($this->query, $arguments);
        return $this;
    }

    protected function responseHandler(callable $callback)
    {
        /**
         * @var $response Response
         */
        $response = call_user_func($callback);
        return $response->getBody()->getContents();
    }

    protected function request($method, $uri, $data = null)
    {
        $options = [
            'base_uri' => $this->apiUrl,
        ];

        $data = array_merge($data, ['api_token' => $this->accessToken]);

        switch (strtoupper($method)) {
            case 'GET':
            case 'DELETE':
                $options += [
                    'query' => $data,
                ];
                break;
            case 'POST':
            case 'PUT':
                $options += [
                    'json' => $data,
                ];
                break;
            case 'FILE':
                $options += [
                    'file' => $data,
                ];
                break;
        }

        $callback = function () use ($method, $uri, $options) {
            $client = new \GuzzleHttp\Client($options);
            return $client->request($method, $uri);
        };

        return $this->responseHandler($callback);
    }
}
