<?php

namespace app\Validators;

use app\Models\Categories;
use app\Models\Tags;

class ValidatorForeignKey
{
    
    public static function cateID($id)
    {
        $CategoriesModel = new Categories();
        if ($CategoriesModel->find($id) == null) {
            return false;
        }

        return true;
    }

    public static function tsID($id)
    {
        $TagsModel = new Tags();
        if ($TagsModel->find($id) == null) {
            return false;
        }

        return true;
    }
}