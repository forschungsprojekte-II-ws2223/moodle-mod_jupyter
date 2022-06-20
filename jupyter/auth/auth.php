<?php
require __DIR__ . '/../vendor/autoload.php';

$jwt = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6InVzZXIiLCJpYXQiOjE1MTYyMzkwMjJ9.khRbDuF1o5ZBSuM94UqI7sS-r6knwoHUDrI6-whE76E';
$jar = new \GuzzleHttp\Cookie\CookieJar();
$client = new \GuzzleHttp\Client(
    [
        'cookies' => $jar,
        'allow_redirects' => ['max' => 7],
        'headers' => ['Authorization' => $jwt]
    ]
);

$response = $client->request('GET', 'localhost:8000/hub/login?next=%2Fhub%2F');

//var_dump($response)
//var_dump($jar)
echo $response->getBody()
?>