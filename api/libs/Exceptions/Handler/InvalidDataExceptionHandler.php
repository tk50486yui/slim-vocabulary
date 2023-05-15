<?php

namespace libs\Exceptions\Handler;

use libs\Exceptions\ExceptionHandlerInterface;
use Exception;
use libs\Responses\MsgHandler as MsgH;

class InvalidDataExceptionHandler implements ExceptionHandlerInterface{

    public function handleException(Exception $e, $response) {       
        return MsgH::handleInvalidData($response);
    }

}
