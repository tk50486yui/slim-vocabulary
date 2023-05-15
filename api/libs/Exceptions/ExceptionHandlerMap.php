<?php

namespace libs\Exceptions;

use libs\Exceptions\Interfaces\ExceptionHandlerInterface;

class ExceptionHandlerMap
{
    private $handlers;

    public function __construct(array $handlers = [])
    {
        $this->handlers = $handlers;
    }

    public function addHandler(string $class, ExceptionHandlerInterface $handler): void
    {
        $this->handlers[$class] = $handler;
    }

    // 判斷例外是否符合介面所定義的 
    public function getHandler(string $class): ?ExceptionHandlerInterface
    {
        return $this->handlers[$class] ?? null;
    }
}