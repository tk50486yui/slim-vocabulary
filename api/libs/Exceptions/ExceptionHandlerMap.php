<?php

namespace libs\Exceptions;

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

    public function getHandler(string $class): ?ExceptionHandlerInterface
    {
        return $this->handlers[$class] ?? null;
    }
}