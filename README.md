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

---

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