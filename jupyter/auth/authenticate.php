<?php
global $USER;

require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../lib.php');
require (__DIR__ . '/../vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$uniqueId=strtolower("user-".$USER->lastname."-".$USER->id); //username has to be lowercase and start with a letter. Since moodle alows names to start with a letter, we user "user-" prefix.
print_r(" name: ".$uniqueId);

//custom key must equal key in jupyterhub_docker .env !
$key = 'your-256-bit-secret';
$data = [
    "name"=> $uniqueId,
    "iat"=> time(),
    "exp"=> time()+15
];

$jwt = JWT::encode($data, $key, 'HS256');

$jupyterLogin="http://127.0.0.1:8000/?auth_token=".$jwt;
print_r(" link: ".$jupyterLogin);

$templatecontext=[
  'login'=>$jupyterLogin
  ];

echo $OUTPUT->render_from_template('mod_jupyter/jupyterhub',$templatecontext);

