<?php

namespace libs\Exceptions;

use libs\Exceptions\ExceptionHandlerMap;
use libs\Exceptions\Handler\InvalidDataExceptionHandler;
use libs\Exceptions\Handler\InvalidForeignKeyExceptionHandler;
use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\ExceptionHandlerChain;

class ExceptionHandlerFactory {
    public static function createExceptionHandlerChain(): ExceptionHandlerChain {
        $handlerMap = new ExceptionHandlerMap([
            InvalidDataException::class => new InvalidDataExceptionHandler(),
            InvalidForeignKeyException::class => new InvalidForeignKeyExceptionHandler(),
        ]);
        return new ExceptionHandlerChain($handlerMap);
    }
}