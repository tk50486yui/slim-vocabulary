# slim-vocabulary

使用 PHP Slim 3 來建立後端 API（本專案為舊版，新版及文件可參照 [Laravel 版本](https://github.com/tk50486yui/laravel-vocabulary.git)）

搭配 Vue 3 前端：[vue-vocabulary](https://github.com/tk50486yui/vue-vocabulary.git)

後端 Laravel 版本（新）：[laravel-vocabulary](https://github.com/tk50486yui/laravel-vocabulary.git)

---
## 開發工具

主要語言：PHP 7.2.12

框架：[Slim 3](https://www.slimframework.com/docs/v3/)

資料庫：PostgreSQL 9.6.24

ORM：[Redbean](https://www.redbeanphp.com/index.php)

---
## Docker

```
docker-compose up -d
```

---
## 目錄架構
```    
+ slim-vocabulary
    ├─ apache   //  Apache Dockerfile
    ├─ app
    │   ├─ Controllers      //  執行主要交易 並處理 Response
    │   ├─ Entities         //  注入資料 驗證格式 轉換資料
    │   ├─ Factories        //  處理資料格式 實際執行 Entity 及 Validator
    │   ├─ Middlewares      //  Middleware 
    │   ├─ Models           //  執行 ORM 與 SQL 語法
    │   ├─ Services         //  處理前端輸入資料（多對多、複雜欄位）
    │   └─ Validators       //  驗證資料完整性
    ├─ core     //  資料庫相關設定
    ├─ libs     //  自定義 Library
    │   ├─ Exceptions       //  Exception 例外管理
    │   │   ├─ Collection       //  Exception implements
    │   │   └─ Interfaces       //  自定義 Interface
    │   └─ Responses        //  自定義 Response
    ├─ pgsql    //  .sql
    ├─ public   //  index.php
    └─ vendor

```