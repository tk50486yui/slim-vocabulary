<?php

namespace app\Validators\Tables;

use app\Validators\ValidatorForeignKey as VFK;
use app\Validators\ValidatorHelper as VH;
use app\Entities\CategoriesEntity;
use app\Models\Categories;

class CategoriesValidator
{

    public function foreignKey(CategoriesEntity $entity)
    {
        if (VH::acceptNullEmpty($entity->cate_parent_id)) {
            return true;
        }
        if (!VFK::cateID($entity->cate_parent_id)) {
            return false;
        }

        return true;
    }

    public function dupName(CategoriesEntity $entity, $id)
    {
        $CategoriesModel = new Categories();
        $rowDup = $CategoriesModel->findByName($entity->cate_name);
        if ($rowDup == null) {
            return true;
        }
        if ($id === null) {
            return false;
        }
        $row = $CategoriesModel->find($id);
        if ($row['cate_name'] == $rowDup['cate_name']) {
            return true;
        }

        return false;
    }

    // 檢查樹狀資料
    public function validateTree(CategoriesEntity $entity, $id)
    {
        $cate_parent_id = $entity->cate_parent_id;
        $CategoriesModel = new Categories();
        $all = $CategoriesModel->findAll();
        // 建立樹狀結構資料
        $tree = $CategoriesModel->buildCategoriesTree($all);
        if ($cate_parent_id === $id) {
            return false;
        }
        // 檢查所新增之 cate_parent_id 是否為自己的子節點 有值才做
        if ($cate_parent_id != null || $cate_parent_id != '') {
            if ($this->validateParent($tree, $id, $cate_parent_id)) {
                return false;
            }
        }

        return true;
    }

    //  檢查所新增的節點是否為子節點 避免出現問題 true => 不合法 false => 合法
    public function validateParent($tree, $id, $cate_parent_id)
    {
        foreach ($tree as $node) {
            if ($node['id'] == $cate_parent_id) {
                return in_array($id, $node['parents']);
            } else {
                if ($this->validateParent($node['children'], $id, $cate_parent_id)) {
                    return true;
                }
            }
        }

        return false;
    }
}
