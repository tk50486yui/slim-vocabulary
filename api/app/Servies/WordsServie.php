<?php

namespace app\Servies;

/**   
 *  組織前端所傳入的資料，通常是用來處理多對多關係或客製化的綜合資料
 *  判斷前端資料是否有問題，與表格驗證無關
 **/

class WordsServie
{   
    private $wordsTags;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function createServie($data){
        $this->validateWordsTags($data);
        if($this->wordsTags == null){
            return false;
        }
        return $this->FilterDupArray($this->wordsTags);
    }

    public function validateWordsTags($data)
    {
        if(isset($data['words_tags']['array']) && !is_bool($data['words_tags']['array'])){
            if(!is_array($data['words_tags']['array']) || empty($data['words_tags']['array'])){
                $this->wordsTags = null;
            }else{
                $this->wordsTags = $data['words_tags']['array'];
            }
        }else{
            $this->wordsTags = null;
        }   
    }
    
    public function FilterDupArray($data)
    {  
        $output = array();
        $seen = array();
        foreach($data as $item){          
            // 避免重複資料         
            if (!in_array($item, $seen)) {
                array_push($output, $item);   
                array_push($seen, $item);
            }  
        }

        return $output;
    }
}
