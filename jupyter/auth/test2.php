<?php

require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../lib.php');


// a little script check is the cURL extension loaded or not
if(!extension_loaded("curl")) {
    die("cURL extension not loaded! Quit Now.");
}

$ch=curl_init();
curl_setopt($ch, CURLOPT_URL, 'host.docker.internal:8000');
//curl_setopt($curl, CURLOPT_URL, 'http://www.google.com');

$jwt ='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6ImFiZXIgYnJhZGVyIiwiaWF0IjoxNTE2MjM5MDIyfQ.kJI2elbu9AKjHxpe867CVDKKcctFmyNJssTNqSWaKH8';
curl_setopt($ch, CURLOPT_HTTPHEADER,'Authorization: '.$jwt);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
$result = curl_exec($ch);
if(curl_error($ch)) {
    print_r(curl_error($ch));
}

print_r(curl_getinfo($ch));
curl_close($ch);
echo $result;
echo "<p>end of file<p>";