<?php

require '../vendor/autoload.php';

/*use core\Model as C;

C::begin();*/

$app = new Slim\App();

/*$app->add(new \Slim\Middleware\Session([
    'name' => 'dummy_session',
    'autorefresh' => true,
    'lifetime' => '1 month'
  ]));*/
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $response->write("Hello " . $args['name']);
});
$app->run();
/*require '../app/Container.php';

require '../app/Middleware.php';

require '../app/Routes.php';*/