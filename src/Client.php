<?php

namespace AGSystems\Fakturownia\REST;

/**
 * Class Client
 * @package AGSystems\Fakturownia\REST
 *
 * @method Client invoices(int $id)
 * @method Client warehouse_documents(int $id)
 * @method Client products(int $id)
 * @method Client clients(int $id)
 * @method Client payments(int $id)
 * @method Client categories(int $id)
 * @method Client warehouses(int $id)
 *
 * @property Client invoices
 * @property Client send_by_email
 * @property Client warehouse_documents
 * @property Client products
 * @property Client clients
 * @property Client payments
 * @property Client account
 * @property Client login
 * @property Client categories
 * @property Client warehouses
 *
 * @method mixed get(array $parameters = [], array $requestOptions = [])
 * @method mixed post(array $parameters = [], array $requestOptions = [])
 * @method mixed put(array $parameters = [], array $requestOptions = [])
 * @method mixed delete(array $parameters = [], array $requestOptions = [])
 */
class Client extends \AGSystems\REST\AbstractClient
{
    protected $accessToken;
    protected $apiUrl;

    public function __construct(
        $accessToken,
        $apiUrl,
        array $options = []
    )
    {
        $this->accessToken = $accessToken;
        $this->apiUrl = $apiUrl;

        parent::__construct($options);
    }

    protected function handlePath($path)
    {
        return $path . '.json';
    }

    protected function handleResponse(callable $callback)
    {
        $response = call_user_func($callback);
        $result = json_decode($response->getBody()->getContents());
        return $result;
    }

    protected function clientOptions()
    {
        return [
            'base_uri' => $this->apiUrl,
            'query' => [
                'api_token' => $this->accessToken,
            ],
            'json' => [
                'api_token' => $this->accessToken,
            ]
        ];
    }
}
