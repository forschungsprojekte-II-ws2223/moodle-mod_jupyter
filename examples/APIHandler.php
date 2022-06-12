<?php
    require 'vendor/autoload.php';

    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'localhost:8000', [
        'headers' => [
            'Content-Type' => 'application/json'
        ]
    ]);
    echo $res->getStatusCode();
