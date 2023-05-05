<?php

namespace libs\Customs;

class ArrayMap
{

    // input {'ws_id':'123', 'ts_id':'456'}
    // output: array('ws_id' => 123, 'ts_id' => 456)
    public static function getMap($data)
    {

        $formatData = static function ($key, $value) {
            return ["{$key}" => $value];
        };
    
        return array_merge(...array_map($formatData, array_keys($data), $data));
         
    }
}
