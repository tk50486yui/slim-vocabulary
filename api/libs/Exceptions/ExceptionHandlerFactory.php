<?php

namespace libs\Exceptions;

use libs\Exceptions\Collection\InvalidDataException;
use libs\Exceptions\Collection\InvalidForeignKeyException;
use libs\Exceptions\Collection\DuplicateException;
use libs\Exceptions\Collection\DataProcessingFaildException;
use libs\Exceptions\Collection\ServerErrorException;
use libs\Exceptions\ExceptionHandlerMap;
use libs\Exceptions\ExceptionHandlerChain;
use libs\Exceptions\ExceptionHandlerDefault;

class ExceptionHandlerFactory {

    // 這邊是處理主動拋出的自訂例外並回傳對應的訊息
    public static function createChain(): ExceptionHandlerChain {

        // ::class取得類別名稱 然後綁定各自對應的處理器   key => object 型態
        $handlerMap = new ExceptionHandlerMap(            
            [
                InvalidDataException::class => new InvalidDataException(),
                InvalidForeignKeyException::class => new InvalidForeignKeyException(),
                DuplicateException::class => new DuplicateException()
            ]
        );
       
        return new ExceptionHandlerChain($handlerMap);
    }

    // 處理預設例外訊息
    public static function createDefault(): ExceptionHandlerDefault {        

        $handlerMap = new ExceptionHandlerMap(            
            [
                DataProcessingFaildException::class => new DataProcessingFaildException(),
                ServerErrorException::class => new ServerErrorException()
            ]
        );
       
        return new ExceptionHandlerDefault($handlerMap);           
    }
}