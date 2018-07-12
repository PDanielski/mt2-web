<?php


namespace App\ItemShop\Wallet;


interface WalletOwnerProviderInterface {

    public function getById($id): WalletOwner;

}