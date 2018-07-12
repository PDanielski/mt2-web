<?php

namespace App\ItemShop\Wallet;


use App\ItemShop\Wallet\Currency\CurrencyInterface;
use App\ItemShop\Wallet\Currency\CurrencyWalletInterface;
use App\ItemShop\Wallet\Currency\Exception\CurrencyWalletNotFoundException;

interface WalletInterface {

    /**
     * @param CurrencyWalletInterface $currencyWallet
     * @return void
     */
    public function addCurrencyWallet(CurrencyWalletInterface $currencyWallet): void;

    /**
     * @param CurrencyInterface $currency
     * @return CurrencyWalletInterface
     * @throws CurrencyWalletNotFoundException
     */
    public function getCurrencyWallet(CurrencyInterface $currency): CurrencyWalletInterface;

    /**
     * @return CurrencyInterface[]
     */
    public function getSupportedCurrencies(): array;

    /**
     * @return WalletOwner
     */
    public function getOwner(): WalletOwner;

    /**
     * @param CurrencyInterface $currency
     * @return bool
     */
    public function supportsCurrency(CurrencyInterface $currency): bool;

}