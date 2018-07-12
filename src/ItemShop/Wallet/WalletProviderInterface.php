<?php


namespace App\ItemShop\Wallet;


interface WalletProviderInterface {

    public function get(): WalletInterface;

}