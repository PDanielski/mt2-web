<?php


namespace App\ItemShop\Wallet\Currency\Warpoints;


use App\ItemShop\Wallet\Currency\CurrencyInterface;
use App\ItemShop\Wallet\Currency\CurrencyWalletInterface;
use App\ItemShop\Wallet\Currency\Exception\NotEnoughBalanceException;
use App\Metin2Domain\Account\AccountInterface;

class WarpointsWallet implements CurrencyWalletInterface {

    protected $account;

    public function __construct(AccountInterface $account) {
        $this->account = $account;
    }

    public function getBalance(): int {
        return $this->account->getWarpoints();
    }

    public function withdraw(int $amount): void {
        if($this->getBalance() - $amount < 0)
            throw new NotEnoughBalanceException();

        $this->account->changeWarpoints(-$amount);
    }

    public function deposit(int $amount): void {
        $this->account->changeWarpoints($amount);
    }

    public function getCurrency(): CurrencyInterface {
        return new WarpointsCurrency();
    }

}