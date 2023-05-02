<?php

require '../vendor/autoload.php';

use app\Middlewares\CheckConnectionMiddleware;
use core\Setup;

$Setup = new Setup();
$Setup->RedBean();

$app = new Slim\App();
$app->add(new CheckConnectionMiddleware());

require '../app/Container.php';

require '../app/Routes.php';

$app->run();