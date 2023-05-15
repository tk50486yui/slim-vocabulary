# SlimProject

使用 PHP Slim 3 + Redbean ORM 來建立後端 API

搭配前端：[VuePoject](https://github.com/tk50486yui/VueProject.git)

---
## PHP 7.2.12


---
## Slim 3


---
## PostgreSQL 9.6.24

資料庫是PostgreSQL，並使用 pgAdmin 4 進行操作

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
    │   ├─ Factories     //  實際執行 Entity 及 Validator
    │   ├─ Middlewares   //  中介層 
    │   ├─ Models        //  執行 ORM 與 SQL 語法    
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