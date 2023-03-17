<?php 



$app->group('/hello', function() {

    $this->get('/{name}', 'TestMain:Test2');  
  
});