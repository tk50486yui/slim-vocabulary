<?php

namespace libs\Exceptions\Interfaces;

use Exception;

Interface ExceptionHandlerInterface {
    public function handle(Exception $e, $response);
}