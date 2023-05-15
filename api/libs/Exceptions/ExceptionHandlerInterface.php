<?php

namespace libs\Exceptions;

use Exception;

Interface ExceptionHandlerInterface {
    public function handleException(Exception $e, $response);
}