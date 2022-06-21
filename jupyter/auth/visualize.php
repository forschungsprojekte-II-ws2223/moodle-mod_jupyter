<?php
require(__DIR__.'/../../../config.php');
require_once(__DIR__.'/../lib.php');

require __DIR__ . '/../vendor/autoload.php';

//this shows how to load the iframe when authorization works

$jupyterLogin="https://jupyter.org/try-jupyter/lab/";

$templatecontext=[
    'login'=>$jupyterLogin
    ];

echo $OUTPUT->header();
//load iframe with jupyterhub
echo $OUTPUT->render_from_template('mod_jupyter/jupyterhub',$templatecontext);
echo $OUTPUT->footer();