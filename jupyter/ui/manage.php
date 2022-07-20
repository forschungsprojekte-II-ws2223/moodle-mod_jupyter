<?php

/**
 * @author Phillip Wohlfart
 * @author Raphael Weber
 * @author Solveigh König
 * @author Robin Klass
 * @date 31.05.2022
 *
 */


require_once (__DIR__ .'/../../../config.php');
require_once(__DIR__.'/../lib.php');
require (__DIR__ . '/../vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$PAGE->set_url(new moodle_url('/mod/jupyter/ui/manage.php'));
//there are different contexts. system wide in this context
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('UI skeleton');

//username has to be lowercase and start with a letter. Since moodle allows names to start with a letter, we user "user-" prefix.
$uniqueId=strtolower("user".$USER->id.$USER->lastname);

//custom key must equal key in jupyterhub_docker .env !
$key = 'your-256-bit-secret';
$data = [
    "name"=> $uniqueId,
    "iat"=> time(),
    "exp"=> time()+15
];
$jwt = JWT::encode($data, $key, 'HS256');
$jupyterLogin="http://127.0.0.1:8000/?auth_token=".$jwt;

$sections = ['Introduction', 'Learning', 'Institution', 'Another section', 'References'];
$templatecontext=[
    'sections'=>array_values($sections),
    'login'=> $jupyterLogin
    ];


echo $OUTPUT->header();
echo $OUTPUT->render_from_template('mod_jupyter/logo',[]);
echo $OUTPUT->render_from_template('mod_jupyter/manage',$templatecontext);
echo $OUTPUT->footer();
