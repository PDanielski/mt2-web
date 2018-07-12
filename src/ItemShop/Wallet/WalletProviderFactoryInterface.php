<?php


namespace App\ItemShop\Wallet;


use App\ItemShop\Wallet\Exception\WalletOwnerNotFound;

interface WalletProviderFactoryInterface {

    /**
     * @param WalletOwner $owner
     * @return WalletProviderInterface
     * @throws WalletOwnerNotFound
     */
    public function create(WalletOwner $owner): WalletProviderInterface;
    
}