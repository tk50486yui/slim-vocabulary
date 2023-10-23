# SlimProject

使用 PHP Slim 3 來建立後端 API

搭配前端：[VuePoject](https://github.com/tk50486yui/VueProject.git)

---
## PHP 7.2.12


---
## Slim 3

使用的 PHP 框架為 [Slim 3](https://www.slimframework.com/docs/v3/)，適合 PHP 5.5 以上
。

---
## PostgreSQL 9.6.24

資料庫是使用 PostgreSQL，並透過 pgAdmin 4 進行建表操作。

---
## Redbean ORM

使用 [Redbean](https://www.redbeanphp.com/index.php) 進行基本 CRUD 及 Transaction 操作，複雜的查詢則搭配 Redbean 使用 SQL 原生語法。

---
## Composer 2.5.4

    slim
    redbean
    autoload

---
## 目錄架構
```    
   + api
    ├─ app      //  主程式目錄
    │   ├─ Controllers   //  邏輯控制 建立 Factory 及存取 Model 並處理訊息
    │   ├─ Entities      //  建立實體 注入資料 驗證格式 轉換資料
    │   ├─ Factories     //  處理資料格式 實際執行 Entity 及 Validator
    │   ├─ Middlewares   //  中介層 
    │   ├─ Models        //  執行 ORM 與 SQL 語法    
    │   ├─ Services       //  處理前端輸入資料（多對多、複雜欄位）
    │   └─ Validators    //  驗證資料完整性
    ├─ core     //  資料庫相關設定
    ├─ libs     //  自定義函式庫
    │   ├─ Exceptions    //  Exception 例外管理
    │   │   ├─ Collection    //  自定義 Exception 實作
    │   │   └─ Interfaces    //  自定義 介面
    │   └─ Responses     //  自定義 Response
    ├─ public   //  index 網址存取目錄    
    └─ vendor   //  composer 套件

```