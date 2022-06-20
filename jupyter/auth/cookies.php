<?php
require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../lib.php');

require (__DIR__ . '/../vendor/autoload.php');

$client = new GuzzleHttp\Client();
$jar = new \GuzzleHttp\Cookie\CookieJar();
$client->request('GET', 'host.docker.internal:8000', ['cookies' => $jar]);

var_dump($jar);