<?php

$container = $app->getContainer();

$container['WordsController'] = function ($container) {
    return new app\Controllers\WordsController;
};
$container['CategoriesController'] = function ($container) {
    return new app\Controllers\CategoriesController;
};
$container['TagsController'] = function ($container) {
    return new app\Controllers\TagsController;
};
$container['ArticlesController'] = function ($container) {
    return new app\Controllers\ArticlesController;
};
$container['WordsGroupsController'] = function ($container) {
    return new app\Controllers\WordsGroupsController;
};
$container['WordsTagsController'] = function ($container) {
    return new app\Controllers\WordsTagsController;
};
$container['ArticlesTagsController'] = function ($container) {
    return new app\Controllers\ArticlesTagsController;
};
$container['ArticlesWordsController'] = function ($container) {
    return new app\Controllers\ArticlesWordsController;
};
$container['WordsGroupsDetailsController'] = function ($container) {
    return new app\Controllers\WordsGroupsDetailsController;
};