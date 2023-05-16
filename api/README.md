# SlimProject - api

**Composer**
```
composer install
```

**Autoload**

添加新的目錄要在 composer.json 的 autoload 同步新增並執行

```
composer dump-autoload
```

---
**Namespace**

使用 Namespace 檔案名稱要與 Class 一致

----

**Middleware**

Slim 的 Middleware 是以主應用程式為中心按照加入順序層層包住的，有提供主應用程式執行前及執行後的中介層，所以最晚加入的 Middleware 一開始會被最先執行，主應用程式結束後該 Middleware 則會是最晚執行的。