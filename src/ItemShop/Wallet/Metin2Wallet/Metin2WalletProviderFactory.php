<?php


namespace App\ItemShop\Wallet\Metin2Wallet;


use App\Account\Repository\AccountRepositoryInterface;
use App\Account\Repository\Exception\AccountNotFoundException;
use App\ItemShop\Wallet\Exception\WalletOwnerNotFound;
use App\ItemShop\Wallet\WalletOwner;
use App\ItemShop\Wallet\WalletProviderFactoryInterface;
use App\ItemShop\Wallet\WalletProviderInterface;

class Metin2WalletProviderFactory implements WalletProviderFactoryInterface {

    protected $accountRepository;

    public function __construct(AccountRepositoryInterface $repository) {
        $this->accountRepository = $repository;
    }

    public function create(WalletOwner $owner): WalletProviderInterface {
        try {
            $account = $this->accountRepository->getById($owner->getId());
            return new Metin2WalletProvider($account, $owner);
        } catch (AccountNotFoundException $ex) {
            throw new WalletOwnerNotFound("The owner with id {$owner} was not found", 0, $ex);
        }
    }

}