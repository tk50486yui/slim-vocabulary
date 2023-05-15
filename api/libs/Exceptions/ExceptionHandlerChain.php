<?php 

namespace libs\Exceptions;

use libs\Exceptions\ExceptionHandlerInterface;
use Exception;

class ExceptionHandlerChain implements ExceptionHandlerInterface
{
    private $handlerMap;

    public function __construct(ExceptionHandlerMap $handlerMap)
    {
        $this->handlerMap = $handlerMap;
    }

    public function handleException(Exception $e, $response)
    {
        $class = get_class($e);
        $handler = $this->handlerMap->getHandler($class);
        while (!$handler && $class = get_parent_class($class)) {
            $handler = $this->handlerMap->getHandler($class);
        }
        if ($handler) {
            return $handler->handleException($e, $response);
        }
        throw $e;
    }
}