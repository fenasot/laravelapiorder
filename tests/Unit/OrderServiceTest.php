<?php

namespace Tests\Unit;

use App\Services\OrderService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class OrderServiceTest extends TestCase
{

    protected OrderService $orderService; // 驗證資料用的 class

    protected function setup(): void
    {
        parent::setup();
        $this->orderService = new OrderService();
    }

    /**
     * 執行並確認結果(僅檢查 status 與 message)
     * 
     * @param array $data
     * @param string $status
     * @param string $message
     */
    private function runAndAssertEquals(array $data, string $status, string $message)
    {
        $result = $this->orderService->checkJson($data);

        $this->assertEquals($status, $result['status']);
        $this->assertEquals($message, $result['message']);
    }

    /**
     * OrderService checkJson() 驗證 json 格式的功能 (成功)  
     * 
     * @see \App\Services\OrderService
     */
    #[Test]
    public function testOrderServiceCheckJsonSuccess()
    {
        $data = [
            'name' => 'Melody Holiday Inn',
            'price' => 1500,
            'currency' => 'TWD'
        ];

        $result = $this->orderService->checkJson($data);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals('訂單檢查通過', $result['message']);
        $this->assertEquals($data, $result['data']);
    }

    /**
     * OrdersService checkJson() 驗證Json資料內容是否正確功能(name 欄位包含非英文字母或空格的字元)
     */
    #[Test]
    public function testOrderServiceCheckJsonNameContainsOnlyEnglishLetters()
    {
        $data = [
            'name' => '我Melody 愛 Ho人liday I人nn', // 內含非英文字母
            'price' => 2000,
            'currency' => 'TWD'
        ];

        $this->runAndAssertEquals($data, 'error', 'Name contains non-English characters');
    }

    /**
     * OrdersService checkJson() 驗證Json資料內容是否正確功能(name 欄位每個單字首字母非大寫)
     */
    #[Test]
    public function testOrderServiceCheckJsonNameIsNotCapitalized()
    {
        $data = [
            'name' => 'Melody holiday Inn', // holidat 開頭非大寫
            'price' => 2000,
            'currency' => 'TWD'
        ];

        $this->runAndAssertEquals($data, 'error', 'Name is not capitalized');
    }

    /**
     * OrdersService checkJson() 驗證Json資料內容是否正確功能(price 欄位金額超過2000)
     */
    #[Test]
    public function testOrderServiceCheckJsonPriceIsOverLimit()
    {
        $data = [
            'name' => 'Melody Holiday Inn',
            'price' => 2100, // 價格超過2000
            'currency' => 'TWD'
        ];

        $this->runAndAssertEquals($data, 'error', 'Price is over 2000');
    }

    /**
     * OrdersService checkJson() 驗證Json資料內容是否正確功能(currency 欄位
     * 貨幣格式不是 TWD 或 USD)
     */
    #[Test]
    public function testOrderServiceCheckJsonCurrencyFormatIsWrong()
    {
        $data = [
            'name' => 'Melody Holiday Inn',
            'price' => 2000,
            'currency' => 'TDD' // 不是 TWD 或 USD
        ];

        $this->runAndAssertEquals($data, 'error', 'Currency format is wrong');
    }


    /**
     * OrderService checkJson() 測試 確認 price USD 為 TWD 價格的功能 
     */
    #[Test]
    public function testOrderServiceCheckJsonPriceFromUsdToTwd()
    {
        $data = [
            'name' => 'Melody Holiday Inn',
            'currency' => 'USD',
            'price' => 20
        ];

        $result = $this->orderService->checkJson($data);

        $this->assertEquals('success', $result['status']);
        $this->assertEquals(20 * OrderService::USD_TO_TWD_RATE, $result['data']['price']);
        $this->assertEquals('TWD', $result['data']['currency']);
    }
}
