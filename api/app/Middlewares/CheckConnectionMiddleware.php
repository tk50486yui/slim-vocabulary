<?php

namespace app\Middlewares;

use RedBeanPHP\R;
use libs\Responses\Msg;
use libs\Responses\MsgHandler;

class CheckConnectionMiddleware {
    public function __invoke($request, $response, $next) {
        $MsgHandler = new MsgHandler();
        $Msg = new Msg(); 
       /* if (!$this->checkConnection()) {
            return $MsgHandler->handleConnetFaild($response, $Msg->msg);
        }*/

        $response = $next($request, $response);
        return $response;
    }

    /*public function checkConnection()
    {
        if (!R::testConnection()) {      
            return false;
        }
        return true;
    }*/
}