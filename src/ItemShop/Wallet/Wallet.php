<?php


namespace App\ItemShop\Wallet;

use App\ItemShop\Wallet\Currency\CurrencyInterface;
use App\ItemShop\Wallet\Currency\CurrencyWalletInterface;
use App\ItemShop\Wallet\Currency\Exception\CurrencyWalletNotFoundException;

class Wallet implements WalletInterface {

    protected $owner;

    protected $currencies;

    protected $currencyWallets;

    public function __construct(WalletOwner $walletOwner) {
        $this->owner = $walletOwner;
    }

    public function getOwner(): WalletOwner {
        return $this->owner;
    }

    public function addCurrencyWallet(CurrencyWalletInterface $currencyWallet): void {
        $this->currencies[$currencyWallet->getCurrency()->getCode()] = $currencyWallet->getCurrency();
        $this->currencyWallets[$currencyWallet->getCurrency()->getCode()] = $currencyWallet;
    }

    public function getCurrencyWallet(CurrencyInterface $currency): CurrencyWalletInterface {
        if(isset($this->currencyWallets[$currency->getCode()]))
            return $this->currencyWallets[$currency->getCode()];
        throw new CurrencyWalletNotFoundException();
    }

    public function getSupportedCurrencies(): array {
        return $this->currencies;
    }

    public function supportsCurrency(CurrencyInterface $currency): bool {
        return isset($this->currencies[$currency->getCode()]);
    }

}