<?php

namespace app\Validators\Tables;

use app\Validators\ValidatorForeignKey as VFK;
use app\Validators\ValidatorHelper as VH;
use app\Entities\TagsEntity;
use app\Models\Tags;

class TagsValidator
{
    
    public function foreignKey(TagsEntity $entity)
    {
        if(VH::acceptNullEmpty($entity->ts_parent_id)){
            return true;
        }
        if (!VFK::tsID($entity->ts_parent_id)) {
            return false;
        }

        return true;
    }

    public function dupName(TagsEntity $entity, $id)
    {
        $TagsModel = new Tags();
        $rowDup = $TagsModel->findByName($entity->ts_name);
        if ($rowDup == null) {
            return true;
        }
        if ($id === null) {
            return false;
        }
        $row = $TagsModel->find($id);
        if ($row['ts_name'] == $rowDup['ts_name']) {
            return true;
        }

        return false;
    }

    // 檢查樹狀資料
    public function validateTree(TagsEntity $entity, $id)
    {
        $ts_parent_id = $entity->ts_parent_id;
        $TagsModel = new Tags();
        $all = $TagsModel->findAll();
        // 建立樹狀結構資料
        $tree = $TagsModel->buildTagsTree($all);
        if ($ts_parent_id === $id) {
            return false;
        }
        // 檢查所新增之 ts_parent_id 是否為自己的子節點 有值才做
        if ($ts_parent_id != null || $ts_parent_id != '') {
            if ($this->validateParent($tree, $id, $ts_parent_id)) {
                return false;
            }
        }

        return true;
    }

    //  檢查所新增的節點是否為子節點 避免出現問題 true => 不合法 false => 合法
    public function validateParent($tree, $id, $ts_parent_id)
    {
        foreach ($tree as $node) {
            if ($node['id'] == $ts_parent_id) {
                return in_array($id, $node['parents']);
            } else {
                if ($this->validateParent($node['children'], $id, $ts_parent_id)) {
                    return true;
                }
            }
        }

        return false;
    }
  
}