<?php

namespace app\Servies;

/**   
 *  組織前端所傳入的資料，通常是用來處理多對多關係的綜合資料
 *  判斷前端資料是否有問題，與表格驗證無關
 **/

class ArticlesServie
{   
    private $articlesTags;

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function createServie($data){
        $this->validateArticlesTags($data);
        if($this->articlesTags == null){
            return false;
        }
        return $this->FilterDupArray($this->articlesTags);
    }

    public function validateArticlesTags($data)
    {
        if(isset($data['articles_tags']['array']) && !is_bool($data['articles_tags']['array'])){
            if(!is_array($data['articles_tags']['array']) || empty($data['articles_tags']['array'])){
                $this->articlesTags = null;
            }else{
                $this->articlesTags = $data['articles_tags']['array'];
            }
        }else{
            $this->articlesTags = null;
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
