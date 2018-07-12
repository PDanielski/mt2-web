<?php

namespace App\Metin2Domain\Wallet;

use App\Metin2Domain\Wallet\Exception\CurrencyNotRegisteredException;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase {

    /** @throws */
    public function test__construct() {
        $ownerId = 1;
        $currencies = ['gold'=>100, 'silver'=>150];
        $wallet = new Wallet($ownerId, $currencies);

        $this->assertEquals($ownerId, $wallet->getOwnerId());
        $this->assertEquals(100, $wallet->getCurrencyBalance('gold'));
        $this->assertEquals(150, $wallet->getCurrencyBalance('silver'));
    }

    /** @throws */
    public function testRegisterCurrency() {
        $wallet = new Wallet(1);
        $wallet->registerCurrency('biscuits');
        $this->assertEquals(0, $wallet->getCurrencyBalance('biscuits'));
    }

    /** @throws */
    public function testSupportsCurrency() {
        $wallet = new Wallet(1, ['bananas'=>0]);
        $this->assertTrue($wallet->supportsCurrency('bananas'));
        $this->assertNotTrue($wallet->supportsCurrency('kiwis'));
    }

    /** @throws */
    public function testChangeCurrencyBalance() {
        $wallet = new Wallet(1, ['bananas'=>43]);
        $wallet->changeCurrencyBalance('bananas',100);
        $this->assertEquals(143, $wallet->getCurrencyBalance('bananas'));
    }

    /** @throws */
    public function testChangeCurrencyBalanceNegative(){
        $wallet = new Wallet(1, ['money'=>12]);
        $wallet->changeCurrencyBalance('money', -50);
        $this->assertEquals(-38, $wallet->getCurrencyBalance('money'));
    }

    /** @throws */
    public function testChangeCurrencyFailure(){
        $wallet = new Wallet(1, ['beans'=>12]);
        $this->expectException(CurrencyNotRegisteredException::class);
        $wallet->changeCurrencyBalance('unknown', 50);
    }
    /** @throws */
    public function testGetCurrencyBalanceFailure() {
        $wallet = new Wallet(1, ['beans'=>12]);
        $this->expectException(CurrencyNotRegisteredException::class);
        $wallet->getCurrencyBalance('unknownCurrency');
    }

}
