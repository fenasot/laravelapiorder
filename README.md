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

### 

### 設計風格

* 使用了 TDD 的方式來開發API功能。
* 使用了 OOAD 中的 SOLID、OOP、KISS、YAGNI、DRY  原則。
* SOILD 的部分使用了
    * SRP: 將業務邏輯與功能邏輯分開撰寫，Controller負責驗證Json資料完整性，以及https的狀態碼回傳，Service負責驗證資料內容的正確性，以及回傳驗證結果。
    * OCP: 使用了 Interface ，讓 OrderService 在之後需要擴充的情況下可不更改原有的程式碼。
    * DIP: 使用了依賴注入的方式注入了 OrderService。

* KISS 原則: 在撰寫Api時，若不需要太複雜的邏輯，就盡量的使用較簡單的方式設計，不過度的追求完美的設計法則，導致降低程式碼的可讀性，以及過多開發成本。
* YAGNI 原則: 不考慮未來不確定的需求，而實作目前不需要的功能，但保留了未來需要時可快速擴充的可能性。
* DRY 原則: 重複的部分若條件允許，我一定會包成function，以便後續的維護與提高可讀性
* Guard Code: 將嵌套邏輯全都優化，讓邏輯較複雜的判斷語句不會有多重嵌套，降低可讀性
