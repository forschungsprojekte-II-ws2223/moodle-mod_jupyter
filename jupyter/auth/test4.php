<?php
require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../lib.php');

require (__DIR__ . '/../vendor/autoload.php');

$headers = [
    "Authorization"=> "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6Ikpva28gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.2c547-cL6FWDfjLCmLp3aQBc7ysdkX7g3lvVL0vZiTc"
];

$client = new GuzzleHttp\Client();

$response = $client->get("host.docker.internal:8000", ["headers" =>$headers]);

var_dump($response->getStatusCode());

var_dump((string) $response->getBody());