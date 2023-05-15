<?php 

namespace libs\Exceptions;

use Exception;
use RedBeanPHP\RedException;
use libs\Exceptions\Collection\DataProcessingFaildException;
use libs\Exceptions\Collection\ServerErrorException;
use libs\Exceptions\Interfaces\ExceptionHandlerInterface;

class ExceptionHandlerDefault implements ExceptionHandlerInterface
{
    private $handlerMap;
   
    public function __construct(ExceptionHandlerMap $handlerMap)
    {
        $this->handlerMap = $handlerMap;
    }

    // 這裡主要是判別進來的例外是屬於哪一種 $e是當下要處理的例外
    public function handle(Exception $e, $response)
    {
        // 預設例外
        $class = ServerErrorException::class;
        $handler = $this->handlerMap->getHandler($class);
       
        // 處理Redbean例外
        $class = DataProcessingFaildException::class;
        if ($e instanceof RedException){          
            $handler = $this->handlerMap->getHandler($class); 
        }
        
        return $handler->handle($e, $response);      
    }
}