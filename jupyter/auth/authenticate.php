<?php

require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../lib.php');
require (__DIR__ . '/../vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\TransferStats;

$adress = 'host.docker.internal:8000';
$name = required_param('name', PARAM_INT);

//custom key must equal key in /../../jupyterhub_docker/jupyterhub/jupyterhub_config.py !!!
$key = 'your-256-bit-secret';
$data = [
    "sub"=> "1234567890",
    "name"=> $name,
    "iat"=> 1516239022
];


//$jwt = JWT::encode($data, $key, 'HS256');
$jwt = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InVzZXIiLCJpYXQiOjE1MTYyMzkwMjJ9.khRbDuF1o5ZBSuM94UqI7sS-r6knwoHUDrI6-whE76E';
print_r("Authorization: ".$jwt);

$jar = new \GuzzleHttp\Cookie\CookieJar();
$client = new \GuzzleHttp\Client(
    [
        'cookies' => $jar,
        'allow_redirects' => ['max' => 10],
        'headers' => ['Authorization' => $jwt],
        'http_errors'=>false
    ]
);

$response = $client->request('GET', $adress,[
  'on_stats' => function (TransferStats $stats) use (&$url) {
  $url = $stats->getEffectiveUri();
}]);

echo $url;
echo $response->getBody();

$templatecontext=[
  'login'=>$url
  ];

echo $OUTPUT->render_from_template('mod_jupyter/jupyterhub',$templatecontext);

// echo $response->getBody();

//$decoded = JWT::decode($jwt, new Key($key, 'HS256'));
//print_r($decoded);

// /*
//  NOTE: This will now be an object instead of an associative array. To get
//  an associative array, you will need to cast it as such:
// */

//$decoded_array = (array) $decoded;

//print_r($decoded_array);

// /**
//  * You can add a leeway to account for when there is a clock skew times between
//  * the signing and verifying servers. It is recommended that this leeway should
//  * not be bigger than a few minutes.
//  *
//  * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
//  */

// JWT::$leeway = 60; // $leeway in seconds
// $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
