<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$env = 'dev';
// $env = 'prod';

// CHANGER POUR MISE EN PROD
require __DIR__.'/../app/config/'.$env.'.php';

require __DIR__.'/../app/app.php';
require __DIR__.'/../app/routes.php';

$app->run();