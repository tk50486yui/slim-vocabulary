<?php

namespace app\Middlewares;

use RedBeanPHP\R;
use libs\Responses\MsgHandler as MsgH;

class CheckConnectedMiddleware {
    
    public function __invoke($request, $response, $next) {

        // before 
        if (!R::testConnection()) {
            return MsgH::ConnetFaild($response);
        }
        
        $response = $next($request, $response);
              
        return $response;
    }
   
}