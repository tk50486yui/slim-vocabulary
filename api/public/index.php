<?php

require '../vendor/autoload.php';

use core\Model as C;

C::begin();

//begin
$app = new Slim\App();

/*$app->add(new \Slim\Middleware\Session([
    'name' => 'dummy_session',
    'autorefresh' => true,
    'lifetime' => '1 month'
  ]));*/

require '../app/Container.php';

//require '../app/Middleware.php';

require '../app/Routes.php';

$app->run();