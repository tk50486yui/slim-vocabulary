# SlimProject

使用 PHP Slim 3 + Redbean ORM 來建立後端api

----
    app/ 主要程式

    public/index.php 執行程式

    core/ 資料庫

    libs/ 自訂函數

## Node v18.15.0

## Composer v2.5.4
    composer install
    composer update
-----    
    slim
    autoload
    redbean

#### Autoload

添加新的目錄要在composer.json 的 autoload 同步新增並執行

    composer dump-autoload

### Git
    git add .
    git commit -m ""
    git push

    git rm --cached api/core/Config.php
    git push -f origin main // !!*這是強制推送並覆蓋*!!