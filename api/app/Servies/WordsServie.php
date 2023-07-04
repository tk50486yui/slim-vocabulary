<?php

namespace app\Servies;

use app\Factories\WordsTagsFactory;

/**   
 *  組織前端所傳入的資料，通常是用來處理多對多關係的綜合資料
 *  並透過Factory去驗證各個表的資料
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

    public function createServie($data, $id){
        $this->validateWordsTags($data);
        if($this->wordsTags == null || $id == null || $id == ''){
            return false;
        }
        return $this->toArrayMap($this->wordsTags, $id);
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
    
    public function toArrayMap($data, $id)
    {
        $WordsTagsFactory = new WordsTagsFactory();
      
        $output = array();
        foreach($data as $item){          
            $d = array('ws_id' => $id, 'ts_id' => $item);
            $WordsTagsFactory->createFactory($d, null);
            array_push($output, $d); 
        }

        return $output;
    }
}
