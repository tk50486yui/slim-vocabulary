# SlimProject

使用 PHP Slim 3 + Redbean ORM 來建立後端 API

## Composer v2.5.4
    composer install
    composer update
-----    
    slim
    autoload
    redbean

#### Autoload

添加新的目錄要在 composer.json 的 autoload 同步新增並執行

    composer dump-autoload

----

## 目錄架構

app/ 主要程式

public/index.php 執行程式

core/ 資料庫相關

libs/ 自訂函數

----

**Middleware**

Slim 的 Middleware是以主應用程式為中心按照加入順序層層包住的，有提供主應用程式執行前及執行後的中介層，所以最晚加入的 Middleware 一開始會被最先執行，主應用程式結束後該 Middleware 則會是最晚執行的。

----
## Node v18.15.0