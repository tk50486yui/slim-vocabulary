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
        $handlerMap = new ExceptionHandlerMap(
            // ::class取得類別名稱 然後綁定各自對應的處理器   key => object 型態
            [
                InvalidDataException::class => new InvalidDataExceptionHandler(),
                InvalidForeignKeyException::class => new InvalidForeignKeyExceptionHandler(),
            ]
        );
        // 創建HandlerChain物件
        return new ExceptionHandlerChain($handlerMap);
    }
}