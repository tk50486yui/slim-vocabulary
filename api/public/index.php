<?php

require '../vendor/autoload.php';

use core\Model as C;
use app\Middlewares\CheckConnectionMiddleware;

C::begin();

/* Begin */
$app = new Slim\App();
$app->add(new CheckConnectionMiddleware());

require '../app/Container.php';

require '../app/Routes.php';

$app->run();