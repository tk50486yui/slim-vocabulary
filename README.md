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
    │   ├─ Controllers   //  邏輯控制 主要存取 Model 並回傳
    │   ├─ Models        //  執行 ORM 與 SQL 語法
    │   ├─ Validations   //  驗證輸入資料
    │   └─ Middlewares   //  中介層 
    ├─ core     //  資料庫相關設定
    ├─ libs     //  函式庫
    │   ├─ Customs      //  自定義函式庫
    │   └─ Responses    //  自定義Response訊息
    ├─ public   //  index 網址存取目錄    
    └─ vendor   //  composer 套件

```