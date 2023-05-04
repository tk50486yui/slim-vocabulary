<?php

require '../vendor/autoload.php';

use core\RedBean;
use app\Middlewares\CheckConnectedMiddleware;
use app\Middlewares\DisConnectedMiddleware;

$RedBean = new RedBean(); 
$RedBean->setup(); // 連接及初始化設定

$app = new Slim\App();

// Middle 以圓圈按順序往外推
$app->add(new CheckConnectedMiddleware()); // 第一圈
$app->add(new DisConnectedMiddleware()); //  第二圈

require '../app/Container.php';

require '../app/Routes.php';

$app->run();