<?php

namespace app\Middlewares;

use RedBeanPHP\R;

class DisConnectedMiddleware {
    
    public function __invoke($request, $response, $next) {   

        $origin = $request->getUri()->getScheme() . '://' . $request->getUri()->getHost();  
     
        if ($origin === 'http://localhost') {
            $response = $response->withHeader('Access-Control-Allow-Origin', '*');
        }
               
        $response = $response
                     ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                     ->withHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response = $next($request, $response);    
        // after 
        R::close();

        return $response;     
    }
   
}