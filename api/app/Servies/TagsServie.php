<?php

namespace app\Servies;

use libs\Exceptions\Collection\InvalidDataException;

/**   
 *  組織前端所傳入的資料，通常是用來處理多對多關係或客製化的綜合資料
 *  判斷前端資料是否有問題，與表格驗證無關
 **/

class TagsServie
{   
    private $tagsOrderArray;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function createServie($data){
        $this->tagsOrderArray = $data;
        if($this->tagsOrderArray == null && !is_array($this->tagsOrderArray)){
            throw new InvalidDataException();
        }
        return $this->tagsOrderArray;
    }   
   
}
