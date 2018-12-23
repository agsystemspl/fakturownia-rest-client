<?php

require __DIR__ . "/../vendor/autoload.php";

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$client = new \AGSystems\Fakturownia\REST\Client(
    getenv('API_TOKEN'),
    getenv('API_URL')
);


var_export(
    $client->invoices->get([
        'period' => 'this_year'
    ])
);
