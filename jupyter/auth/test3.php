<?php
   require (__DIR__ . '/../vendor/autoload.php');

    $jwt ='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IlBldGVyIFBldGVyc29uIiwiaWF0IjoxNTE2MjM5MDIyfQ.4xDK-elVZcyxUJ_n7mucr8n8ytYCvPzXD9DoD07Xk50';
    $headers = [
        "Authorization"=> "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6Ikpva28gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.2c547-cL6FWDfjLCmLp3aQBc7ysdkX7g3lvVL0vZiTc"
    ];
    $client = new GuzzleHttp\Client(['headers' =>$headers]);
    $response = $client->request('GET', 'host.docker.internal:8000');

    $body=$response->getBody();
    var_dump((string) $response->getBody());
