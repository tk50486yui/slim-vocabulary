<?php

namespace app\Models;

use \RedBeanPHP\R as R;
use libs\Time;

class WordsGroups
{

    public function find($id)
    {
        $result = R::findOne('words_groups', ' id = ? ', array($id));
        return $result;
    }

    public function findAll()
    {
        $query = "SELECT 
                    *
                FROM 
                    words_groups              
                ORDER BY
                    created_at DESC";

        $result = R::getAll($query);
      
        return $result;
    }

    public function findByName($wg_name)
    {
        $result = R::findOne('words_groups', 'wg_name = ?', array($wg_name));
        return $result;
    }

    public function add($data)
    {
        // 使用自訂義 xdispense
        $words_groups = R::xdispense('words_groups');
        $words_groups->wg_name = $data['wg_name'];
        $id = R::store($words_groups);
        return $id;
    }

    public function edit($data, $id)
    {
        $words_groups = R::load('words_groups', $id);
        $words_groups->wg_name = $data['wg_name'];
        $words_groups->updated_at = Time::getNow();
        R::store($words_groups);
    }

    public function delete($id)
    {
        $words_groups = R::load('words_groups', $id);
        R::trash($words_groups);
    }
}
