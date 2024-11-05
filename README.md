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

該 API 將提供以下功能

* 驗證所有欄位格式是否正常。
* 驗證是否有缺少任一欄位。
* 驗證 name 欄位是否每個單字開頭為大寫英文字母，以及是否全部都是由英文字母組成。
* 驗證 price 欄位數字不大於 2000 (包含 USD 轉換為 TWD 時的數字)。
* 驗證 currency 欄位是否為 TWD 或 USD。
* 若 currency 為 USD， API 會將 price 依固定比例轉換為 TWD，currency 欄位也將被改回 TWD，然後以 json 格式回傳修改後的資料。
* 若驗證失敗，將回傳 400 Https 狀態碼，並包含錯誤訊息。
* 若驗證成功，將回傳 200 Https 狀態碼，並包含處理過後的資料。
* 若發生其他錯誤，將回傳 500 Https 狀態碼。
