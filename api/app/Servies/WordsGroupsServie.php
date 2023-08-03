<?php

namespace app\Servies;

use libs\Exceptions\Collection\InvalidDataException;

/**   
 *  組織前端所傳入的資料，通常是用來處理多對多關係或客製化的綜合資料
 *  判斷前端資料是否有問題，與表格驗證無關
 **/

class WordsGroupsServie
{   
   
    private $wordsGroupsDetails;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function createServie($data){
        $this->validateWordsGroupsDetails($data);
        if($this->wordsGroupsDetails == null){
            throw new InvalidDataException();
        }
        return $this->FilterDupArray($this->wordsGroupsDetails);
    }

    public function validateWordsGroupsDetails($data)
    {
        if(isset($data['words_groups_details']) && !is_bool($data['words_groups_details'])){
            if(!is_array($data['words_groups_details']) || empty($data['words_groups_details'])){
                $this->wordsGroupsDetails = null;
            }else if(count($data['words_groups_details']) == 0){
                $this->wordsGroupsDetails = null;
            }else{
                $this->wordsGroupsDetails = $data['words_groups_details'];
            }
        }else{
            $this->wordsGroupsDetails = null;
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
