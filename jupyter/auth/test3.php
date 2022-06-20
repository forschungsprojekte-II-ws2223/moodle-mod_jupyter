<?php
   require (__DIR__ . '/../vendor/autoload.php');

    $jwt ='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IlBldGVyIFBldGVyc29uIiwiaWF0IjoxNTE2MjM5MDIyfQ.4xDK-elVZcyxUJ_n7mucr8n8ytYCvPzXD9DoD07Xk50';
    $headers = [
        "Authorization"=> "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6Ikpva28gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.2c547-cL6FWDfjLCmLp3aQBc7ysdkX7g3lvVL0vZiTc"
    ];
    $client = new GuzzleHttp\Client();
    $response = $client->request('GET', 'host.docker.internal:8000', [
        'allow_redirects' => [
                'max'             => 2,        // allow at most 10 redirects.
                'on_redirect'     => $onRedirect,
                'track_redirects' => true
        ],
        'headers' =>$headers
        ]);

        $onRedirect = function(
            RequestInterface $request,
            ResponseInterface $response,
            UriInterface $uri
        ) {
            echo 'Redirecting! ' . $request->getUri() . ' to ' . $uri . "\n";
        };    

    var_dump($response->getStatusCode());

    var_dump((string) $response->getBody());

    echo $res->getHeaderLine('X-Guzzle-Redirect-History');
    // http://first-redirect, http://second-redirect, etc...

    echo $res->getHeaderLine('X-Guzzle-Redirect-Status-History');
    // 301, 302, etc...
