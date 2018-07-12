<?php


namespace App\ItemShop\Wallet\Currency;


use App\ItemShop\Wallet\Currency\Exception\CurrencyNotFoundException;

interface CurrencyRepositoryInterface {

    /**
     * @return CurrencyInterface[]
     */
    public function getAll(): array;

    /**
     * @param string $currencyCode
     * @return CurrencyInterface
     * @throws CurrencyNotFoundException
     */
    public function getByCode(string $currencyCode): CurrencyInterface;

}