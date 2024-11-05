# laravel api post 實作

### 啟動 ( 路徑為 `localhost:8080/api/orders` )

使用docker建立並啟動環境

``` cmd
docker-compose build
```

``` cmd
docker-compose up -d
```

啟動後即可直接使用網址瀏覽頁面，提供了 `http://localhost:8080/testapi` 的api測試頁面，可使用該頁面測試 `http://localhost:8080/api/orders` 的 post 請求

這是提供的範例 json 資料
``` json
{
    "id": "A0000001",
    "name": "Melody Holiday Inn",
    "address": {
        "city": "taipei-city",
        "district": "da-an-district",
        "street": "fuxing-south-road"
    },
    "price": 2000,
    "currency": "TWD"
}

```

