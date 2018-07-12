<?php


namespace App\ItemShop\Wallet\Currency;


use App\ItemShop\Wallet\Currency\Exception\NotEnoughBalanceException;

interface CurrencyWalletInterface {

    /**
     * @param int $amount
     * @return void
     * @throws NotEnoughBalanceException
     */
    public function withdraw(int $amount): void;

    /**
     * @return int|null
     */
    public function getBalance(): int;

    /**
     * @param int $amount
     * @return void
     */
    public function deposit(int $amount): void;

    /**
     * @return CurrencyInterface
     */
    public function getCurrency(): CurrencyInterface;

}