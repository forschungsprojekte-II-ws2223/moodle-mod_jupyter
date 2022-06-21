<?php
require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../lib.php');

require __DIR__ . '/../vendor/autoload.php';

$PAGE->set_url(new moodle_url('/mod/jupyter/auth/debug.php'));
$PAGE->set_context(\context_system::instance());



$jwt = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InVzZXIiLCJpYXQiOjE1MTYyMzkwMjJ9.khRbDuF1o5ZBSuM94UqI7sS-r6knwoHUDrI6-whE76E';
$jar = new \GuzzleHttp\Cookie\CookieJar();
$client = new \GuzzleHttp\Client(
    [
        'cookies' => $jar,
        'allow_redirects' => ['max' => 10],
        'headers' => ['Authorization' => $jwt],
        'debug' => false,
        'http_errors'=>false
    ]
);
var_dump($jar);

$response = $client->request('GET', 'host.docker.internal:8000/hub/login?next=%2Fhub%2F');

//var_dump($response);
var_dump($jar);
// $body = $response->getBody();
// echo $body;

?>