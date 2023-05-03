<?php

require '../vendor/autoload.php';

use core\RedBean;
use app\Middlewares\CheckConnectionMiddleware;


$RedBean = new RedBean(); 
$RedBean->setup(); // 連接及初始化設定

$app = new Slim\App();
$app->add(new CheckConnectionMiddleware());

require '../app/Container.php';

require '../app/Routes.php';

$app->run();