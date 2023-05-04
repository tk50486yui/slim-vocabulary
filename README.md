# SlimProject

使用 PHP Slim 3 + Redbean ORM 來建立後端api

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

----

**架構**

    app/ 主要程式

    public/index.php 執行程式

    core/ 資料庫

    libs/ 自訂函數

----

**Middleware**

Slim 的 Middleware 是按照加入順序層層包住的，所以最晚加入的 Middleware 一開始會被最先執行，應用程式執行結束後則會是最晚執行的。

----

### Git
    git add .
    git commit -m ""
    git push

    git rm --cached path
    git push -f origin main **!!這是強制推送並覆蓋!!**