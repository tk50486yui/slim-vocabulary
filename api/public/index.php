<?php

require '../vendor/autoload.php';

use core\RedBean;
use app\Middlewares\CheckConnectedMiddleware;
use app\Middlewares\DisConnectedMiddleware;

$RedBean = new RedBean(); 
$RedBean->setup(); // 連接及初始化設定

$app = new Slim\App();

$app->add(new CheckConnectedMiddleware());
$app->add(new DisConnectedMiddleware());

require '../app/Container.php';

require '../app/Routes.php';

$app->run();