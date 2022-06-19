<?php

require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../lib.php');

//$id = required_param('id', PARAM_INT);
// $PAGE->set_url('/mod/jupyter/index.php', array('id' => $id));

require (__DIR__ . '/vendor/autoload.php');
$id = $_GET['id'];

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// $payload = [
//     'iss' => 'http://example.org',
//     'aud' => 'http://example.com',
//     'iat' => 1356999524,
//     'nbf' => 1357000000
// ];

$key = 'your-256-bit-secret';

$data = [
  'id' =>$id
];

// /**
//  * IMPORTANT:
//  * You must specify supported algorithms for your application. See
//  * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
//  * for a list of spec-compliant algorithms.
//  */
$jwt = JWT::encode($data, $key, 'HS256');


$testJWT = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6Im1pY2hhZWwgam9uam9uIiwiaWF0IjoxNTE2MjM5MDIyfQ.vgbBQixT0H_LOhFqARyqSPGDjkNoBDTEfDRQ8LhH8Tc';
print_r("Authorization: ".$jwt);

$url = 'host.docker.internal:8000';

///////////////////////////

// a little script check is the cURL extension loaded or not
if(!extension_loaded("curl")) {
  die("cURL extension not loaded! Quit Now.");
}

// Actual script start

// create a new cURL resource
// $curl is the handle of the resource
$curl = curl_init();

// set the URL and other options
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: '.$jwt));
if(curl_error($curl)) {
  print_r(curl_error($curl));
}
// execute and pass the result to browser
curl_exec($curl);

// close the cURL resource
curl_close($curl);


/////////////////////////////


$decoded = JWT::decode($jwt, new Key($key, 'HS256'));

print_r($decoded);

// /*
//  NOTE: This will now be an object instead of an associative array. To get
//  an associative array, you will need to cast it as such:
// */

$decoded_array = (array) $decoded;

//print_r($decoded_array);

// /**
//  * You can add a leeway to account for when there is a clock skew times between
//  * the signing and verifying servers. It is recommended that this leeway should
//  * not be bigger than a few minutes.
//  *
//  * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
//  */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, new Key($key, 'HS256'));

$values = array_values($decoded_array);


  //echo $OUTPUT->header();
  //echo "<h1>{$values}</h1>";
  //echo $OUTPUT->footer();