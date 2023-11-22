<?php

namespace libs\Responses;

class Msg
{              
    private $error; 
    private $result; 

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function toArray()
    {
        return [
            'error' => $this->error,
            'result' => $this->result,
        ];
    }
}