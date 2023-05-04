<?php

namespace app\Middlewares;

use RedBeanPHP\R;

class DisConnectedMiddleware {
    
    public function __invoke($request, $response, $next) {   
               
        $response = $next($request, $response);    
        // after 
        R::close();

        return $response;     
    }
   
}