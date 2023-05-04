<?php

namespace app\Middlewares;

use RedBeanPHP\R;
use libs\Responses\MsgHandler;

class CheckConnectedMiddleware {
    
    public function __invoke($request, $response, $next) {

        // before
        $MsgHandler = new MsgHandler();     
        if (!R::testConnection()) {
            return $MsgHandler->handleConnetFaild($response);
        }
        
        $response = $next($request, $response);
              
        return $response;
    }
   
}