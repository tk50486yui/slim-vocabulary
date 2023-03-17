<?php
$container = $app->getContainer();

/*$container['session'] = function ($container) {
    return new \SlimSession\Helper;
};*/

$container['TestMain'] = function ($container) {
    return new app\Controllers\TestMain;
};