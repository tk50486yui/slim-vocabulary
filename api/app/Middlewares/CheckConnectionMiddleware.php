<?php

namespace app\Middlewares;

use RedBeanPHP\R;
use libs\Responses\MsgHandler;

class CheckConnectionMiddleware {
    
    public function __invoke($request, $response, $next) {

        $MsgHandler = new MsgHandler();

        if (!$this->checkConnection()) {
            return $MsgHandler->handleConnetFaild($response);
        }

        $response = $next($request, $response);
        return $response;
    }

    public function checkConnection()
    {
        if (!R::testConnection()) {      
            return false;
        }
        return true;
    }
}