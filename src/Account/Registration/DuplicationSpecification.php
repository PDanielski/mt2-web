<?php


namespace App\Account\Registration;

use App\Account\Repository\AccountRepositoryInterface;
use App\Account\Repository\Exception\AccountNotFoundException;
use App\Account\Request\CreateAccountRequest;

class DuplicationSpecification {

    protected $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository) {
        $this->accountRepository = $accountRepository;
    }

    public function isSatisfiedBy(CreateAccountRequest $request): bool {
        try {
            $this->accountRepository->getByLogin($request->getLogin());
            return false;
        } catch (AccountNotFoundException $accountNotFoundException) {
            return true;
        }
    }
}