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
## 目錄架構
```    
+ slim-vocabulary
    ├─ app    //  主程式
    │   ├─ Controllers   //  執行主要交易 建立 Factory 及存取 Model 並處理訊息
    │   ├─ Entities      //  注入資料 驗證格式 轉換資料
    │   ├─ Factories     //  處理資料格式 實際執行 Entity 及 Validator
    │   ├─ Middlewares   //  Middleware 
    │   ├─ Models        //  執行 ORM 與 SQL 語法    
    │   ├─ Services      //  處理前端輸入資料（多對多、複雜欄位）
    │   └─ Validators    //  驗證資料完整性
    ├─ core     //  資料庫相關設定
    ├─ libs     //  自定義函式庫
    │   ├─ Exceptions   //  Exception 例外管理
    │   │   ├─ Collection   //  自定義 Exception 實作
    │   │   └─ Interfaces   //  自定義 介面
    │   └─ Responses     //  自定義 Response
    ├─ public   //  index 網址存取目錄    
    └─ vendor   //  composer 套件

```