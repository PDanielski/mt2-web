<?php


namespace App\ItemShop\Wallet\Currency\Gold;


use App\ItemShop\Wallet\Currency\Exception\NotEnoughBalanceException;
use App\ItemShop\Wallet\Currency\CurrencyInterface;
use App\ItemShop\Wallet\Currency\CurrencyWalletInterface;
use App\Metin2Domain\Account\AccountInterface;

class GoldWallet implements CurrencyWalletInterface {

    protected $account;

    public function __construct(AccountInterface $account) {
        $this->account = $account;
    }

    public function getBalance(): int {
        return $this->account->getGold();
    }

    public function withdraw(int $amount): void {
        if($this->getBalance() - $amount < 0)
            throw new NotEnoughBalanceException();

        $this->account->changeGold(-$amount);
    }

    public function deposit(int $amount): void {
        $this->account->changeGold($amount);
    }

    public function getCurrency(): CurrencyInterface {
        return new GoldCurrency();
    }
}