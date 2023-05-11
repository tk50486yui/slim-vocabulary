# SlimProject

使用 PHP Slim 3 + Redbean ORM 來建立後端 API

搭配前端：[VuePoject](https://github.com/tk50486yui/VueProject.git)

---
## PHP 7.2.12

---

## PostgreSQL 9.6.24

資料庫是PostgreSQL，並使用 pgAdmin 4 進行操作

---

## Composer 2.5.4
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
```    
   + api
    ├─ app      //  主要程式
    │   ├─ Controllers   //  邏輯控制 存取Model並回傳給user
    │   ├─ Models        //  執行ORM與SQL語法
    │   ├─ Validations   //  驗證資料
    │   └─ Middlewares   //  中介層      
    ├─ public   //  網址存取目錄    
    ├─ core     //  資料庫相關設定
    └─ libs     //  自訂函數
        ├─ Customs
        └─ Responses    //  自訂回應訊息

```


----

**Namespace**

使用 Namespace 檔案名稱要與 Class 一致

----

**Middleware**

Slim 的 Middleware 是以主應用程式為中心按照加入順序層層包住的，有提供主應用程式執行前及執行後的中介層，所以最晚加入的 Middleware 一開始會被最先執行，主應用程式結束後該 Middleware 則會是最晚執行的。