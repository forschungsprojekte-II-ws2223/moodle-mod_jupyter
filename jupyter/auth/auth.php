<?php
require __DIR__ . '/../vendor/autoload.php';

$jar = new \GuzzleHttp\Cookie\CookieJar();
$client = new \GuzzleHttp\Client(
    [
        'cookies' => $jar,
        'allow_redirects' => false,
        'headers' => ['Authorization' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InVzZXIiLCJpYXQiOjE1MTYyMzkwMjJ9.khRbDuF1o5ZBSuM94UqI7sS-r6knwoHUDrI6-whE76E']
    ]
);

$response = $client->request('GET', 'localhost:8000/hub/login?next=%2Fhub%2F');

//echo $response->getHeaderLine('set-cookie'); 
var_dump($jar)
?>