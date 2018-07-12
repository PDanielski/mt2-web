<?php


namespace App\ItemShop\Wallet\Metin2Wallet;

use App\ItemShop\Wallet\Currency\Biscuits\BiscuitsWallet;
use App\ItemShop\Wallet\Currency\Gold\GoldWallet;
use App\ItemShop\Wallet\Currency\Warpoints\WarpointsWallet;
use App\ItemShop\Wallet\Wallet;
use App\ItemShop\Wallet\WalletInterface;
use App\ItemShop\Wallet\WalletOwner;
use App\ItemShop\Wallet\WalletProviderInterface;
use App\Metin2Domain\Account\AccountInterface;

class Metin2WalletProvider implements WalletProviderInterface {

    protected $account;

    protected $walletOwner;

    public function __construct(AccountInterface $account, WalletOwner $walletOwner) {
        $this->account = $account;
        $this->walletOwner = $walletOwner;
    }

    public function get(): WalletInterface {
        $wallet = new Wallet($this->walletOwner);
        $wallet->addCurrencyWallet(new GoldWallet($this->account));
        $wallet->addCurrencyWallet(new WarpointsWallet($this->account));
        $wallet->addCurrencyWallet(new BiscuitsWallet($this->account));

        return $wallet;
    }

}