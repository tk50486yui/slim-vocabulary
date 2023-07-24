<?php 

$app->group('/words', function() {
   
    $this->get('', 'WordsController:findAll');
    $this->get('/{id}', 'WordsController:find');
    $this->post('', 'WordsController:add');
    $this->put('/{id}', 'WordsController:edit');
  
});

$app->group('/categories', function() {
   
    $this->get('', 'CategoriesController:findAll');
    $this->get('/{id}', 'CategoriesController:find');
    $this->post('', 'CategoriesController:add');
    $this->put('/{id}', 'CategoriesController:edit');

    $this->get('/words/{id}', 'CategoriesController:findWordsByID');

    $this->get('/recent/', 'CategoriesController:findRecent');
  
});

$app->group('/tags', function() {
   
    $this->get('', 'TagsController:findAll');
    $this->get('/{id}', 'TagsController:find');
    $this->post('', 'TagsController:add');
    $this->put('/{id}', 'TagsController:edit');   
    
    $this->get('/recent/', 'TagsController:findRecent');
    $this->get('/popular/', 'TagsController:findPopular');
  
});

$app->group('/articles', function() {
   
    $this->get('', 'ArticlesController:findAll');
    $this->get('/{id}', 'ArticlesController:find');
    $this->post('', 'ArticlesController:add');
    $this->put('/{id}', 'ArticlesController:edit');    
  
});

$app->group('/wordsgroups', function() {
   
    $this->get('', 'WordsGroupsController:findAll');
    $this->get('/{id}', 'WordsGroupsController:find');
    $this->post('', 'WordsGroupsController:add');
    $this->put('/{id}', 'WordsGroupsController:edit');
  
});

$app->group('/wordstags', function() {  
    
    $this->post('', 'WordsTagsController:add');
    $this->delete('/{id}', 'WordsTagsController:delete');

    $this->get('', 'WordsTagsController:findAll');
    $this->get('/tags/{id}', 'WordsTagsController:findByTagsID');
  
});

$app->group('/articlestags', function() {  
  
    $this->post('', 'ArticlesTagsController:add');
    $this->delete('/{id}', 'ArticlesTagsController:delete');

    //$this->get('', 'ArticlesTagsController:findAll');  
});

$app->group('/articleswords', function() {
   
    $this->get('', 'ArticlesWordsController:findAll');
    $this->get('/{id}', 'ArticlesWordsController:find');
    $this->post('', 'ArticlesWordsController:add');
    $this->delete('/{id}', 'ArticlesWordsController:delete');
  
});

$app->group('/wordsgroupsdetails', function() {
   
    $this->get('', 'WordsGroupsDetailsController:findAll');
    $this->get('/{id}', 'WordsGroupsDetailsController:find');
    $this->post('', 'WordsGroupsDetailsController:add');
    $this->put('/{id}', 'WordsGroupsDetailsController:edit');
    $this->delete('/{id}', 'WordsGroupsDetailsController:delete');
  
});