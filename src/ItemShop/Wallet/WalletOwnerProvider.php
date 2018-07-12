<?php


namespace App\ItemShop\Wallet;


use App\Account\Repository\AccountRepositoryInterface;

class WalletOwnerProvider implements WalletOwnerProviderInterface {

    protected $accountRepository;

    public function __construct(AccountRepositoryInterface $repository) {
        $this->accountRepository = $repository;
    }

    public function getById($id): WalletOwner {
        return new WalletOwner($id);
    }

}