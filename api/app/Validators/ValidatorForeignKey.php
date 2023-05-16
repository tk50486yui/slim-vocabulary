<?php

namespace app\Validators;

use app\Models\Categories;
use app\Models\Tags;
use app\Models\Articles;

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

    public static function artiID($id)
    {
        $ArticlesModel = new Articles();
        if ($ArticlesModel->find($id) == null) {
            return false;
        }

        return true;
    }
}