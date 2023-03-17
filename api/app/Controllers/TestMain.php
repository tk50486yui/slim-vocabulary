<?php

namespace app\Controllers;
use app\Models\TestModel;

use \RedBeanPHP\R as R;

class TestMain 
{
    
    public function Test2($request, $response, $args)
    {    
        $testModel = new TestModel();
        $result = $testModel->Test3();
        return $response->write("HelloTest " . $args['name']. $result);
    }
}